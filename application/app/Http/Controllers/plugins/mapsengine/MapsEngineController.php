<?php

namespace AziziSearchEngineStarter\Http\Controllers\plugins\mapsengine;

use Illuminate\Http\Request;
use AziziSearchEngineStarter\Http\Controllers\Controller;
use AziziSearchEngineStarter\Engines;
use Input, Redirect, DB;

class MapsEngineController extends Controller
{
    
	public function search(){
		/*if(empty(Input::get('q'))){
            return Redirect::route('engine.home', ['type' => 'maps']);
        }*/
        $engine = Engines::where('slug', 'maps')->first();
        if(!$engine->turn) abort(404);
		
		$settings = $this->getSettings();
        $file = $this->getLogoInfo($engine->name, $settings);
        $logoType = $file['type'];
        $logo = $file['content'];
		
//		$locale = config('app.locale');
//        $translation = DB::table('translator_translations')->select(['locale', 'group', 'item', 'text'])->where('locale', $locale)->where('group', 'maps_plugin')->pluck('text', 'item')->toArray();
//        $multiDimensionalArray = [];
//        foreach ($translation as $key => $value) {
//            array_set($multiDimensionalArray , $key, $value);
//        }
//        $translations = json_encode($multiDimensionalArray);
		
		$data = [
            'engine' => $engine->slug,
            'engineDb' => $engine,
            'logoType'  => $logoType,
            'logo'      => $logo,
//            'translations'      => $translations,
        ];

        view()->share($data);
        return view('plugins.mapsengine.engine', array_merge($data, $this->CommonData()));
	}
	
	public function redirect(){
		$settings = $this->getSettings();
		$engine = Engines::where('slug', $settings['default'])->first();
        if(!$engine->turn) return redirect('/');
		return redirect()->action('WebController@search', ['name' => $settings['default'], 'q' => Input::get('q')]);
	}
}
