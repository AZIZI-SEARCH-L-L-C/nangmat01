<?php

namespace AziziSearchEngineStarter\Http\Controllers\admin\plugins\wikipedia;

use AziziSearchEngineStarter\Engines;
use AziziSearchEngineStarter\Http\Controllers\admin\Controller;
use Input, Config, Session, Cache;

class WikiController extends Controller
{
    public function get(){
        $engine = Engines::where('slug', 'wiki')->first();
        if(!$engine) return 'an error occured, please contact support';

        $data = [
            'engines' => Engines::get(),
            'engine'  => $engine,
        ];

        return view('admin.plugins.wikipedia.get', array_merge($this->CommonData(), $data));
    }

    public function post(){
        $engine = Engines::where('slug', 'wiki')->first();
        if(!$engine) return 'an error occured, please contact support';

        Config::write('plugins.wikipedia', 'show_in', implode(',', Input::get('show_in')));
        Config::write('plugins.wikipedia', 'enable_query', (boolean) Input::get('enable_query'));
        Config::write('plugins.wikipedia', 'enable_page', (boolean) Input::get('enable_page'));
        $engine->turn = (boolean) Input::get('active');
        $engine->per_page = Input::get('per_page');
        $engine->save();
        Cache::flush();
        Session::flash('messageType', 'success');
        Session::flash('message', 'All changes have been made.');
        return redirect()->route('wikipedia.admin.get');

    }

    public function activeCallback(){
        $active = config('plugins.wikipedia.active');
        $engine = Engines::where('slug', 'wiki')->first();
        $engine->turn = $active ? 1 : 0;
        $engine->save();
        Cache::flush();
        Session::flash('messageType', 'success');
        Session::flash('message', 'All changes have been made.');
        return redirect()->action('admin\PluginsController@installed');
    }

}
