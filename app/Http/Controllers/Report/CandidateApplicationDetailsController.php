<?php

namespace App\Http\Controllers\Report;

use DB;
use Session;

class CandidateApplicationDetailsController extends \App\Http\Controllers\BaseCBController
{

    public function cbInit()
    {
        # START CONFIGURATION DO NOT REMOVE THIS LINE
        $this->table = "vacancy_post_paper";
        $this->title_field = "paper_name_en";
        $this->limit = 20;
        $this->orderby = "id,desc";
        $this->show_numbering = false;
        $this->global_privilege = false;
        $this->button_table_action = true;
        $this->button_action_style = "button_icon";
        $this->button_add = true;
        $this->button_delete = true;
        $this->button_edit = true;
        $this->button_detail = true;
        $this->button_show = true;
        $this->button_filter = true;
        $this->button_export = false;
        $this->button_import = false;
        $this->button_bulk_action = true;
        // $this->getIndex_view = "application_details.index";
        # END CONFIGURATION DO NOT REMOVE THIS LINE

        # START COLUMNS DO NOT REMOVE THIS LINE
        // $this->col = array();
        // $this->col[] = array("label"=>"Vacancy Post Id","name"=>"vacancy_post_id","join"=>"vacancy_post,ad_no");
        // $this->col[] = array("label"=>"Paper Name En","name"=>"paper_name_en" );
        // $this->col[] = array("label"=>"Paper Name Np","name"=>"paper_name_np" );
        // $this->col[] = array("label"=>"Remarks","name"=>"remarks" );

        # END COLUMNS DO NOT REMOVE THIS LINE
        # START FORM DO NOT REMOVE THIS LINE
        // $this->form = [];
        // $this->form[] = ["label"=>"Vacancy Post","name"=>"vacancy_post_id","type"=>"select2-c","cmp-ratio"=>"4:6:12","required"=>true,"validation"=>"","datatable"=>"vacancy_post,ad_no"];
        // $this->form[] = ["label"=>"Paper Name En","name"=>"paper_name_en","type"=>"text-c","cmp-ratio"=>"4:6:12","required"=>true,"validation"=>"required"];
        // $this->form[] = ["label"=>"Paper Name Np","name"=>"paper_name_np","type"=>"text-c","cmp-ratio"=>"4:6:12","required"=>true,"validation"=>"required"];
        // $this->form[] = ["label"=>"Remarks","name"=>"remarks","type"=>"wysiwyg-c","cmp-ratio"=>"12:12:12","required"=>false,"validation"=>"string|min:5|max:5000"];

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
        $this->script_js = "";

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

    public function getIndex()
    {
        $data = [];
        $data['page_title'] = 'Candidate Application Details';
        $data['adno_data'] = $this->getVacancyAdNo();

        $this->cbView('application_details.index', $data);
    }

    public function getVacancyAdNo()
    {
        $fiscal_year_id = Session::get('fiscal_year_id');
        $adno_data = DB::table('vacancy_ad')->select('id', 'ad_title_en')->where([['opening_type_id', 1], ['fiscal_year_id', $fiscal_year_id], ['is_deleted', false]])->get();
        return $adno_data;
    }

    public function getDesignation($id)
    {
        $this->ad_id = $id;
        $desination_data = DB::select('SELECT d.name_en as designation,d.id,vp.id as post_id from vacancy_post vp
        LEFT JOIN mst_designation d on d.id = vp.designation_id
        where vacancy_ad_id =:id', ['id' => $id]);

        return $desination_data;
    }

    public function getDesignationView($id)
    {
        $data = [];
        $data['designation_data'] = $this->getDesignation($id);
        $data['adno_data'] = $this->getVacancyAdNo();
        $data['id'] = $id;
        $data['ad_id'] = $id;
        $this->ad_id = $id;
        $this->cbView('application_details.index', $data);
    }

    public function getCandidates($id)
    {
        $data = [];
        $candidate_data = DB::select('SELECT
        ap.is_nt_staff,
        ap.mobile_no,
        ap.email,
        va.token_number,
        va.total_amount,
        va.total_paid_amount,
        va.is_open,
        va.is_janajati,
        va.is_madhesi,
        va.is_female,
        va.is_dalit,
        va.is_remote_village,
        va.paid_date_bs
    FROM
        vacancy_apply AS va
        LEFT JOIN applicant_profile ap ON ap.id = va.applicant_id
        LEFT JOIN mst_designation d ON d.id = va.designation_id
    WHERE
        d.id =:id', ['id' => $id]);

        $intro_data = DB::select('SELECT
	va.notice_no,
	va.ad_title_en,
	vp.designation_id,
	wl.name_en AS work_level,
	md.name_en AS designation,
	vp.total_req_seats,
	vp.open_seats,
	vp.mahila_seats,
	vp.madheshi_seats,
	vp.janajati_seats,
	vp.remote_seats,
	vp.apanga_seats,
	vp.dalit_seats
FROM
	vacancy_post vp
	LEFT JOIN vacancy_ad va ON va.id = vp.vacancy_ad_id
	LEFT JOIN mst_designation md ON md.id = vp.designation_id
	LEFT JOIN mst_work_level wl ON wl.id = md.work_level_id
WHERE
	vp.designation_id =:id', ['id' => $id]);

        $data['adno_data'] = $this->getVacancyAdNo();
        $data['intro_data'] = $intro_data;
        $data['candidate_data'] = $candidate_data;

        $this->cbView('application_details.index', $data);
    }
}
