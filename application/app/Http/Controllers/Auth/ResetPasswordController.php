<?php

namespace AziziSearchEngineStarter\Http\Controllers\Auth;

use AziziSearchEngineStarter\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use AziziSearchEngineStarter\Pass;
use AziziSearchEngineStarter\User;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getEmail(Request $request)
    {
		$settings = $this->getSettings();
		$common = $this->CommonData(false, null, $settings['default']);
		return view('auth.passwords.email', $common);
	}
	
    public function postEmail(Request $request)
    {
		$settings = $this->getSettings();
		
		$siteName = $settings['siteName'];
		$siteEmail = $settings['siteEmail'];
		
        $this->validate($request, ['email' => 'required|email']);

        $response = Password::sendResetLink($request->only('email'), function (Message $message) {
            $message->subject($siteName.' - '.trans('emails.emailrestpass'))
					->from($siteEmail, $siteName);
        });

        switch ($response) {
            case Password::RESET_LINK_SENT:
                return redirect()->route('password.reset')->with(['message' => trans($response), 'messageType' => 'success']);

            case Password::INVALID_USER:
                return redirect()->route('password.reset')->withErrors(trans($response));
        }
    }

    /**
     * Display the password reset view for the given token.
     *
     * @param  string  $token
     * @return \Illuminate\Http\Response
     */
    public function getReset($token = null)
    {
		$settings = $this->getSettings();
		$common = $this->CommonData(false, null, $settings['default']);
		$password_resets = Pass::where('token', '=', $token)->first();
        if (is_null($token) or !$password_resets) {
            return abort(404);
        }
        return view('auth.passwords.reset', $common)->with('token', $token);
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postReset(Request $request)
    {
        $this->validate($request, [
            'token' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $credentials = $request->only('password', 'token');

		$user = $this->getUser($credentials['token']);

		if( ! $user) return redirect()->route('login')->withErrors(['email' => trans('passwords.user')]);
		     
        $response = $this->resetPassword($user, $credentials['password']);
		
        switch ($response) {
            case Password::PASSWORD_RESET:
			    $this->deleteToken($credentials['token']);
                return redirect($this->redirectPath())->with('messageType', 'success')->with('message', trans($response));

            default:
                return redirect()->route('login')->withErrors(['email' => trans($response)]);
        }
		
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @param  string  $password
     * @return void
     */
    protected function resetPassword($user, $password)
    {
        $user->password = bcrypt($password);

        if( ! $user->save() ) return 'passwords.error';
		
		return 'passwords.reset';

        // Auth::login($user);
    }

    /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    public function redirectPath()
    {
        return route('login');
    }
	
	protected function getUser($token){
		
		$password_resets = Pass::where('token', '=', $token)->first();
		
		if( ! $password_resets ) return redirect()->back()->withErrors(['email' => trans('passwords.token')]);
		
		$user = User::where('email', $password_resets->email)->first();
		
		return $user;
	}
	
	protected function deleteToken($token){
		
		Pass::where('token', '=', $token)->delete();
	}
}
