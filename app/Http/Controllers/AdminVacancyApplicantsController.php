<?php namespace App\Http\Controllers;

use CRUDBooster;
use DB;
use Request;
use Session;
use Carbon\Carbon;

class AdminVacancyApplicantsController extends BaseCBController
{

    public function cbInit()
    {
        # START CONFIGURATION DO NOT REMOVE THIS LINE
        $this->table = "vw_vacancy_applicant";
        $this->title_field = "id";
        $this->limit = "20";
        $this->orderby = "id,desc";
        $this->show_numbering = true;
        $this->global_privilege = false;
        $this->button_table_action = true;
        $this->button_action_style = "button_icon";
        $this->button_action_width = "70px";
        $this->button_add = false;
        $this->button_delete = false;
        $this->button_edit = false;
        $this->button_detail = false;
        $this->button_show = true;
        $this->button_filter = true;
        $this->button_export = true;
        $this->button_import = false;
        $this->button_bulk_action = true;
        // $this->getIndex_view = "default.Applied_applications.index";
        $this->getIndex_view = "default.vacancy.AdwiseIndex";
        # END CONFIGURATION DO NOT REMOVE THIS LINE

        # START COLUMNS DO NOT REMOVE THIS LINE
        $this->col = array();
        $this->col[] = array("label" => "ID", "name" => "id");
        $this->col[] = array("label" => "Ad No", "name" => "ad_no");
        $this->col[] = array("label" => "Vacancy Ad", "name" => "vacancy_ad_id");

        $this->col[] = array("label" => "Designation", "name" => "designation_en");

        $this->col[] = array("label" => "Published&nbsp;/<br>Last (B.S.)", "name" => "published_date_bs", 'callback_php' => '$row->published_date_bs."<br>".$row->last_date_bs');
        $this->col[] = array("label" => "Published B.S.", "name" => "published_date_bs", "visible" => false);
        $this->col[] = array("label" => "Last B.S.", "name" => "last_date_bs", "width" => "85px", "visible" => false);
        if (Session::get("is_applicant") != 1) {
            $this->col[] = array("label" => "Applicant ID", "name" => "applicant_id");
            $this->col[] = array("label" => "Photo", "name" => "photo", "image" => "1");
            $this->col[] = array("label" => "Applicant Name", "name" => "name_en", "display" => "none");
            $this->col[] = array("label" => "Nt Staff Code", "name" => "nt_staff_code");
            $this->col[] = array("label" => "Mobile No.", "name" => "mobile_no", "display" => "none");
        }
        $this->col[] = array("label" => "Applied&nbsp;B.S.", "name" => "applied_date_bs");
        $this->col[] = array("label" => "Token&nbsp;No&nbsp;/<br>Total Fee", "name" => "token_number", 'callback_php' => '$row->token_number."&nbsp;/&nbsp;".$row->total_amount');
        $this->col[] = array("label" => "Token No.", "name" => "token_number", "width" => "75px", "visible" => false);
        $this->col[] = array("label" => "Total Fee", "name" => "total_amount", "width" => "75px", "visible" => false);
        $this->col[] = array("label" => "Receipt No", "name" => "paid_receipt_no", "width" => "75px");
        $this->col[] = array("label" => "Paid_Date&nbsp;<br>A.D.", "name" => "paid_date_ad");
        $this->col[] = array("label" => "Is paid", "name" => " case when is_paid = 1 then 'YES' ELSE '' END as is_paid", "width" => "75px");
        $this->col[] = array("label" => "O", "name" => "case when is_open = 1 then 'O' ELSE '' END as is_open", "width" => "75px");
        $this->col[] = array("label" => "F", "name" => "case when is_female = 1 then 'F' ELSE '' END as is_female", "width" => "70px");
        $this->col[] = array("label" => "J", "name" => "case when is_janajati = 1 then 'J' ELSE '' END as is_janajati", "width" => "70px");
        $this->col[] = array("label" => "M", "name" => "case when is_madhesi = 1 then 'M' ELSE '' END as is_madhesi", "width" => "70px");
        $this->col[] = array("label" => "D", "name" => "case when is_dalit = 1 then 'D' ELSE '' END as is_dalit", "width" => "70px", "visible" => false);
        $this->col[] = array("label" => "H", "name" => "case when is_handicapped = 1 then 'H' ELSE '' END as is_handicapped", "width" => "70px", "visible" => false);
        $this->col[] = array("label" => "R", "name" => "case when is_remote_village = 1 then 'R' ELSE '' END as is_remote_village", "width" => "70px", "visible" => false);
        $this->col[] = array("label" => "Applied group", "name" => "applied_group", "width" => "75px");
        $this->col[] = array("label" => "Rejected", "name" => "case when is_rejected = 1 then 'YES' ELSE 'NO' END as is_rejected");
        $this->col[] = array("label" => "Cancelled", "name" => "case when is_cancelled = 1 then 'YES' ELSE 'NO' END as is_cancelled");
        

        # END COLUMNS DO NOT REMOVE THIS LINE
        # START FORM DO NOT REMOVE THIS LINE
        $this->form = [];
        $this->form[] = ["label" => "Vacancy Post Id", "name" => "vacancy_post_id", "type" => "select2", "required" => true, "validation" => "required|integer|min:0", "datatable" => "vacancy_post,id"];
        $this->form[] = ["label" => "Applicant Id", "name" => "applicant_id", "type" => "select2", "required" => true, "validation" => "required|integer|min:0", "datatable" => "applicant,id"];
        $this->form[] = ["label" => "Designation Id", "name" => "designation_id", "type" => "select2", "required" => true, "validation" => "required|min:1|max:255", "datatable" => "designation,id"];
        $this->form[] = ["label" => "Applied Date Ad", "name" => "applied_date_ad", "type" => "date", "required" => true, "validation" => "required|date"];
        $this->form[] = ["label" => "Applied Date Bs", "name" => "applied_date_bs", "type" => "text", "required" => true, "validation" => "required|min:1|max:255"];
        $this->form[] = ["label" => "Is Female", "name" => "is_female", "type" => "radio", "required" => true, "validation" => "required|integer", "dataenum" => "0|No;1|Yes"];

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
        // $this->addaction = array();

     
    if (in_array(CRUDBooster::myPrivilegeId(), [1, 5])) {
        $this->addaction[] = ['label' => '', 'icon' => 'fa fa-ban', 'confirmation' => true, 'confirmation_text' => "Are you sure you want to reject?", "confirmation_title" => "Reject", 'color' => 'danger', 'url' => CRUDBooster::mainpath('../vacancy_rejection/edit') . '/[id]', 'showIf' => '[is_rejected] == "NO"'];
        $this->addaction[] = ['label' => '', 'icon' => 'fa fa-remove', 'confirmation' => true, 'confirmation_text' => "Are you sure you want to cancel?", "confirmation_title" => "Cancel", 'color' => 'warning', 'url' => CRUDBooster::mainpath('../vacancy_apply_cancelation/edit') . '/[id]', 'showIf' => '[is_cancelled] ==  "NO"'];
        $this->addaction[] = ['label' => '', 'icon' => 'fa fa-pencil', 'confirmation' => true, 'confirmation_text' => "Are you sure you want to edit record?", "confirmation_title" => "Edit", 'color' => 'info', 'url' => CRUDBooster::mainpath('../vacancy_apply/edit') . '/[id]', 'showIf' => '[is_cancelled] ==  "NO"'];
        $this->addaction[] = ['label' => '', 'icon' => 'fa fa-eye', 'color' => 'primary', 'url' => CRUDBooster::mainpath('../vacancy_apply/view') . '/[id]'];
    }
        $this->addaction[] = ['label' => '', 'icon' => 'fa fa-user', 'color' => 'success', 'url' => CRUDBooster::mainpath('../applicant_profile/archive') . '/[id]'.'/[applicant_id]'];

        // $this->addaction[] = ['label' => '', 'icon' => 'fa fa-refresh', 'color' => 'warning', 'url' => CRUDBooster::mainpath('applicant_profile/archive') . '/[id]','showIf' => '[vacancy_ad_id] ==  "4"'];
        if(CRUDBooster::myPrivilegeId()==1||CRUDBooster::myPrivilegeId()==5){
        // $this->addaction[] = ['label' => '', 'icon' => 'fa fa-refresh', 'color' => 'warning', 'url' => CRUDBooster::mainpath('insert') . '/[id]'.'/[applicant_id]','showIf' => '[vacancy_ad_id] ==  "4"'];

        $this->addaction[] = ['label' => '', 'icon' => 'fa fa-refresh', 'color' => 'warning', 'url' => CRUDBooster::mainpath('insert') . '/[id]'.'/[applicant_id]'];
        }
        // $this->addaction[] = ['label'=>' ','icon'=>'fa fa-remove','color'=>'warning','url'=>CRUDBooster::mainpath('set-status/1/[id]')];

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
        //$this->index_button[] = ["label"=>"Print Report","icon"=>"fa fa-print","url"=>CRUDBooster::mainpath('print-report')];

        /*
        | ----------------------------------------------------------------------
        | Customize Table Row Color
        | ----------------------------------------------------------------------
        | @condition = If condition. You may use field alias. E.g : [id] == 1
        | @color = Default is none. You can use bootstrap success,info,warning,danger,primary.
        |
         */
        $this->table_row_color = array();
        $this->table_row_color[] = ['condition' => "[is_rejected] == 'YES'", "color" => "danger"];
        $this->table_row_color[] = ['condition' => "[is_cancelled] == 'YES'", "color" => "warning"];

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
        $this->script_js = "$(document).ready(function(){
            $('td:nth-child(15), th:nth-child(15)').show();
            $('td:nth-child(16), th:nth-child(16)').hide();
            $('td:nth-child(17), th:nth-child(17)').hide();
            $('td:nth-child(18), th:nth-child(18)').hide();
            $('td:nth-child(19), th:nth-child(19)').hide();
            $('td:nth-child(20), th:nth-child(20)').hide();
            $('td:nth-child(21), th:nth-child(21)').hide();

        });";

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

        /*
        | ----------------------------------------------------------------------
        | Add css style at body
        | ----------------------------------------------------------------------
        | css code in the variable
        | $this->style_css = ".style{....}";
        |
         */
        $this->style_css = "
        td .button_action { text-align:left !important;}
            .button_action a.btn{width:24px; margin:1px;}
            th i{display:none !important;}";

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

        // var_dump($id_selected);
        // var_dump($button_name);
        // dd('s');
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
        // dd(Request::all());

        // dd($query->toSql());

        $designation=DB::table('mst_designation')->select('code','name_en')->whereIs_deleted(false)->orderBy('work_level_id', 'ASC')->get();
        Session::put('designation', $designation);

        $opening_type=DB::table('vacancy_ad')->select('id','ad_title_en')->whereIs_deleted(false)->orderBy('id', 'ASC')->get();
        Session::put('opening_type', $opening_type);

        $privilege_group=DB::table('mst_privilege_group')->select('code','name_en')->whereIs_deleted(false)->orderBy('id', 'ASC')->get();
        Session::put('privilege_group', $privilege_group);


        //Your code here
        $ad_id = Request::get('ad');
        $md_id = Request::get('md');
        $last_url = Request::get('lasturl');
        $fiscal_year_id = Session::get('fiscal_year_id');
        $date = date('Y-m-d');

        #search criteria
        $opening_type = Request::get('opening_type');
        if (!empty($opening_type)) {
            $query->where('vacancy_ad_id', $opening_type);
        }

        $privilege_group = Request::get('privilege_group');
        if (!empty($privilege_group)) {
            if($privilege_group==1){
                $query->where('is_female',true);
            }
            if($privilege_group==2){
                $query->where('is_janajati',true);
            }
            if($privilege_group==3){
                $query->where('is_madhesi',true);
            }
            if($privilege_group==4){
                $query->where('is_dalit',true);
            }
            if($privilege_group==5){
                $query->where('is_handicapped',true);
            }
            if($privilege_group==6){
                $query->where('is_remote_village',true);
            }

        }


        $token_no = Request::get('token_no');
        if (!empty($token_no)) {
            $query->where('token_number', $token_no);
        }
        $applicant_id = Request::get('applicant_id');
        if (!empty($applicant_id)) {
            $query->where('applicant_id', $applicant_id);
        }
        $mobile = Request::get('mobile');
        if (!empty($mobile)) {
            $query->where('mobile_no', $mobile);
        }

        $email = Request::get('email');
        if (!empty($email)) {
            $query->where('email', $email);
        }

        $fullname = Request::get('fullname');
        if (!empty($fullname)) {
            $query->where('name_en','LIKE','%'.$fullname.'%');
        }


        $from_date_ad = Request::get('from_date_ad');

        if (!empty($from_date_ad)) {
            if (!empty($to_date_ad)) {
                $date = $to_date_ad;
                $query->whereBetween('applied_date_ad', [$from_date_ad, $date]);
            } else {
                $date = Carbon::now();
                $query->where('applied_date_ad',$from_date_ad);
            }
            //$query->whereBetween('paid_receipt_date_ad', [$from_date_ad, $date]);
        }
        $to_date_ad = Request::get('to_date_ad');
        if (!empty($to_date_ad)) {

            if (!empty($from_date_ad)) {
                $date = $from_date_ad;
            } else {
                $date = Carbon::now();
            }
            $query->whereBetween('applied_date_ad', [$date, $to_date_ad]);
        }



        $designation = Request::get('designation');
        if (!empty($designation)) {
            $query->where('designation_id', $designation);
        }
        $paymentstatus = Request::get('paymentstatus');
        if (!empty($paymentstatus)) {
            if($paymentstatus==1){
                $query->whereNotNull('paid');
            }else{
                $query->whereNull('paid');
            }
        }

        $status = Request::get('status');
        if (!empty($status)) {
           if($status==1){
                $query->where('is_rejected',true);
            }elseif($status==2){
                $query->where('is_cancelled',true);
            }else{
                $query->where([['is_cancelled',false],['is_rejected',false]]);
            }
        }

        if(!empty($ad_id)){
            $query->where('vw_vacancy_applicant.vacancy_ad_id', $ad_id);
        }

        if(!empty($md_id)){
            $query->where([['vacancy_ad_id', $ad_id], ['designation_id', $md_id]])->orderby('ad_no');
        }


        $query->leftjoin('vacancy_ad', 'vw_vacancy_applicant.vacancy_ad_id', 'vacancy_ad.id')
              ->where([['vw_vacancy_applicant.fiscal_year_id', $fiscal_year_id], ['is_deleted', false]])
              ->distinct('applicant_id','vacancy_post_id','vacancy_ad_id','designation_id','designation_en','name_en','name_np');


    






        // if (!empty(Request::all())) {

        //     if ($ad_id == null & $last_url != null) {
        //         $gettingAdId = explode('ad=', $last_url);
        //         $id = $gettingAdId[1];
        //         if ($id != 0) {
        //             $ad_id = $id;
        //         }
        //     }

        //     if ($ad_id != 0) {
        //         $ad = DB::table('vacancy_ad')->where('id', $ad_id);
        //         if ($ad->count() == 0) {
        //             CRUDBooster::redirect(CRUDBooster::mainpath(), trans("Not any advertisement with that id."), 'warning');
        //         } else {
        //             $query->where('vw_vacancy_applicant.vacancy_ad_id', $ad_id);
        //         }
        //     } else {
        //         $ad_id = DB::table('vacancy_ad')->max('id');
        //         $query->where('vw_vacancy_applicant.vacancy_ad_id', $ad_id);
        //     }

        //     if ($ad_id != 0) {
        //         $md_id = Request::get('md');
        //         if ($md_id != 0) {
        //             $query->where([['vacancy_ad_id', $ad_id], ['designation_id', $md_id]])
        //                 ->orderby('ad_no');
        //         } else {
        //             $query->where('vacancy_ad_id', $ad_id)
        //                 ->orderby('ad_no');
        //         }
        //     }
        // } else {

        //     //dd($fiscal_year_id);
        //     $query->leftjoin('vacancy_ad', 'vw_vacancy_applicant.vacancy_ad_id', 'vacancy_ad.id')
        //         ->where([['fiscal_year_id', $fiscal_year_id], ['is_deleted', false], ['vacancy_extended_date_ad', '>=', $date]]);

        //         //dd($query->toSql());
        // }

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

    // public function getIndex()
    // {
    //     // return dd('dd');
    //     try {
    //         $q = request()->query('q');
    //         $ad_id = request()->query('ad');
        
    //         if ($q !== null || $ad_id !== null) {
    //             return self::getsearch();
    //         }

    //         if (!CRUDBooster::isView()) {
    //             CRUDBooster::redirect(CRUDBooster::adminPath(), trans('crudbooster.denied_access'));
    //         }
    
    //         $data = [];
    //         $data['page_title'] = 'Vacancy Applicants';
    //         $data['result'] = DB::table('vw_vacancy_applicant')->orderby('id', 'desc')->paginate(10);
    //         $this->cbView('default.Applied_applications.custom_index', $data);
    //     } catch (\Throwable $th) {
    //         return $th->getMessage().'error occured please go back';
    //     }
    // }

    //By the way, you can still create your own method in here... :)
    // public function getsearch()
    // {
          
    //    try {
    //     $text = Request::get('q');
    //     $ad_id = Request::get('ad');
    //     //dd($ad_id);
    //     $data1 = DB::table('vw_vacancy_applicant')
    //         ->select('id', 'ad_no', 'designation_en', 'published_date_bs', 'last_date_bs', 'applicant_id',
    //             'photo', 'name_en', 'mobile_no', 'applied_date_bs', 'token_number', 'total_amount', 'paid_receipt_no',
    //             'is_handicapped', 'is_dalit', 'is_janajati', 'is_madhesi', 'is_remote_village', 'applied_group',
    //             'is_rejected', 'is_cancelled')
    //         ->where('ad_no', '=', $ad_id)
    //         ->orWhere('id', 'LIKE', '%' . $text . '%')
    //         ->orWhere('ad_no', 'LIKE', '%' . $text . '%')
    //         ->orWhere('designation_en', 'LIKE', '%' . $text . '%')
    //         ->orWhere('published_date_bs', 'LIKE', '%' . $text . '%')
    //         ->orWhere('last_date_bs', 'LIKE', '%' . $text . '%')
    //         ->orWhere('applicant_id', 'LIKE', '%' . $text . '%')
    //         ->where('photo', 'LIKE', '%' . $text . '%')
    //         ->orWhere('name_en', 'LIKE', '%' . $text . '%')
    //         ->orWhere('mobile_no', 'LIKE', '%' . $text . '%')
    //         ->orWhere('applied_date_bs', 'LIKE', '%' . $text . '%')
    //         ->orWhere('token_number', 'LIKE', '%' . $text . '%')
    //         ->orWhere('total_amount', 'LIKE', '%' . $text . '%')
    //         ->orWhere('paid_receipt_no', 'LIKE', '%' . $text . '%')
    //         ->get();

    //     return view('default.Applied_applications.view', compact('data1'));
    //    } catch (\Throwable $th) {
    //     return $th->getMessage().' Error occured please go back';
    //    }
    // }



    
}

