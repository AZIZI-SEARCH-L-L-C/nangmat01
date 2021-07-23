<?php

namespace AziziSearchEngineStarter\Providers\plugins;

use Illuminate\Support\ServiceProvider;
use Route, LaravelLocalization, Hook;

class AmazonNativeAdsServiceProvider extends ServiceProvider
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
            Route::get('amazon_native_ads/settings', 'AziziSearchEngineStarter\Http\Controllers\admin\plugins\amazon_native_ads\AmazonNativeAdsController@get')->name('amazon_native_ads.admin.get');
            Route::post('amazon_native_ads/settings', 'AziziSearchEngineStarter\Http\Controllers\admin\plugins\amazon_native_ads\AmazonNativeAdsController@post');
        });

        Route::group([
            'prefix' => LaravelLocalization::setLocale(),
            'middleware' => ['web', 'installed', 'localeSessionRedirect', 'localizationRedirect']
        ], function() {

        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        if(config('plugins.amazon_native_ads.active')){
            Hook::listen('template.amazonAAAsearch', function () {
                $engineSlug = view()->shared('engine');
                if(in_array($engineSlug, explode(',', config('plugins.amazon_native_ads.show_in')))) {
                    $data = [
                        'attributes' => config('plugins.amazon_native_ads.amazon')
                    ];
                    return view('plugins.amazon_native_ads.params', $data);
                }
            });
        }
    }
}
