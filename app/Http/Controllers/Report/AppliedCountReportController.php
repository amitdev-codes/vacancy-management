<?php
namespace App\Http\Controllers\Report;

use Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AppliedCountReportController extends ReportBaseController
{
    public function cbInit()
    {
        # START CONFIGURATION DO NOT REMOVE THIS LINE
        // $this->table               = "vacancy_apply";
        $this->report_name = "Applied Applicants Count";
        $this->title_field = "id";
        $this->limit = 20;
        $this->orderby = "work_level_code,desc";
        $this->show_numbering = true;
        $this->global_privilege = false;
        $this->button_table_action = true;
        $this->button_action_style = "button_icon";
        $this->button_add = false;
        $this->button_delete = false;
        $this->button_edit = false;
        $this->button_detail = false;
        $this->button_show = true;
        $this->button_filter = true;
        $this->button_export = true;
        $this->button_import = false;
        $this->button_bulk_action = false;

        # END CONFIGURATION DO NOT REMOVE THIS LINE
        $ad_id = Request::get('ad');
        if ($ad_id == 4) {
            $this->table = "vw_applicants_count_file_promotion__";
        } else {
            $this->table = "vw_applicants_count";
        }
        // $this->alias = "count_sql";
        // $this->table = "(SELECT 1 id, count(1) as cnt,sum(is_cancelled) as cancelled,sum(is_rejected) as rejected,
        //         sum(case when total_paid_amount>0 then 1 else 0 end) as actual_pay,
        //         sum(case when paid='excess' then 1 else 0 end) as excess_pay,
        //         sum(case when paid='partial' then 1 else 0 end) as partial_pay,
        //         sum(case when paid='full' then 1 else 0 end) as full_pay,
        //         ad_no , work_level_code, designation_en,designation_id,vacancy_ad_id
        // FROM vw_vacancy_applicant
        // where is_cancelled = 0 or is_rejected = 0
        // GROUP BY ad_no,work_level_code, designation_en,designation_id,vacancy_ad_id) as count_sql";
        # START COLUMNS DO NOT REMOVE THIS LINE

        $this->col = array();
        $this->col[] = array("label" => "Level", "name" => "work_level_code");
        $this->col[] = array("label" => "Ad No", "name" => "ad_no");
        $this->col[] = array("label" => "Designation", "name" => "designation_en");
        $this->col[] = array("label" => "Total Applicants", "name" => "cnt");
        $this->col[] = array("label" => "Cancelled", "name" => "cancelled");
        $this->col[] = array("label" => "Rejected", "name" => "rejected");
        $this->col[] = array("label" => "Eligible", "name" => "eligible");
        $this->col[] = array("label" => "Paid Applicants", "name" => "actual_pay");
        $this->col[] = array("label" => "Full Payment", "name" => "full_pay");
        $this->col[] = array("label" => "Partial Payment", "name" => "partial_pay");
        $this->col[] = array("label" => "Excess Payment", "name" => "excess_pay");

        # END COLUMNS DO NOT REMOVE THIS LINE
        # START FORM DO NOT REMOVE THIS LINE
        $this->form = [];

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

        // $this->addaction[] = ['label'=>' ','icon'=>'fa fa-remove','confirmation'=>true,'confirmation_text'=>"Are you sure you want to cancel?","confirmation_title"=>"Cancel",'color'=>'danger','url'=>CRUDBooster::mainpath('../vacancy_apply_cancelation/edit').'/[id]','showIf'=>'[is_cancelled] == 0'];
        // $this->addaction[] = ['label'=>' ','icon'=>'fa fa-pencil','confirmation'=>true,'confirmation_text'=>"Are you sure you want to edit record?","confirmation_title"=>"Edit",'color'=>'warning','url'=>CRUDBooster::mainpath('../vacancy_apply/edit').'/[id]','showIf'=>'[is_cancelled] == 0'];
        // $this->addaction[] = ['label'=>' ','icon'=>'fa fa-eye','color'=>'primary','url'=>CRUDBooster::mainpath('../vacancy_apply/view').'/[id]'];
        // $this->addaction[] = ['label'=>' ','icon'=>'fa fa-user','color'=>'success','url'=>CRUDBooster::mainpath('../applicant_profile/edit').'/[applicant_id]'];
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
        $this->table_row_color[] = ['condition' => "[is_cancelled] == 1", "color" => "danger"];

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
            $('td:nth-child(15), th:nth-child(15)').hide();
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
        // dd('amit');
        //Your code here
        // $query->where('vw_vacancy_applicant.is_cancelled', 0);
        // $ad_id=Request::get('ad');
        // if($ad_id!=0){
        //     $ad=DB::table('vacancy_ad')->where('id',$ad_id);
        //     if($ad->count()==0){
        //     CRUDBooster::redirect(CRUDBooster::mainpath(),trans("Not any advertisement with that id."),'warning');
        //     }
        //     else{
        //     $query->where('vacancy_ad_id', $ad_id);
        //     }

        // }
        // else{
        //     $ad_id=DB::table('vacancy_ad')->max('id');
        //     $query->where('vacancy_ad_id', $ad_id);
        // }
        $opening_type=DB::table('vacancy_ad')->select('id','ad_title_en')->whereIs_deleted(false)->orderBy('id', 'ASC')->get();
        Session::put('opening_type', $opening_type);

        $privilege_group=DB::table('mst_privilege_group')->select('code','name_en')->whereIs_deleted(false)->orderBy('id', 'ASC')->get();
        Session::put('privilege_group', $privilege_group);

        $ad_id = Request::get('ad');

        //dd(Request::all());
        if ($ad_id != 0) {
            $md_id = Request::get('md');

        
            if ($md_id != 0) {
                $query->where([['vacancy_ad_id', $ad_id], ['designation_id', $md_id]])
                    ->orderby('ad_no');
            } else {
                $query->where('vacancy_ad_id', $ad_id)
                    ->orderby('ad_no');
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
