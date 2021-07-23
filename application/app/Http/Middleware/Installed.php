<?php

namespace AziziSearchEngineStarter\Http\Middleware;

use Closure, Config;

class Installed
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
		if( ! Config::get('app.installed', false) ){
			return redirect()->action('admin\InstallerController@get');
		}
		
        return $next($request);
    }
}
