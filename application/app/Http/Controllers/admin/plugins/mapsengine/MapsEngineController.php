<?php

namespace AziziSearchEngineStarter\Http\Controllers\admin\plugins\mapsengine;

use Illuminate\Http\Request;
use AziziSearchEngineStarter\Http\Controllers\admin\Controller;
use AziziSearchEngineStarter\Engines;
use DB, Input, Session, Cache;

class MapsEngineController extends Controller
{

	public function get(){
        $engine = Engines::where('slug', 'maps')->first();
        if(!$engine) return 'an error occured, please contact support';

        $data = [
            'engines' => Engines::get(),
            'engine'  => $engine,
        ];

        return view('admin.plugins.mapsengine.get', array_merge($data, $this->CommonData()));
    }

    public function post(){
        $engine = Engines::where('slug', 'maps')->first();
        if(!$engine) return 'an error occured, please contact support';

        $engine->turn = (boolean) Input::get('active');
        $engine->save();

        if(Input::has('access_token')){
            $this->set('maps_access_token', Input::get('access_token'));
        }

        if(in_array(Input::get('showbar'), [0, 1])){
            $this->set('maps_show_bar', Input::get('showbar'));
        }

        if(in_array(Input::get('showpopup'), [0, 1])){
            $this->set('maps_show_popup', Input::get('showpopup'));
        }

        if(in_array(Input::get('realtime'), [0, 1])){
            $this->set('maps_real_time', Input::get('realtime'));
        }

        if(Input::has('maps_footer')){
            $this->set('maps_footer', Input::get('maps_footer'));
        }

        if(in_array(Input::get('enable_routes'), [0, 1])){
            $this->set('maps_routes_search', Input::get('enable_routes'));
        }

        if(in_array(Input::get('show_alternatives'), [0, 1])){
            $this->set('maps_show_alternatives', Input::get('show_alternatives'));
        }

        if(in_array(Input::get('fit_selected_routes'), [0, 1])){
            $this->set('maps_fit_selected_routes', Input::get('fit_selected_routes'));
        }

        if(in_array(Input::get('auto_route'), [0, 1])){
            $this->set('maps_auto_route', Input::get('auto_route'));
        }

        if(in_array(Input::get('unites_to_use'), [0, 1])){
            $this->set('maps_unites_to_use', Input::get('unites_to_use'));
        }

        if(Input::has('route_path_color')){
            $this->set('maps_route_path_color', Input::get('route_path_color'));
        }

        if(Input::has('point_color')){
            $this->set('maps_point_color', Input::get('point_color'));
        }

        Cache::flush();
        Session::flash('messageType', 'success');
        Session::flash('message', 'All changes have been made.');
        return redirect()->route('mapsengine.admin.get');

    }

    public function activeCallback(){
        $active = config('plugins.mapsengine.active');
        $engine = Engines::where('slug', 'maps')->first();
        $engine->turn = $active ? 1 : 0;
        $engine->save();
        Cache::flush();
        Session::flash('messageType', 'success');
        Session::flash('message', 'All changes have been made.');
        return redirect()->action('admin\PluginsController@installed');
    }

}
