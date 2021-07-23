<?php

namespace AziziSearchEngineStarter\Http\Controllers\admin;

use Illuminate\Http\Request;

use AziziSearchEngineStarter\Http\Requests;
use AziziSearchEngineStarter\Http\Controllers\admin\Controller;
use AziziSearchEngineStarter\Engines;
use Input, Session, File, cache;

class DeleteController extends Controller
{
    
	private $Controller;

    public function __construct(Controller $Controller)
    {
        $this->Controller = $Controller;
    }
    
	public function get($name){
		
		$data1 = $this->CommonData();
		$data2 = [
		    'name' => $name,
		];
		
		$data = array_merge($data1, $data2);
		return view('admin.delete', $data);
	}
	
	public function post($name){
		$errors = false;
		if(Input::has('submitDelete')){
			
			$settings = $this->Controller->getSettings();
			if($settings['default'] == $name){
				Session::flash('messageType', 'error');
			    Session::flash('message', 'this engine is the default engine, please change the default engine and try again.');
				$errors = true;
			}
			
			$engine = Engines::where('name', $name)->first();
            if ( ! $engine) {
                Session::flash('messageType', 'error');
			    Session::flash('message', 'this engine doesn\'t exist, please try again.');
				$errors = true;
            }
			
			if(!$errors){
				$ControllerName = ucfirst($name).'Controller';
				File::delete(app_path('Http'. DIRECTORY_SEPARATOR .'Controllers'. DIRECTORY_SEPARATOR .$ControllerName.'.php'));
				File::delete(base_path('resources'. DIRECTORY_SEPARATOR .'views'. DIRECTORY_SEPARATOR .'engines'. DIRECTORY_SEPARATOR .$name.'.blade.php'));
				$this->deleteLangaugeValues('en', 'engines', $name);
				$engine->delete();
			}
			
		    if(!$errors){
			    Session::flash('messageType', 'success');
			    Session::flash('message', 'this engine has been deleted, please click return to return Manage engines.');
		    }
			
			Cache::flush();
			return redirect()->action('admin\EnginesController@get');
		}
	}
}
