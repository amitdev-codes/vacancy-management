<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\SMShelper;
use App\Models\Cms_User;
use crocodicstudio\crudbooster\controllers\Controller\AdminController;
use CRUDBooster;
use App\Services\SuperAdminService;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Redirect;
use Schema;
// use SMPP\Exceptions\SMPPException;
use Vinkla\Hashids\Facades\Hashids;
use Smpp\SmppException;
use Smpp\InvalidArgumentException;

class CBAdminController extends \crocodicstudio\crudbooster\controllers\AdminController
{
    public function adminLogin()
    {
        if (strpos(Request::server('HTTP_REFERER'), 'app') !== false) {
            Session::flash('url', Request::server('HTTP_REFERER'));
        }

        $admin_ip = env('ADMIN_IPS');
        $allowed_ip = explode(';', $admin_ip);
        $request_ip = Request::server('REMOTE_ADDR');
        // dd($request_ip);

        // dd($request_ip,$allowed_ip,   env('ADMIN_IPS'),env('BLACKLIST_IPS') );

        if (!in_array($request_ip, $allowed_ip)) {
            \Log::error('IP address is not whitelisted', ['ip address', $request_ip]);
            Session::flush();
            return redirect('/')->with('message', trans("Invalid Access.Your ip is being monitored"));
        } else {
            return view('cbauth.admin_login');
        }

    }

    public function adminPostLogin()
    {
        $email = Request::input("email");
        $password = Request::input("password");
        // dd($email, $password);
        #check request url coming from
        if (Request::segment(1) != "admin") {
            $ip = Request::server('REMOTE_ADDR');
            CRUDBooster::insertLog("Access from Blacklisted IP. email = $email");
            return redirect()->route('home')->with('message', trans("OOPS! Access from Blacklisted IP $ip. You are being MONITORED."));
        }

        #check blacklist ips
        $blacklist_ip = env('BLACKLIST_IPS');
        $banned_ip = explode(';', $blacklist_ip);
        $request_ip = Request::server('REMOTE_ADDR');

        if (in_array($request_ip, $banned_ip)) {
            CRUDBooster::insertLog("Access from Blacklisted IP. email = $email");
            Session::flush();
            return redirect('/')->with('message', trans("OOPS! Access from Blacklisted IP $banned_ip. You are being MONITORED."));
        }
         #check for token payment app basic auth credentials
         $apiCredentials = config('pspcredentials.apiCredentials');
         if ($apiCredentials['name'] == Request::input('email') && $apiCredentials['password'] == Request::input('password')) {
            // User input matches superadmin credentials
            $superAdminService = new SuperAdminService();
            $superAdminService->afterLogin();
            return redirect(CRUDBooster::adminPath('dashboard'));
        } 

        $validator = Validator::make(
            Request::all(),
            [
                'email' => 'required|email|exists:' . config('crudbooster.USER_TABLE'),
                'password' => 'required',
            ]
        );

        if ($validator->fails()) {
            $message = $validator->errors()->all();
            return redirect()->back()->with(['message' => implode(', ', $message), 'message_type' => 'danger']);
        }
        // dd('amit');
        $users = DB::table(config('crudbooster.USER_TABLE'))->where("email", $email)->first();

        if (\Hash::check($password, $users->password)) {
            $priv = DB::table("cms_privileges")->where("id", $users->id_cms_privileges)->first();
            $roles = DB::table('cms_privileges_roles')
                ->where('id_cms_privileges', $users->id_cms_privileges)
                ->join('cms_moduls', 'cms_moduls.id', '=', 'id_cms_moduls')
                ->select('cms_moduls.name', 'cms_moduls.path', 'is_visible', 'is_create', 'is_read', 'is_edit', 'is_delete')
                ->get();

            $photo = ($users->photo) ? asset($users->photo) : asset('vendor/crudbooster/avatar.jpg');
            Session::put('admin_id', $users->id);
            Session::put('admin_is_superadmin', $priv->is_superadmin);
            Session::put('admin_name', $users->name);
            Session::put('admin_photo', $photo);
            Session::put('admin_privileges_roles', $roles);
            Session::put("admin_privileges", $users->id_cms_privileges);
            Session::put('admin_privileges_name', $priv->name);
            Session::put('admin_lock', 0);
            Session::put('theme_color', $priv->theme_color);
            Session::put("appname", CRUDBooster::getSetting('appname'));

            CRUDBooster::insertLog(trans("crudbooster.log_login", ['email' => $users->email, 'ip' => Request::server('REMOTE_ADDR')]));
            // dd('amit');
            $cb_hook_session = new \App\Http\Controllers\CBHook;
            $cb_hook_session->afterLogin();
            // dd('amit');
            // dd(Session::get('url'));
            if (Session::has('url')) {
                return Redirect::to(Session::get('url'));
            } else {
                return redirect(CRUDBooster::adminPath('dashboard'));
            }
        } else {
            return redirect('/')->with('message', trans('crudbooster.alert_password_wrong'));
        }
    }

    public function postLogin()
    {
        // dd('amit');
        $email = Request::input("email");
        $users = DB::table(config('crudbooster.USER_TABLE'))->where("email", $email)->first();

        //dd($email,$users);
        if ($users->id_cms_privileges != 4) {
            return redirect()->route('home')->with('message', trans("OOPS! You are not an applicant."));
        }
        $password = Request::input("password");

        if (Request::segment(1) != "app") {
            $ip = Request::server('REMOTE_ADDR');
            CRUDBooster::insertLog("Access from Blacklisted IP. email = $email");
            return redirect()->route('home')->with('message', trans("OOPS! Access from Blacklisted IP $ip. You are being MONITORED."));
        }

        #check blacklist ips
        $blacklist_ip = env('BLACKLIST_IPS');
        $banned_ip = explode(';', $blacklist_ip);
        $request_ip = Request::server('REMOTE_ADDR');

        if (in_array($request_ip, $banned_ip)) {
            CRUDBooster::insertLog("Access from Blacklisted IP. email = $email");
            Session::flush();
            return redirect('/')->with('message', trans("OOPS! Access from Blacklisted IP $banned_ip. You are being MONITORED."));
        }
        $validator = Validator::make(
            Request::all(),
            [
                'email' => 'required|email|exists:' . config('crudbooster.USER_TABLE'),
                'password' => 'required',
            ]
        );

        if ($validator->fails()) {
            $message = $validator->errors()->all();
            return redirect()->back()->with(['message' => implode(', ', $message), 'message_type' => 'danger']);
        }

        // dd($users);

        if (\Hash::check($password, $users->password)) {
            $priv = DB::table("cms_privileges")->where("id", $users->id_cms_privileges)->first();

            if ($users->is_activated == false) {
                $user_id = $users->id;
                $encoded_user_id = Hashids::encode($user_id);
                return Redirect::route('getOtp', ['id' => $encoded_user_id])->with('message', 'Account is not activated.please check your registered email or mobile for otp code');
            }
            if ($users->is_deleted == true) {
                $new_iid = $users->taxpayer_new_iid;
                $code = $users->taxpayer_code;
                return view('password.viewpassword', compact('new_iid', 'code'));
            }

            $roles = DB::table('cms_privileges_roles')
                ->where('id_cms_privileges', $users->id_cms_privileges)
                ->join('cms_moduls', 'cms_moduls.id', '=', 'id_cms_moduls')
                ->select('cms_moduls.name', 'cms_moduls.path', 'is_visible', 'is_create', 'is_read', 'is_edit', 'is_delete')
                ->get();

            $photo = ($users->photo) ? asset($users->photo) : asset('vendor/crudbooster/avatar.jpg');
            Session::put('admin_id', $users->id);
            Session::put('admin_is_superadmin', $priv->is_superadmin);
            Session::put('admin_name', $users->name);
            Session::put('admin_photo', $photo);
            Session::put('admin_privileges_roles', $roles);
            Session::put("admin_privileges", $users->id_cms_privileges);
            Session::put('admin_privileges_name', $priv->name);
            Session::put('admin_lock', 0);
            Session::put('theme_color', $priv->theme_color);
            Session::put("appname", CRUDBooster::getSetting('appname'));

            CRUDBooster::insertLog(trans("crudbooster.log_login", ['email' => $users->email, 'ip' => Request::server('REMOTE_ADDR')]));
            $cb_hook_session = new \App\Http\Controllers\CBHook;
            $cb_hook_session->afterLogin();

            //amit changes
            $usersid = Session::get('admin_id');
            // dd($usersid);
            $pasword = DB::table('cms_users')
                ->select('created_at', 'updated_at', 'id_cms_privileges')
                ->where('id_cms_privileges', '=', 4)
                ->where('id', '=', $usersid)
                ->first();
            //->get();
            //dd($pasword);

            if ($pasword->id_cms_privileges == 4) {
                return redirect()->route('userDashboardController');

            }

            if ($users->password_changed == false) {
                CRUDBooster::redirect(route('getEditProfile'), trans('Please change your password before continuing.'), 'warning');
            }

        } else {
            return redirect()->route('applicantLogin')->with('message', trans('crudbooster.alert_password_wrong'));
        }
    }

    public function getRegister()
    {

        if (CRUDBooster::myId()) {
            return redirect(CRUDBooster::adminPath());
        }
        return view('cbauth.register');
    }

    public function getRegisterSuccess()
    {

        //check here for BLACKLISTED IP
        // $resp = $this->CheckBlacklistedIP();
        // if ($resp != false) {
        //     return $resp;
        // }

        if (CRUDBooster::myId()) {
            return redirect(CRUDBooster::adminPath());
        }

        return view('cbauth.register_success');
    }

    private function insert($table, $data = [])
    {
        //$data['id'] = DB::table($table)->max('id') + 1;
        if (!$data['created_at']) {
            if (Schema::hasColumn($table, 'created_at')) {
                $data['created_at'] = date('Y-m-d H:i:s');
            }
        }

        if (DB::table($table)->insert($data)) {
            return $data['id'];
        } else {
            return false;
        }
    }

    public function postRegister()
    {

        #check blacklist ips
        $blacklist_ip = env('BLACKLIST_IPS');
        $banned_ip = explode(';', $blacklist_ip);
        $request_ip = Request::server('REMOTE_ADDR');

        if (in_array($request_ip, $banned_ip)) {
            CRUDBooster::insertLog("Access from Blacklisted IP. email = $email");
            Session::flush();
            return redirect('/')->with('message', trans("OOPS! Access from Blacklisted IP $banned_ip. You are being MONITORED."));
        }

        $request = Request::all();
        $validator = Validator::make(
            $request,
            [
                'captcha' => 'required|captcha',
                'name' => 'required|string|max:200',
                'email' => 'required|email',
                'mobile_no' => 'required|string|min:10|max:10',
                'password' => 'required|string|min:6|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
                'password_confirmation' => 'required',
            ]
        );

        if ($validator->fails()) {
            $message = $validator->errors()->all();
            return redirect()->back()->with([
                'request' => $request,
                'message' => implode(', ', $message), 'message_type' => 'danger',
                'errors' => $validator->errors(),
            ]);
        }

        $email = Request::input("email");
        $users = DB::table(config('crudbooster.USER_TABLE'))->where("email", $email)->first();

        if ($users) {
            $data = $request;
            return redirect()->route('applicantPostRegister')->with(['message' => trans('crudbooster.alert_email_exists'), 'request' => $data]);
        } else {
            //save
            DB::beginTransaction();
            $id = DB::table(config('crudbooster.USER_TABLE'))->max('id') + 1;
            $name = Request::input("name");
            $mobile_no = Request::input("mobile_no");
            $email = Request::input("email");
            $password = Request::input("password");
            $password_wo_hash = $password;
            //Generate OTP
            $otp = mt_rand(1000, 9999);
            $otpHash = Hash::make($otp);
            $data = [
                "mobile_no" => $mobile_no,
                "email" => $email,
                "name" => $name,
                "password" => \Hash::make($password),
                "id_cms_privileges" => 4,
                'password_changed' => 0,
                'otp' => $otp,
            ];
            $cms_users = Cms_User::create($data);
            DB::commit();
            $user_id = $cms_users->id;
            if (isset($user_id)) {
                $applicant_data = [
                    'mobile_no' => $mobile_no,
                    'email' => $email,
                    'user_id' => $user_id,
                    'id' => $user_id,
                ];

                $applicant_id = $this->insert("applicant_profile", $applicant_data);
                $applicant_data = [
                    'applicant_id' => $applicant_id,
                    'id' => $user_id,
                ];
                $this->insert("applicant_family_info", $applicant_data);
                CRUDBooster::insertLog(trans("crudbooster.log_register", ['email' => g('email'), 'ip' => Request::server('REMOTE_ADDR')]));
                $mobile = "977" . $mobile_no;
                $message = "Your OTP is " . $otp . " - NTC";
                DB::table('user_activations')->insert(['id_user' => $user_id, 'token' => $otpHash]);
                $user = CRUDBooster::first(config('crudbooster.USER_TABLE'), ['email' => g('email')]);
                $user->token = $token;

                // send email
                CRUDBooster::sendEmail(['to' => $email, 'data' => $user, 'template' => 'new_user_activation']);
                CRUDBooster::insertLog(trans("crudbooster.user_registration", ['email' => g('email'), 'ip' => Request::server('REMOTE_ADDR')]));

                // send sms
                try {
                 SMShelper::sendsms($mobile, $message);
                } catch (Exception $e) {

                 }

                CRUDBooster::insertLog("Registration OTP sent. Mobile No. = $mobile");

                $encoded_user_id = Hashids::encode($user_id);
                return redirect()->route('getOtp', ['id' => $encoded_user_id])->with(['message', trans('User registered. Please check your SMS or email to activate it.  If you do not find the email in your inbox, please check your spam filter or bulk email folder.'), $encoded_user_id]);
            } else {
                CRUDBooster::insertLog(trans("crudbooster.log_register_fail", ['email' => g('email'), 'ip' => Request::server('REMOTE_ADDR')]));
                return redirect()->route('register')->with([
                    'message' => "Technical Error while creating user. Try again later.",
                    'request' => $data,
                ]);
            }


        }
    }

        public function postForgot()
    {


        $validator = Validator::make(
            Request::all(),
            [
                'email' => 'required|email|exists:' . config('crudbooster.USER_TABLE'),
            ]
        );
        $email = Request::input('email');
        $user = DB::table(config('crudbooster.USER_TABLE'))->where('email', $email)->first();
        if ($user == null) {
            CRUDBooster::insertLog("Non registered Password change request. email : " . $email);
            return redirect()->back()->with('message', trans("Invalid email address provided [$email]. Please recheck email address"));
            //return redirect()->route('getLogin')->with('message', trans("Invalid email address provided [$email]. Please recheck email address"));
        }

        if ($user->id_cms_privileges != 4) {
            CRUDBooster::insertLog("Non Applicant Password change request. email : " . $email);
            return redirect()->route('getLogin')->with('message', trans("Invalid request"));
        }

        if ($validator->fails()) {
            $message = $validator->errors()->all();
            return redirect()->back()->with(['message' => implode(', ', $message), 'message_type' => 'danger']);
        }

        $mobile_no=$user->mobile_no;

        // generate strong password
        $rand_string = $this->generateStrongPassword();
        $password = \Hash::make($rand_string);

        DB::table(config('crudbooster.USER_TABLE'))->where('email', Request::input('email'))->update(array('password' => $password, 'password_changed' => 0));

        $appname = CRUDBooster::getSetting('appname');
        $user = CRUDBooster::first(config('crudbooster.USER_TABLE'), ['email' => g('email')]);
        $user->password = $rand_string;

        CRUDBooster::sendEmail(['to' => $user->email, 'data' => $user, 'template' => 'forgot_password_backend']);

                $mobile = "977" . $mobile_no;
                $message = "Your Password is " . $rand_string. " - NTC";

                    try {
                 SMShelper::sendsms($mobile, $message);
                } catch (Exception $e) {

                 }

                 

        CRUDBooster::insertLog(trans("crudbooster.log_forgot", ['email' => g('email'), 'ip' => Request::server('REMOTE_ADDR')]));

        return redirect()->route('applicantLogin')->with('message', trans("crudbooster.message_forgot_password"));
    }

    // public function postForgot()
    // {
    //     //check here for BLACKLISTED IP
    //     // $resp = $this->CheckBlacklistedIP();
    //     // if ($resp != false) {
    //     //     return $resp;
    //     // }

    //     $validator = Validator::make(
    //         Request::all(),
    //         [
    //             'email' => 'required|email|exists:' . config('crudbooster.USER_TABLE'),
    //         ]
    //     );
    //     $email = Request::input('email');
    //     //dd($email);
    //     $user = DB::table(config('crudbooster.USER_TABLE'))->where('email', $email)->first();
    //     //dd($user);
    //     if ($user == null) {
    //         CRUDBooster::insertLog("Non registered Password change request. email : " . $email);
    //         return redirect()->back()->with('message', trans("Invalid email address provided [$email]. Please recheck email address"));
    //         //return redirect()->route('getLogin')->with('message', trans("Invalid email address provided [$email]. Please recheck email address"));
    //     }

    //     if ($user->id_cms_privileges != 4) {
    //         CRUDBooster::insertLog("Non Applicant Password change request. email : " . $email);
    //         return redirect()->route('getLogin')->with('message', trans("Invalid request"));
    //     }

    //     if ($validator->fails()) {
    //         $message = $validator->errors()->all();
    //         return redirect()->back()->with(['message' => implode(', ', $message), 'message_type' => 'danger']);
    //     }

    //     // generate strong password
    //     $rand_string = $this->generateStrongPassword();
    //     // $password = \Hash::make($rand_string);

    //     // DB::table(config('crudbooster.USER_TABLE'))->where('email', Request::input('email'))->update(array('password' => $password, 'password_changed' => 0));

    //     // $appname = CRUDBooster::getSetting('appname');
    //     // $user = CRUDBooster::first(config('crudbooster.USER_TABLE'), ['email' => g('email')]);
    //     // $user->password = $rand_string;

    //     // $details['email'] = $user->email;
    //     // $details['message'] = $user;
    //     // dispatch(new App\Jobs\ForgotPasswordJob($details));

    //     //dd($user, $user->mobile_no);

    //     try {
    //         $mobile = $user->mobile_no;
    //         $user->password = $rand_string;
    //         $password = \Hash::make($rand_string);
    //         $message = "your password is " . $rand_string;
    //         $mobile_no = '977' . $mobile;
    //         $status=SMShelper::sendsms($mobile_no, $message);
    //         //dd($status);
    //         DB::table(config('crudbooster.USER_TABLE'))->where('email', Request::input('email'))->update(array('password' => $password, 'password_changed' => 0));
    //         $appname = CRUDBooster::getSetting('appname');
    //         $user = CRUDBooster::first(config('crudbooster.USER_TABLE'), ['email' => g('email')]);

    //         return redirect()->route('applicantLogin')->with('message', 'please check your Ntc registered mobile no for password');

    //     } catch (\Exception $e) {
    //         $password = \Hash::make($user->mobile_no);
    //         DB::table(config('crudbooster.USER_TABLE'))->where('email', Request::input('email'))->update(array('password' => $password, 'password_changed' => 0));
    //         return redirect()->route('applicantLogin')->with('message', 'Your password has been changed to your registered mobile no.');
    //     }

    //  catch (InvalidArgumentException | SmppException $e) {
    //         $password = \Hash::make($user->mobile_no);
    //         DB::table(config('crudbooster.USER_TABLE'))->where('email', Request::input('email'))->update(array('password' => $password, 'password_changed' => 0));
    //         return redirect()->route('applicantLogin')->with('message', 'Your password has been changed to your registered mobile no.');
    //     }

    //     //  finally  {
    //     //     $password = \Hash::make($user->mobile_no);

    //     //     DB::table(config('crudbooster.USER_TABLE'))->where('email', Request::input('email'))->update(array('password' => $password, 'password_changed' => 0));
    //     //     return redirect()->route('applicantLogin')->with('message', 'Your password has been changed to your registered mobile no.');
    //     // }

    //     //CRUDBooster::sendEmail(['to' => $user->email, 'data' => $user, 'template' => 'forgot_password_backend']); 9861888095

    //     CRUDBooster::insertLog(trans("crudbooster.log_forgot", ['email' => g('email'), 'ip' => Request::server('REMOTE_ADDR')]));

    //     return redirect()->route('applicantLogin')->with('message', trans("crudbooster.message_forgot_password"));
    // }

    public function userActivation($token)
    {
        //check here for BLACKLISTED IP
        // $resp = $this->CheckBlacklistedIP();
        // if ($resp != false) {
        //     return $resp;
        // }

        $check = DB::table('user_activations')->where('token', $token)->first();
        if (!is_null($check)) {
            $user_id = $check->id_user;
            $user = CRUDBooster::first(config('crudbooster.USER_TABLE'), ['id' => $user_id]);

            if ($user->is_activated == true) {
                CRUDBooster::insertLog(trans("User already activated.", ['email' => g('email'), 'ip' => Request::server('REMOTE_ADDR')]));
                return redirect()->route('getLogin')->with('success', "User already activated.");
            }

            DB::table(config('crudbooster.USER_TABLE'))->where('id', $user_id)->update(
                ['is_activated' => true]
            );

            DB::table('user_activations')->where('token', $token)->delete();

            // CRUDBooster::insertLog(trans("User activation successful. email : $email",['email'=>g('email'),'ip'=>Request::server('REMOTE_ADDR')]));

            $email = $user->email;

            CRUDBooster::insertLog(trans("crudbooster.user_activation", ['email' => $email, 'ip' => Request::server('REMOTE_ADDR')]));

            return redirect()->route('getLogin')->with('success', "User activated successfully.");
        }
        CRUDBooster::insertLog(trans("User activation wrong token.", ['email' => g('email'), 'ip' => Request::server('REMOTE_ADDR')]));
        return redirect()->route('getLogin')->with('Warning', "Your token is invalid!");
    }

    public function generateStrongPassword($length = 8, $add_dashes = false, $available_sets = 'luds')
    {
        $sets = array();
        if (strpos($available_sets, 'l') !== false) {
            $sets[] = 'abcdefghjkmnpqrstuvwxyz';
        }

        if (strpos($available_sets, 'u') !== false) {
            $sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
        }

        if (strpos($available_sets, 'd') !== false) {
            $sets[] = '23456789';
        }

        if (strpos($available_sets, 's') !== false) {
            $sets[] = '!@#$%&*?';
        }

        $all = '';
        $password = '';
        foreach ($sets as $set) {
            $password .= $set[array_rand(str_split($set))];
            $all .= $set;
        }
        $all = str_split($all);
        for ($i = 0; $i < $length - count($sets); $i++) {
            $password .= $all[array_rand($all)];
        }

        $password = str_shuffle($password);
        if (!$add_dashes) {
            return $password;
        }

        $dash_len = floor(sqrt($length));
        $dash_str = '';
        while (strlen($password) > $dash_len) {
            $dash_str .= substr($password, 0, $dash_len) . '-';
            $password = substr($password, $dash_len);
        }
        $dash_str .= $password;
        return $dash_str;
    }

    public function getForgot()
    {
        if (CRUDBooster::myId()) {
            return redirect(CRUDBooster::adminPath());
        }
        return view('cbauth.forgot');
    }
    public function getLogout()
    {
        $me = CRUDBooster::me();
        CRUDBooster::insertLog(trans("crudbooster.log_logout", ['email' => $me->email]));
        Session::flush();
        return redirect()->route('home')->with('message', trans("crudbooster.message_after_logout"));
    }
}
