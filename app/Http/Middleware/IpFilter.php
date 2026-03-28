<?php

namespace App\Http\Middleware;

use Closure;
use Request;
use Illuminate\Http\Response;
use CRUDBooster;
use Session;

class IpFilter
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
        $host = request()->getHttpHost();

        if($host == getenv('DOMAIN_ADMIN')){
            // Admin login
            if($this->isIpAdmin()){
                return $next($request);
            }
            CRUDBooster::insertLog("Access from Blacklisted IP." . $ip);
            Session::flush();
            return response(view('invalid_ip'));
        }
        // if($request->is('counter')){
        //     // Counter login
        //     if($this->isIpCounter()){
        //         return $next($request);
        //     }
        //     CRUDBooster::insertLog("Access from Blacklisted IP." . $ip);
        //     Session::flush();
        //     return response(view('invalid_ip'));
        // }
        if($host == getenv('DOMAIN_WWW')){
            // Applicant login
            if($this->isIpBlackListed()){
                CRUDBooster::insertLog("Access from Blacklisted IP." . $ip);
                Session::flush();
                return response(view('invalid_ip'));
            }
            return $next($request);
        }
    }

    private function isIpBlackListed()
    {
        $ip = Request::server('REMOTE_ADDR');
        $blocked = explode(',', getenv('BLACKLIST_IPS'));

        return in_array($ip, $blocked);
    }

    private function isIpAdmin()
    {
        $ip = Request::server('REMOTE_ADDR');
        $admin = explode(',', getenv('ADMIN_IPS'));

        return in_array($ip, $admin);
    }

    private function isIpCounter()
    {
        $ip = Request::server('REMOTE_ADDR');
        $counter = explode(',', getenv('COUNTER_IPS'));

        return in_array($ip, $counter);
    }

}
