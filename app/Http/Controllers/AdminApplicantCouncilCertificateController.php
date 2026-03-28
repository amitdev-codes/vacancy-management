<?php namespace App\Http\Controllers;

use CRUDBooster;
use DB;
use Session;
use Request;
use Vinkla\Hashids\Facades\Hashids;

class AdminApplicantCouncilCertificateController extends ApplicantCBController
{

    public function cbInit()
    {

        # START CONFIGURATION DO NOT REMOVE THIS LINE
        $this->title_field = "id";
        $this->limit = "20";
        $this->orderby = "id,desc";
        $this->global_privilege = false;
        $this->button_table_action = true;
        $this->button_bulk_action = true;
        $this->button_action_style = "button_icon";
        $this->button_edit = true;

        if (Session::get("is_applicant") == 1) {
            $this->button_add = true;
            $this->button_delete = true;
        } else {
            $this->button_add = false;
            $this->button_delete = false;
        }
        $this->button_detail = true;
        $this->button_show = true;
        $this->button_filter = true;
        $this->button_import = false;
        $this->button_export = false;
        $this->table = "applicant_council_certificate";
        if (CRUDBooster::myPrivilegeId() == 4) {
            $this->getIndex_view = "default.applicant_index";
        } else {
        $applicant_id=Request::get('applicant_id');
        $vacancy_id=Request::get('va_id');

        //dd($applicant_id,$vacancy_id);

        if(!empty($applicant_id)){
            $check_nt=DB::table('applicant_profile')->select('is_nt_staff')->whereId($applicant_id)->first();
            if($check_nt->is_nt_staff){

               // dd('devs');
                $check_vacancy_type=DB::table('vacancy_apply')->select('is_open')->whereId($vacancy_id)->first();
                if($check_vacancy_type->is_open){
                    if($vacancy_id){
                        $this->getIndex_view = "appliedApplicants.council";
                      
                    }else{
                        $this->getIndex_view = "applicantProfile.council";
                    }
                }else{
                    if($vacancy_id){
                        $this->getIndex_view = "appliedApplicants.council";

                    }else{
                        $this->getIndex_view = "applicantProfile.council";
                    }
                }
            }else{
                $this->getIndex_view = "appliedApplicants.council";
            }
            
        }else{
            $this->getIndex_view = "applicantProfile.council";
        }
    }



        $this->getEdit_view = "default.custom_form";

        // $this->getEdit_view  = "default.applicant_form";
        # END CONFIGURATION DO NOT REMOVE THIS LINE

        # START COLUMNS DO NOT REMOVE THIS LINE
        $this->col = [];
        // $this->col[] = ["label"=>"Applicant","name"=>"applicant_id","join"=>"applicant_profile,first_name_en"];
        $this->col[] = ["label" => "Council", "name" => "council_id", "join" => "mst_council,name_en"];
        $this->col[] = ["label" => "Registration Type", "name" => "registration_type", "join" => "mst_council_registration_type,name_en"];
        $this->col[] = ["label" => "Registration No", "name" => "registration_no"];
        $this->col[] = ["label" => "Certificate Upload", "name" => "certificate_upload", "image" => 1];
        # END COLUMNS DO NOT REMOVE THIS LINE

        # START FORM DO NOT REMOVE THIS LINE
        $this->form = [];
        // $this->form[] = ['label'=>'Applicant Id','name'=>'applicant_id','type'=>'select-c','validation'=>'integer|min:0','cmp-ratio'=>'12:2:4',"dataquery"=>"SELECT id as value, CONCAT(first_name_en, '   ', mid_name_en, ' ', last_name_en) AS label FROM applicant_profile"];
        $this->form[] = ['label' => 'Council', 'name' => 'council_id', 'type' => 'select-c', 'validation' => 'required|min:1|max:255', 'cmp-ratio' => '6:12:12', "dataquery" => "SELECT id as value, CONCAT(name_en) AS label FROM mst_council"];
        // $this->form[] = ['label'=>'Remarks','name'=>'remarks','type'=>'textarea-c','validation'=>'string|min:5|max:5000','cmp-ratio'=>'12:2:6'];
        $this->form[] = ['label' => 'Registration Type', 'name' => 'registration_type', 'type' => 'select-c', 'validation' => 'required|min:1|max:255', 'cmp-ratio' => '3:12:12', "dataquery" => "SELECT id as value, CONCAT(name_en) AS label FROM mst_council_registration_type"];
        $this->form[] = ['label' => 'Registration No', 'name' => 'registration_no', 'type' => 'text-c', 'validation' => 'required', 'cmp-ratio' => '3:12:12'];
        $this->form[] = ['label' => 'Registration Date BS', 'name' => 'registration_date_bs', 'type' => 'date-n', 'validation' => 'required', 'cmp-ratio' => '3:12:12'];
        $this->form[] = ['label' => 'Registration Date AD', 'name' => 'registration_date_ad', 'type' => 'date-c', 'validation' => '', 'cmp-ratio' => '3:12:12'];
        $this->form[] = ['label' => 'Renewal Date BS', 'name' => 'renewal_date_bs', 'type' => 'date-n', 'validation' => '', 'cmp-ratio' => '3:12:12'];
        $this->form[] = ['label' => 'Renewal Date AD', 'name' => 'renewal_date_ad', 'type' => 'date-c', 'validation' => '', 'cmp-ratio' => '3:12:12'];

        $this->form[] = ['label' => 'Certificate Upload', 'name' => 'certificate_upload', 'type' => 'upload-c', 'validation' => 'required|image|max:200', 'cmp-ratio' => '12:2:12', 'upload_encrypt' => 'true'];
        # END FORM DO NOT REMOVE THIS LINE

        # OLD START FORM
        //$this->form = [];
        //$this->form[] = ["label"=>"Applicant Id","name"=>"applicant_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"applicant,id"];
        //$this->form[] = ["label"=>"Council Id","name"=>"council_id","type"=>"select2","required"=>TRUE,"validation"=>"required|min:1|max:255","datatable"=>"council,id"];
        //$this->form[] = ["label"=>"Certificate Upload","name"=>"certificate_upload","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
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
        $this->script_js = " $(document).ready(function(){
             $('#registration_date_ad').change(function(){ convertAdtoBs('#registration_date_ad','#registration_date_bs'); }); $('#registration_date_bs').change(function(){ convertBstoAd('#registration_date_bs','#registration_date_ad'); });
             $('#renewal_date_ad').change(function(){ convertAdtoBs('#renewal_date_ad','#renewal_date_bs'); }); $('#renewal_date_bs').change(function(){ convertBstoAd('#renewal_date_bs','#renewal_date_ad'); });
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

        //dd($id);
        $encoded_applicant_id = Session::get('applicant_id');
        $applicant_id = Hashids::decode($encoded_applicant_id);
        $vacancy_apply_id = intval($id);

        //dd($vacancy_apply_id);
        if (isset($vacancy_apply_id)) {
            $va = DB::table('applied_applicant_council_certificate')
                ->where([['applicant_id', $applicant_id], ['vacancy_apply_id', $vacancy_apply_id]])
                ->first();

                //dd($va);

            if ($va) {
                CRUDBooster::redirect(CRUDBooster::mainpath(), trans('Sorry, you can not delete this record after applying for job.'), 'warning');
            }
        }
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
