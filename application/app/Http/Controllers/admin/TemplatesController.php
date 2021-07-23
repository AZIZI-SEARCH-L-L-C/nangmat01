<?php

namespace AziziSearchEngineStarter\Http\Controllers\admin;

use AziziSearchEngineStarter\Http\Controllers\admin\Controller;
use Input, Session, File, Config, Validator, Artisan, Zipper;

class TemplatesController extends Controller
{
    
	public function get(){
		$data1 = $this->CommonData();
		
		$data2 = [
		    'template'       => Config::get('app.template'),
		    'templates'      => $this->getTemplates(),
			'uploadTemplate' => (boolean) Input::get('new'),
		];
		
		$data = array_merge($data1, $data2);
		return view('admin.templates', $data);
	}
	
	public function redirect(){
		return redirect()->action('admin\TemplatesController@get');
	}
	
	public function setTemplate($default){
		
		$input = Input::all();
		
		// check if default template is already exist
		if(in_array($default, $this->getTemplates())){
			$this->putAppEnv('TMPL', $default);
		}
		
		Session::flash('messageType', 'success');
		Session::flash('message', 'All changes have been changed.');
	    return $this->redirect();
		
	}
	
	public function upload(){
	
		// getting all of the post data
		$file = array('template' => Input::file('template'));
		// setting up rules
		$rules = array('template' => 'required|mimes:zip,tar'); //mimes:zip
		// doing the validation, passing post data, rules and the messages
		$validator = Validator::make($file, $rules);
		if ($validator->fails()) {
		    // send back to the page with the input data and errors
			$errors = null;
			foreach($validator->errors()->all() as $error){
				// $errors .= '<br/>' . $error;
				if($error){
					return response($error, 500);
				}
			}
			// return response($errors, 500);
		    // return Redirect::to('upload')->withInput()->withErrors($validator);
		}
		
		if (Input::file('template')->isValid()) {
		    $destinationPath = storage_path('templates'); // upload path
		    $extension = Input::file('template')->getClientOriginalExtension(); // getting image extension
		    $fileName = 'template-'.rand(11111,99999).'.'.$extension; // renameing image
		    Input::file('template')->move($destinationPath, $fileName); // uploading file to given path
		    // sending back with message
			// $logo = new Logos();
			// $logo->engine_name = $name;
			// $logo->type        = 1;
			// $logo->content     = $destinationPath.'/'.$fileName;
			// $logo->active      = 1;
			// if (!$logo->save()) return response('template can\'t be saved to database, please try again.', 200);
			Zipper::make(storage_path('templates'. DIRECTORY_SEPARATOR .$fileName))->extractTo(base_path('../'));
			Artisan::call('migrate', ['--force' => true]);
			Artisan::call('db:seed', ['--force' => true, '--class' => 'TemplateDatabaseSeeder']);
		    return response()->json(['file' => $fileName, 'msg' => 'Upload successfully.']);
		}
		
		return response('uploaded plugin is not valid.', 500);
		
	}
	
	private function getTemplates(){
		$dirs_path = array('resources', 'templates');
		$dir_path = implode(DIRECTORY_SEPARATOR, $dirs_path);
		
		$dirs = File::directories(base_path($dir_path));
		$templates = [];
		
		foreach($dirs as $tmpl){
			$templates[] = str_replace(base_path($dir_path . DIRECTORY_SEPARATOR), '', $tmpl);
		}
		
		if(($key = array_search('admin', $templates)) !== false) {
    		unset($templates[$key]);
		}
		
		if(($key = array_search('plugins', $templates)) !== false) {
    		unset($templates[$key]);
		}
		
		return $templates;
	}
 	
}