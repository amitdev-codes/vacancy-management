<?php

namespace App\Http\Controllers;

use CRUDBooster;
use Session;

class AdminVacancyAdController extends BaseCBController
// class AdminVacancyAdController extends \crocodicstudio\crudbooster\controllers\CBController

{

    public function cbInit()
    {

        # START CONFIGURATION DO NOT REMOVE THIS LINE
        $this->title_field = "id";
        $this->limit = "200";
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
        $this->button_export = false;
        $this->table = "vacancy_ad";
        $this->getIndex_view = "crudbooster::default.index";
        # END CONFIGURATION DO NOT REMOVE THIS LINE

        # START COLUMNS DO NOT REMOVE THIS LINE
        $this->col = [];
        $this->col[] = ["label" => "Ad Title", "name" => "ad_title_en"];
        $this->col[] = ["label" => "Fiscal Year", "name" => "fiscal_year_id", "join" => "mst_fiscal_year,code"];
        $this->col[] = ["label" => "Notice No.", "name" => "notice_no"];

        $this->col[] = ["label" => "Published Date", "name" => "trim(concat(date_to_publish_ad,' A.D.</br>', date_to_publish_bs,' B.S.')) as date_to_publish_ad"];
        // $this->col[] = ["label"=>"Date To Publish Bs","name"=>"date_to_publish_bs"];
        $this->col[] = ["label" => "Last Date", "name" => "trim(concat(last_date_for_application_ad,' A.D.</br>', last_date_for_application_bs,' B.S.')) as last_date_for_application_ad"];
        // $this->col[] = ["label"=>"Last Date For Application AD","name"=>"last_date_for_application_ad"];
        // $this->col[] = ["label"=>"Last Date For Application BS","name"=>"last_date_for_application_bs"];
        $this->col[] = ["label" => "Extended Date", "name" => "trim(concat(vacancy_extended_date_ad,' A.D.</br>', vacancy_extended_date_bs,' B.S.')) as vacancy_extended_date_ad"];

        $this->col[] = ["label" => "Opening Type", "name" => "opening_type_id", 'join' => 'mst_job_opening_type,name_en'];
        $this->col[] = ["label" => "Is Published", "name" => "case when is_published = 1 then 'YES' ELSE 'NO' END as is_published"];
        // $this->col[] = ["label"=>"Pdf Upload","name"=>"pdf_upload","callback"=>function($row) { return "<a data-lightbox='roadtrip' id='apdf'  href='".$row->pdf_upload."'><img style='max-width:150px' title='Image For Pdf Upload' src='".$row->pdf_upload."'>".$row->pdf_upload."</a>";}];

        $this->col[] = ["label" => "Pdf Upload", "name" => "pdf_upload", "callback" => function ($row) {return "<a target='_blank' href='/" . $row->pdf_upload . "'>" . $row->pdf_upload . "</a>";}];

        # END COLUMNS DO NOT REMOVE THIS LINE

        # START FORM DO NOT REMOVE THIS LINE
        $this->form = [];
        $this->form[] = ['label' => 'Notice No.', 'name' => 'notice_no', 'type' => 'number-c', 'validation' => 'required|numeric|min:1', 'cmp-ratio' => '3:12:12'];
        $this->form[] = ['label' => 'Fiscal Year', 'name' => 'fiscal_year_id', 'type' => 'select-c', 'validation' => 'required', 'cmp-ratio' => '3:12:12', "dataquery" => "SELECT id as value, code AS label FROM mst_fiscal_year ORDER BY id desc"];
        $this->form[] = ['label' => 'Opening Type', 'name' => 'opening_type_id', 'type' => 'select2-c', 'validation' => 'required|min:1|max:255', 'cmp-ratio' => '3:12:12', 'datatable' => 'mst_job_opening_type,name_en'];
        $this->form[] = ['label' => 'Is Published', 'name' => 'is_published', 'type' => 'radio-c', 'validation' => 'required', 'dataenum' => '0|No;1|Yes', 'cmp-ratio' => '3:12:12'];
        $this->form[] = ['label' => 'Title Nepali', 'placeholder' => 'Nepali', 'name' => 'ad_title_en', 'type' => 'text-c', 'validation' => '', 'cmp-ratio' => '6:9:12'];
        $this->form[] = ['label' => 'Title English', 'placeholder' => 'English', 'name' => 'ad_title_en', 'type' => 'text-c', 'validation' => '', 'cmp-ratio' => '6:9:12'];
        $this->form[] = ['label' => 'Published Date BS', 'name' => 'date_to_publish_bs', 'type' => 'date-n', 'validation' => 'required', 'cmp-ratio' => '3:8:12'];
        $this->form[] = ['label' => 'Published Date AD', 'name' => 'date_to_publish_ad', 'type' => 'date-c', 'validation' => 'date', 'cmp-ratio' => '3:8:12'];
        $this->form[] = ['label' => 'Last Date BS', 'name' => 'last_date_for_application_bs', 'type' => 'date-n', 'validation' => 'required', 'cmp-ratio' => '3:11:12'];
        $this->form[] = ['label' => 'Last Date AD', 'name' => 'last_date_for_application_ad', 'type' => 'date-c', 'validation' => 'date', 'cmp-ratio' => '3:11:12'];
        $this->form[] = ['label' => 'Extended Date BS', 'name' => 'vacancy_extended_date_bs', 'type' => 'date-n', 'validation' => '', 'cmp-ratio' => '6:12:12'];
        $this->form[] = ['label' => 'Extended Date AD', 'name' => 'vacancy_extended_date_ad', 'type' => 'date-c', 'validation' => '', 'cmp-ratio' => '6:12:12'];
        $this->form[] = ['label' => 'Start Date BS', 'name' => 'exam_start_date_bs', 'type' => 'date-n', 'validation' => '', 'cmp-ratio' => '3:7:12'];
        $this->form[] = ['label' => 'Start Date AD', 'name' => 'exam_start_date_ad', 'type' => 'date-c', 'validation' => '', 'cmp-ratio' => '3:7:12'];
        $this->form[] = ['label' => 'End Date BS', 'name' => 'exam_end_date_bs', 'type' => 'date-n', 'validation' => '', 'cmp-ratio' => '3:7:12'];
        $this->form[] = ['label' => 'End Date AD', 'name' => 'exam_end_date_ad', 'type' => 'date-c', 'validation' => '', 'cmp-ratio' => '3:7:12'];
        $this->form[] = ['label' => 'Start Date BS', 'name' => 'interview_start_date_bs', 'type' => 'date-n', 'validation' => '', 'cmp-ratio' => '3:7:12'];
        $this->form[] = ['label' => 'Start Date AD', 'name' => 'interview_start_date_ad', 'type' => 'date-c', 'validation' => '', 'cmp-ratio' => '3:7:12'];
        $this->form[] = ['label' => 'End Date BS', 'name' => 'interview_end_date_bs', 'type' => 'date-n', 'validation' => '', 'cmp-ratio' => '3:7:12'];
        $this->form[] = ['label' => 'End Date AD', 'name' => 'interview_end_date_ad', 'type' => 'date-c', 'validation' => '', 'cmp-ratio' => '3:7:12'];
        $this->form[] = ['label' => 'Pdf Upload', 'name' => 'pdf_upload', 'type' => 'upload-c', 'validation' => 'required|image|max:2000', 'cmp-ratio' => '3:6:12', 'help' => 'File type: JPG, JPEG, PNG, GIF, BMP', 'upload_encrypt' => 'true'];
        //$this->form[] = ['label'=>'Remarks','name'=>'remarks','type'=>'textarea-c','validation'=>'string|min:5|max:5000','cmp-ratio'=>'4:12:8'];

        # END FORM DO NOT REMOVE THIS LINE

        if ($this->is_detail) {

            $columns = [];
            $columns[] = ['label' => 'Ad No', 'name' => 'ad_no', 'type' => 'text', 'validation' => '', 'width' => 'col-sm-10'];
            $columns[] = ['label' => 'Designation', 'name' => 'designation_id', 'type' => 'datamodal', 'datamodal_table' => 'mst_designation', 'datamodal_columns' => 'name_en,name_np', 'datamodal_select_to' => 'name_en:name_en', 'datamodal_where' => '', 'datamodal_size' => 'large'];
            //$columns[] = ['label'=>'Work Level','name'=>'work_level_id','type'=>'datamodal','datamodal_table'=>'mst_work_level','datamodal_columns'=>'name_en','datamodal_select_to'=>'name_en:name_en','datamodal_where'=>'','datamodal_size'=>'large'];
            //$columns[] = ['label'=>'Work Service','name'=>'work_service_id','type'=>'datamodal','datamodal_table'=>'mst_work_service','datamodal_columns'=>'name_en','datamodal_select_to'=>'name_en:name_en','datamodal_where'=>'','datamodal_size'=>'large'];
            $columns[] = ['label' => 'Total Req Seats', 'name' => 'total_req_seats', 'type' => 'number', 'validation' => 'numeric|min:1', 'width' => 'col-sm-10'];
            $columns[] = ['label' => 'Open Seats', 'name' => 'open_seats', 'type' => 'number', 'validation' => 'integer|min:0', 'width' => 'col-sm-10'];
            $columns[] = ['label' => 'Mahila Seats', 'name' => 'mahila_seats', 'type' => 'number', 'validation' => 'integer|min:0', 'width' => 'col-sm-10'];
            $columns[] = ['label' => 'Janajati Seats', 'name' => 'janajati_seats', 'type' => 'number', 'validation' => 'numeric|min:1', 'width' => 'col-sm-10'];
            $columns[] = ['label' => 'Madheshi Seats', 'name' => 'madheshi_seats', 'type' => 'number', 'validation' => 'numeric|min:1', 'width' => 'col-sm-10'];
            $columns[] = ['label' => 'Dalit Seats', 'name' => 'dalit_seats', 'type' => 'number', 'validation' => 'numeric|min:1', 'width' => 'col-sm-10'];
            $columns[] = ['label' => 'Apanga Seats', 'name' => 'apanga_seats', 'type' => 'number', 'validation' => 'numeric|min:1', 'width' => 'col-sm-10'];
            $columns[] = ['label' => 'Remarks', 'name' => 'remarks', 'type' => 'textarea', 'validation' => 'required|string|min:5|max:5000', 'width' => 'col-sm-10'];
            $this->form[] = ['label' => 'Vacancy Post', 'name' => 'vacancy_post', 'type' => 'child', 'columns' => $columns, 'table' => 'vacancy_post', 'foreign_key' => 'vacancy_ad_id', "callback_php" => 'CRUDBooster::isView()'];
        }

        # OLD END FORM

        # OLD START FORM
        //$this->form = [];
        //$this->form[] = ["label"=>"Date To Publish Ad","name"=>"date_to_publish_ad","type"=>"date","required"=>TRUE,"validation"=>"required|date"];
        //$this->form[] = ["label"=>"Date To Publish Bs","name"=>"date_to_publish_bs","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Last Date For Application Ad","name"=>"last_date_for_application_ad","type"=>"date","required"=>TRUE,"validation"=>"required|date"];
        //$this->form[] = ["label"=>"Last Date For Application Bs","name"=>"last_date_for_application_bs","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Pdf Upload","name"=>"pdf_upload","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Opening Type Id","name"=>"opening_type_id","type"=>"select2","required"=>TRUE,"validation"=>"required|min:1|max:255","datatable"=>"opening_type,id"];
        //$this->form[] = ["label"=>"Is Published","name"=>"is_published","type"=>"radio","required"=>TRUE,"validation"=>"required|integer","dataenum"=>"Array"];
        //$this->form[] = ["label"=>"Remarks","name"=>"remarks","type"=>"textarea","required"=>TRUE,"validation"=>"required|string|min:5|max:5000"];
        # OLD END FORM

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

        // $user=CRUDBooster::first("cms_users", Session::get("admin_id"));
        // if (isset($user)) {
        //     if ($user->id_cms_privileges == 4) {
        //         $this->addaction[] = ['label'=>'Apply','icon'=>'fa fa-check-circle','color'=>'warning','url'=>CRUDBooster::mainpath('../vacancy_apply/add').'/[id]'];
        //     }
        // }

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
        //  $this->table_row_color[] = ['condition'=>"[is_published] == '1'","color"=>"sucecss"];

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
        $this->script_js = "
			$(document).ready(function(){
            $('#date_to_publish_ad').change(function(){
                convertAdtoBs('#date_to_publish_ad','#date_to_publish_bs');
            });
                $('#date_to_publish_bs').change(function(){
                         convertBstoAd('#date_to_publish_bs','#date_to_publish_ad');
                 });

                  $('#last_date_for_application_ad').change(function(){
                convertAdtoBs('#last_date_for_application_ad','#last_date_for_application_bs');
            });
                $('#last_date_for_application_bs').change(function(){
                         convertBstoAd('#last_date_for_application_bs','#last_date_for_application_ad');
                 });
				  $('#exam_start_date_ad').change(function(){
                convertAdtoBs('#exam_start_date_ad','#exam_start_date_bs');
                });
				$('#exam_start_date_bs').change(function(){
                         convertBstoAd('#exam_start_date_bs','#exam_start_date_ad');
                 });
				   $('#interview_start_date_ad').change(function(){
                convertAdtoBs('#interview_start_date_ad','#interview_start_date_bs');
                });
				$('#interview_start_date_bs').change(function(){
                         convertBstoAd('#interview_start_date_bs','#interview_start_date_ad');
                 });
				   $('#exam_end_date_ad').change(function(){
                convertAdtoBs('#exam_end_date_ad','#exam_end_date_bs');
                });
				$('#exam_end_date_bs').change(function(){
                         convertBstoAd('#exam_end_date_bs','#exam_end_date_ad');
                 });

				  $('#interview_end_date_ad').change(function(){
                convertAdtoBs('#interview_end_date_ad','#interview_end_date_bs');
                });
				$('#interview_end_date_bs').change(function(){
                         convertBstoAd('#interview_end_date_bs','#interview_end_date_ad');
                 });
				  $('#vacancy_extended_date_ad').change(function(){
                convertAdtoBs('#vacancy_extended_date_ad','#vacancy_extended_date_bs');
                });
				$('#vacancy_extended_date_bs').change(function(){
                         convertBstoAd('#vacancy_extended_date_bs','#vacancy_extended_date_ad');
                 });
            });
			";

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
        $this->load_js[] = asset("js/vacancy.js");

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
        $query->where([['vacancy_ad.fiscal_year_id', Session::get('fiscal_year_id')], ['vacancy_ad.is_deleted', 0]]);
        // $query->where('vacancy_ad.is_deleted',0);
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
        $date_to_publish_bs = $postdata['date_to_publish_bs'];
        $pub_bs = strtotime($date_to_publish_bs);
        $last_date_for_application_bs = $postdata['last_date_for_application_bs'];
        $last_bs = strtotime($last_date_for_application_bs);
        $vacancy_extended_date_bs = $postdata['vacancy_extended_date_bs'];
        $ext_bs = strtotime($vacancy_extended_date_bs);
        if ($pub_bs > $last_bs) {
            $msg = " Last Date must be greater than Publish Date";
        } else if ($last_bs > $ext_bs || $pub_bs > $ext_bs) {
            $msg = "Extended Date must be Greater than Last Date & Publish Date";
        } else {
            $msg = 'ok';
        }
        $exam_start_date_bs = $postdata['exam_start_date_bs'];
        $exam_start = strtotime($exam_start_date_bs);
        $exam_end_date_bs = $postdata['exam_end_date_bs'];
        $exam_end = strtotime($exam_end_date_bs);
        if ($exam_start > $exam_end) {
            $msg = " Exam End Date must be greater than Exam Start Date";
        }

        $interview_start_date_bs = $postdata['interview_start_date_bs'];
        $interview_start = strtotime($interview_start_date_bs);
        $interview_end_date_bs = $postdata['interview_end_date_bs'];
        $interview_end = strtotime($interview_end_date_bs);
        if ($interview_start > $interview_end) {
            $msg = " Interview End Date must be greater than Interview Start Date";
        }

        if ($msg != 'ok') {
            CRUDBooster::redirect('app/vacancy_ad/add/' . $id, $msg, 'warning');
        }
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

        $date_to_publish_bs = $postdata['date_to_publish_bs'];
        $pub_bs = strtotime($date_to_publish_bs);
        $last_date_for_application_bs = $postdata['last_date_for_application_bs'];
        $last_bs = strtotime($last_date_for_application_bs);
        $vacancy_extended_date_bs = $postdata['vacancy_extended_date_bs'];
        $ext_bs = strtotime($vacancy_extended_date_bs);
        if ($pub_bs > $last_bs) {
            $msg = "Last Date must be greater than Publish Date";
        } else if ($last_bs > $ext_bs || $pub_bs > $ext_bs) {
            $msg = "Extended Date must be Greater than Last Date & Publish Date";
        } else {
            $msg = 'ok';
        }
        $exam_start_date_bs = $postdata['exam_start_date_bs'];
        $exam_start = strtotime($exam_start_date_bs);
        $exam_end_date_bs = $postdata['exam_end_date_bs'];
        $exam_end = strtotime($exam_end_date_bs);
        if ($exam_start > $exam_end) {
            $msg = " Exam End Date must be greater than Exam Start Date";
        }

        $interview_start_date_bs = $postdata['interview_start_date_bs'];
        $interview_start = strtotime($interview_start_date_bs);
        $interview_end_date_bs = $postdata['interview_end_date_bs'];
        $interview_end = strtotime($interview_end_date_bs);
        if ($interview_start > $interview_end) {
            $msg = " Interview End Date must be greater than Interview Start Date";
        }

        if ($msg != 'ok') {
            CRUDBooster::redirect('app/vacancy_ad/edit/' . $id, $msg, 'warning');
        }
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
