<?php

namespace AziziSearchEngineStarter\Http\Controllers\admin;

use Illuminate\Http\Request;

use AziziSearchEngineStarter\Http\Requests;
use AziziSearchEngineStarter\Http\Controllers\admin\Controller;
use AziziSearchEngineStarter\Engines;
use AziziSearchEngineStarter\Settings;
use Session, Input, File, Artisan, Cache;

class EnginesController extends Controller
{
    
	public function get(){
		
		$data1 = $this->CommonData();
		$data2 = [
			'engines' => $this->Engines(),
		];
		
		$data = array_merge($data1, $data2);
		return view('admin.engines.all', $data);
	}
    
	public function getEdit($name){
		$engine = Engines::where('name', $name)->first();
		if ( ! $engine) {
			abort(404);
		}
		
		$data1 = $this->CommonData();
		$data2 = [
			'engines' => $this->Engines(),
			'engine'  => $engine,
		];
		
		$data = array_merge($data1, $data2);
		return view('admin.engines.edit', $data);
	}
	
    public function post(){
		
		$enginesNames = $this->getEnginesNames();
		$settings = $this->getSettings();
		$errors = false;
		if(Input::has('submitEdit')){
			
			$input = Input::Only('EngineName', 'key', 'active', 'name');
		    $values = [];
		    $values['name'] = $input['EngineName'];
		    $values['key']  = $input['key'];
		    $values['turn'] = (int) boolval($input['active']);
			
			$engine = $this->Engine($input['name']);
			
			$controllerToEditPath = app_path('Http'. DIRECTORY_SEPARATOR .'Controllers'. DIRECTORY_SEPARATOR .$engine->controller .'.php');
			$controllerToEdit = File::get($controllerToEditPath);
			$controllerEdited = preg_replace(['/\''.$input['name'].'\'/'], ['\''.$input['EngineName'].'\''], $controllerToEdit);
			File::put($controllerToEditPath, $controllerEdited);
			$this->addLangaugeValues('en', 'engines', [$input['EngineName'] => ucfirst($input['EngineName'])]);
			
			// set new engine as defualt if the was default
			if($settings['default'] == $input['name']){
				$this->set('default', $input['EngineName']);
			}


			$this->setEngine($input['name'], $values);
			
		}
		
		if(Input::has('submitOrder') && Input::has('order')){

			$input = Input::only('order');
			
			$order = json_decode($input['order']);
			
			$i = 99999;
			foreach($order as $value){
				$this->setEngine($value->name, ['order' => $i]);
				$i++;
			}
			
			foreach($order as $key => $value){
				$this->setEngine($value->name, ['order' => $key]);
			}
			
		}
		
		if(Input::has('submitDefaultEngine')){
			$input = Input::only('defaultEngine');
			// check if default engine is already exist
		    if(in_array($input['defaultEngine'], $enginesNames)){
				$this->set('default', $input['defaultEngine']);
			}
		}

		if(Input::has('submitEditSettings')){
		    if(Input::get('keepfilters') == 'on'){
				$this->set('keepfilters', 1);
			}else{
                $this->set('keepfilters', 0);
            }
		}
		
		if(!$errors){
		    Session::flash('messageType', 'success');
		    Session::flash('message', 'All changes have been changed.');
		}
		
		Cache::flush();
		return redirect()->action('admin\EnginesController@get');
	}
	
    public function postEdit($name){

	    $engine = Engines::where('name', $name)->first();
	    if(!$engine) abort(404);

		$enginesNames = $this->getEnginesNames();
		$errors = false;

        // check if active is On
        if(Input::get('active') == 'on'){
            $engine->turn = 1;
        }else{
            $engine->turn = 0;
        }
        $engine->save();

        // check if perPage has valide value
        if(is_numeric(Input::get('perPage' . ucfirst($engine->name)))){
            $this->set('perPage' . ucfirst($engine->name), Input::get('perPage' . ucfirst($engine->name)));
        }

        if(Input::get($name.'Pagination')){
            $this->set($name.'Pagination', Input::get($name.'Pagination'));
        }

//        dd([
//            Input::get($name.'Pagination'),
//            Input::get($name.'PaginationFull'),
//            Input::get($name.'PaginationLimit'),
//        ]);

        if(Input::get($name.'Pagination') == 2){
            if(Input::get($name.'PaginationFull') == 'on') {
                $this->set($name . 'PaginationFull', 1);
            }else{
                $this->set($name . 'PaginationFull', 0);
                if(Input::has($name.'PaginationLimit')){
                    $this->set($name . 'PaginationLimit', Input::get($name.'PaginationLimit'));
                }
            }
        }

        if($name == 'web'){
            // check if dateFilter is On
            if(Input::get('dateFilter') == 'on'){
                $this->set('dateFilter', 1);
            }else{
                $this->set('dateFilter', 0);
            }

            // check if googleWebCsePublicKey has valide value
            if(Input::has('googleWebCsePublicKey')){
                $this->set('googleWebCsePublicKey', Input::get('googleWebCsePublicKey'));
            }

            // check if countryFilter is On
            if(Input::get('countryFilter') == 'on'){
                $this->set('countryFilter', 1);
            }else{
                $this->set('countryFilter', 0);
            }

            if(is_array(Input::get('countries'))){
                $this->set('countries', implode(',', Input::get('countries')));
            }

            if(is_array(Input::get('firstCountries'))){
                $this->set('firstCountries', implode(',', Input::get('firstCountries')));
            }

            // check if documentsFilter is On
            if(Input::get('documentsFilter') == 'on'){
                $this->set('documentsFilter', 1);
            }else{
                $this->set('documentsFilter', 0);
            }

            if(is_array(Input::get('fileTypes'))){
                $this->set('fileTypes', implode(',', Input::get('fileTypes')));
            }

            // check if imagesAllturn is On
            if(Input::get('imagesAllturn') == 'on'){
                $this->set('imagesAllturn', 1);
            }else{
                $this->set('imagesAllturn', 0);
            }

            // check if newsAllturn is On
            if(Input::get('newsAllturn') == 'on'){
                $this->set('newsAllturn', 1);
            }else{
                $this->set('newsAllturn', 0);
            }

            // check if videosAllturn is On
            if(Input::get('videosAllturn') == 'on'){
                $this->set('videosAllturn', 1);
            }else{
                $this->set('videosAllturn', 0);
            }

            // check if imagesPosition has valide value
            if(is_numeric(Input::get('imagesPosition'))){
                $this->set('cacheTime', Input::get('imagesPosition'));
            }

            // check if videosPosition has valide value
            if(is_numeric(Input::get('videosPosition'))){
                $this->set('videosPosition', Input::get('videosPosition'));
            }

            // check if newsPosition has valide value
            if(is_numeric(Input::get('newsPosition'))){
                $this->set('newsPosition', Input::get('newsPosition'));
            }

            // check if mathCalc is On
            if(Input::get('mathCalc') == 'on'){
                $this->set('mathCalc', 1);
            }else{
                $this->set('mathCalc', 0);
            }

            // check if timeZone is On
            if(Input::get('timeZone') == 'on'){
                $this->set('timeZone', 1);
            }else{
                $this->set('timeZone', 0);
            }

            // check if facts is On
            if(Input::get('facts') == 'on'){
                $this->set('facts', 1);
            }else{
                $this->set('facts', 0);
            }

            // check if translations is On
            if(Input::get('translations') == 'on'){
                $this->set('translations', 1);
            }else{
                $this->set('translations', 0);
            }

            // check if entities is On
            if(Input::get('entities') == 'on'){
                $this->set('entities', 1);
            }else{
                $this->set('entities', 0);
            }

            // check if entitiesNum has valide value
            if(is_numeric(Input::get('entitiesNum'))){
                $this->set('entitiesNum', Input::get('entitiesNum'));
            }

            // check if entityTruncate has valide value
            if(is_numeric(Input::get('entityTruncate'))){
                $this->set('entityTruncate', Input::get('entityTruncate'));
            }

            if(is_array(Input::get('entitesAllowed'))){
                $this->set('entitesAllowed', implode(',', Input::get('entitesAllowed')));
            }

        }elseif($name == 'images'){

            // check if googleImagesCsePublicKey has valide value
            if(Input::has('googleImagesCsePublicKey')){
                $this->set('googleImagesCsePublicKey', Input::get('googleImagesCsePublicKey'));
            }

            // check if imgColorFilter is On
            if(Input::get('imgColorFilter') == 'on'){
                $this->set('imgColorFilter', 1);
            }else{
                $this->set('imgColorFilter', 0);
            }

            // check if imgTypeFilter is On
            if(Input::get('imgTypeFilter') == 'on'){
                $this->set('imgTypeFilter', 1);
            }else{
                $this->set('imgTypeFilter', 0);
            }

            // check if imgLicenseFilter is On
            if(Input::get('imgLicenseFilter') == 'on'){
                $this->set('imgLicenseFilter', 1);
            }else{
                $this->set('imgLicenseFilter', 0);
            }

            // check if imgSizeFilter is On
            if(Input::get('imgSizeFilter') == 'on'){
                $this->set('imgSizeFilter', 1);
            }else{
                $this->set('imgSizeFilter', 0);
            }
        }elseif($name == 'videos'){
            // check if videosPricingFilter is On
            if(Input::get('videosPricingFilter') == 'on'){
                $this->set('videosPricingFilter', 1);
            }else{
                $this->set('videosPricingFilter', 0);
            }

            // check if videosLengthFilter is On
            if(Input::get('videosLengthFilter') == 'on'){
                $this->set('videosLengthFilter', 1);
            }else{
                $this->set('videosLengthFilter', 0);
            }

            // check if videosResolutionFilter is On
            if(Input::get('videosResolutionFilter') == 'on'){
                $this->set('videosResolutionFilter', 1);
            }else{
                $this->set('videosResolutionFilter', 0);
            }

        }elseif($name == 'news'){
            // check if newsDateFormat has valide value
            if(in_array(Input::get('newsDateFormat'), [1, 2])){
                $this->set('newsDateFormat', Input::get('newsDateFormat'));
            }

            // check if newsDateFormatform has valide value
            if(Input::has('newsDateFormatform')){
                $this->set('newsDateFormatform', Input::get('newsDateFormatform'));
            }

            // check if newsDateFull is On
            if(Input::get('newsDateFull') == 'on'){
                $this->set('newsDateFull', 1);
            }else{
                $this->set('newsDateFull', 0);
            }

            // check if newsThumbnail is On
            if(Input::get('newsThumbnail') == 'on'){
                $this->set('newsThumbnail', 1);
            }else{
                $this->set('newsThumbnail', 0);
            }

        }


        if(Input::get('apiProviders')){
            $this->putAppEnv(strtoupper($name).'_PROVIDERS', implode(',', Input::get('apiProviders')));
        }

		if(!$errors){
		    Session::flash('messageType', 'success');
		    Session::flash('message', 'All changes have been changed.');
		}
		
		Cache::flush();
		return redirect()->action('admin\EnginesController@getEdit', $name);
	}
	
	
	public static function setEngine($name, $values)
    {
        $engine = Engines::where('name', $name)->first();

        if ( ! $engine) {
            return null;
        }

		foreach($values as $key => $value){
			$engine->{$key} = $value;
		}
        
		$engine->save();

        return $engine;
    }
}
