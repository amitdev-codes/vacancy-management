<?php namespace App\Http\Controllers;

class AdminMstWorkLevelController extends BaseCBController
{

    public function cbInit()
    {
        # START CONFIGURATION DO NOT REMOVE THIS LINE
        $this->table = "mst_work_level";

        $this->title_field = "id";
        $this->limit = 20;
        $this->orderby = "code,asc";
        $this->show_numbering = true;
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
        $this->button_bulk_action = false;
        # END CONFIGURATION DO NOT REMOVE THIS LINE

        # START COLUMNS DO NOT REMOVE THIS LINE
        $this->col = [];
        $this->col[] = ["label" => "Code", "name" => "code"];
        $this->col[] = ["label" => "Work Level", "name" => "name_en"];
        // $this->col[] = ["label" => "तह", "name" => "name_np"];
        $this->col[] = ["label" => "Min Age", "name" => "min_age"];
        $this->col[] = ["label" => "Max Age", "name" => "max_age"];
        $this->col[] = ["label" => "Application Rate", "name" => "application_rate"];
        $this->col[] = ["label" => "Privileged Group Rate", "name" => "privileged_group_rate"];
        $this->col[] = ["label" => "Extended Rate", "name" => "ext_rate"];
        $this->col[] = ["label" => "Extended Rate (Priv. Grp)", "name" => "ext_priv_rate"];
        $this->col[] = ["label" => "Internal Application Rate", "name" => "internal_application_rate"];
        $this->col[] = ["label" => "Internal Priv Group Rate", "name" => "internal_privileged_group_rate"];
        $this->col[] = ["label" => "Internal Ext Rate", "name" => "internal_ext_rate"];
        $this->col[] = ["label" => "Internal Ext Priv Rate", "name" => "internal_ext_priv_rate"];
        # END COLUMNS DO NOT REMOVE THIS LINE
        # START FORM DO NOT REMOVE THIS LINE
        $this->form = [];
        $this->form[] = ['label' => 'Code', 'name' => 'code', 'type' => 'text-c', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10', 'cmp-ratio' => '4:12:12'];
        $this->form[] = ['label' => 'तह', 'name' => 'name_np', 'type' => 'text-c', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10', 'cmp-ratio' => '4:12:12'];
        $this->form[] = ['label' => 'level', 'name' => 'name_en', 'type' => 'text-c', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10', 'cmp-ratio' => '4:12:12'];
        $this->form[] = ['label' => 'Min Age', 'name' => 'min_age', 'type' => 'number-c', 'validation' => 'required|numeric|min:1', 'width' => 'col-sm-10', 'cmp-ratio' => '4:12:12'];
        $this->form[] = ['label' => 'Max Age', 'name' => 'max_age', 'type' => 'number-c', 'validation' => 'required|numeric|max:100', 'width' => 'col-sm-10', 'cmp-ratio' => '4:12:12'];
        $this->form[] = ['label' => 'Application Rate', 'name' => 'application_rate', 'type' => 'text-c', 'validation' => 'numeric|min:1', 'width' => 'col-sm-10', 'cmp-ratio' => '4:12:12'];
        $this->form[] = ['label' => 'Privileged Group Rate', 'name' => 'privileged_group_rate', 'type' => 'text-c', 'validation' => 'numeric|min:1', 'width' => 'col-sm-10', 'cmp-ratio' => '4:12:12'];
        $this->form[] = ['label' => 'Extended Rate', 'name' => 'ext_rate', 'type' => 'text-c', 'validation' => 'numeric|min:1', 'width' => 'col-sm-10', 'cmp-ratio' => '4:12:12'];
        $this->form[] = ['label' => 'Extended Rate (Priv. Group)', 'name' => 'ext_priv_rate', 'type' => 'text-c', 'validation' => 'numeric|min:1', 'width' => 'col-sm-10', 'cmp-ratio' => '4:12:12'];
        $this->form[] = ["label" => "Internal Application Rate", "name" => "internal_application_rate", 'type' => 'text-c', 'validation' => 'numeric|min:1', 'width' => 'col-sm-10', 'cmp-ratio' => '4:12:12'];
        $this->form[] = ["label" => "Internal Privileged Group Rate", "name" => "internal_privileged_group_rate", 'type' => 'text-c', 'validation' => 'numeric|min:1', 'width' => 'col-sm-10', 'cmp-ratio' => '4:12:12'];
        $this->form[] = ["label" => "Internal Ext Rate", "name" => "internal_ext_rate", 'type' => 'text-c', 'validation' => 'numeric|min:1', 'width' => 'col-sm-10', 'cmp-ratio' => '4:12:12'];
        $this->form[] = ["label" => "Internal Ext Rate (Priv. Group)", "name" => "internal_ext_priv_rate", 'type' => 'text-c', 'validation' => 'numeric|min:1', 'width' => 'col-sm-10', 'cmp-ratio' => '4:12:12'];

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
        // $query->orderBy(CAST(code AS UNSIGNED));
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
