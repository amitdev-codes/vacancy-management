<?php

namespace App\Http\Controllers;

use DB;
use App;
use PDF;
use View;
use Session;
use Storage;
use CRUDBooster;
use Carbon\Carbon;
use App\Helpers\Helper;
use App\Models\VacancyExam;
use App\Models\VacancyApply;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;

class DashboardController extends BaseCBController
{

    //$this->load_js[] = asset("dashboard.css");

    public function index()
    {
        $this->is_index = true;
        if(!empty(CRUDBooster::myPrivilegeId())) {
            if (Session::get("is_applicant") == 1) {
                $hashed_applicant_id = Session::get("applicant_id");
                $decodeded_applicant_id = Hashids::decode($hashed_applicant_id);
                $user_id = $decodeded_applicant_id[0];
                Session::get('fiscal_year_id');

                $applied_post_exams=VacancyExam::appliedapplicant($user_id)
                                   ->select('vacancy_post_id')
                                   ->whereNotnull('exam_center')
                                   ->where('vacancy_exam.is_deleted',0)
                                   ->distinct()
                                   ->get()
                                   ->toArray();

                                //    dd($applied_post_exams);

    

                $applied_exams=VacancyApply::filter($user_id)
                              ->select('vacancy_post.id as post_id', 'vacancy_post.ad_no as ad_no', 'vacancy_apply.designation_id', 'vacancy_apply.token_number', 'mst_designation.name_en as name', 'vacancy_apply.applied_date_bs as adb')
                              ->leftjoin('mst_designation','mst_designation.id','vacancy_apply.designation_id')
                              ->leftjoin('vacancy_post','vacancy_post.id','vacancy_apply.vacancy_post_id')
                              ->whereIn('vacancy_post_id',$applied_post_exams)
                              ->where('vacancy_apply.is_rejected',0)
                              ->distinct()->get();
                            //   dd($applied_exams);



                $roll_number = DB::table('vacancy_exam')
                    ->select('vacancy_exam.vacancy_post_id as post_id', 'vacancy_exam.designation_id', 'vacancy_exam.exam_roll_no', 'vacancy_post_paper.id as paper_id', 'mst_exam_centre.name_np')
                    ->leftjoin('mst_exam_centre', 'mst_exam_centre.id', '=', 'vacancy_exam.exam_center')
                    ->leftjoin('vacancy_post_paper', 'vacancy_exam.vacancy_post_id', '=', 'vacancy_post_paper.vacancy_post_id')
                    ->distinct()
                    ->where('vacancy_exam.applicant_id', $user_id)
                    ->where('vacancy_exam.is_deleted',0)
                    ->get();

                $degination_paper = DB::table('vacancy_post_paper')
                    ->select('vacancy_post.id as post_id', 'vacancy_post.designation_id', 'vacancy_post_exam.date_bs', 'vacancy_post_paper.paper_name_np as name', 'vacancy_post_paper.id as paper_id', 'vacancy_post_exam.time_from as time')
                    ->leftjoin('vacancy_post', 'vacancy_post.id', '=', 'vacancy_post_paper.vacancy_post_id')
                    ->leftjoin('vacancy_post_exam', 'vacancy_post_exam.paper_id', '=', 'vacancy_post_paper.id')
                    ->distinct()
                    ->get();

                    // dd($applied_exams,$designation_paper,$roll_number);

                return view("dashboard_applicant", compact('applied_exams', 'degination_paper', 'roll_number'));
            } else {
                $today = date('Y-m-d');
                $yesterday = date('Y-m-d', strtotime($today . "-1 days"));
                $weekly = date('Y-m-d', strtotime($today . "-7 days"));
                $tomorrow = date('Y-m-d', strtotime($today . "+1 days"));
                $fiscal_year_id=Session::get('fiscal_year_id');

                #todays from psps
                $data['esewa_pay_today'] = DB::select("select COALESCE
            ( SUM( total_amount ), 0 ) AS total_pay from web_payment_log where ntc_update_datetime >= :today and ntc_update_datetime < :tomorrow and ntc_update_status is true and psp_id=:pspid and fiscal_year_id=:fiscal_year_id", ['today' => $today, 'pspid' => 1, 'tomorrow' => $tomorrow,'fiscal_year_id'=>$fiscal_year_id]);

                $data['khalti_pay_today'] = DB::select("select COALESCE
            ( SUM( total_amount ), 0 ) AS total_pay from web_payment_log where ntc_update_datetime >= :today and ntc_update_datetime < :tomorrow and ntc_update_status is true and psp_id=:pspid and fiscal_year_id=:fiscal_year_id", ['today' => $today, 'pspid' => 3, 'tomorrow' => $tomorrow,'fiscal_year_id'=>$fiscal_year_id]);

                     $data['namastepay_pay_today'] = DB::select("select COALESCE
            ( SUM( total_amount ), 0 ) AS total_pay from web_payment_log where ntc_update_datetime >= :today and ntc_update_datetime < :tomorrow and ntc_update_status is true and psp_id=:pspid and fiscal_year_id=:fiscal_year_id", ['today' => $today, 'pspid' => 5, 'tomorrow' => $tomorrow,'fiscal_year_id'=>$fiscal_year_id]);

                $data['Ips_pay_today'] = DB::select("select COALESCE
            ( SUM( total_amount ), 0 ) AS total_pay from web_payment_log where ntc_update_datetime >= :today and ntc_update_datetime < :tomorrow and ntc_update_status is true and psp_id=:pspid and fiscal_year_id=:fiscal_year_id", ['today' => $today, 'pspid' => 2, 'tomorrow' => $tomorrow,'fiscal_year_id'=>$fiscal_year_id]);

            $data['sajilopay_pay_today'] = DB::select("select COALESCE
            ( SUM( total_amount ), 0 ) AS total_pay from web_payment_log where ntc_update_datetime >= :today and ntc_update_datetime < :tomorrow and ntc_update_status is true and psp_id=:pspid and fiscal_year_id=:fiscal_year_id", ['today' => $today, 'pspid' => 6, 'tomorrow' => $tomorrow,'fiscal_year_id'=>$fiscal_year_id]);

                #yesterday from psps
                $data['esewa_pay_yesterday'] = DB::select("select COALESCE
            ( SUM( total_amount ), 0 ) AS total_pay from web_payment_log where ntc_update_datetime >= :yesterday and ntc_update_datetime < :today and ntc_update_status is true and psp_id=:pspid and fiscal_year_id=:fiscal_year_id", ['yesterday' => $yesterday, 'pspid' => 1, 'today' => $today,'fiscal_year_id'=>$fiscal_year_id]);

                     $data['namastepay_pay_yesterday'] = DB::select("select COALESCE
            ( SUM( total_amount ), 0 ) AS total_pay from web_payment_log where ntc_update_datetime >= :yesterday and ntc_update_datetime < :today and ntc_update_status is true and psp_id=:pspid and fiscal_year_id=:fiscal_year_id", ['yesterday' => $yesterday, 'pspid' => 5, 'today' => $today,'fiscal_year_id'=>$fiscal_year_id]);

              
            $data['sajilopay_pay_yesterday'] = DB::select("select COALESCE
            ( SUM( total_amount ), 0 ) AS total_pay from web_payment_log where ntc_update_datetime >= :yesterday and ntc_update_datetime < :today and ntc_update_status is true and psp_id=:pspid and fiscal_year_id=:fiscal_year_id", ['yesterday' => $yesterday, 'pspid' => 6, 'today' => $today,'fiscal_year_id'=>$fiscal_year_id]);

            $data['khalti_pay_yesterday'] = DB::select("select COALESCE
            ( SUM( total_amount ), 0 ) AS total_pay from web_payment_log where ntc_update_datetime >= :yesterday and ntc_update_datetime < :today and ntc_update_status is true and psp_id=:pspid and fiscal_year_id=:fiscal_year_id", ['yesterday' => $yesterday, 'pspid' => 3, 'today' => $today,'fiscal_year_id'=>$fiscal_year_id]);

                $data['Ips_pay_yesterday'] = DB::select("select COALESCE
            ( SUM( total_amount ), 0 ) AS total_pay from web_payment_log where ntc_update_datetime >= :yesterday and ntc_update_datetime < :today and ntc_update_status is true and is_deleted is false and psp_id=:pspid and fiscal_year_id=:fiscal_year_id", ['yesterday' => $yesterday, 'pspid' => 2, 'today' => $today,'fiscal_year_id'=>$fiscal_year_id]);

                #yweekly from psps
                $data['esewa_pay_weekly'] = DB::select("select COALESCE
            ( SUM( total_amount ), 0 ) AS total_pay from web_payment_log where  (ntc_update_datetime BETWEEN :weekly and :today)  and ntc_update_status is true and psp_id=:pspid and fiscal_year_id=:fiscal_year_id", ['weekly' => $weekly, 'pspid' => 1, 'today' => $today,'fiscal_year_id'=>$fiscal_year_id]);

                     $data['namastepay_pay_weekly'] = DB::select("select COALESCE
            ( SUM( total_amount ), 0 ) AS total_pay from web_payment_log where  (ntc_update_datetime BETWEEN :weekly and :today)  and ntc_update_status is true and psp_id=:pspid and fiscal_year_id=:fiscal_year_id", ['weekly' => $weekly, 'pspid' => 5, 'today' => $today,'fiscal_year_id'=>$fiscal_year_id]);


            $data['sajilopay_pay_weekly'] = DB::select("select COALESCE
            ( SUM( total_amount ), 0 ) AS total_pay from web_payment_log where  (ntc_update_datetime BETWEEN :weekly and :today)  and ntc_update_status is true and psp_id=:pspid and fiscal_year_id=:fiscal_year_id", ['weekly' => $weekly, 'pspid' => 6, 'today' => $today,'fiscal_year_id'=>$fiscal_year_id]);


                $data['khalti_pay_weekly'] = DB::select("select COALESCE
            ( SUM( total_amount ), 0 ) AS total_pay from web_payment_log where  (ntc_update_datetime BETWEEN :weekly and :today)  and ntc_update_status is true and is_deleted is false and psp_id=:pspid and fiscal_year_id=:fiscal_year_id", ['weekly' => $weekly, 'pspid' => 3, 'today' => $today,'fiscal_year_id'=>$fiscal_year_id]);

                $data['Ips_pay_weekly'] = DB::select("select COALESCE
            ( SUM( total_amount ), 0 ) AS total_pay from web_payment_log where  (ntc_update_datetime BETWEEN :weekly and :today)  and ntc_update_status is true and is_deleted is false and psp_id=:pspid and fiscal_year_id=:fiscal_year_id", ['weekly' => $weekly, 'pspid' => 2, 'today' => $today,'fiscal_year_id'=>$fiscal_year_id]);

                #total from psps
                $data['esewa_pay_total'] = DB::select("select COALESCE
            ( SUM( total_amount ), 0 ) AS total_pay from web_payment_log where   ntc_update_status is true and is_deleted is false and psp_id=:pspid and fiscal_year_id=:fiscal_year_id", ['pspid' => 1,'fiscal_year_id'=>$fiscal_year_id]);

                   $data['namastepay_pay_total'] = DB::select("select COALESCE
            ( SUM( total_amount ), 0 ) AS total_pay from web_payment_log where   ntc_update_status is true and is_deleted is false and psp_id=:pspid and fiscal_year_id=:fiscal_year_id", ['pspid' => 5,'fiscal_year_id'=>$fiscal_year_id]);


            $data['sajilopay_pay_total'] = DB::select("select COALESCE
            ( SUM( total_amount ), 0 ) AS total_pay from web_payment_log where   ntc_update_status is true and is_deleted is false and psp_id=:pspid and fiscal_year_id=:fiscal_year_id", ['pspid' => 6,'fiscal_year_id'=>$fiscal_year_id]);


                $data['khalti_pay_total'] = DB::select("select COALESCE
            ( SUM( total_amount ), 0 ) AS total_pay from web_payment_log where   ntc_update_status is true and is_deleted is false and psp_id=:pspid and fiscal_year_id=:fiscal_year_id", ['pspid' => 3,'fiscal_year_id'=>$fiscal_year_id]);

                $data['Ips_pay_total'] = DB::select("select COALESCE
            ( SUM( total_amount ), 0 ) AS total_pay from web_payment_log where   ntc_update_status is true and is_deleted is false and psp_id=:pspid and fiscal_year_id=:fiscal_year_id", ['pspid' => 2,'fiscal_year_id'=>$fiscal_year_id]);


                $data['pay_today'] = DB::select("select COALESCE
            ( SUM( total_amount ), 0 ) AS total_pay from web_payment_log where ntc_update_datetime >= :today and ntc_update_datetime < :tomorrow and ntc_update_status is true and is_deleted is false and fiscal_year_id=:fiscal_year_id", ['today' => $today, 'tomorrow' => $tomorrow,'fiscal_year_id'=>$fiscal_year_id]);

                $data['pay_yesterday'] = DB::select("select COALESCE
            ( SUM( total_amount ), 0 ) AS total_pay from web_payment_log where ntc_update_datetime >= :yesterday and ntc_update_datetime < :today and ntc_update_status is true and is_deleted is false and fiscal_year_id=:fiscal_year_id", ['yesterday' => $yesterday, 'today' => $today,'fiscal_year_id'=>$fiscal_year_id]);

                $data['pay_weekly'] = DB::select("select COALESCE
            ( SUM( total_amount ), 0 ) AS total_pay from web_payment_log where (ntc_update_datetime BETWEEN :weekly and :today) and ntc_update_status is true and is_deleted is false and fiscal_year_id=:fiscal_year_id", ['weekly' => $weekly, 'today' => $today,'fiscal_year_id'=>$fiscal_year_id]);

                $data['pay_total'] = DB::select("select COALESCE
            ( SUM( total_amount ), 0 ) AS total_pay from web_payment_log where ntc_update_status is true and is_deleted is false and fiscal_year_id=:fiscal_year_id",['fiscal_year_id'=>$fiscal_year_id]);
                return view('dashboard_admin', $data);
            }
        }
        return response()->view('errors.404', [], 404);
        
    }

    public function getapplicantByPrivilegeFroup()
    {
        $female = DB::table('vacancy_apply')
            ->where('is_female', '=', 1)
            ->where('fiscal_year_id', Session::get('fiscal_year_id'))
            ->count();
        $janajati = DB::table('vacancy_apply')
            ->where('is_janajati', '=', 1)
            ->where('fiscal_year_id', Session::get('fiscal_year_id'))
            ->count();
        $dalit = DB::table('vacancy_apply')
            ->where('is_dalit', '=', 1)
            ->where('fiscal_year_id', Session::get('fiscal_year_id'))
            ->count();
        $handicapped = DB::table('vacancy_apply')
            ->where('is_handicapped', '=', 1)
            ->where('fiscal_year_id', Session::get('fiscal_year_id'))
            ->count();
        $remote_village = DB::table('vacancy_apply')
            ->where('is_remote_village', '=', 1)
            ->where('fiscal_year_id', Session::get('fiscal_year_id'))
            ->count();
        $open = DB::table('vacancy_apply')
            ->where('is_open', '=', 1)
            ->where('fiscal_year_id', Session::get('fiscal_year_id'))
            ->count();
        #applicant chart
        $data = array("chart" => array("labels" => ['Female', 'Janajati', 'Dalit', 'Handicapped', 'Remote Village', 'Open']),
            "datasets" => array(
                array("name" => "Applicants By Privilege Group", "values" => array($female, $janajati, $dalit, $handicapped, $remote_village, $open)),
            ),
        );
        return response()->json($data);
    }

    public function psptotaldata(){
    
           $fiscal_year_id=Session::get('fiscal_year_id');
        
    

        $psptotal=DB::select('SELECT
	          mpm.name_en as psp_name,
	          sum(total_amount) as psp_amount
    FROM
        web_payment_log wbl
        left join mst_payment_methods mpm on wbl.psp_id=mpm.id
    WHERE
        ntc_update_status IS TRUE and wbl.is_deleted is false and wbl.fiscal_year_id=:fiscal_year_id
        GROUP BY psp_id',['fiscal_year_id'=>$fiscal_year_id]);

          foreach ($psptotal as $key=>$p) {
              $p_name = $p->psp_name;
              $p_amount = $p->psp_amount;
              $psp_modes[] = $p_name;
              $psp_amount[] = $p_amount;
              }

                $data = array("chart" => array("labels" =>$psp_modes),"datasets" => array(array("name" => "PSP Chart", "values" => $psp_amount),
                ),
            );

            return response()->json($data);

    }

    public function pspdata(){
           $fiscal_year_id=Session::get('fiscal_year_id');

        $pspdata=DB::select('SELECT
        mpm.name_en as psp_name,
        count(*) as psp_paid_count 
    FROM
        web_payment_log wbl
        left join mst_payment_methods mpm on wbl.psp_id=mpm.id
    WHERE
        ntc_update_status IS TRUE and wbl.is_deleted is false and wbl.fiscal_year_id=:fiscal_year_id
        GROUP BY psp_id',['fiscal_year_id'=>$fiscal_year_id]);

          foreach ($pspdata as $key=>$p) {
              $p_name = $p->psp_name;
              $p_count = $p->psp_paid_count;
              $psp_modes[] = $p_name;
              $psp_counts[] = $p_count;
              }

                $data = array("chart" => array("labels" =>$psp_modes),"datasets" => array(array("name" => "PSP Chart", "values" => $psp_counts),
                ),
            );

            return response()->json($data);

    }

    public function designation_chart()
    {

    //    $designation = DB::table('vacancy_apply')
    //         ->leftjoin('mst_designation', 'vacancy_apply.designation_id', '=', 'mst_designation.id')
    //         ->selectRaw('mst_designation.name_en as designation_name, count(*) as designation_count')
    //         ->where('vacancy_apply.is_deleted',false)
    //         ->where('vacancy_apply.fiscal_year_id', Session::get('fiscal_year_id'))
    //         ->groupBy('designation_id')
    //         ->get(); 
    $designation = DB::table('vacancy_apply as va')
    ->leftJoin('mst_designation as md', 'va.designation_id', '=', 'md.id')
    ->where('va.fiscal_year_id', '=', Session::get('fiscal_year_id'))
    ->where('va.is_deleted', '=', false)
    ->where('va.is_cancelled', '=', false)
    ->where('va.is_rejected', '=', false)
    ->select('md.name_en as designation_name', DB::raw('COUNT(va.designation_id) AS designation_count'))
    ->groupBy('va.designation_id')
    ->orderByDesc('designation_count')
    ->get();
       
            
            foreach ($designation as $key=>$d) {
                $d_name = $d->designation_name;
                $d_count = $d->designation_count;
                $design_name[] = $d_name;
                $design_count[] = $d_count;
                }

        #designation chart
        $data = array("chart" => array("labels" =>$design_name),
        "datasets" => array(
            array("name" => "Designation Chart", "values" => $design_count),
        ),
    );
        // $data = array("chart" => array("labels" => array($designation->pluck('designation_name')),
        //     "datasets" => array(
        //         array("name" => "Designation Chart", "values" => array($designation[0]->designation_count)),
        //     ),
        // );
        return response()->json($data);
    }

    public function reg_user_chart()
    {
        $registered_male_users = DB::table('applicant_profile')
            ->select(DB::raw('gender_id'))
            ->where('gender_id', '=', 1)
            ->count();

        $registered_female_users = DB::table('applicant_profile')
            ->select(DB::raw('gender_id'))
            ->where('gender_id', '=', 2)
            ->count();

        $registered_gender_unspecifed_users = DB::table('applicant_profile')
            ->select(DB::raw('gender_id'))
            ->where('gender_id', '=', 3)
            ->count();
        #designation chart
        $data = array("chart" => array("labels" => ['Male', 'Female', 'Third Gender']),
            "datasets" => array(
                array("name" => "Registered Users", "values" => array($registered_male_users, $registered_female_users, $registered_gender_unspecifed_users)),
            ),
        );
        return response()->json($data);
    }

    public function paid_cancelled_applicant_chart()
    {
        $paid_applicant_data = $paid_applicant_data = DB::table('vacancy_apply')
        ->where('is_paid', true)
        ->where('fiscal_year_id',Session::get('fiscal_year_id'))
        ->where('is_deleted', false)
        ->where('is_cancelled', false)
        ->where('is_rejected', false)
        ->count();

        $cancelled_applicant_data = DB::table('vacancy_apply')
            ->where('is_cancelled',true)
            ->where('fiscal_year_id', Session::get('fiscal_year_id'))
            ->count();

        $rejected_applicant_data = DB::table('vacancy_apply')
            ->whereRaw('is_rejected = 1')
            ->where('fiscal_year_id', Session::get('fiscal_year_id'))
            ->count();

        $total_applicant_data = DB::table('vacancy_apply')
        ->where('fiscal_year_id', Session::get('fiscal_year_id'))
            ->count();
        #paid_cancelled_applicant_chart chart
        $data = array("chart" => array("labels" => ['Total', 'Paid', 'Cancelled', 'Rejected']),
            "datasets" => array(
                array("name" => "Paid / Canceled / Rejected Applicants", "values" => array($total_applicant_data, $paid_applicant_data, $cancelled_applicant_data, $rejected_applicant_data)),
            ),
        );
        return response()->json($data);
    }

    public function generateAdminCardForUser($token_number)
    {
        $post_id = DB::table('vacancy_apply')
            ->select('vacancy_post_id')
            ->where('token_number', $token_number)
            ->first();


        $storage_path = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
        // dd($storage_path);


        // $working_path = 'admit_card/open_exam/' .$post_id->vacancy_post_id;
        // $admit_card_path = $working_path . "/" . $token_number . "_AdmitCard" . ".html";

        $admit_card_path=public_path('admitcard/'.$post_id->vacancy_post_id. "/" . $token_number . "_AdmitCard" . ".html");
        $url = $admit_card_path ;
        $path='/admitcard/'.$post_id->vacancy_post_id. "/" . $token_number . "_AdmitCard" . ".html";
        $baseUrl = url('/');
        $admit_card_url=$baseUrl.$path;
        return redirect( $admit_card_url);




        // $url = $storage_path . 'admit_card/open/' . $post_id->vacancy_post_id . '/' . $token_number . '_AdmitCard.html';

        $file = file_get_contents($url, true);
        $pdf = App::make('snappy.pdf.wrapper');
        $pdf->loadHTML($file);
        return $pdf->inline();

    }
    private function generateHtml()
    {
        $this->working_path = 'AdmitCards';
        $date = date('Y-m-d H:i:s');
        Storage::makeDirectory($this->working_path);
        //  $this->final_pdf_filepath = $storage_path."/".$client_id."_ProfileBook_".$working_folder.".pdf";
        //$this->final_pdf_filepath = $working_path."/".$client_id."_ProfileBook_".$working_folder.".pdf";
        $this->final_html_filepath = $this->working_path . "/" . $date . "admitcard.html";
        $a = View::make('user_admitcard.index', compact('admit_card'))->render();
        Storage::put($this->final_html_filepath, $a);
    }

    public function getpassword(Request $request)
    {
        $id = CRUDBooster::myId();
        $oldpassword = $request->get('current_password');
        $newpassword = $request->get('newpassword');
        $passwordconfirm = $request->get('password_confirmation');
        if ($oldpassword == $newpassword) {
            echo "<script>alert('New password and old password are same. Please create a new password.');history.go(-1);</script>";
            return;
        }
        if ($newpassword != $passwordconfirm) {
            echo "<script>alert('New password and confirm password do not match!');history.go(-1);</script>";
            return;
        }

        $users = DB::table(config('crudbooster.USER_TABLE'))->where('id', $id)->first();
        if (\Hash::check($oldpassword, $users->password)) {
            $date = Carbon::now();
            $newpassword = \Hash::make($newpassword);
            $data = array('password' => $newpassword, 'updated_at' => $date);

            $changed_password = DB::table('cms_users')
                ->where('id', '=', $id)
                ->update($data);
            // return redirect(CRUDBooster::adminPath());
            CRUDBooster::redirect(CRUDBooster::adminPath(), "Your password was succesfully changed");
        } else {
            echo "<script>alert('" . trans('crudbooster.alert_password_wrong') . "');history.go(-1);</script>";
        }
    }

}
