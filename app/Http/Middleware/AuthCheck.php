<?php

namespace App\Http\Middleware;

use Closure;
use CRUDBooster;

class AuthCheck
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
        if (CRUDBooster::me() !== null) {
            return $next($request);
        } else {
            return redirect('app');
        }
    }
}
