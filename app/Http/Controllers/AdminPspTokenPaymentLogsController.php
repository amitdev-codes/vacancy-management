<?php namespace App\Http\Controllers;

use App;
use App\Models\Tokenpaymentlog;
use App\Models\VacancyPaymentDetail;
use Carbon\Carbon;
use CRUDBooster;
use DB;
use Illuminate\Support\Facades\Storage;
use Redirect;
use View;

class AdminPspTokenPaymentLogsController extends BaseCBController
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
        $this->table = "psp_token_payment_logs";
        # END CONFIGURATION DO NOT REMOVE THIS LINE

        # START COLUMNS DO NOT REMOVE THIS LINE
        $this->col = [];
        $this->col[] = ["label" => "Psp Id", "name" => "psp_id", "join" => "mst_payment_methods,name_en"];
        $this->col[] = ["label" => "Validation Token", "name" => "validation_unique_generated_token"];
        $this->col[] = ["label" => "Applicant Name", "name" => "applicant_name"];
        $this->col[] = ["label" => "Applicant Token", "name" => "applicant_token"];
        $this->col[] = ["label" => "Applicant Id", "name" => "applicant_id"];
        $this->col[] = ["label" => "Ntc TxnId", "name" => "eservice_transaction_code"];
        $this->col[] = ["label" => "Psp token", "name" => "psp_transaction_code"];
        $this->col[] = ["label" => "Amount", "name" => "ntc_paid_amount"];
        $this->col[] = ["label" => "Verification Status", "name" => "payment_verification_status"];
        $this->col[] = ["label" => "Ntc Update Status", "name" => "ntc_update_status"];
        $this->col[] = ["label" => "Report No", "name" => "paid_receipt_no"];
        $this->col[] = ["label" => "Receipt Date", "name" => "paid_receipt_date_ad"];


        # END COLUMNS DO NOT REMOVE THIS LINE

        # START FORM DO NOT REMOVE THIS LINE
        $this->form = [];
        $this->form[] = ['label' => 'Ipaddress', 'name' => 'ipaddress', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Useragent', 'name' => 'useragent', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Psp Id', 'name' => 'psp_id', 'type' => 'select2', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10', 'datatable' => 'mst_payment_methods,name_en'];
        $this->form[] = ['label' => 'Applicant Id', 'name' => 'applicant_id', 'type' => 'text', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Applicant Name', 'name' => 'applicant_name', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Email', 'name' => 'email', 'type' => 'email', 'validation' => 'required|min:1|max:255|email|unique:psp_token_payment_logs', 'width' => 'col-sm-10', 'placeholder' => 'Please enter a valid email address'];
        $this->form[] = ['label' => 'Mobile', 'name' => 'mobile', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Applicant Token', 'name' => 'applicant_token', 'type' => 'number', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Applied Group', 'name' => 'applied_group', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Total Amount', 'name' => 'total_amount', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Process Step1', 'name' => 'process_step1', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Validation Pspcode', 'name' => 'validation_pspcode', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Validation Key', 'name' => 'validation_key', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Validation Applicant Token', 'name' => 'validation_applicant_token', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Validation Status', 'name' => 'validation_status', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Validation Message', 'name' => 'validation_message', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Validation Unique Generated Token', 'name' => 'validation_unique_generated_token', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Validation Time', 'name' => 'validation_time', 'type' => 'datetime', 'validation' => 'required|date_format:Y-m-d H:i:s', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Process Step2', 'name' => 'process_step2', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Inquiry Token', 'name' => 'inquiry_token', 'type' => 'number', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Inquiry Status', 'name' => 'inquiry_status', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Inquiry Message', 'name' => 'inquiry_message', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Inquiry Time', 'name' => 'inquiry_time', 'type' => 'datetime', 'validation' => 'required|date_format:Y-m-d H:i:s', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Process Step3', 'name' => 'process_step3', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Payment Token', 'name' => 'payment_token', 'type' => 'number', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Paid amount', 'name' => 'ntc_paid_amount', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Eservice Transaction Code', 'name' => 'eservice_transaction_code', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Psp Transaction Code', 'name' => 'psp_transaction_code', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Payment Verification Status', 'name' => 'payment_verification_status', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Payment Verification Message', 'name' => 'payment_verification_message', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Payment Verification Time', 'name' => 'payment_verification_time', 'type' => 'datetime', 'validation' => 'required|date_format:Y-m-d H:i:s', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Ntc Update Status', 'name' => 'ntc_update_status', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Ntc Update Datetime', 'name' => 'ntc_update_datetime', 'type' => 'datetime', 'validation' => 'required|date_format:Y-m-d H:i:s', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Ntc Update Message', 'name' => 'ntc_update_message', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Paid receipt No', 'name' => 'paid_receipt_no', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Paid receipt Date Bs', 'name' => 'paid_receipt_date_bs', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10'];
        $this->form[] = ['label' => 'Paid receipt Date Ad', 'name' => 'paid_receipt_date_ad', 'type' => 'date', 'validation' => 'required|date', 'width' => 'col-sm-10'];
        // $this->form[] = ['label' => 'Is Deleted', 'name' => 'is_deleted', 'type' => 'radio', 'validation' => 'required|integer', 'width' => 'col-sm-10', 'dataenum' => 'Array'];
        # END FORM DO NOT REMOVE THIS LINE

        # OLD START FORM
        //$this->form = [];
        //$this->form[] = ["label"=>"Ipaddress","name"=>"ipaddress","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Useragent","name"=>"useragent","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Psp Id","name"=>"psp_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"psp,id"];
        //$this->form[] = ["label"=>"Applicant Id","name"=>"applicant_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"applicant,id"];
        //$this->form[] = ["label"=>"Applicant Name","name"=>"applicant_name","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Email","name"=>"email","type"=>"email","required"=>TRUE,"validation"=>"required|min:1|max:255|email|unique:psp_token_payment_logs","placeholder"=>"Please enter a valid email address"];
        //$this->form[] = ["label"=>"Mobile","name"=>"mobile","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Applicant Token","name"=>"applicant_token","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
        //$this->form[] = ["label"=>"Applied Group","name"=>"applied_group","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Total Amount","name"=>"total_amount","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Process Step1","name"=>"process_step1","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Validation Pspcode","name"=>"validation_pspcode","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Validation Key","name"=>"validation_key","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Validation Applicant Token","name"=>"validation_applicant_token","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Validation Status","name"=>"validation_status","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Validation Message","name"=>"validation_message","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Validation Unique Generated Token","name"=>"validation_unique_generated_token","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Validation Time","name"=>"validation_time","type"=>"datetime","required"=>TRUE,"validation"=>"required|date_format:Y-m-d H:i:s"];
        //$this->form[] = ["label"=>"Process Step2","name"=>"process_step2","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Inquiry Token","name"=>"inquiry_token","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
        //$this->form[] = ["label"=>"Inquiry Status","name"=>"inquiry_status","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Inquiry Message","name"=>"inquiry_message","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Inquiry Time","name"=>"inquiry_time","type"=>"datetime","required"=>TRUE,"validation"=>"required|date_format:Y-m-d H:i:s"];
        //$this->form[] = ["label"=>"Process Step3","name"=>"process_step3","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Payment Token","name"=>"payment_token","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
        //$this->form[] = ["label"=>"Tax Paamount","name"=>"tax_paid_amount","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Eservice Transaction Code","name"=>"eservice_transaction_code","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Psp Transaction Code","name"=>"psp_transaction_code","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Payment Verification Status","name"=>"payment_verification_status","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Payment Verification Message","name"=>"payment_verification_message","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Payment Verification Time","name"=>"payment_verification_time","type"=>"datetime","required"=>TRUE,"validation"=>"required|date_format:Y-m-d H:i:s"];
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
        if (CRUDBooster::isSuperadmin()) {
            $this->addaction[] = ['label' => '', 'icon' => 'fa fa-recycle', 'color' => 'danger', 'url' => CRUDBooster::mainpath('Reprocess') . '/[id]'];
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

    }

    /*
    | ----------------------------------------------------------------------
    | Hook for manipulate row of index table html
    | ----------------------------------------------------------------------
    |
     */
    public function hook_row_index($column_index, &$column_value)
    {

        if ($column_index == 9) {
            switch ($column_value) {
                case '1':
                    $column_value = "<span class='bg-yellow panel-text-warning'>Payment Verified</span>";
                    break;
            }
        }
        if ($column_index == 10) {
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
        $today = Carbon::now();
        try {
            $tokenpay = Tokenpaymentlog::where('id', $id)->firstOrFail();

            $psp_id = $tokenpay->psp_id;
            $applicant_id = $tokenpay->applicant_id;
            $token = $tokenpay->applicant_token;
            $amt = $tokenpay->total_amount;
            $txnid = $tokenpay->eservice_transaction_code;

            // dd($tokenpay,$id);

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
                ->where('token_number', $token)
                ->get();
                // dd($applicant_details,$token,$applicant_id);

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
                'psp_mode' => $psp_id,
                'adv_no' => $ad_no,
                'token_number' => $token,
                'email' =>null,
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

            // dd($data);

            $uniquecode = mt_rand(1000, 9999);

            // $view = View::make('payment_integration.receipt', $data);
            // $contents = $view->render();
            // $pdf = App::make('snappy.pdf.wrapper');
            // $pdf->loadHTML($view);
            // Storage::disk('public')->put($location_path, $pdf->output());
            // $display_path = 'storage/' . $location_path;
            // $filpath = asset($display_path);

            $vacancy_payment_detail = VacancyPaymentDetail::updateOrCreate(
                ['token_number' => $token],
                ['applicant_id' => $applicant_id],
                ['amount_paid' => $amt],
                ['txn_id' => $txnid],
            );
            $vacancy_payment_detail->vacancy_post_id = $vacancy_post_id;
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
            $vacancy_payment_detail->tokenpayment_id = $tokenpay->id;
            $vacancy_payment_detail->receipt_path = $location_path;
            $vacancy_payment_detail->txn_id = $txnid;
            $vacancy_payment_detail->save();

            #save in webpayment table
            $tokenpay->payment_verification_status = true;
            $tokenpay->payment_verification_time = $date;
            $tokenpay->payment_verification_message = "verification of payment was done succesfully";

            $tokenpay->ntc_update_status = true;
            $tokenpay->ntc_update_datetime = $date;
            $tokenpay->ntc_update_message = "Ntc update  was done succesfully";
            $tokenpay->paid_receipt_no = $receipt_no;
            $tokenpay->paid_receipt_date_bs = $date;
            $tokenpay->paid_receipt_date_ad = $date;
            $tokenpay->save();

            #send mail
            CRUDBooster::sendEmail(['to' => $email, 'data' => $data, 'template' => 'Receipt', 'attachments' => [$filpath]]);
            CRUDBooster::redirect(CRUDBooster::mainpath(), "Reprocess Of payment was done succesfully", "info");

        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', "Reprocess failed");
        }
    }

    //By the way, you can still create your own method in here... :)

}
