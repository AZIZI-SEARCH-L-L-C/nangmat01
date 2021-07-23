<?php

namespace AziziSearchEngineStarter\Http\Controllers\admin;

use AziziSearchEngineStarter\Http\Controllers\admin\Controller;
use Input, Session, Cache, Log;

class ApiController extends Controller
{

    public function get($apiName){
        $apisPath = 'AziziSearchEngineStarter\Http\Controllers\APIs\\';
        $apiPath = $apisPath.$apiName;
        if(!in_array($apiPath, array_keys(config('app.apiProviders')))){
            abort(404);
        }

        $data = array_merge([
            'apiName' => $apiName,
            'apiPath' => $apiPath,
        ], $this->CommonData());

        return view('admin.apiConfig', $data);
    }

//    public function getApiSettings(){
//
//        $data = array_merge([
//
//        ], $this->CommonData());
//
//        return view('admin.apiSettings', $data);
//    }

    public function redirect($name){
        return redirect()->action('admin\ApiController@get', $name);
    }

    public function post($apiName){
        $apisPath = 'AziziSearchEngineStarter\Http\Controllers\APIs\\';
        $apiPath = $apisPath.$apiName;
        if(!in_array($apiPath, array_keys(config('app.apiProviders')))){
            abort(404);
        }

//        dd(config('app.apiWebProviders'));
        $input = Input::all();
        $errors = false;

        // check if BingApi has valide value
        if(Input::has('BingApi')){
//            if(Input::get('enableBing') == 'on'){
//
//            }else{
//
//            }
            $this->putAppEnv('BING_COGNITIVE_KEY', $input['BingApi']);
            $this->putAppEnv('BING_CUSTOM_CONFIG_KEY', $input['BingCustomSearchConfigsId']);
        }

        // check if GoogleApi has valide value
        if(Input::has('GoogleApi')){
            $this->putAppEnv('GOOGLE_CSE_KEY', $input['GoogleApi']);
        }

        // check if GoogleApi has valide value
        if(Input::has('AziziSearchApi')){
            $this->putAppEnv('AZIZI_SEACH_API_KEY', $input['AziziSearchApi']);
        }

        if(!$errors){
            Session::flash('messageType', 'success');
            Session::flash('message', 'All changes have been changed.');
        }

        Cache::flush();
        return $this->redirect($apiName);

    }
}
