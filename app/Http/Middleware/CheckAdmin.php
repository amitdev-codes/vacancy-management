<?php

namespace App\Http\Middleware;

use Closure;
use CRUDBooster;
use Illuminate\Http\Request;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        if (CRUDBooster::isSuperadmin()) {
            return $next($request);
        } else {
            if ($request->is('app/*')) {
                return redirect('app/dashboard')->with('errors', 'Oops! Page Not Found Or is Unvailabale at this moment.Please make sure the URL is correct');
            } else {
                return response()->view('errors.404', [], 404);
            }
        }

    }
}
