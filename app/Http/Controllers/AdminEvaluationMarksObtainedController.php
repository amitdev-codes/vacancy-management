<?php namespace App\Http\Controllers;

use CRUDBooster;

class AdminEvaluationMarksObtainedController extends BaseCBController
{

    public function cbInit()
    {

        # START CONFIGURATION DO NOT REMOVE THIS LINE
        $this->title_field = "id";
        $this->limit = "20";
        $this->orderby = "id,desc";
        $this->global_privilege = false;
        $this->button_table_action = true;
        $this->button_bulk_action = false;
        $this->button_action_style = "button_icon";
        $this->button_add = false;
        $this->button_edit = false;
        $this->button_delete = false;
        $this->button_detail = false;
        $this->button_show = true;
        $this->button_filter = true;
        $this->button_import = false;
        $this->button_export = false;
        $this->table = "applicant_evaluation_marks"; //"evaluation_marks_obtained";
        # END CONFIGURATION DO NOT REMOVE THIS LINE
        //$this->col[] = ["label"=>"Designation","name"=>"designation_id","join"=>"mst_designation,name_en"];
        # START COLUMNS DO NOT REMOVE THIS LINE
        $this->col = [];
        $this->col[] = ["label" => "Staff Code", "name" => "applicant_id", "join" => "applicant_profile,nt_staff_code"];
        $this->col[] = ["label" => "token", "name" => "token_number", 'visible' => false];
        $this->col[] = ["label" => "Applicant Name", "name" => "trim(concat(upper(first_name_en), ' ', COALESCE(upper(mid_name_en),''), ' ', upper(last_name_en),'<br/>',first_name_np, ' ', COALESCE(mid_name_np,''), ' ', last_name_np)) as first_name_en"];
        $this->col[] = ["label" => "Seniority Points", "name" => "seniority_marks"];
        $this->col[] = ["label" => "Geographical Points", "name" => "geographical_marks"];
        // $this->col[] = ["label"=>"leave_marks","name"=>"leave_marks"];
        $this->col[] = ["label" => "Qualification Points", "name" => "qualification_marks"];
        $this->col[] = ["label" => "Office InCharge Points", "name" => "incharge_marks"];
        $this->col[] = ["label" => "Total Points", "name" => "total_marks"];

        # END COLUMNS DO NOT REMOVE THIS LINE

        # START FORM DO NOT REMOVE THIS LINE
        $this->form = [];
        $this->form[] = ['label' => 'Applicant Id', 'name' => 'applicant_id', 'type' => 'select2-c', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10', 'datatable' => 'applicant_profile,first_name_en', 'cmp-ratio' => '4:12:12'];
        $this->form[] = ['label' => 'Criteria Id', 'name' => 'criteria_id', 'type' => 'select2-c', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10', 'datatable' => 'mst_evaluation_criteria,name_en', 'cmp-ratio' => '4:12:12'];
        $this->form[] = ['label' => 'Marks Obtained', 'name' => 'marks_obtained', 'type' => 'number-c', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10', 'cmp-ratio' => '4:12:12'];
        $this->form[] = ['label' => 'Remarks', 'name' => 'remarks', 'type' => 'textarea-c', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10', 'cmp-ratio' => '4:12:12'];
        # END FORM DO NOT REMOVE THIS LINE

        # OLD START FORM
        //$this->form = [];
        //$this->form[] = ["label"=>"Applicant Id","name"=>"applicant_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"applicant,id"];
        //$this->form[] = ["label"=>"Criteria Id","name"=>"criteria_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"criteria,id"];
        //$this->form[] = ["label"=>"Marks Obtained","name"=>"marks_obtained","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
        //$this->form[] = ["label"=>"Remarks","name"=>"remarks","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
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
        // $this->addaction = array();
        // $this->addaction[] = ['label'=>'view','url'=>'/app/individual_evaluation/[token_number]','icon'=>'fa fa-check','color'=>'success'];

        //$app_id = DB::select( DB::raw("select applicant_id FROM applicant_evaluation_marks where id = .".[id].") );

        $this->addaction = array();
        $this->addaction[] = ['label' => 'view', 'url' => CRUDBooster::mainpath('../individual_evaluation/') . '[token_number]', 'icon' => 'fa fa-check', 'color' => 'success'];

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
        $this->index_button[] = ["label" => "Evaluate Points", "icon" => "fa fa-check", "url" => CRUDBooster::adminPath('evaluation'), 'color' => 'success'];

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
        // $query->where('total_marks','>','0');
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
