<?php namespace App\Http\Controllers;

use crocodicstudio\crudbooster\helpers\CRUDBooster;
use Illuminate\Support\Facades\DB;
use Session;
use Vinkla\Hashids\Facades\Hashids;
use Request;


class AdminApplicantExpInfoController extends ApplicantCBController
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
        if (Session::get("is_applicant") == 1||CRUDBooster::myPrivilegeId() == 1||CRUDBooster::myPrivilegeId() == 4) {
            $this->button_add = true;
            $this->button_edit = true;
            $this->button_delete = true;
        } else {
            $this->button_add = false;
            $this->button_edit = false;
            $this->button_delete = false;
        }
        $this->button_detail = true;
        $this->button_show = true;
        $this->button_filter = true;
        $this->button_import = false;
        $this->button_export = false;
        $this->table = "applicant_exp_info";

        if (CRUDBooster::myPrivilegeId() == 4) {
            $this->getIndex_view = "default.applicant_index";
        } else {
        $applicant_id=Request::get('applicant_id');
        $vacancy_id=Request::get('va_id');
        if(!empty($applicant_id)){
            $check_nt=DB::table('applicant_profile')->select('is_nt_staff')->whereId($applicant_id)->first();
            if($check_nt->is_nt_staff){
                $check_vacancy_type=DB::table('vacancy_apply')->select('is_open')->whereId($vacancy_id)->first();
                if($check_vacancy_type->is_open){
                    if($vacancy_id){
                        $this->getIndex_view = "appliedApplicants.experience";
                    }else{
                        $this->getIndex_view = "applicantProfile.experience";
                    }
                }else{
                    if($vacancy_id){
                        $this->getIndex_view = "appliedApplicants.experience";
                    }else{
                        $this->getIndex_view = "applicantProfile.experience";
                    }
                }
            }else{
                $this->getIndex_view = "appliedApplicants.experience";  
            }
        }else{
            $this->getIndex_view = "applicantProfile.experience";
        }

    }


        # END CONFIGURATION DO NOT REMOVE THIS LINE

        # START COLUMNS DO NOT REMOVE THIS LINE
        $this->col = [];
        // $this->col[] = ["label"=>"Applicant","name"=>"applicant_id","join"=>"applicant_profile,first_name_en"];
        $this->col[] = ["label" => "Working Office", "name" => "working_office"];
        $this->col[] = ["label" => "Designation", "name" => "designation"];
        $this->col[] = ["label" => "Date From BS", "name" => "date_from_bs"];
        $this->col[] = ["label" => "Date To BS", "name" => "date_to_bs"];
        $this->col[] = ["label" => "Job Category", "name" => "job_category_id", "join" => "mst_job_category,name_en"];
        $this->col[] = ["label" => "Appointment", "name" => "appointment_doc","image" => true];
        $this->col[] = ["label" => "Termination", "name" => "termination_doc","image" => true];
        # END COLUMNS DO NOT REMOVE THIS LINE

        # START FORM DO NOT REMOVE THIS LINE
        $this->form = [];
        $this->form[] = ['label' => 'Working Office', 'name' => 'working_office', 'type' => 'text-c', 'validation' => 'required', 'cmp-ratio' => '4:12:12', 'datatable' => 'mst_working_office,name_en'];
        $this->form[] = ['label' => 'Designation', 'name' => 'designation', 'type' => 'text-c', 'validation' => 'required', 'cmp-ratio' => '4:12:12', 'datatable' => 'mst_designation,name_en'];
        $this->form[] = ['label' => 'Service Group', 'name' => 'service_group', 'type' => 'text-c', 'validation' => '', 'cmp-ratio' => '4:12:12', 'datatable' => 'mst_work_service_group,name_en'];
        $this->form[] = ['label' => 'Service Subgroup', 'name' => 'service_subgroup', 'type' => 'text-c', 'validation' => '', 'cmp-ratio' => '4:12:12', 'datatable' => 'mst_work_service_sub_group,name_en'];
        $this->form[] = ['label' => 'Job Category', 'name' => 'job_category_id', 'type' => 'select2-c', 'validation' => 'required|max:255', 'cmp-ratio' => '4:12:12', 'datatable' => 'mst_job_category,name_en'];
        $this->form[] = ['label' => 'Work Level', 'name' => 'work_level', 'type' => 'select2-c',  'cmp-ratio' => '4:12:12', 'datatable' => 'mst_work_level,name_en'];
        $this->form[] = ['label' => 'Date From BS', 'name' => 'date_from_bs', 'type' => 'date-n', 'validation' => 'required', 'cmp-ratio' => '4:12:12'];
        $this->form[] = ['label' => 'Date To BS', 'name' => 'date_to_bs', 'type' => 'date-n', 'validation' => '', 'cmp-ratio' => '4:12:12'];
//        $this->form[] = ['label' => 'Contract End Date BS', 'name' => 'contract_end_date_bs', 'type' => 'date-n', 'cmp-ratio' => '4:12:12'];
        $this->form[] = ['label' => 'Date From AD', 'name' => 'date_from_ad', 'type' => 'date-c',  'cmp-ratio' => '4:12:12'];
        $this->form[] = ['label' => 'Date To AD', 'name' => 'date_to_ad', 'type' => 'date-c',  'cmp-ratio' => '4:12:12'];
//        $this->form[] = ['label' => 'Contract End Date AD', 'name' => 'contract_end_date_ad', 'type' => 'date-c', 'cmp-ratio' => '4:12:12'];
        $this->form[] = ['label' => 'Organization type', 'name' => 'is_govt', 'type' => 'select2-c', 'validation' => 'integer', 'cmp-ratio' => '4:12:12','validation' => 'required', 'datatable' => 'mst_org_category,name_en','datatable_where' => 'id in(1,2)'];
        $this->form[] = ['label' => 'Appointment Doc', 'name' => 'appointment_doc','validation' => 'required', 'type' => 'upload-c', 'cmp-ratio' => '6:12:12','help' => 'File type: JPG, JPEG, PNG, GIF, BMP', 'upload_encrypt' => 'true'];
        $this->form[] = ['label' => 'Termination Doc', 'name' => 'termination_doc', 'type' => 'upload-c', 'cmp-ratio' => '6:12:12','help' => 'File type: JPG, JPEG, PNG, GIF, BMP', 'upload_encrypt' => 'true'];

        // $this->form[] = ['label'=>'Remarks','name'=>'remarks','type'=>'textarea-c','validation'=>'required|string|min:5|max:5000','width'=>'col-sm-10'];
        # END FORM DO NOT REMOVE THIS LINE

        # OLD START FORM
        //$this->form = [];
        //$this->form[] = ["label"=>"Applicant Id","name"=>"applicant_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"applicant,id"];
        //$this->form[] = ["label"=>"Working Office Id","name"=>"working_office_id","type"=>"select2","required"=>TRUE,"validation"=>"required|max:255","datatable"=>"working_office,id"];
        //$this->form[] = ["label"=>"Designation Id","name"=>"designation_id","type"=>"select2","required"=>TRUE,"validation"=>"required|max:255","datatable"=>"designation,id"];
        //$this->form[] = ["label"=>"Service Group Id","name"=>"service_group_id","type"=>"select2","required"=>TRUE,"validation"=>"required|max:255","datatable"=>"service_group,id"];
        //$this->form[] = ["label"=>"Service Subgroup Id","name"=>"service_subgroup_id","type"=>"select2","required"=>TRUE,"validation"=>"required|max:255","datatable"=>"service_subgroup,id"];
        //$this->form[] = ["label"=>"Work Level Id","name"=>"work_level_id","type"=>"select2","required"=>TRUE,"validation"=>"required|max:255","datatable"=>"work_level,id"];
        //$this->form[] = ["label"=>"Job Category Id","name"=>"job_category_id","type"=>"select2","required"=>TRUE,"validation"=>"required|max:255","datatable"=>"job_category,id"];
        //$this->form[] = ["label"=>"Date From Bs","name"=>"date_from_bs","type"=>"text","required"=>TRUE,"validation"=>"required|max:255"];
        //$this->form[] = ["label"=>"Date To Bs","name"=>"date_to_bs","type"=>"text","required"=>TRUE,"validation"=>"required|max:255"];
        //$this->form[] = ["label"=>"Date From Ad","name"=>"date_from_ad","type"=>"date","required"=>TRUE,"validation"=>"required|date"];
        //$this->form[] = ["label"=>"Date To Ad","name"=>"date_to_ad","type"=>"date","required"=>TRUE,"validation"=>"required|date"];
        //$this->form[] = ["label"=>"Is Govt","name"=>"is_govt","type"=>"radio","required"=>TRUE,"validation"=>"required|integer","dataenum"=>"Array"];
        //$this->form[] = ["label"=>"Remarks","name"=>"remarks","type"=>"textarea","required"=>TRUE,"validation"=>"required|string|min:5|max:5000"];
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
        $this->script_js = "function(){
            $('#date_from_ad').change(function(){
                convertAdtoBs('#date_from_ad','#date_from_bs');
                });
            $('#date_from_bs').change(function(){
                convertBstoAd('#date_from_bs','#date_from_ad');
                });
            $('#date_to_ad').change(function(){
                convertAdtoBs('#date_to_ad','#date_to_bs');
                });
            $('#date_to_bs').change(function(){
                convertBstoAd('#date_to_bs','#date_to_ad');
                });
        }";

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
        //$this->load_js = array();
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
  public function getIndex(){
      if(!CRUDBooster::isView()) CRUDBooster::redirect(CRUDBooster::adminPath(),trans('crudbooster.denied_access'));
      CRUDBooster::myPrivilegeId()===1||CRUDBooster::myPrivilegeId()===5||CRUDBooster::myPrivilegeId()===2||CRUDBooster::myPrivilegeId()===3?$id=Request::input('applicant_id'):$id=CRUDBooster::myId();
      $data = [];
      $data['page_title'] = 'Applicant Experience';
      $data['applicant_exp_info'] = DB::table('applicant_exp_info')
                                   ->select( 'applicant_exp_info.id','date_from_bs','date_to_bs','mst_job_category.name_en as job_category','working_office','designation','appointment_doc','termination_doc',
                                   'date_from_ad','date_to_ad')
                                   ->leftjoin('mst_job_category','applicant_exp_info.job_category_id','mst_job_category.id')
                                   ->where([['applicant_id',$id],['applicant_exp_info.is_deleted',false]])
                                   ->paginate(10);

      $check_nt = DB::table('applicant_profile')->select('is_nt_staff')->whereId(CRUDBooster::myId())->exists();
      if($check_nt){
          $data['isNtStaff']=true;
          $data['isApplicant']=true;
      }

      if (CRUDBooster::myPrivilegeId() == 4) {
          $data['applicant_id']= CRUDBooster::myId();
          $this->cbView('applicantProfile.experience', $data);
      } else {
          $applicant_id = Request::get('applicant_id');
          $vacancy_id = Request::get('va_id');
          $data['applicant_id']= Request::get('applicant_id');
          $data['vaID']= Request::get('va_id');

          if (!empty($applicant_id)) {
              $check_nt = DB::table('applicant_profile')->select('is_nt_staff')->whereId($applicant_id)->first();;
              if ($check_nt->is_nt_staff) {
                  $check_vacancy_type = DB::table('vacancy_apply')->select('is_open')->whereId($vacancy_id)->first();
                  if ($check_vacancy_type->is_open) {
                      if ($vacancy_id) {
                          $this->cbView('appliedApplicants.experience', $data);
                      } else {
                          $this->cbView('applicantProfile.experience', $data);
                      }
                  } else {

                      if ($vacancy_id) {
                          $this->cbView('appliedApplicants.experience', $data);
                      } else {
                          $this->cbView('applicantProfile.experience', $data);
                      }
                  }
              } else {
                  $this->cbView('appliedApplicants.experience', $data);
              }
          } else {
              $this->cbView('applicantProfile.experience', $data);
          }
      }
  }


}
