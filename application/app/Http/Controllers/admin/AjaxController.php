<?php

namespace AziziSearchEngineStarter\Http\Controllers\admin;

use Illuminate\Http\Request;
use AziziSearchEngineStarter\Http\Controllers\admin\Controller;
use AziziSearchEngineStarter\Advertisements;
use AziziSearchEngineStarter\User;
use Input, Artisan, DB;

class AjaxController extends Controller
{
    public function systemMode(){
		$mode = Input::get('mode');
		// check if mode has valid value
		if(in_array($mode, ['local', 'production'])){
			$this->putAppEnv('APP_ENV', $mode);
		}else{
			return response('There is an error.', 500);
		}
		if($mode == 'local'){
			$this->putAppEnv('APP_DEBUG', 'true');
			$this->putAppEnv('CACHE_ENABLED', 'false');
			Artisan::call('route:clear');
			Artisan::call('view:clear');
			Artisan::call('config:clear');
			Artisan::call('cache:clear');
			// paypal
//			 $this->putAppEnv('PAYPAL_MODE', 'sandbox');
			// stripe
//			 $this->putAppEnv('PAYPAL_MODE', 'pk_test_ZrhGoIgLO32eY8C3UQDqbfic');
		}else{
			$this->putAppEnv('APP_DEBUG', 'false');
			$this->putAppEnv('CACHE_ENABLED', 'true');
			Artisan::call('optimize');
		}
	}

	public function makeNotficationsRead(){
        DB::table('notifications')->update(['read' => 1]);
        return 'marked read!';
    }
	
	public function approveAd(){
		$ad = Advertisements::find(Input::get('adId'));
		if(!$ad)
			return response('There is no ad to approve.', 500);
		
		$ad->approve();
		
		// must sent email to user
		
		return response('Ad approved.', 200);
	}
	
	public function users(){
		if(Input::has('q')){
			$users = User::where('username', 'like', '%' . Input::get('q') . '%')->paginate(10);
		}else{
			$users = User::paginate(10);
		}
		
		$ArrJson = [];
		foreach($users as $user){
			array_push($ArrJson, ['id' => $user->id, 'text' => $user->username . ' ('. $user->email . ')']);
		}
		
		return response()->json(['results' => $ArrJson]);
		// must sent email to user
		
		return response('Ad approved.', 200);
	}
}
