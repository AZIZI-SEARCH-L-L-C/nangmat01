<?php

namespace AziziSearchEngineStarter\Http\Controllers\admin;

use Illuminate\Http\Request;
use AziziSearchEngineStarter\Http\Controllers\admin\Controller;
use Config, Zipper, Input, Validator, Artisan, Session, Cache;

class PluginsController extends Controller
{
  
	public function installed(){
		// Config::write('plugins.whatismyip', 'active', false);
		$data = array_merge([
		    'plugins' => config('plugins'),
		    'uploadPlug' => (boolean) Input::get('new'),
		], $this->CommonData());
		
		return view('admin.plugins.installed', $data);
	}
	
	public function activate($plugin){
		$active = config('plugins.'.$plugin.'.active');
		if($active){
			Config::write('plugins.'.$plugin, 'active', false);
		}else{
			Config::write('plugins.'.$plugin, 'active', true);
		}
		return redirect()->action(config('plugins.'.$plugin.'.activeCallback'));
	}
	
	public function changeOption($plugin, $option){
		$active = config('plugins.'.$plugin.'.'.$option);
		if($active){
			Config::write('plugins.'.$plugin, $option, false);
		}else{
			Config::write('plugins.'.$plugin, $option, true);
		}
		Session::flash('messageType', 'success');
		Session::flash('message', 'All changes have been made.');
		return redirect()->action('admin\PluginsController@installed');
	}
  
	public function pluginManifest(){
		$plugin = Input::get('name');
		// Zipper::make(storage_path('plugins/test.zip'))->extractTo(base_path('../foo'));
		$zip = Zipper::make(storage_path('plugins/'.$plugin))->getFileContent('manifest.json');
		$manifest = json_decode($zip, true);
		return $manifest;
	}
  
	public function install(){
        $file = Input::get('file');
        Zipper::make(storage_path('plugins/'.$file))->extractTo(base_path('../'));
        Artisan::call('migrate', ['--force' => true]);
        Artisan::call('db:seed', ['--force' => true, '--class' => 'PluginsDatabaseSeeder']);
        Cache::flush();
        return 'The plugin installed successfully.';
	}
  
	public function upload(){
	
		// getting all of the post data
		$file = array('plugin' => Input::file('plugin'));
		// setting up rules
		$rules = array('plugin' => 'required|mimes:zip,tar'); //mimes:zip
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
		
		if (Input::file('plugin')->isValid()) {
		    $destinationPath = storage_path('plugins'); // upload path
		    $extension = Input::file('plugin')->getClientOriginalExtension(); // getting image extension
		    $fileName = 'plugin-'.rand(11111,99999).'.'.$extension; // renameing image
		    Input::file('plugin')->move($destinationPath, $fileName); // uploading file to given path
		    // sending back with message
			// $logo = new Logos();
			// $logo->engine_name = $name;
			// $logo->type        = 1;
			// $logo->content     = $destinationPath.'/'.$fileName;
			// $logo->active      = 1;
			// if (!$logo->save()) return response('plugin can\'t be saved to database, please try again.', 200);
		    return response()->json(['file' => $fileName, 'msg' => 'Upload successfully.']);
		}else{
			return response('uploaded plugin is not valid.', 500);
		}

	}
	
}
