<?php

namespace AziziSearchEngineStarter\Http\Middleware;

use Closure;

class advertisementSystem
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
		
		if(! settings('advertisements') ) abort(404);
		
        return $next($request);
		
    }
}
