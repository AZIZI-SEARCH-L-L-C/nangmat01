<?php

namespace AziziSearchEngineStarter\Providers\plugins;

use Illuminate\Support\ServiceProvider;
use Route, LaravelLocalization, Hook;

class CustomPagesServiceProvider extends ServiceProvider
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
        ], function() {
            Route::get('custompages', 'AziziSearchEngineStarter\Http\Controllers\admin\plugins\custompages\CustomPagesController@get');
            Route::post('custompages', 'AziziSearchEngineStarter\Http\Controllers\admin\plugins\custompages\CustomPagesController@post');
        });

        Route::group([
            'prefix' => LaravelLocalization::setLocale(),
            'middleware' => ['web', 'installed', 'localeSessionRedirect', 'localizationRedirect']
        ], function() {
            Route::get('page/{slug}', 'AziziSearchEngineStarter\Http\Controllers\plugins\custompages\CustomPagesController@get');
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        if(config('plugins.custompages.active')){
            Hook::listen('template.customPagesFooterLinks', function () {
                return view('plugins.custompages.'.config('app.template') . '.footer');
            });
        }
    }
}
