<?php

namespace AziziSearchEngineStarter\Http\Controllers\admin;

use Illuminate\Http\Request;

use AziziSearchEngineStarter\Http\Requests;
use Illuminate\Routing\Controller as BaseController;
use Input, PDO, PDOException, Session, DB, Artisan, File;
use AziziSearchEngineStarter\Settings;
use GuzzleHttp\Client;

class InstallerController extends BaseController
{
    
	private $migs = [
		"2014_10_12_000000_create_users_table.php",
		"2014_10_12_100000_create_password_resets_table.php",
		"2015_10_26_133441_create_engines_table.php",
		"2015_10_26_133442_create_settings_table.php",
        "2016_02_08_205307_create_advertise_requestes_table.php",
        "2016_02_13_220928_create_logos_table.php",
		"2016_02_18_170406_create_queries_stats_table.php",
		"2017_10_16_172426_create_ads_packages_table.php",
		"2017_10_17_070741_create_ads_compains_table.php",
		"2017_10_17_134034_create_advertisements_table.php",
		"2017_10_18_074838_create_billing_table.php",
		"2017_10_19_142417_create_ads_payments_table.php",
		"2017_10_20_080627_create_ad_targets_table.php",
		"2017_10_29_115744_create_primery_keywords_table.php",
		"2018_02_16_153136_entrust_setup_tables.php",
		"2018_03_31_071123_create_notifications_table.php",
		"2019_07_01_155127_create_local_sites_table.php",
		"2019_07_01_231305_create_keywords_table.php",
		"2019_07_02_062232_create_cache_table.php",
		"2019_07_05_144646_create_bookmarks_categories_table.php",
		"2019_07_05_144704_create_bookmarks_table.php",
		"2019_07_12_181501_create_comments_table.php",
		"2019_07_15_132450_create_simple_ads_table.php",
		"2019_07_17_173857_create_submited_sites_table.php",
	];

	public static function get(){
		$error = false;
		if(!extension_loaded('pdo') or !extension_loaded('curl') or !is_writable(base_path('bootstrap'.DIRECTORY_SEPARATOR.'cache')) OR !is_writable(base_path('config')) OR !is_writable(base_path('resources'.DIRECTORY_SEPARATOR.'lang'))) $error = true;
		$data = [
		    'error'  => $error,
		    'server' => $_SERVER["SERVER_SOFTWARE"],
		];
		return view('admin.install.check', $data);
	}
    
	public static function license(){
		return view('admin.install.license');
	}
    
	public static function database(){
		return view('admin.install.database');
	}
    
	public static function settings(){
		return view('admin.install.settings');
	}
    
	public static function complete(){
		return view('admin.install.complete');
	}
    
	public function postLicense(){
		set_time_limit(60 * 60 * 2);
		$version = config('app.version');
        $product = config('app.product-id');
		$email  = Input::get("email");
		$key    = Input::get("key");
		
		$url = asset('/');
		$client = new Client(['base_uri' => $url, 'verify' => false]);
		
		 foreach($this->migs as $mig){
		     try {
		         $res = $client->get('https://azizisearch.com/api/migration/'.$mig, [
		             'query' => [
		                 'email'  =>  $email,
		                 'v'      =>  $version,
		                 'p'      =>  $product,
		                 'url'    =>  $url,
				         'key'    =>  $key
			         ]
	             ]);

			     $filePath = database_path(join(DIRECTORY_SEPARATOR, array('migrations', $mig)));
		         File::put($filePath, $res->getBody());
		     }catch (\Exception $e){
			     Session::flash('messageType', 'error');
			     Session::flash('message', "Invalid credentials, please provide valid license key or contact us for more informations. : ");
			     return redirect()->action('admin\InstallerController@license');
		     }
		 }
		
		// foreach($this->seeds as $seed){
		    // try {
		        // $res = $client->get('https://azizisearch.com/api/seed/'.$seed, [
		               // 'email'  =>  $email,
		             // 'query' => [
		                // 'v'      =>  $version,
						// 'p'      =>  'starter-api-google',
				        // 'key'    =>  $key
			        // ]
	            // ]);
			
			    // $filePath = database_path(join(DIRECTORY_SEPARATOR, array('seeds', $seed)));
		        // File::put($filePath, $res->getBody());
		    // }catch (\Exception $e){
			    // Session::flash('messageType', 'error');
			    // Session::flash('message', "Invalid credentials, please provide valid license key or contact us for more informations.");
			    // return redirect()->action('admin\InstallerController@license');
		    // }
		// }
		
		return redirect()->action('admin\InstallerController@database');
	}
    
	public function postDatabase(){
		
		if(!Input::has('dbHost') or !Input::has('dbName') or !Input::has('dbUsername') or !Input::has('dbPassword') ){
			Session::flash('messageType', 'error');
			Session::flash('message', 'some or all database informations are empty.');
            return redirect()->action('admin\InstallerController@database');
		}
		
        $db =  'mysql:host='.Input::get('dbHost').';dbname='.Input::get('dbName');
        
        //test db connection with user supplied credentials
        try {
            $conn = new PDO($db, Input::get('dbUsername'), Input::get('dbPassword'));
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(\PDOException $e) {
			Session::flash('messageType', 'error');
			Session::flash('message', 'Database Information are incorrect: ' . $e->getMessage());
            return redirect()->action('admin\InstallerController@database');
        }
		
		$this->putAppDBEnv(Input::get('dbHost'), Input::get('dbName'), Input::get('dbUsername'), Input::get('dbPassword'), Input::get('dbPrefix'));
		Artisan::call('key:generate');
		return redirect()->action('admin\InstallerController@settings');
	}
    
	public function postSettings(){
		set_time_limit(60 * 60 * 2);
		if(!Input::has('siteName') or !Input::has('siteDescription') ){
			Session::flash('messageType', 'error');
			Session::flash('message', 'Site name or site description is empty.');
            return redirect()->action('admin\InstallerController@settings');
		}
		
		if(!Input::has('adminUsername') or !Input::has('adminPassword') ){
			Session::flash('messageType', 'error');
			Session::flash('message', 'admin username or admin password are empty.');
            return redirect()->action('admin\InstallerController@settings');
		}

//		Artisan::call('cache:table');
		Artisan::call('route:clear');
		Artisan::call('view:clear');
		Artisan::call('config:clear');
//		Artisan::call('cache:clear');
		Artisan::call('migrate', ['--force' => true]);
//		 dd('test');
        Artisan::call('db:seed', ['--force' => true]);
		
		// delete migrations files
		 foreach($this->migs as $mig){
			 File::delete(database_path(join(DIRECTORY_SEPARATOR, array('migrations', $mig))));
		 }
		
		// foreach($this->seeds as $seed){
			// File::delete(database_path(join(DIRECTORY_SEPARATOR, array('seeds', $seed))));
		// }

		DB::table('users')->insert(['username' => Input::get('adminUsername'), 'password' => bcrypt(Input::get('adminPassword')), 'confirmed' => 1, 'admin' => 1]);
		$this->set('siteName', Input::get('siteName'));
		$this->set('defaultLogoContent', Input::get('siteName'));
		$this->set('siteDescription', Input::get('siteDescription'));
		return redirect()->action('admin\InstallerController@complete');
	}
    
	public function postComplete(){
		$this->endInstallation();
		Artisan::call('optimize');
		Session::flash('messageType', 'success');
		Session::flash('message', 'the search engine was installed, please login to your admin panel.');
		return redirect()->action('admin\DashboardController@get');
	}
	
	/**
     * Change app env to production and set debug to false in .env file.
     */
    private static function putAppDBEnv($dbHost, $dbName, $dbUser, $dbPass, $dbPrefix)
    {
        $content = File::get(base_path('.env'));

		// set database info while we're editing .env file
		$content = preg_replace("/(.*?DB_HOST=).*?(.+?)\\n/msi", '${1}'.$dbHost."\n", $content);
		$content = preg_replace("/(.*?DB_DATABASE=).*?(.+?)\\n/msi", '${1}'.$dbName."\n", $content);
		$content = preg_replace("/(.*?DB_USERNAME=).*?(.+?)\\n/msi", '${1}'.$dbUser."\n", $content);
		$content = preg_replace("/(.*?DB_PASSWORD=).*?(.+?)\\n/msi", '${1}'.$dbPass."\n", $content);
		$content = preg_replace("/(.*?DB_PREFIX=).*?(.+?)\\n/msi", '${1}'.$dbPrefix."\n", $content);
		
        File::put(base_path('.env'), $content);
    }
	
	private static function endInstallation()
    {
        $content = File::get(base_path('.env'));

		//set env to production
        $content = preg_replace("/(.*?APP_ENV=).*?(.+?)\\n/msi", '${1}production'."\n", $content);
        //set debug to false
        $content = preg_replace("/(.*?APP_DEBUG=).*?(.+?)\\n/msi", '${1}false'."\n", $content);
		
		//set app key while we're editing .env file
        // $key = str_random(32);
        // $content = preg_replace("/(.*?APP_KEY=).*?(.+?)\\n/msi", '${1}'.$key."\n", $content);
        Artisan::call('key:generate');
		
        //set debug to false
        $content = preg_replace("/(.*?INSTALLED=).*?(.+?)\\n/msi", '${1}true'."\n", $content);
		
        File::put(base_path('.env'), $content);
    }
	
	private static function set($key, $value)
    {
        $setting = Settings::where('name', $key)->first();

        if ( ! $setting) {
            $setting = new Settings(['name' => $key]);
        }

        $setting->value = $value;
        $setting->save();

        return $setting;
    }
	
}
