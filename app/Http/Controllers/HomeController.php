<?php

namespace App\Http\Controllers;

use App\Helpers\SMShelper;
use App\Models\Cms_User;
use Carbon\Carbon;
use CRUDBooster;
use DateTimeZone;
use DB;
use Request;

class HomeController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ot = Request::get('ot');
        if (isset($ot)) {
            $selected_opening_type = $ot;
        } else {
            $selected_opening_type = null;
        }

        $today = Carbon::now(new DateTimeZone('Asia/Kathmandu'))->format('Y-m-d');

        $vacancy_ext = DB::table('vacancy_post')
            ->join('mst_designation', 'vacancy_post.designation_id', '=', 'mst_designation.id')
            ->join('mst_work_service', 'mst_designation.work_service_id', '=', 'mst_work_service.id')
            ->join('mst_work_service_group', 'mst_designation.service_group_id', '=', 'mst_work_service_group.id')
            ->join('mst_work_level', 'mst_designation.work_level_id', '=', 'mst_work_level.id')
            ->join('vacancy_ad', 'vacancy_post.vacancy_ad_id', '=', 'vacancy_ad.id')
            ->select(
                'vacancy_post.*',
                'mst_designation.name_np as desigination',
                'mst_work_level.code as work_level',
                'mst_work_service.name_np as service',
                'mst_work_service_group.name_np as service_group',
                'vacancy_ad.*'
            )
            ->where([['vacancy_ad.opening_type_id', '1'], ['vacancy_ad.is_published', '1'],['vacancy_post.is_deleted',false], ['vacancy_ad.vacancy_extended_date_ad', '>=', $today]])
            // ->orderBy('work_level', 'desc')
            ->orderByRaw('CONVERT(ad_no, UNSIGNED) ASC')
            ->get();

        $vacancy_int_open = DB::table('vacancy_post')
            ->join('mst_designation', 'vacancy_post.designation_id', '=', 'mst_designation.id')
            ->join('mst_work_service', 'mst_designation.work_service_id', '=', 'mst_work_service.id')
            ->join('mst_work_service_group', 'mst_designation.service_group_id', '=', 'mst_work_service_group.id')
            ->join('mst_work_level', 'mst_designation.work_level_id', '=', 'mst_work_level.id')
            ->join('vacancy_ad', 'vacancy_post.vacancy_ad_id', '=', 'vacancy_ad.id')
            ->select(
                'vacancy_post.*',
                'mst_designation.name_np as desigination',
                'mst_work_level.code as work_level',
                'mst_work_service.name_np as service',
                'mst_work_service_group.name_np as service_group',
                'vacancy_ad.*'
            )
            ->where([['vacancy_ad.opening_type_id', '2'], ['vacancy_ad.is_published', '1'],['vacancy_post.is_deleted',false], ['vacancy_ad.vacancy_extended_date_ad', '>=', $today]])
            // ->orderBy('work_level', 'desc')
            // ->orderByRaw('CONVERT(work_level, UNSIGNED) DESC')
            ->orderByRaw('CONVERT(ad_no, UNSIGNED) ASC')
            ->get();

        $vacancy_int_promotion = DB::table('vacancy_post')
            ->join('mst_designation', 'vacancy_post.designation_id', '=', 'mst_designation.id')
            ->join('mst_work_service', 'mst_designation.work_service_id', '=', 'mst_work_service.id')
            ->join('mst_work_service_group', 'mst_designation.service_group_id', '=', 'mst_work_service_group.id')
            ->join('mst_work_level', 'mst_designation.work_level_id', '=', 'mst_work_level.id')
            ->join('vacancy_ad', 'vacancy_post.vacancy_ad_id', '=', 'vacancy_ad.id')
            ->select(
                'vacancy_post.*',
                'mst_designation.name_np as desigination',
                'mst_work_level.code as work_level',
                'mst_work_service.name_np as service',
                'mst_work_service_group.name_np as service_group',
                'vacancy_ad.*'
            )
            ->where([['vacancy_ad.opening_type_id', '3'], ['vacancy_ad.is_published', '1'],['vacancy_post.is_deleted',false], ['vacancy_ad.vacancy_extended_date_ad', '>=', $today]])
            // ->orderBy('vacancy_ad', 'asc')
            // ->orderByRaw('CONVERT(work_level, UNSIGNED) DESC')
            ->orderByRaw('CONVERT(ad_no, UNSIGNED) ASC')
            ->get();

        $date_result = DB::table('vacancy_ad')
            ->select('date_to_publish_bs', 'last_date_for_application_bs')
            ->where([['vacancy_ad.is_published', '1'], ['vacancy_ad.vacancy_extended_date_ad', '>=', $today], ['is_deleted', 0]])
            ->orderBy('date_to_publish_bs', 'desc')
            ->get();

        $notice_data = DB::table('vacancy_notice')
            ->select(DB::raw('id,LEFT(body , 40) as body,title as tt,date_bs,file_upload'))
            ->where('is_deleted', 0)
            ->orderBy('id', 'desc')
            ->get();

        $opening_types = DB::table('mst_job_opening_type')->where('is_deleted', 0)->get();

        //dd($vacancy_int_promotion);

        return view('index', ['selected_opening_type' => $selected_opening_type, 'opening_types' => $opening_types, 'vacancy_ext' => $vacancy_ext, 'vacancy_int_open' => $vacancy_int_open, 'vacancy_int_promotion' => $vacancy_int_promotion, 'date_result' => $date_result, 'notice_data' => $notice_data]);
    }

    public function faq()
    {
        $faqs = DB::table('vacancy_faq')->where('is_deleted', 0)->get();
        return view('faq', ['faqs' => $faqs]);
    }

    public function howto()
    {
        $howtos = DB::table('vacancy_howto')->where('is_deleted', 0)->get();
        return view('howto', ['howtos' => $howtos]);
    }

    public function relatedstaff()
    {
        $related_staffs = DB::table('related_staff')->where('is_deleted', 0)->get();
        return view('relatedstaff', ['related_staffs' => $related_staffs]);
    }

    public function getNotice($id)
    {
        $notice_data = DB::table('vacancy_notice')
            ->select(DB::raw('body,title,date_ad,file_upload'))->where([['id', '=', $id], ['is_deleted', 0]])->first();
        return view('notice_detail', ['notice_data' => $notice_data]);
    }

    public function sendsms()
    {
        // echo 'test sms';
        // $status = SMShelper::sendsms(9779841451669, 'test recruit sms');
        $status = SMShelper::sendsms(9779861888095, 'test recruit sms');
        echo $status;
    }

    public function verifyotp()
    {
        $user_id = Input::get('user_id');
        $otp_input = Input::get('otp');
        $otp_stored = DB::table('cms_users')->select('otp')->where('user_id', $user_id)->first();
        if ($otp_input == $otp_stored->otp) {
            $updated_at = Carbon::now();
            $data = [
                'status' => 'Active',
                'is_activated' => true,
                'verified' => true,
                'updated_at' => $updated_at,
            ];
            DB::table('cms_users')->where('user_id', $user_id)->update($data);
        }

        return redirect()->route('home');
    }

    public function checkmobile()
    {
        $mobile = Request::get('mobile');
        if (Cms_User::where('mobile_no', $mobile)->exists()) {
            $data['status'] = true;
            $data['message'] = "Mobile Number is already registered";
            return $data;
        }
    }
    public function checkemail()
    {
        $email = Request::get('email');
        if (Cms_User::where('email', $email)->exists()) {
            $data['status'] = true;
            $data['message'] = "Email is already registered";
            return $data;
        }
    }

    public function testmail()
    {
        $data['title'] = "hello test";
        CRUDBooster::sendEmail(['to' => "amitdev67@gmail.com", 'data' => $data, 'template' => 'Receipt']);
        echo "message sent";
    }
}
