<?php namespace App\Http\Controllers;

use CRUDBooster;
use DB;
use Session;
use App\Helpers\Helper;

class AdminCsvFilesUploadingController extends BaseCBController
{

    public function cbInit()
    {
        # START CONFIGURATION DO NOT REMOVE THIS LINE
        $this->table = "erp_file_uploads";
        $this->title_field = "table_name";
        $this->limit = 20;
        $this->orderby = "id,desc";
        $this->show_numbering = false;
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
        $this->col[] = ["label" => "Table", "name" => "table_name"];
        $this->col[] = ["label" => "Uploaded by", "name" => "uploader_user_id", "join" => "cms_users,name"];
        $this->col[] = ["label" => "Uploaded Date Ad", "name" => "uploaded_date_ad"];
        $this->col[] = ["label" => "Uploaded Date Bs", "name" => "uploaded_date_bs"];

        $this->col[] = ["label" => "File Path", "name" => "file_path", "callback" => function ($row) {
            $f = explode("/", $row->file_path);
            if ($f && count($f) > 0) {
                return $f[count($f) - 1];
            }
            return $row->file_path;
        }];
        $this->col[] = ["label" => "File Path", "name" => "file_path", "download" => "Y"];
        $this->col[] = ["label" => "Imported At", "name" => "imported_at"];
        $this->col[] = ["label" => "Imported Mode ", "name" => "imported_mode"];
        $this->col[] = ["label" => "Task Status", "name" => "case when task_status = 1 then 'YES' ELSE 'NO' END as task_status"];
        $this->col[] = ["label" => "Remarks ", "name" => "remarks"];

        # END COLUMNS DO NOT REMOVE THIS LINE
        $this->form = [];
        //    $this->form[] = ['label' => 'Uploader User', 'name' => 'uploader_user_id', 'type' => 'text-c', 'cmp-ratio' => '12:2:10', 'value' => CRUDBooster::myId(), "visible" => false];
        $this->form[] = ['label' => 'Date Bs', 'name' => 'uploaded_date_bs', 'type' => 'date-n', 'validation' => 'required|max:10', 'cmp-ratio' => '6:6:12'];
        $this->form[] = ['label' => 'Date Ad', 'name' => 'uploaded_date_ad', 'type' => 'date-c', 'validation' => 'required|date', 'cmp-ratio' => '6:6:12'];
        $this->form[] = ["label" => "Table Name", "name" => "table_name", "type" => "select2-c", "required" => true, "validation" => "required|min:1|max:255", 'cmp-ratio' => '6:6:12', 'dataenum' => 'erp_jobs;erp_organization;erp_organization_district;erp_qualification;erp_applicant_qualification;erp_service_history;erp_department_action;applicant_leave_details;applicant_absent_details;erp_leave_details;erp_absent_details'];
        $this->form[] = ['label' => 'File Path', 'name' => 'file_path', 'type' => 'upload-c', 'cmp-ratio' => '6:6:12'];
        // $this->form[] = ['label' => 'Task Status', 'name' => 'task_status', 'type' => 'radio-c', 'class' => 'task_status', 'cmp-ratio' => '6:6:12', 'dataenum' => '1|Yes ; 0|No'];
        # END FORM DO NOT REMOVE THIS LINE
        //    $this->form[] = ['label' => 'Task Status', 'name' => 'task_status', 'type' => 'textarea-c', 'validation' => 'max:2000', 'cmp-ratio' => '4:2:10', "readonly" => "readonly"];

        $this->form[] = ['label' => 'Remarks', 'name' => 'remarks', 'type' => 'textarea-c', 'validation' => 'max:500', 'cmp-ratio' => '6:6:12'];

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
        $this->addaction[] = ['label' => 'Import/Link', 'url' => CRUDBooster::mainpath('import/[id]'), 'icon' => 'fa fa-link', 'color' => 'success'];

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
        $this->script_js = "$(document).ready(function(){
				$('#uploaded_date_ad').change(function(){
					convertAdtoBs('#uploaded_date_ad','#uploaded_date_bs');
				});
					$('#uploaded_date_bs').change(function(){
								convertBstoAd('#uploaded_date_bs','#uploaded_date_ad');
						});
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

    public function importData($id = null)
    {
        ini_set('max_execution_time', 0);
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        if (isset($id) && $id > 0) {
            $id = \intval($id);

            // dd($id);
            $csvFile = DB::table("erp_file_uploads")->where("id", "=", $id)->first();
            if (isset($csvFile)) {
                $skip_rows = 1;
                $count = 0;
                $arr = [];
                $arr_uq = [];
                //import data into the database.
                try {
                    if (($handle = fopen(storage_path() . "/app/" . $csvFile->file_path, 'r')) !== false) {
                        $delimiter='|';
                        // should be comma but in file its |
                        while (($row = fgetcsv($handle, 1000,$delimiter)) !== false) {
                            $count++;
                            if ($count <= $skip_rows) {
                                continue;
                            }
                            // file_path
                            $data = [];
                            $data = $this->process_row($row, $id);

                            // dd($data);
                            if ($data) {
                                $this->insertRow($data, $csvFile->table_name);
                            }
                        }
                        fclose($handle);
                    }
                } catch (Exception $e) {
                    Log::error($e);
                    $msg = "Error while trying to process CSV File. <BR/>Please verify CSV file & re-upload and try importing again. <BR/>If problem comes again contact System Development Team or Repective Personnel.";
                    $res = redirect()->back()
                    //->with("errors",$message)
                        ->with(['message' => $msg, 'message_type' => 'warning'])
                        ->withInput();
                    \Session::driver()->save();
                    $res->send();
                    exit();
                }
            } else {
                $msg = "Error while trying to process CSV File. Please verify CSV file & re-upload and try importing again. If problem comes again contact System Development Team or Repective Personnel.";
                $res = redirect()->back()
                //->with("errors",$message)
                    ->with(['message' => $msg, 'message_type' => 'warning'])
                    ->withInput();
                \Session::driver()->save();
                $res->send();
                exit();
            }
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        $msg = "Imported data to " . $csvFile->table_name . " successfully.";
        CRUDBooster::redirect(CRUDBooster::mainpath(), trans($msg), 'success');
    }
    private function process_row($row, $csv_file_id)
    {
        $csvFile = DB::table("erp_file_uploads")->where("id", "=", $csv_file_id)->first();

        // dd($csvFile);
        $data = [];
        switch ($csvFile->table_name) {
            case 'erp_jobs':
                $data['id'] = $row[0];
                $data['name'] = $row[1];
                break;
            case 'erp_organization':
                $data['id'] = $row[0];
                $data['name'] = $row[1];
                $data['geo_category'] = $row[2];
                break;
            case 'erp_department_action':
                $data['emp_no'] = $row[0];
                $date_from = date_parse($row[1]);
                if ($date_from['year']) {
                    $data['date_from'] = $date_from['year'] . '-' . $date_from['month'] . '-' . $date_from['day'];
                    if ((int) $date_from['year'] <= 2022) {
                        $date_from_bs = Helper::get_nepali_date($date_from['year'], $date_from['month'], $date_from['day']);
                        $data['date_from_bs'] = $date_from_bs['year'] . '-' . $date_from_bs['month'] . '-' . $date_from_bs['date'];
                    }
                }
                $date_to = date_parse($row[2]);
                if ($date_to['year']) {
                    $data['date_to'] = $date_to['year'] . '-' . $date_to['month'] . '-' . $date_to['day'];
                    if ((int) $date_to['year'] <= 2022) {
                        $date_to_bs = Helper::get_nepali_date($date_to['year'], $date_to['month'], $date_to['day']);
                        $data['date_to_bs'] = $date_to_bs['year'] . '-' . $date_to_bs['month'] . '-' . $date_to_bs['date'];
                    }
                }
                $data['punishment_type'] = $row[4];
                break;
            case 'erp_qualification':
                $data['id'] = $row[0];
                $data['name'] = $row[1];
                $data['erp_edu_level'] = $row[2];
                break;
            case 'erp_applicant_qualification':
                $data['id'] = $row[0];
                $data['emp_no'] = $row[1];
                $data['qt_id'] = $row[2];
                $data['title'] = $row[3];
                $start_date = date_parse($row[4]);
                  // $start_date =$row[4];

                       // dd($start_date,$start_date['year'],$row[1] );
                if ($start_date['year']) {
                    $data['start_date'] = $start_date['year'] . '-' . $start_date['month'] . '-' . $start_date['day'];

                    // dd($data['start_date'],(int) $start_date['year'] );

                    if ((int) $start_date['year'] <= 2022) {
                        $start_date_bs = Helper::get_nepali_date($start_date['year'], $start_date['month'], $start_date['day']);

                        // dd($start_date_bs);

                    $data['start_date_bs'] = $start_date_bs['y'] . '-' . $start_date_bs['m'] . '-' . $start_date_bs['d'];

                      // dd($data['start_date_bs']);  
                    }
                }
                $end_date = date_parse($row[5]);
                if ($end_date['year']) {
                    $data['end_date'] = $end_date['year'] . '-' . $end_date['month'] . '-' . $end_date['day'];
                    if ((int) $end_date['year'] <= 2022) {
                        $end_date_bs = Helper::get_nepali_date($end_date['year'], $end_date['month'], $end_date['day']);
                        $data['end_date_bs'] = $end_date_bs['y'] . '-' . $end_date_bs['m'] . '-' . $end_date_bs['d'];
                    }
                }
                $data['city'] = $row[10];
                $data['country'] = $row[11];
                if (strpos($row[12], 'COMPLETE') !== false) {
                    $data['status'] = true;
                }

                if (strpos($row[7], 'FIRST') !== false) {
                    $data['edu_division_id'] = 1;
                } elseif (strpos($row[7], 'SECOND') !== false) {
                    $data['edu_division_id'] = 2;
                } elseif (strpos($row[7], 'THIRD') !== false) {
                    $data['edu_division_id'] = 3;
                } elseif (strpos($row[7], 'DISTINCTION') !== false) {
                    $data['edu_division_id'] = 1;
                } elseif (strpos($row[7], 'PASS') !== false) {
                    $data['edu_division_id'] = 4;
                } elseif (strpos($row[7], 'MERIT') !== false) {
                    $data['edu_division_id'] = 4;
                } else {
                    $data['edu_division_id'] = 5;
                }

                break;
            case 'erp_service_history':
                // if(checkdate($seniority_date['month'],$seniority_date['day'],$seniority_date['year']))
                $data['emp_no'] = $row[0];

                // dd($row);

                $seniority_date = date_parse($row[6]);
                if ($this->isValidDate($seniority_date)) {
                    $data['seniority_date'] = $seniority_date['year'] . '-' . $seniority_date['month'] . '-' . $seniority_date['day'];

                    if ((int) $seniority_date['year'] <= 2022) {

                        // Helper::get_nepali_date
                        $seniority_date_bs =  Helper::get_nepali_date($seniority_date['year'], $seniority_date['month'], $seniority_date['day']);

                        // $seniority_date_bs = Helper::get_nepali_date($seniority_date['year'], $seniority_date['month'], $seniority_date['day']);
                        $data['seniority_date_bs'] = $seniority_date_bs['year'] . '-' . $seniority_date_bs['month'] . '-' . $seniority_date_bs['date'];
                    }
                }
                $start_date = date_parse($row[7]);
                if ($start_date['year']) {
                    $data['start_date'] = $start_date['year'] . '-' . $start_date['month'] . '-' . $start_date['day'];
                    if ((int) $start_date['year'] <= 2022) {
                        $start_date_bs = Helper::get_nepali_date($start_date['year'], $start_date['month'], $start_date['day']);
                        // $start_date_bs = Helper::get_nepali_date($start_date['year'], $start_date['month'], $start_date['day']);
                        $data['start_date_bs'] = $start_date_bs['y'] . '-' . $start_date_bs['m'] . '-' . $start_date_bs['d'];
                    }
                }
                $end_date = date_parse($row[8]);
                if ($end_date['year']) {
                    $data['end_date'] = $end_date['year'] . '-' . $end_date['month'] . '-' . $end_date['day'];
                    if ((int) $end_date['year'] <= 2022) {
                        $end_date_bs = Helper::get_nepali_date($end_date['year'], $end_date['month'], $end_date['day']);
                        // $end_date_bs = Helper::get_nepali_date($end_date['year'], $end_date['month'], $end_date['day']);
                        $data['end_date_bs'] = $end_date_bs['y'] . '-' . $end_date_bs['m'] . '-' . $end_date_bs['d'];
                    }
                }
                $data['grade'] = (int) $row[9];
                $data['job_id'] = (int) $row[10];
                $data['org_id'] = (int) $row[13];
                $data['emp_type'] = $row[14];
                if (strpos($row[15], 'Yes') !== false) {
                    $data['incharge'] = 1;
                }

                $data['reason'] = $row[16];
                break;
            case 'applicant_leave_details':
                $data['emp_no'] = $row[0];
                if (strpos($row[1], 'STUDY LEAVE') !== false) {
                    $data['leave_type_id'] = 3;
                } else {
                    $data['leave_type_id'] = 1;
                }

                $date_from = date_parse($row[2]);
                if ($date_from['year']) {
                    $data['date_from_ad'] = $date_from['year'] . '-' . $date_from['month'] . '-' . $date_from['day'];
                    if ((int) $date_from['year'] <= 2022) {
                        $date_from_bs = Helper::get_nepali_date($date_from['year'], $date_from['month'], $date_from['day']);
                        // $date_from_bs = Helper::get_nepali_date($date_from['year'], $date_from['month'], $date_from['day']);
                        $data['date_from_bs'] = $date_from_bs['y'] . '-' . $date_from_bs['m'] . '-' . $date_from_bs['d'];
                    }
                }
                $date_to = date_parse($row[3]);
                if ($date_to['year']) {
                    $data['date_to_ad'] = $date_to['year'] . '-' . $date_to['month'] . '-' . $date_to['day'];
                    if ((int) $date_to['year'] <= 2022) {
                        $date_to_bs = Helper::get_nepali_date($date_to['year'], $date_to['month'], $date_to['day']);
                        $data['date_to_bs'] = $date_to_bs['y'] . '-' . $date_to_bs['m'] . '-' . $date_to_bs['d'];
                    }
                }
                $data['remarks'] = $row[5];
                break;
            case 'applicant_absent_details':
                $data['emp_no'] = $row[0];
                $data['no_of_days'] = (int) $row[1];
                $date_from = date_parse($row[2]);
                if ($date_from['year']) {
                    $data['date_from_ad'] = $date_from['year'] . '-' . $date_from['month'] . '-' . $date_from['day'];
                    if ((int) $date_from['year'] <= 2022) {
                        $date_from_bs = Helper::get_nepali_date($date_from['year'], $date_from['month'], $date_from['day']);
                        $data['date_from_bs'] = $date_from_bs['y'] . '-' . $date_from_bs['m'] . '-' . $date_from_bs['d'];
                    }
                }
                $date_to = date_parse($row[3]);
                if ($date_to['year']) {
                    $data['date_to_ad'] = $date_to['year'] . '-' . $date_to['month'] . '-' . $date_to['day'];
                    if ((int) $date_to['year'] <= 2022) {
                        $date_to_bs = Helper::get_nepali_date($date_to['year'], $date_to['month'], $date_to['day']);
                        $data['date_to_bs'] = $date_to_bs['y'] . '-' . $date_to_bs['m'] . '-' . $date_to_bs['d'];
                    }
                }
                $data['remarks'] = $row[4];
                break;
            case 'erp_organization_district':
                $data['org_id'] = (int) $row[1];
                $data['district'] = $row[3];
                break;

            default:
                break;
        }
        $data["erp_file_uploads_id"] = $csv_file_id;
        $data["imported_by"] = CRUDBooster::myId();
        $data["imported_at"] = date('Y-m-d H:i:s');
        $data["imported_mode"] = "manual";
        return $data;
    }

    public function insertRow($data, $table)
    {
        switch ($table) {
            case 'erp_jobs':
                if ((int) $data['id'] != 0) {
                    $ifexist = DB::table('erp_jobs')->where('id', (int) $data['id'])->first();
                    if ($ifexist) {
                    } else {
                        DB::table('erp_jobs')->insert($data);
                    }
                }
                break;
            case 'erp_organization':
                if ((int) $data['id'] != 0) {
                    $ifexist = DB::table('erp_organization')->where('id', (int) $data['id'])->first();
                    if ($ifexist) {
                    } else {
                        DB::table('erp_organization')->insert($data);
                    }
                }
                break;
            case 'erp_department_action':
                if ((int) $data['emp_no'] != 0) {
                    $ifexist = DB::table('erp_punishment')->where([['emp_no', $data['emp_no']], ['date_from', $data['date_from']]])->first();
                    if ($ifexist) {
                    } else {
                        DB::table('erp_punishment')->insert($data);
                    }
                }
                break;
            case 'erp_qualification':
                if ((int) $data['id'] != 0) {
                    $ifexist = DB::table('erp_qualification')->where('id', $data['id'])->first();
                    if ($ifexist > 0) {
                    } else {
                        DB::table('erp_qualification')->insert($data);
                    }
                }
                break;
            case 'erp_applicant_qualification':
                if ((int) $data['emp_no'] != 0) {

                    // dd($data);
                    $ifexist = DB::table('erp_applicant_qualification')->where('id', $data['id'])->first();
                    if ($ifexist) {

                        // DB::table('erp_applicant_qualification')->insert($data);
                    } else {

                        DB::table('erp_applicant_qualification')->insert($data);
                    }
                }
                break;
            case 'erp_service_history':
                if ((int) $data['emp_no'] != 0) {
                    $job_exist = DB::table('erp_jobs')->where('id', $data['job_id'])->first();
                    $org_exist = DB::table('erp_organization')->where('id', $data['org_id'])->first();
                    $remarks = DB::table('erp_file_uploads')->select('remarks')->where('id', $data['erp_file_uploads_id'])->first();
                    if (empty($job_exist)) {
                        $add_remarks = "|" . $data['job_id'] . " job id not found";
                        if (strpos($remarks->remarks, $add_remarks) !== false) {

                        } else {
                            $remarks = $remarks->remarks . $add_remarks;
                            DB::table('erp_file_uploads')
                                ->where('id', $data['erp_file_uploads_id'])
                                ->update(['remarks' => $remarks]);
                        }
                    }
                    if (empty($org_exist)) {
                        $add_remarks = "|" . $data['org_id'] . " organization id not found";
                        if (strpos($remarks->remarks, $add_remarks) !== false) {

                        } else {
                            $remarks = $remarks->remarks . $add_remarks;
                            DB::table('erp_file_uploads')
                                ->where('id', $data['erp_file_uploads_id'])
                                ->update(['remarks' => $remarks]);
                        }
                    }
                    // if(count($org_exist)>0 && count($job_exist)>0){
                    $already_exist = DB::table('erp_service_history')->where([['emp_no', $data['emp_no']], ['start_date', $data['start_date']], ['end_date', $data['end_date']], ['job_id', $data['job_id']]])->get();
                    if (count($already_exist) == 0) {
                        DB::table('erp_service_history')->insert($data);
                    }

                    // }
                }
                break;
            case 'applicant_leave_details':
                if ((int) $data['emp_no'] != 0) {
                    $ifexist = DB::table('applicant_leave_details')->where([['emp_no', $data['emp_no']], ['date_from_ad', $data['date_from_ad']]])->first();
                    if ($ifexist) {
                    } else {
                        DB::table('applicant_leave_details')->insert($data);
                    }
                }
                break;
            case 'applicant_absent_details':
                if ((int) $data['emp_no'] != 0) {
                    $ifexist = DB::table('applicant_absent_details')->where([['emp_no', $data['emp_no']], ['date_from_ad', $data['date_from_ad']]])->first();
                    if ($ifexist) {
                    } else {
                        DB::table('applicant_absent_details')->insert($data);
                    }
                }
                break;
            case 'erp_organization_district':
                $ifexist = DB::table('erp_organization')->where('id', $data['org_id'])->first();
                if ($ifexist || empty($ifexist->district)) {
                    DB::table('erp_organization')
                        ->where('id', $data['org_id'])
                        ->update(['district' => $data['district']]);
                }
                break;
            default:
                break;
        }
    }

    public function isValidDate($date)
    {
        return checkdate($date['month'], $date['day'], $date['year']);
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
        $postdata["uploader_user_id"] = CRUDBooster::myId();

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
