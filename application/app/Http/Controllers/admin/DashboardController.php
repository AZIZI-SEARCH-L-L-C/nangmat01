<?php

namespace AziziSearchEngineStarter\Http\Controllers\admin;

use AziziSearchEngineStarter\AdminLog;
use AziziSearchEngineStarter\Http\Controllers\admin\Controller;
use AziziSearchEngineStarter\Queries;
use Carbon\Carbon, DB, Response, Artisan, Input, Cache;

class DashboardController extends Controller
{
    
	public function __construct()
    {
        view()->share('colors', ['#3c8dbc', '#f56954', '#00a65a', '#a0d0e0', '#000']);
        view()->share('i', 0);
    }
	
	public function get(){
		$data1 = $this->CommonData();
		
		$data2 = [
			
		];
		
		$data = array_merge($data1, $data2);
		return view('admin.dashboard', $data);
	}
	
	public function topQueries(){
		$queries = Queries::select([DB::raw('query'), DB::raw('Count(*) as total')])->groupBy('query')->orderby('total', 'desc')->take(5)->get();
		return $queries;
	}
	
	public function QueriesPerday(){
		$QueriesPerday = Queries::select([DB::raw('created_at'), DB::raw('Count(*) as total'), DB::raw('DATE(created_at) as day')])->groupBy('day')->orderby('created_at', 'desc')->take(30)->get();
		$data = [
		    'QueriesPerday' => $QueriesPerday
		];
		
		$response = Response::make(view('admin.js.topQueriesTable', $data), 200);
        $response->header('Content-Type', 'application/javascript');
		return $response;
	}
	
	public function countries(){
		$countries = Queries::select([DB::raw('country'), DB::raw('Count(*) as total')])->groupBy('country')->orderBy('total', 'desc')->take(5)->get();
		$data = [
		    'countries' => $countries,
		];
		
		$response = Response::make(view('admin.js.topCountries', $data), 200);
        $response->header('Content-Type', 'application/javascript');
		return $response;
	}
	
	public function oss(){
		$OSs = Queries::select([DB::raw('os'), DB::raw('Count(*) as total')])->groupBy('os')->take(5)->get();
		$data = [
		    'OSs'       => $OSs,
		];
		
		$response = Response::make(view('admin.js.topOs', $data), 200);
        $response->header('Content-Type', 'application/javascript');
		return $response;
	}
	
	public function devices(){
		$devices = Queries::select([DB::raw('device'), DB::raw('Count(*) as total')])->groupBy('device')->take(5)->get();
		$data = [
		    'devices'   => $devices,
		];
		
		$response = Response::make(view('admin.js.topDevices', $data), 200);
        $response->header('Content-Type', 'application/javascript');
		return $response;
	}
	
	public function browsers(){
		$browsers = Queries::select([DB::raw('browser'), DB::raw('Count(*) as total')])->groupBy('browser')->take(5)->get();
		$data = [
		    'browsers'  => $browsers,
		];
		
		$response = Response::make(view('admin.js.topBrowsers', $data), 200);
        $response->header('Content-Type', 'application/javascript');
		return $response;
	}
	
	public function getOptimizer(){
		return view('admin.optimizer', $this->CommonData());
	}
	
	public function optimizer(){
		set_time_limit(60 * 60 * 2);
		Artisan::call('optimize');
		Artisan::call('route:clear');
		Artisan::call('view:clear');
		Artisan::call('config:clear');
		Queries::whereDate('created_at', '<', Carbon::Now()->subMonth(1))->delete();
		session()->flash('messageType', 'success');
		session()->flash('message', 'the search engine optimized. Now your search engine in it\'s best performance.');
		// return "the search engine optimized. Now your search engine in it\'s best performance. <a href=''>Click here to return</a>";
		return redirect()->action('admin\DashboardController@getOptimizer');
	}
	
	public function redirect(){
		return redirect()->action('admin\DashboardController@get');
	}

	public function getQueries(){
        $data1 = $this->CommonData();

        $queries = Queries::orderBy('id', 'desc')->paginate(50);
        $data2 = [
            'queries' => $queries,
        ];

        $data = array_merge($data1, $data2);
        return view('admin.queries', $data);
    }

	public function getAdminLog(){
        $data1 = $this->CommonData();

        $logs = AdminLog::orderBy('id', 'desc')->paginate(50);
        $data2 = [
            'logs' => $logs,
        ];

        $data = array_merge($data1, $data2);
        return view('admin.adminlog', $data);
    }

	public function getBlockTerr(){
        $data1 = $this->CommonData();

        $data2 = [

        ];

        $data = array_merge($data1, $data2);
        return view('admin.blockTerr', $data);
    }

    public function unBlockTerr(){
	    $terr = Input::get('terr');
        $settings = $this->getSettings();
        $blocked_txt = str_replace($terr, '', $settings['excTerr']);
        $blocked_arr = explode(',', $blocked_txt);
        $blocked_db = implode(',', $blocked_arr);
        $this->set('excTerr', $blocked_db);
        Cache::flush();
        session()->flash('messageType', 'success');
        session()->flash('message', $terr.' unblocked.');
        return redirect()->action('admin\DashboardController@getBlockTerr');
    }

	public function postBlockTerr(){
        $settings = $this->getSettings();
        $blockedTxt = '';
        if(Input::has('city')){
            $blocked = Input::get('city');
            $blockedTxt = Input::get('city').' city';
        }else{
            if(Input::has('state')){
                $blocked = Input::get('state');
                $blockedTxt = Input::get('state').' state';
            }else{
                if(Input::has('country')){
                    $blocked = Input::get('country');
                    $blockedTxt = Input::get('country').' country';
                }else{
                    session()->flash('messageType', 'error');
                    session()->flash('message', 'Please select a territories to block for accessing your site.');
                    return redirect()->action('admin\DashboardController@getBlockTerr');
                }
            }
        }

        $blocked_arr = explode(',', $settings['excTerr']);
        array_push($blocked_arr, $blocked);
        $blocked_db = implode(',', $blocked_arr);
        $this->set('excTerr', $blocked_db);
        Cache::flush();
        session()->flash('messageType', 'success');
        session()->flash('message', $blockedTxt.' blocked.');
        return redirect()->action('admin\DashboardController@getBlockTerr');
    }

	
 	
}
