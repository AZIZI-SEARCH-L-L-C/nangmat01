<?php

namespace AziziSearchEngineStarter\Http\Middleware;

use AziziSearchEngineStarter\AdminLog;
use Closure;
use Auth, Route, GeoIP, Log;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
		if ( ! Auth::check() || ! Auth::user()->isAdmin()) {
            if ($request->ajax()) {
                return response('Unauthorized, you are unauthorized to access this page.', 401);
            } else {
                return redirect()->action('UsersController@login');
            }
        }


		if($request->isMethod('post')){
		    $path = Route::getCurrentRoute()->getPath();
            $this->recordAdminActivity($path);
        }
		
        return $next($request);
    }

    protected function recordAdminActivity($path){
        $log_phrases = [
            'admin/settings' => 'Settings updated.',
            'admin/settings/social_login' => ' Social login settings updated.',
            'admin/settings/payments_gateways' => 'payments gateways updated.',
            'admin/engines' => 'Search Engines updated.',
            'admin/ads/simple' => 'Simple ads updated.',
            'admin/ads/adsblocks' => 'Ads Blocks updated.',
            'admin/ads/primary/keywords' => 'Primary keywords updated.',
            'admin/ads/settings' => 'Ads Settings updated.',
            'admin/ads/compains' => 'Campains edited.',
            'admin/ads/compain/new' => 'New campain created.',
            'admin/logos' => 'Logos updated.',
            'admin/languages' => 'Languages settings updated.',
            'admin/templates/zip' => 'New template uploaded.',
            'admin/api/plugins/install' => 'New Plugin uploaded.',
            'admin/optimizer' => 'Search engine optimized.',
            'admin/sites/ranked' => 'Sites ranking updated.',
            'admin/sites/new' => 'New site ranking recorded.',
            'admin/territories/block' => 'Block territories settings updated.',
            'admin/config/api/{name}' => 'A search Engine API Key updated.',
            'admin/engines/edit/{name}' => 'An engine settings updated.',
            'admin/api/ajax/systemMode' => 'System mode changed.',
            'admin/api/ajax/approveAd' => 'New ad approved.',
        ];

        Log::info($path);
        if(!isset($log_phrases[$path])){
            return;
        }
        $log = new AdminLog();
        $log->activity = $log_phrases[$path];
        $log->ip = GeoIP::getClientIP();
        $log->save();
    }
}
