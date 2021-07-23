<?php

namespace AziziSearchEngineStarter\Http\Controllers\Auth;

use AziziSearchEngineStarter\User;
use Validator;
use AziziSearchEngineStarter\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Mail;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
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
        $this->middleware('guest');
    }
	
	public function showRegistrationForm(){
		$settings = $this->getSettings();
		$common = $this->CommonData(false, null, $settings['default']);
		return view('auth.register', $common);
	}

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => 'required|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
		$settings = $this->getSettings();
		$confirmation_key = str_random(220);

		$confirmed = 0;
		if(!$settings['confirmEmail']){
			$confirmed = 1;
			$confirmation_key = null;
		}
		
		$user = User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'confirmed'  => $confirmed,
            'confirmation_key'  => $confirmation_key,
            'admin'  => 0,
        ]);
		
		if (!$user->save()){ 
		   Session::flash('messageType', 'error');
		   Session::flash('message', 'validation.signupfail');
		   return Redirect()->route('login');
		}
		
		$siteName = $settings['siteName'];
		$siteEmail = $settings['siteEmail'];
		
		// confirmation email
		if($settings['confirmEmail']){
			Mail::send('emails.confirmation', ['confirmation_key' => $confirmation_key], function($message) use ($siteName, $siteEmail, $data) {
				$message->from($siteEmail, $siteName);
				$message->to($data['email'], $data['username']);
				$message->subject($siteName.' - '.'Confirm your email address');
			});
		}
		
		// welcome email
		if($settings['welcomeEmail']){
			Mail::send('emails.welcome', $data, function($message) use ($siteName, $siteEmail, $data) {
				$message->from($siteEmail, $siteName);
				$message->to($data['email'], $data['username']);
				$message->subject('Welcome to ' . $siteName);
			});
		}
		
		return $user;
    }
}
