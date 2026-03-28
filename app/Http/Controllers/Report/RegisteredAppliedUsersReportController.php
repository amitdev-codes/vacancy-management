<?php

namespace App\Http\Controllers\Report;

use Request;

class RegisteredAppliedUsersReportController extends ReportBaseController
{
    public function cbInit()
    {
        # START CONFIGURATION DO NOT REMOVE THIS LINE
        // $this->table               = "vacancy_apply";
        $this->report_name = "Registered Users and Applied Applicants Count";
        $this->title_field = "id";
        $this->limit = 10;
        $this->orderby = "work_level,desc";
        $this->show_numbering = true;
        $this->global_privilege = false;
        $this->button_table_action = true;
        $this->button_action_style = "button_icon";
        $this->button_add = false;
        $this->button_delete = false;
        $this->button_edit = false;
        $this->button_detail = true;
        $this->button_show = true;
        $this->button_filter = false;
        $this->button_export = true;
        $this->button_import = false;
        $this->button_bulk_action = false;

        # END CONFIGURATION DO NOT REMOVE THIS LINE
        // $this->table   = "vacancy_apply";
        $this->alias = "count_sql";
        $this->table = "(SELECT 1 id,
        vp.ad_no as ad_no,
        count(ap.id) AS users,
        count(va.id) AS applicants,
        sum(va.is_paid) as paid_applicants,
        COALESCE (d.name_en, 'NA') AS designation,va.designation_id as designation_id,
        COALESCE (l.name_en, 'NA') AS work_level,vacancy_ad_id
    FROM
        applicant_profile ap
    LEFT JOIN vacancy_apply va ON va.applicant_id = ap.id
    LEFT JOIN mst_designation d ON d.id = va.designation_id
    LEFT JOIN mst_work_level l ON l.id = d.work_level_id
    LEFT JOIN vacancy_post vp on vp.id = va.vacancy_post_id
    GROUP BY
        designation,
        work_level,designation_id,
        ad_no,vacancy_ad_id
        ) as count_sql";
        # START COLUMNS DO NOT REMOVE THIS LINE
        $this->col = array();
        $this->col[] = array("label" => "Work Level", "name" => "work_level");
        $this->col[] = array("label" => "Ad No.", "name" => "ad_no");
        $this->col[] = array("label" => "Designation", "name" => "designation");
        $this->col[] = array("label" => "Total Registered Users", "name" => "users");
        $this->col[] = array("label" => "Total Applied Applicants", "name" => "applicants");
        $this->col[] = array("label" => "Total Paid Applicants", "name" => "paid_applicants");
        // $this->col[] = array("label"=>"Open","name"=>"open");
        // $this->col[] = array("label"=>"Female","name"=>"female");
        // $this->col[] = array("label"=>"Dalit","name"=>"dalit");
        // $this->col[] = array("label"=>"Handicapped","name"=>"handicapped");
        // $this->col[] = array("label"=>"Madhesi","name"=>"madhesi");
        // $this->col[] = array("label"=>"Janajati","name"=>"janajati");
        // $this->col[] = array("label"=>"Remote Village","name"=>"remote_village");

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

        $ad_id = Request::get('ad');
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
}
