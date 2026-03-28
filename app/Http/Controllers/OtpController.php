<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use CRUDBooster;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use Vinkla\Hashids\Facades\Hashids;

class OtpController extends Controller
{
    public function verify_otp($id)
    {
        $encoded_id = $id;
        return view('verify_otp', compact('encoded_id'));
    }
    public function verifyotp()
    {
        $encoded_user_id = Request::get('user_id');
        $otp_input = Request::get('otpcode');
        $user = Hashids::decode($encoded_user_id);
        $user_id = $user[0];

        $otp_stored = DB::table('cms_users')->select('otp')->where('id', $user_id)->first();
        if ($otp_input == $otp_stored->otp) {
            $updated_at = Carbon::now();
            $data = [
                'status' => 'Active',
                'is_activated' => true,
                'updated_at' => $updated_at,
            ];
            DB::table('cms_users')->where('id', $user_id)->update($data);
            $data['status'] = true;
        } else {
            $data['status'] = false;
        }
        return response()->json($data);
    }

    public function resendOtp($id)
    {
        $encoded_id = $id;
        $otp = mt_rand(1000, 9999);
        $otpHash = Hash::make($otp);

        $user = Hashids::decode($encoded_id);
        $user_id = $user[0];

        $users = DB::table('cms_users')->where("id", $user_id)->get();
        $mobile_no = $users[0]->mobile_no;
        $email = $users[0]->email;

        $mobile = "977" . $mobile_no;
        $message = "Your OTP is " . $otp . " - NTC";

        DB::table('user_activations')->whereId_user($user_id)->update(['token' => $otpHash]);
        DB::table('cms_users')->whereId($user_id)->update(['otp' => $otp]);

        $user = CRUDBooster::first(config('crudbooster.USER_TABLE'), ['email' => $email]);
        CRUDBooster::sendEmail(['to' => $email, 'data' => $user, 'template' => 'new_user_activation']);

        return view('verify_otp', compact('encoded_id'));
    }
}
