<?php

namespace AziziSearchEngineStarter\Http\Controllers;

use AziziSearchEngineStarter\SimpleAds;
use Illuminate\Http\Request;
use AziziSearchEngineStarter\Advertisements;
use AziziSearchEngineStarter\AdTargets;
use AziziSearchEngineStarter\AdsCompain;
use AziziSearchEngineStarter\Payments;
use Carbon\Carbon;

use Stripe\Stripe;
use Stripe\Customer;

use Input, Location, GeoIP, BrowserDetect, Validator, File, DB;

class AdsController extends Controller
{
	
    protected $IPaddress = '';
	
	public function payments(){
		$user = auth()->user();
		$payments = $user->payments()->orderBy('created_at', 'desc')->paginate(10);
		$total = $user->ads()->whereYear('created_at', '=', Carbon::now()->year)->whereMonth('created_at', '=', Carbon::now()->month)->sum('paid');
		$billing = $user->billing;
		
		$stripe_secret_key = config('stripe.private');
		Stripe::setApiKey($stripe_secret_key);
		try{
			$customer = Customer::retrieve($user->bill_id);
			$sources = $customer->sources->all(['object' => 'card']);
			$sources = $sources->data;
		}catch(\Exception $e){
			$customer = null;
			$sources = null;
		}
		
		// dd($sources);
		// dd($customer->sources->all(array('limit'=>3, 'object' => 'card')));
		
		$data = [
			'user' 	   		=> $user,
			'payments' 	    => $payments,
			'totalUsage' 	=> $total,
			'billing' 		=> $billing,
			'customer' 		=> $customer,
			'sources' 		=> $sources,
		];
		$data = array_merge($data, $this->commonData());
        return view('auth.ads.payments', $data);
	}
	
	public function compains(){
		$user = auth()->user();
		$compains = $user->compains()->orderBy('created_at', 'desc')->paginate(10);
		
		$data = [
			'user' 	   		=> $user,
			'compains' 	    => $compains,
		];
		$data = array_merge($data, $this->commonData());
        return view('auth.ads.compains', $data);
	}
	
	public function manageCompainAds($id){
		$user = auth()->user();
		$compain = $user->compains()->where('id', $id)->first();
		if(!$compain) abort(404);
		$ads = $compain->ads()->paginate(10);
		
		$data = [
			'user' 	  	 	=> $user,
			'compain' 	   	=> $compain,
			'ads' 	   		=> $ads,
		];
		$data = array_merge($data, $this->commonData());
        return view('auth.ads.ads', $data);
	}
	
	public function compainAdPay($compain, $ad){
		$user = auth()->user();
		$compainObj = $user->compains()->where('id', $compain)->first();
		if(!$compainObj) abort(404);
		$adObj = $compainObj->ads()->where('id', $ad)->whereApproved(2)->first();
		if(!$adObj) abort(404);
		
		if($user->credit < $adObj->budget){
			$this->sessionMessage('Insufficient funds in your account', 'error');
			return redirect()->route('ads.payments');
		}
		
		$user->credit = $user->credit - $adObj->budget;
		$adObj->approved = 1;
		if($this->settings['approveAds']){
			$adObj->approved = 0;
		}
		
		$payment = Payments::whereAdsId($adObj->id)->first();
		if(!$payment){
			$payment = new Payments;
			$payment->user_id = $user->id;
			$payment->ads_id = $adObj->id;
		}
		$payment->total = - ($adObj->budget);
		
		if(!$user->save() || !$adObj->save() || !$payment->save()){
			$this->sessionMessage('error occured, please try again!', 'error');
			return redirect()->route('ads.compains.ads', ['id' => $compain]);
		}
		
		$this->sessionMessage('Payment done!', 'success');
		return redirect()->route('ads.compains.ads', ['id' => $compain]);
	}
	
	
	// with ajax toggel active
	public function postToggelAd(){
		$id = Input::get('compainId');
		$adId = Input::get('id');
		$user = auth()->user();
		$compain = $user->compains()->where('id', $id)->first();
		if(!$compain) return response('error occured, please try again', 500);
		$ad = $compain->ads()->where('id', $adId)->first();
		if(!$ad) return response('error occured, please try again', 500);
		
		if($ad->type != 2){
			if((($ad->paid + $ad->costPer) > $ad->budget) && ($ad->budget != 0)){
				return response('you have insufficient budget.', 500);
			}
		}else{
			$now = Carbon::now();
			$ends = Carbon::parse($ad->target->end);
			if($now->gt($ends)){
				$ad->turnOff();
				return response('ad period completed.', 500);
			}
		}
		
		// change statu
		if($ad->turn){
			$ad->turnOff();
		}else{
			$ad->turnOn();
		}
		return response('Ad unit '.$ad->name.' statu changed.', 200);
	}
	
	// with ajax editable
	public function postManageCompainAds($id, $adId){
		$user = auth()->user();
		$compain = $user->compains()->where('id', $id)->first();
		if(!$compain) return response('error occured, please try again!', 500);
		$ad = $compain->ads()->where('id', $adId)->first();
		if(!$ad) return response('error occured, please try again!', 500);
		
		if($ad->type == 2) return response('budget of ad unit that are paid per day not change able.', 500);
		
		if(Input::has('budget')){
			$budget = Input::get('budget');
			if(!is_numeric($budget)) return response('please enter a valid budget!', 500);
		
			if($ad->approved == 2) {
				$ad->update(['budget' => $budget]);
				return response('great!', 200);
			}
			$currentBudget = $ad->budget;
			$availableCredit = $user->credit + $currentBudget;
			$spent = $ad->paid;
			
			if($budget > $availableCredit) return response('you have insufficient credit.', 511);
			
			if($spent > $budget) return response('you have to enter a budget more than what you spent in this ad unit.', 500);
			
			$newCredit = $availableCredit - $budget;
			$user->update(['credit' => $newCredit]);
			$ad->update(['budget' => $budget]);
			return response('great!', 200);
		}
		
		return response('error occured, please try again!', 500);
	}
	
	public function postCreateCompain(Request $request){
		$user = auth()->user();
		$compain = new AdsCompain;
		
		if(!Input::has('compainName')){
			if($request->ajax()){
				return response('please set compain name!', 500);
			}
			$this->sessionMessage('please set compain name!', 'error');
			return redirect()->route('ads.compains');
		}
		$compain->name = Input::get('compainName');
		
		if(!$user->compains()->save($compain)){
			if($request->ajax()){
				return response('error occured, please try again!', 500);
			}
			$this->sessionMessage('error occured, please try again!', 'error');
			return redirect()->route('ads.compains');
		}
		if($request->ajax()){
			return response($compain, 200);
		}
		$this->sessionMessage('compain created', 'success');
		return redirect()->route('ads.compains');
	}
	
	public function adEdit($compainId, $slug){
		$user = auth()->user();
		$compain = $user->compains()->where('id', $compainId)->first();
		if(!$compain) abort(404);
		$ad = $compain->ads->where('slug', $slug)->first();
		if(!$ad) abort(404);
		
		$data = [
			'user' 	   		=> $user,
			'ad' 	   		=> $ad,
			'compain' 	    => $compain,
		];
		$data = array_merge($data, $this->commonData());
        return view('auth.ads.edit', $data);
	}
	
	public function postAdEdit($compainId, $slug){
		$user = auth()->user();
		$compain = $user->compains()->where('id', $compainId)->first();
		if(!$compain) abort(404);
		$ad = $compain->ads->where('slug', $slug)->first();
		if(!$ad) abort(404);
		
		$input = Input::only('adUnitName', 'adTitle', 'adDescription', 'adVurl', 'adKeywords', 'adURL');
		
		$validator = Validator::make($input, [
            'adUnitName' => 'max:25',
            'adTitle' => 'required|max:25',
            'adDescription' => 'required|max:255',
            'adVurl' => 'required|max:64',
            'adKeywords' => 'required|max:64',
            'adURL' => 'required|max:255',
        ]);
		
		if ($validator->fails()) {
            return redirect()->route('ads.compains.ad.edit', ['compainID' => $compainId, 'slug' => $slug])->withErrors($validator)->withInput();
        }
		
		$name = str_replace(' ', '_', $input['adUnitName']);
		$ad->name = $name;
		$ad->title = $input['adTitle'];
		$ad->description = $input['adDescription'];
		$ad->Vurl = $input['adVurl'];
		$ad->keywords = $input['adKeywords'];
		$ad->url = $input['adURL'];
		
		if(!$ad->save()){
			$this->sessionMessage('general.error_occured', 'error');
			return redirect()->route('ads.compains.ad.edit',['compainID' => $compainId, 'slug' => $slug]);
		}
		
		$this->sessionMessage('ad edited', 'success');
		return redirect()->route('ads.compains.ad.edit',['compainID' => $compainId, 'slug' => $slug]);
		return redirect()->route('ads.compains.ads', ['id' => $compainId]);
		// dd(Input::all());
	}
	
	public function createNewAdd(){
		$user = auth()->user();
		$compains = $user->compains;
		$compain = (int) Input::get('compain', 0);
		$costFactors = DB::table('ads_primery_keywords')->whereField(1)->get();
		
		$data = [
			'user' 	   		=> $user,
			'compain' 	   	=> $compain,
			'compains' 	    => $compains,
			'costFactors' 	=> $costFactors,
		];
		$data = array_merge($data, $this->commonData());
		return view('auth.ads.create', $data);
	}
	
	public function postCreateNewAdd(){
		$user = auth()->user();
		$compain = $user->compains()->where('id', Input::get('compain'))->first();
		if(!$compain){
			$this->sessionMessage('please select a compain.', 'error');
			return redirect()->route('ads.new');
		}
		
		$input = Input::only(
			'chargeType', 
			'compain', 
			'adUnitName',
			'adTitle',
			'adDescription', 
			'adVurl',
			'adKeywords',
			'adURL',
			'show_in',
			'ageFrom',
			'ageTo',
			'gender',
			'languages',
			'interests',
			'geoTurn',
			'continentTurn',
			'continents',
			'countriesTurn1',
			'inc_countries',
			'countriesTurn2',
			'exc_countries',
			'scheduleTurn',
			'startDate',
			'startTime',
			'endDate',
			'endTime',
			'budgetTurn',
			'budget'
		);

        if(!Input::has('budget')){
            $input['budget'] = 5;
        }
		
		$validator = Validator::make($input, [
            'chargeType' => 'required|in:0,1,2',
            'adUnitName' => 'max:25',
            'compain' => 'required|exists:ads_compains,id',
            'adTitle' => 'required|max:25',
            'adDescription' => 'required|max:150',
            'adVurl' => 'required|max:35',
            'adKeywords' => 'required',
            'adURL' => 'required|max:255',
            'show_in' => 'required|array',
            'ageFrom' => 'integer|nullable',
            'ageTo' => 'integer|nullable',
            'gender' => 'in:0,1,2|nullable',
            'languages' => 'string|nullable',
            'interests' => 'string|nullable',
            'geoTurn' => 'nullable',
            'continentTurn' => 'nullable',
            'continents' => 'string|nullable|required_if:continentTurn,1',
			'countriesTurn1' => 'nullable',
            'inc_countries' => 'string|nullable|required_if:countriesTurn1,1',
			'countriesTurn2' => 'nullable',
            'exc_countries' => 'string|nullable|required_if:countriesTurn2,1',
			'scheduleTurn' => 'required|boolean',
			'startDate' => 'date_format:d-m-Y|nullable|required_if:scheduleTurn,1|after:today',
			'startTime' => 'date_format:H:i|nullable|required_if:scheduleTurn,1|after:today',
			'endDate' => 'date_format:d-m-Y|string|nullable|required_if:scheduleTurn,1|after:startDate',
			'endTime' => 'date_format:H:i|string|nullable|required_if:scheduleTurn,1',
			'budgetTurn' => 'required|boolean',
			'budget' => 'numeric|min:'.$this->settings['budgetMin'].'|required_if:chargeType,0|required_if:chargeType,1',
        ]);
		
		
		if ($validator->fails()) {
            return redirect()->route('ads.new')->withErrors($validator)->withInput();
        }
		
		$settings = $this->settings;
		$data = $validator->getData();
		
		// calculate the cost with provided $data
		if($data['chargeType'] == 0){
			$costPer = $settings['initialCost0'];
		}else if($data['chargeType'] == 1){
			$costPer = $settings['initialCost1'];
		}else if($data['chargeType'] == 2){
			$costPer = $settings['initialCost2'];
		}
		
		$InitialCost = $costPer;
		$primeryKeywords = DB::table('ads_primery_keywords')->get();
		if(!$primeryKeywords->isEmpty()){
			foreach($primeryKeywords as $primeryKeyword){
				if(!$primeryKeyword->operation){
					if(stripos($data['adKeywords'], $primeryKeyword->keyword) !== false
					|| stripos($data['adTitle'], $primeryKeyword->keyword) !== false
					|| stripos($data['adVurl'], $primeryKeyword->keyword) !== false
					|| stripos($data['adURL'], $primeryKeyword->keyword) !== false
					|| stripos($data['adDescription'], $primeryKeyword->keyword) !== false){
						$costPer += $InitialCost * ($primeryKeyword->leverage / 100);
					}
				}
				if($primeryKeyword->operation){
					if($data[$primeryKeyword->keyword] != ''){
						$costPer += $this->calcMathLeverage($costPer, $primeryKeyword->leverage, $primeryKeyword->operation);
					}
				}elseif($primeryKeyword->advancedOperation){
					if($data[$primeryKeyword->keyword] != ''){
						$costPer += $this->calcMathLeverage($costPer, $primeryKeyword->leverage, '', true, $primeryKeyword->advancedOperation);
					}
				}
			}
		}
		$costPer = round($costPer, $settings['costPerDecimals']);
		// create the ad
		$ad = new Advertisements;
		$adTarget = new AdTargets;
		
		// type
		$ad->type = $data['chargeType'];
		
		// name
		$name = str_replace(' ', '_', $data['adUnitName']);
		$ad->name = $name;
		
		// compain
		$ad->compain_id = $data['compain'];
		
		// ad contents
		$ad->title = $data['adTitle'];
		$ad->description = $data['adDescription'];
		$ad->Vurl = $data['adVurl'];
		$ad->keywords = $data['adKeywords'];
		$ad->url = $data['adURL'];
		
		// show in
		$show_in_arr = $data['show_in'];
		foreach($show_in_arr as $show_inV){
			if ((array_search('0', $show_in_arr)) !== false) {
				$showInValue = 0;
				break;
			}else{
				$showInValue = implode(',', $show_in_arr);
			}
		}
		$show_in = $showInValue;
		
		// ad targets --------------------
		// age
		$adTarget->age = '0,0';
		if($data['ageFrom'] || $data['ageTo']){
			$ageFrom = (int) $data['ageFrom'];
			$ageTo = (int) $data['ageTo'];
			$adTarget->age = $ageFrom . ',' . $ageTo;
		}
		
		// gender
		$adTarget->gender = 0;
		if($data['gender']) 
			$adTarget->gender = $data['gender'];
		
		// languages & interests
		$adTarget->language = 0;
		if($data['languages']) 
			$adTarget->language = $data['languages'];
		$adTarget->interests = 0;
		if($data['interests'])
			$adTarget->interests = $data['interests'];
		
		// geo options
		$adTarget->continent = 0;
		$adTarget->inc_countries = 0;
		$adTarget->exc_countries = 0;
		if($data['geoTurn']){
			if($data['continentTurn']){
				$adTarget->continent = $data['continents'];
			}
			if($data['countriesTurn1']){
				$adTarget->inc_countries = $data['inc_countries'];
			}
			if($data['countriesTurn2']){
				$adTarget->exc_countries = $data['exc_countries'];
			}
		}
		
		// schedule
		if($data['scheduleTurn']){
			$adTarget->start = Carbon::parse($data['startDate'] .' '. $data['startTime'])->toDateTimeString();
			$adTarget->end = Carbon::parse($data['endDate'] .' '. $data['endTime'])->toDateTimeString();
		}
		
		// budget 
		$ad->useBudget = 0;
		$ad->budget = 0;
		if($data['chargeType'] == 2){
			$ad->useBudget = 1;
			$ad->budget = $costPer * $this->getDiffDays($adTarget->start, $adTarget->end, $settings['costPerDecimals']);
		}else{
			if($data['budgetTurn']){
				$ad->useBudget = 1;
				$ad->budget = $data['budget'];
			}
		}
		
		// defualt
		$ad->slug = str_random(64);
		$ad->paid = 0;
		$ad->clicks = 0;
		$ad->impressions = 0;
		$ad->costPer = $costPer;
		$ad->user_id = $user->id;
		$ad->turn = 0;
		
		$payment = new Payments;
		$payment->user_id = $user->id;
		$payment->total = 0;
		
		if($user->credit > $ad->budget){
			$user->credit = $user->credit - $ad->budget;
			if($settings['approveAds']){
				$ad->approved = 0;
			}else{
				$ad->approved = 1;
			}
			$payment->total = -($ad->budget);
		}else{
			$ad->approved = 2;
		}
		
		if(!$ad->save() || !$user->save()){
			$this->sessionMessage('general.error_occured', 'error');
			return redirect()->route('ads.new')->withInput();
		}
		
		$adTarget->ad_id = $ad->id;
		if(!$adTarget->save()){
			$this->sessionMessage('general.error_occured', 'error');
			return redirect()->route('ads.new')->withInput();
		}
		
		$payment->ads_id = $ad->id;
		if(!$payment->save()){
			$this->sessionMessage('general.error_occured', 'error');
			return redirect()->route('ads.new')->withInput();
		}
		
		$this->sessionMessage('general.ad_created', 'success');
		return redirect()->route('ads.compains');
	}
	
	public function ajax(){
		
		$this->settings = $this->getSettings();
		if(!$this->settings['advertisements']) return [];
		$take = $this->settings['takeFromAdvertisements'];
		$query = Input::get('q');
		$type = Input::get('t');
		$adsShowedCacheSlugeIDs = 'ads_showed_IDs_for_query_'.$query;
		$ads = $this->getAdsCached($query, $type);
		
		if(cache($adsShowedCacheSlugeIDs)){
			$adsIDs = cache($adsShowedCacheSlugeIDs);
			cache()->forget($adsShowedCacheSlugeIDs);
		}else{
			if(!$ads) return [];
			$adsIDs = $this->getAdsIDs($ads);
		}
		
		$returnedAdsIDs = array_slice($adsIDs, 0, $take);
		$unReturnedAdsIDs = array_slice($adsIDs, $take);
		if(!empty($unReturnedAdsIDs)){
			cache()->forever($adsShowedCacheSlugeIDs, $unReturnedAdsIDs);
		}
		return $this->adsByIDs($ads, $returnedAdsIDs);
	}

	public function ajaxSimple(){

		$this->settings = $this->getSettings();
		if(!$this->settings['advertisements']) return [];
		$take = $this->settings['takeFromAdvertisements'];
		$query = Input::get('q');
        $ads = SimpleAds::search($query, 2)->where('turn', 1)->limit($take)->get();
//        if(!$ads) return response('No Ads found for this query.', 404);
        return $ads;

	}
	
	public function jumpToAdLink(){
		$slug = Input::get('s');
		$ad = Advertisements::where('slug', $slug)->where('turn', 1)->where('approved', 1)->first();
		if(!$ad) return abort(404);
		$ad->oneClick();
		return redirect()->away($this->addHttp($ad->url));
	}
	
	protected function getAdsIDs($ads){
		$IDs = [];
		foreach($ads as $ad){
			$IDs[] = $ad->id;
		}
		return $IDs;
	}
	
	protected function adsByIDs($ads, $IDs){
		$returnedAds = [];
		$i = 0;
		foreach($ads as $key => $ad){
			if(in_array($ad->id, $IDs)){
				if($ad->turnOffUnSufficientFunds()){
					unset($ads[$key]);
				}else{
					$ad->oneImpression();
					$ad->oneDay();
					$returnedAds[$i] = $ad;
					$returnedAds[$i]['click'] = $ad->getURL();
				}
			}
			$i++;
		}
		return $returnedAds;
	}
	
	protected function getAdsCached($query, $type){
//		 $cacheSlug = 'ads_'.$query.'_type_'.$type.'_ip_address_'.$this->IPaddress;
//		 if($this->settings['cache']){
//			 if(cache()->has($cacheSlug)){
//				 $ads = cache()->get($cacheSlug);
//			 }else{
//				 $ads = $this->getAdsFromDatabase($query, $type);
//				 cache()->forever($cacheSlug, $ads);
//			 }
//		 }else{
			$ads = $this->getAdsFromDatabase($query, $type);
//		 }
		return $ads;
	}
	
	protected function getAdsFromDatabase($query, $type){
		
		$minWordLength = 2;
		$ads = Advertisements::search($query, $minWordLength)->where('turn', 1)->where('approved', 1)->get();
		if(!$ads) return response('No Ads found for this query.', 404);
		
		$geo = GeoIP::getLocation();
		// $detect = BrowserDetect::detect();
		// $browserFamily = $detect->browserFamily;
		// dd($geo);
		
		/* targets treats -------- */
		foreach($ads as $key => $ad){
			// if deosn't have unset this ad
			if(!$ad->target) continue;

			// shown in just some types
			if($ad->target->show_in){
				$shown_in = explode(',', $ad->target->show_in);
				if(!in_array($type, $shown_in))
					unset($ads[$key]);
			}

			// continent target
			if($ad->target->continent){
				if($ad->target->continent == $geo->continent)
					continue;
			}

			// inc_countries target
			if($ad->target->inc_countries){
				$inc_countries = explode(',', $ad->target->inc_countries);
				if(!in_array($geo->iso_code, $inc_countries))
					continue;
			}

			// exc_countries target
			if($ad->target->exc_countries){
				$exc_countries = explode(',', $ad->target->exc_countries);
				if(in_array($geo->iso_code, $exc_countries))
					unset($ads[$key]);
			}

//			if($this->settings['adTargetStrict']){

				// Interests

				// gender

				// age

				// language
//			}
		}
		
		return $ads;
	}
	
	public function getData($name){
		$data = json_decode(\File::get(storage_path('app/data/data.json')), true);
		if($name == 'countries'){
			$arr = [];
			foreach($data['countries'] as $countryCode => $country){
				$arr[] = [
					'text' => $country['name'],
					'value' => $countryCode,
				];
			}
			return $arr;
		}
		
		if($name == 'continents'){
			$arr = [];
			foreach($data['continents'] as $continentCode => $continent){
				$arr[] = [
					'text' => $continent,
					'value' => $continentCode,
				];
			}
			return $arr;
		}
		
		if($name == 'languages'){
			$arr = [];
			foreach($data['languages'] as $languageCode => $language){
				if(isset($language['name'])){	
					$arr[] = [
						'text' => $language['name'],
						'value' => $languageCode,
					];
				}
			}
			return $arr;
		}
		
		if($name == 'primeryKeywords'){
			$costFactors = DB::table('ads_primery_keywords')->select('keyword', 'leverage')->whereField(0)->get();
			return $costFactors;
		}
		
		return response('no data.', 404);
	}
	
	public function getDiffDays($start, $end, $decimals){
		$startDate = strtotime($start); // or your date as well
		$endDate = strtotime($end);
		$datediff = $endDate - $startDate;
		// dd(round($datediff / (60 * 60 * 24), $decimals));
		return round($datediff / (60 * 60 * 24), $decimals);
	}
	
	private function calcMathLeverage($cost = 0, $leverage = 0, $operation = "+", $advanced = false, $advancedOperation = ''){
		if($advanced){
			$newAdvancedOperation = str_replace(['cost', 'leverage'], [$cost, $leverage], $advancedOperation);
			return eval("return " . $newAdvancedOperation . ";");
		}
		if($operation == '/' && $second == 0) return 'NaN'; 
		return eval('return '.$cost.' '.$operation.' ('.$leverage.' / 100);');
	}
}
