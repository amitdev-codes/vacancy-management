<?php namespace App\Http\Controllers;

use App\Helpers;
use App\Helpers\VAARS;
use Bsdate;
use Carbon\Carbon;
use CRUDBooster;
use DateTime;
use DateTimeZone;
use DB;
use Exception;
use Request;
use Schema;
use Session;
use Vinkla\Hashids\Facades\Hashids;

class AdminVacancyApplyController extends BaseCBController
{
    public function cbInit()
    {

        # START CONFIGURATION DO NOT REMOVE THIS LINE
        $this->title_field = "id";
        $this->limit = "20";
        $this->orderby = "id,desc";
        $this->global_privilege = false;
        $this->button_table_action = true;
        $this->button_bulk_action = false;
        $this->button_action_style = "button_icon";
        $this->button_add = false;
        $this->button_edit = false;
        $this->button_delete = true;
        $this->button_detail = false;
        $this->button_show = true;
        $this->button_filter = true;
        $this->button_import = false;
        $this->button_export = false;
        $this->table = "vacancy_apply";

        # END CONFIGURATION DO NOT REMOVE THIS LINE

        # START COLUMNS DO NOT REMOVE THIS LINE

        $this->col = array();
        $this->col[] = array("label" => "ID", "name" => "id", "width" => "60px");
        $this->col[] = array("label" => "Ad No", "name" => "ad_no", "width" => "60px");
        $this->col[] = ["label" => "Designation", "name" => "trim(concat(designation_en,'<br/>',designation_np)) as designation"];

        $this->col[] = array("label" => "Published B.S.", "name" => "published_date_bs", "width" => "75px");
        $this->col[] = array("label" => "Last B.S.", "name" => "last_date_bs", "width" => "75px");
        $this->col[] = array("label" => "Last A.D.", "name" => "last_date_ad", "width" => "75px");
        if (Session::get("is_applicant") != 1) {
            $this->col[] = array("label" => "Applicant ID", "name" => "applicant_id");
            $this->col[] = array("label" => "Applicant", "name" => "name_en");
        }
        $this->col[] = array("label" => "Applied B.S.", "name" => "applied_date_bs", "width" => "75px");
        $this->col[] = ["label" => "Apply Email Log", "link" => "Email Log", "name" => "apply_email_log_path", "width" => "45px"];
        $this->col[] = array("label" => "Token No.", "name" => "token_number", "width" => "75px");
        $this->col[] = array("label" => "Total Fee", "name" => "total_amount", "width" => "75px");
        $this->col[] = array("label" => "Receipt No", "name" => "paid_receipt_no", "width" => "75px");
        $this->col[] = array("label" => "Paid Date", "name" => "paid_date_bs", "width" => "75px");
        $this->col[] = array("label" => "Canceled", "name" => "case when is_cancelled = 1 then 'YES' ELSE 'NO' END as is_cancelled", "width" => "75px");
        $this->col[] = array("label" => "Paid", "name" => "case when is_paid = 1 then 'YES' ELSE 'NO' END as is_paid", "width" => "75px");
        $this->col[] = ["label" => "Cancel Email Log", "link" => "Email Log", "name" => "cancel_email_log_path", "width" => "30px"];
        $this->col[] = array("label" => "Rejected", "name" => "case when is_rejected = 1 then 'YES' ELSE 'NO' END as is_rejected", "width" => "75px");
        $this->col[] = ["label" => "Reject Email Log", "link" => "Email Log", "name" => "reject_email_log_path", "width" => "30px"];
        # END COLUMNS DO NOT REMOVE THIS LINE

        # START FORM DO NOT REMOVE THIS LINE
        $this->form = [];
        $this->form[] = ['label' => 'is_rejected', 'name' => 'is_rejected', 'type' => 'hidden', 'validation' => 'required', 'value' => 0];
        //$this->form[] = ['label'=>'is_rejected','name'=>'is_rejected','type'=>'hidden','validation'=>'required','value'=>0];
        $this->form[] = ['label' => 'is_cancelled', 'name' => 'is_cancelled', 'type' => 'hidden', 'validation' => 'required', 'value' => 0];
        $this->form[] = ['label' => 'is_paid', 'name' => 'is_paid', 'type' => 'hidden', 'validation' => 'required', 'value' => 0];
        $this->form[] = ['label' => 'Applicant Id', 'name' => 'applicant_id', 'type' => 'select2', 'validation' => 'integer|min:0', 'width' => 'col-sm-10', 'datatable' => 'applicant_profile,id'];
        $this->form[] = ['label' => 'Vacancy Post Id', 'name' => 'vacancy_post_id', 'type' => 'text-c', 'readonly' => 'readonly', 'width' => 'col-sm-10', 'datatable' => 'vacancy_post,id'];
        $this->form[] = ['label' => 'Designation Id', 'name' => 'designation_id', 'type' => 'select2-c', 'validation' => 'max:255', 'cmp-ratio' => '12:12:6', 'datatable' => 'mst_designation,name_en'];
        $this->form[] = ['label' => 'Applied Date Ad', 'name' => 'applied_date_ad', 'type' => 'date-c', 'validation' => 'date', 'cmp-ratio' => '4:12:8'];
        $this->form[] = ['label' => 'Applied Date Bs', 'name' => 'applied_date_bs', 'type' => 'date-n', 'validation' => 'min:1|max:255', 'cmp-ratio' => '8:12:4'];
        $this->form[] = ['label' => 'Female', 'name' => 'is_female', 'type' => 'radio-c', 'validation' => 'integer', 'cmp-ratio' => '3:6:6', 'dataenum' => '1|Yes;0|NO'];
        $this->form[] = ['label' => 'Janajati', 'name' => 'is_janajati', 'type' => 'radio-c', 'validation' => 'integer', 'cmp-ratio' => '3:6:6', 'dataenum' => '1|Yes;0|NO'];
        $this->form[] = ['label' => 'Madehsi', 'name' => 'is_madhesi', 'type' => 'radio-c', 'validation' => 'integer', 'cmp-ratio' => '3:6:6', 'dataenum' => '1|Yes;0|NO'];
        $this->form[] = ['label' => 'Dalit', 'name' => 'is_dalit', 'type' => 'radio-c', 'validation' => 'integer', 'cmp-ratio' => '3:6:6', 'dataenum' => '1|Yes;0|NO'];
        $this->form[] = ['label' => 'Handicapped', 'name' => 'is_handicapped', 'type' => 'radio-c', 'validation' => 'integer', 'cmp-ratio' => '3:6:6', 'dataenum' => '1|Yes;0|NO'];
        $this->form[] = ['label' => 'Handicapped', 'name' => 'is_open', 'type' => 'radio-c', 'validation' => 'integer', 'cmp-ratio' => '3:6:6', 'dataenum' => '1|Yes;0|NO'];
        $this->form[] = ['label' => 'Remote Village', 'name' => 'is_remote_village', 'type' => 'radio-c', 'validation' => 'integer', 'cmp-ratio' => '9:6:6', 'dataenum' => '1|Yes;0|NO'];
        $this->form[] = ['label' => 'Amount For Job', 'name' => 'amount_for_job', 'type' => 'text-c', 'validation' => 'numeric', 'cmp-ratio' => '4:12:6'];
        $this->form[] = ['label' => 'Amount For Privilege Group', 'name' => 'amount_for_priv_grp', 'type' => 'text-c', 'validation' => 'numeric', 'cmp-ratio' => '4:12:6'];
        $this->form[] = ['label' => 'Total Amount', 'name' => 'total_amount', 'type' => 'text-c', 'validation' => 'numeric', 'cmp-ratio' => '4:12:6'];
        $this->form[] = ['label' => 'Token Number', 'name' => 'token_number', 'type' => 'number-c', 'validation' => 'numeric|min:1', 'cmp-ratio' => '12:12:6'];
        $this->form[] = ['label' => 'Application Confirmed', 'name' => 'is_application_confirmed', 'type' => 'radio-c', 'validation' => 'integer', 'cmp-ratio' => '12:3:8', 'dataenum' => '1|Yes;0|NO'];
        // $this->form[] = ['label'=>'Amount For Submission Date Extension','name'=>'amount_for_extension','type'=>'text-c','validation'=>'numeric','cmp-ratio'=>'12:4:6'];
        $this->form[] = ['label' => 'Age While Applying', 'name' => 'age_while_applying', 'type' => 'number', 'validation' => 'numeric|min:1|max:100', 'cmp-ratio' => '12:12:6'];
         $this->form[] = ['label' => 'Fiscal Year', 'name' => 'fiscal_year_id', 'type' => 'number', 'cmp-ratio' => '12:12:6'];
        # END FORM DO NOT REMOVE THIS LINE
        /*
        | ----------------------------------------------------------------------
        | Sub Module
        | ----------------------------------------------------------------------
        | @label          = Label of action
        | @path           = Path of sub module
        | @foreign_key    = foreign key of sub table/module
        | @button_color   = Bootstrap Class (primary,success,warning,danger)
        | @button_icon    = Font Awesome Class
        | @parent_columns = Sparate with comma, e.g : name,created_at
        |
         */
        $this->sub_module = array();

        /*
        | ----------------------------------------------------------------------
        | Add More Action Button / Menu
        | ----------------------------------------------------------------------
        | @label       = Label of action
        | @url         = Target URL, you can use field alias. e.g : [id], [name], [title], etc
        | @icon        = Font awesome class icon. e.g : fa fa-bars
        | @color       = Default is primary. (primary, warning, succecss, info)
        | @showIf      = If condition when action show. Use field alias. e.g : [id] == 1
        |
         */

        $this->addaction = array();

        // $today = Carbon::today();

        // if (Session::get("is_applicant") && $data[vacancy_extended_date_ad] >= $today) {
        //     $this->addaction[] = ['label' => 'Re-Apply', 'icon' => 'fa fa-check', 'confirmation' => true, 'confirmation_text' => "Are you sure you want to apply again?", "confirmation_title" => "Apply Again", 'color' => 'success', 'url' => CRUDBooster::mainpath('../vacancy_apply/reapply') . '/[id]', 'showIf' => '[is_cancelled] == "YES"'];
        // }

        $this->addaction[] = ['label' => 'Re-Apply', 'icon' => 'fa fa-check', 'confirmation' => true, 'confirmation_text' => "Are you sure you want to apply again?", "confirmation_title" => "Apply Again", 'color' => 'success', 'url' => CRUDBooster::mainpath('../vacancy_apply/reapply') . '/[id]', 'showIf' => '[is_cancelled] == "YES" and [is_rejected]=="NO"']; // and [last_date_ad]<='.date("Y-m-d")
        $this->addaction[] = ['label' => 'View', 'icon' => 'fa fa-eye', 'color' => 'primary', 'url' => CRUDBooster::mainpath('../vacancy_apply/view') . '/[id]'];
        if(CRUDBooster::myPrivilegeId()==1||CRUDBooster::myPrivilegeId()==5){
            $this->addaction[] = ['label' => 'Cancel', 'icon' => 'fa fa-remove', 'color' => 'warning', 'url' => CRUDBooster::mainpath('../vacancy_apply/Cancel') . '/[id]', 'showIf' => '[is_cancelled] == "NO" and [is_paid]=="NO"'];
        }
       

        /*
        | ----------------------------------------------------------------------
        | Add More Button Selected
        | ----------------------------------------------------------------------
        | @label       = Label of action
        | @icon        = Icon from fontawesome
        | @name        = Name of button
        | Then about the action, you should code at actionButtonSelected method
        |
         */
        $this->button_selected = array();

        /*
        | ----------------------------------------------------------------------
        | Add alert message to this module at overheader
        | ----------------------------------------------------------------------
        | @message = Text of message
        | @type    = warning,success,danger,info
        |
         */
        $this->alert = array();

        /*
        | ----------------------------------------------------------------------
        | Add more button to header button
        | ----------------------------------------------------------------------
        | @label = Name of button
        | @url   = URL Target
        | @icon  = Icon from Awesome.
        |
         */
        $this->index_button = array();

        /*
        | ----------------------------------------------------------------------
        | Customize Table Row Color
        | ----------------------------------------------------------------------
        | @condition = If condition. You may use field alias. E.g : [id] == 1
        | @color = Default is none. You can use bootstrap success,info,warning,danger,primary.
        |
         */
        $this->table_row_color = array();

        /*
        | ----------------------------------------------------------------------
        | Customize Table Row Color
        | ----------------------------------------------------------------------
        | @condition = If condition. You may use field alias. E.g : [id] == 1
        | @color = Default is none. You can use bootstrap success,info,warning,danger,primary.
        |
         */
        $this->table_row_color = array();
        // $this->table_row_color[] = ['condition'=>"[is_rejected] == 'NO'","color"=>"danger"];
        $this->table_row_color[] = ['condition' => "[is_cancelled] == 'YES' and [is_rejected] == 'YES'", "color" => "danger"];
        $this->table_row_color[] = ['condition' => "[is_cancelled] == 'YES' and [is_rejected] == 'NO'", "color" => "warning"];

        /*
        | ----------------------------------------------------------------------
        | You may use this bellow array to add statistic at dashboard
        | ----------------------------------------------------------------------
        | @label, @count, @icon, @color
        |
         */
        $this->index_statistic = array();

        /*
        | ----------------------------------------------------------------------
        | Add javascript at body
        | ----------------------------------------------------------------------
        | javascript code in the variable
        | $this->script_js = "function() { ... }";
        |
         */
        $this->script_js = null;

        /*
        | ----------------------------------------------------------------------
        | Include HTML Code before index table
        | ----------------------------------------------------------------------
        | html code to display it before index table
        | $this->pre_index_html = "<p>test</p>";
        |
         */
        $this->pre_index_html = null;
        /*
        | ----------------------------------------------------------------------
        | Include HTML Code after index table
        | ----------------------------------------------------------------------
        | html code to display it after index table
        | $this->post_index_html = "<p>test</p>";
        |
         */
        $this->post_index_html = null;
        /*
        | ----------------------------------------------------------------------
        | Include Javascript File
        | ----------------------------------------------------------------------
        | URL of your javascript each array
        | $this->load_js[] = asset("myfile.js");
        |
         */
        $this->load_js = array();
        $this->load_js[] = asset("js/vacancy_apply.js");

        /*
        | ----------------------------------------------------------------------
        | Add css style at body
        | ----------------------------------------------------------------------
        | css code in the variable
        | $this->style_css = ".style{....}";
        |
         */
        $this->style_css = null;
        /*
        | ----------------------------------------------------------------------
        | Include css File
        | ----------------------------------------------------------------------
        | URL of your css each array
        | $this->load_css[] = asset("myfile.css");
        |
         */
        $this->load_css = array();
    }

    public function getAppliedCount()
    {
        $is_applied_before = DB::table('vacancy_apply')
            ->select(DB::raw('count(*) as applied_count'))
            ->where('applicant_id', '=', CRUDBooster::myId())
            ->first();
    }

    public function getAdd($ad_id=null)
    {
        $data['ad_id'] = $ad_id;
        $data['page_title'] = 'Apply for Post';
        $data['applicant_id'] = $userid = CRUDBooster::myId();

        #1.check if required profile details are empty or not
        try {
            $profile_details = DB::table('applicant_profile')->whereNotNull(['first_name_en',
                'first_name_np',
                'last_name_en',
                'last_name_np',
                'gender_id',
                'dob_bs',
                'religion_id',
                'mothertongue_id',
                'district_id',
                'local_level_id',
                'mobile_no',
                'email',
                'citizenship_no',
                'citizenship_issued_from',
                'citizenship_issued_date_bs',
                'photo',
                'signature_upload',
                'citizenship_upload'])->where([['user_id', $userid], ['is_deleted', false]])->get();
            $profile_isempty = $profile_details->isEmpty();
            if ($profile_isempty == true) {
                CRUDBooster::redirect('app/vacancy_post60', 'please fill all the required fields at profile details', 'warning');
            }
        } catch (Exception $e) {
            if (CRUDBooster::myPrivilegeId() != 4) {
                // dd($e->getMessage());
                return;
            } else {
                CRUDBooster::redirect('app/vacancy_post60', 'Oops! Page Not Found Or is Unvailabale at this moment.Please make sure the URL is correct', 'warning');
            }

        }

        #2.check if required family details are empty or not
        try {
            $family_details = DB::table('applicant_family_info')->whereNotNull([
                'father_name_en',
                'father_name_np',
                'mother_name_en',
                'mother_name_np',
                'grand_father_name_en',
                'grand_father_name_np'])->where([['applicant_id', $userid], ['is_deleted', false]])->get();
            $family_isempty = $family_details->isEmpty();
            if ($family_isempty == true) {
                CRUDBooster::redirect('app/vacancy_post60', 'please fill all the required fields at family details', 'warning');
            }
        } catch (Exception $e) {
            if (CRUDBooster::myPrivilegeId() != 4) {
                dd($e->getMessage());
            } else {
                // dd($e->getMessage());
                CRUDBooster::redirect('app/vacancy_post60', 'Oops! Page Not Found Or is Unvailabale at this moment.Please make sure the URL is correct', 'warning');
            }
        }

        #get gender from applicant id
        $gender = DB::select('SELECT gender_id from applicant_profile where user_id=:applicant_id', ['applicant_id' => $data['applicant_id']]);
        $gender_id = $gender[0]->gender_id;

        #get opening type->open,internal or file promotion
        $ot = DB::select('SELECT DISTINCT
                   opening_type_id
               FROM
                   vw_published_vacancy_posts_all
               WHERE
                   vacancy_ad_id = ( SELECT vacancy_ad_id FROM vacancy_post WHERE id =:ad_id)', ['ad_id' => $ad_id]);
        $opening_type_id = $ot[0]->opening_type_id;
        //$service_group=$ot[0]->service_group_id;

        #get designation id to be applied
        $designation_id = DB::table('vacancy_post')->select('designation_id')->where('id', $data['ad_id'])->get();
        $design_id = $designation_id[0]->designation_id;

        // dd($design_id, $data['ad_id']);
        #get level id
        $level = DB::select('SELECT distinct LEVEL,service_group_id
           FROM
               vw_published_vacancy_posts_all
           WHERE
               designation_id =:id', ['id' => $design_id]);
        $level_id = $level[0]->level;
        $service_group = $level[0]->service_group_id;

        #check if nt_staff or not
        $is_nt_staff = DB::table('applicant_profile')->where('user_id', $data['applicant_id'])->select('is_nt_staff')->get();
        $nt_staff = $is_nt_staff[0]->is_nt_staff;

        #get fiscal year id
        $fY_id = Session::get('fiscal_year_id');

        #last_date to apply for
        $last_date_for_application_ad = DB::select('SELECT last_date_for_application_ad from vacancy_ad where fiscal_year_id=:id and opening_type_id=:ot_id', ['id' => $fY_id, 'ot_id' => $opening_type_id]);
        $last_date_ad = $last_date_for_application_ad[0]->last_date_for_application_ad;

        #validations

        #If not ntstaff
        if (empty($nt_staff)) {
            #for age
            $this->check_for_age($last_date_ad, $design_id, $gender_id);
            #for education degree
            $this->check_for_degree($design_id, $nt_staff, $level_id);
            #for documents attached
            $this->check_for_documents_attached();
        }
        #for nt staff
        else {

            //dd('devs');
            #for service period 3 years check,if worklevel 6 or greater than 6 than 4 years else 3

            // $worklevel=
            $this->check_for_service_period($last_date_ad, $opening_type_id,$level_id);
            #check for service group
            if ($opening_type_id != 1) {
                if($opening_type_id==2){
                    $this->check_for_service_group($service_group);
                }
                
            }
            #for external edu degree should be same for nt staff and non nt staff and for internal check degree and for file promotion doesnt require
            if ($opening_type_id == 1){
                $this->check_for_degree_for_opening($design_id, $level_id);
            }
             if ($opening_type_id == 2){ 
                 $this->check_for_degree($design_id, $nt_staff, $level_id);
            }
        }


        #check for council certificate
        $required_designation_for_council = DB::select('SELECT id from mst_designation where is_council_reg_required=:id', ['id' => 1]);
        foreach ($required_designation_for_council as $key => $council_id) {
            $req_design = $council_id->id;
            $total_design[] = $req_design;
        }
        if (in_array($design_id, $total_design)) {
            $this->check_for_council_certificate($design_id);
        }
        #for experience

       // dd($opening_type_id);

        if ($opening_type_id != 2 && $opening_type_id != 3) {
            if ($level_id == 8 || $level_id == 9) {

                //dd('devs');
                #for C.A. no experience required
                if ($design_id != 4) {
                    //dd('devs');
                    $this->check_for_experience($design_id, $level_id);
                }
            }
        }
        #check if already applied
        $this->is_applied_before($ad_id);
        #check if already cancelled
        $this->is_cancelled($ad_id);

        $data['applicant_name'] = DB::table('applicant_profile')
            ->select(DB::raw('concat(first_name_en,\' \',coalesce(NULLIF(mid_name_en,\'\'),\'\'),\' \',last_name_en) as fullname, gender_id, is_nt_staff'))
            ->where('id', '=', CRUDBooster::myId())
            ->first();
        $data['vacancy_details'] = DB::table('vacancy_post as t1')
            ->select(
                't1.id',
                't1.open_seats',
                't1.mahila_seats',
                't1.janajati_seats',
                't1.madheshi_seats',
                't1.dalit_seats',
                't1.apanga_seats',
                't1.remote_seats',
                't1.ad_no',
                't2.ad_title_en as ad_title',
                't3.id as post_id',
                't3.name_en as post',
                't1.id as vacancy_post_id',
                't4.application_rate as fee',
                't4.privileged_group_rate as privilege_fee',
                't4.ext_rate as fine',
                't4.ext_priv_rate as priv_fine',
                't4.internal_application_rate as internal_fee',
                't4.internal_privileged_group_rate as internal_privilege_fee',
                't4.internal_ext_rate as internal_fine',
                't4.internal_ext_priv_rate as internal_priv_fine',
                't2.last_date_for_application_bs as last_date_bs',
                't2.last_date_for_application_ad as last_date_ad',
                't2.vacancy_extended_date_bs as last_ext_date_bs',
                't2.vacancy_extended_date_ad as last_ext_date_ad',
                't2.opening_type_id as opening_type_id'
            )
            ->leftJoin('vacancy_ad as t2', 't2.id', '=', 't1.vacancy_ad_id')
            ->leftJoin('mst_designation as t3', 't3.id', '=', 't1.designation_id')
            ->leftJoin('mst_work_level as t4', 't4.id', '=', 't3.work_level_id')
            ->where('t1.id', '=', $ad_id)
            ->first();

        #check for privileges
        #user privileges certificate
        $data['privilege_certificates'] = DB::select('SELECT
                  privilege_group_id
              FROM
                  applicant_privilege_certificate
              WHERE
                  applicant_id =:applicantid
                  AND is_deleted =:is_deleted', ['applicantid' => CRUDBooster::myId(), 'is_deleted' => 0]);

        foreach ($data['privilege_certificates'] as $key => $privilege) {
            $p_id = $privilege->privilege_group_id;
            $privilege_id[] = $p_id;
        }
        if (empty($privilege_id)) {
            $privilege_id[] = 0;
        }

        #check for privilege group
        #female
        if (in_array(1, $privilege_id)) {
            $data['mahila'] = 1;
        }
        #tribal
        if (in_array(2, $privilege_id)) {
            $data['tribal'] = 1;
        }
        #madhesi
        if (in_array(3, $privilege_id)) {
            $data['madhesi'] = 1;
        }
        #dalit
        if (in_array(4, $privilege_id)) {
            $data['dalit'] = 1;
        }
        #handicapped
        if (in_array(5, $privilege_id)) {
            $data['handicapped'] = 1;
        }
        #remote_villages
        if (in_array(6, $privilege_id)) {
            $data['remote'] = 1;
        }

        // dd($data);
        $this->cbView('vacancy_apply.add', $data);
    }

    private function is_applied_before($ad_id)
    {
        $applicant_id = CRUDBooster::myId();
        $fiscal_year_id= Session::get('fiscal_year_id');
        $check_for_applied_before = DB::select('SELECT designation_id from vacancy_apply
                                       where applicant_id=:id and is_deleted=:is_deleted and vacancy_post_id=:post_id and fiscal_year_id=:fiscal_year_id', ['id' => $applicant_id, 'is_deleted' => 0, 'post_id' => $ad_id,'fiscal_year_id'=>$fiscal_year_id ]);
        if (empty($check_for_applied_before)) {return;} else {CRUDBooster::redirect('app/vacancy_post60', 'You have already applied for this post.', 'warning');}

    }

    private function is_cancelled($ad_id)
    {
        $applicant_id = CRUDBooster::myId();
        $fiscal_year_id= Session::get('fiscal_year_id');
        $check_for_applied_before = DB::select('SELECT designation_id from vacancy_apply
                                         where applicant_id=:id and is_deleted=:is_deleted and is_cancelled=:is_cancel and vacancy_post_id=:post_id and fiscal_year_id=:fiscal_year_id', ['id' => $applicant_id, 'is_deleted' => 0, 'is_cancel' => 1, 'post_id' => $ad_id,'fiscal_year_id'=>$fiscal_year_id ]);
        if (empty($check_for_applied_before)) {return;} else {CRUDBooster::redirect('app/vacancy_post60', 'You have already applied for this post.', 'warning');}

    }
    private function check_for_degree_for_opening($design_id, $level_id)
    {

       // dd($design_id,$level_id);

        $applicant_id = CRUDBooster::myId();
        #getting major subject
        $designation_major = DB::select('SELECT
                  mddm.edu_major_id,
                  mem.name_en
              FROM
                  mst_designation_degree_major mddm
                  LEFT JOIN mst_edu_major mem ON mddm.edu_major_id = mem.id
              WHERE
                  mddm.designation_id =:designation_id', ['designation_id' => $design_id]);

        foreach ($designation_major as $key => $degree_major) {
            $req_major_degrees = $degree_major->edu_major_id;
            $req_major_degrees_name = $degree_major->name_en;
            $total_major_degree[] = $req_major_degrees;
            $total_major_degrees_name[] = $req_major_degrees_name;
        }
        #for junior technician or with level that requires training
        if ($level_id == 3 || $level_id == 4 || $level_id == 2) {
            $applicant_edu_level = DB::select('SELECT edu_level_id FROM applicant_edu_info where applicant_id=:applicant_id and is_deleted=0', ['applicant_id' => $applicant_id]);
            foreach ($applicant_edu_level as $key => $edu_level) {
                $req_level = $edu_level->edu_level_id;
                $total_level[] = $req_level;
            }
            if ($total_level) {
                $edu_level = implode(',', $total_level);
            }

            #check if bachelor has done or not
            if (in_array(1, $total_level)) {
                if ($total_major_degree) {
                    $major_deg = implode(',', $total_major_degree);
                    $edu_eligible_toapply = DB::select('SELECT DISTINCT
            md.name_en AS designation,
            med.name_en AS degree_name,
            mdd.edu_degree_id
        FROM
            mst_designation md
            LEFT JOIN mst_designation_degree mdd ON md.CODE = mdd.designation_id
            LEFT JOIN mst_edu_degree med ON mdd.edu_degree_id = med.id
        WHERE
            (mdd.is_for_external =:is_for_external)
            AND md.id =:designation_id
            and edu_degree_id in(SELECT edu_degree_id from applicant_edu_info where applicant_id=:applicant_id and is_deleted=:deleted
            AND edu_major_id in(' . $major_deg . ')
            )',
                        ['designation_id' => $design_id, 'is_for_external' => 1, 'applicant_id' => $applicant_id, 'deleted' => 0]);
                }


                if (empty($edu_eligible_toapply)) {
                    #for training
                    $this->check_for_training($design_id, $level_id);
                } else {
                    return;
                }
                return;
            }
            #if slc has done
            elseif (in_array(1, $total_level)) {
                #for training
                $this->check_for_training($design_id, $level_id);
            } else {
                #for training
                $this->check_for_training($design_id, $level_id);
            }
        }

        #if major or specialization is required for certain designations
        if (empty($total_major_degree)) {
            $edu_eligible_toapply = DB::select('SELECT DISTINCT
                    md.name_en AS designation,
                    med.name_en AS degree_name,
                    mdd.edu_degree_id
                FROM
                    mst_designation md
                    LEFT JOIN mst_designation_degree mdd ON md.CODE = mdd.designation_id
                    LEFT JOIN mst_edu_degree med ON mdd.edu_degree_id = med.id
                WHERE
                    md.id =:designation_id
                    AND mdd.is_for_external=:is_for_external
                    and edu_degree_id in(SELECT edu_degree_id from applicant_edu_info where applicant_id=:applicant_id and is_deleted=:deleted)', ['designation_id' => $design_id, 'is_for_external' => 1, 'applicant_id' => $applicant_id, 'deleted' => 0]);

            $required_degrees = DB::select('SELECT DISTINCT
                    med.name_en
                FROM
                    mst_designation md
                    LEFT JOIN mst_designation_degree mdd ON md.CODE = mdd.designation_id
                    LEFT JOIN mst_edu_degree med ON mdd.edu_degree_id = med.id
                WHERE
                    md.id =:designationid
                    AND mdd.is_for_external =:is_for_external', ['designationid' => $design_id, 'is_for_external' => 1]);

            foreach ($required_degrees as $key => $degree_id) {
                $req_degree = $degree_id->name_en;
                $total_degree[] = $req_degree;
            }

            if (empty($edu_eligible_toapply)) {
                CRUDBooster::redirect('app/vacancy_post60', 'You cannot apply for this post.Your eduaction requirements does not meet to apply.
                       Required degrees are ' . json_encode($total_degree) . '', 'warning');
            } else {return;}
        } else {

            $major_deg = implode(',', $total_major_degree);

            //dd($total_major_degree);


            $edu_eligible_toapply = DB::select('SELECT DISTINCT
                md.name_en AS designation,
                med.name_en AS degree_name,
                mdd.edu_degree_id
            FROM
                mst_designation md
                LEFT JOIN mst_designation_degree mdd ON md.CODE = mdd.designation_id
                LEFT JOIN mst_edu_degree med ON mdd.edu_degree_id = med.id
            WHERE
                (mdd.is_for_external =:is_for_external)
                AND md.id =:designation_id
                and edu_degree_id in(SELECT edu_degree_id from applicant_edu_info where applicant_id=:applicant_id and is_deleted=:deleted
                AND edu_major_id in(' . $major_deg . ')
                )',
                ['designation_id' => $design_id, 'is_for_external' => 1, 'applicant_id' => $applicant_id, 'deleted' => 0]);

                // dd($edu_eligible_toapply,$major_deg,$applicant_id);

            $required_degrees = DB::select('SELECT DISTINCT
                med.name_en
            FROM
                mst_designation md
                LEFT JOIN mst_designation_degree mdd ON md.CODE = mdd.designation_id
                LEFT JOIN mst_edu_degree med ON mdd.edu_degree_id = med.id
            WHERE
               (mdd.is_for_external =:is_for_external)
            AND md.id =:designationid
                ', ['is_for_external' => 1, 'designationid' => $design_id]);

            foreach ($required_degrees as $key => $degree_id) {
                $req_degree = $degree_id->name_en;
                $total_degree[] = $req_degree;
            }
            if (empty($edu_eligible_toapply)) {
                CRUDBooster::redirect('app/vacancy_post60', 'You cannot apply for this post.Your eduaction requirements does not meet to apply.
                 Required degrees are ' . json_encode($total_degree) . ' and majors are ' . json_encode($total_major_degrees_name) . '', 'warning');
            } else {return;}
        }
    }


        private function check_for_degree($design_id, $nt_staff, $level_id)
    {
        $applicant_id = CRUDBooster::myId();
        #getting major subject
        $designation_major = DB::select('SELECT
              mddm.edu_major_id,
              mem.name_en
          FROM
              mst_designation_degree_major mddm
              LEFT JOIN mst_edu_major mem ON mddm.edu_major_id = mem.id
          WHERE
              mddm.designation_id =:designation_id', ['designation_id' => $design_id]);

        foreach ($designation_major as $key => $degree_major) {
            $req_major_degrees = $degree_major->edu_major_id;
            $req_major_degrees_name = $degree_major->name_en;
            $total_major_degree[] = $req_major_degrees;
            $total_major_degrees_name[] = $req_major_degrees_name;
        }
        #for junior technician 9 design id
        if ($level_id == 3 || $level_id == 4 || $level_id == 2) {
            $applicant_edu_level = DB::select('SELECT edu_level_id FROM applicant_edu_info where applicant_id=:applicant_id and is_deleted=0', ['applicant_id' => $applicant_id]);
            foreach ($applicant_edu_level as $key => $edu_level) {
                $req_level = $edu_level->edu_level_id;
                $total_level[] = $req_level;
            }
            $edu_level = implode(',', $total_level);
            #check if bachelor has done or not
            if (in_array(1, $total_level)) {

                if( $total_major_degree){
                    $major_deg = implode(',', $total_major_degree);
                    $edu_eligible_toapply = DB::select('SELECT DISTINCT
                md.name_en AS designation,
                med.name_en AS degree_name,
                mdd.edu_degree_id
            FROM
                mst_designation md
                LEFT JOIN mst_designation_degree mdd ON md.CODE = mdd.designation_id
                LEFT JOIN mst_edu_degree med ON mdd.edu_degree_id = med.id
            WHERE
                (mdd.is_for_external =:is_for_external)
                AND md.id =:designation_id
                and edu_degree_id in(SELECT edu_degree_id from applicant_edu_info where applicant_id=:applicant_id and is_deleted=:deleted
                AND edu_major_id in(' . $major_deg . ')
                )',
                        ['designation_id' => $design_id, 'is_for_external' => 1, 'applicant_id' => $applicant_id, 'deleted' => 0]);
                }


                if (empty($edu_eligible_toapply)) {
                    #for training
                    $this->check_for_training($design_id, $level_id);
                } else {return;}
                return;
            } elseif (in_array(1, $total_level)) {
                #for training
                $this->check_for_training($design_id, $level_id);
            } else {
                #for training
                $this->check_for_training($design_id, $level_id);
            }
        }
        //dd(count(array_intersect($permission, $userRoles)));

        #getting major subject
        $designation_major = DB::select('SELECT
            mddm.edu_major_id,
            mem.name_en
        FROM
            mst_designation_degree_major mddm
            LEFT JOIN mst_edu_major mem ON mddm.edu_major_id = mem.id
        WHERE
            mddm.designation_id =:designation_id', ['designation_id' => $design_id]);

        foreach ($designation_major as $key => $degree_major) {
            $req_major_degrees = $degree_major->edu_major_id;
            $req_major_degrees_name = $degree_major->name_en;
            $total_major_degree[] = $req_major_degrees;
            $total_major_degrees_name[] = $req_major_degrees_name;
        }

        if (empty($total_major_degree)) {
            #if not nt staff
            if (empty($nt_staff)) {
                $edu_eligible_toapply = DB::select('SELECT DISTINCT
            md.name_en AS designation,
            med.name_en AS degree_name,
            mdd.edu_degree_id
        FROM
            mst_designation md
            LEFT JOIN mst_designation_degree mdd ON md.CODE = mdd.designation_id
            LEFT JOIN mst_edu_degree med ON mdd.edu_degree_id = med.id
        WHERE
            (mdd.is_for_external =:is_for_external OR mdd.is_additional =:is_additional)
            AND md.id =:designation_id
            and edu_degree_id in(SELECT edu_degree_id from applicant_edu_info where applicant_id=:applicant_id and is_deleted=:deleted)',
                    ['designation_id' => $design_id, 'is_for_external' => 1, 'is_additional' => 1, 'applicant_id' => $applicant_id, 'deleted' => 0]);

                $required_degrees = DB::select('SELECT DISTINCT
            med.name_en
        FROM
            mst_designation md
            LEFT JOIN mst_designation_degree mdd ON md.CODE = mdd.designation_id
            LEFT JOIN mst_edu_degree med ON mdd.edu_degree_id = med.id
        WHERE
           (mdd.is_for_external =:is_for_external OR mdd.is_additional =:is_additional)
        AND md.id =:designationid
            ', ['is_for_external' => 1, 'is_additional' => 1, 'designationid' => $design_id]);

                foreach ($required_degrees as $key => $degree_id) {
                    $req_degree = $degree_id->name_en;
                    $total_degree[] = $req_degree;
                }

                if (empty($edu_eligible_toapply)) {
                    CRUDBooster::redirect('app/vacancy_post60', 'You cannot apply for this post.Your eduaction requirements does not meet to apply.
             Required degrees are ' . json_encode($total_degree) . '', 'warning');

                } else {
                    return;
                }

            }
            #if nt_staff
            else {
                $edu_eligible_toapply = DB::select('SELECT DISTINCT
            md.name_en AS designation,
            med.name_en AS degree_name,
            mdd.edu_degree_id
        FROM
            mst_designation md
            LEFT JOIN mst_designation_degree mdd ON md.CODE = mdd.designation_id
            LEFT JOIN mst_edu_degree med ON mdd.edu_degree_id = med.id
        WHERE
            md.id =:designation_id
            AND mdd.is_for_internal=:is_for_internal
            and edu_degree_id in(SELECT edu_degree_id from applicant_edu_info where applicant_id=:applicant_id and is_deleted=:deleted)', ['designation_id' => $design_id, 'is_for_internal' => 1, 'applicant_id' => $applicant_id, 'deleted' => 0]);

                $required_degrees = DB::select('SELECT DISTINCT
            med.name_en
        FROM
            mst_designation md
            LEFT JOIN mst_designation_degree mdd ON md.CODE = mdd.designation_id
            LEFT JOIN mst_edu_degree med ON mdd.edu_degree_id = med.id
        WHERE
            md.id =:designationid
            AND mdd.is_for_internal =:is_for_internal', ['designationid' => $design_id, 'is_for_internal' => 1]);

                foreach ($required_degrees as $key => $degree_id) {
                    $req_degree = $degree_id->name_en;
                    $total_degree[] = $req_degree;
                }

                if (empty($edu_eligible_toapply)) {
                    CRUDBooster::redirect('app/vacancy_post60', 'You cannot apply for this post.Your eduaction requirements does not meet to apply.
             Required degrees are ' . json_encode($total_degree) . '', 'warning');
                } else {
                    return;
                }
            }
        } else {
            //dd($total_major_degrees_name);


            $major_deg = implode(',', $total_major_degree);

            if (empty($nt_staff)) {
                $edu_eligible_toapply = DB::select('SELECT DISTINCT
            md.name_en AS designation,
            med.name_en AS degree_name,
            mdd.edu_degree_id
        FROM
            mst_designation md
            LEFT JOIN mst_designation_degree mdd ON md.CODE = mdd.designation_id
            LEFT JOIN mst_edu_degree med ON mdd.edu_degree_id = med.id
        WHERE
            (mdd.is_for_external =:is_for_external OR mdd.is_additional =:is_additional)
            AND md.id =:designation_id
            and edu_degree_id in(SELECT edu_degree_id from applicant_edu_info where applicant_id=:applicant_id and is_deleted=:deleted
            AND edu_major_id in(' . $major_deg . ')
            )',
                    ['designation_id' => $design_id, 'is_for_external' => 1, 'is_additional' => 1, 'applicant_id' => $applicant_id, 'deleted' => 0]);

                $required_degrees = DB::select('SELECT DISTINCT
            med.name_en
        FROM
            mst_designation md
            LEFT JOIN mst_designation_degree mdd ON md.CODE = mdd.designation_id
            LEFT JOIN mst_edu_degree med ON mdd.edu_degree_id = med.id
        WHERE
           (mdd.is_for_external =:is_for_external OR mdd.is_additional =:is_additional)
        AND md.id =:designationid
            ', ['is_for_external' => 1, 'is_additional' => 1, 'designationid' => $design_id]);

                foreach ($required_degrees as $key => $degree_id) {
                    $req_degree = $degree_id->name_en;
                    $total_degree[] = $req_degree;
                }

                if (empty($edu_eligible_toapply)) {
                    CRUDBooster::redirect('app/vacancy_post60', 'You cannot apply for this post.Your eduaction requirements does not meet to apply.
             Required degrees are ' . json_encode($total_degree) . ' and majors are ' . json_encode($total_major_degrees_name) . '', 'warning');

                } else {
                    return;
                }

            }
            #if nt_staff
            else {
                $edu_eligible_toapply = DB::select('SELECT DISTINCT
            md.name_en AS designation,
            med.name_en AS degree_name,
            mdd.edu_degree_id
        FROM
            mst_designation md
            LEFT JOIN mst_designation_degree mdd ON md.CODE = mdd.designation_id
            LEFT JOIN mst_edu_degree med ON mdd.edu_degree_id = med.id
        WHERE
            md.id =:designation_id
            AND mdd.is_for_internal=:is_for_internal
            and edu_degree_id in(SELECT edu_degree_id from applicant_edu_info where applicant_id=:applicant_id and is_deleted=:deleted
            AND edu_major_id in(' . $major_deg . '))', ['designation_id' => $design_id, 'is_for_internal' => 1, 'applicant_id' => $applicant_id, 'deleted' => 0]);

                $required_degrees = DB::select('SELECT DISTINCT
            med.name_en
        FROM
            mst_designation md
            LEFT JOIN mst_designation_degree mdd ON md.CODE = mdd.designation_id
            LEFT JOIN mst_edu_degree med ON mdd.edu_degree_id = med.id
        WHERE
            md.id =:designationid
            AND mdd.is_for_internal =:is_for_internal', ['designationid' => $design_id, 'is_for_internal' => 1]);

                foreach ($required_degrees as $key => $degree_id) {
                    $req_degree = $degree_id->name_en;
                    $total_degree[] = $req_degree;
                }

                if (empty($edu_eligible_toapply)) {
                    CRUDBooster::redirect('app/vacancy_post60', 'You cannot apply for this post.Your eduaction requirements does not meet to apply.
             Required degrees are ' . json_encode($total_degree) . ' and majors are ' . json_encode($total_major_degrees_name) . '', 'warning');
                } else {
                    return;
                }
            }

        }
    }

    private function check_for_service_group($service_group)
    {

        $applicant_id = CRUDBooster::myId();
        $current_service_group = DB::select('SELECT service_group from applicant_service_history where applicant_id=:id and is_current=:is_current and is_deleted is false', ['id' => $applicant_id, 'is_current' => 1]);
        $applicant_current_service_group = $current_service_group[0]->service_group;

        return;

        // if ($applicant_current_service_group == $service_group) {
        //     return;
        // } else {
        //     CRUDBooster::redirect('app/vacancy_post60', 'You cannot apply for this post.Your service group doesnot match.', 'warning');
        // }

    }
    private function check_for_age($last_date_ad, $design_id, $gender_id)
    {

        // dd($design_id, $last_date_ad, $gender_id);

        $data['applicant_id'] =$applicant_id= CRUDBooster::myId();
        $date_of_birth = DB::select('SELECT dob_ad,gender_id,is_handicapped from applicant_profile where user_id=:id', ['id' => $data['applicant_id']]);
        $dob_ad = $date_of_birth[0]->dob_ad;
        $gender_id = $date_of_birth[0]->gender_id;
        $is_handicapped=$date_of_birth[0]->is_handicapped;
        #date difference for age
        $to = Carbon::parse($last_date_ad);
        $from = Carbon::parse($dob_ad);

        // Check age difference till today
        $today = Carbon::today();
        // $today = $dt->toDateString();
        $diff_today = $today->diff($from);
        $diff_today_years = $diff_today->y;

        // Check age difference till last date to apply
        #age
        $diff = $to->diff($from);
        $diff_years = $diff->y;
        $diff_months = $diff->m;
        $diff_days = $diff->d;
        $diff_total_days = $diff->days;

        $age_limit = DB::select('SELECT min_age,max_age from mst_age_limit where designation_id=:design_id and gender_id=:gender', ['design_id' => $design_id, 'gender' => $gender_id]);

        $min_age = intval(($age_limit[0]->min_age));
        $max_age = intval(($age_limit[0]->max_age));

        // if ($diff_today_years >= $min_age && $diff_today_years <= $max_age) {
        //     return;
        // }

        // dd($age_limit);
        if(!empty($is_handicapped)){
            $max_age_for_handicapped=40;
            if ($diff_years >= $min_age && $diff_years < $max_age_for_handicapped) {
               #check the handicapped certificate
               $check_certificate=DB::table('applicant_privilege_certificate')->where([['privilege_group_id','5'],['applicant_id',$applicant_id],['is_deleted',false]])->first();
               if($check_certificate){
                   return;
               }else{
                CRUDBooster::redirect('app/vacancy_post60', 'please upload handicapped certificate.you have checked in profile as handicapped', 'warning');
               }


            } else if (empty($age_limit)) {
                CRUDBooster::redirect('app/vacancy_post60', 'You cannot apply for this post.please contact Administrator', 'warning');
                $desc = "Age limit for this post is not set in master table";
                CRUDBooster::insertLog($desc);
            } else {
                CRUDBooster::redirect('app/vacancy_post60', 'You cannot apply for this post. Your age must be between ' . $min_age . ' & ' . $max_age . '. Your current age is ' . $diff->y . ' years,' . $diff->m . ' months and ' . $diff->d . ' days.', 'warning');
            }

        }else{
            if ($diff_years >= $min_age && $diff_years < $max_age) {
                return;
            } else if (empty($age_limit)) {
                CRUDBooster::redirect('app/vacancy_post60', 'You cannot apply for this post.please contact Administrator', 'warning');
                $desc = "Age limit for this post is not set in master table";
                CRUDBooster::insertLog($desc);
            } else {
                CRUDBooster::redirect('app/vacancy_post60', 'You cannot apply for this post. Your age must be between ' . $min_age . ' & ' . $max_age . '. Your current age is ' . $diff->y . ' years,' . $diff->m . ' months and ' . $diff->d . ' days.', 'warning');
            }
        }


    }
    private function check_for_documents_attached()
    {
        $applicant_id = CRUDBooster::myId();
        $applicant = DB::table('applicant_profile')
            ->where('id', $applicant_id)
            ->first();
        if (strlen($applicant->photo) < 1) {
            CRUDBooster::redirect('app/vacancy_post60', 'Please upload your Photo before applying', 'warning');
        }
        if (strlen($applicant->signature_upload) < 1) {
            CRUDBooster::redirect('app/vacancy_post60', 'Please upload your Signature before applying', 'warning');
        }
        if (strlen($applicant->citizenship_upload) < 1) {
            CRUDBooster::redirect('app/vacancy_post60', 'Please upload your Citizenship before applying', 'warning');
        }

        return;
    }

    private function check_for_service_period($last_date_ad, $opening_type_id,$level_id)
    {
        #for opening competition since no service period is required
        if ($opening_type_id == 1) {return;}

        $applicant_id = CRUDBooster::myId();
        $seniority_date_ad = DB::select('SELECT DISTINCT
             seniority_date_ad
             FROM
                 applicant_service_history
             WHERE
                 applicant_id =:id
                 AND is_current =:is_current
                 AND is_deleted=:deleted', ['id' => $applicant_id, 'is_current' => 1, 'deleted' => 0]);

        $senior_ad = $seniority_date_ad[0]->seniority_date_ad;
        $seniority_date = Carbon::parse($senior_ad);

        #for internal competition starting date is  seniority date and end date is last date for application
        if ($opening_type_id == 2) {
            $last_date = Carbon::parse($last_date_ad);
            $diff_in_days = $last_date->diffInDays($seniority_date);
            if($level_id >=6){
                $min_service_days = (365 * 3);
                if ($diff_in_days < $min_service_days) {
                    CRUDBooster::redirect('app/vacancy_post60', 'Your Service period is less than 3 years', 'warning');
                }
            }else{
                $min_service_days = (365 * 3);
                if ($diff_in_days < $min_service_days) {
                    CRUDBooster::redirect('app/vacancy_post60', 'Your Service period is less than 3 years', 'warning');
                }
            }
            // if ($diff_in_days < $min_service_days) {
            //     CRUDBooster::redirect('app/vacancy_post60', 'Your Service period is less than 3 years', 'warning');
            // }
            return;
        }
        #for file promotion starting date is  seniority date and end date is last fiscal year ending date for application
        $last_fiscal_year_ending_date = DB::select('SELECT date_to_ad,code,date_to_bs from mst_fiscal_year ORDER BY date_to_ad DESC LIMIT 1 OFFSET 1');
        $last_fy_ad = $last_fiscal_year_ending_date[0]->date_to_ad;
        $last_fy_date = Carbon::parse($last_fy_ad);
        $diff_in_days = $last_fy_date->diffInDays($seniority_date);
        $min_service_days = (365 * 3);
        if ($diff_in_days < $min_service_days) {
            CRUDBooster::redirect('app/vacancy_post60', 'Your Service period is less than 3 years upto last fiscal year', 'warning');
        }
        return;
    }

    private function check_for_experience($design_id, $level_id)
    {

        $applicant_id = CRUDBooster::myId();
        $start_working_office_date_from_ad = DB::select('SELECT
           date_from_ad
         FROM
             applicant_exp_info
         WHERE
             applicant_id =:applicant_id
             AND is_deleted is false
         ORDER BY
          id asc
          LIMIT 1', ['applicant_id' => $applicant_id]);

          //dd( $start_working_office_date_from_ad);

        $date_from_ad = $start_working_office_date_from_ad[0]->date_from_ad;

        $last_working_office_date_to_ad = DB::select('SELECT
          date_to_ad
      FROM
          applicant_exp_info
      WHERE
          applicant_id =:applicant_id
          AND is_deleted =:deleted
      ORDER BY
          id DESC
          LIMIT 1', ['applicant_id' => $applicant_id, 'deleted' => 0]);
        $date_to_ad = $last_working_office_date_to_ad[0]->date_to_ad;

        $from = Carbon::parse($date_from_ad);
        $to = Carbon::parse($date_to_ad);
        $diff_in_years = $to->diffInYears($from);

        //dd($from,$to,$diff_in_years);
        #get working experience from table
        #1.condition 1 check first if nt staff or non nt staff
          $applicant=DB::table('applicant_profile')->select('is_nt_staff')->where([['id',$applicant_id],['is_deleted',false]])->first();
          $nt_staff= $applicant->is_nt_staff;
          if($nt_staff){
            $year=DB::table('mst_designation')->select('internal_experience')->where([['id',$design_id],['is_deleted',false]])->first();
            $exp_in_years=$year->internal_experience;
          }else{
            $year=DB::table('mst_designation')->select('external_experience')->where([['id',$design_id],['is_deleted',false]])->first();
            $exp_in_years=$year->external_experience;   
          }

          if($diff_in_years >=$exp_in_years){
              return;
          }else{
            CRUDBooster::redirect('app/vacancy_post60', 'Your working experience must be equal to or greater than  '.$exp_in_years.' years in this designation', 'warning'); 
          }
         


        // if ($level_id == 9) {
        //     if ($diff_in_years >= 7) {return;} else {
        //         CRUDBooster::redirect('app/vacancy_post60', 'Your working experience must be equal to or greater than 7 years in this designation', 'warning');
        //     }
        // } else {

        //     if ($diff_in_years >= 5) {return;} else {
        //         CRUDBooster::redirect('app/vacancy_post60', 'Your working experience must be equal to or greater than 5 years in this designation', 'warning');
        //     }

        // }

    }

    private function check_for_training($design_id, $level_id)
    {
        $applicant_id = CRUDBooster::myId();
        $edu_level_of_applicant = DB::select('SELECT edu_level_id FROM applicant_edu_info where applicant_id=:applicant_id and is_deleted=0', ['applicant_id' => $applicant_id]);
        #getting major subject
        $designation_major = DB::select('SELECT
            mddm.edu_major_id,
            mem.name_en
        FROM
            mst_designation_degree_major mddm
            LEFT JOIN mst_edu_major mem ON mddm.edu_major_id = mem.id
        WHERE
            mddm.designation_id =:designation_id', ['designation_id' => $design_id]);

        foreach ($designation_major as $key => $degree_major) {
            $req_major_degrees = $degree_major->edu_major_id;
            $req_major_degrees_name = $degree_major->name_en;
            $total_major_degree[] = $req_major_degrees;
            $total_major_degrees_name[] = $req_major_degrees_name;
        }
        if ($total_major_degree) {
            $major_deg = implode(',', $total_major_degree);
            $edu_eligible_toapply = DB::select('SELECT DISTINCT
            md.name_en AS designation,
            med.name_en AS degree_name,
            mdd.edu_degree_id
        FROM
            mst_designation md
            LEFT JOIN mst_designation_degree mdd ON md.CODE = mdd.designation_id
            LEFT JOIN mst_edu_degree med ON mdd.edu_degree_id = med.id
        WHERE
            (mdd.is_for_external =:is_for_external OR mdd.is_additional =:is_additional)
            AND md.id =:designation_id
            and edu_degree_id in(SELECT edu_degree_id from applicant_edu_info where applicant_id=:applicant_id and is_deleted=:deleted
            AND edu_major_id in(' . $major_deg . ')
            )',
                ['designation_id' => $design_id, 'is_for_external' => 1, 'is_additional' => 1, 'applicant_id' => $applicant_id, 'deleted' => 0]);
        }

        #incase of be.electronics,electrical....

        if (!empty($edu_eligible_toapply)) {
            return;
        }

        $applicant_edu_level = DB::select('SELECT edu_level_id FROM applicant_edu_info where applicant_id=:applicant_id and is_deleted=0', ['applicant_id' => $applicant_id]);

        #incase of assistant no training
        if ($design_id != 14) {
            $applicant_id = CRUDBooster::myId();
            $majors = DB::select('SELECT
                d.id, d.name_en, tm.name_en major_name, dtm.training_major_id
            FROM mst_designation d
                INNER JOIN mst_designation_training_major dtm ON d.id = dtm.designation_id
                INNER JOIN mst_training_major tm ON dtm.training_major_id = tm.id
            WHERE d.id =:desig', ['desig' => $design_id]);
            foreach ($majors as $key => $major_id) {
                $req_training = $major_id->major_name;
                $total_training[] = $req_training;
            }

            $check_for_eligible = DB::select('SELECT
             training_major_id
         FROM
             applicant_training_info ati
             LEFT JOIN mst_designation_training mdt ON ati.training_id = mdt.training_id
             LEFT JOIN mst_training_major mtm ON ati.training_major_id = mtm.id
         WHERE
             training_major_id IN (
             SELECT
                 dtm.training_major_id
             FROM
                 mst_designation d
                 INNER JOIN mst_designation_training_major dtm ON d.id = dtm.designation_id
                 INNER JOIN mst_training_major tm ON dtm.training_major_id = tm.id
             WHERE
             d.id =:design_id
             )
             AND applicant_id=:applicant_id
             AND ati.is_deleted=:is_deleted', ['design_id' => $design_id, 'applicant_id' => $applicant_id, 'is_deleted' => 0]);

            //dd($check_for_eligible);
            if (empty($check_for_eligible)) {
                CRUDBooster::redirect('app/vacancy_post60', 'No training Records are found.Required major trainings are  ' . json_encode($total_training) . '', 'warning');
            } else {return;}
        }
    }

    private function check_for_council_certificate($design_id)
    {
        //dd($designid);
        $applicant_id = CRUDBooster::myId();
        $check_for_council_certificate = DB::select('SELECT council_id from applicant_council_certificate where applicant_id=:id', ['id' => $applicant_id]);
        foreach ($check_for_council_certificate as $key => $c_id) {
            $req_council = $c_id->council_id;
            $total_council[] = $req_council;
        }

        
        #check for C.A
        if ($design_id != 4) {
            if (empty($check_for_council_certificate)) {
                CRUDBooster::redirect('app/vacancy_post60', 'No council certificate found.Please upload your Engineering council certificate', 'warning');
            } elseif (in_array(1, $total_council)) {return;} else {
                CRUDBooster::redirect('app/vacancy_post60', 'Please upload your Engineering council certificate', 'warning');
            }
        } else {
            if (empty($check_for_council_certificate)) {
                CRUDBooster::redirect('app/vacancy_post60', 'No council certificate found.Please upload your C.A. council certificate', 'warning');
            } elseif (in_array(2, $total_council)) {
                return;
            } else {
                CRUDBooster::redirect('app/vacancy_post60', 'Please upload your C.A. council certificate', 'warning');
            }
        }

    }

    public function getEdit($id)
    {
        $data = $this->getApplicationDetail($id);
        $isApplicant = false;
        if (Session::get('is_applicant') == 1) {
            $data['isApplicant'] = true;
            $isApplicant = true;
        }
        $encoded_applicant_id = Session::get('applicant_id');
        $applicant_id = Hashids::decode($encoded_applicant_id);
        $applicant_id = $applicant_id[0];
        if ($isApplicant) {

            $desc = "Access route " . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . " with applicant_id " . $applicant_id;
        } else {
            $desc = "Access route " . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . " with user_id " . CRUDBooster::myId();
        }

        parent::insert_log($desc, $id, 'vacancy_apply');
        $data['page_title'] = 'Application Edit';

        if (Session::get("is_applicant") && $data[is_cancelled] == 0) {
            CRUDBooster::redirect(CRUDBooster::adminPath(), trans('crudbooster.denied_access'));
        } else {
            $this->cbView('vacancy_apply.edit', $data);
        }
    }

    public function getCancel($id)
    {
        $isApplicant = false;
        if (Session::get('is_applicant') == 1) {
            $data['isApplicant'] = true;
            $isApplicant = true;
        }
        $encoded_applicant_id = Session::get('applicant_id');
        $applicant_id = Hashids::decode($encoded_applicant_id);
        $applicant_id = $applicant_id[0];
        if ($isApplicant) {
            $desc = "Access route " . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . " with applicant_id " . $applicant_id;
        } else {
            $desc = "Access route " . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . " with user_id " . CRUDBooster::myId();
        }

        parent::insert_log($desc, $id, 'vacancy_apply');
        // $data = $this->getApplicationDetail($id);
        $opening_type = DB::table('vacancy_apply as va')
            ->select('vad.opening_type_id')
            ->leftjoin('vacancy_post as vp', 'vp.id', '=', 'va.vacancy_post_id')
            ->leftjoin('vacancy_ad as vad', 'vad.id', '=', 'vp.vacancy_ad_id')
            ->where('va.id', $id)
            ->first();
        if ($opening_type->opening_type_id == 1) {
            CRUDBooster::redirect(CRUDBooster::mainpath(), 'You cannot cancel the post you applied. Please contact NTC.', 'warning');
        } else {
            DB::table('vacancy_apply')
                ->where('id', $id)
                ->update(['is_cancelled' => 1]);
            CRUDBooster::redirect(CRUDBooster::mainpath(), 'Successfully cancelled.', 'success');
        }
    }

    public function getReApply($id)
    {

        // dd($id);
        $data = $this->getApplicationDetail($id);

        $ext_date = $data['vacancy_details']->vacancy_extended_date_ad;
        $last_day = Carbon::parse($ext_date)->format('Y-m-d');
        $today = Carbon::parse('today')->format('Y-m-d');

        if ($last_day <= $today) {
            CRUDBooster::redirect(CRUDBooster::mainpath(), 'Sorry, the vacancy has already expired.', 'warning');
            return;
        }

        $isApplicant = false;
        if (Session::get('is_applicant') == 1) {
            $data['isApplicant'] = true;
            $isApplicant = true;
        }
        $encoded_applicant_id = Session::get('applicant_id');
        $applicant_id = Hashids::decode($encoded_applicant_id);
        $applicant_id = $applicant_id[0];
        if ($isApplicant) {
            $desc = "Access route " . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . " with applicant_id " . $applicant_id;
        } else {
            $desc = "Access route " . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . " with user_id " . CRUDBooster::myId();
        }

        parent::insert_log($desc, $id, 'vacancy_apply');
        $data['page_title'] = 'Application Reapply';

        if (Session::get("is_applicant") && $data['is_rejected'] == 1) {
            CRUDBooster::redirect(CRUDBooster::adminPath(), trans('crudbooster.denied_access'));
        } else {

            //dd('amit');
            #check validations
            $fY_id = Session::get('fiscal_year_id');
            #check for nt staff
            $is_nt_staff = DB::table('applicant_profile')->where('user_id', $data['applicant_id'])->select('is_nt_staff')->get();
            $nt_staff = $is_nt_staff[0]->is_nt_staff;
            $opening_type_id = $data['vacancy_details']->opening_type_id;
            // dd($data,$data['vacancy_details'],$data['vacancy_details']->id);
            #check for last date for age
            $last_date_for_application_ad = DB::select('SELECT last_date_for_application_ad from vacancy_ad where fiscal_year_id=:id and opening_type_id=:ot_id', ['id' => $fY_id, 'ot_id' => $opening_type_id]);
            $last_date_ad = $last_date_for_application_ad[0]->last_date_for_application_ad;
            $applicant_id = $data['applicant_id'];
            $design_id = $data['vacancy_details']->post_id;

            $level = DB::select('SELECT distinct LEVEL,service_group_id
            FROM
                vw_published_vacancy_posts_all
            WHERE
                designation_id =:id', ['id' => $design_id]);
            $level_id = $level[0]->level;
            $ad_id = $data['ad_id'];
            $service_group = $level[0]->service_group_id;
            #get gender from applicant id
            $gender = DB::select('SELECT gender_id from applicant_profile where user_id=:applicant_id', ['applicant_id' => $applicant_id]);
            $gender_id = $gender[0]->gender_id;

            if (empty($nt_staff)) {
                #for age
                $this->check_for_age($last_date_ad, $design_id, $gender_id);
                #for education degree
                $this->check_for_degree($design_id, $nt_staff, $level_id);
                #for documents attached
                $this->check_for_documents_attached();

            } else {
                // $last_date_ad, $opening_type_id,$level_id
                $this->check_for_service_period($last_date_ad, $opening_type_id,$level_id);
                #for service group
                if ($opening_type_id != 1) {
                    $this->check_for_service_group($service_group);
                }
                #for external edu degree should be same for nt staff and non nt staff
                if ($opening_type_id == 1) {$this->check_for_degree_for_opening($design_id, $level_id);} else { $this->check_for_degree($design_id, $nt_staff, $level_id);}
            }
            #check for council certificate
            $required_designation_for_council = DB::select('SELECT id from mst_designation where is_council_reg_required=:id', ['id' => 1]);
            foreach ($required_designation_for_council as $key => $council_id) {
                $req_design = $council_id->id;
                $total_design[] = $req_design;
            }
            if (in_array($design_id, $total_design)) {
                $this->check_for_council_certificate($design_id);
            }
            #for experience
            if ($opening_type_id != 2 && $opening_type_id != 3) {
                if ($level_id == 8 || $level_id == 9) {
                    #for C.A. no experience required
                    if ($design_id != 4) {
                        $this->check_for_experience($design_id, $level_id);
                    }
                }
            }
            #check if already applied
            $this->is_applied_before($ad_id);
            #check if already cancelled
            $this->is_cancelled($ad_id);
            #check for privileges
            #user privileges certificate
            //dd('amit');
            // $data['privilege_certificates'] = DB::select('SELECT
            //     privilege_group_id
            // FROM
            //     applicant_privilege_certificate
            // WHERE
            //     applicant_id =:applicantid
            //     AND is_deleted =:is_deleted', ['applicantid' => CRUDBooster::myId(), 'is_deleted' => 0]);

            // foreach ($data['privilege_certificates'] as $key => $privilege) {
            //     $p_id = $privilege->privilege_group_id;
            //     $privilege_id[] = $p_id;
            // }


            $data['privilege_certificates'] = DB::select('SELECT
            privilege_group_id
        FROM
            applicant_privilege_certificate
        WHERE
            applicant_id =:applicantid
            AND is_deleted =:is_deleted', ['applicantid' => CRUDBooster::myId(), 'is_deleted' => 0]);

                  foreach ($data['privilege_certificates'] as $key => $privilege) {
                      $p_id = $privilege->privilege_group_id;
                      $privilege_id[] = $p_id;
                  }
                    if (empty($privilege_id)) {
                        $privilege_id[] = 0;
                    }


            // dd(count($privilege_id));

            // if (count($privilege_id) <= 0) {$privilege_id[] = 0;}
            #check for privilege group
            #female
            if (in_array(1, $privilege_id)) {
                $data['mahila'] = 1;
            }
            #tribal
            if (in_array(2, $privilege_id)) {
                $data['tribal'] = 1;
            }
            #madhesi
            if (in_array(3, $privilege_id)) {
                $data['madhesi'] = 1;
            }
            #dalit
            if (in_array(4, $privilege_id)) {
                $data['dalit'] = 1;
            }
            #handicapped
            if (in_array(5, $privilege_id)) {
                $data['handicapped'] = 1;
            }
            #remote_villages
            if (in_array(6, $privilege_id)) {
                $data['remote'] = 1;
            }

            // dd($data);
            $this->cbView('vacancy_apply.reapply', $data);
        }

    }

    private function getApplicationDetail($id)
    {
        $vacancy_post_id = intval($id);
        $application_dtl = collect(DB::select('SELECT va.id, va.is_open, va.is_cancelled,
            va.is_female,va.is_janajati, va.is_madhesi, a.gender_id
            , va.is_dalit, va.is_handicapped, va.is_remote_village, va.is_open
            , vp.mahila_seats, vp.janajati_seats, vp.madheshi_seats
            , vp.dalit_seats, vp.apanga_seats, vp.remote_seats, vp.open_seats
            , ad.ad_title_en ad_title, ad.vacancy_extended_date_ad,ad.opening_type_id
            , d.id post_id, d.name_en post, va.vacancy_post_id, va.token_number,wl.id as aaaaa
            , CASE
            WHEN ( ad.opening_type_id <> 1  ) THEN
        CASE
                WHEN ( va.applied_date_ad <= ad.last_date_for_application_ad ) THEN
                ( wl.internal_application_rate ) ELSE ( wl.internal_ext_rate )
        END
        ELSE
        CASE
            WHEN ( va.applied_date_ad <= ad.last_date_for_application_ad ) THEN
            ( wl.application_rate ) ELSE ( wl.ext_rate )
        END
            END AS fee,
            CASE
            WHEN ( ad.opening_type_id <> 1 ) THEN
        CASE
                WHEN ( va.applied_date_ad <= ad.last_date_for_application_ad ) THEN
                ( wl.internal_privileged_group_rate ) ELSE ( wl.internal_ext_priv_rate )
        END
        ELSE
        CASE
            WHEN ( va.applied_date_ad <= ad.last_date_for_application_ad ) THEN
            ( wl.privileged_group_rate ) ELSE ( wl.ext_priv_rate )
        END
            END AS privilege_fee
            , wl.ext_rate as fine
            , va.applicant_id, va.applied_date_ad, va.applied_date_bs, vp.ad_no, vp.vacancy_ad_id ad_id
            , concat(a.first_name_en,\' \',coalesce(NULLIF(a.mid_name_en,\'\'),\'\'),\' \',a.last_name_en) as fullname
            , va.amount_for_job, va.amount_for_priv_grp, va.is_rejected, va.total_amount
            FROM vacancy_apply va
            INNER JOIN vacancy_post vp on va.vacancy_post_id = vp.id
            LEFT JOIN vacancy_ad AS ad ON vp.vacancy_ad_id = ad.id
            LEFT JOIN mst_designation AS d ON vp.designation_id = d.id
            LEFT JOIN mst_work_level AS wl ON d.work_level_id = wl.id
            LEFT JOIN applicant_profile a on va.applicant_id = a.id
            WHERE va.id =:id
            ', ['id' => $vacancy_post_id]))->first();

        $token_number = intval($application_dtl->token_number);

        // $payment_data = DB::table('csv_payment_file_details')
        //     ->select('token_number', 'receipt_number', 'receipt_date_ad', 'amount_paid')
        //     ->where('token_number', '=', $token_number)
        //     ->first();

        $payment_data = DB::table('vacancy_payment_details as vpd')
            ->select('mpm.name_en as counter_name', 'md.name_en as designation', 'txn_id', 'token_number', 'receipt_number', 'receipt_date_ad', 'amount_paid')
            ->leftjoin('mst_payment_methods as mpm', 'vpd.psp_id', 'mpm.id')
            ->leftjoin('mst_designation as md', 'vpd.designation_id', 'md.id')
            ->where('token_number', $token_number)
            ->first();

        $data['vacancy_details'] = $application_dtl;
        $data['payment_details'] = $payment_data;
        $data["current_date"] = $application_dtl->applied_date_ad;
        $data["applicant_name"] = $application_dtl->fullname;
        $data["applicant_id"] = $application_dtl->applicant_id;
        $data["ad_id"] = $application_dtl->ad_id;
        $data["is_cancelled"] = $application_dtl->is_cancelled;
        $data["gender_id"] = $application_dtl->gender_id;

        return $data;
    }

    // public function getPaymentDetails($id)
    // {
    //     $application_data = $this->getApplicationDetail($id);
    //     $token_number =$application_data->token_number;

    //     dd($token_number);

    //     $payment_data = DB::table('csv_payment_file_details')
    //                         ->select('token_number','receipt_number','receipt_date_ad','amount_paid')
    //                         ->where('token_number', '=', $token_number)
    //                         ->get();

    //     $data['payment_details'] = $payment_data;
    //     return $payment_data;
    // }

    public function getView($id)
    {
        if(DB::table('vacancy_apply')->where([
            ['applicant_id', CrudBooster::myId()],
            ['id', $id]
        ])->doesntExist()) {
            return redirect()->back()->withErrors("Trying to access other ids ...your IP will be monitored")->withInput();
        }
        $data = $this->getApplicationDetail($id);

        $ot_id = $data['vacancy_details']->opening_type_id;
        $data['page_title'] = 'Application View';

        // dd($ot_id);

        if ($ot_id == 2) {
            $this->cbView('vacancy_apply.int_view', $data);
        } else if ($ot_id == 3) {
            $this->cbView('vacancy_apply.file_view', $data);
        } else {
            $this->cbView('vacancy_apply.view', $data);
        }
    }

    public function validation($id = null)
    {
        parent::validation($id);
        //make validation related to vacancy apply.
        //1. is vacancy valid
        //2. age valid (for nt staff no age validation/check emp. code)
        //3. check if documents attached (photo, signature, citizenship)
        //4. check if priviledged group docs attached
        //5. education validation
        //6. training validation
        //7. work. exp validation
        //8. service history validation
        $request_all = Request::all();
        $vacancy_post_id = $request_all["vacancy_post_id"];
        $vacancy = DB::table('vacancy_ad as va')
            ->select('va.id', 'va.opening_type_id', 'va.date_to_publish_ad', 'va.date_to_publish_bs', 'va.last_date_for_application_ad', 'va.last_date_for_application_bs', 'va.vacancy_extended_date_ad', 'va.vacancy_extended_date_bs', "vp.total_req_seats", "vp.open_seats", "vp.mahila_seats", "vp.janajati_seats", "vp.madheshi_seats", "vp.dalit_seats", "vp.apanga_seats", "d.is_council_reg_required", "vp.designation_id")
            ->join("vacancy_post as vp", "vp.vacancy_ad_id", "=", "va.id")
            ->join("mst_designation as d", "vp.designation_id", "=", "d.id")
            ->where("vp.id", $vacancy_post_id)->first();
        $errors = array();

        if (Session::get("is_applicant") != 1) {
            $application_data = $this->getAppliedVacancy($id);
            $applicant_id = $application_data->applicant_id;
        } else {
            $encoded_applicant_id = Session::get('applicant_id');
            $applicant_id = Hashids::decode($encoded_applicant_id);
            $applicant_id = $applicant_id[0];
        }
        $already_applied = DB::table('vacancy_apply')
            ->where([['applicant_id', $applicant_id], ['vacancy_post_id', $vacancy_post_id], ['is_cancelled', 1]])
            ->get();

        if (isset($already_applied) && count($already_applied) > 0) {
            if ($already_applied[0]->is_cancelled != 1) {
                CRUDBooster::redirect(CRUDBooster::adminPath() . "/vacancy_post60", trans("crudbooster.denied_access"));
            }
        }

        if ($vacancy) {
            //1. is vacancy valid
            // $today=new DateTime('');
            $today = Carbon::now(new DateTimeZone('Asia/Kathmandu'))->format('Y-m-d');
            //$publish_date = new DateTime($vacancy->date_to_publish_ad);
            $publish_date = \App\Helpers\VAARS::CDate($vacancy->date_to_publish_ad);
            $publish_date_bs = $vacancy->date_to_publish_bs;

            //$last_date = $vacancy->last_date_for_application_ad;
            $last_date = Carbon::parse($vacancy->last_date_for_application_ad)->format('Y-m-d');
            // $extended_date = $vacancy->vacancy_extended_date_ad;
            $extended_date = Carbon::parse($vacancy->vacancy_extended_date_ad)->format('Y-m-d');
            $actual_last_date = null; //new DateTime("");
            $actual_last_date_bs = "";
            if ($extended_date != null && strlen($extended_date) > 0) {
                $actual_last_date = $extended_date;
                $actual_last_date_bs = $vacancy->vacancy_extended_date_bs;
            } else {
                $actual_last_date = $last_date;
                $actual_last_date_bs = $vacancy->last_date_for_application_bs;
            }
            $actual_last_date = \App\Helpers\VAARS::CDate($actual_last_date);
            if ($today >= $publish_date && $today <= $actual_last_date || Session::get("is_applicant") != 1) {
                //ok valid
            } else {
                $errors["vacancy"] = "You can apply for vacancy between $vacancy->date_to_publish_bs B.S. to $actual_last_date_bs B.S. only.";
            }
            //2. age valid (for nt staff no age validation/check emp. code)
            $applicant = DB::table('applicant_profile')
                ->where('id', $applicant_id)
                ->first();
            //$this->validate_age($applicant, $vacancy->designation_id, $errors);
            if ($applicant->is_nt_staff == 1) {
                //No need to check age validation for NT staff
            } else {
                $age_limits = DB::table("mst_work_level as wl")
                    ->join("mst_designation as d", "wl.id", "=", "d.work_level_id")
                    ->select("wl.min_age", "wl.max_age")
                    ->where("d.id", $vacancy->designation_id)
                    ->first();
                $min_age = 18;
                $max_age = 35;
                if ($age_limits) {
                    if ($age_limits->min_age > 0) {
                        $min_age = $age_limits->min_age;
                    }
                    if ($age_limits->max_age > 0) {
                        $max_age = $age_limits->max_age;
                    }
                }
                $dob_bs = $applicant->dob_bs;
                if (strlen($dob_bs) > 0) {

                    $dob_ad = \App\Helpers\VAARS::CDate($applicant->dob_ad);
                    $min_date_ad = \App\Helpers\VAARS::CDate($applicant->dob_ad); //null;//new DateTime('');
                    //checking for minimum age
                    $min_date_ad = $min_date_ad->addYears($min_age);
                    $max_date_ad = \App\Helpers\VAARS::CDate($applicant->dob_ad); //null;//new DateTime('');

                    // $max_age = $max_age;
                    if ($applicant->gender_id == 2) {
                        $max_date_ad = $max_date_ad->addYears(40);
                        $max_age = 40;
                    } else {
                        $max_date_ad = $max_date_ad->addYears($max_age);
                    }

                    if ($last_date < $min_date_ad) {
                        $d = $publish_date->format('Y-m-d');
                        $errors["dob"] = "You must be between $min_age and $max_age years to apply. You are not $min_age years by the last date to apply that is $last_date B.S. ";
                    }
                    //checking for maximum age
                    if ($publish_date > $max_date_ad) {
                        $d = $actual_last_date->format('Y-m-d');
                        $errors["dob"] = "You must be between $min_age and $max_age years to apply. You have to be $max_age by the Applicant End Date $actual_last_date_bs B.S./ $d A.D.";
                    }
                } else {
                    $errors["dob"] = "Date of birth is not set in your applicant profile page.";
                }
            }
            //3. check if documents attached (photo, signature, citizenship)
            if (strlen($applicant->photo) < 1) {
                $errors["photo"] = "Photo is not uploaded in your applicant profile page.";
            }
            if (strlen($applicant->signature_upload) < 1) {
                $errors["signature"] = "Signature is not uploaded in your applicant profile page.";
            }
            if (strlen($applicant->citizenship_upload) < 1) {
                $errors["citizenship"] = "Citizenship is not uploaded in your applicant profile page.";
            }
            //4. check if priviledged group docs attached
            // if (isset($request_all["is_female"]) && strlen($request_all["is_female"]) > 0 && $request_all["is_female"] == 1) {
            //     $this->validate_privilege_document($applicant_id, 1, $errors);
            // }
            if (isset($request_all["is_janajati"]) && strlen($request_all["is_janajati"]) > 0 && $request_all["is_janajati"] == 1) {
                $this->validate_privilege_document($applicant_id, 2, $errors);
            }
            if (isset($request_all["is_madhesi"]) && strlen($request_all["is_madhesi"]) > 0 && $request_all["is_madhesi"] == 1) {
                $this->validate_privilege_document($applicant_id, 3, $errors);
            }
            if (isset($request_all["is_dalit"]) && strlen($request_all["is_dalit"]) > 0 && $request_all["is_dalit"] == 1) {
                $this->validate_privilege_document($applicant_id, 4, $errors);
            }
            if (isset($request_all["is_handicapped"]) && strlen($request_all["is_handicapped"]) > 0 && $request_all["is_handicapped"] == 1) {
                $this->validate_privilege_document($applicant_id, 5, $errors);
            }
            if (isset($request_all["is_remote_village"]) && strlen($request_all["is_remote_village"]) > 0 && $request_all["is_remote_village"] == 1) {
                $this->validate_privilege_document($applicant_id, 6, $errors);
            }
            if ($vacancy->opening_type_id == 1 || $vacancy->opening_type_id == 2) {
                $this->validate_education($applicant_id, $vacancy->designation_id, $vacancy->opening_type_id, $errors);

                // if (Session::get('is_nt_staff') == 1) {
                //     $this->validate_education($applicant_id, $vacancy->designation_id, $vacancy->opening_type_id, $errors);
                // } else {
                //     $this->validate_education_external($applicant_id, $vacancy->designation_id, $vacancy->opening_type_id, $errors);
                // }
                //6. training validation
                $this->validate_training($applicant_id, $vacancy->designation_id, $errors);
            }
            //5. education validation

            //7. work. exp validation

            //8. internal opening validation
            if ($vacancy->opening_type_id == 3) {
                $this->validate_department_action($applicant_id, $vacancy_post_id, $errors);
            }

            if ($vacancy->opening_type_id == 3 || $vacancy->opening_type_id == 2) {
                //No need to check this validation for Non NT staff
                $this->validate_service_history($applicant_id, $vacancy_post_id, $vacancy->last_date_for_application_ad, $vacancy->opening_type_id, $errors);
            }
        } else {
            $errors["general"] = "Invalid vacancy.";
        }
        // dd($errors);
        if (count($errors) > 0) {
            if (Request::ajax()) {
                $res = response()->json(['message' => trans('crudbooster.alert_validation_error', ['error' => implode(', ', $errors)]), 'message_type' => 'warning'])->send();
                exit;
            } else {
                $res = redirect()->back()
                // ->with("errors", $errors)
                // ->with(['message'=>trans('crudbooster.alert_validation_error', ['error'=>implode(', ', $errors)])
                //         ,'message_type'=>'warning',
                //         'errors' => $errors
                //         ])
                    ->with([
                        "error_title" => "Job Application Validation Fail",
                        // 'errors' => $errors
                    ])
                    ->withErrors(['errors' => $errors])
                    ->withInput();
                \Session::driver()->save();
                $res->send();
                exit;
            }
        }
    }
    // check for department action for file pormotion only
    private function validate_department_action($id, $vacancy_post_id, &$errors)
    {
        $latestFPVacancyAd = DB::select(
            'SELECT va.date_to_publish_ad,
            va.last_date_for_application_ad,
            va.vacancy_extended_date_ad
            from vacancy_post vp
            LEFT join vacancy_ad va on va.id= vp.vacancy_ad_id
            where vp.id=?
            ',
            [$vacancy_post_id]
        );
        $department_action = DB::table('applicant_punishment_details')
            ->where('applicant_id', $id)->get();
        if ($department_action->count() == 0) {
            // return false;
        } else {
            $AdPublishDate = Carbon::parse($latestFPVacancyAd[0]->date_to_publish_ad);
            $LastDateToApply = Carbon::parse($latestFPVacancyAd[0]->last_date_for_application_ad);
            $ExtendedDateToApply = Carbon::parse($latestFPVacancyAd[0]->vacancy_extended_date_ad);
            if (isset($ExtendedDateToApply)) {
                $LastDateToApply = $ExtendedDateToApply;
            }
            foreach ($department_action as $da) {
                // note assuming grade ghatuwa as id 4
                if ($da->punishment_type_id != 4) {
                    $action_from = Carbon::parse($da->date_from_ad);
                    $action_to = Carbon::parse($da->date_to_ad);
                    if ($action_from <= $LastDateToApply && $action_to >= $AdPublishDate)
                    // return true;
                    {
                        $errors["department_action"] = "You are under department Action ,please contact NTC Headquater if not so.";
                    }

                    return;
                } else {
                    $action_from = Carbon::parse($da->date_from_ad);
                    $action_to = $action_from->addYear();
                    if (Carbon::parse($da->date_from_ad) < $LastDateToApply && $action_to > $AdPublishDate)
                    // return true;
                    {
                        $errors["department_action"] = "You are under department Action ,please contact if not so.";
                    }

                    return;
                }
            }
        }
        // return false;
    }
    private function validate_age($applicant, $vacancy, $designation_id, &$errors)
    {
        if ($applicant->is_nt_staff == 1) {
            //No need to check age validation for NT staff
            return;
        }

        //$publish_date = new DateTime($vacancy->date_to_publish_ad);
        $dob_bs = $applicant->dob_bs;
        $age_limits = DB::table("mst_work_level as wl")
            ->join("mst_designation as d", "wl.id", "=", "d.work_level_id")
            ->select("wl.min_age", "wl.max_age")
            ->where("d.id", $designation_id)
            ->first();
        $min_age = 18;
        $max_age = 35;
        if ($age_limits) {
            if ($age_limits->min_age > 0) {
                $min_age = $age_limits->min_age;
            }
            if ($age_limits->max_age > 0) {
                $max_age = $age_limits->max_age;
            }
        }

        if (strlen($dob_bs) > 0) {
            $dob_ad = new DateTime($applicant->dob_ad);
            $min_date_ad = new Carbon($applicant->dob_ad); //null;//new DateTime('');
            //checking for minimum age
            $min_date_ad = $min_date_ad->addYears($min_age);
            $max_date_ad = new Carbon($applicant->dob_ad); //null;//new DateTime('');
            //$max_age = 35;
            if ($applicant->gender_id == 2) {
                $max_date_ad = $max_date_ad->addYears(40);
                $max_age = 40;
            } else {
                $max_date_ad = $max_date_ad->addYears($max_age);
            }

            if ($publish_date < new DateTime($min_date_ad->toDateTimeString())) {
                $d = $publish_date->format('Y-m-d');
                $errors["dob"] = "You must be between $min_age and $max_age years to apply. You are not 21 years by the Advertisement publish date $publish_date_bs B.S. / $d A.D.";
            }
            //checking for maximum age
            if ($actual_last_date > new DateTime($max_date_ad->toDateTimeString())) {
                $d = $actual_last_date->format('Y-m-d');
                $errors["dob"] = "You must be between $min_age and $max_age years to apply. You have to be $max_age by the Applicant End Date $actual_last_date_bs B.S./ $d A.D.";
            }
        } else {
            $errors["dob"] = "Date of birth is not set in your applicant profile page.";
        }
    }

    private function validate_experience($applicant_id, $designation_id, $work_level_id, &$errors)
    {
        $applicant = intval($applicant_id);
        $desig = intval($designation_id);
        $level = intval($work_level_id);
        $req_level = $level - 1;

        // no need of experience if CA

        $council = DB::table('applicant_council_certificate')
            ->where([['applicant_id', $applicant], ['is_deleted', 0], ['council_id', 2]])
            ->get();

        if (isset($council) && count($council) > 0) {
            return;
        }

        $experience = DB::table('applicant_exp_info')
            ->where([['applicant_id', $applicant], ['work_level', $req_level]])
            ->get();

        if (!isset($experience) || count($experience) == 0) {
            $err = "Please update your experience details.";
            $errors["experience"] = $err;
            return;
        }

        $experience_rqd = DB::table('mst_designation')
            ->select('internal_experience', 'external_experience')
            ->where('work_level_id', $req_level)
            ->get();

        if (isset($experience_rqd) && count($experience_rqd) > 0) {
            $int_exp = $experience_rqd[0]->internal_experience;
            $ext_exp = $experience_rqd[0]->external_experience;
        }

        if (isset($experience) && count($experience) > 0) {
            // success
            $date_from_ad = $experience[0]->date_from_ad;
            $date_to_ad = $experience[0]->date_to_ad;
            $date_from = Carbon::parse($date_from_ad);
            $date_to = Carbon::parse($date_to_ad);
            $diff = $date_from->diffInDays($date_to);
            $days = 0;
            if (Session::get(is_nt_staff) == 1) {
                $days = 365 * $int_exp;
            } else {
                $days = 365 * $ext_exp;
            }
            if ($diff < $days) { // check 5 years
                //not enough work experience
                $err = "Sorry, you do not have enough work experience.";
                $errors["experience"] = $err;
                return;
            }
        }
    }

    private function validate_council_certificate($applicant_id, $designation_id, &$errors)
    {
        $applicant = intval($applicant_id);
        $desig = intval($designation_id);
        // Engineering Council = council_id = 1
        $council = DB::table('applicant_council_certificate')
            ->where([['applicant_id', $applicant], ['is_deleted', 0], ['council_id', 1]])
            ->get();
        if (isset($council) && count($council) > 0) {
            // success
        } else {
            $err = "Please upload your Nepal Engineering Council certificate to apply.";
            $errors["council"] = $err;
            return;
        }
    }

    private function validate_ca_certificate($applicant_id, $designation_id, &$errors)
    {
        $applicant = intval($applicant_id);
        $desig = intval($designation_id);
        // CA = council_id = 2
        $council = DB::table('applicant_council_certificate')
            ->where([['applicant_id', $applicant], ['is_deleted', 0], ['council_id', 2]])
            ->get();
        if (isset($council) && count($council) > 0) {
            // success
        } else {
            $err = "Please upload your Nepal Chartered Accountant Council certificate to apply.";
            $errors["ca"] = $err;
            return;
        }
    }

    private function validate_education($applicant_id, $designation_id, $opening_type, &$errors)
    {
        $desig = intval($designation_id);

        // validate degrees first
        if (Session::get('is_nt_staff') != 1) {
            $desig_degree = DB::table('mst_designation_degree as dd')
                ->select('dd.edu_degree_id', 'ed.name_en', 'ed.edu_level_id')
                ->leftJoin('mst_edu_degree as ed', 'ed.id', '=', 'dd.edu_degree_id')
                ->where([['dd.designation_id', $desig], ['dd.is_deleted', 0], ['dd.is_for_external', 1]])
                ->get();
        } else {
            if ($opening_type == 2) {
                $desig_degree = DB::table('mst_designation_degree as dd')
                    ->select('dd.edu_degree_id', 'ed.name_en', 'ed.edu_level_id')
                    ->leftJoin('mst_edu_degree as ed', 'ed.id', '=', 'dd.edu_degree_id')
                    ->where([['dd.designation_id', $desig], ['dd.is_deleted', 0], ['dd.is_for_internal', 1]])
                    ->get();
            } elseif ($opening_type == 3) {
                $desig_degree = DB::table('mst_designation_degree as dd')
                    ->select('dd.edu_degree_id', 'ed.name_en', 'ed.edu_level_id')
                    ->leftJoin('mst_edu_degree as ed', 'ed.id', '=', 'dd.edu_degree_id')
                    ->where([['dd.designation_id', $desig], ['dd.is_deleted', 0], ['dd.is_additional', 1]])
                    ->get();
            } else {
                $desig_degree = DB::table('mst_designation_degree as dd')
                    ->select('dd.edu_degree_id', 'ed.name_en', 'ed.edu_level_id')
                    ->leftJoin('mst_edu_degree as ed', 'ed.id', '=', 'dd.edu_degree_id')
                    ->where([['dd.designation_id', $desig], ['dd.is_deleted', 0], ['dd.is_for_external', 1]])
                    ->get();
            }
        }

        // dd($desig_degree);

        // list degrees required for post
        if (isset($desig_degree) && count($desig_degree) > 0) {
            foreach ($desig_degree as $degree) {
                $edu_degree_id = $degree->edu_degree_id;
                $degrees[] = $edu_degree_id;
            }

            //list degrees of applicant
            $applicant_degree = DB::table('applicant_edu_info')
                ->select('edu_degree_id')
                ->distinct('designation_id')
                ->where([['applicant_id', $applicant_id], ['is_deleted', 0]])
                ->wherein('edu_degree_id', $degrees)
                ->get();
        }

        // check if applicant has one of the required degrees
        if (isset($applicant_degree) && count($applicant_degree) > 0) {
            // education degrees verified

            // check designation service type
            // if administrative :
            // check following
            // level 4,6 - edu only
            // level 8,9 - edu / exp
            // level 8, CA - edu, CA Certificate
            // if techical :
            // check following
            // level 3,4 - edu, training
            // level 7 - edu, council certificate
            // level 8,9 - edu, exp, council certificate
            $work_service = DB::table('mst_designation as d')
                ->where('d.id', $desig)
                ->select('work_service_id', 'work_level_id', 's.name_en as service', 'l.name_en as level')
                ->leftJoin('mst_work_service as s', 's.id', '=', 'd.work_service_id')
                ->leftJoin('mst_work_level as l', 'l.id', '=', 'd.work_level_id')
                ->first();

            // dd($work_service);

            if (isset($work_service) && count($work_service) > 0) {
                $service_id = $work_service->work_service_id;
                $service = $work_service->service;
                $level_id = $work_service->work_level_id;
                $level = $work_service->level;
                if ($service_id == 1) { // Technical
                    if ($level == '3' || $level == '4') {
                        // level 3,4 - edu, training
                        $this->validate_experience($applicant_id, $desig, $level, $errors);
                    }
                    if ($level == '7') {
                        // level 7 - edu, council certificate
                        $this->validate_council_certificate($applicant_id, $desig, $errors);
                    }
                    if ($level == '8' || $level == '9') {
                        // level 8,9 - edu, exp, council certificate
                        $this->validate_experience($applicant_id, $desig, $level, $errors);
                        $this->validate_council_certificate($applicant_id, $desig, $errors);
                    }
                } elseif ($service_id == 2) { // Admin
                    if ($level == '4' || $level == '6') {
                        // level 4,6 - edu only
                    }
                    if ($level == '8' || $level == '9') {
                        // level 8,9 - edu / exp
                        $this->validate_experience($applicant_id, $desig, $level, $errors);
                    }
                    if ($level == '8' && $desig == '4') {
                        // level 8, CA - edu, CA Certificate
                        $this->validate_ca_certificate($applicant_id, $desig, $errors);
                    }
                } else {
                    // do nothing for generic
                }
            }
            // applicant_exp_info
        } else {
            $err = "Not valid Education Qualification.";
            // $err = "Not valid Education Qualification. Required Degrees are (";
            // foreach ($desig_degree as $deg) {
            //     $err .= $deg->name_en . ",";
            // }
            // $err .= ")";
            // $err .= ".";
            $errors["education"] = $err;
            return;
        }

        // check majors only if engineering
        $majors = DB::table('mst_designation as d')
            ->join("mst_designation_degree_major as ddm", "ddm.designation_id", "=", "d.id")
            ->join("mst_edu_major as em", "ddm.edu_major_id", "=", "em.id")
            ->select("d.id", "em.name_en as major_name_en", "em.name_np as major_name_np", "ddm.edu_major_id")
            ->where("d.id", $desig)->get();

        if (isset($majors) && count($majors) > 0) {
            $err .= " Not valid Education Qualification. Required majors are (";
            foreach ($majors as $maj) {
                $err .= $maj->major_name_en . ",";
            }
            $err .= ")";
            $err .= ".";
            $errors["education"] = $err;
        }
    }

    private function validate_education_external($applicant_id, $designation_id, $opening_type, &$errors)
    {
        $desig = intval($designation_id);
        $edu = DB::select('SELECT
        ei.applicant_id,
        d.*,
        m.major_name,
        m.edu_major_id
    FROM
        applicant_edu_info AS ei
        INNER JOIN (
        SELECT
            d.id,
            d.name_en,
            ed.name_en degree_name,
            dd1.edu_degree_id,
            d.is_council_reg_required,
            ed.is_all_degree_of_same_edu_level,
            ed.edu_level_id,
            dd1.is_training_required
        FROM
            mst_designation d
            LEFT JOIN mst_designation_degree dd1 ON d.id = dd1.designation_id
            LEFT JOIN mst_edu_degree ed ON dd1.edu_degree_id = ed.id
        WHERE
            d.id =:designation_id
        ) AS d ON d.edu_degree_id = ei.edu_degree_id
        OR ( d.is_all_degree_of_same_edu_level = 1 AND ei.edu_level_id = d.edu_level_id )
        INNER JOIN (
        SELECT
            d.id,
            d.name_en,
            em.name_en major_name,
            ddm1.edu_major_id
        FROM
            mst_designation d
            LEFT JOIN mst_designation_degree_major ddm1 ON d.id = ddm1.designation_id
            LEFT JOIN mst_edu_major em ON ddm1.edu_major_id = em.id
        WHERE
            d.id =:designation_id1
        ) AS m ON m.edu_major_id = ei.edu_major_id
        OR m.edu_major_id IS NULL
        OR d.is_training_required = 1
    WHERE
        ei.applicant_id =:applicant_id', ['designation_id' => $desig, 'designation_id1' => $desig, 'applicant_id' => $applicant_id]);

        if (isset($edu) && count($edu) > 0) {
            //education qualification OK.
        } else {
            if ($opening_type == 2) {
                $degrees = DB::table('mst_designation as d')
                    ->join("mst_designation_degree as dd", "dd.designation_id", "=", "d.id")
                    ->join("mst_edu_degree as ed", "dd.edu_degree_id", "=", "ed.id")
                    ->select("d.id", "d.name_en as desgination_name_en", "ed.name_en as degree_name_en", "ed.name_np as degree_name_np", "dd.edu_degree_id", "d.is_council_reg_required")
                    ->where([["d.id", $designation_id], ['is_for_internal', 1], ['is_additional', 0]])->get();
            } else {
                $degrees = DB::table('mst_designation as d')
                    ->join("mst_designation_degree as dd", "dd.designation_id", "=", "d.id")
                    ->join("mst_edu_degree as ed", "dd.edu_degree_id", "=", "ed.id")
                    ->select("d.id", "d.name_en as desgination_name_en", "ed.name_en as degree_name_en", "ed.name_np as degree_name_np", "dd.edu_degree_id", "d.is_council_reg_required")
                    ->where([["d.id", $designation_id], ['is_for_internal', 0], ['is_additional', 0]])->get();
            }

            $majors = DB::table('mst_designation as d')
                ->join("mst_designation_degree_major as ddm", "ddm.designation_id", "=", "d.id")
                ->join("mst_edu_major as em", "ddm.edu_major_id", "=", "em.id")
                ->select("d.id", "em.name_en as major_name_en", "em.name_np as major_name_np", "ddm.edu_major_id")
                ->where("d.id", $designation_id)->get();
            if (isset($degrees) && count($degrees) > 0) {
                $err = "Not valid Education Qualification. Required Degrees are (";
                foreach ($degrees as $deg) {
                    $err .= $deg->degree_name_en . ",";
                }
                $err .= ")";
                if (isset($majors) && count($majors) > 0) {
                    $err .= " with majors in (";
                    foreach ($majors as $maj) {
                        $err .= $maj->major_name_en . ",";
                    }
                    $err .= ")";
                }
                $err .= ".";
                $errors["education"] = $err;
            }
        }

        // $edu = DB::table(DB::raw('('.$sub_query.') as edu'))
        //     ->join('applicant_edu_info as ei ', function ($join) {
        //         $join->on("edu.edu_degree_id", "=", "ei.edu_degree_id");
        //         $join->on("edu.edu_major_id", "=", "ei.edu_major_id");
        //     })
        //     ->where("pc.applicant_id", $applicant_id)
        //     ->get();
    }

    private function validate_training($applicant_id, $designation_id, &$errors)
    {

        $desig = intval($designation_id);
        //check if the applicant has got any degree that doesnot required training
        $any_valid_edu = DB::select('SELECT
        ei.applicant_id, d.*, m.major_name, m.edu_major_id
    FROM applicant_edu_info as ei
        INNER JOIN (
            SELECT
                d.id, d.name_en, ed.name_en degree_name, dd.edu_degree_id, d.is_council_reg_required
                , ed.is_all_degree_of_same_edu_level, ed.edu_level_id
                , dd.is_training_required
            FROM mst_designation d
                LEFT JOIN  mst_designation_degree dd on d.id = dd.designation_id
                LEFT JOIN 	mst_edu_degree ed on dd.edu_degree_id = ed.id
            WHERE d.id =:designation_id
        ) as d on d.edu_degree_id = ei.edu_degree_id
            OR (d.is_all_degree_of_same_edu_level =:is_all_degree_of_same_edu_level AND ei.edu_level_id = d.edu_level_id)
        INNER JOIN
        (
            SELECT
                d.id, d.name_en, em.name_en major_name, ddm1.edu_major_id
            FROM mst_designation d
                LEFT JOIN  mst_designation_degree_major ddm1 on d.id = ddm1.designation_id
                LEFT JOIN mst_edu_major em on ddm1.edu_major_id = em.id
            WHERE d.id =:designation_id1
        ) as m on m.edu_major_id = ei.edu_major_id OR m.edu_major_id is null
WHERE ei.applicant_id =:applicant_id and d.is_training_required =:is_training_required', [
            'designation_id' => $designation_id,
            'is_all_degree_of_same_edu_level' => 1,
            'designation_id1' => $designation_id,
            'applicant_id' => $applicant_id,
            'is_training_required' => 0,
        ]);

        if (isset($any_valid_edu) && count($any_valid_edu) > 0) {
            //NO trainings requried so no need to check further.
            return;
        }

        //NOW check if applicant has taken proper training or not.
        $sql = "SELECT	ti.applicant_id, d.*, m.major_name,	m.training_major_id
        FROM
            applicant_training_info AS ti
        INNER JOIN (
            SELECT
                d.id, d.name_en, t.name_en degree_name, dt.training_id
            FROM
                mst_designation d
            LEFT JOIN mst_designation_training dt ON d.id = dt.designation_id
            LEFT JOIN mst_training t ON dt.training_id = t.id
            WHERE d.id = $desig
        ) AS d ON d.training_id = ti.training_id
        INNER JOIN (
            SELECT
                d.id, d.name_en, tm.name_en major_name, dtm.training_major_id
            FROM
                mst_designation d
            LEFT JOIN mst_designation_training_major dtm ON d.id = dtm.designation_id
            LEFT JOIN mst_training_major tm ON dtm.training_major_id = tm.id
            WHERE d.id = $desig
        ) AS m ON m.training_major_id = ti.training_major_id OR m.training_major_id IS NULL
        WHERE
            ti.applicant_id = $applicant_id";

        $train = DB::select('SELECT	ti.applicant_id, d.*, m.major_name,	m.training_major_id
        FROM
            applicant_training_info AS ti
        INNER JOIN (
            SELECT
                d.id, d.name_en, t.name_en degree_name, dt.training_id
            FROM
                mst_designation d
            LEFT JOIN mst_designation_training dt ON d.id = dt.designation_id
            LEFT JOIN mst_training t ON dt.training_id = t.id
            WHERE d.id =:desig
        ) AS d ON d.training_id = ti.training_id
        INNER JOIN (
            SELECT
                d.id, d.name_en, tm.name_en major_name, dtm.training_major_id
            FROM
                mst_designation d
            LEFT JOIN mst_designation_training_major dtm ON d.id = dtm.designation_id
            LEFT JOIN mst_training_major tm ON dtm.training_major_id = tm.id
            WHERE d.id =:desig1
        ) AS m ON m.training_major_id = ti.training_major_id OR m.training_major_id IS NULL
        WHERE
            ti.applicant_id =:applicant_id', ['desig' => $desig, 'desig1' => $desig, 'applicant_id' => $applicant_id]);

        if (isset($train) && count($train) > 0) {
            //Training qualification OK.
        } else {
            $degrees = DB::select('SELECT
            d.id, d.name_en, t.name_en degree_name, dt.training_id
        FROM mst_designation d
            INNER JOIN mst_designation_training dt ON d.id = dt.designation_id
            INNER JOIN mst_training t ON dt.training_id = t.id
        WHERE d.id =:desig', ['desig' => $desig]);

            $majors = DB::select('SELECT
            d.id, d.name_en, tm.name_en major_name, dtm.training_major_id
        FROM mst_designation d
            INNER JOIN mst_designation_training_major dtm ON d.id = dtm.designation_id
            INNER JOIN mst_training_major tm ON dtm.training_major_id = tm.id
        WHERE d.id =:desig', ['desig' => $desig]);

            if (isset($degrees) && count($degrees) > 0) {
                $err = "Not valid Trainings. Required Trainings are (";
                foreach ($degrees as $deg) {
                    $err .= $deg->degree_name . ",";
                }
                $err .= ")";
                if (isset($majors) && count($majors) > 0) {
                    $err .= " with majors in (";
                    foreach ($majors as $maj) {
                        $err .= $maj->major_name . ",";
                    }
                    $err .= ")";
                }
                $err .= ".";
                $errors["training"] = $err;
            }
        }
    }

    private function validate_privilege_document($applicant_id, $privilege_group_id, &$errors)
    {
        $doc = DB::table('applicant_privilege_certificate as pc')
            ->leftjoin("mst_privilege_group as p", function ($join) {
                $join->on("pc.privilege_group_id", "=", "p.id");
                //$join->on("pc.applicant_id", "=", $applicant_id);
            })
            ->select("pc.privilege_certificate_upload", "pc.registration_no", "pc.registration_date_bs", "p.code", "p.name_en as privilege_group_name_en", "p.name_np as privilege_group_name_np")
            ->where("pc.privilege_group_id", $privilege_group_id)
            ->where("pc.applicant_id", $applicant_id)
            ->first();
        if (isset($doc)) {
            if (strlen($doc->privilege_certificate_upload) < 1) {
                $errors[$doc->code . "_certificate"] = "$doc->privilege_group_name_en / $doc->privilege_group_name_np certificate is not uploaded in your applicant profile page.";
            }
            // if (strlen($doc->registration_no) < 1) {
            //     $errors[$doc->code."_registration_no"] = "$doc->privilege_group_name_en / $doc->privilege_group_name_np Registration Number is not set in your applicant profile page.";
            // }
            // if (strlen($doc->registration_date_bs) < 1) {
            //     $errors[$doc->code."_registration_date"] = "$doc->privilege_group_name_en / $doc->privilege_group_name_np Registration Date is not set in your applicant profile page.";
            // }
        } else {
            $doc = DB::table("mst_privilege_group as p")
                ->select("p.code", "p.name_en as privilege_group_name_en", "p.name_np as privilege_group_name_np")
                ->where("p.id", $privilege_group_id)
                ->first();
            $errors[$doc->code] = "[$doc->privilege_group_name_en / $doc->privilege_group_name_np] Certificate is not set in your applicant profile page.";
        }
    }

    private function validate_service_history($applicant_id, $vacancy_post_id, $last_date_for_application_ad, $opening_type, &$errors)
    {
        // check if NT Staff
        if (Session::get('is_nt_staff') == 1) {

            //If yes, get service history
            $service_history = DB::table('applicant_service_history as ash')
                ->select(
                    'ash.service_group as service_group_id',
                    'ash.service_subgroup as service_subgroup_id',
                    'mwl.id as work_level_id',
                    'mwl.name_en as work_level',
                    'ash.appointment_letter',
                    'ash.distance_certificate',
                    'ash.leave_letter',
                    'ash.date_to_ad as end_date',
                    'ash.seniority_date_ad'
                )
                ->leftJoin('mst_work_level as mwl', 'mwl.id', '=', 'ash.work_level')
                ->where([['ash.applicant_id', $applicant_id], ['ash.is_current', 1], ['ash.is_deleted', 0]])
                ->first();

            if (count($service_history) == 0) {
                $errors["service_history"] = "Please add your current working office details first!";
                return;
            }

            if (strlen($service_history->appointment_letter) < 1) {
                $errors["appointment_letter"] = "Appointment letter for your current working office is missing.";
                return;
            }

            $vacancy = DB::table('vacancy_post as p')
                ->select('p.vacancy_ad_id', 'p.ad_no', 'd.id as designation_id', 'd.name_en as designation', 'd.work_level_id', 'd.service_group_id', 'wl.name_en as work_level', 'ws.name_en as work_service')
                ->leftjoin('mst_designation as d', 'd.id', '=', 'p.designation_id')
                ->leftjoin('mst_work_service as ws', 'ws.id', '=', 'd.work_service_id')
                ->leftjoin('mst_work_service_group as wsg', 'wsg.id', '=', 'd.service_group_id')
                ->leftjoin('mst_work_level as wl', 'wl.id', '=', 'd.work_level_id')
                ->where('p.id', $vacancy_post_id)
                ->first();

            // dd($service_history, $vacancy);

            // check work group
            if ($vacancy->service_group_id != 3 && $vacancy->service_group_id != $service_history->service_group_id) {
                $errors["service_group"] = "Your service groups do not match.";
                return;
            }

            // check work_level
            // $my_level = $service_history->work_level;
            // $required_level = $vacancy->work_level;

            // if($my_level != $required_level){
            //     dd("success");
            // }

            if ($service_history->work_level + 1 != $vacancy->work_level) {
                $errors["service_group"] = "Your current work level should be one step below the job you are applying for.";
                return;
            }

            //check 3 years
            $min_days = 1095; // 3 years

            $formatted_dt1 = Carbon::parse($service_history->seniority_date_ad);
            $formatted_dt2 = Carbon::parse($last_date_for_application_ad);
            $date_diff = $formatted_dt1->diffInDays($formatted_dt2);

            // check opening type for internal competition or file promotion
            if ($opening_type == 2) {
                // Internal Competition
                if ($date_diff <= $min_days) { // Do this if more than 3 years only!
                    $errors["min_years"] = "Minimun years of service must be 3 years.";
                    return;
                }
            } elseif ($opening_type == 3) {
                // File Promotion
                $today = VAARS::Today();
                $exploded_today = explode('-', $today);
                $LastShrawanAd = $this->checkLastShrawanDiff($exploded_today, $formatted_dt1);
                $LastShrawanAd = Carbon::parse($LastShrawanAd);
                $date_diff = $formatted_dt1->diffInDays($LastShrawanAd);
                if ($date_diff <= $min_days) { // Do this if more than 3 years only!
                    $errors["min_years"] = "Minimun years of service must be 3 years in Ashadh end.";
                    return;
                }
            } else {
                // Open Competition
            }
        } else {
            // applicant is new user. do nothing.
        }
    }

    public function checkLastShrawanDiff($exploded_today)
    {
        $year = (int) $exploded_today[0];
        $month = (int) $exploded_today[1];
        $month = 6;
        $day = (int) $exploded_today[2];
        if ($month >= 7) {
            $adlastShrawan = $this->ShrawanLastAd($year);
        } else {
            $year = $year - 1;
            $adlastShrawan = $this->ShrawanLastAd($year);
        }
        return $adlastShrawan;
    }

    public function ShrawanLastAd($year)
    {
        $nepaliDate = Bsdate::eng_to_nep($year, 7, 16);

        if ((int) $nepaliDate['month'] == 3) {
            $ad_date = $year . '-07-16';
            return $ad_date;
        }
        $nepaliDate = Bsdate::eng_to_nep($year, 7, 15);
        if ((int) $nepaliDate['month'] == 3) {
            $ad_date = $year . '-07-15';
            return $ad_date;
        }
        $nepaliDate = Bsdate::eng_to_nep($year, 7, 14);
        if ((int) $nepaliDate['month'] == 3) {
            $ad_date = $year . '-07-14';
            return $ad_date;
        }
    }

    /*s
    | ----------------------------------------------------------------------
    | Hook for button selected
    | ----------------------------------------------------------------------
    | @id_selected = the id selected
    | @button_name = the name of button
    |
     */
    public function postAddSave()
    {
        //dd(Request::all());



        $is_applied_before = DB::table('vacancy_apply')
            ->select(DB::raw('count(*) as applied_count'))
            ->where([
                ['applicant_id', '=', CRUDBooster::myId()],
                ['vacancy_post_id', '=', $this->arr['vacancy_post_id']],
            ])
            ->first();
        if ($is_applied_before->applied_count == 0) {
            // if ($is_applied_before->applied_count == 0 && $is_cancelled == 1)  {

            $this->cbLoader();
            if (!CRUDBooster::isCreate() && $this->global_privilege == false) {
                CRUDBooster::insertLog(trans('crudbooster.log_try_add_save', ['name' => Request::input($this->title_field), 'module' => CRUDBooster::getCurrentModule()->name]));
                //dd('dev');
                CRUDBooster::redirect(CRUDBooster::adminPath(), trans("crudbooster.denied_access"));
            }

            //dd($this->table);

            //$this->validation();
            $this->input_assignment();
            //get opening type
            $OT = DB::table('vacancy_post')
                ->select('vacancy_ad.opening_type_id')
                ->leftjoin('vacancy_ad', 'vacancy_ad.id', '=', 'vacancy_post.vacancy_ad_id')
                ->where('vacancy_post.id', $this->arr['vacancy_post_id'])
                ->first();

            if (Schema::hasColumn($this->table, 'created_at')) {
                $this->arr['created_at'] = date('Y-m-d H:i:s');
            }
            $this->arr['fiscal_year_id']=Session::get('fiscal_year_id');


            $this->hook_before_add($this->arr);

            if (!isset($this->arr[$this->primary_key])) {
                // $id = DB::table($this->table)->insertGetId($this->arr);
                $this->arr[$this->primary_key] = $id = CRUDBooster::newId($this->table);
            } else {
                $id = $this->arr[$this->primary_key];
            }

            //dd('dev', $this->data_inputan);

            DB::table($this->table)->insert($this->arr);

            //Looping Data Input Again After Insert
            foreach ($this->data_inputan as $ro) {
                $name = $ro['name'];
                if (!$name) {
                    continue;
                }

                $inputdata = Request::get($name);

                //Insert Data Checkbox if Type Datatable
                if ($ro['type'] == 'checkbox' || $ro['type'] == 'checkbox-2') {
                    if ($ro['relationship_table']) {
                        $datatable = explode(",", $ro['datatable'])[0];
                        $foreignKey2 = CRUDBooster::getForeignKey($datatable, $ro['relationship_table']);
                        $foreignKey = CRUDBooster::getForeignKey($this->table, $ro['relationship_table']);
                        DB::table($ro['relationship_table'])->where($foreignKey, $id)->delete();

                        if ($inputdata) {
                            $relationship_table_pk = CB::pk($ro['relationship_table']);
                            foreach ($inputdata as $input_id) {
                                DB::table($ro['relationship_table'])->insert([
                                    $relationship_table_pk => CRUDBooster::newId($ro['relationship_table']),
                                    $foreignKey => $id,
                                    $foreignKey2 => $input_id,
                                ]);
                            }
                        }
                    }
                }

                if ($ro['type'] == 'select2' || $ro['type'] == 'select2-c') {
                    if ($ro['relationship_table']) {
                        $datatable = explode(",", $ro['datatable'])[0];
                        $foreignKey2 = CRUDBooster::getForeignKey($datatable, $ro['relationship_table']);
                        $foreignKey = CRUDBooster::getForeignKey($this->table, $ro['relationship_table']);
                        DB::table($ro['relationship_table'])->where($foreignKey, $id)->delete();

                        if ($inputdata) {
                            foreach ($inputdata as $input_id) {
                                $relationship_table_pk = CB::pk($row['relationship_table']);
                                DB::table($ro['relationship_table'])->insert([
                                    $relationship_table_pk => CRUDBooster::newId($ro['relationship_table']),
                                    $foreignKey => $id,
                                    $foreignKey2 => $input_id,
                                ]);
                            }
                        }
                    }
                }

                if ($ro['type'] == 'child') {
                    $name = str_slug($ro['label'], '');
                    $columns = $ro['columns'];
                    $count_input_data = count(Request::get($name . '-' . $columns[0]['name'])) - 1;
                    $child_array = [];

                    for ($i = 0; $i <= $count_input_data; $i++) {
                        $fk = $ro['foreign_key'];
                        $column_data = [];
                        $column_data[$fk] = $id;
                        foreach ($columns as $col) {
                            $colname = $col['name'];
                            $column_data[$colname] = Request::get($name . '-' . $colname)[$i];
                        }
                        $child_array[] = $column_data;
                    }

                    $childtable = CRUDBooster::parseSqlTable($ro['table'])['table'];
                    DB::table($childtable)->insert($child_array);
                }
            }

            $this->hook_after_add($this->arr[$this->primary_key]);

            $this->return_url = ($this->return_url) ? $this->return_url : Request::get('return_url');

            //insert log
            CRUDBooster::insertLog(trans("crudbooster.log_add", ['name' => $this->arr[$this->title_field], 'module' => CRUDBooster::getCurrentModule()->name]));
            if (($OT->opening_type_id) == 3) {
                if ($this->return_url) {
                    if (Request::get('submit') == trans('crudbooster.button_save_more')) {
                        CRUDBooster::redirect(Request::server('HTTP_REFERER'), trans("crudbooster.alert_add_data_success"), 'success');
                    } else {
                        CRUDBooster::redirect($this->return_url, trans("तपाइको दरखास्त भर्ने कार्य सम्पन्न भएको छ। सोको जानकारी तपाइको email id मा पठाइएको छ।<br/>धन्यबाद।"), 'success');
                    }
                } else {
                    if (Request::get('submit') == trans('crudbooster.button_save_more')) {
                        CRUDBooster::redirect(CRUDBooster::mainpath('add'), trans("crudbooster.alert_add_data_success"), 'success');
                    } else {
                        CRUDBooster::redirect(CRUDBooster::mainpath(), trans("तपाइको दरखास्त भर्ने कार्य सम्पन्न भएको छ। सोको जानकारी तपाइको email id मा पठाइएको छ।<br/>धन्यबाद।"), 'success');
                    }
                }
            } else {
                if ($this->return_url) {
                    if (Request::get('submit') == trans('crudbooster.button_save_more')) {
                        CRUDBooster::redirect(Request::server('HTTP_REFERER'), trans("crudbooster.alert_add_data_success"), 'success');
                    } else {
                        CRUDBooster::redirect($this->return_url, trans("तपाइको दरखास्त भर्ने कार्य सम्पन्न भएको छ। Wallets बाट परिक्षा शुल्क तिर्नको लागि Payment Option मा गएर कुनै Wallets प्रयोग गरि भुक्तानी गर्न सक्नु हुनेछ अथवा तपाइको email id खोलि प्राप्त भएको token slip print गरि नेपाल टेलिकमको महसुल counter बाट परीक्षा शुल्क बुझाउन अनुरोध गरिन्छ।<br/>धन्यबाद।"), 'success');
                        // CRUDBooster::redirect($this->return_url, trans("तपाइको दरखास्त भर्ने कार्य सम्पन्न भएको छ। तपाइको email id खोलि प्राप्त भएको token slip print गरि नेपाल टेलिकमको महसुल counter बाट परीक्षा शुल्क बुझाउन अनुरोध गरिन्छ।<br/>धन्यबाद।"), 'success');
                    }
                } else {
                    if (Request::get('submit') == trans('crudbooster.button_save_more')) {
                        CRUDBooster::redirect(CRUDBooster::mainpath('add'), trans("crudbooster.alert_add_data_success"), 'success');
                    } else {
                        CRUDBooster::redirect(CRUDBooster::mainpath(), trans("तपाइको दरखास्त भर्ने कार्य सम्पन्न भएको छ। तपाइको दरखास्त भर्ने कार्य सम्पन्न भएको छ। Wallets बाट परिक्षा शुल्क तिर्नको लागि Payment Option मा गएर कुनै wallets प्रयोग गरि भुक्तानी गर्न सक्नु हुनेछ अथवा तपाइको email id खोलि प्राप्त भएको token slip print गरि नेपाल टेलिकमको महसुल counter बाट परीक्षा शुल्क बुझाउन अनुरोध गरिन्छ।<br/>धन्यबाद।"), 'success');
                    }
                }
            }
        } else {
            CRUDBooster::redirect(CRUDBooster::mainpath(), trans("तपाइको दरखास्त भर्ने कार्य सम्पन्न भएको छ। सोको जानकारी तपाइको email id मा पठाइएको छ।<br/>धन्यबाद।"), 'success');
        }
    }
    public function actionButtonSelected($id_selected, $button_name)
    {
        //Your code here
    }

    /*
    | ----------------------------------------------------------------------
    | Hook for manipulate query of index result
    | ----------------------------------------------------------------------
    | @query = current sql query
    |
     */
    public function hook_query_index(&$query)
    {
        //Your code here
        $applicant_id = Session::get('applicant_id');
        if (!is_int($applicant_id)) {

            $applicant_id = Hashids::decode($applicant_id)[0];
        }
        $query->where('applicant_id', $applicant_id);
         $query->where('fiscal_year_id', Session::get('fiscal_year_id'));

        $ad_id = Request::get('ad');
        if ($ad_id != 0) {
            $md_id = Request::get('md');

            if ($md_id != 0) {
                $query->where([['vacancy_ad_id', $ad_id], ['vacancy_apply.designation_id', $md_id], ['is_deleted', 0]])
                    ->orderby('applicant_id');
            } else {
                $query->where([['vacancy_ad_id', $ad_id], ['is_deleted', 0]])
                    ->orderby('applicant_id');
                //  dd($ad_id);
            }
        }
    }

    /*
    | ----------------------------------------------------------------------
    | Hook for manipulate row of index table html
    | ----------------------------------------------------------------------
    |
     */
    public function hook_row_index($column_index, &$column_value)
    {
        //Your code here
    }

    /*
    | ----------------------------------------------------------------------
    | Hook for manipulate data input before add data is execute
    | ----------------------------------------------------------------------
    | @arr
    |
     */
    public function hook_before_add(&$postdata)
    {
        //Your code here

        $encoded_applicant_id = Session::get('applicant_id');
        $applicant_id = Hashids::decode($encoded_applicant_id);
        $applicant_id = $applicant_id[0];
        $postdata['applicant_id'] = $applicant_id;
        $postdata['is_application_confirmed'] = 1;
    }

    public function checkExtendedFine($application_id)
    {}

    /*
    | ----------------------------------------------------------------------
    | Hook for execute command after add public static function called
    | ----------------------------------------------------------------------
    | @id = last insert id
    |
     */
    private function getAppliedVacancy($application_id)
    {
        return DB::table('vacancy_apply as va')
            ->select(
                'va.applicant_id',
                'vp.mahila_seats',
                'vp.janajati_seats',
                'vp.madheshi_seats',
                'vp.dalit_seats',
                'vp.apanga_seats',
                'vp.remote_seats',
                'ad.ad_title_en as ad_title_en',
                'ad.ad_title_np as ad_title_np',
                'va.designation_id',
                'd.name_en as designation_name_en',
                'd.name_np as designation_name_np',
                'va.vacancy_post_id',
                'l.code as level_code',
                'va.amount_for_job as fee',
                'va.amount_for_priv_grp as privilege_fee',
                'va.total_amount as total',
                'va.token_number',
                'va.applied_date_ad',
                'va.applied_date_bs',
                'ad.last_date_for_application_bs as last_date_bs',
                'ad.last_date_for_application_ad as last_date_ad',
                'ad.vacancy_extended_date_bs as last_ext_date_bs',
                'ad.vacancy_extended_date_ad as last_ext_date_ad',
                'ad.opening_type_id as opening_type_id'

            )
            ->join('vacancy_post as vp', 'va.vacancy_post_id', '=', 'vp.id')
            ->leftJoin('vacancy_ad as ad', 'ad.id', '=', 'vp.vacancy_ad_id')
            ->leftJoin('mst_designation as d', 'd.id', '=', 'vp.designation_id')
            ->leftJoin('mst_work_level as l', 'l.id', '=', 'd.work_level_id')
        // ->where([['va.id', '=', $application_id],['va.is_cancelled','=',0]])
            ->where('va.id', '=', $application_id)
            ->where('va.fiscal_year_id',Session::get('fiscal_year_id'))

            ->first();
    }

    public function take_applicant_snapshot($id)
    {
        // $applicant_id =Session::get('applicant_id');

        $application_data = $this->getAppliedVacancy($id);

        //dd($application_data);

        if (Session::get("is_applicant") != 1) {
            $application_data = $this->getAppliedVacancy($id);
            $applicant_id = $application_data->applicant_id;
        } else {
            $applicant_id = Session::get('applicant_id');
            $applicant_id = Hashids::decode($applicant_id)[0];
        }

        // dd($applicant_id, $id);

        //cloning profile
        #get applied_applicant profile data
        DB::table('applied_applicant_profile')->where([['user_id', '=', $applicant_id], ['vacancy_apply_id', '=', $id]])->delete();
        try {
            $app_profile_id = DB::table('applied_applicant_profile')->insertGetId(['vacancy_apply_id' => $id]);

            $profile = DB::table('applicant_profile')->where('id', $applicant_id)->first();

            // dd($profile,$app_profile_id);

            foreach ($profile as $key => $item) {
                $value = $item;
                $keys = $key;
                if ($key != 'id') {
                    DB::table('applied_applicant_profile')
                        ->where('id', $app_profile_id)
                        ->update([$key => $item]);
                }
            }

        } catch (Exception $e) {
            return false;
        }

        //cloning family info
        DB::table('applied_applicant_family_info')->where([['applicant_id', '=', $applicant_id], ['vacancy_apply_id', '=', $id]])->delete();
        try {
            $family = DB::table('applicant_family_info')->where('applicant_id', $applicant_id)->first();
            if ($family) {
                $family_id = DB::table('applied_applicant_family_info')->insertGetId(['vacancy_apply_id' => $id, 'applicant_id' => $applicant_id]);
               // dd($family_id);
                foreach ($family as $key => $item) {
                    $value = $item;
                    $keys = $key;
                    if ($key != 'id') {
                        DB::table('applied_applicant_family_info')
                            ->where('id', $family_id)
                            ->update([$key => $item]);
                    }
                }
            }

        } catch (Exception $e) {
            return false;
        }
        //cloning education info
        DB::table('applied_applicant_edu_info')->where([['applicant_id', $applicant_id], ['vacancy_apply_id', $id]])->delete();
        try {
            $education = DB::table('applicant_edu_info')->where('applicant_id', $applicant_id)->get();
            //dd($education);
            if ($education) {
                $count = DB::table('applicant_edu_info')->where('applicant_id', $applicant_id)->count();
                for ($i = 0; $i < $count; $i++) {
                    $edu = $education[$i];
                    $edu_level_id = $edu->edu_level_id;
                    $edu_degree_id = $edu->edu_degree_id;
                    $edu_id = DB::table('applied_applicant_edu_info')->insertGetId(['vacancy_apply_id' => $id, 'applicant_id' => $applicant_id, 'edu_level_id' => $edu_level_id, 'edu_degree_id' => $edu_degree_id]);

                    foreach ($edu as $key => $item) {
                        $value = $item;
                        $keys = $key;
                        if ($key != 'id') {
                            DB::table('applied_applicant_edu_info')
                                ->where('id', $edu_id)
                                ->update([$key => $item]);
                        }
                    }
                }
            }

        } catch (Exception $e) {
            return false;
        }

        // //cloning experience info
        $experience = DB::table('applicant_exp_info')->where('applicant_id', $applicant_id)->get();
        try{

        if ($experience) {
            DB::table('applied_applicant_exp_info')->where([['applicant_id', '=', $applicant_id], ['vacancy_apply_id', '=', $id]])->delete();
            $count = DB::table('applicant_exp_info')->where('applicant_id', $applicant_id)->count();
            for ($i = 0; $i < $count; $i++) {
                $exp = $experience[$i];
                $exp_id = DB::table('applied_applicant_exp_info')->insertGetId(['vacancy_apply_id' => $id, 'applicant_id' => $applicant_id]);
                foreach ($exp as $key => $item) {
                    $value = $item;
                    $keys = $key;
                    if ($key != 'id') {
                        DB::table('applied_applicant_exp_info')
                            ->where('id', $exp_id)
                            ->update([$key => $item]);
                    }
                }
            }
        }
                } catch (Exception $e) {
            return false;
        }

        // //cloning council certificate

     try{
        $council = DB::table('applicant_council_certificate')->where('applicant_id', $applicant_id)->get();
 
        if ($council) {
            DB::table('applied_applicant_council_certificate')->where([['applicant_id', $applicant_id], ['vacancy_apply_id', $id]])->delete();
            $count = DB::table('applicant_council_certificate')->where('applicant_id', $applicant_id)->count();
            for ($i = 0; $i < $count; $i++) {
                $cert = $council[$i];
                $council_id = $cert->council_id;
                $registration_type = $cert->registration_type;
                $council_id = DB::table('applied_applicant_council_certificate')->insertGetId(['vacancy_apply_id' => $id, 'applicant_id' => $applicant_id, 'council_id' => $council_id, 'registration_type' => $registration_type]);
                foreach ($cert as $key => $item) {
                    $value = $item;
                    $keys = $key;
                    if ($key != 'id') {
                        DB::table('applied_applicant_council_certificate')
                            ->where('id', $council_id)
                            ->update([$key => $item]);
                    }
                }
            }
        }
         } catch (Exception $e) {
            return false;
        }

        // //cloning priv_grp certificate

    try{
        $priv_grp = DB::table('applicant_privilege_certificate')->where('applicant_id', $applicant_id)->get();
        if ($priv_grp) {
            DB::table('applied_applicant_privilege_certificate')->where([['applicant_id', $applicant_id], ['vacancy_apply_id', $id]])->delete();
            $count = DB::table('applicant_privilege_certificate')->where('applicant_id', $applicant_id)->count();
            for ($i = 0; $i < $count; $i++) {
                $priv_cert = $priv_grp[$i];
                $privilege_group_id = $priv_cert->privilege_group_id;
                $priv_grp_id = DB::table('applied_applicant_privilege_certificate')->insertGetId(['vacancy_apply_id' => $id, 'applicant_id' => $applicant_id, 'privilege_group_id' => $privilege_group_id]);
                foreach ($priv_cert as $key => $item) {
                    $value = $item;
                    $keys = $key;
                    if ($key != 'id') {
                        DB::table('applied_applicant_privilege_certificate')
                            ->where('id', $priv_grp_id)
                            ->update([$key => $item]);
                    }
                }
            }
        }
         } catch (Exception $e) {
            return false;
        }
        // // //cloning service history

try{
        $service_history = DB::table('applicant_service_history')->where('applicant_id', $applicant_id)->get();
        if ($service_history) {
            DB::table('applied_applicant_service_history')->where([['applicant_id', '=', $applicant_id], ['vacancy_apply_id', '=', $id]])->delete();
            $count = DB::table('applicant_service_history')->where('applicant_id', $applicant_id)->count();
            for ($i = 0; $i < $count; $i++) {
                $service = $service_history[$i];
                $serv_hist_id = DB::table('applied_applicant_service_history')->insertGetId(['vacancy_apply_id' => $id, 'applicant_id' => $applicant_id]);
                foreach ($service as $key => $item) {
                    $value = $item;
                    $keys = $key;
                    if ($key != 'id') {
                        DB::table('applied_applicant_service_history')
                            ->where('id', $serv_hist_id)
                            ->update([$key => $item]);
                    }
                }
            }
        }
         } catch (Exception $e) {
            return false;
        }



    }

    public function hook_after_add($id)
    {

        //dd($id);

        //update token number
        DB::table('vacancy_apply')
            ->where('id', $id)
            ->where('vacancy_apply.fiscal_year_id',Session::get('fiscal_year_id'))
            ->update(['token_number' => $id]);

        $success = '';
        // Start transaction!
        DB::beginTransaction();
        try {
            $this->take_applicant_snapshot($id);
            DB::commit();
            $success = true;
        } catch (Exception $e) {
            $success = false;
            DB::rollback();
        }

        $application_data = $this->getAppliedVacancy($id);
        $encoded_applicant_id = Session::get('applicant_id');
        $applicant_id = Hashids::decode($encoded_applicant_id);
        $applicant_id = $applicant_id[0];
        $applicant = CRUDBooster::first('applicant_profile', $applicant_id);
        $data = collect($application_data);
        $data = $data->merge($applicant)->all();

        if ($application_data->opening_type_id == 1) {
            \App\Helpers\VAARS::sendEmail(['to' => $applicant->email, 'data' => $data, 'template' => 'email_after_job_apply']);
            $log_file = \App\Helpers\VAARS::logSendEmail($applicant->user_id, "vacancy_apply", ['to' => $applicant->email, 'data' => $data, 'template' => 'email_after_job_apply']);
        }
        if ($application_data->opening_type_id == 2) {
            \App\Helpers\VAARS::sendEmail(['to' => $applicant->email, 'data' => $data, 'template' => 'email_after_job_apply_internal']);
            $log_file = \App\Helpers\VAARS::logSendEmail($applicant->user_id, "vacancy_apply", ['to' => $applicant->email, 'data' => $data, 'template' => 'email_after_job_apply_internal']);
        }
        if ($application_data->opening_type_id == 3) {
            \App\Helpers\VAARS::sendEmail(['to' => $applicant->email, 'data' => $data, 'template' => 'email_after_job_apply_file_pormotion']);
            $log_file = \App\Helpers\VAARS::logSendEmail($applicant->user_id, "vacancy_apply", ['to' => $applicant->email, 'data' => $data, 'template' => 'email_after_job_apply_file_pormotion']);
        }

        //update log
        DB::table('vacancy_apply')
            ->where('id', $id)
             ->where('vacancy_apply.fiscal_year_id',Session::get('fiscal_year_id'))
            ->update(['apply_email_log_path' => $log_file]);
        $this->return_url = CRUDBooster::mainpath() . "/detail/" . $id;
    }

    /*
    | ----------------------------------------------------------------------
    | Hook for manipulate data input before update data is execute
    | ----------------------------------------------------------------------
    | @postdata = input post data
    | @id       = current id
    |
     */
    public function hook_before_edit(&$postdata, $id)
    {

        //Your code here
    }

    /*
    | ----------------------------------------------------------------------
    | Hook for execute command after edit public static function called
    | ----------------------------------------------------------------------
    | @id       = current id
    |
     */
    public function hook_after_edit($id)
    {
        //Your code here
        $application_data = $this->getAppliedVacancy($id);
        if (Session::get("is_applicant") != 1) {
            $application_data = $this->getAppliedVacancy($id);
            $applicant_id = $application_data->applicant_id;
        } else {
            $applicant_id = Session::get('applicant_id');
            $applicant_id = Hashids::decode($applicant_id)[0];
        }

        // Start transaction!
        DB::beginTransaction();
        try {
            $this->take_applicant_snapshot($id);
            DB::commit();
            $success = true;
        } catch (Exception $e) {
            $success = false;
            DB::rollback();
        }

        $applicant = CRUDBooster::first('applicant_profile', $applicant_id);
        $data = collect($application_data);
        $data = $data->merge($applicant)->all();

        if ($application_data->opening_type_id == 1) {
            \App\Helpers\VAARS::sendEmail(['to' => $applicant->email, 'data' => $data, 'template' => 'email_after_job_apply']);
            $log_file = \App\Helpers\VAARS::logSendEmail($applicant->user_id, "vacancy_apply", ['to' => $applicant->email, 'data' => $data, 'template' => 'email_after_job_apply']);
        }
        if ($application_data->opening_type_id == 2) {
            \App\Helpers\VAARS::sendEmail(['to' => $applicant->email, 'data' => $data, 'template' => 'email_after_job_apply_internal']);
            $log_file = \App\Helpers\VAARS::logSendEmail($applicant->user_id, "vacancy_apply", ['to' => $applicant->email, 'data' => $data, 'template' => 'email_after_job_apply_internal']);
        }
        if ($application_data->opening_type_id == 3) {
            \App\Helpers\VAARS::sendEmail(['to' => $applicant->email, 'data' => $data, 'template' => 'email_after_job_apply_file_pormotion']);
            $log_file = \App\Helpers\VAARS::logSendEmail($applicant->user_id, "vacancy_apply", ['to' => $applicant->email, 'data' => $data, 'template' => 'email_after_job_apply_file_pormotion']);
        }
        DB::table('vacancy_apply')
            ->where('id', $id)
            ->update(['apply_email_log_path' => $log_file]);
        $this->return_url = CRUDBooster::mainpath() . "/detail/" . $id;

        CRUDBooster::redirect(CRUDBooster::adminPath() . '/vacancy_applicants', trans("crudbooster.alert_update_data_success"), 'success');
    }

    /*
    | ----------------------------------------------------------------------
    | Hook for execute command before delete public static function called
    | ----------------------------------------------------------------------
    | @id       = current id
    |
     */
    public function hook_before_delete($id)
    {
        //Your code here
    }

    /*
    | ----------------------------------------------------------------------
    | Hook for execute command after delete public static function called
    | ----------------------------------------------------------------------
    | @id       = current id
    |
     */
    public function hook_after_delete($id)
    {
        //Your code here
    }
    private function checkApplicantInvalidAccess($id)
    {
        // dd($id);
        if (Session::get("is_applicant") == 1) {
            $this->cbLoader();
            if ($this->profile_module) {
                if (Session::get("applicant_id") != $id) {
                    $id = Session::get("applicant_id");
                }
            } else {
                $data = DB::table($this->table)
                    ->where("id", $id)
                    ->select("applicant_id")->first();
                if (isset($data) && isset($data->applicant_id)) {
                    if ($data->applicant_id != Session::get("applicant_id")) {
                        return CRUDBooster::redirect(CRUDBooster::mainpath('?applicant_id=' . Session::get("applicant_id")), "Sorry you do not have privilege to ACCESS other Applicant Data.");
                    }
                } else {
                    return CRUDBooster::redirect(CRUDBooster::mainpath('?applicant_id=' . Session::get("applicant_id")), "Sorry you do not have privilege to ACCESS other Applicant Data.");
                }
            }
        }
        return $id;
    }
    public function getDetail($id)
    {
        return $this->getView($id);
    }
    public function postEditSave($id)
    {

        $data = $this->getApplicationDetail($id);
        $isApplicant = false;

        if (Session::get('is_applicant') == 1) {
            $data['isApplicant'] = true;
            -$isApplicant = true;
        }
        $encoded_applicant_id = Session::get('applicant_id');
        $applicant_id = Hashids::decode($encoded_applicant_id);
        $applicant_id = $applicant_id[0];
        if ($isApplicant) {
            $desc = "Access route " . $_SERVER[HTTP_HOST] . $_SERVER[REQUEST_URI] . " with applicant_id " . $applicant_id;
        } else {
            $desc = "Access route " . $_SERVER[HTTP_HOST] . $_SERVER[REQUEST_URI] . " with user_id " . CRUDBooster::myId();
        }

        parent::insert_log($desc, $id, 'vacancy_apply');
        $data['page_title'] = 'Application Edit';

        if (Session::get("is_applicant")) {
            return CRUDBooster::redirect(CRUDBooster::mainpath('edit/' . $id), trans('crudbooster.denied_access'));
        }
        return parent::postEditSave($id);
    }

    public function postReapplySave($id)
    {
        $data = $this->getApplicationDetail($id);
        $data['page_title'] = 'Application Edit';
        return parent::postReapplySave($id);
    }

    public function getDelete($id)
    {
        if (Session::get("is_applicant")) {
            return CRUDBooster::redirect(CRUDBooster::mainpath('?applicant_id=' . Session::get("applicant_id")), trans('crudbooster.denied_access'));
        }
        return parent::getDelete($id);
    }

    public function getIndex()
    {
        $this->cbLoader();
        $this->table = "vw_vacancy_applicant";
        $this->alias = "vw_vacancy_applicant";

        $parameters = \Request::segment(3);
        Session::put('opening_type', $parameters);

        return parent::getIndex();
    }
    //By the way, you can still create your own method in here... :)

    public function hook_after_reapply($id)
    {
        //Your code here
        $application_data = $this->getAppliedVacancy($id);
        if (Session::get("is_applicant") != 1) {
            $application_data = $this->getAppliedVacancy($id);
            $applicant_id = $application_data->applicant_id;
        } else {
            $applicant_id = Session::get("applicant_id");
        }

        // Start transaction!
        DB::beginTransaction();
        try {
            $this->take_applicant_snapshot($id);
            DB::commit();
            $success = true;
        } catch (Exception $e) {
            $success = false;
            DB::rollback();
        }
        $applicant = CRUDBooster::first('applicant_profile', $applicant_id);
        $data = collect($application_data);
        $data = $data->merge($applicant)->all();

        // Reset cancel fields in table
        $is_cancelled = 0;
        DB::table('vacancy_apply')
            ->where('id', $id)
            ->update(['is_cancelled' => $is_cancelled, 'cancel_reason' => null, 'cancelled_date_ad' => null, 'cancelled_date_bs' => null, 'cancelled_by' => null]);

        if ($application_data->opening_type_id == 1) {
            \App\Helpers\VAARS::sendEmail(['to' => $applicant->email, 'data' => $data, 'template' => 'email_after_job_apply']);
            $log_file = \App\Helpers\VAARS::logSendEmail($applicant->user_id, "vacancy_apply", ['to' => $applicant->email, 'data' => $data, 'template' => 'email_after_job_apply']);
        }
        if ($application_data->opening_type_id == 2) {
            \App\Helpers\VAARS::sendEmail(['to' => $applicant->email, 'data' => $data, 'template' => 'email_after_job_apply_internal']);
            $log_file = \App\Helpers\VAARS::logSendEmail($applicant->user_id, "vacancy_apply", ['to' => $applicant->email, 'data' => $data, 'template' => 'email_after_job_apply_internal']);
        }
        if ($application_data->opening_type_id == 3) {
            \App\Helpers\VAARS::sendEmail(['to' => $applicant->email, 'data' => $data, 'template' => 'email_after_job_apply_file_pormotion']);
            $log_file = \App\Helpers\VAARS::logSendEmail($applicant->user_id, "vacancy_apply", ['to' => $applicant->email, 'data' => $data, 'template' => 'email_after_job_apply_file_pormotion']);
        }
        DB::table('vacancy_apply')
            ->where('id', $id)
            ->update(['apply_email_log_path' => $log_file]);
        $this->return_url = CRUDBooster::mainpath() . "/detail/" . $id;

        CRUDBooster::redirect(CRUDBooster::mainpath(), trans("Vacancy reapply successful."), 'success');
    }
}
