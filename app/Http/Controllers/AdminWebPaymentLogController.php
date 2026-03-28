<?php namespace App\Http\Controllers;

use App;
use App\Models\VacancyPaymentDetail;
use App\Models\WebPaymentLog;
use App\Models\VacancyApply;
use Carbon\Carbon;
use CRUDBooster;
use DB;
use Illuminate\Support\Facades\Storage;
use Redirect;
use View;
use Session;
use Request;

class AdminWebPaymentLogController extends BaseCBController
{

    public function cbInit()
    {

        # START CONFIGURATION DO NOT REMOVE THIS LINE
        $this->title_field = "applicant_name";
        $this->limit = "20";
        $this->orderby = "id,desc";
        $this->global_privilege = false;
        $this->button_table_action = true;
        $this->button_bulk_action = false;
        $this->button_action_style = "button_icon";
        $this->button_add = true;
        $this->button_edit = true;
        $this->button_delete = true;
        $this->button_detail = true;
        $this->button_show = true;
        $this->button_filter = true;
        $this->button_import = false;
        $this->button_export = true;
        $this->table = "web_payment_log";
        $this->getIndex_view = "webPayment.webPayment_index";

        # END CONFIGURATION DO NOT REMOVE THIS LINE

        # START COLUMNS DO NOT REMOVE THIS LINE
        $this->col = [];
        $this->col[] = ["label" => "Psp Id", "name" => "psp_id", "join" => "mst_payment_methods,name_en"];
        $this->col[] = ["label" => "Applicant Name", "name" => "applicant_name"];
        $this->col[] = ["label" => "Mobile Number", "name" => "mobile"];
        $this->col[] = ["label" => "Token/ApplicantId", "name" => "trim(concat(applicant_token,'</br>', applicant_id)) as dob_ad"];
        $this->col[] = ["label" => "Designation", "name" => "psp_product","join" => "mst_designation,name_en"];
        $this->col[] = ["label" => "Applied Group", "name" => "applied_group"];
        $this->col[] = ["label" => "Ntc TxnId", "name" => "eservice_trans_ref_code"];
        $this->col[] = ["label" => "Psp token", "name" => "psp_reference_token"];
       // $this->col[] = ["label" => "Amount", "name" => "total_paid_amount"];
        $this->col[] = ["label" => "Amount", "name" => "case when psp_id = 2 then round(total_paid_amount/100) ELSE total_amount END as Amount"];
        $this->col[] = ["label" => "payment Status", "name" => "psp_payment_status"];
        $this->col[] = ["label" => "Verification Status", "name" => "psp_verification_status"];
        $this->col[] = ["label" => "Ntc Update Status", "name" => "ntc_update_status"];
        $this->col[] = ["label" => "Report No", "name" => "paid_receipt_no"];

        // $this->col[] = ["label"=>"Email","name"=>"email"];
        // $this->col[] = ["label"=>"Mobile","name"=>"mobile"];

        // $this->col[] = ["label"=>"Notice No","name"=>"notice_no"];
        # END COLUMNS DO NOT REMOVE THIS LINE

        # START FORM DO NOT REMOVE THIS LINE
        $this->form = [];
        $this->form[] = ['label' => 'Psp Id', 'name' => 'psp_id', 'type' => 'select2', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10', 'datatable' => 'mst_payment_methods,name_en'];
        $this->form[] = ['label' => 'Applicant Id', 'name' => 'applicant_id', 'type' => 'number', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Applicant Name', 'name' => 'applicant_name', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Email', 'name' => 'email', 'type' => 'email', 'width' => 'col-sm-10', 'placeholder' => 'Please enter a valid email address'];
        $this->form[] = ['label' => 'Mobile', 'name' => 'mobile', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Applicant Token', 'name' => 'applicant_token', 'type' => 'number', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Notice No', 'name' => 'notice_no', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Advertisement No', 'name' => 'advertisement_no', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Applied Date Ad', 'name' => 'applied_date_ad', 'type' => 'date', 'validation' => 'required|date', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Applied Date Bs', 'name' => 'applied_date_bs', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Applied Group', 'name' => 'applied_group', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Total Amount', 'name' => 'total_amount', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Eservice Trans Ref Code', 'name' => 'eservice_trans_ref_code', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Process Step', 'name' => 'process_step', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Psp Code', 'name' => 'psp_code', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Psp Trans Ref Code', 'name' => 'psp_trans_ref_code', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Psp Reference Token', 'name' => 'psp_reference_token', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Psp Product', 'name' => 'psp_product', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Psp Payment Status', 'name' => 'psp_payment_status', 'type' => 'text', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Psp Payment Message', 'name' => 'psp_payment_message', 'type' => 'text', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Psp Verification Status', 'name' => 'psp_verification_status', 'type' => 'text', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Psp Verification Datetime', 'name' => 'psp_verification_datetime', 'type' => 'datetime', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Psp Verification Message', 'name' => 'psp_verification_message', 'type' => 'text', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Total PaId amount', 'name' => 'total_paid_amount', 'type' => 'text', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Ntc Update Status', 'name' => 'ntc_update_status', 'type' => 'text', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Ntc Update Datetime', 'name' => 'ntc_update_datetime', 'type' => 'datetime', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Ntc Update Message', 'name' => 'ntc_update_message', 'type' => 'text', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Paid receipt No', 'name' => 'paid_receipt_no', 'type' => 'text', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Paid receipt Date Bs', 'name' => 'paid_receipt_date_bs', 'type' => 'text', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Paid receipt Date Ad', 'name' => 'paid_receipt_date_ad', 'type' => 'date', 'width' => 'col-sm-10'];
        // $this->form[] = ['label' => 'Is Deleted', 'name' => 'is_deleted', 'type' => 'radio', 'validation' => 'required|integer', 'width' => 'col-sm-10', 'dataenum' => 'Array'];
        # END FORM DO NOT REMOVE THIS LINE

        # OLD START FORM
        //$this->form = [];
        //$this->form[] = ["label"=>"Psp Id","name"=>"psp_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"psp,id"];
        //$this->form[] = ["label"=>"Applicant Id","name"=>"applicant_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"applicant,id"];
        //$this->form[] = ["label"=>"Applicant Name","name"=>"applicant_name","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Email","name"=>"email","type"=>"email","required"=>TRUE,"validation"=>"required|min:1|max:255|email|unique:web_payment_log","placeholder"=>"Please enter a valid email address"];
        //$this->form[] = ["label"=>"Mobile","name"=>"mobile","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Applicant Token","name"=>"applicant_token","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
        //$this->form[] = ["label"=>"Notice No","name"=>"notice_no","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Advertisement No","name"=>"advertisement_no","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Applied Date Ad","name"=>"applied_date_ad","type"=>"date","required"=>TRUE,"validation"=>"required|date"];
        //$this->form[] = ["label"=>"Applied Date Bs","name"=>"applied_date_bs","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Applied Group","name"=>"applied_group","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Total Amount","name"=>"total_amount","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Eservice Trans Ref Code","name"=>"eservice_trans_ref_code","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Process Step","name"=>"process_step","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Psp Code","name"=>"psp_code","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Psp Trans Ref Code","name"=>"psp_trans_ref_code","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Psp Reference Token","name"=>"psp_reference_token","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Psp Product","name"=>"psp_product","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Psp Payment Status","name"=>"psp_payment_status","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Psp Payment Message","name"=>"psp_payment_message","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Psp Verification Status","name"=>"psp_verification_status","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Psp Verification Datetime","name"=>"psp_verification_datetime","type"=>"datetime","required"=>TRUE,"validation"=>"required|date_format:Y-m-d H:i:s"];
        //$this->form[] = ["label"=>"Psp Verification Message","name"=>"psp_verification_message","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Total Paamount","name"=>"total_paid_amount","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Ntc Update Status","name"=>"ntc_update_status","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Ntc Update Datetime","name"=>"ntc_update_datetime","type"=>"datetime","required"=>TRUE,"validation"=>"required|date_format:Y-m-d H:i:s"];
        //$this->form[] = ["label"=>"Ntc Update Message","name"=>"ntc_update_message","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Pareceipt No","name"=>"paid_receipt_no","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Pareceipt Date Bs","name"=>"paid_receipt_date_bs","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Pareceipt Date Ad","name"=>"paid_receipt_date_ad","type"=>"date","required"=>TRUE,"validation"=>"required|date"];
        //$this->form[] = ["label"=>"Is Deleted","name"=>"is_deleted","type"=>"radio","required"=>TRUE,"validation"=>"required|integer","dataenum"=>"Array"];
        # OLD END FORM

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
        if (CRUDBooster::isSuperadmin()||CRUDBooster::myPrivilegeId()=='5') {
        $this->addaction[] = ['label' => '', 'icon' => 'fa fa-print', 'color' => 'danger', 'url' => CRUDBooster::adminpath('paymentreceipt') . '/[eservice_trans_ref_code]'];
        }
        if (CRUDBooster::isSuperadmin()) {
            // $this->addaction[] = ['label' => '', 'icon' => 'fa fa-print', 'color' => 'primary', 'url' => CRUDBooster::mainpath('Reprocess') . '/[id]'];
            $this->addaction[] = ['label' => '', 'icon' => 'fa fa-recycle', 'color' => 'primary', 'url' => CRUDBooster::mainpath('Reprocess') . '/[id]'];

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
        // $this->load_js[] = asset("js/nepali.datepicker.v2.2.min.js");
        // $this->load_js[] = asset("js/newdateConversion.js");

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
        //Your code here

        $epay_source=DB::table('mst_payment_methods')->select('counter_id','name_en')->whereIs_webpayment(true)->orderBy('id', 'ASC')->get();
        Session::put('epaysource', $epay_source);

        $designation=DB::table('mst_designation')->select('code','name_en')->whereIs_deleted(false)->orderBy('work_level_id', 'ASC')->get();
        Session::put('designation', $designation);

        $token_no = Request::get("token_no");
        $applicant_id = Request::get("applicant_id");
        $mobile = Request::get("mobile");
        $designation = Request::get("designation");
        $epay = Request::get("epay");
        $status = Request::get("status");
        $email = Request::get("email");

        $from_date_ad = Request::input('from_date_ad');
        $to_date_ad = Request::input('to_date_ad');

$query->where('web_payment_log.fiscal_year_id',Session::get('fiscal_year_id'));
        //dd( Request::all());
       
     
        if (!empty($token_no)) {
            $query->where('applicant_token', $token_no);
        }
        if (!empty($designation)) {
            $query->where('psp_product', $designation);
        }
        if (!empty($from_date_ad)) {
            if (!empty($to_date_ad)) {
                $date = $to_date_ad;
                $query->whereBetween('paid_receipt_date_ad', [$from_date_ad, $date]);
            } else {
                $date = Carbon::now();
                $query->where('paid_receipt_date_ad',$from_date_ad);
            }
            //$query->whereBetween('paid_receipt_date_ad', [$from_date_ad, $date]);
        }

        if (!empty($to_date_ad)) {

            if (!empty($from_date_ad)) {
                $date = $from_date_ad;
            } else {
                $date = Carbon::now();
            }
            $query->whereBetween('paid_receipt_date_ad', [$date, $to_date_ad]);
        }

        if (!empty($applicant_id)) {
            $query->where('applicant_id', $applicant_id);
        }
        if (!empty($epay)) {
            $psp_id = DB::table('mst_payment_methods')->select('code')->whereId($epay)->first();
            $psp = $psp_id->code;
            $query->where('psp_code', $psp);
        }
        if (!empty($mobile)) {
            $query->where('mobile', $mobile);
        }

        if (!empty($email)) {
            $query->where('email', $email);
        }


        if (!empty($status)) {
            if ($status == 1) {
                $query->where('psp_payment_status', true);
            }
            elseif($status==2){
                $query->where('psp_verification_status', true); 
            }elseif($status==3){
                $query->where('ntc_update_status', true); 
            } else {
                $query->whereNull('psp_payment_status')->orWhere('psp_payment_status', false);
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

        if ($column_index == 10) {
            switch ($column_value) {
                case '1':
                    $column_value = "<span class='bg-aqua panel-text-info'>Payment Done</span>";
                    break;
            }
        }
        if ($column_index == 11) {
            switch ($column_value) {
                case '1':
                    $column_value = "<span class='bg-yellow panel-text-warning'>Payment Verified</span>";
                    break;
            }
        }
        if ($column_index == 12) {
            switch ($column_value) {
                case '1':
                    $column_value = "<span class='bg-green panel text-success'>Ntc Updated</span>";
                    break;
            }
        }

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

    public function getReprocess($id)
    {
        // dd($id);
        $today = Carbon::now();
        try {
            $webpay = WebPaymentLog::where('id', $id)->firstOrFail();
            $notice_no = $webpay->notice_no;
            $psp_id = $webpay->psp_id;
            $applicant_id = $webpay->applicant_id;
            $token = $webpay->applicant_token;
            $amt = $webpay->total_amount;
            $epay_code = $webpay->psp_code;
            $email = $webpay->email;
            $txnid= $webpay->eservice_trans_ref_code;

            // $designation_id=$webpay->psp_product;
            // $ad_no=$webpay->advertisement_no;

            // $vacancy_post=DB::table('vacancy_post')->where([['designation_id',$designation_id],['ad_no',$ad_no]])->select('id')->first();
            // $vacancy_post_id=$vacancy_post->id;

           // dd($webpay,$txnid);
            #get data
            $applicant_details = DB::table('vw_vacancy_applicant')
                ->select('name_en',
                    'applicant_id',
                    'designation_id',
                    'vacancy_post_id',
                    'vacancy_ad_id',
                    'ad_no',
                    'token_number',
                    'total_amount',
                    'mobile_no',
                    'applied_group',
                    'designation_en',
                    'applied_date_ad',
                    'applied_date_bs',
                    'is_female',
                    'is_janajati',
                    'is_madhesi',
                    'is_dalit',
                    'is_handicapped',
                    'is_remote_village',
                    'is_open',
                    'amount_for_job',
                    'amount_for_priv_grp')
                ->where([['token_number', $token], ['applicant_id', $applicant_id], ['is_cancelled', false], ['is_rejected', false], ['is_paid', null]])
                ->get();

            $username = $applicant_details[0]->name_en;
            $designation_en = $applicant_details[0]->designation_en;
            $designation_id = $applicant_details[0]->designation_id;
            $ad_no = $applicant_details[0]->ad_no;
            $applied_date_ad = $applicant_details[0]->applied_date_ad;
            $applied_date_bs = $applicant_details[0]->applied_date_bs;

            $mobile = $applicant_details[0]->mobile_no;
            $applied_group = $applicant_details[0]->applied_group;
            $vacancy_post_id = $applicant_details[0]->vacancy_post_id;

            #for group
            $is_female = $applicant_details[0]->is_female;
            $is_janajati = $applicant_details[0]->is_janajati;
            $is_madhesi = $applicant_details[0]->is_madhesi;
            $is_dalit = $applicant_details[0]->is_dalit;
            $is_handicapped = $applicant_details[0]->is_handicapped;
            $is_remote_village = $applicant_details[0]->is_remote_village;
            $is_open = $applicant_details[0]->is_open;
            $amount_for_job = $applicant_details[0]->amount_for_job;
            $amount_for_priv_grp = $applicant_details[0]->amount_for_priv_grp;

            #generate receipt
            $today = Carbon::now();
            $date = date('Ymd', strtotime($today));
            $receipt_no = 'C' . $date . '-' . $psp_id . '-' . $applicant_id . '-' . $token;

            $data = ['applicant_name' => $username,
                'applicant_id' => $applicant_id,
                'psp_mode' => $epay_code,
                'adv_no' => $ad_no,
                'token_number' => $token,
                'email' => $email,
                'Designation' => $designation_en,
                'receipt' => $receipt_no,
                'amount' => $amt,
                'receipt_date' => $date,
                'is_female' => $is_female,
                'is_janajati' => $is_janajati,
                'is_madhesi' => $is_madhesi,
                'is_dalit' => $is_dalit,
                'is_handicapped' => $is_handicapped,
                'is_remote_village' => $is_remote_village,
                'is_open' => $is_open,
                'amount_for_job' => $amount_for_job,
                'amount_for_priv_grp' => $amount_for_priv_grp,

            ];

            //dd($data);

            $uniquecode = mt_rand(1000, 9999);
            $location_path = '/pdf/cash_receipt/' . $applicant_id . '/' . $token . '/' . $uniquecode . '_payment_receipt.pdf';
            $view = View::make('payment_integration.receipt', $data);
            $contents = $view->render();
            $pdf = App::make('snappy.pdf.wrapper');
            $pdf->loadHTML($view);
            Storage::disk('public')->put($location_path, $pdf->output());
            $display_path = 'storage/' . $location_path;
            $filpath = asset($display_path);

            $vacancy_payment_detail = VacancyPaymentDetail::updateOrCreate(
                ['token_number' => $token],
                ['applicant_id' => $applicant_id],
                ['amount_paid' => $amt],
                ['txn_id' => $txnid],
            );
            $vacancy_payment_detail->vacancy_post_id = $vacancy_post_id;;
            $vacancy_payment_detail->designation_id = $designation_id;
            $vacancy_payment_detail->applicant_id = $applicant_id;
            $vacancy_payment_detail->applicant_name = $username;
            $vacancy_payment_detail->psp_id = $psp_id;
            $vacancy_payment_detail->token_number = $token;
            $vacancy_payment_detail->amount_paid = $amt;
            $vacancy_payment_detail->receipt_number = $receipt_no;
            $vacancy_payment_detail->receipt_date_ad = $date;
            $vacancy_payment_detail->remarks = "Payment data updated successfully";
            $vacancy_payment_detail->is_email_sent = true;
            $vacancy_payment_detail->email_sent_date_ad = $date;
            $vacancy_payment_detail->webpayment_id = $webpay->id;
            $vacancy_payment_detail->receipt_path = $location_path;
            $vacancy_payment_detail->txn_id = $txnid;
            $vacancy_payment_detail->save();

            #save in webpayment table
            $webpay->psp_verification_status = true;
            $webpay->psp_verification_datetime = $date;
            $webpay->psp_verification_message = "verification of payment was done succesfully";
            $webpay->total_paid_amount = $amt;
            $webpay->ntc_update_status = true;
            $webpay->ntc_update_datetime = $date;
            $webpay->ntc_update_message = "Ntc update  was done succesfully";
            $webpay->paid_receipt_no = $receipt_no;
            $webpay->paid_receipt_date_bs = $date;
            $webpay->paid_receipt_date_ad = $date;
            $webpay->save();

            $vacancyapply = VacancyApply::where([['token_number', $token], ['total_paid_amount', null], ['is_cancelled', false], ['is_rejected', false]])->firstOrFail();
            $vacancyapply->total_paid_amount = $amt;
            $vacancyapply->is_paid = true;
            $vacancyapply->paid_receipt_no = $receipt_no;
            $vacancyapply->paid_date_ad = $date;
            $vacancyapply->paid_date_bs = $date;
            $vacancyapply->save();

            #send mail
            CRUDBooster::sendEmail(['to' => $email, 'data' => $data, 'template' => 'Receipt', 'attachments' => [$filpath]]);
            CRUDBooster::redirect(CRUDBooster::mainpath(), "Reprocess Of payment was done succesfully", "info");

        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', "Reprocess failed");
        }
    }

    //By the way, you can still create your own method in here... :)

}
