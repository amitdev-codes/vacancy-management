<?php namespace App\Http\Controllers;

use CRUDBooster;
use DB;
// use Hashids;
use Request;
use Session;
use Vinkla\Hashids\Facades\Hashids;

class AdminApplicantLeaveDetailsController extends ApplicantCBController
{

    public function cbInit()
    {
        # START CONFIGURATION DO NOT REMOVE THIS LINE
        $this->table = "applicant_leave_details";
        $this->title_field = "id";
        $this->limit = 20;
        $this->orderby = "id,desc";
        $this->show_numbering = false;
        $this->global_privilege = false;
        $this->button_table_action = true;
        $this->button_action_style = "button_icon";
        $this->button_detail = true;
        $this->button_show = true;
        $this->button_filter = true;
        $this->button_export = false;
        $this->button_import = false;
        $this->button_bulk_action = false;

        if (CRUDBooster::myPrivilegeId() == 4) {
            $this->getIndex_view = "default.applicant_leave.leave_index";
        } else {
            $this->button_add = true;
            $this->button_delete = true;
            $this->button_edit = true;
            // $this->getIndex_view = "default.applicant_leave.leave_comparison";
            // $this->getIndex_view = "applicantProfile.leave";


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
                              //dd('devs');
                            $this->getIndex_view = "appliedApplicants.leave";
                          
                        }else{
                            //dd('hello');
                            $this->getIndex_view = "applicantProfile.leave";
                        }
                    }else{
                        $this->getIndex_view = "applicantProfile.leave";
                    }
                }
            }else{
                $this->getIndex_view = "applicantProfile.leave";
            }
    


        }
        # END CONFIGURATION DO NOT REMOVE THIS LINE

        # START COLUMNS DO NOT REMOVE THIS LINE
        $this->col = array();
        $this->col[] = array("label" => "Emp No", "name" => "emp_no");
        // $this->col[] = array("label" => "Applicant Id", "name" => "applicant_id", "join" => "applicant_profile,id");
        $this->col[] = array("label" => "Leave Type Id", "name" => "leave_type_id", "join" => "mst_leave_type,name_en");
        $this->col[] = array("label" => "Date From Bs", "name" => "date_from_bs");
        $this->col[] = array("label" => "Date To Bs", "name" => "date_to_bs");
        $this->col[] = array("label" => "Date From Ad", "name" => "date_from_ad");
        $this->col[] = array("label" => "Date To Ad", "name" => "date_to_ad");
        $this->col[] = array("label" => "Leave file", "name" => "file_uploads", "image" => true);

        # END COLUMNS DO NOT REMOVE THIS LINE
        # START FORM DO NOT REMOVE THIS LINE
        $this->form = [];
        //$this->form[] = ["label" => "Emp No", "name" => "emp_no", "type" => "text", "required" => true, "validation" => "required|min:1|max:255"];
        // $this->form[] = ["label" => "Applicant Id", "name" => "applicant_id", "type" => "select2", "required" => true, "validation" => "required|integer|min:0", "datatable" => "applicant_profile,id"];
        $this->form[] = ["label" => "Leave Type Id", "name" => "leave_type_id", "type" => "select2-c", "required" => true, "validation" => "required|min:1|max:255", "datatable" => "mst_leave_type,name_en", 'cmp-ratio' => '6:12:12'];
        $this->form[] = ["label" => "Date From Bs", "name" => "date_from_bs", "type" => "date-n", "required" => true, "validation" => "required|min:1|max:255", 'cmp-ratio' => '6:12:12'];
        $this->form[] = ["label" => "Date To Bs", "name" => "date_to_bs", "type" => "date-n", "required" => true, "validation" => "required|min:1|max:255", 'cmp-ratio' => '6:12:12'];
        $this->form[] = ["label" => "Date From Ad", "name" => "date_from_ad", "type" => "date-c", "required" => true, "validation" => "required|date", 'cmp-ratio' => '6:12:12'];
        $this->form[] = ["label" => "Date To Ad", "name" => "date_to_ad", "type" => "date-c", "required" => true, "validation" => "required|date", 'cmp-ratio' => '6:12:12'];
        $this->form[] = ["label" => "File Upload", "name" => "file_uploads", 'type' => 'upload-c', 'validation' => 'required|image|max:200', 'cmp-ratio' => '4:12:12', 'help' => 'File type: JPG, JPEG, PNG, GIF, BMP', 'upload_encrypt' => 'true'];
        $this->form[] = ["label" => "Remarks", "name" => "remarks", "type" => "text-c", 'cmp-ratio' => '6:12:12'];
        // $this->form[] = ["label" => "Is Deleted", "name" => "is_deleted", "type" => "radio", "required" => true, "validation" => "required|integer", "dataenum" => "Array"];

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
        $this->script_js = " $(document).ready(function(){
			$('#date_from_ad').change(function(){ convertAdtoBs('#date_from_ad','#date_from_bs'); });
			$('#date_from_bs').change(function(){ convertBstoAd('#date_from_bs','#date_from_ad'); });
			$('#date_to_ad').change(function(){ convertAdtoBs('#date_to_ad','#date_to_bs'); });
			$('#date_to_bs').change(function(){ convertBstoAd('#date_to_bs','#date_to_ad'); });
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
        // dd('devs');
        $vacancy_apply_id = Request::get("va_id");
        if (isset($vacancy_apply_id)) {
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

            // dd('dev');

            if ($opening_type->opening_type_id == 3) {

                // dd('dev');

                if (CRUDBooster::myPrivilegeId() == 1 || CRUDBooster::myPrivilegeId() == 5) {
                    $applicant_id = Request::get("applicant_id");
                    $vacancy_apply_id = Request::get("va_id");

                    $data['apply_info'] = DB::table('vw_vacancy_applicant_file_pormotion')
                        ->where('id', $vacancy_apply_id)
                        ->first();

                    $level = (int) $data['apply_info']->work_level - 1;
                    $work_level_id = DB::table('mst_work_level')->where('name_en', $level)->first();

                    $MergedDataExists = DB::table('merged_applicant_leave_detail')
                        ->where([['applicant_id', $applicant_id], ['vacancy_apply_id', $vacancy_apply_id]])->get();

                    if (count($MergedDataExists) == 0) {
                        $this->data['erp_data'] = $this->getErpData($applicant_id);

                        $recruit_data = DB::select(
                            'SELECT
                            emp_no,
                            leave_type_id,
                            date_from_bs,
                            date_to_bs,
                            date_from_ad,
                            date_to_ad,
                            file_uploads,
                            remarks
                        FROM
                            applicant_leave_details
                        WHERE
                            applicant_id =:applicant_id
                            AND is_deleted IS FALSE', ['applicant_id' => $applicant_id]
                        );
                        $this->InsertInitMergedData($recruit_data, $this->data['erp_data']);
                    }
                    $this->data['erp_data'] = $this->getErpData($applicant_id);
                    $recruit_merged_data = DB::select(
                        'SELECT
                        mad.id,
                        mad.emp_no,
                        -- mad.leave_type_id,
                        mad.leave_type_id,
                        mlt.name_en as leave_type,
                        mad.date_from_bs,
                        mad.date_to_bs,
                        mad.date_from_ad,
                        mad.date_to_ad,
                        mad.file_uploads,
                        mad.remarks,
                        mad.is_verified,
                        cu.email as verified_by,
                        mad.verified_on,
                        cm.email as approved_by,
                        mad.approved_on,
                        mad.is_approved,
                        mad.flag,
                        mad.mismatched_key
                    FROM
                        merged_applicant_leave_detail as mad
                           LEFT JOIN cms_users cu ON cu.id=mad.verified_by
   				           LEFT JOIN cms_users cm ON cm.id=mad.approved_by
                           LEFT JOIN mst_leave_type mlt  ON mlt.id=mad.leave_type_id

                    WHERE
                    applicant_id =:applicant_id
                    AND vacancy_apply_id=:vacancy_apply_id
                        AND mad.is_deleted IS FALSE', ['applicant_id' => $applicant_id, 'vacancy_apply_id' => $vacancy_apply_id]
                    );

                    $MergedData = $recruit_merged_data;
                    $date = array();

                    foreach ($MergedData as $key => $row) {
                        $date[$key] = $row->date_from_bs;
                    }
                    array_multisort($date, SORT_ASC, $MergedData);
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
        
        //Your code here
        $encoded_applicant_id = Session::get('applicant_id');
        $emp_no = Session::get('nt_staff_code');
        $applicant_id = Hashids::decode($encoded_applicant_id);

        $postdata['applicant_id'] = $applicant_id[0];
        $postdata['emp_no'] = $emp_no;
        //$postdata['encoded_applicant_id'] = $encoded_applicant_id;

        //dd($postdata);

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
        //dd($id);
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

    public function getErpData($applicant_id)
    {
        $emp_no = DB::table('applicant_profile')->select('nt_staff_code')->where('id', $applicant_id)->first();

        $erp_data = DB::select('SELECT
        eld.emp_no,
        eld.leave_type_id,
        mlt.name_en as leave_type,
        eld.date_from_bs,
        eld.date_to_bs,
        eld.date_from_ad,
        eld.date_to_ad,
        eld.imported_by,
        eld.imported_mode,
        eld.remarks,
        eld.erp_file_uploads_id as file_uploads
    FROM
        erp_leave_details as eld
        LEFT JOIN mst_leave_type mlt  ON mlt.id=eld.leave_type_id
    WHERE
        emp_no =:emp_no
        AND eld.is_deleted IS FALSE', ['emp_no' => $emp_no->nt_staff_code]
        );
        return $erp_data;
    }

    public function InsertInitMergedData($arr1, $arr2)
    {
        $applicant_id = Request::get("applicant_id");
        $vacancy_apply_id = Request::get("va_id");

        $common_data = $this->getIdenticalData($arr1, $arr2);
        $ComparedData = $this->CompareArray($arr1, $arr2);
        $MergedData = $this->MergeArray($common_data, $ComparedData[0], $ComparedData[1], $ComparedData[2]);

        foreach ($MergedData as $key => $MergedData) {
            $mismatchedkey = isset($MergedData["mismatched_keys"]) ? $MergedData["mismatched_keys"] : "";

            DB::table('merged_applicant_leave_detail')->insert([
                'vacancy_apply_id' => $vacancy_apply_id,
                'applicant_id' => $applicant_id,
                'emp_no' => $MergedData["emp_no"],
                'leave_type_id' => $MergedData["leave_type_id"],
                'date_from_bs' => $MergedData["date_from_bs"],
                'date_from_ad' => $MergedData["date_from_ad"],
                'date_to_bs' => $MergedData["date_to_bs"],
                'date_to_ad' => $MergedData["date_to_ad"],
                'remarks' => $MergedData["remarks"],
                'file_uploads' => $MergedData["file_uploads"],
                'flag' => $MergedData["flag"],
                'mismatched_key' => $mismatchedkey,
            ]);
        }
    }

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
                if ($recruit->emp_no == $erp->emp_no && $recruit->leave_type_id == $erp->leave_type_id && $recruit->date_from_bs == $erp->date_from_bs) {
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
                if ($recruit->emp_no == $erp->emp_no && $recruit->leave_type_id == $erp->leave_type_id && $recruit->date_from_bs == $erp->date_from_bs) {
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

    //By the way, you can still create your own method in here... :)

}
