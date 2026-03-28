<?php
namespace App\Utils;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use CRUDBooster;

class CBFirewall{
    // public static $blacklisted_IPs = array('103.232.231.182','182.93.83.11','182.50.64.67','127.0.0.1','192.99.56.22') ;
    // public static $whitelisted_IPs = array('110.44.116.135','202.70.66.227','127.0.0.1');
    public static function GetBlacklistedIps(){
        // return array('103.232.231.182','182.93.83.11','182.50.64.67','192.99.56.22','127.0.0.11') ;
        return explode(',', getenv('BLACKLIST_IPS'));

    }
    public static function GetWhitelistedIps(){
        // return array('110.44.116.135','202.70.66.227','127.0.0.1') ;
        return explode(',', getenv('ADMIN_IPS'));
    }
    public static function IsBlacklistedIP($ip =  null){
        if($ip == null)
            $ip = Request::server('REMOTE_ADDR');
          if(in_array($ip, CBFirewall::GetBlacklistedIps())){
            return true;
        }
        return ;
    }

    public static function IsWhitelistedIP($ip =  null){
        if($ip == null)
            $ip = Request::server('REMOTE_ADDR');
        if(in_array($ip, CBFirewall::GetWhitelistedIps()))
        return true;
        else
            return false;
    }
}