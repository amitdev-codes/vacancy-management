<?php
namespace App\Http\Controllers;

use DB;
use Request;
use Session;
use Vinkla\Hashids\Facades\Hashids;

class CBHook extends Controller
{

    /*
    | --------------------------------------
    | Please note that you should re-login to see the session work
    | --------------------------------------
    |
     */
    public function afterLogin()
    {
        $user = DB::table(config('crudbooster.USER_TABLE'))->where("id", Session::get('admin_id'))->first();
        Session::put('email', $user->email);

        $designation=DB::table('mst_designation')->select('code','name_en')->whereIs_deleted(false)->orderBy('work_level_id', 'ASC')->get();
        Session::put('designation', $designation);

        // get applicant service details
        $user_profile = DB::table('applicant_service_history as ash')->select(
            'user_id as applicant_id',
            'mwo.name_en AS working_office',
            'md.name_en AS current_designation',
            'mwsg.id AS servicegroup_id',
            'mwsg.name_en AS servicegroup',
            'mwssg.id as servicesubgroup_id',
            'mwssg.name_en as servicesubgroup',
            'md.work_level_id',
            'wl.name_en as work_level',
            'ws.id as work_service_id'
        )
            ->leftjoin('mst_working_office as mwo', 'ash.working_office', '=', 'mwo.id')
            ->leftjoin('mst_designation as md', 'ash.designation', '=', 'md.id')
            ->leftjoin('mst_work_level as wl', 'md.work_level_id', '=', 'wl.id')
            ->leftjoin('mst_work_service as ws', 'ash.work_service_id', '=', 'ws.id')
            ->leftjoin('mst_work_service_group as mwsg', 'mwsg.id', '=', 'ash.service_group')
            ->leftjoin('mst_work_service_sub_group as mwssg', 'mwssg.id', '=', 'ash.service_subgroup')
            ->leftjoin('applicant_profile as ap', 'ash.applicant_id', '=', 'ap.user_id')
            ->where([["ash.applicant_id", $user->id], ["ash.is_current", 1], ["ash.is_deleted", 0]])
            ->get();

        Session::put('working_office', ($user_profile[0]->working_office));
        Session::put('current_designation', ($user_profile[0]->current_designation));
        Session::put('work_level', ($user_profile[0]->work_level));
        Session::put('work_level_id', ($user_profile[0]->work_level_id));
        Session::put('servicegroup_id', ($user_profile[0]->servicegroup_id));
        Session::put('servicesubgroup_id', ($user_profile[0]->servicesubgroup_id));
        Session::put('work_service_id', ($user_profile[0]->work_service_id));
        // Session::put('servicegroup', ($user_profile[0]->servicegroup));
        // Session::put('servicesubgroup', ($user_profile[0]->servicesubgroup));

        //amit changes for user profile at header for ntc staff for internal
        $fiscal_year = DB::table('mst_fiscal_year')->select('id', 'code', 'date_to_ad','date_from_ad')->where("is_current", 1)->first();
        Session::put('fiscal_year_id', ($fiscal_year->id));
        Session::put('fiscal_year_code', ($fiscal_year->code));
        Session::put('fy_date_from_ad', ($fiscal_year->date_from_ad));
        Session::put('fy_date_to_ad', ($fiscal_year->date_to_ad));

        $prev_fiscal_year = DB::table('mst_fiscal_year')
            ->select('id', 'code', 'date_to_ad')
            ->where("is_current", 0)
            ->orderBy('date_to_ad', 'desc')
            ->first();
        Session::put('pfy_date_to_ad', ($prev_fiscal_year->date_to_ad));

        $admin_photo = Session::get('admin_photo');
        $photo = end(explode('/', $admin_photo));
        if ($photo == "avatar.jpg") {
            Session::put('admin_photo', "/images/no-user-image.gif");
        }
        $user = DB::table(config('crudbooster.USER_TABLE'))->where("id", Session::get('admin_id'))->first();
        Session::put('id_cms_privileges', ($user->id_cms_privileges == 0 ? null : $user->id_cms_privileges));

        if ($user->id_cms_privileges == 4) {
            $photo = DB::table('applicant_profile')
                ->select("photo")
                ->where("user_id", $user->id)
                ->first();
            $photoUrl = $photo->photo;
            if (isset($photoUrl) && $photoUrl !== '') {
                Session::put('admin_photo', '/' . $photo->photo);
            }
            $appli = DB::table('applicant_profile')
                ->select("id", "user_id", "photo", "is_nt_staff", "nt_staff_code")
                ->where("user_id", $user->id)
                ->first();
            if (isset($appli)) {
                Session::put('is_applicant', 1);
                Session::put('is_nt_staff', $appli->is_nt_staff);
                Session::put('nt_staff_code', $appli->nt_staff_code);
                // Session::put('applicant_id', Hashids::encode($appli->id));
                // $appli->id=339;

                // dd(Hashids::encode($appli->id,10));

                // $hashids = new Hashids('', 10);

                
                // dd(Hashids::decode('8e94'));
                // Session::put('applicant_id', Hashids::encode($appli->id,10));

                // dd(Hashids::encode($appli->id),$appli->id);

                Session::put('applicant_id', Hashids::encode($appli->id));
            } else {
                Session::flush();
                return redirect()->route('getLogin')->with('message', trans("crudbooster.applicant_id_not_linked"));
            }
        } else {
            //check the ip for white-list

            $admin_ip = env('ADMIN_IPS');
            $allowed_ip = explode(';', $admin_ip);
            $request_ip = Request::server('REMOTE_ADDR');
            if (in_array(Request::server('REMOTE_ADDR'), $allowed_ip)) {
                Session::put('is_applicant', 0);
                Session::put('applicant_id', null);
            } else {
                Session::flush();
                return redirect()->route('home')->with('message', trans("crudbooster.invalid_access"));
            }
        }
    }
}
