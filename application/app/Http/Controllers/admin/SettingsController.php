<?php

namespace AziziSearchEngineStarter\Http\Controllers\admin;

use AziziSearchEngineStarter\Http\Controllers\admin\Controller;
use Input, Session, Cache, Log;

class SettingsController extends Controller
{
    
	public function get(){
		// dd(Log::getMonolog());
		$data = array_merge([
		    'locales' => config('locales'),
		], $this->CommonData());
		
		return view('admin.settings', $data);
	}
	
	public function redirect(){
		return redirect()->action('admin\SettingsController@get');
	}
	
	public function post(){
		$input = Input::all();
		$errors = false;
		
		// check if siteName has valide value
		if(Input::has('siteName')){
			$this->set('siteName', $input['siteName']);
		}
		
		// check if siteDescription has valide value
		if(Input::get('siteDescription')){
			$this->set('siteDescription', $input['siteDescription']);
		}

		// check if siteEmail has valide value
		if(Input::get('siteEmail')){
			$this->set('siteEmail', $input['siteEmail']);
		}

		// check if companyName has valide value
		if(Input::get('companyName')){
			$this->set('companyName', $input['companyName']);
		}

		// check if siteDomain has valide value
		if(Input::get('siteDomain')){
			$this->set('siteDomain', $input['siteDomain']);
		}

		// check if resultsTarget has valide value
		if(Input::get('resultsTarget')){
			$this->set('resultsTarget', $input['resultsTarget']);
		}

		// check if cacheTime has valide value
		if(is_numeric(Input::get('cacheTime'))){
			$this->set('cacheTime', $input['cacheTime']);
			$this->set('defferCacheTime', $input['cacheTime']);
		}

		// check if resultsInfo is On
		if(Input::get('resultsInfo') == 'on'){
			$this->set('resultsInfo', 1);
		}else{
            $this->set('resultsInfo', 0);
        }

		// check if keywordsSuggestion is On
		if(Input::get('keywordsSuggestion') == 'on'){
			$this->set('keywordsSuggestion', 1);
		}else{
            $this->set('keywordsSuggestion', 0);
        }

		// check if relatedKeywords is On
		if(Input::get('relatedKeywords') == 'on'){
			$this->set('relatedKeywords', 1);
		}else{
            $this->set('relatedKeywords', 0);
        }

		// check if speachInput is On
		if(Input::get('speachInput') == 'on'){
			$this->set('speachInput', 1);
		}else{
            $this->set('speachInput', 0);
        }

        // check if logNotifications is On
        if(Input::get('logNotifications') == 'on'){
            $this->set('logNotifications', 1);
        }else{
            $this->set('logNotifications', 0);
        }


        if(Input::get('enable_bookmarks') == 'on'){
            $this->set('enable_bookmarks', 1);
        }else{
            $this->set('enable_bookmarks', 0);
        }


        if(Input::get('enable_comments') == 'on'){
            $this->set('enable_comments', 1);
        }else{
            $this->set('enable_comments', 0);
        }

        // check if cache is On
        if(Input::get('cache') == 'on'){
            $this->set('cache', 1);
        }else{
            $this->set('cache', 0);
        }
		
		if(!$errors){
			Session::flash('messageType', 'success');
			Session::flash('message', 'All changes have been changed.');
		}
		
		Cache::flush();
	    return $this->redirect();
		
	}

	public function getSocialLogin(){
        $data = array_merge([

        ], $this->CommonData());

        return view('admin.sociallogin', $data);
    }

    public function postSocialLogin(){
        $errors = false;

        // facebook
        if(Input::get('enable_facebook') == 'on'){
            $this->putAppEnv('FB_ENABLED', 'true');
        }else{
            $this->putAppEnv('FB_ENABLED', 'false');
        }
        if(Input::has('fb_id')){
            $this->putAppEnv('FB_ID', Input::get('fb_id'));
        }
        if(Input::has('fb_secret')){
            $this->putAppEnv('FB_SECRET', Input::get('fb_secret'));
        }

        // twitter
        if(Input::get('enable_twitter') == 'on'){
            $this->putAppEnv('TW_ENABLED', 'true');
        }else{
            $this->putAppEnv('TW_ENABLED', 'false');
        }
        if(Input::has('tw_id')){
            $this->putAppEnv('TW_ID', Input::get('tw_id'));
        }
        if(Input::has('tw_secret')){
            $this->putAppEnv('TW_SECRET', Input::get('tw_secret'));
        }

        // google
        if(Input::get('enable_google') == 'on'){
            $this->putAppEnv('GO_ENABLED', 'true');
        }else{
            $this->putAppEnv('GO_ENABLED', 'false');
        }
        if(Input::has('go_id')){
            $this->putAppEnv('GO_ID', Input::get('go_id'));
        }
        if(Input::has('tw_secret')){
            $this->putAppEnv('GO_SECRET', Input::get('go_secret'));
        }

        if(!$errors){
            Session::flash('messageType', 'success');
            Session::flash('message', 'All changes have been changed.');
        }

        Cache::flush();
        return redirect()->action('admin\SettingsController@getSocialLogin');

    }

	public function getPaymentsGateways(){
        $data = array_merge([

        ], $this->CommonData());

        return view('admin.paymentgateways', $data);
    }

    public function postPaymentsGateways(){
        $errors = false;

        // facebook
        if(Input::get('enable_paypal') == 'on'){
            $this->putAppEnv('PAYPAL_ENABLED', 'true');
        }else{
            $this->putAppEnv('PAYPAL_ENABLED', 'false');
        }
        if(Input::has('paypal_id')){
            $this->putAppEnv('PAYPAL_CLIENT_ID', Input::get('paypal_id'));
        }
        if(Input::has('paypal_secret')){
            $this->putAppEnv('PAYPAL_CLIENT_SECRET', Input::get('paypal_secret'));
        }
        if(Input::has('paypal_mode')){
            $this->putAppEnv('PAYPAL_MODE', Input::get('paypal_mode'));
        }

        // facebook
        if(Input::get('enable_stripe') == 'on'){
            $this->putAppEnv('STRIPE_ENABLED', 'true');
        }else{
            $this->putAppEnv('STRIPE_ENABLED', 'false');
        }
        if(Input::has('stripe_id')){
            $this->putAppEnv('STRIPE_PUBLIC_KEY', Input::get('stripe_id'));
        }
        if(Input::has('stripe_secret')){
            $this->putAppEnv('STRIPE_PRIVATE_KEY', Input::get('stripe_secret'));
        }


        if(!$errors){
            Session::flash('messageType', 'success');
            Session::flash('message', 'All changes have been changed.');
        }

        Cache::flush();
        return redirect()->action('admin\SettingsController@getPaymentsGateways');

    }
}
