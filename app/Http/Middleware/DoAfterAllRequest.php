<?php

namespace App\Http\Middleware;

use Closure;

class DoAfterAllRequest
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
        $response = $next($request);

        session(['lastURL' => url()->current()]);

        return $response;
    }
}
