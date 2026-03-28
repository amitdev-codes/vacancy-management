<?php

namespace App\Helpers;

use DB;
use Bsdate;

class UploadErpDataHelper
{
    public static function upload_data()
    {
        $files = (new self)->getItems();
        foreach ($files as $fl) {
            switch ($fl['name']) {
                case 'erp_reward_punish.csv':
                    (new self)->importData($fl['name'], $fl['updated_at']);
                    break;
                case 'erp_jobs.csv':
                    (new self)->importData($fl['name'], $fl['updated_at']);
                    break;
                case 'erp_hr_organization.csv':
                    (new self)->importData($fl['name'], $fl['updated_at']);
                    break;
                case 'erp_qualification_type.csv':
                    (new self)->importData($fl['name'], $fl['updated_at']);
                    break;
                case 'erp_absent.csv':
                    (new self)->importData($fl['name'], $fl['updated_at']);
                    break;
                case 'erp_leave.csv':
                    (new self)->importData($fl['name'], $fl['updated_at']);
                    break;
                case 'erp_qualification.csv':
                    (new self)->importData($fl['name'], $fl['updated_at']);
                    break;
                case 'erp_service.csv':
                    (new self)->importData($fl['name'], $fl['updated_at']);
                    break;
                default:
                    break;
            }
        }
    }
    // for getting files
    public function getItems()
    {
        // $path = parent::getCurrentPath();
        $files = $this->listFolderFiles();
        $items = array();
        $i = 0;
        foreach ($files as $key => $files) {
            $items[$i]['name'] = $files;
            //    $items[$i]['updated_at']=$key;
            $i++;
        }
        return $items;
    }
    public function listFolderFiles()
    {
        $directory  = env('FILES_PATH');
        $all_files  = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($directory));
        $html_files = new \RegexIterator($all_files, '/\.csv$/');

        foreach ($html_files as $file) {
            $files[] = $html_files->getFilename();
        }
        // arsort($files);
        return $files;
    }

    public function importData($filename, $updated_at)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        ini_set('max_execution_time', 0);

        if (isset($filename)) {
            $skip_rows = 1;
            $count = 0;
            $arr = [];
            $arr_uq = [];
            //import data into the database.
            try {
                if (($handle = fopen(env('FILES_PATH') . '/' . $filename, 'r')) !== false) {
                    while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                        $count++;
                        if ($count <= $skip_rows) {
                            continue;
                        }
                        $row = explode('|', $row[0]);
                        // file_path
                        $data = [];
                        $data = $this->process_row($row, $filename);
                        if ($data) {
                            $this->insertRow($data, $filename);
                        }
                    }
                    fclose($handle);
                }
            } catch (Exception $e) {
                Log::error($e);
                $msg = "Error while trying to process CSV File. <BR/>Please verify CSV file & re-upload and try importing again. <BR/>If the problem comes again, contact System Development Team or Respective Personnel.";
                $res = redirect()->back()
                    //->with("errors",$message)
                    ->with(['message' => $msg, 'message_type' => 'warning'])
                    ->withInput();
                \Session::driver()->save();
                $res->send();
                exit();
            }
        } else {
            $msg = "Error while trying to process CSV File. Please verify CSV file & re-upload and try importing again. If the problem comes again, contact System Development Team or Respective Personnel.";
            $res = redirect()->back()
                //->with("errors",$message)
                ->with(['message' => $msg, 'message_type' => 'warning'])
                ->withInput();
            \Session::driver()->save();
            $res->send();
            exit();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        $realFilename = env('FILES_PATH') . '/' . $filename;
        $newName = env('FILES_PATH') . '/done_' . date('l\_jS\_F\_Y\_h:i:s\_A\_') . $filename;
        rename($realFilename, $newName);
        // $msg="Imported data to ".$csvFile->table_name." successfully.";
        // CRUDBooster::redirect(CRUDBooster::mainpath(), trans($msg), 'success');
    }
    private function process_row($row, $filename)
    {
        $data = [];
        switch ($filename) {
            case 'erp_jobs.csv':
                $data['id'] = $row[0];
                $data['name'] = $row[1];
                break;
            case 'erp_hr_organization.csv':
                $data['id'] = $row[0];
                $data['name'] = $row[1];
                $data['geo_category'] = $row[2];
                break;
            case 'erp_reward_punish.csv':
                $data['emp_no'] = $row[0];
                $date_from = date_parse($row[1]);
                if ($date_from['year']) {
                    $data['date_from'] = $date_from['year'] . '-' . $date_from['month'] . '-' . $date_from['day'];
                    if ((int)$date_from['year'] <= 2022) {
                        $date_from_bs = Bsdate::eng_to_nep($date_from['year'], $date_from['month'], $date_from['day']);
                        $data['date_from_bs'] = $date_from_bs['year'] . '-' . $date_from_bs['month'] . '-' . $date_from_bs['date'];
                    }
                }
                $date_to = date_parse($row[2]);
                if ($date_to['year']) {
                    $data['date_to'] = $date_to['year'] . '-' . $date_to['month'] . '-' . $date_to['day'];
                    if ((int)$date_to['year'] <= 2022) {
                        $date_to_bs = Bsdate::eng_to_nep($date_to['year'], $date_to['month'], $date_to['day']);
                        $data['date_to_bs'] = $date_to_bs['year'] . '-' . $date_to_bs['month'] . '-' . $date_to_bs['date'];
                    }
                }

                $data['punishment_type'] = $row[4];
                break;
            case 'erp_qualification_type.csv':
                $data['id'] = $row[0];
                $data['name'] = $row[1];
                $data['erp_edu_level'] = $row[2];
                break;
            case 'erp_qualification.csv':
                $data['id'] = $row[0];
                $data['emp_no'] = $row[1];
                $data['qt_id'] = $row[2];
                $data['title'] = $row[3];
                $start_date = date_parse($row[4]);
                if ($start_date['year']) {
                    $data['start_date'] = $start_date['year'] . '-' . $start_date['month'] . '-' . $start_date['day'];
                    if ((int)$start_date['year'] <= 2022) {
                        $start_date_bs = Bsdate::eng_to_nep($start_date['year'], $start_date['month'], $start_date['day']);
                        $data['start_date_bs'] = $start_date_bs['year'] . '-' . $start_date_bs['month'] . '-' . $start_date_bs['date'];
                    }
                }

                $end_date = date_parse($row[5]);
                if ($end_date['year']) {
                    $data['end_date'] = $end_date['year'] . '-' . $end_date['month'] . '-' . $end_date['day'];
                    if ((int)$end_date['year'] <= 2022) {
                        $end_date_bs = Bsdate::eng_to_nep($end_date['year'], $end_date['month'], $end_date['day']);
                        $data['end_date_bs'] = $end_date_bs['year'] . '-' . $end_date_bs['month'] . '-' . $end_date_bs['date'];
                    }
                }
                $data['city'] = $row[10];
                $data['country'] = $row[11];
                if (strpos($row[12], 'COMPLETE') !== false)
                    $data['status'] = true;
                if (strpos($row[7], 'FIRST') !== false)
                    $data['edu_division_id'] = 1;
                elseif (strpos($row[7], 'SECOND') !== false)
                    $data['edu_division_id'] = 2;
                elseif (strpos($row[7], 'THIRD') !== false)
                    $data['edu_division_id'] = 3;
                elseif (strpos($row[7], 'DISTINCTION') !== false)
                    $data['edu_division_id'] = 1;
                elseif (strpos($row[7], 'PASS') !== false)
                    $data['edu_division_id'] = 4;
                elseif (strpos($row[7], 'MERIT') !== false)
                    $data['edu_division_id'] = 4;
                else
                    $data['edu_division_id'] = 5;
                break;
            case 'erp_service.csv':
                // if(checkdate($seniority_date['month'],$seniority_date['day'],$seniority_date['year']))
                $data['emp_no'] = $row[0];
                $seniority_date = date_parse($row[6]);
                if ($this->isValidDate($seniority_date)) {
                    $data['seniority_date'] = $seniority_date['year'] . '-' . $seniority_date['month'] . '-' . $seniority_date['day'];
                    if ((int)$seniority_date['year'] <= 2022) {
                        $seniority_date_bs = Bsdate::eng_to_nep($seniority_date['year'], $seniority_date['month'], $seniority_date['day']);
                        $data['seniority_date_bs'] = $seniority_date_bs['year'] . '-' . $seniority_date_bs['month'] . '-' . $seniority_date_bs['date'];
                    }
                }
                $start_date = date_parse($row[7]);
                if ($start_date['year']) {
                    $data['start_date'] = $start_date['year'] . '-' . $start_date['month'] . '-' . $start_date['day'];
                    if ((int)$start_date['year'] <= 2022) {
                        $start_date_bs = Bsdate::eng_to_nep($start_date['year'], $start_date['month'], $start_date['day']);
                        $data['start_date_bs'] = $start_date_bs['year'] . '-' . $start_date_bs['month'] . '-' . $start_date_bs['date'];
                    }
                }
                $end_date = date_parse($row[8]);
                if ($end_date['year']) {
                    $data['end_date'] = $end_date['year'] . '-' . $end_date['month'] . '-' . $end_date['day'];
                    if ((int)$end_date['year'] <= 2022) {
                        $end_date_bs = Bsdate::eng_to_nep($end_date['year'], $end_date['month'], $end_date['day']);
                        $data['end_date_bs'] = $end_date_bs['year'] . '-' . $end_date_bs['month'] . '-' . $end_date_bs['date'];
                    }
                }
                $data['grade'] = (int)$row[9];
                $data['job_id'] = (int)$row[10];
                $data['org_id'] = (int)$row[13];
                $data['emp_type'] = $row[14];
                if (strpos($row[15], 'Yes') !== false)
                    $data['incharge'] = 1;
                $data['reason'] = $row[16];
                break;
            case 'erp_leave.csv':
                $data['emp_no'] = $row[0];
                if (strpos($row[1], 'STUDY LEAVE') !== false)
                    $data['leave_type_id'] = 3;
                else
                    $data['leave_type_id'] = 1;
                $date_from = date_parse($row[2]);
                if ($date_from['year']) {
                    $data['date_from_ad'] = $date_from['year'] . '-' . $date_from['month'] . '-' . $date_from['day'];
                    if ((int)$date_from['year'] <= 2022) {
                        $date_from_bs = Bsdate::eng_to_nep($date_from['year'], $date_from['month'], $date_from['day']);
                        $data['date_from_bs'] = $date_from_bs['year'] . '-' . $date_from_bs['month'] . '-' . $date_from_bs['date'];
                    }
                }
                $date_to = date_parse($row[3]);
                if ($date_to['year']) {
                    $data['date_to_ad'] = $date_to['year'] . '-' . $date_to['month'] . '-' . $date_to['day'];
                    if ((int)$date_to['year'] <= 2022) {
                        $date_to_bs = Bsdate::eng_to_nep($date_to['year'], $date_to['month'], $date_to['day']);
                        $data['date_to_bs'] = $date_to_bs['year'] . '-' . $date_to_bs['month'] . '-' . $date_to_bs['date'];
                    }
                }
                $data['remarks'] = $row[5];
                break;
            case 'erp_absent.csv':
                $data['emp_no'] = $row[0];
                $data['no_of_days'] = (int)$row[1];
                $date_from = date_parse($row[2]);
                if ($date_from['year']) {
                    $data['date_from_ad'] = $date_from['year'] . '-' . $date_from['month'] . '-' . $date_from['day'];
                    if ((int)$date_from['year'] <= 2022) {
                        $date_from_bs = Bsdate::eng_to_nep($date_from['year'], $date_from['month'], $date_from['day']);
                        $data['date_from_bs'] = $date_from_bs['year'] . '-' . $date_from_bs['month'] . '-' . $date_from_bs['date'];
                    }
                }
                $date_to = date_parse($row[3]);
                if ($date_to['year']) {
                    $data['date_to_ad'] = $date_to['year'] . '-' . $date_to['month'] . '-' . $date_to['day'];
                    if ((int)$date_to['year'] <= 2022) {
                        $date_to_bs = Bsdate::eng_to_nep($date_to['year'], $date_to['month'], $date_to['day']);
                        $data['date_to_bs'] = $date_to_bs['year'] . '-' . $date_to_bs['month'] . '-' . $date_to_bs['date'];
                    }
                }
                $data['remarks'] = $row[4];
                break;
            case 'erp_organization_district':
                $data['org_id'] = (int)$row[1];
                $data['district'] = $row[3];
                break;

            default:
                break;
        }
        $data["erp_file_uploads_id"] = 1;
        $data["imported_by"] = 1;
        $data["imported_at"] = date('Y-m-d H:i:s');
        $data["imported_mode"] = "FTP";
        return $data;
    }

    public function insertRow($data, $filename)
    {
        switch ($filename) {
            case 'erp_jobs.csv':
                if ((int)$data['id'] != 0) {
                    $ifexist = DB::table('erp_jobs')->where('id', (int)$data['id'])->first();
                    if (count($ifexist) > 0) { } else {
                        if (strlen(trim($data['id'])) != 0)
                            DB::table('erp_jobs')->insert($data);
                    }
                }
                break;
            case 'erp_hr_organization.csv':
                if ((int)$data['id'] != 0) {
                    $ifexist = DB::table('erp_organization')->where('id', (int)$data['id'])->first();
                    if (count($ifexist) > 0) { } else {
                        if (strlen(trim($data['id'])) != 0)
                            DB::table('erp_organization')->insert($data);
                    }
                }
                break;
            case 'erp_reward_punish.csv':
                if ((int)$data['emp_no'] != 0) {
                    $ifexist = DB::table('erp_punishment')->where([['emp_no', $data['emp_no']], ['date_from', $data['date_from']]])->first();
                    if (count($ifexist) > 0) { } else {
                        DB::table('erp_punishment')->insert($data);
                    }
                }
                break;
            case 'erp_qualification_type.csv':
                if ((int)$data['id'] != 0) {
                    $ifexist = DB::table('erp_qualification')->where('id', $data['id'])->first();
                    if (count($ifexist) > 0) { } else {
                        if (strlen(trim($data['id'])) != 0)
                            DB::table('erp_qualification')->insert($data);
                    }
                }
                break;
            case 'erp_qualification.csv':
                if ((int)$data['emp_no'] != 0) {
                    $ifexist = DB::table('erp_applicant_qualification')->where('id', $data['id'])->first();
                    if (count($ifexist) > 0) { } else {
                        DB::table('erp_applicant_qualification')->insert($data);
                    }
                }
                break;
            case 'erp_service.csv':
                if ((int)$data['emp_no'] != 0) {
                    // $job_exist=DB::table('erp_jobs')->where('id',$data['job_id'])->first();
                    // $org_exist=DB::table('erp_organization')->where('id',$data['org_id'])->first();
                    // // $remarks=DB::table('erp_file_uploads')->select('remarks')->where('id',$data['erp_file_uploads_id'])->first();
                    // if(count($job_exist)==0){
                    //     $add_remarks="|".$data['job_id']." job id not found";
                    //     if(strpos($remarks->remarks,$add_remarks) !== false){

                    //     }
                    //     else{
                    //         $remarks=$remarks->remarks.$add_remarks;
                    //         DB::table('erp_file_uploads')
                    //         ->where('id', $data['erp_file_uploads_id'])
                    //         ->update(['remarks' => $remarks]);
                    //     }
                    // }
                    // if(count($org_exist)==0){
                    //     $add_remarks="|".$data['org_id']." organization id not found";
                    //     if(strpos($remarks->remarks,$add_remarks) !== false){

                    //     }
                    //     else{
                    //         $remarks=$remarks->remarks.$add_remarks;
                    //         DB::table('erp_file_uploads')
                    //         ->where('id', $data['erp_file_uploads_id'])
                    //         ->update(['remarks' => $remarks]);
                    //     }
                    // }
                    // if(count($org_exist)>0 && count($job_exist)>0){
                    $already_exist = DB::table('erp_service_history')->where([['emp_no', $data['emp_no']], ['start_date', $data['start_date']], ['end_date', $data['end_date']], ['job_id', $data['job_id']]])->get();
                    if (count($already_exist) == 0)
                        DB::table('erp_service_history')->insert($data);

                    // }

                }
                break;
            case 'erp_leave.csv':
                if ((int)$data['emp_no'] != 0) {
                    $ifexist = DB::table('applicant_leave_details')->where([['emp_no', $data['emp_no']], ['date_from_ad', $data['date_from_ad']]])->first();
                    if (count($ifexist) > 0) { } else {
                        DB::table('applicant_leave_details')->insert($data);
                    }
                }
                break;
            case 'erp_absent.csv':
                if ((int)$data['emp_no'] != 0) {
                    // if(strlen(trim($data['emp_no']))!=0){
                    $ifexist = DB::table('applicant_absent_details')->where([['emp_no', $data['emp_no']], ['date_from_ad', $data['date_from_ad']]])->first();
                    if (count($ifexist) > 0) { } else {
                        DB::table('applicant_absent_details')->insert($data);
                    }
                }
                break;
            case 'erp_organization_district':
                $ifexist = DB::table('erp_organization')->where('id', $data['org_id'])->first();
                if (count($ifexist) > 0) {
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
}
