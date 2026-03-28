<?php namespace App\Http\Controllers;

class AdminErpServiceHistoryController extends BaseCBController
{

    public function cbInit()
    {
        # START CONFIGURATION DO NOT REMOVE THIS LINE
        $this->table = "erp_service_history";
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
        $this->button_detail = true;
        $this->button_show = true;
        $this->button_filter = true;
        $this->button_export = false;
        $this->button_import = false;
        $this->button_bulk_action = false;
        # END CONFIGURATION DO NOT REMOVE THIS LINE

        # START COLUMNS DO NOT REMOVE THIS LINE
        $this->col = array();
        $this->col[] = array("label" => "Emp No", "name" => "emp_no");
        // $this->col[] = array("label"=>"Date Of Birth","name"=>"date_of_birth" );
        // $this->col[] = array("label"=>"Sex","name"=>"sex" );
        // $this->col[] = array("label"=>"Join Date","name"=>"join_date" );
        // $this->col[] = array("label"=>"Prem Date","name"=>"prem_date" );
        $this->col[] = array("label" => "Start Date", "name" => "start_date");
        $this->col[] = array("label" => "End Date", "name" => "end_date");
        $this->col[] = array("label" => "Seniority Date", "name" => "seniority_Date");
        $this->col[] = array("label" => "Grade", "name" => "grade");
        $this->col[] = array("label" => "Job Id", "name" => "job_id", "join" => "erp_jobs,name");
        // $this->col[] = array("label"=>"Function","name"=>"function" );
        // $this->col[] = array("label"=>"Emp Category","name"=>"emp_category" );
        $this->col[] = array("label" => "Org Id", "name" => "org_id", "join" => "erp_organization,name");
        $this->col[] = array("label" => "Emp Type", "name" => "emp_type");
        // $this->col[] = array("label"=>"Reason","name"=>"reason" );
        $this->col[] = array("label" => "Incharge", "name" => "case when incharge = 1 then 'YES' ELSE 'NO' END as incharge");

        $this->col[] = array("label" => "Imported At", "name" => "imported_at");
        $this->col[] = array("label" => "Imported Mode", "name" => "imported_mode");
        $this->col[] = array("label" => "Imported By", "name" => "imported_by", "join" => "cms_users,email");
        $this->col[] = array("label" => "Erp File Uploads", "name" => "erp_file_uploads_id", "join" => "erp_file_uploads,id");

        # END COLUMNS DO NOT REMOVE THIS LINE

        # START FORM DO NOT REMOVE THIS LINE
        $this->form = [];
        $this->form[] = ["label" => "Emp No", "name" => "emp_no", "type" => "text-c", "required" => true, "validation" => "required|min:1|max:255", 'cmp-ratio' => '4:12:12'];
        $this->form[] = ["label" => "Date Of Birth", "name" => "date_of_birth", "type" => "date-c", "required" => true, "validation" => "required|date", 'cmp-ratio' => '4:12:12'];
        $this->form[] = ["label" => "Sex", "name" => "sex", "type" => "text-c", "required" => true, "validation" => "required|min:1|max:255", 'cmp-ratio' => '4:12:12'];
        $this->form[] = ["label" => "Join Date", "name" => "join_date", "type" => "date-c", "required" => true, "validation" => "required|date", 'cmp-ratio' => '4:12:12'];
        $this->form[] = ["label" => "Temp Date", "name" => "temp_date", "type" => "date-c", "required" => true, "validation" => "required|date", 'cmp-ratio' => '4:12:12'];
        $this->form[] = ["label" => "Prem Date", "name" => "prem_date", "type" => "date-c", "required" => true, "validation" => "required|date", 'cmp-ratio' => '4:12:12'];
        $this->form[] = ["label" => "Seniority Date", "name" => "seniority_Date", "type" => "date-c", "required" => true, "validation" => "required|date", 'cmp-ratio' => '4:12:12'];
        $this->form[] = ["label" => "Start Date", "name" => "start_date", "type" => "date-c", "required" => true, "validation" => "required|date", 'cmp-ratio' => '4:12:12'];
        $this->form[] = ["label" => "End Date", "name" => "end_date", "type" => "date-c", "required" => true, "validation" => "required|date", 'cmp-ratio' => '4:12:12'];
        $this->form[] = ["label" => "Grade", "name" => "grade", "type" => "number-c", "required" => true, "validation" => "required|integer|min:0", 'cmp-ratio' => '4:12:12'];
        $this->form[] = ["label" => "Job Id", "name" => "job_id", "type" => "select2-c", "required" => true, "validation" => "required|min:1|max:255", "datatable" => "erp_jobs,name", 'cmp-ratio' => '4:12:12'];
        $this->form[] = ["label" => "Function", "name" => "function", "type" => "text-c", "required" => true, "validation" => "required|min:1|max:255", 'cmp-ratio' => '4:12:12'];
        $this->form[] = ["label" => "Emp Category", "name" => "emp_category", "type" => "text-c", "required" => true, "validation" => "required|min:1|max:255", 'cmp-ratio' => '4:12:12'];
        $this->form[] = ["label" => "Org Id", "name" => "org_id", "type" => "select2-c", "required" => true, "validation" => "required|min:1|max:255", "datatable" => "erp_organization,name", 'cmp-ratio' => '4:12:12'];
        $this->form[] = ["label" => "Emp Type", "name" => "emp_type", "type" => "text-c", "required" => true, "validation" => "required|min:1|max:255", 'cmp-ratio' => '4:12:12'];
        $this->form[] = ["label" => "Reason", "name" => "reason", "type" => "text-c", "required" => true, "validation" => "required|min:1|max:255", 'cmp-ratio' => '4:12:12'];
        $this->form[] = ['label' => 'Incharge', 'name' => 'incharge', 'type' => 'radio-c', 'class' => 'incharge', 'cmp-ratio' => '4:12:12', 'dataenum' => '1|Yes ; 0|No', 'cmp-ratio' => '4:12:12'];

        //    $this->form[] = ["label"=>"Imported At","name"=>"imported_at","type"=>"datetime","required"=>TRUE,"validation"=>"required|date_format:Y-m-d H:i:s", 'cmp-ratio' => '4:12:12'];
        //    $this->form[] = ["label"=>"Imported Mode","name"=>"imported_mode","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255", 'cmp-ratio' => '4:12:12'];
        //    $this->form[] = ["label"=>"Importrd By","name"=>"importrd_by","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0", 'cmp-ratio' => '4:12:12'];

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
