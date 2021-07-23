<?php

namespace AziziSearchEngineStarter\Providers\plugins;

use Illuminate\Support\ServiceProvider;
use Route, LaravelLocalization, Hook;

class MapsEngineServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Route::group([
            'prefix' => 'admin',
            'middleware' => ['web', 'installed', 'admin']
        ], function () {
            Route::get('plugins/mapsengine/settings', 'AziziSearchEngineStarter\Http\Controllers\admin\plugins\mapsengine\MapsEngineController@get')->name('mapsengine.admin.get');
            Route::get('plugins/mapsengine/callback', 'AziziSearchEngineStarter\Http\Controllers\admin\plugins\mapsengine\MapsEngineController@activeCallback')->name('mapsengine.admin.active');
            Route::post('plugins/mapsengine/settings', 'AziziSearchEngineStarter\Http\Controllers\admin\plugins\mapsengine\MapsEngineController@post');
        });

        if(config('plugins.mapsengine.active')) {
            Route::group([
                'prefix' => LaravelLocalization::setLocale(),
                'middleware' => ['web', 'installed', 'localeSessionRedirect', 'localizationRedirect']
            ], function () {
               Route::get('maps/find', 'AziziSearchEngineStarter\Http\Controllers\plugins\mapsengine\MapsEngineController@search')->name('plugin.mapsengine.search');
               Route::get('maps/redirect', 'AziziSearchEngineStarter\Http\Controllers\plugins\mapsengine\MapsEngineController@redirect')->name('plugin.mapsengine.redirect');
            });
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
