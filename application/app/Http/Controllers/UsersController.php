<?php

namespace AziziSearchEngineStarter\Http\Controllers;

use AziziSearchEngineStarter\Comments;
use AziziSearchEngineStarter\Http\Requests;
use AziziSearchEngineStarter\Http\Controllers\Controller;
use LaravelLocalization, Auth, Socialite, View, Input, Session, Redirect, Validator, Str, Hash, Mail, File, URL;
use AziziSearchEngineStarter\User;

class UsersController extends Controller
{
	
	// general variables
    // public function __construct() 
    // {
        // $this->middleware('guest');
    // }

    public function login()
    {
		Session::put('previous', URL::previous());
		$settings = $this->getSettings();
		$common = $this->CommonData(false, null, $settings['default']);
        return view('auth.login', $common);
    } 

    public function register()
    {
		$settings = $this->getSettings();
		$common = $this->CommonData(false, null, $settings['default']);
        return view('auth.register', $common);
    }

    public function twoFaChoose()
    {
        $email_2fa = session('email_2fa');
        $phone_2fa = session('phone_2fa');
        $email = session('email');
        $phone = session('phone');
        $settings = $this->getSettings();
        $common = $this->CommonData(false, null, $settings['default']);

        $data = [
            'email'         => $email,
            'phone'         => $phone,
            'phone_2fa'     => $phone_2fa,
            'email_2fa'     => $email_2fa,
            'email_obf'     => $this->hideEmailAddress($email),
            'phone_obf'     => $this->hidePhoneNumber($phone),
        ];
        return view('auth.2fa.choose', array_merge($data, $common));
    }

    public function postTwoFaChoose(){
        $way = Input::get('way');

        if($way == 'email'){
            return Redirect()->route('2fa.email');
        }
        if($way == 'phone'){
            return Redirect()->route('2fa.phone');
        }

        return Redirect()->route('login');
    }

    private function hideEmailAddress($email)
    {
        if(filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            list($first, $last) = explode('@', $email);
            $first = str_replace(substr($first, '2'), str_repeat('*', strlen($first)-3), $first);
            $last = explode('.', $last);
            $last_domain = str_replace(substr($last['0'], '1'), str_repeat('*', strlen($last['0'])-1), $last['0']);
            $hideEmailAddress = $first.'@'.$last_domain.'.'.$last['1'];
            return $hideEmailAddress;
        }
    }

    private function hidePhoneNumber($number)
    {
        return substr($number, 0, 3) . '******' . substr($number, -2);
    }

    public function twoFaPhone()
    {
        $phone_2fa = session('phone_2fa');
        $phone = session('phone');
        $data = [
            'phone'         => $phone,
            'phone_2fa'     => $phone_2fa,
            'phone_obf'     => $this->hidePhoneNumber($phone),
        ];

        $settings = $this->getSettings();
        $common = $this->CommonData(false, null, $settings['default']);
        return view('auth.2fa.phone', array_merge($data, $common));
    }

    public function postTwoFaPhone(){
        if(session('fuid') == Input::get('uid') && session('phone') == Input::get('phone')){
            $username = session('username');
            $password = session('password');
            $attempt = Auth::attempt([
                'username' => $username,
                'password' => $password
            ], true);

            if($attempt){
                return $this->previous('home');
            }
        }

        $this->sessionMessage('validation.loginfail', 'error');
        return Redirect()->route('login')->withInput(Input::all());
    }

    public function twoFaEmail()
    {
        $email_2fa = session('email_2fa');
        $email = session('email');
        $username = session('username');

        if(!session('email_code_sent')) {
            $code = rand(100000, 999999);
            session()->put('email_code', $code);

            if (!$email_2fa) return Redirect()->route('login');

            $this->sendMail(
                'emails.code',  // view
                ['code' => $code], // data
                ['username' => $username, 'email' => $email], // to
                'Verification code' // subject
            );
            session()->put('email_code_sent', true);
        }

		$settings = $this->getSettings();
		$common = $this->CommonData(false, null, $settings['default']);
        $data = [
            'email'         => $email,
            'email_2fa'     => $email_2fa,
            'email_obf'     => $this->hideEmailAddress($email),
        ];
        return view('auth.2fa.email', array_merge($data, $common));
    }

    public function postTwoFaEmail(){
        if(session('email_code') == Input::get('emailCode')){
            $username = session('username');
            $password = session('password');
            $attempt = Auth::attempt([
                'username' => $username,
                'password' => $password
            ], true);

            if($attempt){
                return $this->previous('home');
            }
            // some changes
            $this->sessionMessage('validation.loginfail', 'error');
            return Redirect()->route('login')->withInput(Input::all());
        }

        $this->sessionMessageplain('Incorrect code!', 'error');
        return Redirect()->route('2fa.email')->withInput(Input::all());
    }

    public function postlogin()
    {
		$input = Input::only('username', 'password');
        $attempt = Auth::attempt([
            'username' => $input['username'],
            'password' => $input['password']
        ], Input::has('remember-me'));
        
        if($attempt){
            $user = Auth::user();
		    if(!$user->confirmed){
				Auth::logout();
				$this->sessionMessage('general.emailAddressNotConfirmed', 'error'); // translate : 'Your Email address not confirmed, please check your email inbox or spam, and confirm your email.'
		        return Redirect()->route('login')->withInput(Input::all());
			}

		    if($user->email_2fa || $user->phone_2fa){
                Auth::logout();
		        session()->put('email', $user->email);
		        session()->put('phone', $user->phone_number);
		        session()->put('username', $user->username);
		        session()->put('password', $input['password']);
		        session()->put('email_2fa', $user->email_2fa);
		        session()->put('phone_2fa', $user->phone_2fa);
		        session()->put('fuid', $user->fuid);

                return Redirect()->route('2fa.choose');
            }
			
			return $this->previous('home');
        }
		// some changes
		$this->sessionMessage('validation.loginfail', 'error');
		return Redirect()->route('login')->withInput(Input::all());
    }

    public function postSignup()
    {
        $rules = [
            'username'             => 'required|min:6|unique:users',
            'email'                => 'required|email|unique:users',
            'password'             => 'required|confirmed|min:8',
			// 'g-recaptcha-response' => 'recaptcha',
        ];

        $input = Input::only(
            'username',
            'email',
            'password',
            'password_confirmation'
            // 'g-recaptcha-response',
        );

        $validator = Validator::make($input, $rules);

        if($validator->fails())
        {
            return Redirect::back()->withInput()->withErrors($validator);
        }

		$settings = $this->getSettings();
		$confirmed = 1;
		$confirmation_key = '';

		if($settings['confirmEmail']){
			$confirmed = 0;
			$confirmation_key = str_random(200);
		}

		$user = new User;
		$user->username = Input::get('username');
		$user->email = Input::get('email');
		$user->password = Hash::make(Input::get('password'));
		$user->confirmed = $confirmed;
		$user->confirmation_key = $confirmation_key;
		$user->admin = 0;

		if (!$user->save()){
			$this->sessionMessage('validation.signupfail', 'error');
		    return Redirect()->route('register');
		}

		$siteName = $settings['siteName'];
		$siteEmail = $settings['siteEmail'];

		// confirmation email
		if($settings['confirmEmail']){
			$this->sendMail(
				'emails.confirmation',  // view
				['confirmation_key' => $confirmation_key], // data
				$input, // to
				'Confirm your email address' // subject
			);
		}

		$this->sessionMessage('validation.youraccountcreated', 'success');

        return Redirect()->route('login');
    }

	public function loginFacebook()
    {
        return Socialite::with('facebook')->redirect();
    }

	public function facebookCheck()
    {
        if(Input::has('code')){
			$auser = Auth::user();
			$user = Socialite::with('facebook')->user();
			$_user = User::where('facebookID', '=', $user->id)->first();

			if(Auth::check()){
				if ( ! $_user )
				{
					$auser->facebookID = $user->getId();
					$auser->save();
					$this->sessionMessage('connect.facebook.success', 'success');
				}else{
					if($user->getId() == Auth::user()->facebookID){
						$_user->facebookID = null;
						$_user->save();
						$this->sessionMessage('disconnect.facebook.success', 'success');
					}else{
						$this->sessionMessage('connect.facebook.fail', 'error');
					}
				}
				return $this->previous('profile.edit.info');
			}else{
				if ( ! $_user )
				{
					$email = $user->email ? $user->email : $user->id.'@'.config('app.domain');
					$validator = Validator::make(array('email' => $email), array('email' => 'unique:users,email'));
					if ($validator->fails()) {
						return Redirect::route('login')->withInput()->withErrors($validator);
					}

					$pass = str_random(10);
					$cuser = new User;
					$cuser->username = $user->getName();
					$cuser->email = $email;
					$cuser->password = Hash::make($pass);
					$cuser->facebookID = $user->getId();
					$cuser->confirmed = 1;
					$cuser->admin = 0;
					$cuser->save();
					if (!$cuser->save()){
						$this->sessionMessage('validation.signupfail', 'error');
						return Redirect()->route('login');
					}

					Session::set($cuser->username, $cuser->id);
					$attempt = Auth::login($user = $cuser, false);

					if($attempt){
						return $this->previous('home');
					}else{
						$this->sessionMessage('validation.loginfailus', 'error');
						return Redirect()->route('login');
					}

				}else{
					Session::set($_user->username, $_user->id);
					Auth::login($user = $_user, false);
					return $this->previous('home');
				}
			}
		}else{
			$this->sessionMessage('validation.loginfailus', 'error');
            return Redirect()->route('login');
		}
    }

	public function loginTwitter()
    {
        return Socialite::with('twitter')->redirect();
    }

	public function twitterCheck()
    {
        // if(Input::has('code')){
			$auser = Auth::user();
			$user = Socialite::with('twitter')->user();
			$_user = User::where('twitterID', '=', $user->id)->first();

			if(Auth::check()){
				if ( ! $_user ){
					$auser->twitterID = $user->getId();
					$auser->save();
					$this->sessionMessage('connect.twitter.success', 'success');
				}else{
					if($user->getId() == Auth::user()->twitterID){
						$_user->twitterID = null;
						$_user->save();
						$this->sessionMessage('disconnect.twitter.success', 'success');
					}else{
						$this->sessionMessage('connect.twitter.fail', 'error');
					}
				}
				return $this->previous('profile.edit.info');
			}else{
				if ( ! $_user )
				{
					$email = $user->email ? $user->email : $user->id.'@'.config('app.domain');
					$validator = Validator::make(array('email' => $email), array('email' => 'unique:users,email'));
					if ($validator->fails()) {
						return Redirect::route('login')->withInput()->withErrors($validator);
					}

					$pass = str_random(10);
					$cuser = new User;
					$cuser->username = $user->getName();
					$cuser->email = $email;
					$cuser->password = Hash::make($pass);
					$cuser->twitterID = $user->getId();
					$cuser->confirmed = 1;
					$cuser->admin = 0;
					$cuser->save();
					if (!$cuser->save()){
						$this->sessionMessage('validation.signupfail', 'error');
						return Redirect()->route('login');
					}
					Session::set($cuser->username, $cuser->id);
					$attempt = Auth::login($user = $cuser, false);

					if($attempt){
						return $this->previous('home');
					}else{
						$this->sessionMessage('validation.loginfailus', 'error');
						return Redirect()->route('login');
					}

				}else{
					Session::set($_user->username, $_user->id);
					Auth::login($user = $_user, false);
					return $this->previous('home');

				}
			}
		// }else{
			// $this->sessionMessage('validation.loginfailus', 'error');
            // return Redirect()->route('login');
		// }
    }

	public function loginGoogle()
    {
        return Socialite::with('google')->redirect();
    }

	public function googleCheck()
    {
        if(Input::has('code')){
			$auser = Auth::user();
			$user = Socialite::with('google')->user();
			$_user = User::where('googleID', '=', $user->id)->first();

			if(Auth::check()){
				if ( ! $_user )
				{
					$auser->googleID = $user->getId();
					$auser->save();
					$this->sessionMessage('connect.google.success', 'success');
				}else{
					if($user->getId() == Auth::user()->googleID){
						$_user->googleID = null;
						$_user->save();
						$this->sessionMessage('disconnect.google.success', 'success');
					}else{
						$this->sessionMessage('connect.google.fail', 'error');
					}
				}
				return $this->previous('profile.edit.info');
			}else{
				if ( ! $_user )
				{
					$email = $user->email ? $user->email : $user->id.'@'.config('app.domain');
					$validator = Validator::make(array('email' => $email), array('email' => 'unique:users,email'));
					if ($validator->fails()) {
						return Redirect::route('login')->withInput()->withErrors($validator);
					}

					$pass = Str::random(10);
					$cuser = new User;
					$cuser->username = $user->getName();
					$cuser->email = $email;
					$cuser->password = Hash::make($pass);
					$cuser->googleID = $user->getId();
					$cuser->confirmed = 1;
					$cuser->admin = 0;
					$cuser->save();
					if (!$cuser->save()){
						$this->sessionMessage('validation.signupfail', 'error');
						return Redirect()->route('login');
					}
					Session::set($cuser->username, $cuser->id);
					$attempt = Auth::login($user = $cuser, false);

					if($attempt){
						return $this->previous('home');
					}else{
						$this->sessionMessage('validation.signupfail', 'error');
						return Redirect()->route('login');
					}

				}else{
					Session::set($_user->username, $_user->id);
					Auth::login($user = $_user, false);
					return $this->previous('home');
				}
			}
		}else{
			$this->sessionMessage('validation.loginfailus', 'error');
            return Redirect()->route('login');
		}
    }
	

	//*******************************************
    public function confirm($confirmation_code)
    {
        $user = User::where('confirmation_key', '=', $confirmation_code)->first();

        if ( ! $user)
        {
            return abort(404);
        }

        $user->confirmed = 1;
        $user->confirmation_key = null;
        
		if(!$user->save()){
			$this->sessionMessage('validation.saveDataBaseError', 'error'); // an error occured.
			return Redirect()->route('login');
		}

		$settings = $this->getSettings();
		
		// welcome email
		if($settings['welcomeEmail']){
			$this->sendMail(
				'emails.welcome',  // view
				[], // data
				[
					'username' => $user->username,
					'email'	   => $user->email,
				], // to
				'Welcome' // subject
			);
		}

		$this->sessionMessage('validation.emailConfirmed', 'success'); // Thank you! you email has been confirmed, you can login now
        return Redirect()->route('login');
    }  
	
	public function logout()
    {
        Auth::logout();
        return Redirect()->route('login');
    }

    public function profileEdit()
    {
		$user = Auth::user();
		$settings = $this->getSettings();
		$common = $this->CommonData(false, null, $settings['default']);
		
		$data1 = [
			'user' => $user,
		];
		
		$data = array_merge($data1, $common);
        return view('auth.profile.editInfo', $data);
    }

    public function profileEditPass()
    {
		$user = Auth::user();
		$settings = $this->getSettings();
		$common = $this->CommonData(false, null, $settings['default']);
		
		$data1 = [
			'user' => $user,
		];
		
		$data = array_merge($data1, $common);
        return view('auth.profile.editPass', $data);
    }

    public function postProfileEditPass(){
		
		if(Input::has('submitEditPass')){
			
			$input = Input::only(
				'password',
				'new_password',
				'new_password_confirmation'
			);
			
			$validator = Validator::make($input, [
				'password' => 'required',
				'new_password' => 'min:6|confirmed|different:password',
			]);

			if($validator->fails())
			{
				return Redirect::route('profile.edit.pass')->withInput()->withErrors($validator);
			}
			
			if(!Hash::check($input['password'], Auth()->user()->password)){
				$this->sessionMessage('validation.oldPassNotTrue', 'error'); // Old password not correct
                return Redirect()->route('profile.edit.pass');
            }
		
            $user = Auth::user();
            $user->password = Hash::make($input['new_password']);
            $user->save();
			$this->sessionMessage('validation.yourPassUpdated', 'success'); // your password updated			
			return Redirect()->route('profile.edit.pass');
		}
		
		$this->sessionMessage('validation.yourInfoUpdated', 'success'); // your information updated.
        return Redirect()->route('profile.edit.pass');
		
	}
	
    public function postProfileEdit(){
        $user = Auth::user();
		if(Input::has('submitEdit2fa')){
		    $user->email_2fa = (boolean) Input::get('email_2fa');
		    $user->phone_2fa = (boolean) Input::get('phone_2fa');
            if($user->phone_number != Input::get('phone') && Input::has('uid')){
                $user->fuid = Input::get('uid');
                $user->phone_number = Input::get('phone');
            }

            $user->save();
        }
		if(Input::has('submitEditInfo')){

			$input = Input::only(
				'username',
				'email'
			);

			$rules = [];
			$inputRules = [];
			if($user->username != $input['username']){
				$rules = array_add($rules, 'username', 'required|min:6|unique:users');
				$inputRules = array_add($inputRules, 'username', $input['username']);
			}
			if($user->email != $input['email']){
				$rules = array_add($rules, 'username', 'required|email|unique:users');
				$inputRules = array_add($inputRules, 'email', $input['email']);
			}
			
			$validator = Validator::make($inputRules, $rules);

			if($validator->fails())
			{
				return Redirect::route('profile.edit.info')->withInput()->withErrors($validator);
			}
			
			if($user->username != $input['username']){
				$user->username = $input['username'];
			}
			
			if($user->email != $input['email']){
				
				$settings = $this->getSettings();
				$confirmed = 1;
				$confirmation_key = '';
				
				if($settings['confirmEmail']){
					$confirmed = 0;
					$confirmation_key = str_random(200);
				}
				
				$user->email = $input['email'];
				$user->confirmed = $confirmed;
				$user->confirmation_key = $confirmation_key;
				// confirmation email
				if($settings['confirmEmail']){
					$this->sendMail(
						'emails.confirmation',  // view
						['confirmation_key' => $confirmation_key], // data
						$input, // to
						'Confirm your new email address' // subject
					);
				}
				
			}
			
			$user->save();
		}
		
		$this->sessionMessage('validation.yourInfoUpdated', 'success'); // your information updated.
        return Redirect()->route('profile.edit.info');
    }
	
	public function uploadThumbnail(){
		$user = Auth::user();
		
		if (Input::file('thumbnail')->isValid()){
			$destinationPath = storage_path('app/public/users/' .$user->id . '/thumbnails/'); // upload path
			$extension = Input::file('thumbnail')->getClientOriginalExtension(); // getting image extension
			$fileName = 'thumbnail-'.str_random(40).'.'.$extension; // renameing image
			Input::file('thumbnail')->move($destinationPath, $fileName);
			$fileUrl = url('application/storage/app/public/users/' .Auth::user()->id . '/thumbnails/'.$fileName);
			$user->img = $fileUrl;
			$user->save();
			
			$array = ['msg' => 'The thumbnail updated.', 'src' => $fileUrl];
			return json_encode($array);
		}else{
			return response('The thumbnail not valid', 500);
		}
    }

    public function numOfComments(){
        return Comments::where('engine_id', Input::get('engine'))->where('url', Input::get('url'))->where('reply', 0)->count();
    }

    public function comments(){

        $replies = 0;
        if(in_array(Input::get('r', 0), [0,1]))
            $replies = Input::get('r', 0);
//        dd($replies);
        if($replies == 1) {
            $comments = Comments::where('engine_id', Input::get('engine'))->where('url', Input::get('url'))->where('reply', $replies)->where('comment_id', Input::get('comment'))->ordered()->paginate(10);
        }else{
            $comments = Comments::where('engine_id', Input::get('engine'))->where('url', Input::get('url'))->where('reply', 0)->ordered()->paginate(10);
        }

        $showPages = false;
        if($comments->lastPage() > Input::get('page', 1)){
            $showPages = true;
        }


        $data = [
            'page'  => Input::get('page', 1),
            'showPages'  => $showPages,
            'replies'  => $replies,
            'url' => Input::get('url'),
            'comment_id' => Input::get('comment'),
            'comments' => $comments,
        ];

        return view('auth.profile.comments', $data);
    }

    public function postComment(){
        if(!Input::has('comment')) return response('Please enter a comment', 500);
        $user = Auth::user();
        $url = Input::get('url');
        $engine = Input::get('engine');
        $comment = Input::get('comment');
        $reply = Input::get('reply');
        $comment_id = Input::get('comment_id');

        $newComment = new Comments();

        $newComment->url = $url;
        $newComment->comment = $comment;
        $newComment->reply = $reply;
        $newComment->comment_id = $comment_id;
        $newComment->user_id = $user->id;
        $newComment->engine_id = $engine;

        $newComment->save();

        $data = [
            'comment' => $newComment,
            'comment_id' => $comment_id,
            'reply' => $reply,
        ];
        return view('auth.profile.comment-prepend', $data);
    }
}
