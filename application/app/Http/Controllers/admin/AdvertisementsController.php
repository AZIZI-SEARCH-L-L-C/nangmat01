<?php

namespace AziziSearchEngineStarter\Http\Controllers\admin;

use AziziSearchEngineStarter\AdTargets;
use AziziSearchEngineStarter\Http\Controllers\admin\Controller;
use AziziSearchEngineStarter\Advertisements;
use AziziSearchEngineStarter\AdsCompain;
use AziziSearchEngineStarter\Payments;
use AziziSearchEngineStarter\Settings;
use AziziSearchEngineStarter\SimpleAds;
use AziziSearchEngineStarter\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Input, Session, Cache, Validator;

class AdvertisementsController extends Controller
{

    public function getSimpleAds(){
        $ads = SimpleAds::paginate(10);
        $data1 = $this->CommonData();

        // $costFactors = DB::table('ads_primery_keywords')->select('keyword', 'leverage')->whereField(0)->get();

        $data2 = [
            'ads' 	  	   => $ads,
        ];

        $data = array_merge($data1, $data2);
        return view('admin.ads.simple', $data);
    }

    public function postSimpleAds(){
        $input = Input::all();
        $errors = false;

        if(Input::has('submitEditAd')){
            $adver = SimpleAds::where('id', $input['adId'])->first();

            if(!$adver){
                $errors = true;
                Session::flash('messageType', 'error');
                Session::flash('message', 'There was an error during search for advertisement id, please verify that you don\'t do any thing that is illegal.');
            }

            if(!$errors){
                $adver->email = $input['ownerEmail'];
                $adver->title = $input['adTitle'];
                $adver->url = $input['adURL'];
                $adver->Vurl = $input['adVURL'];
                $adver->description = $input['adDescription'];
                $adver->keywords = $input['adKeywords'];
                $adver->turn = (int) boolval(Input::get('adStatu'));

                $adver->save();
            }
        }

        if(Input::has('submitNew')){

            $adver = new SimpleAds();
            $adver->email = $input['ownerEmail'];
            $adver->title = $input['adTitle'];
            $adver->url = $input['adURL'];
            $adver->Vurl = $input['adVURL'];
            $adver->description = $input['adDescription'];
            $adver->keywords = $input['adKeywords'];
            $adver->turn = (int) boolval(Input::get('adStatu'));

            $adver->save();
        }

        if(Input::has('submitDelete')){
            $adver = SimpleAds::where('id', $input['adId'])->first();

            if(!$adver){
                $errors = true;
                Session::flash('messageType', 'error');
                Session::flash('message', 'There was an error during search for advertisement id, please verify that you don\'t do any thing that is illegal.');
            }

            if(!$errors){
                $adver->delete();
            }

        }

        if(Input::has('submitSettings')){
            $this->set('takeFromAdvertisements', (int) $input['numberAds']);
            $this->set('advertisements', (int) boolval(Input::get('adsStatu')));
        }

        if(!$errors){
            Session::flash('messageType', 'success');
            Session::flash('message', 'All changes have been made.');
        }

        Cache::flush();
        return redirect()->action('admin\AdvertisementsController@getSimpleAds');
    }

    public function removeSimpleAds($id){
        $errors = false;
        $adver = SimpleAds::where('id', $id)->first();

        if(!$adver){
            $errors = true;
            Session::flash('messageType', 'error');
            Session::flash('message', 'There was an error during search for advertisement id, please verify that you don\'t do any thing that is illegal.');
        }

        if(!$errors){
            $adver->delete();
            Session::flash('messageType', 'success');
            Session::flash('message', 'Ad removed.');
        }

        Cache::flush();
        return redirect()->action('admin\AdvertisementsController@getSimpleAds');
    }

	public function getCompains(){
		$data1 = $this->CommonData();
		$data2 = [
		    'compains' 		=> AdsCompain::paginate(10),
		];
		
		$data = array_merge($data1, $data2);
		return view('admin.ads.compains', $data);
	}

	public function getPrimaryKeywords(){
		$data1 = $this->CommonData();
		$data2 = [
		    'keywords' 		=> DB::table('ads_primery_keywords')->whereField(0)->select('id', 'keyword', 'leverage')->paginate(10),
		];

		$data = array_merge($data1, $data2);
		return view('admin.ads.primarykeywords', $data);
	}

	public function postPrimaryKeywords(){
        if(Input::has('submitNewPrimary')){
            $keyword = DB::table('ads_primery_keywords')->whereField(0)->where('keyword', Input::get('keyword'))->first();
            if($keyword){
                $this->sessionMessagePlain('The keyword already exist.', 'error');
                return redirect()->action('admin\AdvertisementsController@getPrimaryKeywords');
            }

            DB::table('ads_primery_keywords')->insert(['keyword' => Input::get('keyword'), 'leverage' => Input::get('leverage')]);
        }

        if(Input::has('submitEditPrimary')){
            $keyword = DB::table('ads_primery_keywords')->whereField(0)->where('id', Input::get('id'))->first();
            if(!$keyword){
                $this->sessionMessagePlain('The keyword does not exist.', 'error');
                return redirect()->action('admin\AdvertisementsController@getPrimaryKeywords');
            }

            DB::table('ads_primery_keywords')->where('id', Input::get('id'))->update(['keyword' => Input::get('keyword'), 'leverage' => Input::get('leverage')]);
        }

        if(Input::has('submitDeletePrimary')){
            $keyword = DB::table('ads_primery_keywords')->whereField(0)->where('id', Input::get('id'))->first();
            if(!$keyword){
                $this->sessionMessagePlain('The keyword does not exist.', 'error');
                return redirect()->action('admin\AdvertisementsController@getPrimaryKeywords');
            }

            DB::table('ads_primery_keywords')->where('id', Input::get('id'))->delete();
        }

        Session::flash('messageType', 'success');
        Session::flash('message', 'All changes have been made.');

        Cache::flush();
        return redirect()->action('admin\AdvertisementsController@getPrimaryKeywords');
    }


	public function getFieldsfactors(){
		$data1 = $this->CommonData();
		$data2 = [
		    'keywords' 		=> DB::table('ads_primery_keywords')->whereField(1)->select('id', 'keyword', 'leverage', 'operation', 'advancedOperation')->paginate(10),
            'fields'        => [
                'show_in' => 'Show ad in field',
                'ageFrom' => 'Restrict ad to age from',
                'ageTo' => 'Restrict ad to age to',
                'gender' => 'Restrict ad to specific gender',
                'languages' => 'Restrict ad to specific languages',
                'interests' => 'Restrict ad to specific interests',
                'geoTurn' => 'Restrict ad to specific Geo',
            ]
		];

		$data = array_merge($data1, $data2);
		return view('admin.ads.fieldsfactors', $data);
	}

	public function postFieldsfactors(){
        if(Input::has('submitNewPrimary')){
            $keyword = DB::table('ads_primery_keywords')->whereField(1)->where('keyword', Input::get('keyword'))->first();
            if($keyword){
                $this->sessionMessagePlain('The field factor already exist.', 'error');
                return redirect()->action('admin\AdvertisementsController@getFieldsfactors');
            }

            $operationType = Input::get('operationtype');
            $operation = '';
            $advanedOperation = '';
            if($operationType == 'simple'){
                $operation = Input::get('simpleoperation');
            }elseif($operationType == 'advanced'){
                $operation = 0;
                $advanedOperation = Input::get('advancedoperatin');
            }

            DB::table('ads_primery_keywords')->insert(['field' => 1, 'keyword' => Input::get('keyword'), 'leverage' => Input::get('leverage'), 'operation' => $operation, 'advancedOperation' => $advanedOperation]);
        }

        if(Input::has('submitEditPrimary')){
            $keyword = DB::table('ads_primery_keywords')->where('id', Input::get('id'))->first();
            if(!$keyword){
                $this->sessionMessagePlain('The field factor does not exist.', 'error');
                return redirect()->action('admin\AdvertisementsController@getFieldsfactors');
            }

            $operationType = Input::get('operationtype');
            $operation = '';
            $advanedOperation = '';
            if($operationType == 'simple'){
                $operation = Input::get('simpleoperation');
            }elseif($operationType == 'advanced'){
                $operation = 0;
                $advanedOperation = Input::get('advancedoperatin');
            }

            DB::table('ads_primery_keywords')->where('id', Input::get('id'))->update(['keyword' => Input::get('keyword'), 'leverage' => Input::get('leverage'), 'operation' => $operation, 'advancedOperation' => $advanedOperation]);
        }

        if(Input::has('submitDeletePrimary')){
            $keyword = DB::table('ads_primery_keywords')->whereField(1)->where('id', Input::get('id'))->first();
            if(!$keyword){
                $this->sessionMessagePlain('The field factor does not exist.', 'error');
                return redirect()->action('admin\AdvertisementsController@getFieldsfactors');
            }

            DB::table('ads_primery_keywords')->where('id', Input::get('id'))->delete();
        }

        Session::flash('messageType', 'success');
        Session::flash('message', 'All changes have been made.');

        Cache::flush();
        return redirect()->action('admin\AdvertisementsController@getFieldsfactors');
    }

    public function getAdsBlocks(){
        $data1 = $this->CommonData();

        $ad_blocks = Settings::where('name', 'LIKE', 'ad_block_%')->pluck('value', 'name')->all();
        $data2 = [
            'adblocks'   => $ad_blocks,
            'placements' => [
                'hometop' => 'Home top',
                'homebottom' => 'Home bottom',
                'resultstop' => 'Results top',
                'resultsbottom' => 'Results bottom',
                'resultsright' => 'Results right side',
            ]
        ];

        $data = array_merge($data1, $data2);
        return view('admin.ads.adblocks', $data);
    }

    public function postAdsBlocks(){
        if(Input::has('submitNewAdBlock')){
            $this->set('ad_block_'.Input::get('placement').'_'.str_slug(Input::get('name'), '_'), Input::get('adcontent'));
        }

        if(Input::has('submitEditPrimary')){
            $this->set('ad_block_'.Input::get('placement').'_'.str_slug(Input::get('name'), '_'), Input::get('adcontent'));
        }

        if(Input::has('submitDeleteAdBlock')){
            $adBlock = Settings::where('name', Input::get('id'))->first();
            if(!$adBlock){
                $this->sessionMessagePlain('The ad block does not exist.', 'error');
                return redirect()->action('admin\AdvertisementsController@getAdsBlocks');
            }

            $adBlock->delete();
        }

        Session::flash('messageType', 'success');
        Session::flash('message', 'All changes have been made.');

        Cache::flush();
        return redirect()->action('admin\AdvertisementsController@getAdsBlocks');
    }

    public function getAdsSettings(){
        $data = array_merge([

        ], $this->CommonData());

        return view('admin.ads.settings', $data);
    }

    public function postAdsSettings(){

        if(Input::get('enableads') == 'on'){
            $this->set('advertisements', 1);
        }else{
            $this->set('advertisements', 0);
        }

        if(Input::get('approveAds') == 'on'){
            $this->set('approveAds', 1);
        }else{
            $this->set('approveAds', 0);
        }

        if(Input::has('takeFromAdvertisements')){
            $this->set('takeFromAdvertisements', Input::get('takeFromAdvertisements'));
        }

        if(Input::has('takeFromAdvertisements')){
            $this->set('takeFromAdvertisements', Input::get('takeFromAdvertisements'));
        }

        if(Input::has('initialCost0')){
            $this->set('initialCost0', Input::get('initialCost0'));
        }

        if(Input::has('initialCost1')){
            $this->set('initialCost1', Input::get('initialCost1'));
        }

        if(Input::has('initialCost2')){
            $this->set('initialCost2', Input::get('initialCost2'));
        }

        if(Input::has('costPerDecimals')){
            $this->set('costPerDecimals', Input::get('costPerDecimals'));
        }

        if(Input::has('budgetMin')){
            $this->set('budgetMin', Input::get('budgetMin'));
        }

        if(Input::has('min_payment')){
            $this->set('min_payment', Input::get('min_payment'));
        }

        if(Input::has('max_payment')){
            $this->set('max_payment', Input::get('max_payment'));
        }

        Session::flash('messageType', 'success');
        Session::flash('message', 'All changes have been made.');

        Cache::flush();
        return redirect()->action('admin\AdvertisementsController@getAdsSettings');
    }

	public function getAds($id){
		$compain = AdsCompain::find($id);
		if(!$compain) abort(404);
		
		$ads = $compain->ads()->paginate(10);
		$data1 = $this->CommonData();
		
		// $costFactors = DB::table('ads_primery_keywords')->select('keyword', 'leverage')->whereField(0)->get();
		
		$data2 = [
		    'ads' 	  	   => $ads,
		    'compain' 	   => $compain,
		    // 'costFactors'  => $costFactors,
		];
		
		$data = array_merge($data1, $data2);
		return view('admin.ads.ads', $data);
	}

    /**
     *
     */
    public function postCompains(){

        $this->set('takeFromAdvertisements', (int) Input::get('numberAds'));
        $this->set('advertisements', (int) boolval(Input::get('adsStatu')));

        Session::flash('messageType', 'success');
        Session::flash('message', 'All changes have been made.');

        Cache::flush();
        return redirect()->action('admin\AdvertisementsController@getCompains');

	}

	public function deleteAd($id){
        $ad = Advertisements::find($id);
        if(!$ad) abort(404);

        $ad->delete();

        Session::flash('messageType', 'success');
        Session::flash('message', 'Ad removed successfully.');

        return redirect()->action('admin\AdvertisementsController@getCompains');
    }

	public function deleteCompain($id){
        $compain = AdsCompain::find($id);
        if(!$compain) abort(404);

        $compain->delete();

        Session::flash('messageType', 'success');
        Session::flash('message', 'Ad removed successfully.');

        return redirect()->action('admin\AdvertisementsController@getCompains');
    }

    public function newCompain(){
        $user = User::find(Input::get('compainUser'));
        if(!$user){
            Session::flash('messageType', 'error');
            Session::flash('message', 'User not found.');
            return redirect()->route('admin.searchcompains.get');
        }

        $compain = new AdsCompain;
        $compain->name = Input::get('compainName');
        $compain->user_id = $user->id;

        $compain->save();

        Session::flash('messageType', 'success');
        Session::flash('message', 'Compain created successfully.');
        return redirect()->route('admin.searchcompains.get');
    }

    public function getNewAd($id){
        $compain = AdsCompain::find($id);
        if(!$compain) abort(404);

        $data = json_decode(\File::get(storage_path('app/data/data.json')), true);

        $countries = [];
        foreach($data['countries'] as $countryCode => $country){
            $countries[$countryCode] = $country['name'];
        }

        $continents = [];
        foreach($data['continents'] as $continentCode => $continent){
            $continents[$continentCode] = $continent;
        }

        $languages = [];
        foreach($data['languages'] as $languageCode => $language){
            if(isset($language['name'])){
                $languages[$languageCode] = $language['name'];
            }
        }

        $costFactors = DB::table('ads_primery_keywords')->whereField(1)->get();

        $data2 = [
            'compain' 	   => $compain,
            'countries'    => $countries,
            'continents'   => $continents,
            'languages'    => $languages,
            'engines'      => $this->Engines(),
            'costFactors'  => $costFactors,
        ];

        $data = array_merge($this->CommonData(), $data2);
        return view('admin.ads.new', $data);

    }

    public function getEditAd($id){
        $ad = Advertisements::find($id);
        if(!$ad) abort(404);

        $compain = $ad->compain;
        $data = json_decode(\File::get(storage_path('app/data/data.json')), true);

        $countries = [];
        foreach($data['countries'] as $countryCode => $country){
            $countries[$countryCode] = $country['name'];
        }

        $continents = [];
        foreach($data['continents'] as $continentCode => $continent){
            $continents[$continentCode] = $continent;
        }

        $languages = [];
        foreach($data['languages'] as $languageCode => $language){
            if(isset($language['name'])){
                $languages[$languageCode] = $language['name'];
            }
        }

        $costFactors = DB::table('ads_primery_keywords')->whereField(1)->get();

        $data2 = [
            'ad' 	       => $ad,
            'target' 	   => $ad->target,
            'compain' 	   => $compain,
            'countries'    => $countries,
            'continents'   => $continents,
            'languages'    => $languages,
            'engines'      => $this->Engines(),
            'costFactors'  => $costFactors,
        ];

        $data = array_merge($this->CommonData(), $data2);
        return view('admin.ads.edit', $data);

    }

    public function postEditAd($id){
        $ad = Advertisements::find($id);
        if(!$ad){
            Session::flash('messageType', 'error');
            Session::flash('message', 'There is an error, the ad id not recognized.');
            return redirect()->route('admin.searchcompains.get');
        }

        $compain = $ad->compain;

        $input = Input::only(
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
            'adStatu',
            'adApproved'
        );

        if(!Input::has('budget')){
            $input['budget'] = 5;
        }

        $validator = Validator::make($input, [
            'adUnitName' => 'max:25',
            'adTitle' => 'required|max:25',
            'adDescription' => 'required|max:150',
            'adVurl' => 'required|max:35',
            'adKeywords' => 'required',
            'adURL' => 'required|max:255',
            'show_in' => 'required|array',
            'ageFrom' => 'integer|nullable',
            'ageTo' => 'integer|nullable',
            'gender' => 'in:0,1,2|nullable',
            'languages' => 'array|nullable',
            'interests' => 'string|nullable',
            'geoTurn' => 'nullable',
            'continentTurn' => 'nullable',
            'continents' => 'array|nullable|required_if:continentTurn,1',
            'countriesTurn1' => 'nullable',
            'inc_countries' => 'array|nullable|required_if:countriesTurn1,1',
            'countriesTurn2' => 'nullable',
            'exc_countries' => 'array|nullable|required_if:countriesTurn2,1',
        ]);


        if ($validator->fails()) {
            return redirect()->route('admin.searchads.edit', $id)->withErrors($validator)->withInput();
        }

        $settings = $this->settings;
        $data = $validator->getData();

        // create the ad
        $adTarget = $ad->target;

        // name
        $name = str_replace(' ', '_', $data['adUnitName']);
        $ad->name = $name;

        // compain
        $ad->compain_id = $compain->id;

        // ad contents
        $ad->title = $data['adTitle'];
        $ad->description = $data['adDescription'];
        $ad->Vurl = $data['adVurl'];
        $ad->keywords = $data['adKeywords'];
        $ad->url = $data['adURL'];


        // show in
        $show_in_arr = $data['show_in'];
        if ((array_search('0', $show_in_arr)) !== false) {
            $showInValue = 0;
        }else{
            $showInValue = implode(',', $show_in_arr);
        }

        // ad targets --------------------
        // show in
        $adTarget->show_in = $showInValue;
        // age
        if($data['ageFrom'] || $data['ageTo']){
            $ageFrom = (int) $data['ageFrom'];
            $ageTo = (int) $data['ageTo'];
            $adTarget->age = $ageFrom . ',' . $ageTo;
        }

        // gender
        if($data['gender'])
            $adTarget->gender = $data['gender'];

        // languages & interests
        if($data['languages'])
            $adTarget->language = implode(',',$data['languages']);
        if($data['interests'])
            $adTarget->interests = $data['interests'];

        // geo options
        if($data['geoTurn']){
            if($data['continentTurn']){
                $adTarget->continent = implode(',', $data['continents']);
            }
            if($data['countriesTurn1']){
                $adTarget->inc_countries = implode(',', $data['inc_countries']);
            }
            if($data['countriesTurn2']){
                $adTarget->exc_countries = implode(',', $data['exc_countries']);
            }
        }

        // defualt
        $ad->turn = (int) Input::get('adStatu');

        if(!$ad->save() || !$compain->user->save()){
            $this->sessionMessage('admin.error_occured', 'error');
            return redirect()->route('admin.searchads.edit', $id)->withInput();
        }

        if(!$adTarget->save()){
            $this->sessionMessage('admin.error_occured', 'error');
            return redirect()->route('admin.searchads.edit', $id)->withInput();
        }

        $this->sessionMessage('admin.ad_edited', 'success');
        return redirect()->route('admin.searchads.edit', $id);
    }

    public function postNewAd($id){
        $compain = AdsCompain::where('id', Input::get('compain'))->first();
        if(!$compain){
            Session::flash('messageType', 'error');
            Session::flash('message', 'There is an error, the compain not recognized.');
            return redirect()->route('admin.searchads.new.get', $id);
        }

//        $user = User::find(Input::get('userId'));
//        if(!$user) {
//            Session::flash('messageType', 'error');
//            Session::flash('message', 'please select a user.');
//            return redirect()->route('admin.searchads.new.get', $id);
//        }

        $input = Input::only(
            'chargeType',
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
            'budget',
            'adStatu',
            'adApproved'
        );

        if(!Input::has('budget')){
            $input['budget'] = 5;
        }

        $validator = Validator::make($input, [
            'chargeType' => 'required|in:0,1,2',
            'adUnitName' => 'max:25',
            'adTitle' => 'required|max:25',
            'adDescription' => 'required|max:150',
            'adVurl' => 'required|max:35',
            'adKeywords' => 'required',
            'adURL' => 'required|max:255',
            'show_in' => 'required|array',
            'ageFrom' => 'integer|nullable',
            'ageTo' => 'integer|nullable',
            'gender' => 'in:0,1,2|nullable',
            'languages' => 'array|nullable',
            'interests' => 'string|nullable',
            'geoTurn' => 'nullable',
            'continentTurn' => 'nullable',
            'continents' => 'array|nullable|required_if:continentTurn,1',
            'countriesTurn1' => 'nullable',
            'inc_countries' => 'array|nullable|required_if:countriesTurn1,1',
            'countriesTurn2' => 'nullable',
            'exc_countries' => 'array|nullable|required_if:countriesTurn2,1',
            'scheduleTurn' => 'required_if:chargeType,2|boolean',
            'startDate' => 'date_format:d-m-Y|nullable|required_if:scheduleTurn,1|after:today',
            'startTime' => 'date_format:H:i|nullable|required_if:scheduleTurn,1|after:today',
            'endDate' => 'date_format:d-m-Y|string|nullable|required_if:scheduleTurn,1|after:startDate',
            'endTime' => 'date_format:H:i|string|nullable|required_if:scheduleTurn,1',
            'budgetTurn' => 'required|boolean',
            'budget' => 'numeric|min:'.$this->settings['budgetMin'].'|required_if:chargeType,0|required_if:chargeType,1',
        ]);


        if ($validator->fails()) {
            return redirect()->route('admin.searchads.new.get', $id)->withErrors($validator)->withInput();
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
        $adTarget = new AdTargets();

        // type
        $ad->type = $data['chargeType'];

        // name
        $name = str_replace(' ', '_', $data['adUnitName']);
        $ad->name = $name;

        // compain
        $ad->compain_id = $compain->id;

        // ad contents
        $ad->title = $data['adTitle'];
        $ad->description = $data['adDescription'];
        $ad->Vurl = $data['adVurl'];
        $ad->keywords = $data['adKeywords'];
        $ad->url = $data['adURL'];


        // show in
        $show_in_arr = $data['show_in'];
        if ((array_search('0', $show_in_arr)) !== false) {
            $showInValue = 0;
        }else{
            $showInValue = implode(',', $show_in_arr);
        }

        // ad targets --------------------
        // show in
        $adTarget->show_in = $showInValue;
        // age
        $adTarget->age = 0;
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
            $adTarget->language = implode(',',$data['languages']);
        $adTarget->interests = 0;
        if($data['interests'])
            $adTarget->interests = $data['interests'];

        // geo options
        $adTarget->continent = 0;
        $adTarget->inc_countries = 0;
        $adTarget->exc_countries = 0;
        if($data['geoTurn']){
            if($data['continentTurn']){
                $adTarget->continent = implode(',', $data['continents']);
            }
            if($data['countriesTurn1']){
                $adTarget->inc_countries = implode(',', $data['inc_countries']);
            }
            if($data['countriesTurn2']){
                $adTarget->exc_countries = implode(',', $data['exc_countries']);
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
        $ad->user_id = $compain->user->id;
        $ad->turn = (int) Input::get('adStatu');
        $ad->approved = (int) Input::get('adApproved');

        $payment = new Payments;
        $payment->user_id = $compain->user->id;
        $payment->total = 0;

        if($compain->user->credit > $ad->budget){
            $compain->user->credit = $compain->user->credit - $ad->budget;
            if($settings['approveAds']){
                $ad->approved = 0;
            }else{
                $ad->approved = 1;
            }
            $payment->total = -($ad->budget);
        }else{
            $ad->approved = 2;
        }

        if(!$ad->save() || !$compain->user->save()){
            $this->sessionMessage('general.error_occured', 'error');
            return redirect()->route('admin.searchads.new.get', $id)->withInput();
        }

        $adTarget->ad_id = $ad->id;
        if(!$adTarget->save()){
            $this->sessionMessage('general.error_occured', 'error');
            return redirect()->route('admin.searchads.new.get', $id)->withInput();
        }

        $payment->ads_id = $ad->id;
        if(!$payment->save()){
            $this->sessionMessage('general.error_occured', 'error');
            return redirect()->route('admin.searchads.new.get', $id)->withInput();
        }

        $this->sessionMessage('general.ad_created', 'success');
        return redirect()->route('admin.searchads.get', $id);
    }

    public function postAds($id){

		$input = Input::all();
		$errors = false;

        // dd(Input::all());
        if(Input::has('submitNew')){

        }

		if(Input::has('submitEditAd')){
			$adver = Advertisements::where('id', $input['adId'])->first();
			
			if(!$adver){
				$errors = true;
				Session::flash('messageType', 'error');
			    Session::flash('message', 'There was an error during search for advertisement id, please verify that you don\'t do any thing that is illegal.');
			}
			
			if(!$errors){
				$adver->owner = $input['ownerEmail'];
				$adver->title = $input['adTitle'];
				$adver->url = $input['adURL'];
				$adver->Vurl = $input['adVURL'];
				$adver->description = $input['adDescription'];
				$adver->keywords = $input['adKeywords'];
				$adver->turn = (int) boolval(Input::get('adStatu'));
				
				$adver->save();
			}
		}
		
		if(Input::has('submitDelete')){
			$adver = Advertisements::where('id', $input['adId'])->first();
			
			if(!$adver){
				$errors = true;
				Session::flash('messageType', 'error');
			    Session::flash('message', 'There was an error during search for advertisement id, please verify that you don\'t do any thing that is illegal.');
			}
			
			if(!$errors){
				$adver->delete();
			}
			
		}
		
		if(Input::has('submitSettings')){
			$this->set('takeFromAdvertisements', (int) $input['numberAds']);
			$this->set('advertisements', (int) boolval(Input::get('adsStatu')));
		}
		
		if(!$errors){
			Session::flash('messageType', 'success');
			Session::flash('message', 'All changes have been made.');
		}
		
		Cache::flush();
		return redirect()->action('admin\AdvertisementsController@get');
	}

    private function getDiffDays($start, $end, $decimals){
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
        if($operation == '/' && ($leverage / 100) == 0) return 'NaN';
        return eval('return '.$cost.' '.$operation.' ('.$leverage.' / 100);');
    }
	
}
