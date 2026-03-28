<?php namespace App\Http\Controllers;

use App;
use App\Helpers\VAARS;
use App\Http\Controllers\BaseCBController;
use CRUDBooster;
use DB;
use File;
use Illuminate\Support\Facades\Session;
use Storage;


class AdminAdmitCardStatusController extends BaseCBController
{

    public function cbInit()
    {
        # START CONFIGURATION DO NOT REMOVE THIS LINE
        $this->table = "admit_card_status";
        $this->title_field = "id";
        $this->limit = 20;
        $this->orderby = "id,desc";
        $this->show_numbering = false;
        $this->global_privilege = false;
        $this->button_table_action = true;
        $this->button_action_style = "button_icon";
        $this->button_add = false;
        $this->button_delete = false;
        $this->button_edit = false;
        $this->button_detail = false;
        $this->button_show = true;
        $this->button_filter = true;
        $this->button_export = false;
        $this->button_import = false;
        $this->button_bulk_action = false;
        # END CONFIGURATION DO NOT REMOVE THIS LINE

        # START COLUMNS DO NOT REMOVE THIS LINE
        $this->col = array();
        $this->col[] = array("label" => "Vacancy Post Id", "name" => "vacancy_post_id", "join" => "vacancy_post,ad_no");
        $this->col[] = array("label" => "Token Number", "name" => "token_number");
        $this->col[] = array("label" => "Applicant Id", "name" => "applicant_id", "join" => "applicant_profile,id");
        $this->col[] = array("label" => "Html Path", "name" => "html_path");
        $this->col[] = array("label" => "Status", "name" => "status");

        # END COLUMNS DO NOT REMOVE THIS LINE
        # START FORM DO NOT REMOVE THIS LINE
        $this->form = [];
        $this->form[] = ["label" => "Vacancy Post Id", "name" => "vacancy_post_id", "type" => "select2", "required" => true, "validation" => "required|integer|min:0", "datatable" => "vacancy_post,ad_no"];
        $this->form[] = ["label" => "Token Number", "name" => "token_number", "type" => "number", "required" => true, "validation" => "required|integer|min:0"];
        $this->form[] = ["label" => "Applicant Id", "name" => "applicant_id", "type" => "select2", "required" => true, "validation" => "required|integer|min:0", "datatable" => "applicant,id"];
        $this->form[] = ["label" => "Html Path", "name" => "html_path", "type" => "text", "required" => true, "validation" => "required|min:1|max:255"];
        $this->form[] = ["label" => "Status", "name" => "status", "type" => "number", "required" => true, "validation" => "required|integer|min:0"];
        $this->form[] = ["label" => "Fiscal Year id", "name" => "fiscal_year_id", "type" => "select2", "required" => true, "value"=>Session::get('fiscal_year_id')];

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
        $this->addaction = array();
        $this->addaction[] = ['label' => 'Resend Mail', 'icon' => 'fa fa-home', 'color' => 'info', 'url' => CRUDBooster::mainpath('../exam/resendmail') . '/[id]'];
        $this->addaction[] = ['label' => 'Regenerate admit', 'icon' => 'fa fa-home', 'color' => 'success', 'url' => CRUDBooster::mainpath('../exam/pdfregenerate') . '/[id]'];

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

    public function resendMail($id)
    {
        $admitCardList = DB::table('admit_card_status')
            ->select('admit_card_status.*','vw_applicant_details.email as email','vw_applicant_details.applicant_name as applicant_name','mst_designation.name_en as name_en','vacancy_post.id as vacancy_post_id')
            ->leftJoin('vw_applicant_details', array('vw_applicant_details.applicant_id'=> 'admit_card_status.applicant_id'))
            ->leftJoin('vacancy_post', array('vacancy_post.id'=> 'admit_card_status.vacancy_post_id'))
            ->leftJoin('mst_designation', array('vacancy_post.designation_id'=> 'mst_designation.id'))
            ->where(array('admit_card_status.id'=>$id))
            ->first();
        // VAARS::sendApplicantEmail(array('to'=>$admitCardList->email, 'data'=>$admitCardList, 'template'=>'admit_card_email'));

        $admit_card_path = 'admit_card/' . $admitCardList->vacancy_post_id . "/" . $admitCardList->token_number . "_AdmitCard" . ".html";
        $admit_card_pdf_path = 'admit_card/' . $admitCardList->vacancy_post_id . "/" . $admitCardList->token_number . "_AdmitCard" . ".pdf";
        $files[] = public_path('pdf') . '/' . $admit_card_pdf_path;
        
        CRUDBooster::sendEmail(['to' =>$admitCardList->email,'data' => $admitCardList,'template' => 'admit_card_email','attachments'=>$files]);
        CRUDBooster::redirect(CRUDBooster::mainpath(), 'Mail will be sent soon.', 'success');
        // DB::table('admit_card_status')
        //     ->where('id', $id)
        //     ->update(['status' => 0]);
        // CRUDBooster::redirect(CRUDBooster::mainpath(), 'Mail will be sent soon.', 'success');
    }

    public function pdfRegenerate($id)
    {

        $admitIinfo = DB::table('admit_card_status')
            ->where('id', $id)
            ->first();
        // $admit_card_path = $admitIinfo->html_path;
        // $admit_card_pdf_path = 'admit_card/' . $admitIinfo->vacancy_post_id . "/" . $admitIinfo->token_number . "_AdmitCard" . ".pdf";
          
        // $file_pdf = public_path('pdf') . '/' . $admit_card_pdf_path;
        // if (File::exists($file_pdf)){
        //      File::delete($file_pdf);
        // }
        // $html = url('/') . Storage::url($admit_card_path);
        // $pdf = App::make('snappy.pdf.wrapper');
        // $pdf->loadFile($html);
        // return $pdf->download($file_pdf);


        $admit_card_path=public_path('admitcard/'.$admitIinfo->vacancy_post_id. "/" . $admitIinfo->token_number . "_AdmitCard" . ".html");
        $url = $admit_card_path ;

        $path='admitcard/'.$admitIinfo->vacancy_post_id. "/" . $admitIinfo->token_number . "_AdmitCard" . ".html";
        $baseUrl = url('/');
        $admit_card_url=$baseUrl.'/'.$path;
        return redirect( $admit_card_url);

        $file = file_get_contents($url, true);
        $pdf = App::make('snappy.pdf.wrapper');
        $pdf->loadHTML($file);
        return $pdf->inline();



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
        $query->where('admit_card_status.fiscal_year_id', Session::get('fiscal_year_id'));

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
        $postdata['fiscal_year_id'] = Session::get('fiscal_year_id');

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

    //By the way, you can still create your own method in here... :)

}
