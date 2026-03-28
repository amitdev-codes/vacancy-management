<?php
namespace App\Http\Controllers;

use CRUDBooster;
use DB;
use Request;
use Session;
use Vinkla\Hashids\Facades\Hashids;

class AdminApplicantProfileController extends ApplicantCBController
{
    public $profile_module = true;
    public function cbInit()
    {
        // $this->primary_key        = 'user_id';
        # START CONFIGURATION DO NOT REMOVE THIS LINE
        $this->title_field = "first_name_en";
        $this->limit = "20";
        $this->orderby = "user_id,desc";
        $this->global_privilege = false;
        $this->button_table_action = true;
        $this->button_bulk_action = true;
        $this->button_action_style = "button_icon";
        $this->button_add = false;
        $this->button_edit = true;
        $this->button_delete = true;
        $this->button_detail = true;
        $this->button_show = true;
        $this->button_filter = true;
        $this->button_import = false;
        $this->button_export = false;
        $this->table = "applicant_profile";
       // $this->getIndex_view = "default.applicant_form";
        // $this->getIndex_view ="default.index";

        //    "default.index";
        $this->getEdit_view = "default.applicant_form";
        # END CONFIGURATION DO NOT REMOVE THIS LINE

        # START COLUMNS DO NOT REMOVE THIS LINE
        $this->col = [];
        // $this->col[] = ["label"=>"Full Name","name"=>"trim(concat(first_name_en, ' ', COALESCE(mid_name_en,''), ' ', last_name_en)) as full_name_en"];
        // $this->col[] = ["label"=>"नाम","name"=>"trim(concat(first_name_np, ' ', COALESCE(mid_name_np,''), ' ', last_name_np)) as full_name_np"];
        $this->col[] = ["label" => "Applicant ID", "name" => "id"];

        $this->col[] = ["label" => "Full Name", "name" => "trim(concat(upper(first_name_en), ' ', COALESCE(upper(mid_name_en),''), ' ', upper(last_name_en),'<br/>',first_name_np, ' ', COALESCE(mid_name_np,''), ' ', last_name_np)) as first_name_en"];
        $this->col[] = ["label" => "Gender", "name" => "gender_id", "join" => "mst_gender,name_en"];
        // $this->col[] = ["label"=>"DOB (B.S.)","name"=>"dob_bs"];
        // $this->col[] = ["label"=>"DOB (A.D.)","name"=>"dob_ad"];
        $this->col[] = ["label" => "DOB", "name" => "trim(concat(dob_ad,' A.D.</br>', dob_bs,' B.S.')) as dob_ad"];
        $this->col[] = ["label" => "Mobile No.", "name" => "mobile_no"];
        $this->col[] = ["label" => "Email", "name" => "email"];
        // $this->col[] = ["label"=>"NT Staff","name"=>"COALESCE(is_nt_staff,0) as is_nt_staff"];
        $this->col[] = ["label" => "NT Staff", "name" => "case when is_nt_staff = 1 then 'YES' ELSE 'NO' END as is_nt_staff"];

        $this->col[] = ["label" => "Photo", "name" => "photo", "image" => true];
        // $this->col[] = array("label"=>"Photo","name"=>"photo","image"=>0);
        # END COLUMNS DO NOT REMOVE THIS LINE

        # START FORM DO NOT REMOVE THIS LINE
        $this->form = [];
        $this->form[] = ['label' => 'नाम', 'name' => 'first_name_np', 'placeholder' => 'नाम', 'type' => 'text-c', 'validation' => 'required|max:255', 'cmp-ratio' => '4:4:12'];
        $this->form[] = ['label' => 'बीचको नाम', 'name' => 'mid_name_np', 'type' => 'text-c', 'placeholder' => 'बीचको नाम', 'validation' => 'max:255', 'cmp-ratio' => '4:4:12'];
        $this->form[] = ['label' => 'थर', 'name' => 'last_name_np', 'type' => 'text-c', 'placeholder' => 'थर', 'validation' => 'required|max:255', 'cmp-ratio' => '4:4:12'];

        $this->form[] = ['label' => 'First Name', 'name' => 'first_name_en', 'placeholder' => 'First', 'type' => 'text-c', 'validation' => 'required|max:255', 'cmp-ratio' => '4:4:12'];
        $this->form[] = ['label' => 'Middle Name', 'name' => 'mid_name_en', 'type' => 'text-c', 'placeholder' => 'Middle', 'validation' => 'max:255', 'cmp-ratio' => '4:4:12'];
        $this->form[] = ['label' => 'Last Name', 'name' => 'last_name_en', 'type' => 'text-c', 'placeholder' => 'Last', 'validation' => 'required|max:255', 'cmp-ratio' => '4:4:12'];

        $this->form[] = ['label' => 'जन्म मिति', 'name' => 'dob_bs', 'type' => 'date-n', 'placeholder' => 'बि.स.', 'validation' => 'required|max:255', 'cmp-ratio' => '4:6:12'];
        $this->form[] = ['label' => 'Date of Birth', 'name' => 'dob_ad', 'placeholder' => 'A.D.', 'type' => 'date-c', 'validation' => 'date', 'cmp-ratio' => '4:6:12'];
        $this->form[] = ['label' => 'Gender/लिंग', 'name' => 'gender_id', 'type' => 'select2-c', 'validation' => 'required|max:255', 'cmp-ratio' => '4:6:12', 'datatable' => 'mst_gender,name_en'];

        $this->form[] = ['label' => 'धर्म/Religion', 'name' => 'religion_id', 'type' => 'select2-c', 'validation' => 'required|max:255', 'cmp-ratio' => '4:12:12', 'datatable' => 'mst_religion,name_en'];
        $this->form[] = ['label' => 'मातृभाषा/Mothertongue', 'name' => 'mothertongue_id', 'type' => 'select2-c', 'validation' => 'required|max:255', 'cmp-ratio' => '4:12:12', 'datatable' => 'mst_mothertongue,name_en'];
        $this->form[] = ['label' => 'वर्ण/Complexion', 'name' => 'complexion', 'type' => 'text-c', 'validation' => 'max:255', 'cmp-ratio' => '4:12:12'];
        // $this->form[] = ['label'=>'Privilege Group','name'=>'privilege_group_id','type'=>'select2-c','validation'=>'required|max:255','cmp-ratio'=>'11:10:3','datatable'=>'mst_privilege_group,name_en'];
        $this->form[] = ['label' => 'जिल्ला', 'name' => 'district_id', 'type' => 'select2-c', 'validation' => 'required|max:255', 'cmp-ratio' => '3:12:12', 'datatable' => 'mst_district,name_en'];
        // $this->form[] = ['label'=>'न.पा./ग.पा.','name'=>'local_level_id','type'=>'select-c','validation'=>'required','cmp-ratio'=>'3:12:12','datatable'=>'mst_local_level,name_en','parent_select'=>'district_id'];
        // $this->form[] = ['label'=>'वडा/Ward','name'=>'ward_no','type'=>'number-c','validation'=>'required|integer','cmp-ratio'=>'2:12:12'];
        $this->form[] = ['label' => 'न.पा./ग.पा.', 'name' => 'local_level_id', 'type' => 'select-c', 'validation' => 'required', 'cmp-ratio' => '3:12:12', 'datatable' => 'mst_local_level,name_en', 'parent_select' => 'district_id'];
        $this->form[] = ['label' => 'वडा/Ward', 'name' => 'ward_no', 'type' => 'number-c', 'validation' => 'required|numeric|min:1|max:40', 'cmp-ratio' => '2:12:12'];
        $this->form[] = ['label' => 'टोल/Tole Name', 'name' => 'tole_name', 'type' => 'text-c', 'validation' => 'max:255', 'cmp-ratio' => '4:12:12'];

        $this->form[] = ['label' => 'जिल्ला', 'name' => 'temp_district_id', 'type' => 'select2-c', 'validation' => 'max:255', 'cmp-ratio' => '3:12:12', 'datatable' => 'mst_district,name_en'];
        $this->form[] = ['label' => 'न.पा./ग.पा.', 'name' => 'temp_local_level_id', 'type' => 'select-c', 'validation' => 'max:255', 'cmp-ratio' => '3:12:12', 'datatable' => 'vw_local_level,name_en', 'parent_select' => 'temp_district_id'];
        $this->form[] = ['label' => 'वडा/Ward', 'name' => 'temp_ward_no', 'type' => 'number-c', 'validation' => 'numeric|min:1', 'cmp-ratio' => '2:12:12'];
        $this->form[] = ['label' => 'टोल/Tole Name', 'name' => 'temp_tole_name', 'type' => 'text-c', 'validation' => 'max:255', 'cmp-ratio' => '4:12:12'];

        $this->form[] = ['label' => 'Phone No', 'name' => 'phone_no', 'type' => 'text-c', 'validation' => 'max:255', 'cmp-ratio' => '3:6:12'];
        if(CRUDBooster::myPrivilegeId()==1||CRUDBooster::myPrivilegeId()==5){
            $this->form[] = ['label' => 'Mobile No', 'name' => 'mobile_no', 'type' => 'text-c', 'validation' => 'required|max:255', 'cmp-ratio' => '3:6:12'];
            $this->form[] = ['label' => 'Email', 'name' => 'email', 'type' => 'email-c', 'validation' => 'required|max:255|email', 'cmp-ratio' => '6:12:12', 'placeholder' => 'Please enter a valid email address'];
        }else{
            $this->form[] = ['label' => 'Mobile No', 'name' => 'mobile_no', 'type' => 'text-c', 'validation' => 'required|max:255', 'cmp-ratio' => '3:6:12', 'readonly' => true];
            $this->form[] = ['label' => 'Email', 'name' => 'email', 'type' => 'email-c', 'validation' => 'required|max:255|email', 'cmp-ratio' => '6:12:12', 'placeholder' => 'Please enter a valid email address', 'readonly' => true];
        }



        $this->form[] = ['label' => 'नागरिकता नं', 'name' => 'citizenship_no', 'type' => 'text-c', 'validation' => 'required|max:255', 'cmp-ratio' => '3:12:12'];
        $this->form[] = ['label' => 'नागरिकता जारी जिल्ला', 'name' => 'citizenship_issued_from', 'type' => 'select2-c', 'required|validation' => 'required|max:255', 'cmp-ratio' => '3:12:12', 'datatable' => 'mst_district,name_en'];
        $this->form[] = ['label' => 'नागरिकता जारी मिति', 'placeholder' => 'बि.स.', 'name' => 'citizenship_issued_date_bs', 'type' => 'date-n', 'validation' => 'required|max:255',  'cmp-ratio' => '3:12:12'];
        $this->form[] = ['label' => 'Citizenship Issued Date', 'placeholder' => 'A.D.', 'name' => 'citizenship_issued_date_ad', 'type' => 'date-c','validation' => 'required|max:255',  'cmp-ratio' => '3:12:12'];

        $this->form[] = ['label' => '', 'name' => 'is_nt_staff', 'type' => 'radio-c', 'class' => 'is_nt_staff', 'cmp-ratio' => '2:12:10', 'dataenum' => '1|हो ; 0|होइन'];
        $this->form[] = ['label' => '', 'name' => 'nt_staff_code', 'type' => 'text-c', 'cmp-ratio' => '4:12:10', 'class' => 'staffCode', 'placeholder' => 'NT Staff Code', 'validation' => ''];

        $this->form[] = ['label' => '', 'name' => 'is_handicapped', 'type' => 'radio-c', 'class' => 'is_handicapped', 'cmp-ratio' => '2:12:10', 'dataenum' => '1|हो ; 0|होइन'];
        //$this->form[] = ['label' => '', 'name' => 'nt_staff_code', 'type' => 'text-c', 'cmp-ratio' => '4:12:10', 'class' => 'staffCode', 'placeholder' => 'NT Staff Code', 'validation' => ''];

        $this->form[] = ['label' => 'Photo', 'name' => 'photo', 'type' => 'upload-c', 'validation' => 'required|image|max:200', 'cmp-ratio' => '4:12:12', 'help' => 'File type: JPG, JPEG, PNG, GIF, BMP', 'upload_encrypt' => 'true'];
        $this->form[] = ['label' => 'दस्तखत / Signature', 'name' => 'signature_upload', 'type' => 'upload-c', 'validation' => 'required|image|max:200', 'cmp-ratio' => '4:12:12', 'help' => 'File type: JPG, JPEG, PNG, GIF, BMP', 'upload_encrypt' => 'true'];
        $this->form[] = ['label' => 'नागरिकता', 'name' => 'citizenship_upload', 'type' => 'upload-c', 'validation' => 'required|image|max:200', 'cmp-ratio' => '4:12:12', 'help' => 'File type: JPG, JPEG, PNG, GIF, BMP', 'upload_encrypt' => 'true'];

        /*
        | ----------------------------------------------------------------------
        | Sub Module
        | ----------------------------------------------------------------------
        | @label          = Label of action
        | @path           = Path of sub module
        | @foreign_key       = foreign key of sub table/module
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
        | @color        = Default is primary. (primary, warning, succecss, info)
        | @showIf        = If condition when action show. Use field alias. e.g : [id] == 1
        |
         */
        $this->addaction = array();

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
        //$this->table_row_color[] = ["condition"=>"[id] == 'select applicant_id from vacancy_apply where applicant_id =[id] limit 1'","color"=>"success"];
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
        // $this->script_js = null;
        // $this->script_js[] = asset("js/validation/checkage.js");
        // ";

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
        //  $this->load_js = array();
        $this->load_js[] = asset("js/applicant.js");
        $this->load_js[] = asset("js/validation/checkage.js");
        // $this->load_js[] = asset("js/applicant.js");
        //   $this->load_js[] = asset("js/applicant_profile.js");
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

    // public function getEdit($id){
    //     if(Session::get("is_applicant") ==1){
    //         return parent::getEdit(Session::get("applicant_id"));
    //     }
    //     else{
    //         return parent::getEdit($id);
    //     }
    // }

    /*
    | ----------------------------------------------------------------------
    | Hook for button selected
    | ----------------------------------------------------------------------
    | @id_selected = the id selected
    | @button_name = the name of button
    |
     */
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
        if (CRUDBooster::myPrivilegeId() == 5) {
            $query->where('first_name_en', '<>', null);
        } else {
            parent::hook_query_index($query);
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
        //find which the column you want to override, let say status column position number 3
        if ($column_index == 2) {
            try {
                $app = DB::table('vacancy_apply')
                    ->where('applicant_id', $column_value)
                    ->first();
                if ($app == null) {
                    $column_value = "<span class='label label-warning'>" . $column_value . "</span>";
                } else {
                    $column_value = "<span class='label label-success'>" . $column_value . "</span>";
                }
            } catch (\Exception $e) {
                $column_value = "<span class='label label-warning'>" . $column_value . "</span>";
            }
        } //endif
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
        if ($postdata['is_nt_staff'] == '1' && !isset($postdata['nt_staff_code'])) {
            CRUDBooster::redirect(CRUDBooster::mainpath('edit/' . Session::get("applicant_id")), trans('Please be sure you add nt staff code before saving with is_nt_staff true'), 'warning');
        }
        //Your code here
    }

    /*
    | ----------------------------------------------------------------------
    | Hook for execute command after add public static function called
    | ----------------------------------------------------------------------
    | @id = last insert id
    |
     */
    public function hook_after_add($id)
    {

        //Your code here
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
     
        if ($postdata['is_nt_staff'] == '1' && !isset($postdata['nt_staff_code'])) {
            CRUDBooster::redirect(CRUDBooster::mainpath('edit/' . Session::get("applicant_id")), trans('Please make sure you have added your NT Code.'), 'warning');
        }
        //Your code here
        // $alreadyApplied=DB::table("vacancy_apply")
        // ->select('id')
        // ->where([['id',$id],['is_cancelled',0]])
        // ->get();

        // if($alreadyApplied){
        //      CRUDBooster::redirect(CRUDBooster::mainpath('edit/' . Session::get("applicant_id")), trans('Sorry, you can not change your profile after you have applied for vacancy!'), 'warning');
        // }
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
    // public function getIndex() {

    //     if(Session::get("is_applicant")){
    //         return CRUDBooster::redirect(CRUDBooster::mainpath('edit/'.Session::get("applicant_id")), "Sorry you do not have privilege to access Applicant Profile List !
    //         ");
    //     }
    //     return parent::getIndex();

    // }
    public function getEdit($id)
    {

        if (Session::get("is_applicant")) {
            if (Session::get("applicant_id") != $id) {
                $id = Session::get("applicant_id");
            }
            return parent::getEditEncoded($id);
        } else {
            return parent::getEdit($id);
        }
    }

    public function getIndex()
    {
        if (Session::get("is_applicant")) {
            return CRUDBooster::redirect(CRUDBooster::mainpath('edit/' . Session::get("applicant_id")), "Sorry you do not have privilege to access Applicant Profile List !
            ");
        }

        return parent::getIndex();
    }

    public function getView($id)
    {
        if (
            Session::get("is_applicant")
            && Session::get("applicant_id") != $id
        ) {
            $session_id = Session::get("applicant_id");
            $id = Hashids::decode($session_id)[0];
        }
        return parent::getView($id);
    }

//    public function getsearch()
//    {
//
//        $text = Request::get('q');
//
//        $names = explode(" ", $text);
//        //dd($names);
//
//        $data1 = DB::table('applicant_profile as ap')
//            ->select(
//                'ap.id',
//                'ap.user_id as user_id',
//                'ap.mobile_no as mobile_no',
//                'ap.email as email',
//                'gd.name_en as gender_id',
//                'ap.dob_ad',
//                'ap.dob_bs',
//                'ap.is_nt_staff',
//                'ap.photo',
//                DB::raw("CONCAT_WS(' ',ap.first_name_en,'',ap.mid_name_en,'',ap.last_name_en) AS first_name_en"),
//                DB::raw("CONCAT_WS(' ',ap.first_name_np,'',ap.mid_name_np,'',ap.last_name_np) AS first_name_np")
//            )
//
//        // DB::raw("CONCAT_WS(' ',ap.dob_ad,'/',ap.dob_bs) AS dob_ad"))
//
//            ->leftjoin('mst_gender as gd', 'gd.id', '=', 'ap.gender_id')
//
//            ->where('first_name_en', '=', $names)
//            ->orwhere('mid_name_en', '=', $names)
//            ->orwhere('last_name_en', '=', $names)
//            ->orwhere('ap.user_id', 'LIKE', '%' . $text . '%')
//            ->orWhere('gd.name_en', 'LIKE', '%' . $text . '%')
//            ->orWhere('dob_ad', 'LIKE', '%' . $text . '%')
//            ->orWhere('mobile_no', 'LIKE', '%' . $text . '%')
//            ->orWhere('email', 'LIKE', '%' . $text . '%')
//            ->orWhere('is_nt_staff', 'LIKE', '%' . $text . '%')
//            ->get();
//
//        return view('default.Applicant_profile.view', compact('data1'));
//    }

    public function getdetails($id)
    {

        $data1 = DB::table('applicant_profile as ap')
            ->select(
                'ap.first_name_en',
                'ap.mid_name_en',
                'ap.last_name_en',
                'ap.first_name_np',
                'ap.mid_name_np',
                'ap.last_name_np',
                'ap.dob_bs',
                'ap.dob_ad',
                'gd.name_np as gender_id',
                'rg.name_np as religion_id',
                'mt.name_np as mothertongue_id',
                'ap.complexion',
                'tdist.name_np as temp_district_id',
                'tlocal.name_np  as temp_local_level_id',
                'ap.temp_ward_no',
                'ap.temp_tole_name',
                'dist.name_np as district_id',
                'ap.local_level_id',
                'ap.ward_no',
                'ap.tole_name',
                'ap.phone_no',
                'ap.mobile_no',
                'ap.email',
                'ap.citizenship_no',
                'ap.citizenship_issued_from',
                'ap.citizenship_issued_date_ad',
                'ap.citizenship_issued_date_bs',
                'ap.signature_upload',
                'ap.citizenship_upload',
                'ap.photo'
            )
            ->leftjoin('mst_gender as gd', 'gd.id', '=', 'ap.gender_id')
            ->leftjoin('mst_religion as rg', 'rg.id', '=', 'ap.religion_id')
            ->leftjoin('mst_mothertongue as mt', 'mt.id', '=', 'ap.mothertongue_id')
            ->leftjoin('mst_district as tdist', 'tdist.id', '=', 'ap.temp_district_id')
            ->leftjoin('mst_local_level as tlocal', 'tlocal.id', '=', 'ap.temp_local_level_id')
            ->leftjoin('mst_district as dist', 'dist.id', '=', 'ap.district_id')
            ->where('user_id', '=', $id)
            ->get();
        return view('default.Applicant_profile.view', compact(data1));

        //dd($data1);
    }

    //By the way, you can still create your own method in here... :)
}
