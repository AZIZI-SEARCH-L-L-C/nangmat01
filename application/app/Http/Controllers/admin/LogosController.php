<?php

namespace AziziSearchEngineStarter\Http\Controllers\admin;

use AziziSearchEngineStarter\Http\Controllers\admin\Controller;
use AziziSearchEngineStarter\Engines;
use AziziSearchEngineStarter\Logos;
use Carbon\Carbon;
use Input, Validator, File, Session, Cache;

class LogosController extends Controller
{
    
	public function getAll(){
		
		$data1 = $this->CommonData();
		$data2 = [
		    'engines' => $this->Engines(),
		    'logos'   => $this->getLogos(),
		    'upload'  => false,
		    'engine'  => null,
		];
		
		$data = array_merge($data1, $data2);
		return view('admin.logos', $data);
	}
    
	public function get($name){
		
		$engine = Engines::where('name', $name)->first();
		if(!$engine) return redirect()->action('admin\LogosController@getAll');
		
		$data1 = $this->CommonData();
		$data2 = [
		    'engines' => $this->Engines(),
		    'logos'   => $this->getLogosWhere($name),
		    'upload'  => true,
		    'engine'  => $name,
		];
		
		$data = array_merge($data1, $data2);
		return view('admin.logos', $data);
	}
    
	public function postAll(){
		
		$errors = false;
		if(Input::has('submitDelete')){
			
			$logo = Logos::where('id', Input::get('logoId'))->first();
			if($logo){
				$myfile = $logo->content;
			}else{
				$errors = true;
				Session::flash('messageType', 'error');
			    Session::flash('message', 'Can\'t find the logo, please try again.');
			}
			
			if(!$errors){
			    if(File::exists($logo->content)){
				     File::delete($logo->content);
				}
				$logo->delete();
			}
		}
		
		if(Input::has('submitSettings')){
			
			// check if resultsInfo has valide value
			if(in_array(Input::get('rotationTime'), [60, 3600, 86400, 604800, 2592000])){
				$this->set('ChangeLogoTime', Input::get('rotationTime'));
			}
		}
		
		if(Input::has('submitDefaultLogo')){
			
			if(Input::get('defaultLogoType') == 1){
				if (Input::file('DefaultLogoImage')->isValid()) {
					$destinationPath = 'imgs/general'; // upload path
					$extension = Input::file('DefaultLogoImage')->getClientOriginalExtension(); // getting image extension
					$fileName = 'logo-'.rand(11111, 99999).'.'.$extension; // renameing image
					Input::file('DefaultLogoImage')->move($destinationPath, $fileName);
					$this->set('defaultLogoType', 1);
				    $this->set('defaultLogoContent', $destinationPath.'/'.$fileName);
				}
			}elseif(Input::get('defaultLogoType') == 0){
				$this->set('defaultLogoType', 0);
				$this->set('defaultLogoContent', Input::get('DefaultLogoText'));
			}
			
		} 
		
		if(!$errors){
			Session::flash('messageType', 'success');
			Session::flash('message', 'All changes have been changed.');
		}
		
		Cache::flush();
		return redirect()->action('admin\LogosController@getAll');
	}
	
	public function addLogoText ($name){
		
		    if(!Input::has('text')) return redirect()->action('admin\LogosController@get', ['name' => $name]);
		
		    $logo = new Logos();
			$logo->engine_name = $name;
			$logo->type        = 0;
			$logo->content     = Input::get('text');
			$logo->active      = 1;
            $logo->starts      = Carbon::parse(Input::get('startDate') .' '. Input::get('startTime'))->toDateTimeString();
            $logo->ends        = Carbon::parse(Input::get('endDate') .' '. Input::get('endTime'))->toDateTimeString();
			if (!$logo->save()){
				Session::flash('messageType', 'success');
			    Session::flash('message', 'logo text can\'t be saved to database, please try again.');
				return redirect()->action('admin\LogosController@getAll');
			}
			
			Session::flash('messageType', 'success');
			Session::flash('message', 'All changes have been changed.');
			
			Cache::flush();
	        return redirect()->action('admin\LogosController@get', ['name' => $name]);
	}
    
	public function post($name){
		
		$errors = false;
		$engine = Engines::where('name', $name)->first();
		if(!$engine) return redirect()->action('admin\LogosController@getAll');
		
		if(Input::has('submitDelete')){
			
			$logo = Logos::where('id', Input::get('logoId'))->first();
			if($logo){
				$myfile = $logo->content;
			}else{
				$errors = true;
				Session::flash('messageType', 'error');
			    Session::flash('message', 'Can\'t find the logo, please try again.');
			}
			
			if(!$errors){
			    if(File::exists($logo->content)){
				     File::delete($logo->content);
				}
				$logo->delete();
			}
		}
		
		if(!$errors){
			Session::flash('messageType', 'success');
			Session::flash('message', 'All changes have been changed.');
		}
		
		Cache::flush();
		return redirect()->action('admin\LogosController@getAll');
	}
	
	public function upload ($name){

		$engine = Engines::where('name', $name)->first();
		if(!$engine) return response('Engine name not valid.', 500);
		
		// getting all of the post data
		$file = array('image' => Input::file('file'));
		// setting up rules
		$rules = array('image' => 'required|mimes:jpeg,bmp,png'); //mimes:jpeg,bmp,png and for max size max:10000
		// doing the validation, passing post data, rules and the messages
		$validator = Validator::make($file, $rules);
		if ($validator->fails()) {
		    // send back to the page with the input data and errors
			$errors = null;
			foreach($validator->errors()->all() as $error){
				$errors .= ' + ' . $error;
			}
			return response($errors, 500);
		    // return Redirect::to('upload')->withInput()->withErrors($validator);
		}
		
		if (Input::file('file')->isValid()) {
		    $destinationPath = 'imgs/'.$name; // upload path
		    $extension = Input::file('file')->getClientOriginalExtension(); // getting image extension
		    $fileName = 'logo-'.rand(11111,99999).'.'.$extension; // renameing image
		    Input::file('file')->move($destinationPath, $fileName); // uploading file to given path
		    // sending back with message
			$logo = new Logos();
			$logo->engine_name = $name;
			$logo->type        = 1;
			$logo->content     = $destinationPath.'/'.$fileName;
			$logo->active      = 1;
			$logo->starts      = Carbon::parse(Input::get('startDate') .' '. Input::get('startTime'))->toDateTimeString();
			$logo->ends        = Carbon::parse(Input::get('endDate') .' '. Input::get('endTime'))->toDateTimeString();
			if (!$logo->save()) return response('file can\'t be saved to database, please try again.', 200);
		    return response('Upload successfully.', 200);
		}else{
			return response('uploaded file is not valid.', 500);
		}
		
		Cache::flush();
	}
	
	public static function getLogos(){
		$logos = Logos::get()->toArray();
		return $logos;
	}
	
	public static function getLogosWhere($name){
		$logos = Logos::where('engine_name', $name)->get()->toArray();
		return $logos;
	}
}
