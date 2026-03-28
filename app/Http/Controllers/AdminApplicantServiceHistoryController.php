<?php namespace App\Http\Controllers;

use App;
use Bsdate;
use CRUDBooster;
use DateTime;
use DB;
use Hashids;
use PDF;
use Request;
use Session;
use View;
use App\Helpers\Helper;

class AdminApplicantServiceHistoryController extends ApplicantCBController
{

    public function cbInit()
    {

        # START CONFIGURATION DO NOT REMOVE THIS LINE
        $this->title_field = "id";
        $this->limit = "20";
        $this->orderby = "date_from_bs,asc";
        $this->global_privilege = true;
        $this->button_table_action = true;
        $this->button_bulk_action = true;
        $this->button_action_style = "button_icon";
        $this->button_edit = true;
        if (CRUDBooster::myPrivilegeId() == 1) {
            $this->button_delete = true;
        }

        if (Session::get("is_applicant") == 1) {
            $this->button_add = true;
            // $this->button_delete = true;
        } else {
            $this->button_add = false;
            // $this->button_delete = false;
        }
        $this->button_detail = true;
        $this->button_show = true;
        $this->button_filter = true;
        $this->button_import = false;
        $this->button_export = false;
        $this->table = "applicant_service_history";
        if (CRUDBooster::myPrivilegeId() == 4) {
            $this->getIndex_view = "default.applicant_index";
        } else {
            $applicant_id=Request::get('applicant_id');
            $vacancy_id=Request::get('va_id');
            if(!empty($applicant_id)){
                $check_nt=DB::table('applicant_profile')->select('is_nt_staff')->whereId($applicant_id)->first();
                if($check_nt->is_nt_staff){
                   if($vacancy_id)
                   {
                     $check_vacancy_type=DB::table('vw_vacancy_applicant as va')
                                        ->select('vacancy_ad_id','vad.opening_type_id')
                                        ->leftjoin('vacancy_ad as vad','va.vacancy_ad_id','=','vad.id')
                                        ->where([['vad.is_deleted',false],['is_published',true],['va.id',$vacancy_id]])
                                        ->distinct()
                                        ->first();
                      // dd($check_vacancy_type);
                       if($check_vacancy_type->opening_type_id==1){
                           $this->getIndex_view = "appliedApplicants.serviceHistory";
                       }elseif($check_vacancy_type->opening_type_id==2){
                           $this->getIndex_view = "appliedApplicants.serviceHistory";
                       }else{
                           $this->getIndex_view = "appliedApplicants.serviceHistory";
//                           $this->getIndex_view = "appliedApplicants.ServiceHistoryComparison";
                       }
                    }else{
                        $this->getIndex_view = "applicantProfile.serviceHistory";
                    }
 
                }
            }else{
                $this->getIndex_view = "applicantProfile.serviceHistory";
            }
        }
        $this->getEdit_view = "default.custom_form";

        # END CONFIGURATION DO NOT REMOVE THIS LINE

        # START COLUMNS DO NOT REMOVE THIS LINE
        $this->col = array();
        //$this->col[] = array("label"=>"Applicant Id","name"=>"applicant_id","join"=>"applicant_profile,id");

        $this->col[] = array("label" => "Office", "name" => "working_office", "join" => "mst_working_office,name_en", "width" => "180px");
        $this->col[] = array("label" => "Designation", "name" => "designation", "join" => "mst_designation,name_en");
        $this->col[] = array("label" => "Level", "name" => "work_level", "join" => "mst_work_level,name_en", "width" => "60px");
        $this->col[] = array("label" => "Service Type", "name" => "work_service_id", "join" => "mst_work_service,name_en");
        $this->col[] = array("label" => "Service Group", "name" => "service_group", "join" => "mst_work_service_group,name_en");
        $this->col[] = array("label" => "Service Sub Group", "name" => "service_subgroup", "join" => "mst_work_service_sub_group,name_en");

        $this->col[] = array("label" => "Date From", "name" => "date_from_bs", "width" => "100px");
        $this->col[] = array("label" => "Date To", "name" => "date_to_bs", "width" => "100px");

        $this->col[] = array("label" => "Incharge", "name" => "case when is_office_incharge = 1 then 'YES' ELSE 'NO' END as is_office_incharge");
        // $this->col[] = array("label"=>"Incharge from","name"=>"incharge_date_from_bs","width"=>"100px" );
        // $this->col[] = array("label"=>"Incharge to","name"=>"incharge_date_to_bs","width"=>"100px");
        // $this->col[] = array("label" => "Seniority Date", "name" => "seniority_date_bs", "width" => "100px");
        $this->col[] = array("label" => "Seniority Date", "name" => "case when is_current = 1 then seniority_date_bs ELSE 'Null' END as seniority_date_bs", "width" => "100px");
        $this->col[] = array('label' => 'Currently Working', 'name' => "case when is_current = 1 then 'YES' ELSE 'NO' END as is_current");

        # END COLUMNS DO NOT REMOVE THIS LINE

        # START FORM DO NOT REMOVE THIS LINE
        $this->form = [];
        //$this->form[] = ['label'=>'Applicant Id','name'=>'applicant_id','type'=>'select2-c','validation'=>'required|integer|min:0','width'=>'col-sm-10','cmp-ratio'=>'4:12:12','datatable'=>'applicant_profile,first_name_np'];
        $this->form[] = ['label' => 'Working Office', 'name' => 'working_office', 'type' => 'select2-c', 'validation' => 'required', 'datatable' => 'mst_working_office,name_np', 'cmp-ratio' => '4:12:12'];
        $this->form[] = ['label' => 'Designation', 'name' => 'designation', 'type' => 'select2-c', 'validation' => 'required', 'datatable' => 'mst_designation,name_np', 'cmp-ratio' => '4:12:12', "datatable_format" => "name_np,' - ',name_en"];
        $this->form[] = ['label' => 'Work Level', 'name' => 'work_level', 'type' => 'select-c', 'validation' => 'required', "dataquery" => "select id as value,name_en as label from mst_work_level
			order by cast(name_en as unsigned) ", 'cmp-ratio' => '4:12:12'];
        $this->form[] = ['label' => 'Service Type', 'name' => 'work_service_id', 'type' => 'select2-c', 'validation' => 'required', 'datatable' => 'mst_work_service,name_np', 'cmp-ratio' => '4:12:12', "datatable_format" => "name_np,' - ',name_en"];
        $this->form[] = ['label' => 'Service Group', 'name' => 'service_group', 'type' => 'select2-c', 'validation' => 'required', 'datatable' => 'mst_work_service_group,name_np', 'cmp-ratio' => '4:12:12', "datatable_format" => "name_np,' - ',name_en"];
        $this->form[] = ['label' => 'Service Sub Group', 'name' => 'service_subgroup', 'type' => 'select2-c', 'validation' => '', 'datatable' => 'mst_work_service_sub_group,name_np', 'cmp-ratio' => '4:12:12', "datatable_format" => "name_np,' - ',name_en"];

        //$this->form[] = ['label'=>'Job Category','name'=>'job_category_id','type'=>'select2-c','validation'=>'required|min:1|max:255','width'=>'col-sm-10','cmp-ratio'=>'4:12:12','datatable'=>'mst_job_category,name_np'];

        $this->form[] = ['label' => 'Date From BS', 'name' => 'date_from_bs', 'type' => 'date-n', 'validation' => 'required|date|max:255', 'width' => 'col-sm-10', 'cmp-ratio' => '3:12:12'];
        $this->form[] = ['label' => 'Date From AD', 'name' => 'date_from_ad', 'type' => 'date-c', 'validation' => 'required|date', 'width' => 'col-sm-10', 'cmp-ratio' => '3:12:12'];
        $this->form[] = ['label' => 'Date To BS', 'name' => 'date_to_bs', 'type' => 'date-n', 'validation' => 'date|max:255', 'width' => 'col-sm-10', 'cmp-ratio' => '3:12:12'];

        $this->form[] = ['label' => 'Date To AD', 'name' => 'date_to_ad', 'type' => 'date-c', 'validation' => 'date', 'width' => 'col-sm-10', 'cmp-ratio' => '3:12:12'];

        $this->form[] = ['label' => 'माथि उल्लेखित कार्यलयमा तपाई कार्यालय प्रमुख हो वा होइन ?', 'name' => 'is_office_incharge', 'type' => 'radio-c', 'validation' => 'required|integer', 'width' => 'col-sm-10', 'cmp-ratio' => '6:12:12', 'dataenum' => '1|हो; 0|होइन'];
        $this->form[] = ['label' => 'Incharge from BS', 'name' => 'incharge_date_from_bs', 'type' => 'date-n', 'validation' => 'date', 'width' => 'col-sm-10', 'cmp-ratio' => '3:12:12'];
        $this->form[] = ['label' => 'Incharge to BS', 'name' => 'incharge_date_to_bs', 'type' => 'date-n', 'validation' => 'date', 'width' => 'col-sm-10', 'cmp-ratio' => '3:12:12'];

        $this->form[] = ['label' => 'Incharge from AD', 'name' => 'incharge_date_from_ad', 'type' => 'date-c', 'validation' => 'date', 'width' => 'col-sm-10', 'cmp-ratio' => '3:12:12'];
        $this->form[] = ['label' => 'Incharge to AD', 'name' => 'incharge_date_to_ad', 'type' => 'date-c', 'validation' => 'date', 'width' => 'col-sm-10', 'cmp-ratio' => '3:12:12'];

        $this->form[] = ['label' => 'माथि उल्लेखित कार्यलयमा तपाई हाल कार्यरत हो वा होइन ?', 'name' => 'is_current', 'type' => 'radio-c', 'validation' => 'required|integer', 'width' => 'col-sm-10', 'cmp-ratio' => '6:12:12', 'dataenum' => '1|हो; 0|होइन'];
        $this->form[] = ['label' => 'Seniority Date BS', 'name' => 'seniority_date_bs', 'type' => 'date-n', 'width' => 'col-sm-10', 'cmp-ratio' => '3:12:12'];
        $this->form[] = ['label' => 'Seniority Date AD', 'name' => 'seniority_date_ad', 'type' => 'date-c', 'validation' => 'date', 'width' => 'col-sm-10', 'cmp-ratio' => '3:12:12'];

        $this->form[] = ['label' => 'नियुक्ति पत्र', 'name' => 'appointment_letter', 'type' => 'upload-c', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10', 'cmp-ratio' => '4:12:12', 'upload_encrypt' => 'true'];
        $this->form[] = ['label' => 'कोष प्रमाणित पत्र', 'name' => 'distance_certificate', 'type' => 'upload-c', 'validation' => 'min:1|max:255', 'width' => 'col-sm-10', 'cmp-ratio' => '4:12:12', 'upload_encrypt' => 'true'];
        $this->form[] = ['label' => 'कोष प्रमाणित दुरी', 'name' => 'distance_km', 'type' => 'number-c', 'width' => 'col-sm-10', 'cmp-ratio' => '4:12:4'];
        $this->form[] = ['label' => 'रमाना पत्र', 'name' => 'leave_letter', 'type' => 'upload-c', 'validation' => 'required|min:1|max:255', 'width' => 'col-sm-10', 'cmp-ratio' => '4:12:12', 'upload_encrypt' => 'true'];

        if (CRUDBooster::getCurrentMethod() == 'getAdd') {
            $ap_id = Session::get("applicant_id") ? Hashids::decode(Session::get("applicant_id"))[0] : Request::get("applicant_id");
            // old changes
            // Session::get("applicant_id");
            // $query="SELECT aei.certificate_1 as upload,mel.name_en as degree_name,mel.sort_order,med.name_en as division
            // FROM applicant_edu_info aei
            // LEFT JOIN mst_edu_level mel on mel.id=aei.edu_level_id
            // LEFT JOIN mst_edu_division med on med.id=aei.division_id
            // where applicant_id=". Hashids::decode(Session::get("applicant_id"))[0].
            // " ORDER BY mel.sort_order DESC LIMIT 2";
            // $education=DB::select(DB::raw($query));

            // dd($education);
            //dd(count($education));

            // if (CRUDBooster::getCurrentMethod() != 'getAdd') {
            //     $this->form[] = ['label' => 'Minimum Qualification upload', 'name' => 'minimum_qualification_upload', 'validation' => 'max:255', 'cmp-ratio' => '4:12:12', 'type' => 'upload-c'];
            // } else {
            //     $this->form[] = ['label' => 'Minimum Qualification upload', 'name' => 'minimum_qualification_upload', 'validation' => 'max:255', 'cmp-ratio' => '4:12:12', 'value' => $education[0]->upload, 'readonly' => true, 'type' => 'text-c'];
            // }

            // $this->form[] = ['label' => 'Minimum Qualification degree', 'name' => 'minimum_qualification_degree', 'type' => 'text-c', 'validation' => 'required', 'cmp-ratio' => '4:12:12', 'upload_encrypt' => 'true', 'value' => $education[0]->degree_name, 'readonly' => true];
            // $this->form[] = ['label' => 'Minimum Qualification division', 'name' => 'minimum_qualification_division', 'type' => 'text-c', 'validation' => 'required', 'cmp-ratio' => '4:12:12', 'upload_encrypt' => 'true', 'value' => $education[0]->division, 'readonly' => true];
            // $this->form[] = ['label' => 'Additional Qualification upload', 'name' => 'additional_qualification_upload', 'type' => 'upload-c', 'validation' => 'max:255', 'cmp-ratio' => '4:12:12', 'upload_encrypt' => 'true'];
            // $this->form[] = ['label' => 'Additional Qualification degree', 'name' => 'additional_qualification_degree', 'type' => 'text-c', 'validation' => '', 'cmp-ratio' => '4:12:12', 'upload_encrypt' => 'true'];
            // $this->form[] = ['label' => 'Additional Qualification division', 'name' => 'additional_qualification_division', 'type' => 'text-c', 'validation' => 'numeric', 'cmp-ratio' => '4:12:12', 'upload_encrypt' => 'true'];

        }

        $this->form[] = ['label' => 'थप बिषय प्रस्ट पर्न आवश्यक भएमा :', 'name' => 'remarks', 'type' => 'textarea-c', 'validation' => 'string|min:5|max:5000', 'width' => 'col-sm-10', 'cmp-ratio' => '8:12:12'];
        # END FORM DO NOT REMOVE THIS LINE

        # OLD START FORM
        //$this->form = [];
        //$this->form[] = ['label'=>'Applicant Id','name'=>'applicant_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
        //$this->form[] = ['label'=>'Working Office','name'=>'working_office','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
        //$this->form[] = ['label'=>'Designation','name'=>'designation','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
        //$this->form[] = ['label'=>'Service Group','name'=>'service_group','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
        //$this->form[] = ['label'=>'Service Subgroup','name'=>'service_subgroup','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
        //$this->form[] = ['label'=>'Work Level','name'=>'work_level','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
        //$this->form[] = ['label'=>'Job Category Id','name'=>'job_category_id','type'=>'select2','validation'=>'required|min:1|max:255','width'=>'col-sm-10','datatable'=>'mst_job_category,name_np'];
        //$this->form[] = ['label'=>'Date From Bs','name'=>'date_from_bs','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
        //$this->form[] = ['label'=>'Date To Bs','name'=>'date_to_bs','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
        //$this->form[] = ['label'=>'Date From Ad','name'=>'date_from_ad','type'=>'date','validation'=>'required|date','width'=>'col-sm-10'];
        //$this->form[] = ['label'=>'Date To Ad','name'=>'date_to_ad','type'=>'date','validation'=>'required|date','width'=>'col-sm-10'];
        //$this->form[] = ['label'=>'Is Office Incharge','name'=>'is_office_incharge','type'=>'radio','validation'=>'required|integer','width'=>'col-sm-10','dataenum'=>'Array'];
        //$this->form[] = ['label'=>'Contract End Date Ad','name'=>'contract_end_date_ad','type'=>'date','validation'=>'required|date','width'=>'col-sm-10'];
        //$this->form[] = ['label'=>'Contract End Date Bs','name'=>'contract_end_date_bs','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
        //$this->form[] = ['label'=>'Appointment Letter','name'=>'appointment_letter','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
        //$this->form[] = ['label'=>'Distance Certificate','name'=>'distance_certificate','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
        //$this->form[] = ['label'=>'Leave Letter','name'=>'leave_letter','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
        //$this->form[] = ['label'=>'Remarks','name'=>'remarks','type'=>'textarea','validation'=>'required|string|min:5|max:5000','width'=>'col-sm-10'];
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
        $this->load_js[] = asset("js/serviceHistory.js");

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

    public function getExportPdf($id)
    {
        $data['apply_info'] = DB::table('vw_vacancy_applicant')
            ->where('id', $id)
            ->first();
        $applicant_id = $data['apply_info']->applicant_id;
        $vacancy_ad_id=  $data['apply_info']->vacancy_ad_id;


        $data['notice_no']=DB::table('vacancy_ad')->where([['id', $vacancy_ad_id],['is_deleted',false]])->select('notice_no')->first();


        $level = (int) $data['apply_info']->work_level - 1;
        $work_level_id = DB::table('mst_work_level')->where('name_en', $level)->first();

        $data['service_history'] = DB::select('SELECT DISTINCT
		eo.district AS district,
		mwo.name_en AS working_office,
		ash.date_from_ad,
		ash.date_to_ad,
        ash.date_from_bs,
		ash.date_to_bs,
		ash.is_current,
		ash.is_office_incharge,
		ash.incharge_date_from_ad,
		ash.incharge_date_to_ad
	FROM
		applicant_service_history ash
		LEFT JOIN mst_working_office mwo ON ash.working_office = mwo.id
		LEFT JOIN erp_organization eo ON ( eo.working_office_id = ash.working_office AND eo.district IS NOT NULL )
	WHERE
		ash.applicant_id =:id
		AND ash.is_deleted IS FALSE', ['id' => $applicant_id]);

        $seniority_date = DB::table('applicant_service_history')->where([['is_current', 1], ['applicant_id', $data['apply_info']->applicant_id]])->first();

        if (count($data['service_history']) > 0) {
            $data['service_history'][0]->date_from_bs = $seniority_date->seniority_date_bs;
            $lastkey = count($data['service_history']) - 1;
            $data['service_history'][$lastkey]->date_to_bs = $this->ShrawanLastBs(explode('-', $data['apply_info']->published_date_ad)[0]);
        }
        $data['current_position'] = DB::table('applicant_service_history as ash')
            ->select(
                'md.name_en as designation',
                'mwl.name_en as work_level',
                'sg.name_np as service_group',
                'ssg.name_np as service_sub_group',
                'seniority_date_bs'
            )
            ->leftjoin('mst_designation as md', 'md.id', '=', 'ash.designation')
            ->leftjoin('mst_work_level as mwl', 'mwl.id', '=', 'ash.work_level')

            ->leftjoin('mst_work_service_group as sg', 'ash.service_group', '=', 'sg.id')
            ->leftjoin('mst_work_service_sub_group as ssg', 'ash.service_subgroup', '=', 'ssg.id')
            ->where([['ash.applicant_id', $data['apply_info']->applicant_id], ['ash.is_current', 1]])
            ->first();

        $data['education'] = DB::table('applicant_edu_info as edu')
            ->select('edu.certificate_1', 'ed.name_en', 'edu.degree_name', 'edu.university', 'edu.specialization', 'edv.name_en as division', 'my.year_bs as passed_year_bs', 'edu.passed_year_ad')
            ->leftjoin('mst_edu_degree as ed', 'ed.id', '=', 'edu.edu_degree_id')
            ->leftjoin('mst_edu_division as edv', 'edv.id', '=', 'edu.division_id')
            ->leftjoin('mst_year as my','edu.passed_year_bs','=','my.id')
            ->where([['edu.applicant_id', $data['apply_info']->applicant_id], ['edu.is_deleted', false]])
            ->orderBy('edu.passed_year_ad', 'desc')
            ->get();

        $data['ad_no'] = $ad_no = DB::table('vacancy_ad')
            ->select('ad_title_en')
            ->where('id', $data['apply_info']->vacancy_ad_id)
            ->get();

        $data['sewa'] = $sewa = DB::table('vacancy_ad')
            ->select('ad_title_en')
            ->where('id', $data['apply_info']->vacancy_ad_id)
            ->get();

        $data['office_incharge'] = DB::table('applicant_service_history as ash')
            ->select(
                'md.name_en as district',
                'mw.name_en as working_office',
                'ash.is_office_incharge',
                'ash.incharge_date_from_bs',
                'ash.incharge_date_to_bs',
                'ash.leave_letter'
            )
            ->leftjoin('mst_working_office as mw', 'mw.id', '=', 'ash.working_office')
            ->leftjoin('mst_district as md', 'md.id', '=', 'mw.district_id')
            ->where([['ash.applicant_id', $applicant_id], ['ash.is_office_incharge', true], ['ash.is_deleted', false]])
            ->orderBy('ash.date_from_ad')
            ->get();

        $data['address'] = $address = DB::table('applicant_profile as ap')
            ->select(
                'md.name_en as temp_district',
                'mll.name_en as temp_local_level',
                'ap.temp_ward_no',
                'ap.temp_tole_name',

                'pmd.name_en as perm_district',
                'pmll.name_en as perm_local_level',
                'ap.ward_no',
                'ap.tole_name',

                'cmd.name_en as citizenship_issued_district'
            )
            ->leftjoin('mst_local_level as mll', 'ap.temp_local_level_id', '=', 'mll.id')
            ->leftjoin('mst_local_level as pmll', 'ap.local_level_id', '=', 'pmll.id')

            ->leftjoin('mst_district as md', 'ap.temp_district_id', '=', 'md.id')
            ->leftjoin('mst_district as pmd', 'ap.district_id', '=', 'pmd.id')

            ->leftjoin('mst_district as cmd', 'ap.citizenship_issued_from', '=', 'cmd.id')
            ->where('user_id', $data['apply_info']->applicant_id)
            ->get();
        $view = View::make('exports.applicantProfile', $data);



        return $view;

//        $pdf->loadHTML($view);
//        return $pdf->inline();

//        $pdf = PDF::loadView('exports.applicantProfile', $data);
//        return $pdf->download('invoice.pdf');

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
//    public function hook_query_index(&$query)
//    {
//        //Your code here
//        $vacancy_apply_id = Request::get("va_id");
//
//        // dd($vacancy_apply_id);
//        if (isset($vacancy_apply_id)) {
//            $vacancy_post = DB::table('vacancy_apply')
//                ->select('vacancy_post_id')
//                ->where('id', $vacancy_apply_id)
//                ->first();
//            $vacancy_ad = DB::table('vacancy_post')
//                ->select('vacancy_ad_id')
//                ->where('id', $vacancy_post->vacancy_post_id)
//                ->first();
//            $opening_type = DB::table('vacancy_ad')
//                ->select('opening_type_id')
//                ->where('id', $vacancy_ad->vacancy_ad_id)
//                ->first();
//
//                // dd($opening_type->opening_type_id );
//
//            if ($opening_type->opening_type_id != 4) {
//
//                // dd('devs');
//
//                if (CRUDBooster::myPrivilegeId() == 1 || CRUDBooster::myPrivilegeId() == 5) {
//                    $applicant_id = Request::get("applicant_id");
//                    $vacancy_apply_id = Request::get("va_id");
//
//                    $data['apply_info'] = DB::table('vw_vacancy_applicant_file_pormotion')
//                        ->where('id', $vacancy_apply_id)
//                        ->first();
//
//                    $level = (int) $data['apply_info']->work_level - 1;
//
//                    $work_level_id = DB::table('mst_work_level')->where('name_en', $level)->first();
//
//                    $MergedDataExists = DB::table('merged_applicant_service_history')->where([['applicant_id', $applicant_id], ['vacancy_apply_id', $vacancy_apply_id]])->get();
//                    $mrd = collect($MergedDataExists);
//                    $count = count($mrd);
//
//                    if ($count < 1) {
//                        $this->data['erp_data'] = $this->getErpData($applicant_id);
//
//                        //dd($applicant_id, $work_level_id->id);
//
//                        $recruit_data = DB::select(
//                            'SELECT
//					mwo.name_en as working_office
//					,mwo.id as working_office_id
//					,md.name_en as designation
//					,md.id as designation_id
//					,mwsg.name_en as service_group
//					,mwsg.id as service_group_id
//					,mwl.name_en as work_level
//					,mwl.id as work_level_id
//					,ash.date_from_ad
//					,ash.date_to_ad
//					,ash.date_from_bs
//					,ash.date_to_ad
//					,ash.date_to_bs
//					,ash.seniority_date_ad
//					,ash.seniority_date_bs
//					,case when ash.is_office_incharge = 1 then "YES" ELSE "NO" END as is_office_incharge
//					,ash.incharge_date_from_ad
//					,ash.incharge_date_to_ad
//					,ash.incharge_date_to_bs
//					,ash.incharge_date_from_bs
//					,case when ash.is_current = 1 then "YES" ELSE "NO" END as is_current
//					FROM applicant_service_history ash
//					LEFT JOIN mst_working_office mwo ON mwo.id=ash.working_office
//					LEFT JOIN mst_designation md ON md.id=ash.designation
//					LEFT JOIN mst_work_service_group mwsg ON mwsg.id=ash.service_group
//					LEFT JOIN mst_work_service_sub_group mwssg ON mwssg.id=ash.service_subgroup
//					LEFT JOIN mst_work_level mwl ON mwl.id=ash.work_level
//					WHERE ash.applicant_id=:applicant_id and ash.work_level=:work_level and ash.is_deleted is false
//					ORDER BY date_from_bs', ['applicant_id' => $applicant_id, 'work_level' => $work_level_id->id]
//                        );
//                        $this->InsertInitMergedData($recruit_data, $this->data['erp_data']);
//                    }
//
//                    //dd($recruit_data);
//                    $this->data['erp_data'] = $this->getErpData($applicant_id);
//                    // dd($this->data['erp_data'],$this->transformToRecruitTypeData($this->data['erp_data']));
//                    $this->data['erp_data'] = $this->transformToRecruitTypeData($this->data['erp_data']);
//                    $recruit_merged_data = DB::select(
//                        'SELECT
//				ash.id as id
//				,cu.email as verified_by
//				,cm.email as approved_by
//				,cms.email as approved_on
//				,mwo.name_en as working_office
//				,mwo.id as working_office_id
//				,md.name_en as designation
//				,md.id as designation_id
//				,mwsg.name_en as service_group
//				,mwsg.id as service_group_id
//				,mwl.name_en as work_level
//				,mwl.id as work_level_id
//				,ash.date_from_ad
//				,ash.date_from_bs
//				,ash.date_to_ad
//				,ash.date_to_bs
//				,case when ash.is_office_incharge = 1 then "YES" ELSE "NO" END as is_office_incharge
//				,ash.incharge_date_from_ad
//				,ash.incharge_date_to_ad
//				,ash.incharge_date_to_bs
//				,ash.incharge_date_from_bs
//				,case when ash.is_current = 1 then "YES" ELSE "NO" END as is_current
//				,ash.seniority_date_ad
//				,ash.seniority_date_bs
//				,ash.flag
//				,ash.mismatched_key
//				,ash.is_verified
//				,ash.is_approved
//				,ash.verified_on
//				,ash.approved_on
//				FROM merged_applicant_service_history ash
//				LEFT JOIN mst_working_office mwo ON mwo.id=ash.working_office
//				LEFT JOIN mst_designation md ON md.id=ash.designation
//				LEFT JOIN mst_work_service_group mwsg ON mwsg.id=ash.service_group
//				LEFT JOIN mst_work_service_sub_group mwssg ON mwssg.id=ash.service_subgroup
//				LEFT JOIN mst_work_level mwl ON mwl.id=ash.work_level
//				LEFT JOIN cms_users cu ON cu.id=ash.verified_by
//				LEFT JOIN cms_users cm ON cm.id=ash.approved_by
//				LEFT JOIN cms_users cms ON cms.id=ash.approved_on
//				WHERE applicant_id=:applicant_id and vacancy_apply_id=:vacancy_apply_id
//				ORDER BY date_from_bs', ['applicant_id' => $applicant_id, 'vacancy_apply_id' => $vacancy_apply_id]
//                    );
//                    $MergedData = $recruit_merged_data;
//                    $date = array();
//
//                    foreach ($MergedData as $key => $row) {
//                        $date[$key] = $row->date_from_bs;
//                    }
//                    array_multisort($date, SORT_ASC, $MergedData);
//                    $this->data['merged'] = $MergedData;
//                }
//            }
//        }
//        parent::hook_query_index($query);
//    }

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
        //Your code here
        // dd($postdata);

        $encoded_applicant_id = Session::get('applicant_id');
        $applicant_id = Hashids::decode($encoded_applicant_id);

        $current_data_exist = DB::table('applicant_service_history')
            ->where([['is_current', 1], ['applicant_id', $applicant_id[0]], ['working_office', $postdata['working_office']]])
            ->first();

        // dd($current_data_exist);

        if ($current_data_exist) {
            CRUDBooster::redirect(CRUDBooster::mainpath() . '?applicant_id=' . $applicant_id[0], 'हाल कार्यरत को डाटा एक भन्दा बढी हाल्न मिल्दैन।', 'warning');
        }

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
    public function ShrawanLastBs($year)
    {
        $nepaliDate = Helper::get_nepali_date($year, 7, 16);

        if ((int) $nepaliDate['month'] == 3) {
            return $nepaliDate['year'] . '-' . $nepaliDate['month'] . '-' . $nepaliDate['date'];
        }
        $nepaliDate = Helper::get_nepali_date($year, 7, 15);
        if ((int) $nepaliDate['month'] == 3) {
            return $nepaliDate['year'] . '-' . $nepaliDate['month'] . '-' . $nepaliDate['date'];
        }
        $nepaliDate = Helper::get_nepali_date($year, 7, 14);
        if ((int) $nepaliDate['month'] == 3) {
            return $nepaliDate['year'] . '-' . $nepaliDate['month'] . '-' . $nepaliDate['date'];
        }
        $nepaliDate = Helper::get_nepali_date($year, 7, 13);
        if ((int) $nepaliDate['month'] == 3) {
            return $nepaliDate['year'] . '-' . $nepaliDate['month'] . '-' . $nepaliDate['date'];
        }
    }
    public function getErpData($applicant_id)
    {
        $emp_no = DB::table('applicant_profile')->select('nt_staff_code')->where('id', $applicant_id)->first();

        $erp_data = DB::select(
            'SELECT
            distinct
				t1.start_date AS date_from_ad,
         		t1.end_date AS date_to_ad,
				t1.job_id,
				t1.org_id,
				t1.seniority_date_bs AS seniority_date_bs,
				t1.seniority_Date AS seniority_date_ad,
				t5.name_en AS working_office,
				t5.id AS working_office_id,
				t7.name_en AS designation,
				t7.id AS designation_id,
				t8.name_en AS service_group,
				t8.id AS service_group_id,
				t9.name_en AS work_level,
				t9.id AS work_level_id,
				CASE
					WHEN t1.incharge = 1 THEN \'YES\'
					ELSE \'NO\'
				END AS is_office_incharge,
				CASE
					WHEN t1.incharge = 1 THEN t1.start_date
					ELSE NULL
				END AS incharge_date_from_ad,
				CASE
					WHEN t1.incharge = 1 THEN t1.end_date
					ELSE NULL
				END AS incharge_date_to_ad
				FROM erp_service_history t1
				INNER JOIN applicant_profile t4 ON t4.nt_staff_code = t1.emp_no
				LEFT JOIN erp_organization t3 ON t3.id = t1.org_id
				LEFT JOIN mst_working_office t5 ON t5.id = t3.working_office_id
				LEFT JOIN erp_jobs t6 ON t6.id = t1.job_id
				LEFT JOIN mst_designation t7 ON t7.id = t6.designation_id
				LEFT JOIN mst_work_service_group t8 ON t8.id = t6.service_group_id
				LEFT JOIN mst_work_level t9 ON t9.name_en = t1.grade
				WHERE t1.emp_no=:emp_no and t1.seniority_Date=(SELECT MAX(seniority_Date) from erp_service_history WHERE emp_no=:emp_no1)
				ORDER by t1.start_date', ['emp_no' => $emp_no->nt_staff_code, 'emp_no1' => $emp_no->nt_staff_code]
        );

        // $erp_data=$this->removeDuplicatieData($erp_data);
        foreach ($erp_data as $key => $erd) {
            $date_from = explode('-', $erd->date_from_ad);
            if ((int) $date_from[0] <= 2022 && (int) $date_from[0] >= 1944) {
                // $date_from_bs = Bsdate::eng_to_nep($date_from[0], $date_from[1], $date_from[2]);

                // dd()
                $date_from_bs = Helper::get_nepali_date($date_from[0], $date_from[1], $date_from[2]);
                $erp_data[$key]->date_from_bs = $date_from_bs['year'] . '-' . $date_from_bs['month'] . '-' . $date_from_bs['date'];
            }
            $date_to = explode('-', $erd->date_to_ad);
            if ((int) $date_to[0] <= 2022 && (int) $date_to[0] >= 1944) {
                // $date_to_bs = Bsdate::eng_to_nep($date_to[0], $date_to[1], $date_to[2]);
                $date_to_bs =  Helper::get_nepali_date($date_to[0], $date_to[1], $date_to[2]);
                $erp_data[$key]->date_to_bs = $date_to_bs['year'] . '-' . $date_to_bs['month'] . '-' . $date_to_bs['date'];
            }
            $incharge_date_from = explode('-', $erd->incharge_date_from_ad);
            if ((int) $incharge_date_from[0] <= 2022 && (int) $incharge_date_from[0] >= 1944) {
                $incharge_date_from_bs = Helper::get_nepali_date($incharge_date_from[0], $incharge_date_from[1], $incharge_date_from[2]);
                $erp_data[$key]->incharge_date_from_bs = $incharge_date_from_bs['year'] . '-' . $incharge_date_from_bs['month'] . '-' . $incharge_date_from_bs['date'];
            }
            $incharge_date_to = explode('-', $erd->incharge_date_to_ad);
            if ((int) $incharge_date_to[0] <= 2022 && (int) $incharge_date_to[0] >= 1944) {
                $incharge_date_to_bs = Helper::get_nepali_date($incharge_date_to[0], $incharge_date_to[1], $incharge_date_to[2]);
                $erp_data[$key]->incharge_date_to_bs = $incharge_date_to_bs['year'] . '-' . $incharge_date_to_bs['month'] . '-' . $incharge_date_to_bs['date'];
            }
        }
        return $erp_data;
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
                if ($recruit->working_office == $erp->working_office && $recruit->designation == $erp->designation && $recruit->date_from_bs == $erp->date_from_bs) {
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
                if ($recruit->working_office == $erp->working_office && $recruit->designation == $erp->designation && $recruit->date_from_bs == $erp->date_from_bs) {
                    $not_in_erp = false;
                    $arr1 = json_decode(json_encode($recruit), true);
                    $arr2 = json_decode(json_encode($erp), true);
                    $result = array_diff_assoc($arr2, $arr1);
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
    public function transformToRecruitTypeData($arr)
    {
        $trasformarr = [];

        // $lastkey=count($arr)-1;
        foreach ($arr as $key => $array) {
            if ($array->date_to_ad == null) {
                $arr[$key]->is_current = "YES";
            } else {
                $arr[$key]->is_current = "NO";
                unset($arr[$key]->seniority_date_ad);
                unset($arr[$key]->seniority_date_bs);
            }
        }
        $duplicate = 0;
        $arr = array_reverse($arr);
        foreach ($arr as $key => $array) {
            foreach ($arr as $key2 => $array2) {
                if ($array->job_id == $array2->job_id && $array->org_id == $array2->org_id) {
                    $duplicate++;
                    if ($duplicate > 1) {
                        //if work is continuos and only change in incharge day
                        $date = new DateTime($array2->date_to_ad);
                        $date->modify('+1 day');
                        if ($date->format('Y-m-d') == $array->date_from_ad) {
                            if (isset($array2->incharge_date_from_ad)) {
                                if ($arr[$key]->incharge_date_from_ad > $array2->incharge_date_from_ad) {
                                    $arr[$key]->incharge_date_from_ad = $array2->incharge_date_from_ad;
                                }

                                if ($arr[$key]->incharge_date_to_ad < $array2->incharge_date_to_ad) {
                                    $arr[$key]->incharge_date_to_ad = $array2->incharge_date_to_ad;
                                }

                            }
                            $arr[$key]->date_from_ad = $array2->date_from_ad;
                            $arr[$key]->date_from_bs = $array2->date_from_bs;
                            unset($arr[$key2]);
                        }
                    }
                }
            }
            $duplicate = 0;
        }
        $arr = array_reverse($arr);
        foreach ($arr as $key => $array) {
            unset($arr[$key]->org_id);
            unset($arr[$key]->job_id);
        }
        return $arr;
    }
    // $arr1=$recruit_data and $arr2=$erp_data
    public function InsertInitMergedData($arr1, $arr2)
    {
        $applicant_id = Request::get("applicant_id");
        $vacancy_apply_id = Request::get("va_id");
        $arr2 = $this->transformToRecruitTypeData($arr2);
        $common_data = $this->getIdenticalData($arr1, $arr2);
        $ComparedData = $this->CompareArray($arr1, $arr2);
        $MergedData = $this->MergeArray($common_data, $ComparedData[0], $ComparedData[1], $ComparedData[2]);

        foreach ($MergedData as $key => $MergedData) {
            $mismatchedkey = isset($MergedData["mismatched_keys"]) ? $MergedData["mismatched_keys"] : "";
            $distance_exist = DB::table('applicant_service_history')
                ->select('distance_km')
                ->where([['applicant_id', $applicant_id], ['work_level', $MergedData["work_level_id"]], ['working_office', $MergedData["working_office_id"]], ['service_group', $MergedData["service_group_id"]]])
                ->first();
            if ($distance_exist) {
                $distance_km = $distance_exist->distance_km;
            } else {
                $distance_km = 0;
            }

            DB::table('merged_applicant_service_history')->insert([
                'vacancy_apply_id' => $vacancy_apply_id,
                'applicant_id' => $applicant_id,
                'working_office' => $MergedData["working_office_id"],
                'designation' => $MergedData["designation_id"],
                'service_group' => $MergedData["service_group_id"],
                'work_level' => $MergedData["work_level_id"],
                'date_from_bs' => $MergedData["date_from_bs"],
                'date_from_ad' => $MergedData["date_from_ad"],
                'date_to_bs' => $MergedData["date_to_bs"],
                'date_to_ad' => $MergedData["date_to_ad"],
                'is_office_incharge' => $MergedData["is_office_incharge"] == "YES" ? 1 : 0,
                'incharge_date_from_bs' => $MergedData["incharge_date_from_bs"],
                'incharge_date_from_ad' => $MergedData["incharge_date_from_ad"],
                'incharge_date_to_bs' => $MergedData["incharge_date_to_bs"],
                'incharge_date_to_ad' => $MergedData["incharge_date_to_ad"],
                'is_current' => $MergedData["is_current"] == "YES" ? 1 : 0,
                'seniority_date_bs' => $MergedData["seniority_date_bs"],
                'seniority_date_ad' => $MergedData["seniority_date_ad"],
                'flag' => $MergedData["flag"],
                'mismatched_key' => $mismatchedkey,
                'distance_km' => $distance_km,
            ]);
        }
    }
}
