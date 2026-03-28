<?php namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Session;
use DB;
use Vinkla\Hashids\Facades\Hashids;
use crocodicstudio\crudbooster\helpers\CRUDBooster;
class AdminApplicantFamilyInfoController extends ApplicantCBController
{

    public function cbInit()
    {

        # START CONFIGURATION DO NOT REMOVE THIS LINE
        $this->title_field = "father_name_en";
        $this->limit = "20";
        $this->orderby = "id,desc";
        $this->global_privilege = false;
        $this->button_table_action = true;
        $this->button_bulk_action = true;
        $this->button_action_style = "button_icon";
        $this->button_add = true;
        $this->button_edit = true;
        $this->button_delete = true;
        $this->button_detail = true;
        $this->button_show = true;
        $this->button_filter = true;
        $this->button_import = false;
        $this->button_export = false;
        $this->table = "applicant_family_info";

        $va_id=Request::get('va_id');
        if($va_id){
            $this->getEdit_view = "appliedApplicants.family";
        }else{
            $this->getEdit_view = "applicantProfile.family";
        }



        # END CONFIGURATION DO NOT REMOVE THIS LINE

        # START COLUMNS DO NOT REMOVE THIS LINE
        $this->col = [];
        $this->col[] = ["label" => "Applicant", "name" => "applicant_id", "join" => "applicant_profile,first_name_en"];
        $this->col[] = ["label" => "Father's Name", "name" => "father_name_en"];
        $this->col[] = ["label" => "Mother's Name", "name" => "mother_name_en"];
        $this->col[] = ["label" => "Father's Occupation", "name" => "father_occupation"];
        $this->col[] = ["label" => "Father's Nationality", "name" => "father_nationality"];
        # END COLUMNS DO NOT REMOVE THIS LINE

        # START FORM DO NOT REMOVE THIS LINE
        $this->form = [];
        // $this->form[] = ['label'=>'Applicant Id','name'=>'applicant_id','type'=>'select-c','validation'=>'required|integer|min:0','cmp-ratio'=>'4:12:12',"dataquery"=>"SELECT id as value, CONCAT(first_name_en, '  ', mid_name_en, ' ', last_name_en) AS label FROM applicant_profile"];
        // $this->form[] = ['label' => '', "placeholder" => ' नाम ', 'name' => 'father_name_np', 'validation' => 'required', 'type' => 'text-c', 'cmp-ratio' => '3:12:12'];
        // $this->form[] = ['label' => '', "placeholder" => ' Name (English)', 'name' => 'father_name_en', 'validation' => 'required', 'type' => 'text-c', 'cmp-ratio' => '3:12:12'];
        // $this->form[] = ['label' => '‍‍‍‍‍‍‍‍‍‍', "placeholder" => ' Nationality', 'name' => 'father_nationality', 'type' => 'text-c', 'cmp-ratio' => '3:12:12'];
        // $this->form[] = ['label' => '‍‍','name' => 'father_occupation', 'type' => 'text-c', 'cmp-ratio' => '3:12:12'];
        // $this->form[] = ['label' => '', "placeholder" => ' नाम', 'name' => 'mother_name_np', 'type' => 'text-c', 'cmp-ratio' => '3:12:12'];
        // $this->form[] = ['label' => '', "placeholder" => ' Name (English)', 'name' => 'mother_name_en', 'type' => 'text-c', 'cmp-ratio' => '3:12:12'];
        // $this->form[] = ['label' => '', "placeholder" => ' Nationality', 'name' => 'mother_nationality', 'type' => 'text-c', 'cmp-ratio' => '3:12:12'];
        // $this->form[] = ['label' => '', "placeholder" => ' Occupation', 'name' => 'mother_occupation', 'type' => 'text-c', 'cmp-ratio' => '3:12:12'];
        // $this->form[] = ['label' => '', "placeholder" => ' नाम', 'name' => 'grand_father_name_np', 'validation' => 'required', 'type' => 'text-c', 'cmp-ratio' => '3:12:12'];
        // $this->form[] = ['label' => '', "placeholder" => ' Name (English)', 'name' => 'grand_father_name_en', 'validation' => 'required', 'type' => 'text-c', 'cmp-ratio' => '3:12:12'];
        // $this->form[] = ['label' => '‍‍', "placeholder" => ' Nationality', 'name' => 'grand_father_nationality', 'type' => 'text-c', 'cmp-ratio' => '3:12:12'];
        // $this->form[] = ['label' => '', "placeholder" => ' नाम', 'name' => 'spouse_name_np', 'type' => 'text-c', 'cmp-ratio' => '3:12:12'];
        // $this->form[] = ['label' => '', "placeholder" => ' Name (English)', 'name' => 'spouse_name_en', 'type' => 'text-c', 'cmp-ratio' => '3:12:12'];
        // $this->form[] = ['label' => '', "placeholder" => ' Nationality', 'name' => 'spouse_nationality', 'type' => 'text-c', 'cmp-ratio' => '3:12:12'];
        // $this->form[] = ['label' => '', "placeholder" => ' Occupation', 'name' => 'spouse_occupation', 'type' => 'text-c', 'cmp-ratio' => '3:12:12'];

        $this->form[] = ['label' => 'नाम (नेपालीमा)', 'name' => 'father_name_np', 'validation' => 'required', 'type' => 'text-c', 'cmp-ratio' => '3:12:12'];
        $this->form[] = ['label' => 'Name (In English)', 'name' => 'father_name_en', 'validation' => 'required', 'type' => 'text-c', 'cmp-ratio' => '3:12:12'];
        $this->form[] = ['label' => '‍‍‍‍‍‍‍‍‍‍Nationality', 'name' => 'father_nationality', 'type' => 'text-c', 'cmp-ratio' => '3:12:12'];
        $this->form[] = ['label' => '‍‍Occupation', 'name' => 'father_occupation', 'type' => 'text-c', 'cmp-ratio' => '3:12:12'];
        $this->form[] = ['label' => 'नाम (नेपालीमा)', 'name' => 'mother_name_np', 'validation' => 'required', 'type' => 'text-c', 'cmp-ratio' => '3:12:12'];
        $this->form[] = ['label' => 'Name (In English)', 'name' => 'mother_name_en', 'validation' => 'required', 'type' => 'text-c', 'cmp-ratio' => '3:12:12'];
        $this->form[] = ['label' => 'Nationality', 'name' => 'mother_nationality', 'type' => 'text-c', 'cmp-ratio' => '3:12:12'];
        $this->form[] = ['label' => 'Occupation', 'name' => 'mother_occupation', 'type' => 'text-c', 'cmp-ratio' => '3:12:12'];
        $this->form[] = ['label' => 'नाम (नेपालीमा)', 'name' => 'grand_father_name_np', 'validation' => 'required', 'type' => 'text-c', 'cmp-ratio' => '3:12:12'];
        $this->form[] = ['label' => 'Name (In English)', 'name' => 'grand_father_name_en', 'validation' => 'required', 'type' => 'text-c', 'cmp-ratio' => '3:12:12'];
        $this->form[] = ['label' => '‍‍Nationality', 'name' => 'grand_father_nationality', 'type' => 'text-c', 'cmp-ratio' => '3:12:12'];
        $this->form[] = ['label' => 'नाम (नेपालीमा)', 'name' => 'spouse_name_np', 'validation' => '', 'type' => 'text-c', 'cmp-ratio' => '3:12:12'];
        $this->form[] = ['label' => 'Name (In English)', 'name' => 'spouse_name_en', 'validation' => '', 'type' => 'text-c', 'cmp-ratio' => '3:12:12'];
        $this->form[] = ['label' => 'Nationality', 'name' => 'spouse_nationality', 'type' => 'text-c', 'cmp-ratio' => '3:12:12'];
        $this->form[] = ['label' => 'Occupation', 'name' => 'spouse_occupation', 'type' => 'text-c', 'cmp-ratio' => '3:12:12'];
        # END FORM DO NOT REMOVE THIS LINE

        # OLD START FORM
        //$this->form = [];
        //$this->form[] = ["label"=>"Applicant Id","name"=>"applicant_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"applicant,id"];
        //$this->form[] = ["label"=>"Father Name En","name"=>"father_name_en","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Father Name Np","name"=>"father_name_np","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Father Occupation","name"=>"father_occupation","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Father Nationality","name"=>"father_nationality","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Mother Name En","name"=>"mother_name_en","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Mother Name Np","name"=>"mother_name_np","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Mother Occupation","name"=>"mother_occupation","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Mother Nationality","name"=>"mother_nationality","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Grand Father Name En","name"=>"grand_father_name_en","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Grand Father Name Np","name"=>"grand_father_name_np","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Grand Father Nationality","name"=>"grand_father_nationality","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Spouse Name En","name"=>"spouse_name_en","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Spouse Name Np","name"=>"spouse_name_np","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Spouse Occupation","name"=>"spouse_occupation","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
        //$this->form[] = ["label"=>"Spouse Nationality","name"=>"spouse_nationality","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
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
        $this->load_js[] = asset("js/applicant.js");

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

     public function getEdit($id){

         // if(Session::get("is_applicant") ==1){
         //     $applicant_id = Session::get("applicant_id");
         //     $family = DB::table("applicant_family_info")->where("applicant_id", $applicant_id)->select("id")->first();
         //     return parent::getEdit($family->id);
         // }
         // else{
         //     return parent::getEdit($id);
         // }

             if(CRUDBooster::myPrivilegeId()===4){
             $applicant_id = CRUDBooster::myId();
             $family = DB::table("applicant_family_info")->where("applicant_id", $applicant_id)->select("id")->first();
             return parent::getEdit($family->id);
         }
         else{
             return parent::getEdit($id);
         }
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
        parent::hook_query_index($query);

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
        $encoded_applicant_id = Session::get('applicant_id');
        $applicant_id = Hashids::decode($encoded_applicant_id);
        $postdata['applicant_id'] = $applicant_id[0];
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
