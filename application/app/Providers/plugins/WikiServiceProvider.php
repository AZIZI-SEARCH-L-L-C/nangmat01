<?php

namespace AziziSearchEngineStarter\Providers\plugins;

use Illuminate\Support\ServiceProvider;
use Route, LaravelLocalization, Hook;

class WikiServiceProvider extends ServiceProvider
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
                Route::get('plugins/wikipedia/settings', 'AziziSearchEngineStarter\Http\Controllers\admin\plugins\wikipedia\WikiController@get')->name('wikipedia.admin.get');
                Route::get('plugins/wikipedia/callback', 'AziziSearchEngineStarter\Http\Controllers\admin\plugins\wikipedia\WikiController@activeCallback')->name('wikipedia.admin.active');
                Route::post('plugins/wikipedia/settings', 'AziziSearchEngineStarter\Http\Controllers\admin\plugins\wikipedia\WikiController@post');
            });

        if(config('plugins.wikipedia.active')) {
            Route::group([
                'prefix' => LaravelLocalization::setLocale(),
                'middleware' => ['web', 'installed', 'localeSessionRedirect', 'localizationRedirect']
            ], function () {
                Route::get('wikipedia/info/query', 'AziziSearchEngineStarter\Http\Controllers\plugins\wikipedia\WikiController@query')->name('plugin.wikipedia.query');
                Route::get('wikipedia/results', 'AziziSearchEngineStarter\Http\Controllers\plugins\wikipedia\WikiController@search')->name('plugin.wikipedia.search');
                Route::get('wikipedia/page/{slug}', 'AziziSearchEngineStarter\Http\Controllers\plugins\wikipedia\WikiController@page')->where('slug', '(.*)')->name('plugin.wikipedia.page');
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
        if(config('plugins.wikipedia.active') && config('plugins.wikipedia.enable_query')){
            Hook::listen('template.wikiAAAinfoContainer', function () {
                return '<div id="wiki-info"></div>';
            });

            Hook::listen('template.wikiAAAinfoScript', function () {
                $engineSlug = view()->shared('engineDb')->slug;
                if(in_array($engineSlug, explode(',', config('plugins.wikipedia.show_in')))) {
                    $data = [

                    ];
                    return view('plugins.wikipedia.script', $data);
                }
            });
        }
    }
}
