<?php

namespace HesamRad\Flashlight\Middleware;

use Closure;
use Illuminate\Http\Request;

class FlashlightMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }
}
