<?php

namespace AziziSearchEngineStarter\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        $segments = [app_path(), 'Providers', 'plugins', ''];
        $segments2 = [app_path(), 'Providers', 'plugins', '*.php'];
        $path = join(DIRECTORY_SEPARATOR, $segments);
        $path2 = join(DIRECTORY_SEPARATOR, $segments2);

        foreach (glob($path2) as $filename){
            $className = str_replace([$path, '.php'], '', $filename);
            $this->app->register("AziziSearchEngineStarter\Providers\plugins\\$className");
        }

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(){
		foreach (glob(app_path().'/Helpers/*.php') as $filename){
			require_once($filename);
		}
	}
}
