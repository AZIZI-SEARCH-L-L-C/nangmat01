<?php

namespace AziziSearchEngineStarter\Http\Middleware;

use Closure;

class usersSystem
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
		if( settings('usersLogin') ) return $next($request);
//		if( settings('usersLogin') || settings('advertisements') ) return $next($request);

		abort(404);
    }
}
