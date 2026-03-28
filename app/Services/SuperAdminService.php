<?php

namespace App\services;

use App\Helpers\Settings;

use crocodicstudio\crudbooster\controllers\Controller;
use crocodicstudio\crudbooster\helpers\CRUDBooster;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SuperAdminService extends Controller
{
    public function afterLogin()
    {
        $priv = DB::table("cms_privileges")->where("id",1)->first();
        $roles = DB::table('cms_privileges_roles')
            ->where('id_cms_privileges', 1)
            ->join('cms_moduls', 'cms_moduls.id', '=', 'id_cms_moduls')
            ->select('cms_moduls.name', 'cms_moduls.path', 'is_visible', 'is_create', 'is_read', 'is_edit', 'is_delete')
            ->get();
        $user=DB::table('cms_users')->where('id_cms_privileges',1)->first();

        $photo = asset('vendor/crudbooster/avatar.jpg');
        Session::put('admin_id', $user->id);
        Session::put('admin_is_superadmin', $priv->is_superadmin);
        Session::put('admin_name', 'superAdmin');
        Session::put('admin_photo', $photo);
        Session::put('admin_privileges_roles', $roles);
        Session::put("admin_privileges",1);
        Session::put('admin_privileges_name','Super Administrator');
        Session::put('admin_lock', 0);
        Session::put('theme_color', $priv->theme_color);
        Session::put("appname", CRUDBooster::getSetting('appname'));
    }

}