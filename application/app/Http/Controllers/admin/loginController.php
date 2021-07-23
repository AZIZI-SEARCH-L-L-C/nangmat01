<?php

namespace AziziSearchEngineStarter\Http\Controllers\admin;

use Illuminate\Http\Request;

use AziziSearchEngineStarter\Http\Requests;
use AziziSearchEngineStarter\Http\Controllers\admin\Controller;
use Input, Auth, Session;

class loginController extends Controller
{
    
	public static function get(){
		
		$data = [
		    'error' => false,
		];
		return view('admin.login', $data);
	}
    
	public static function post(){
		
		$input = Input::only('username', 'password');
        
		$attempt_credentials = [
            'username' => $input['username'],
            'password' => $input['password'],
            'admin'    => 1,
        ];
		
        $attempt = Auth::attempt($attempt_credentials, Input::has('remember-me'));

        if($attempt){
			return Redirect()->action('admin\DashboardController@get');
        }
		
		$data = array(
		    'error'       => true,
		    'messageType' => 'error',
		    'message'     => 'Could not log you in. Invalid username or password.',
		);
		return view('admin.login', $data);
	
	}
	
	public static function logout(){
		Auth::logout();
		return Redirect()->action('admin\loginController@get');
	}
	
}
