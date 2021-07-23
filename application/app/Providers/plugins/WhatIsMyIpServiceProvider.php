<?php

namespace AziziSearchEngineStarter\Providers\plugins;

use Illuminate\Support\ServiceProvider;
use Hook, GeoIP;

class WhatIsMyIpServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        if(config('plugins.whatismyip.active')){
            $this->ipAddressRequested();
        }
    }

    private function ipAddressRequested(){
        $words = array(
            'my' => 1,
            'ip' => 2,
            'address' => 1
        );
        $query = request()->input('q');
        $totalWeight = 0;
        foreach ( $words as $word => $weight )
        {
            if ( stripos( $query, $word ) !== FALSE ){
                $totalWeight += $weight;
            }
        }
        if($totalWeight > 2){
            Hook::listen('template.whatIsMyIpCard', function () {
                return view('plugins.whatismyip.'.config('app.template'), ['ipAddress' => GeoIP::getClientIP()]);
            });
        }
    }
}
