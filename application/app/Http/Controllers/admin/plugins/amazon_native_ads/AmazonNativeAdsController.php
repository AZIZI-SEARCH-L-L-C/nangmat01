<?php

namespace AziziSearchEngineStarter\Http\Controllers\admin\plugins\amazon_native_ads;

use AziziSearchEngineStarter\Engines;
use Illuminate\Http\Request;
use AziziSearchEngineStarter\Http\Controllers\admin\Controller;
use Input, Config, Session;

class AmazonNativeAdsController extends Controller
{

    public function get(){

        $data = [
            'engines' => Engines::get(),
        ];

        return view('admin.plugins.amazon_native_ads.get', array_merge($data, $this->CommonData()));
    }

    public function post(){

        Config::write('plugins.amazon_native_ads', 'amazon.amzn_assoc_tracking_id', Input::get('tracking_id'));
        Config::write('plugins.amazon_native_ads', 'amazon.amzn_assoc_linkid', Input::get('link_id'));
        Config::write('plugins.amazon_native_ads', 'amazon.amzn_assoc_design', Input::get('design'));
        Config::write('plugins.amazon_native_ads', 'amazon.amzn_assoc_rows', Input::get('rows'));

        $category = 'All';
        $sub_category = '';
        $default_category = Input::get('default_category');
        $category_parts = explode('#', $default_category);
        if(!empty($category_parts[0]) && !empty($category_parts[1])){
            $category = $category_parts[0];
            $sub_category = $category_parts[1];
        }
        if($sub_category=="REMOVE") $sub_category = '';
        Config::write('plugins.amazon_native_ads', 'amazon.amzn_assoc_default_category', $category);
        Config::write('plugins.amazon_native_ads', 'amazon.amzn_assoc_default_browse_node', $sub_category);
        Config::write('plugins.amazon_native_ads', 'amzn_assoc_default_category_kham', $default_category);
        Config::write('plugins.amazon_native_ads', 'show_in', implode(',', Input::get('show_in')));

        Session::flash('messageType', 'success');
        Session::flash('message', 'All changes have been made.');
        return redirect()->route('amazon_native_ads.admin.get');

    }

}
