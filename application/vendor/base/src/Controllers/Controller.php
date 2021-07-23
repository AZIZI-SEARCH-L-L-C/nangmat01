<?php

namespace AziziSearchBase\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use AziziSearchEngineStarter\Engines;
use AziziSearchEngineStarter\Advertisements;
use AziziSearchEngineStarter\Settings;
use AziziSearchEngineStarter\Notifications;
use AziziSearchEngineStarter\Logos;
use Monolog\Logger;
use Carbon\Carbon;
use Monolog\Handler\RotatingFileHandler;
use LaravelLocalization, GeoIP, Cache, Request, Input, Mail, Auth, Log, Config, View;
use Illuminate\Notifications\Messages\MailMessage;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	
	protected $settings;
	
	protected $cache;
	
	protected $regionMode;
	
	protected $region;
	
	protected $safeSearch;
	
	function __construct() {
		if( config('app.installed', false) )
			$this->settings = $this->getSettings();
		else $this->settings = [];
	}
	
	public function CommonData($result = false, $query = null, $name = null){

		// $this->sendMail('emails.confirmation', ['confirmation_key' => 'fdfgd'], ['email' => 'jaafarazizi1@gmail.com', 'username' => 'jaafar'], 'gfghf');

		$advertisements = [];
	    $keywords = [];
		$this->settings = $this->getSettings();
		$settings = $this->settings;


		if(!$name) $name = $settings['default'];
		if(!$query) $query = Input::get('q');

		if($result){
//			if($settings['advertisements']) $advertisements = $this->getAds($query, $settings['takeFromAdvertisements']);
		}

		if(Auth::check()){
			$user = Auth::user();
			$search_references = json_decode($user->search_references, true);
		}

		$enginesNames = $this->getEnginesNames();
		// dd(session('region'));

		if(Auth::check()){
			$this->regionMode = $user->getSearchReference('regionMode');
		}else{
			if(session()->has('regionMode')){
				$this->regionMode = session()->get('regionMode');
			}else{
				$this->regionMode = $settings['localizationMode'];
			}
		}

		$location = GeoIP::getLocation(); // user locaion
		if(Auth::check()){
			$this->region = $user->getSearchReference('region');
		}else{
			if(session()->has('region')){
				$this->region = session()->get('region');
			}else{
				if($this->regionMode == 0){
					$this->region = '';
				}else{
					if($settings['autoLocalization']){
						$this->region = $location->iso_code;
						// $this->region = 'df';
					}else{
						$this->region = $settings['locale'];
					}
				}
			}
		}

		// block territories
        /*$excTerr = explode(',', $settings['excTerr']);
        $foundStatTerr = preg_grep("/".$location->state_name."/i", $excTerr);
        $foundCountryTerr = preg_grep("/".$location->country."/i", $excTerr);
        $foundCityTerr = preg_grep("/".$location->city."/i", $excTerr);
        if(!empty($foundStatTerr)
            or !empty($foundCountryTerr)
            or !empty($foundCityTerr)
        ){
            echo 'your location blocked';
            exit();
        }*/
		
		if(Input::has('safeSearch')){
			$settings['safeSearch'] = 0;
			if(Input::get('safeSearch')){
				$settings['safeSearch'] = 2; // = Input::get('safeSearch');
			}
		}else{
			if(Auth::check()){
				$settings['safeSearch'] = 0;
				if($user->getSearchReference('safeSearch')){
					$settings['safeSearch'] = $user->getSearchReference('safeSearch');
				}
			}else{
				if(session()->has('safeSearch')){
					$settings['safeSearch'] = 0;
					if(session()->get('safeSearch')){
						$settings['safeSearch'] = 2; // = session()->get('safeSearch');
					}
				}
			}
		}
		
		if(Auth::check()){
			$settings['resultsTarget'] = $user->getSearchReference('resultsTarget');
		}else{
			if(session()->has('resultsTarget')){
				if(session()->get('resultsTarget')){
					$settings['resultsTarget'] = '_blank';
				}else{
					$settings['resultsTarget'] = '_self';
				}
			}else{
				if($settings['resultsTarget']){ 
					$settings['resultsTarget'] = '_blank';
				}else{
					$settings['resultsTarget'] = '_self';
				}
			}
		}
		
//		$logos = $this->getLogoInfo($name, $settings);
		$logos = $this->getCurrentLogoDate($name, $settings);

		$file = $this->getCurrentLogo($logos, $settings);
		
		$logoType = $file['type'];
		$logo = $file['content'];
		
		$engine = $this->Engine($name);

        $ad_blocks = Settings::where('name', 'LIKE', 'ad_block_%')->pluck('value', 'name')->all();
        $ad_blocks2 = [];

        foreach ($ad_blocks as $ad_name => $content) {
            $ad_blocks2[str_replace('block_', '', $ad_name)] = $content;
        }

		$data = [
		    'keywords'       => $keywords,
		    'advertisements' => $advertisements,
		    'query'          => $query,
			'engines'        => $this->Engines(),
			'engine'         => $name,
			'engineObj'      => $engine,
			'engineDb'       => $engine,
			'action'         => $engine->controller.'@search',
			'cse_key'        => $engine->key,
			'settings'       => $settings,
			'logoType'       => $logoType,
			'enginesNames'   => $enginesNames,
			'logo'           => $logo,
			'regionMode'     => $this->regionMode,
			'region'         => $this->region,
			'boldActMenu'	 => $result,
			'ad_blocks'	     => $ad_blocks2,
			'urlParams'      => Request::all(),
			'assets_v'       => 1,
		];

        View::Share($data);

		return $data;
	}
	
	public function getAds($query, $take)
	{
		if(config('cache.enabled')){
			if(Cache::has('ads-'.$query)){
				$ads = Cache::get('ads-'.$query);
			}else{
//				$ads = Advertisements::search($query, null, true)->where('turn', true)->take($take)->get()->toArray();
                $ads = [];
				Cache::forever('ads-'.$query, $ads);
			}
		}else{
			$ads = Advertisements::search($query, null, true)->where('turn', true)->take($take)->get()->toArray();
		}
		return $ads;
		
	}
	
	public function Engines(){
		if(config('cache.enabled')){
			if(Cache::has('engines')){
				$engines = Cache::get('engines');
			}else{
				$engines = Engines::where('turn', true)->orderBy('order')->get()->toArray();
				Cache::forever('engines', $engines);
			}
		}else{
			$engines = Engines::where('turn', true)->orderBy('order')->get()->toArray();
		}
		return $engines;
	}
	
	public function Engine($name){
		if(config('cache.enabled')){
			if(Cache::has('engine-'.$name)){
				$engine = Cache::get('engine-'.$name);
			}else{
				$engine = Engines::where('name', $name)->first();
				if(!$engine){ abort(404);}
				Cache::forever('engine-'.$name, $engine);
			}
		}else{
			$engine = Engines::where('name', $name)->first();
			if(!$engine){ abort(404);}
		}
		
		return $engine;
	}
	
	public function getSettings(){
		if(config('cache.enabled')){
			if(Cache::has('settings')){
				$settings = Cache::get('settings');
			}else{
				$settings = Settings::pluck('value', 'name')->all();
				Cache::forever('settings', $settings);
			}
		}else{
			$settings = Settings::pluck('value', 'name')->all();
		}
		return $settings;
	}
	
	public function getEnginesNames(){
		
		if(config('cache.enabled')){
			if(Cache::has('enginesNames')){
				$enginesNames = Cache::get('enginesNames');
			}else{
				$engines = $this->Engines();
				foreach($engines as $engine){
					$enginesNames[] = $engine['name'];
				}
				Cache::forever('enginesNames', $enginesNames);
			}
		}else{
			$engines = $this->Engines();
			foreach($engines as $engine){
				$enginesNames[] = $engine['name'];
			}
		}
		
		return $enginesNames;
	}

    protected function getLogoInfo($name, $settings){
        $cacheName = 'logo_'.$name;
        if(config('cache.enabled')){
            if(Cache::has($cacheName)){
                $logo = Cache::get($cacheName);
            }else{
                $logo = Logos::where('engine_name', $name)->where('active', 1)->select('type', 'content')->first();
                Cache::forever($cacheName, $logo);
            }
        }else{
            $logo = Logos::where('engine_name', $name)->where('active', 1)->select('type', 'content')->first();
        }

        if(!$logo){
            $logo['type'] = $settings['defaultLogoType'];
            $logo['content'] = $settings['defaultLogoContent'];
        }

        return $logo;
    }

    protected function getCurrentLogo ($logos, $settings) {
        $Temp_logos = [];

        $x = 0;
        foreach($logos as $Clogo){
            $Temp_logos[$x]['content'] = $Clogo['content'];
            $Temp_logos[$x]['type']    = $Clogo['type'];
            $x++;
        }

        $secondsFixed = $settings['ChangeLogoTime'];
        $total = count($Temp_logos);
        $seedValue =(int)(time() / $secondsFixed);
        srand($seedValue);

        for ($i=0; $i < $total; $i++){
            $r = $total-1;
            $temp = $Temp_logos[$i];
            $Temp_logos[$i] = $Temp_logos[$r];
            $Temp_logos[$r] = $temp;
        }

        if($settings['ChangeLogoTime'] == 60){
            $index =(int)(date('i'));
        }elseif($settings['ChangeLogoTime'] == 3600){
            $index =(int)(date('G'));
        }elseif($settings['ChangeLogoTime'] == 86400){
            $index =(int)(date('z'));
        }elseif($settings['ChangeLogoTime'] == 604800){
            $index =(int)(date('W'));
        }elseif($settings['ChangeLogoTime'] == 2592000){
            $index =(int)(date('n'));
        }else{
            $index =(int)(date('i'));
        }
        $i = $index%$total;
        $file = $Temp_logos[$i];

        return $file;
    }

	protected function getCurrentLogoDate($name, $settings){
	    $now = Carbon::now()->toDateTimeString();
        if(config('cache.enabled')){
            if(Cache::has('logoDate')){
                $logo = Cache::get('logoDate');
            }else{
                $logo = Logos::where('engine_name', $name)->whereDate('starts', '>=', $now)->whereDate('ends', '<', $now)->where('active', 1)->select('type', 'content')->get()->toArray();
                Cache::forever('logoDate', $logo);
            }
        }else{
            $logo = Logos::where('engine_name', $name)->where('starts', '<=', $now)->where('ends', '>', $now)->where('active', 1)->select('type', 'content')->get()->toArray();
        }

        if(!$logo){
            $logo[0]['type'] = $settings['defaultLogoType'];
            $logo[0]['content'] = $settings['defaultLogoContent'];
        }

        return $logo;
    }
	
	protected function getUncryptedUrl($url){
		$query = parse_url($url, PHP_URL_QUERY);
		parse_str($query, $parsed_str);
		if(!empty($parsed_str['r'])){
			return $parsed_str['r'];
		}
		return $url;
    }
	
	protected function getDuration($vidDuration){
		preg_match_all('/(\d+)/', $vidDuration, $parts);
		$duration = '';
		$i = 0;
		$numItems = count($parts[0]);
		if($numItems == 1){ 
			$parts[0][1] = $parts[0][0];
			$parts[0][0] = '00';
		}
		$duration = implode(':', $parts[0]);
		return $duration;
	}
	
	protected function getTimeFormated($date){
		$settings = $this->getSettings();
		if($settings['newsDateFormat'] == 1){
			$time = get_readable_time($date, $settings['newsDateFormatform']);
		}else{
			$time = get_time_ago($date, $settings['newsDateFull']);
		}
		return $time;
	}
	
	protected function sendMail($view, $data, $to, $subject){
		$settings = $this->getSettings();
		$siteName = $settings['siteName'];
		$siteEmail = $settings['siteEmail'];
		
		$mail_data = array_merge (
			config('emailStyle'),
			$data ,
			['settings' => $settings],
			$to
		);
		// dd($mail_data);
		Mail::send($view, $mail_data, function($message) use ($siteName, $siteEmail, $to, $subject) {
			$message->from($siteEmail, $siteName);
			$message->to($to['email'], $to['username']);
			$message->subject($this->getEmailSubject($subject));
		});
	}
	
	protected function getEmailSubject($subject){
		$settings = $this->getSettings();
		return $settings['siteName'] . ' - ' . $subject;
	}
	
	protected function previous($default){
		$redirect = route($default);
        if(session()->has('previous')){
			$redirect = session()->get('previous');
			session()->forget('previous');
		}
		return redirect($redirect);
    }
	
	protected function adminNotifaction($message, $type){
		// notifaction to admin
	}
	
	protected function sessionMessage($messageTransCode, $messageType){	
		session()->flash('messageType', $messageType);
		session()->flash('message', trans($messageTransCode));
    }

	protected function sessionMessageplain($message, $messageType){
		session()->flash('messageType', $messageType);
		session()->flash('message', $message);
    }
	
	protected function addHttp($url){
		if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
        	$url = "http://" . $url;
    	}
    	return $url;
    }
	
	protected function addToLog($engine, $level, $message, $notification = false, $notifiMsg = ''){
		$log = new Logger($engine);
		$log->pushHandler(
			$handler = new RotatingFileHandler(storage_path() . '/logs/'.$engine.'.log', 365, $level)
		);
		$log->log($level, $message, ['user' => Auth::check() ? Auth::user()->name : 'guest']);
		
		if($notification && $this->settings['logNotifications']){
			Notifications::create(['type' => $level, 'message' => $notifiMsg]);
		}
	}
}
