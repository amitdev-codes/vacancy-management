<?php
namespace App\Http\Controllers;

use CRUDBooster;
use DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Session;

class AdminCsvPaymentFileDetailsController extends BaseCBController
{

    public function cbInit()
    {

        # START CONFIGURATION DO NOT REMOVE THIS LINE
        $this->title_field = "applicant_name";
        $this->limit = "20";
        $this->orderby = "id,desc";
        $this->global_privilege = false;
        $this->button_table_action = true;
        $this->button_bulk_action = true;
        $this->button_action_style = "button_icon";
        //$this->button_add = true;
        $this->button_add = false;
        $this->button_edit = true;
        //$this->button_delete = true;
        $this->button_detail = true;
        $this->button_show = true;
        $this->button_filter = true;
        $this->button_import = false;
        $this->button_export = true;
        $this->table = "csv_payment_file_details";
        // $this->hide_form = ["importer_user"];
        # END CONFIGURATION DO NOT REMOVE THIS LINE

        # START COLUMNS DO NOT REMOVE THIS LINE
        $this->col = [];
        $this->col[] = ["label" => "Csv Payment File", "name" => "csv_payment_file_id", "join" => "csv_payment_files,uploaded_date_ad"];
        $this->col[] = ["label" => "Imported By", "name" => "importer_user_id", "join" => "cms_users,name"];
        $this->col[] = ["label" => "Imported Date A.D.", "name" => "imported_date_ad", "width" => "80px"];
        $this->col[] = ["label" => "Token Number", "name" => "token_number", "width" => "80px"];
        $this->col[] = ["label" => "Receipt Date A.D.", "name" => "receipt_date_ad", "width" => "80px"];
        $this->col[] = ["label" => "Receipt Number", "name" => "receipt_number"];
        $this->col[] = ["label" => "Amount Paid", "name" => "amount_paid", "width" => "50px"];
        $this->col[] = ["label" => "Receipt Applicant", "name" => "applicant_name", "width" => "130px"];
        $this->col[] = ["label" => "Is Linked", "name" => "is_linked", "width" => "70px"];
        // $this->col[] = ["label" => "Linked<br/>Applicant", "name" => "linked_application_id", "join" => "vw_vacancy_applicant,name_en"];
        // $this->col[] = ["label"=>"Applicant ID","name"=>"applicant_id", "join"=>"vw_vacancy_applicant,id", "width"=>"60px"];

        // $this->col[] = ["label"=>"Applicant ID","name" =>"(select a.applicant_id from vw_vacancy_applicant a where csv_payment_file_details.token_number = a.token_number) as linked_applicant"];

        // $this->col[] = ["label" => "Application ID", "name" => "linked_application_id", "join" => "vw_vacancy_applicant,id", "width" => "60px"];
        $this->col[] = ["label" => "Email Log", "link" => "Email Log", "name" => "link_email_log_path", "width" => "30px"];

        # END COLUMNS DO NOT REMOVE THIS LINE

        # START FORM DO NOT REMOVE THIS LINE
        $this->form = [];
        $this->form[] = ["label" => "Csv Payment File", "name" => "csv_payment_file_id", "type" => "select2-c", "required" => true, "validation" => "required|integer|min:0", "datatable" => "csv_payment_files,uploaded_date_ad", 'cmp-ratio' => '12:2:10'];
        $this->form[] = ["label" => "Importer User Id", "name" => "importer_user_id", "type" => "hidden", "required" => true];
        $this->form[] = ["label" => "Importer User", "name" => "importer_user", "type" => "text-c", "disabled" => true, 'cmp-ratio' => '6:4:8'];
        $this->form[] = ["label" => "Imported Date A.D.", "name" => "imported_date_ad", "type" => "date-c", "required" => false, "validation" => "", 'cmp-ratio' => '6:4:8', "readonly" => true];
        //$this->form[] = ["label"=>"Imported Date Bs","name"=>"imported_date_bs","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        $this->form[] = ["label" => "Token Number (CSV)", "name" => "token_number_text", "type" => "text-c", "validation" => "", 'cmp-ratio' => '6:4:8'];
        $this->form[] = ["label" => "Token Number (Final)", "name" => "token_number", "type" => "text-c", "validation" => "", 'cmp-ratio' => '6:4:8'];
        $this->form[] = ["label" => "Amount Paid", "name" => "amount_paid", "type" => "number-c", 'cmp-ratio' => '6:4:8', "readonly" => true];
        $this->form[] = ["label" => "Receipt Number", "name" => "receipt_number", "type" => "text-c", 'cmp-ratio' => '6:4:8', "readonly" => true];
        $this->form[] = ["label" => "Receipt Date A.D.", "name" => "receipt_date_ad", "type" => "date-c", "required" => false, "validation" => "", 'cmp-ratio' => '6:4:8', "readonly" => true];
        $this->form[] = ["label" => "Applicant Name", "name" => "applicant_name", "type" => "text-c", 'cmp-ratio' => '6:4:8', "readonly" => true];
        $this->form[] = ["label" => "Remarks", "name" => "remarks", "type" => "textarea-c", 'cmp-ratio' => '12:2:10', "readonly" => true];
        $this->form[] = ["label" => "Is Linked", "name" => "is_linked", "type" => "radio-c", "required" => true, "validation" => "required|integer", "dataenum" => "0|No; 1|Yes", 'cmp-ratio' => '4:4:8'];
        $this->form[] = ["label" => "Linked Application", "name" => "linked_application_id", "type" => "number-c", "required" => false, 'cmp-ratio' => '4:4:8'];
        //$this->form[] = ["label"=>"Linked Application","name"=>"linked_application_id","type"=>"custom-c","required"=>TRUE,"html"=>$atag,'cmp-ratio'=>'6:4:8'];
        $this->form[] = ["label" => "Is Email Sent", "name" => "is_email_sent", "type" => "radio-c", "required" => true, "validation" => "required|integer", "dataenum" => "0|No; 1|Yes", 'cmp-ratio' => '4:4:8'];
        //$atag = '<a href="https://www.w3schools.com" target=_blank>Visit W3Schools.com!</a>';
        //$this->form[] = ["label"=>"Linked Application","name"=>"linked_application_id","type"=>"custom-c","required"=>TRUE,"html"=>$atag,'cmp-ratio'=>'6:4:8'];
        # END FORM DO NOT REMOVE THIS LINE

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
        $this->addaction[] = ['label' => 'Relink', 'url' => CRUDBooster::mainpath('../csv_payment_files/relink/[id]'), 'icon' => 'fa fa-link', 'color' => 'success'];

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
        $details = DB::table('csv_payment_file_details')
            ->where('id', $id)
            ->first();
        $fault = DB::table('vacancy_apply')
            ->where([['paid_receipt_no', $details->receipt_number], ['token_number', '!=', (int) $details->token_number]])
            ->get();
        if ($fault->count() != 0) {
            DB::table('vacancy_apply')
                ->where([['paid_receipt_no', $details->receipt_number], ['token_number', '!=', (int) $details->token_number]])
                ->update([
                    "is_paid" => 0,
                    "total_paid_amount" => null,
                    "paid_receipt_no" => null,
                    "paid_date_ad" => null,
                    "paid_date_bs" => null,
                ]);
        }
    }
    // public function relink_after_edit($id){

    // }

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
        $details = DB::table('csv_payment_file_details')
            ->where('id', $id)
            ->first();

        DB::table('vacancy_apply')
            ->where('token_number', (int) $details->token_number)
            ->update([
                "is_paid" => 0,
                "total_paid_amount" => null,
                "paid_receipt_no" => null,
                "paid_date_ad" => null,
                "paid_date_bs" => null,
            ]);
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

    public function getEdit($id)
    {
        $this->cbLoader();
        $row = DB::table($this->table)->where($this->primary_key, $id)->first();
        $usr = DB::table("cms_users")->where("id", $row->importer_user_id)->first();
        if (isset($usr)) {
            $row->importer_user = $usr->name;
        }
        if (!CRUDBooster::isRead() && $this->global_privilege == false || $this->button_edit == false) {
            CRUDBooster::insertLog(trans("crudbooster.log_try_edit", ['name' => $row->{$this->title_field}, 'module' => CRUDBooster::getCurrentModule()->name]));
            CRUDBooster::redirect(CRUDBooster::adminPath(), trans('crudbooster.denied_access'));
        }

        $page_menu = Route::getCurrentRoute()->getActionName();
        $page_title = trans("crudbooster.edit_data_page_title", ['module' => CRUDBooster::getCurrentModule()->name, 'name' => $row->{$this->title_field}]);
        $command = 'edit';
        Session::put('current_row_id', $id);
        $isApplicant = false;
        if (Session::get('is_applicant') == 1) {
            $isApplicant = true;
        }
        //return view('crudbooster::default.form',compact('id','row','page_menu','page_title','command'));
        //$row["link_email_log_path"]= Storage::url($row["link_email_log_path"]);

        // $atag = '<a href="'.Storage::url($row->link_email_log_path).'" target=_blank>Email Log</a>';
        // $this->form[] = ["label"=>"Email Log","name"=>"link_email_log_path","type"=>"custom-c","required"=>TRUE,"html"=>$atag,'cmp-ratio'=>'6:4:8'];

        return view($this->getEdit_view, compact('id', 'row', 'page_menu', 'page_title', 'command', 'isApplicant'));
    }

    //By the way, you can still create your own method in here... :)
    public function postEditSave($id)
    {
        $this->hide_form = ["importer_user"];
        return parent::postEditSave($id);
    }
}
