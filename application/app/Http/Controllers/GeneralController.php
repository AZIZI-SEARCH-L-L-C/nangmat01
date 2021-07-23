<?php

namespace AziziSearchEngineStarter\Http\Controllers;

use AziziSearchEngineStarter\Sites;
use AziziSearchEngineStarter\Submited;
use Illuminate\Http\Request;

use AziziSearchEngineStarter\Http\Requests;
use AziziSearchEngineStarter\Http\Controllers\Controller;
use AziziSearchEngineStarter\AdvertiseRequestes;
use AziziSearchEngineStarter\AdsPackages;
use AziziSearchEngineStarter\Engines;
use Jenssegers\Agent\Agent;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use AziziSearchEngineStarter\Queries;
use Input, Session, DB, GeoIP, Cache, Auth;

class GeneralController extends Controller
{

    protected $baseUrl;

	public function index(){
		
		$settings = $this->getSettings();
	    $type = $settings['default'];

		$data1 = $this->CommonData(false, '', $type);
		
		$engine = Engines::where('name', $settings['default'])->first();
		$data2 = [
			'controller' => $engine['controller'],
			'boldActMenu' => true,
		];
		
		$data = array_merge($data1, $data2);
		return View('home', $data);
		
	}
    
	public function indexType($type){
		
		if(empty($type)) $type = $settings['default'];
		$settings = $this->getSettings();

		$data1 = $this->CommonData(false, '', $type);
		
		$engine = Engines::where('name', $settings['default'])->first();
		$data2 = [
			'controller' => $engine['controller'],
			'boldActMenu' => true,
		];
		
		$data = array_merge($data1, $data2);
		return View('home', $data);
		
	}
	
	public function Advertise (){
//		$adsPackages = AdsPackages::get();
		$data = array_merge([
//			'packages' => $adsPackages,
		], $this->CommonData());
		
		return view('pages.advertise', $data);
	}


	public function PremiumKeywords (){
		$data = array_merge([

		], $this->CommonData());

		return view('pages.premiumkeywords', $data);
	}

	public function getSubmitSite (){
	    $email = '';
		if(Auth::check()){
		    $email = Auth::user()->email;
        }
		$data = array_merge([
			'email' => $email,
		], $this->CommonData());

		return view('pages.submit', $data);
	}
	
	public function Settings (){
		$settings = $this->getSettings();
		$data = $this->CommonData(false, '', $settings['default']);

		if(Auth::check()){
			$data['user'] = Auth::user();
		}
		
		return view('pages.settings', $data);
	}
	
	public function postSettings (){
		
		$settings = $this->getSettings();
		
		if(Auth::check()){
			$user = Auth::user();
			$user_references = json_decode($user->search_references, true);
		}
		
		if(in_array(Input::get('regionMode'), [0, 1, 2])){
			if(Auth::check()){
				$user_references['regionMode'] = Input::get('regionMode');
			}else{
				Session::put('regionMode', Input::get('regionMode'));
			}
			
		}
		
		
		if(Auth::check()){
			$user_references['region'] = $settings['locale'];
			if(in_array(Input::get('region'), explode(',', $settings['countries']))){
				$user_references['region'] = Input::get('region');
			}
		}else{
			Session::put('region', Input::get('region'));
		}
		
		// set safe search in session if it is
		if(Auth::check()){
			if(Input::has('safeSearch')){
				$user_references['safeSearch'] = Input::get('safeSearch');
			}else{
				$user_references['safeSearch'] = 0;
			}
			$user_references['resultsTarget'] = (boolean) Input::get('resultsTarget');
			$user_references['darkMode'] = (boolean) Input::get('darkMode');
			$user_references['collectData'] = (boolean) Input::get('collectData');
			$user_references['language'] = Input::get('language');
			
			$user->references = json_encode($user_references);
			$user->save();
		}else{
			if(Input::has('safeSearch')){
				Session::put('safeSearch', Input::get('safeSearch'));
			}else{
				Session::put('safeSearch', 0);
			}
			Session::put('resultsTarget', (boolean) Input::get('resultsTarget'));
			Session::put('darkMode', (boolean) Input::get('darkMode'));
			Session::put('collectData', (boolean) Input::get('collectData'));
			Session::save();
		}
		
		return redirect(Input::get('language').'/preferences')->with(['message' => 'Your preferences have been saved!', 'messageType' => 'success']);
		
	}
	
	public function AdvancedSearch (){
		
		$settings = $this->getSettings();
		$data = $this->CommonData(false, '', $settings['default']);
		$data['fileTypes'] = explode(',', $settings['fileTypes']);
		$data['dates'] = [0 => 'past 24 hours', 1 => 'past week', 2 => 'past month'];
		$data['countries'] = explode(',', $settings['countries']);
		// dd($data['fileTypes']);
		return view('pages.advancedSearch', $data);
	}
	
	public function postAdvancedSearch (){
		
		// dd(Input::all());
		
		$params = [];
		$query = Input::get('q', '');
		
		if(Input::has('exact')){
			$query .= ' "' . Input::get('exact') . '"';
		}
		
		if(Input::has('any')){
			$any = explode(' ', Input::get('any'));
			$i = 0;
			foreach($any as $anyWord){
				if(count($any) <= 1){ 
					$query .= ' ' . $anyWord;
					break; 
				}
				if(++$i != count($any)){
					$query .= ' ' . $anyWord . ' OR';
				}else{
					$query .= ' ' . $anyWord;
				}
			}
		}
		
		if(Input::has('none')){
			$query .= ' -"' . Input::get('none') . '"';
		}
		
		if(Input::has('site')){
			$query .= ' site:' . Input::get('site') . '';
		}
		
		if(Input::has('fileType')){
			$query .= ' filetype:' . Input::get('fileType') . '';
		}
		
		if(empty($query)){
			return redirect()->action('GeneralController@AdvancedSearch')->with(['message' => 'your query miss words.', 'messageType' => 'error']);
		}
		
		$params = array_add($params, 'q', $query);
		
		if(Input::has('safeSearch')){
			$params = array_add($params, 'safeSearch', Input::get('safeSearch'));
		}
		
		if(Input::has('time')){
			$params = array_add($params, 'd', Input::get('time'));
		}
		
		if(Input::has('region')){
			$params = array_add($params, 'c', Input::get('region'));
		}
	    
		// dd($params);
		return redirect()->action('WebController@search', $params);
		
	}
	
	public function postAdvertise (){
		// $input = Input::only('name', 'email', 'message');
		
		// if(empty($input['name']) or empty($input['email']) or empty($input['message'])){
			// $this->sessionMessage('general.advertiseRequestError', 'error');
			// return redirect()->route('advertise');
		// }
		
		// $Request = new AdvertiseRequestes();
		
		// $Request->name = $input['name'];
		// $Request->email = $input['email'];
		// $Request->message = $input['message'];
		
		// if(!$Request->save()){
			// $this->sessionMessage('general.advertiseRequestError', 'error');
		// }else{
			// $this->sessionMessage('general.advertiseRequestSuccess', 'success');
		// }
		
		dd(Input::all());
		
		return redirect()->route('advertise');
	}	
	
	
    public function registerQuery(){
		if(app()->environment('production')){
			$IPaddress = GeoIP::getClientIP();
			$geo = GeoIP::getLocation($IPaddress);
            $agent = new Agent();
			$browserFamily = $agent->browser();
			$osFamily = $agent->platform();
//			$device = $agent->device();
			if($agent->isPhone()){
				$device = 'Mobile';
			}elseif($agent->isTablet()){
				$device = 'Tablet';
			}elseif($agent->isDesktop()){
				$device = 'Desktop';
			}else{
				$device = 'Bot';
			}
			if( ! Input::has('q') ) return "No query";
			Queries::create(['query' => Input::get('q'), 'country' => $geo->iso_code, 'browser' => $browserFamily, 'device' => $device, 'os' => $osFamily]);
		}else{
			return 'queries not registered in development mode';
		}
	}
	
	public function getTopWords (){
		if(config('cache.enabled')){
			if(Cache::has('keywords')){
				$keywords = Cache::get('keywords');
			}else{
				$keywords = Queries::select([DB::raw('*'), DB::raw('count(*) as total')])->groupBy('query')->orderBy('total', 'desc')->take(10)->pluck('total', 'query');
				Cache::put('keywords', $keywords, 60); //  cache for one hour
			}
		}else{
			$keywords = Queries::select([DB::raw('*'), DB::raw('count(*) as total')])->groupBy('query')->orderBy('total', 'desc')->take(10)->pluck('total', 'query');
		}
		return $keywords;
	}

	public function postSubmitSite(){

        $url = Input::get('url');
	    $email = Input::get('email');

        if (filter_var($url, FILTER_VALIDATE_URL) === FALSE) {
            $this->sessionMessage('validation.notvalidurl', 'error');
            return redirect()->action('GeneralController@getSubmitSite');
        }

        if (filter_var($email, FILTER_VALIDATE_EMAIL) === FALSE) {
            $this->sessionMessage('validation.notvalidemail', 'error');
            return redirect()->action('GeneralController@getSubmitSite');
        }

        $site = new Submited();

        $site->email = $email;
        $site->url = $url;

        $site->save();

        $this->sessionMessage('validation.sitesubmited', 'success');
        return redirect()->action('GeneralController@getSubmitSite');

//        $url_info = parse_url($site);
//        $this->baseUrl = $url_info['scheme'] . '://' . $url_info['host'];
//
//        $client = new Client();
//        $res = $client->request('GET', $site);

//        dd($res->getBody()->getContents());
//        $crawler = new Crawler($res->getBody()->getContents());
//
//        $childLinks = [];
//        $crawler->filter('a')->each(function (Crawler $node) use (&$childLinks) {
//            $node_text = trim($node->text());
//            $node_url = $this->makeFullUrl($node->attr('href'));
//            $hash = $this->normalizeLink($node_url);
//            if($this->checkIfCrawlable($node_url) && $this->checkIfExternal($node_url)){
//                $childLinks[] = $node_url;
//            }
//        });
//        dd($childLinks);

    }

    /**
     * Is a given URL crawlable?
     * @param  string $uri
     * @return bool
     */
    protected function checkIfCrawlable($uri)
    {
        if ($uri == "") {
            return false;
        }

        if (empty($uri) === true) {
            return false;
        }

        $stop_links = array(
            '@^javascript\:.*$@i',
            '@^#.*@',
            '@^mailto\:.*@i',
            '@^tel\:.*@i',
            '@^fax\:.*@i',
        );

        foreach ($stop_links as $ptrn) {
            if (preg_match($ptrn, $uri) == true) {
                return false;
            }
        }

        return true;
    }

    /**
     * Is URL external?
     * @param  string $url An absolute URL (with scheme)
     * @return bool
     */
    protected function checkIfExternal($url)
    {
        $base_url_trimmed = str_replace(array('http://', 'https://'), '', $this->baseUrl);

        return preg_match("@$base_url_trimmed@", $url) == true;
        // return preg_match("@http(s)?\://$base_url_trimmed@", $url) == false;
    }

    /**
     * Normalize link (remove hash, etc.)
     * @param  string $url
     * @return string
     */
    protected function normalizeLink($uri)
    {
        return preg_replace('@#.*$@', '', $uri);
    }

    protected function makeFullUrl($url){
        if(filter_var($url, FILTER_VALIDATE_URL) === false){
            if($this->checkIfCrawlable($url)){
                $url = $this->baseUrl . $url;
            }
        }
        return $url;
    }
}
