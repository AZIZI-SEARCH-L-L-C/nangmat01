<?php

namespace AziziSearchEngineStarter\Http\Middleware;

use Closure, Config, Auth;

class PrivateSearch
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
		if( Config::get('app.private', false) && !Auth::check() ){
			session()->flash('messageType', 'error');
			session()->flash('message', 'you can\'t search in this site if you are not a member.');
			return redirect()->route('login');
		}
		
        return $next($request);
    }
}
