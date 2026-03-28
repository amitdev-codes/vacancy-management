<?php namespace App\Http\Controllers;

class AdminMstDesignationController extends BaseCBController
{

    public function cbInit()
    {

        # START CONFIGURATION DO NOT REMOVE THIS LINE
        $this->title_field = "name_en";
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
        $this->table = "mst_designation";
        // $this->getIndex_view = "default.index";
        # END CONFIGURATION DO NOT REMOVE THIS LINE

        # START COLUMNS DO NOT REMOVE THIS LINE
        $this->col = [];
        $this->col[] = ["label" => "Code", "name" => "code"];
        $this->col[] = ["label" => "Post/Designation", "name" => "name_en"];
        $this->col[] = ["label" => "पद", "name" => "name_np"];
        $this->col[] = ["label" => "Work Level", "name" => "work_level_id", "join" => "mst_work_level,name_en"];
        $this->col[] = ["label" => "Work Service", "name" => "work_service_id", "join" => "mst_work_service,name_en"];
        $this->col[] = ["label" => "Work Service Group", "name" => "service_group_id", "join" => "mst_work_service_group,name_en"];
        $this->col[] = ["label" => "Internal Experience", "name" => "internal_experience"];
        $this->col[] = ["label" => "External Experience", "name" => "external_experience"];

        //$this->col[] = ["label"=>"Degree","name"=>"allowed_degree","join"=>"mst_edu_level,name_en"];
        //$this->col[] = ["label"=>"Major Subjects","name"=>"allowed_major_subjects","join"=>"mst_edu_major,name_en"];
        $this->col[] = ["label" => "Council Registration", "name" => "case when is_council_reg_required = 1 then 'YES' ELSE 'NO' END as is_council_reg_required"];
        # END COLUMNS DO NOT REMOVE THIS LINE

        # START FORM DO NOT REMOVE THIS LINE

        $this->form = [];
        $this->form[] = ['label' => 'Code', 'name' => 'code', 'type' => 'text-c', 'validation' => 'required|min:1|max:255', 'cmp-ratio' => '4:7:12'];
        $this->form[] = ['label' => 'Name', 'name' => 'name_en', 'type' => 'text-c', 'validation' => 'required|min:1|max:255', 'cmp-ratio' => '4:7:12'];
        $this->form[] = ['label' => 'Name (Nepali)', 'name' => 'name_np', 'type' => 'text-c', 'validation' => 'required|min:1|max:255', 'cmp-ratio' => '4:7:12'];
        $this->form[] = ['label' => 'Work Level', 'name' => 'work_level_id', 'type' => 'select-c', 'validation' => 'required|min:1|max:255', 'cmp-ratio' => '4:7:12', 'dataquery' => 'SELECT id as value, CONCAT(code) AS label FROM mst_work_level'];
        $this->form[] = ['label' => 'Work Service', 'name' => 'work_service_id', 'type' => 'select-c', 'validation' => 'required|min:1|max:255', 'cmp-ratio' => '4:7:12', 'dataquery' => 'SELECT id as value, CONCAT(name_en, \' -  \', name_np) AS label FROM mst_work_service'];
        $this->form[] = ['label' => 'Work Service Group', 'name' => 'service_group_id', 'type' => 'select-c', 'validation' => 'required|min:1|max:255', 'cmp-ratio' => '4:7:12', 'dataquery' => 'SELECT id as value, CONCAT(name_en, \' - \', name_np) AS label FROM mst_work_service_group'];
        $this->form[] = ['label' => 'Council Registration', 'name' => 'is_council_reg_required', 'type' => 'radio-c', 'validation' => 'required', 'cmp-ratio' => '4:7:12', 'dataenum' => '1|Yes;0|No'];
        $this->form[] = ['label' => 'Council', 'name' => 'council_id', 'id' => 'council_id', 'type' => 'select-c', 'cmp-ratio' => '4:7:12', 'dataquery' => 'SELECT id as value,name_en AS label FROM mst_council'];
        $this->form[] = ['label' => 'PHD Candidate', 'name' => 'is_phd_candidate', 'type' => 'radio-c', 'validation' => 'required', 'cmp-ratio' => '4:7:12', 'dataenum' => '1|Yes;0|No'];
        // $this->form[] = ['label'=>'Required Work Experience (In Years)','name'=>'work_experience','type'=>'text-c','validation'=>'min:1|max:500','cmp-ratio'=>'4:6:12'];
        $this->form[] = ['label' => 'Work Experience For External Applicants (In Years)', 'name' => 'external_experience', 'type' => 'number-c', 'validation' => 'min:1|max:500', 'cmp-ratio' => '4:12:12'];
        $this->form[] = ['label' => 'Work Experience For NT Staff (In Years)', 'name' => 'internal_experience', 'type' => 'number-c', 'validation' => 'min:1|max:500', 'cmp-ratio' => '4:12:12'];

        // $this->form[] = ['label'=>'Degree','name'=>'degree','type'=>'select','datatable'=>'mst_edu_degree,name_en'];
        # END FORM DO NOT REMOVE THIS LINE

        $degree = [];
        //$columns[] = ['label'=>'Ad No','name'=>'ad_no','type'=>'text','validation'=>'','width'=>'col-sm-10'];
        // $degree[] = ['label'=>'Level','name'=>'edu_level','type'=>'select2','datatable'=>'mst_edu_level,name_en','datatable_where'=>'is_deleted != 1'];

        $degree[] = ['label' => 'Degree', 'name' => 'edu_degree_id', 'type' => 'datamodal', 'datamodal_table' => 'mst_edu_degree', 'datamodal_columns' => 'name_np', 'datamodal_select_to' => 'id:name_np', 'datamodal_where' => '', 'datamodal_size' => 'default'];
        $degree[] = ['label' => 'Is Training Required', 'name' => 'is_training_required', 'type' => 'radio', 'dataenum' => '0|Not Required ; 1|Required', 'value' => 'No'];
        $degree[] = ['label' => 'Is for External', 'name' => 'is_for_external', 'type' => 'radio', 'dataenum' => '0|No; 1|Yes', 'value' => 'No'];
        $degree[] = ['label' => 'Is for Internal', 'name' => 'is_for_internal', 'type' => 'radio', 'dataenum' => '0|No; 1|Yes', 'value' => 'No'];
        $degree[] = ['label' => 'Is Additional', 'name' => 'is_additional', 'type' => 'radio', 'dataenum' => '0|No; 1|Yes', 'value' => "No"];

        //$columns[] = ['label'=>'Discount','name'=>'discount','type'=>'number','required'=>true];
        //$columns[] = ['label'=>'Work Level','name'=>'work_level_id','type'=>'datamodal','datamodal_table'=>'mst_work_level','datamodal_columns'=>'name_en','datamodal_select_to'=>'name_en:name_en','datamodal_where'=>'','datamodal_size'=>'large'];
        //$columns[] = ['label'=>'Work Service','name'=>'work_service_id','type'=>'datamodal','datamodal_table'=>'mst_work_service','datamodal_columns'=>'name_en','datamodal_select_to'=>'name_en:name_en','datamodal_where'=>'','datamodal_size'=>'large'];
        $this->form[] = ['label' => 'Degree', 'name' => 'mst_designation_degree', 'type' => 'child', 'columns' => $degree, 'table' => 'mst_designation_degree', 'foreign_key' => 'mst_designation_degree.designation_id'];

        $eduMajor = [];
        $eduMajor[] = ['label' => 'Education Major', 'name' => 'edu_major_id', 'type' => 'datamodal', 'datamodal_table' => 'mst_edu_major', 'datamodal_columns' => 'name_np', 'datamodal_select_to' => 'id:name_np', 'datamodal_where' => '', 'datamodal_size' => 'default'];
        $this->form[] = ['label' => 'Education Major', 'name' => 'mst_designation_degree_major', 'type' => 'child', 'columns' => $eduMajor, 'table' => 'mst_designation_degree_major', 'foreign_key' => 'mst_designation_degree_major.designation_id'];

        $training = [];
        $training[] = ['label' => 'Training', 'name' => 'training_id', 'type' => 'datamodal', 'datamodal_table' => 'mst_training', 'datamodal_columns' => 'name_np', 'datamodal_select_to' => 'id:name_np', 'datamodal_where' => '', 'datamodal_size' => 'default'];
        $this->form[] = ['label' => 'Training', 'name' => 'mst_designation_training', 'type' => 'child', 'columns' => $training, 'table' => 'mst_designation_training', 'foreign_key' => 'mst_designation_training.designation_id'];

        $trainingMajor = [];
        $trainingMajor[] = ['label' => 'Training Major', 'name' => 'training_major_id', 'type' => 'datamodal', 'datamodal_table' => 'mst_training_major', 'datamodal_columns' => 'name_np', 'datamodal_select_to' => 'id:name_np', 'datamodal_where' => '', 'datamodal_size' => 'default'];
        $this->form[] = ['label' => 'Training Major', 'name' => 'mst_designation_training_major', 'type' => 'child', 'columns' => $trainingMajor, 'table' => 'mst_designation_training_major', 'foreign_key' => 'mst_designation_training_major.designation_id'];

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
        $this->script_js = "
        $(document).ready(function(){

            $('input[name=is_council_reg_required]').on('click',function(){
            debugger;
                    var council_reg = $(this).val();
                    // alert(council_reg);
                    if( council_reg == '1'){

                        $('#council_id').show();
                    } else {

                        $('#council_id').hide();
                    }

            })

            var council_reg = $('input[name=is_council_reg_required]:radio:checked').val();

                if( council_reg == '1'){

                    $('#council_id').show();
                } else {

                    $('#council_id').hide();
                }

            }) ";

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
