<?php

namespace AziziSearchEngineStarter\Http\Controllers\admin;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use AziziSearchEngineStarter\Engines;
use AziziSearchEngineStarter\Queries;
use AziziSearchEngineStarter\Advertisements;
use AziziSearchEngineStarter\AdminLog;
use AziziSearchEngineStarter\Settings;
use AziziSearchEngineStarter\Notifications;
use AziziSearchEngineStarter\Http\Controllers\autoCompleteController;
use Carbon\Carbon;
use Lang, App, File, Cache;

class Controller extends BaseController
{
    protected $settings;

    function __construct() {
        if( config('app.installed', false) )
            $this->settings = $this->getSettings();
        else $this->settings = [];
    }

	protected function CommonData(){
		$data = [
			'notifications' 	  => Notifications::whereRead(0)->get(),
			'user' 				  => auth()->user(),
			'settings'            => $this->getSettings(),
		];
		
		return $data;
	}
	
	protected static function Engines(){
		if(config('cache.enabled')){
			if(Cache::has('admin-engines')){
				$engines = Cache::get('admin-engines');
			}else{
				$engines = Engines::orderBy('order')->get()->toArray();
				if(!$engines){ abort(404);}
				Cache::forever('admin-engines', $engines);
			}
		}else{
			$engines = Engines::orderBy('order')->get()->toArray();
			if(!$engines){ abort(404);}
		}
		
		return $engines;
	}
	
	protected static function getSettings(){
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
	
	protected function getEnginesNames(){
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
	
	public function Engine($name){
		if(config('cache.enabled')){
			if(Cache::has('engine-'.$name)){
				$engine = Cache::get('engine-'.$name);
			}else{
				$engine = Engines::where('name', $name)->select('key', 'controller')->first();
				if(!$engine){ abort(404);}
				Cache::forever('engine-'.$name, $engine);
			}
		}else{
			$engine = Engines::where('name', $name)->select('key', 'controller')->first();
			if(!$engine){ abort(404);}
		}
		
		return $engine;
	}
	
	protected function getAdvertiseRequestes() {
		if(config('cache.enabled')){
			if(Cache::has('AdvertiseRequestes')){
				$requests = Cache::get('AdvertiseRequestes');
			}else{
				$requests = AdvertiseRequestes::where('read', 0)->get();
				Cache::forever('AdvertiseRequestes', $requests);
			}
		}else{
			$requests = AdvertiseRequestes::where('read', 0)->get();
		}
		return $requests;
	}
	
	protected function getAllAdvertiseRequestes() {
		$requests = AdvertiseRequestes::select('id', 'name', 'email', 'message', 'read')->orderBy('id', 'desc')->get();
		return $requests;
	}
	
	protected static function set($key, $value)
    {
        $setting = Settings::where('name', $key)->first();

        if ( ! $setting) {
            $setting = new Settings(['name' => $key]);
        }

        $setting->value = $value;
        $setting->save();

        return $setting;
    }
	
	protected function addLangaugeValues($lang_code, $file, $new_value){
		App::setLocale($lang_code);
		$language_current = Lang::get($file);
		foreach($new_value as $key => $value){
			$language_current = array_add($language_current, $key, $value);
		}
		
		foreach($language_current as $key1 => $value1){
			$new_language_values[] = "\t\t'". addslashes($key1) . "' => '" . addslashes($value1) . "',";
	    }
		
		$new_language_values = implode("\n", $new_language_values);
	    $new_language_values = "<?php\n\nreturn [\n\n$new_language_values \n\n ];";
		
		File::put(base_path('resources' .DIRECTORY_SEPARATOR. 'lang' . DIRECTORY_SEPARATOR . $lang_code) . DIRECTORY_SEPARATOR . $file . '.php', $new_language_values);

	}

	protected function editLangaugeValues($lang_code, $file, $edit_value){
		App::setLocale($lang_code);
		$language_current = Lang::get($file);
		
		foreach($edit_value as $key => $value){
			$language_current = array_set($language_current, $key, $value);
		}
		
		foreach($language_current as $key1 => $value1){
			$new_language_values[] = "\t\t'". addslashes($key1) . "' => '" . addslashes($value1) . "',";
	    }
		
		$new_language_values = implode("\n", $new_language_values);
	    $new_language_values = "<?php\n\nreturn [\n\n$new_language_values \n\n ];";
		
		File::put(base_path('resources' .DIRECTORY_SEPARATOR. 'lang' .DIRECTORY_SEPARATOR . $lang_code) . DIRECTORY_SEPARATOR . $file . '.php', $new_language_values);

	}

	protected function deleteLangaugeValues($lang_code, $file, $key){
		App::setLocale($lang_code);
		$language_current = Lang::get($file);
		
		unset($language_current[$key]);
		
		foreach($language_current as $key => $value){
			$new_language_values[] = "\t\t'". addslashes($key) . "' => '" . addslashes($value) . "',";
	    }
		
		$new_language_values = implode("\n", $new_language_values);
	    $new_language_values = "<?php\n\nreturn [\n\n$new_language_values \n\n ];";
		
		File::put(base_path('resources'.DIRECTORY_SEPARATOR.'lang' . DIRECTORY_SEPARATOR . $lang_code) . DIRECTORY_SEPARATOR . $file . '.php', $new_language_values);

	}
	
	/**
     * Change app env to production and set debug to false in .env file.
     */
    protected static function putAppEnv($key, $value)
    {
        $content = File::get(base_path('.env'));
		//set given key info while we're editing .env file
		$content = preg_replace("/(.*?" . $key . "=).*?(.+?)\\n/msi", '${1}' . $value . "\n", $content);
        File::put(base_path('.env'), $content);
    }
	
    protected function nowItIsFlat( $arr ) {
        $output = Array();
        foreach( $arr as $key => $val ) {
            if( is_array( $val ) ) {
                $output = array_merge( $output, $val );
            } else {
                $output[$key] = $val;
            }
        }
        return $output;
	}

    protected function sessionMessage($messageTransCode, $messageType){
        session()->flash('messageType', $messageType);
        session()->flash('message', trans($messageTransCode));
    }

    protected function sessionMessagePlain($messageTransCode, $messageType){
        session()->flash('messageType', $messageType);
        session()->flash('message', $messageTransCode);
    }

    protected function recordAdminActivity($activity){
        $log = new AdminLog();
        $log->activity = $activity;
        $log->save();
    }
}
