<?php

namespace AziziSearchEngineStarter\Http\Middleware;

use Closure;
use Auth;

class userLoggedIn
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
		if ( ! Auth::check()) {
			if ($request->ajax()) {
				return response('Please login to unlock this feature and other features.', 401);
			}else{
				return redirect()->route('login');
			}
        }
		
        return $next($request);
    }
}
