<?php

namespace AziziSearchEngineStarter\Http\Controllers\Auth;

use AziziSearchEngineStarter\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Input, Auth, Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }
	
	public function showLoginForm(){
		$settings = $this->getSettings();
		$common = $this->CommonData(false, null, $settings['default']);
		return view('auth.login', $common);
	}
	
	public function login(){
		
		$input = Input::only('username', 'password');
        
		$attempt_credentials = [
            'username' => $input['username'],
            'password' => $input['password'],
        ];
		
        $attempt = Auth::attempt($attempt_credentials, Input::has('remember-me'));

        if($attempt){
			return Redirect()->action('GeneralController@index');
        }
		
		Session::flash('messageType', 'error');
		Session::flash('message', 'Could not log you in. Invalid username or password.');
		
		return redirect()->action('Auth\LoginController@showLoginForm');
	
	}
	
	public static function logout(){
		
		Auth::logout();
		return Redirect()->action('GeneralController@index');
	}
	
}
