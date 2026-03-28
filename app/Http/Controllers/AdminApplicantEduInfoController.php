<?php namespace App\Http\Controllers;

use App;
use CRUDBooster;
use DB;
use Request;
use Session;
use Vinkla\Hashids\Facades\Hashids;

class AdminApplicantEduInfoController extends ApplicantCBController
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
        $this->table = "applicant_edu_info";
        if (CRUDBooster::myPrivilegeId() == 4) {
            $this->getIndex_view = "default.applicant_index";
        } else {

            $applicant_id=Request::get('applicant_id');
            $vacancy_id=Request::get('va_id');

            if(!empty($applicant_id)){
                $check_nt=DB::table('applicant_profile')->select('is_nt_staff')->whereId($applicant_id)->first();
                if($check_nt->is_nt_staff){
                    #check if applied applicants or applicant profile only
                    if($vacancy_id){
                        $check_vacancy_type=DB::table('vacancy_apply')->select('is_open')->whereId($vacancy_id)->first();
                        if($check_vacancy_type->is_open){
                            $this->getIndex_view = "appliedApplicants.education";
                        }else{
                            #check if internal or file promotion
                           $vp_id= DB::table('vacancy_apply')->select('vacancy_post_id')->whereApplicant_id($applicant_id)->first();
                           $vpost_id=$vp_id->vacancy_post_id;
                           $opening_type=DB::table('vacancy_post')->whereId($vpost_id)->select('file_pormotion')->first();
                           #if file pormotion merged data should be included for internal nothing
                           if(!empty($opening_type->file_pormotion)){
                               $this->getIndex_view = "appliedApplicants.education";
                           }else{
                            $this->getIndex_view = "appliedApplicants.education"; 
                           }
                        }
                    }else{
                        $this->getIndex_view = "applicantProfile.education";
                    }

                }else{
                    $this->getIndex_view = "appliedApplicants.education";  
                }
            }else{
                $this->getIndex_view = "applicantProfile.education";
            }
          
        }
        $this->getEdit_view = "default.custom_form";
        //$this->getAdd_view ="default.applicant_form";
        # END CONFIGURATION DO NOT REMOVE THIS LINE

        # START COLUMNS DO NOT REMOVE THIS LINE
        $this->col = [];
        // $this->col[] = ["label"=>"Applicant","name"=>"applicant_id","join"=>"applicant_profile,first_name_en"];
        // $this->col[] = ["label"=>"University","name"=>"university"];
        $this->col[] = ["label" => "Education Level", "name" => "edu_level_id", "join" => "mst_edu_level,name_en"];
        $this->col[] = ["label" => "Education Degree", "name" => "edu_degree_id", "join" => "mst_edu_degree,name_en"];
        $this->col[] = ["label" => "Education Major", "name" => "edu_major_id", "join" => "mst_edu_major,name_en"];
        $this->col[] = ["label" => "Division", "name" => "division_id", "join" => "mst_edu_division,name_en"];
        $this->col[] = ["label" => "Passed Year BS", "name" => "passed_year_bs", "join" => "mst_year,year_bs"];
        $this->col[] = ["label" => "Transcript", "name" => "certificate_1", "image" => 1];
        $this->col[] = ["label" => "Is Foreign University?", "name" => "is_foreign_university"];
        // $this->col[] = ["label" => "Character Certificate", "name" => "certificate_2", "image" => 1];

        // $this->col[] = ["label"=>"Percentage","name"=>"percentage"];
        # END COLUMNS DO NOT REMOVE THIS LINE

        # START FORM DO NOT REMOVE THIS LINE
        $this->form = [];
        // $this->form[] = ['label'=>'Applicant ','name'=>'applicant_id','type'=>'select-c','validation'=>'required|integer|min:0','cmp-ratio'=>'12:2:8','dataquery'=>'SELECT id as value, CONCAT(first_name_en, \'   \', mid_name_en, \' \', last_name_en) AS label FROM applicant_profile'];
        $this->form[] = ['label' => 'Education Level ', 'name' => 'edu_level_id', 'type' => 'select-c', 'validation' => 'required|max:255', 'cmp-ratio' => '4:12:12', 'dataquery' => 'SELECT id as value, CONCAT( name_en) AS label FROM mst_edu_level'];
        // $this->form[] = ['label'=>'Education Degree ','name'=>'edu_degree_id','type'=>'select-c','validation'=>'required|max:255','cmp-ratio'=>'6:12:12','dataquery'=>'SELECT id as value, CONCAT( name_en) AS label FROM mst_edu_degree'];
        $this->form[] = ['label' => 'Education Degree ', 'name' => 'edu_degree_id', 'type' => 'select-c', 'validation' => 'required|max:255', 'cmp-ratio' => '4:12:12', 'datatable' => 'mst_edu_degree,name_np', 'parent_select' => 'edu_level_id'];
        $this->form[] = ['label' => 'Specialization', 'name' => 'specialization', 'type' => 'text-c', 'cmp-ratio' => '4:12:12'];
        $this->form[] = ['label' => 'Education Major', 'name' => 'edu_major_id', 'type' => 'select2-c', 'cmp-ratio' => '4:12:12', 'datatable' => 'mst_edu_major,name_en', 'parent_select' => 'edu_level_id'];
        // $this->form[] = ['label' => 'Degree Name', 'name' => 'degree_name', 'type' => 'select-c', 'validation' => 'required|max:255','datatable' => 'mst_degree,name_en', 'cmp-ratio' => '4:12:12'];
        $this->form[] = ['label' => 'Is Foreign University?', 'name' => 'is_foreign_university', 'type' => 'radio-c', 'validation' => 'required|bool', 'width' => 'col-sm-10', 'dataenum' => '1|YES;0|NO', 'value' => '0', 'cmp-ratio' => '4:12:12'];
        $this->form[] = ['label' => 'University Name', 'name' => 'university_name', 'type' => 'text-c', 'validation' => 'required|max:255', 'cmp-ratio' => '3:12:12'];
        $this->form[] = ['label' => 'Country Name', 'name' => 'country_name', 'type' => 'text-c', 'validation' => 'required|max:255', 'cmp-ratio' => '3:12:12'];
        $this->form[] = ['label' => 'University', 'name' => 'university', 'type' => 'select-c', 'validation' => 'required|max:255', 'datatable' => 'mst_university,name_en', 'cmp-ratio' => '3:12:12'];
        $this->form[] = ['label' => 'Passed Year BS', 'maxlength' => '4', 'name' => 'passed_year_bs', 'id' => 'passed_year', 'type' => 'select-c', 'cmp-ratio' => '2:12:12', "datatable" => "mst_year,year_bs"];
        $this->form[] = ['label' => 'Passed Year AD', 'maxlength' => '4', 'name' => 'passed_year_ad', 'id' => 'passed_year_ad', 'type' => 'select-c', 'cmp-ratio' => '2:12:12', "datatable" => "mst_year,year_ad"];
        $this->form[] = ['label' => 'Division ', 'name' => 'division_id', 'type' => 'select-c', 'validation' => 'max:255', 'cmp-ratio' => '2:12:12', 'dataquery' => 'SELECT id as value, CONCAT( name_en) AS label FROM mst_edu_division'];
        $this->form[] = ['label' => 'Percentage', 'name' => 'percentage', 'type' => 'number-c', 'validation' => 'numeric|min:1|max:100', 'cmp-ratio' => '2:12:12'];
        $this->form[] = ['label' => 'Grade', 'name' => 'grade', 'type' => 'text-c', 'cmp-ratio' => '2:12:12'];
        $this->form[] = ['label' => 'Certificate(Transcript)', 'name' => 'certificate_1', 'type' => 'upload-c', 'validation' => 'required|image|max:200', 'cmp-ratio' => '12:12:12', 'upload_encrypt' => 'true', 'help' => 'इन्जिनियर समुहमा दरखास्त दिने उम्मेद्द्वारले division, percentage वा GPA खुलेको transcript को पाना upload गरि बाकी document तल upload 1-6 मा गर्नुहोला।'];
        $this->form[] = ['label' => 'Equalivalent Certificate', 'name' => 'equivalent_certificate', 'type' => 'upload-c', 'validation' => 'required|image|max:200', 'cmp-ratio' => '12:12:12', 'upload_encrypt' => 'true'];
        $this->form[] = ['label' => 'Character Certificate', 'name' => 'certificate_2', 'type' => 'upload-c', 'validation' => 'required|image|max:200', 'cmp-ratio' => '12:12:12', 'upload_encrypt' => 'true'];
        $this->form[] = ['label' => 'Upload 1', 'name' => 'upload_1', 'type' => 'upload-c', 'validation' => 'image|max:200', 'cmp-ratio' => '4:12:12', 'upload_encrypt' => 'true'];
        $this->form[] = ['label' => 'Upload 2', 'name' => 'upload_2', 'type' => 'upload-c', 'validation' => 'image|max:200', 'cmp-ratio' => '4:12:12', 'upload_encrypt' => 'true'];
        $this->form[] = ['label' => 'Upload 3', 'name' => 'upload_3', 'type' => 'upload-c', 'validation' => 'image|max:200', 'cmp-ratio' => '4:12:12', 'upload_encrypt' => 'true'];
        $this->form[] = ['label' => 'Upload 4', 'name' => 'upload_4', 'type' => 'upload-c', 'validation' => 'image|max:200', 'cmp-ratio' => '4:12:12', 'upload_encrypt' => 'true'];
        $this->form[] = ['label' => 'Upload 5', 'name' => 'upload_5', 'type' => 'upload-c', 'validation' => 'image|max:200', 'cmp-ratio' => '4:12:12', 'upload_encrypt' => 'true'];
        $this->form[] = ['label' => 'Upload 6', 'name' => 'upload_6', 'type' => 'upload-c', 'validation' => 'image|max:200', 'cmp-ratio' => '4:12:12', 'upload_encrypt' => 'true'];

        # END FORM DO NOT REMOVE THIS LINE

        # OLD START FORM
        //$this->form = [];
        //$this->form[] = ['label'=>'Applicant Id','name'=>'applicant_id','type'=>'select','validation'=>'required|integer|min:0','width'=>'col-sm-10',"dataquery"=>"SELECT id as value, CONCAT(first_name_en, '   ', mid_name_en, ' ', last_name_en) AS label FROM applicant_profile"];
        //$this->form[] = ['label'=>'Edu Level Id','name'=>'edu_level_id','type'=>'select','validation'=>'required|max:255','width'=>'col-sm-10',"dataquery"=>"SELECT id as value, CONCAT( name_np, ' - ', name_en) AS label FROM mst_edu_level"];
        //$this->form[] = ['label'=>'Passed Year Ad','name'=>'passed_year_ad','type'=>'number','validation'=>'integer|min:0','width'=>'col-sm-10'];
        //$this->form[] = ['label'=>'Passed Year Bs','name'=>'passed_year_bs','type'=>'number','validation'=>'integer|min:0','width'=>'col-sm-10'];
        //$this->form[] = ['label'=>'Division Id','name'=>'division_id','type'=>'select','validation'=>'required|max:255','width'=>'col-sm-10',"dataquery"=>"SELECT id as value, CONCAT( name_np, ' - ', name_en) AS label FROM mst_edu_division"];
        //$this->form[] = ['label'=>'Percentage','name'=>'percentage','type'=>'money','validation'=>'integer|min:0','width'=>'col-sm-10'];
        //$this->form[] = ['label'=>'Certificate Upload','name'=>'certificate_upload','type'=>'text','validation'=>'min:1|max:255','width'=>'col-sm-10'];
        //$this->form[] = ['label'=>'Exam Board','name'=>'exam_board','type'=>'select','validation'=>'required|max:255','width'=>'col-sm-10',"dataquery"=>"SELECT id as value, CONCAT( name_np, ' - ', name_en) AS label FROM mst_exam_board"];
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
        // $this->script_js =
        // "  $(document).ready(function(){
        //     passed_year_ad();
        //     passed_year_bs(); });

        // function passed_year_ad(){
        //     var end = new Date().getFullYear();
        //     var start = end - 40;
        //     var options = '';
        //     for(var year = start ; year <=end; year++){
        //       options += '<option>'+ year +'</option>';
        //     }
        //     document.getElementById('passed_year_ad').innerHTML = options;
        // }
        // function passed_year_bs(){
        //     var end = new Date().getFullYear();
        //     var end_bs = end + 57;
        //     var start = end_bs - 40;
        //     var options = '';
        //     for(var year = start ; year <=end_bs; year++){
        //       options += '<option>'+ year +'</option>';
        //     }
        //     document.getElementById('passed_year_bs').innerHTML = options;
        // }
        //";

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
        $this->load_js[] = asset("js/foreign_university.js");

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

        // dd($query, Request::get("va_id"));
        $vacancy_apply_id = Request::get("va_id");
        $applicant_id=Request::get("applicant_id");
        // dd('devs');

        if (isset($vacancy_apply_id)) {

            // dd('devs');
            $vacancy_post = DB::table('vacancy_apply')
                ->select('vacancy_post_id')
                ->where('id', $vacancy_apply_id)
                ->first();
            $vacancy_ad = DB::table('vacancy_post')
                ->select('vacancy_ad_id')
                ->where('id', $vacancy_post->vacancy_post_id)
                ->first();
            $opening_type = DB::table('vacancy_ad')
                ->select('opening_type_id')
                ->where('id', $vacancy_ad->vacancy_ad_id)
                ->first();

            if ($opening_type->opening_type_id == 3) {
                if (CRUDBooster::myPrivilegeId() == 1 || CRUDBooster::myPrivilegeId() == 5|| CRUDBooster::myPrivilegeId() == 3) {
                    $applicant_id = Request::get("applicant_id");
                    $vacancy_apply_id = Request::get("va_id");
                    $this->data['erp_data'] = DB::select(
                        'SELECT
                        education_level_id
                        ,education_level
                        ,degree_id
                        ,education_degree
                        ,division_id
                        ,division
                        ,passed_year_ad
                        ,passed_year_bs
                        FROM vw_erp_qualification veq
                        WHERE ap_id=:id', ['id' => $applicant_id]);

                    $MergedDataExists = DB::table('merged_applicant_education')
                        ->where([['applicant_id', $applicant_id], ['vacancy_apply_id', $vacancy_apply_id]])->get();
                    $count_MergedDataExists=count($MergedDataExists);
                    // dd($count_MergedDataExists);

                    if ($count_MergedDataExists==0) {
                        $recruit_data = DB::select(
                            'SELECT
                    mel.id as education_level_id
                    ,mel.name_en AS education_level
                    ,med.id AS degree_id
                    ,med.name_en AS education_degree
                    ,medi.id AS division_id
                    ,medi.name_en AS division
                    ,my.year_bs as passed_year_bs
                    ,my.year_ad as passed_year_ad
                    FROM applied_applicant_edu_info aei
                    LEFT JOIN mst_edu_level mel ON mel.id=aei.edu_level_id
                    LEFT JOIN mst_edu_degree med ON med.id=aei.edu_degree_id
                    LEFT JOIN mst_edu_major mem ON mem.id=aei.edu_major_id
                    LEFT JOIN mst_edu_division medi ON medi.id=aei.division_id
                    left join mst_year my on aei.passed_year_bs=my.id
                    WHERE applicant_id=:id
                    and aei.is_deleted=:is_deleted
                     and vacancy_apply_id=:vacancy_apply_id', ['id' => $applicant_id, 'is_deleted' => 0, 'vacancy_apply_id' => $vacancy_apply_id]);

                        $this->InsertInitMergedData($recruit_data, $this->data['erp_data']);
                    }
                    $recruit_merged_data = DB::select(
                        'SELECT
                aei.id
                ,cu.email as verified_by
				,cm.email as approved_by
                ,mel.id as education_level_id
                ,mel.name_en AS education_level
                ,med.id AS degree_id
                ,med.name_en AS education_degree
                ,medi.id AS division_id
                ,medi.name_en AS division
                ,my.year_bs as passed_year_bs
                ,my.year_ad as passed_year_ad
                ,aei.flag
				,aei.mismatched_key
                ,aei.is_approved
                ,aei.is_verified
                ,aei.verified_on
                ,aei.approved_on
                FROM merged_applicant_education aei
                LEFT JOIN mst_edu_level mel ON mel.id=aei.edu_level_id
                left join mst_year my on aei.passed_year_bs=my.id
                LEFT JOIN mst_edu_degree med ON med.id=aei.edu_degree_id
                LEFT JOIN mst_edu_major mem ON mem.id=aei.edu_major_id
                LEFT JOIN mst_edu_division medi ON medi.id=aei.division_id
                LEFT JOIN cms_users cu ON cu.id=aei.verified_by
				LEFT JOIN cms_users cm ON cm.id=aei.approved_by
                WHERE
                applicant_id=:applicant_id
                 and vacancy_apply_id=:vacancy_apply_id
                    ', ['applicant_id' => $applicant_id, 'vacancy_apply_id' => $vacancy_apply_id]);
                    $MergedData = $recruit_merged_data;
                    $date = array();
                    foreach ($MergedData as $key => $row) {
                        $date[$key] = $row->date_from_bs;
                    }
                    array_multisort($date, SORT_DESC, $MergedData);
                    $this->data['merged'] = $MergedData;
                }
            }
        }
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
        //  $postdata['passed_year_bs'] = substr($postdata['passed_year_bs'],0,4);
        // $postdata['passed_year_ad'] = substr($postdata['passed_year_ad'],0,4);
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
        // $postdata['passed_year_bs'] = substr($postdata['passed_year_bs'],0,4);
        // $postdata['passed_year_ad'] = substr($postdata['passed_year_ad'],0,4);

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
        $postdata['passed_year_bs'] = substr($postdata['passed_year_bs'], 0, 4);
        $postdata['passed_year_ad'] = substr($postdata['passed_year_ad'], 0, 4);
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
        //TODO: uncomment on live
        // $encoded_applicant_id = Session::get('applicant_id');
        // $applicant_id = Hashids::decode($encoded_applicant_id);
        // // check if record exists in applied_applicant_edu
        // // $vacancy_apply_id = Request::get("id");
        // $vacancy_apply_id = intval($id);
        // if (isset($vacancy_apply_id)) {
        //     $va = DB::table('applied_applicant_edu_info')
        //     ->where([['applicant_id',$applicant_id],['vacancy_apply_id',$vacancy_apply_id]])
        //     ->get();

        //     if(isset($va) && $va>0){
        //         CRUDBooster::redirect(CRUDBooster::mainpath(), trans('Sorry, you can not delete this record after applying for job.'), 'warning');
        //     }
        // }

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
    // returns only in erp data,not in erp data and mistakes data
    public function CompareArray($array1, $array2)
    {
        $diff = array();
        $diff2 = array();
        $onlyInErpData = array();
        $missingInErpData = array();
        $misMatchedData = array();
        $mistakes = array();
        // getting only in erp data
        foreach ($array2 as $erp) {
            $only_in_erp = true;
            foreach ($array1 as $recruit) {
                if ($recruit->education_degree == $erp->education_degree && $recruit->edu_level_id == $erp->edu_level_id) {
                    $only_in_erp = false;
                }
            }
            if ($only_in_erp == true) {
                $onlyInErpData[] = json_decode(json_encode($erp), true);
            }
        }
        // getting missing in erp data and mismatched data
        foreach ($array1 as $recruit) {
            $not_in_erp = true;
            foreach ($array2 as $erp) {
                if ($recruit->education_degree == $erp->education_degree && $recruit->edu_level_id == $erp->edu_level_id) {
                    $not_in_erp = false;
                    $arr1 = json_decode(json_encode($recruit), true);
                    $arr2 = json_decode(json_encode($erp), true);
                    $result = array_diff_assoc($arr2, $arr1);
                    // dd($result);
                    if (count($result) > 0) {
                        $mismatchedkeys = "";
                        foreach ($result as $key => $value) {
                            $mismatchedkeys = $mismatchedkeys . '-' . $key;
                        }
                        $mismatched = $recruit;
                        $mismatched->mismatched_keys = $mismatchedkeys;
                        $misMatchedData[] = json_decode(json_encode($recruit), true);
                    }
                }
            }
            if ($not_in_erp == true) {
                $missingInErpData[] = json_decode(json_encode($recruit), true);
            }
        }

        $onlyInErpData = $this->updateFlag($onlyInErpData, 3);
        $missingInErpData = $this->updateFlag($missingInErpData, 4);
        $misMatchedData = $this->updateFlag($misMatchedData, 2);
        // dd($onlyInErpData,$missingInErpData,$misMatchedData);

        return array($onlyInErpData, $missingInErpData, $misMatchedData);
    }
    // merging array
    public function MergeArray($array1, $array2, $array3, $array4)
    {
        return array_merge($array1, $array2, $array3, $array4);
    }

    // getting common data
    public function getIdenticalData($array1, $array2)
    {
        $common_data = [];
        foreach ($array1 as $key => $value) {
            foreach ($array2 as $key2 => $value2) {
                $arr1 = json_decode(json_encode($value), true);
                $arr2 = json_decode(json_encode($value2), true);
                $result = array_diff_assoc($arr2, $arr1);
                if (count($result) == 0) {
                    $common_data[] = $arr1;
                }
            }
        }
        $common_data = $this->updateFlag($common_data, 1);
        return $common_data;
    }
    // setting flag for common, mistakes to array
    public function updateFlag($array, $type)
    {
        switch ($type) {
            case 1:
                $flag = 'correct';
                break;
            case 2:
                $flag = 'mistakes';
                break;
            case 3:
                $flag = 'only_in_erp';
                break;
            case 4:
                $flag = 'missing_in_erp';
                break;
            default:
        }
        foreach ($array as $key => $arr) {
            $array[$key]['flag'] = $flag;
        }
        return $array;
    }
    // for initialising merge data and inserting
    public function InsertInitMergedData($arr1, $arr2)
    {
        // dd('devs');
        $applicant_id = Request::get("applicant_id");
        $vacancy_apply_id = Request::get("va_id");
        $common_data = $this->getIdenticalData($arr1, $arr2);
        $ComparedData = $this->CompareArray($arr1, $arr2);

        $MergedData = $this->MergeArray($common_data, $ComparedData[0], $ComparedData[1], $ComparedData[2]);

        // dd($common_data, $ComparedData[0], $ComparedData[1], $ComparedData[2]);
        foreach ($MergedData as $key => $MergedData) {
            $mismatchedkey = isset($MergedData["mismatched_keys"]) ? $MergedData["mismatched_keys"] : "";
            if ($MergedData["flag"] == "missing_in_erp" || $MergedData["flag"] == "mistakes") {
                $edu_maj = DB::table('applicant_edu_info')->select('edu_major_id')
                    ->where([['edu_degree_id', $MergedData["degree_id"]], ['passed_year_ad', $MergedData['passed_year_ad']], ['applicant_id', $applicant_id]])
                    ->first();

                    // dd(  $edu_maj);
                // if (count($edu_maj) > 0) {
                if ($edu_maj) {
                    $data['edu_major_id'] = $edu_maj->edu_major_id;
                }
            }
            $data['vacancy_apply_id'] = $vacancy_apply_id;
            $data['applicant_id'] = $applicant_id;
            $data['edu_level_id'] = $MergedData["education_level_id"];
            $data['edu_degree_id'] = $MergedData["degree_id"];
            $data['division_id'] = $MergedData["division_id"];
            $data['passed_year_ad'] = $MergedData["passed_year_ad"];
            $data['passed_year_bs'] = $MergedData["passed_year_bs"];
            $data['flag'] = $MergedData["flag"];
            $data['mismatched_key'] = $mismatchedkey;
            DB::table('merged_applicant_education')->insert($data);
        }
    }

    //By the way, you can still create your own method in here... :)

}
