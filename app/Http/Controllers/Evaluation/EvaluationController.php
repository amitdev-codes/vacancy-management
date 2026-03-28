<?php

namespace App\Http\Controllers\Evaluation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use DB;
use carbon\carbon;

use CRUDBooster;

class EvaluationController extends Controller
{
    public function index()
    {
        if (Session::get("is_applicant") != 1) {
            $applicants = $this->listApplicants();

            if ($applicants) {
                $applicantsCount = count($applicants);
                for ($i = 0; $i < $applicantsCount; $i++) {
                    $id = $applicants[$i]->app_id;

                    // NO marks calculation if applicant has punishments

                    $isonAction = $this->checkForDepartmentAction($id);
                    if ($isonAction) {
                        return false;
                    }

                    // initialize marks
                    $point_seniority = 0;
                    $point_incharge = 0;
                    $point_geographic = 0;
                    $min_point = 0;
                    $add_point = 0;
                    $point_education = 0;
                    $total_points = 0;


                    // dd($eduHistory);

                    // 1. Seniority Marks
                    $serviceHistory = $this->getServiceHistory($id);
                    if ($serviceHistory) {
                        $serviceHistoryCount = count($serviceHistory);
                        for ($j = 0; $j < $serviceHistoryCount; $j++) {
                            $seniority_date_ad = $serviceHistory[$j]->seniority_date_ad;

                            if ($seniority_date_ad) {
                                $seniority_rates = $this->getPointSetting(1);
                                $min_months = $seniority_rates[0]->min_duration_months;
                                $min_years = $min_months / 12;
                                $rate = $seniority_rates[0]->annual_marks_rate;
                                $max_marks = $seniority_rates[0]->max_marks_obtainable;
                                $carry_over = $seniority_rates[0]->duration_carry_over;
                                $start = Carbon::parse($seniority_date_ad);
                                $end = Carbon::parse(Session::get('pfy_date_to_ad'));

                                $leaveDaysToBeDeducted = $this->getLeaveDaysToBeDeducted($id, $start, $end);
                                // subtracting education leave days from total
                                // since education leave days doesnot effect seniority calculation
                                $total_absent_days = $leaveDaysToBeDeducted[3];
                                // $years = $end->diffInYears($start);
                                // $months = $end->diffInMonths($start);
                                $days = $end->diffInDays($start) + 1;
                                $days = $days - $total_absent_days;
                                $years = round($days / 365, 3);

                                // dd($years, $months, $days);

                                if ($years >= $min_years) {
                                    $point_seniority = $point_seniority + round($years * $rate, 3);
                                    if ($point_seniority >= $max_marks) {
                                        $point_seniority = $max_marks;
                                    }
                                }
                                echo $point_seniority;
                            }

                            if ($serviceHistory[$j]->is_office_incharge === 1) {
                                // calculate
                                $start = Carbon::parse($serviceHistory[$j]->incharge_date_from_ad);
                                $end = Carbon::parse($serviceHistory[$j]->incharge_date_to_ad);
                                $days = $end->diffInDays($start) + 1;
                                $years = round($days / 365, 3);
                                $months = round($years / 12, 3);

                                $in_charge_rates = $this->getPointSetting(5);
                                if ($in_charge_rates) {
                                    $min_months = $in_charge_rates[0]->min_duration_months;
                                    $min_years = round($min_months / 12, 3);
                                    $rate = $in_charge_rates[0]->annual_marks_rate;
                                    $max_marks = $in_charge_rates[0]->max_marks_obtainable;
                                    $duration_carry_over = $in_charge_rates[0]->duration_carry_over;
                                }

                                if ($months >= $min_months) {
                                    // Eligible. Calculate points.
                                    $point_incharge = $years * $rate;
                                    if ($point_incharge > $max_marks) {
                                        $point_incharge = $max_marks;
                                    }
                                }

                                if ($months < $min_months && $duration_carry_over === 1) {
                                    // Check previous working_office as in_charge
                                    $previous_work_office = $this->getPreviousWorkingOffice($id);
                                    if ($previous_work_office) {
                                        $start = Carbon::parse($previous_work_office->incharge_date_from_ad);
                                        $end = Carbon::parse($previous_work_office->incharge_date_to_ad);
                                        $priv_months = $end->diffInMonths($start);
                                        $total_months = $months + $priv_months;
                                        $years = round($total_months / 12, 3);

                                        if ($total_months >= $min_months) {
                                            // Eligible. Calculate points.
                                            $point_incharge = $point_incharge + $years * $rate;
                                            if ($point_incharge > $max_marks) {
                                                $point_incharge = $max_marks;
                                            }
                                        }
                                        echo $point_incharge;
                                    }
                                }
                            }

                            $geo_category = $serviceHistory[$j]->geo_category;

                            if ($geo_category) {
                                if ($geo_category === "A") {
                                    $category_type = 1;
                                } else if ($geo_category === "B") {
                                    $category_type = 2;
                                } else if ($geo_category === "C") {
                                    $category_type = 3;
                                } else if ($geo_category === "D") {
                                    $category_type = 4;
                                } else {
                                    $category_type = 5;
                                }

                                // dd($category_type, $geo_category);
                                $gender_id = $serviceHistory[$j]->gender_id;

                                // $applicant_id = $serviceHistory[$j]->applicant_id;

                                if ($gender_id == 1) {
                                    $geo_rate = DB::table('geo_points_setting')
                                        ->select('rate_male as rate')
                                        ->where('category', $category_type)
                                        ->get();
                                } else {
                                    $geo_rate = DB::table('geo_points_setting')
                                        ->select('rate_female as rate')
                                        ->where('category', $category_type)
                                        ->get();
                                }

                                $rate = $geo_rate[0]->rate;

                                $geo_rates = $this->getPointSetting(2);
                                if ($geo_rates) {
                                    $min_months = $geo_rates[0]->min_duration_months;
                                    $min_years = $min_months / 12;
                                }

                                $start = Carbon::parse($serviceHistory[$j]->date_from_ad);
                                $end = Carbon::parse($serviceHistory[$j]->date_to_ad);

                                $geo_days = $end->diffInDays($start) + 1;

                                // $applicant_id = $id; //$serviceHistory[$j]->applicant_id;

                                $leave_days = $this->getLeaveDaysToBeDeducted($applicant_id, $start, $end);
                                $total_absent_days = $leave_days[3];
                                $total_education_leave = $leave_days[1];
                                // $leave_days = $this->getLeaveDays($applicant_id); // Subtract absent days from total.
                                // $punishment_days = $this->getPunishmentDays($applicant_id); // Subtract punishment days from total.

                                // $total_geo_days = $geo_days - $leave_days - $punishment_days;
                                $total_geo_days = $geo_days - $total_absent_days;

                                $total_years = round($total_geo_days / 365, 3);

                                if ($total_years >= $min_years) {
                                    $point_geographic = round($total_years * $rate, 3);
                                    // adding the least point for education leave to geographic point
                                    $least_rate = $this->getLeastPoint($gender_id);
                                    $total_year_education_leave = round($total_education_leave / 365, 3);
                                    $pointForEductionLeave = round($total_year_education_leave * $least_rate, 3);
                                    $point_geographic = $point_geographic + round($point_geographic + $pointForEductionLeave, 3);
                                }

                            }

                            // Edu points


                            $vacancy_apply_id = $serviceHistory[$j]->vacancy_apply_id;
                            $eduHistory = $this->getEducationHistory($id,$vacancy_apply_id);
                            if (!$eduHistory) {
                                return false;
                            }


                            $minDivision = $serviceHistory[$j]->min_division ?? 2; // Set 2nd division if not available!

                            if ($minDivision) {
                                $edu_rates = $this->getEduSetting($minDivision);
                                if ($edu_rates) {
                                    $min_point = $min_point + $edu_rates[0]->minimum_points;
                                }
                            }

                            $addDivision = $serviceHistory[$j]->add_division; // Not mandatory, so, do nothing if null

                            if ($addDivision) {
                                $edu_rates = $this->getEduSetting($addDivision);
                                if ($edu_rates) {
                                    $add_point = $add_point + $edu_rates[0]->additional_points;
                                }
                            }

                            $point_education = $point_education + $min_point + $add_point;

                        }
                    }
                    $token = DB::table('vacancy_apply as va')
                    ->select('va.token_number')
                    ->leftjoin('vacancy_post as vp','vp.id','=','va.vacancy_post_id')
                    ->leftjoin('vacancy_ad as vad','vad.id','=','vp.vacancy_ad_id')
                    ->where([['va.applicant_id',$id],['vad.opening_type_id',3]])
                    ->orderBy('va.id','desc')
                    ->first();
                // Finally SAVE marks

                    DB::beginTransaction();

                    try {   // Delete previous data
                        DB::table('applicant_evaluation_marks')->where('applicant_id', '=', $id)->delete();

                     // Insert calculated points into table
                        $current_time = Carbon::now()->toDateTimeString();
                        $total_points = $point_seniority + $point_geographic + $point_education + $point_incharge;
                        $data = array(
                            'applicant_id' => $id,'token_number'=>$token->token_number, 'created_at' => $current_time, 'seniority_marks' => $point_seniority, 'incharge_marks' => $point_incharge, 'geographical_marks' => $point_geographic, 'qualification_marks' => $point_education, 'total_marks' => $total_points
                        );
                        DB::table('applicant_evaluation_marks')->insert($data);
                        DB::commit();
                     // all good
                    } catch (\Exception $e) {
                        DB::rollback();
                     // something went wrong
                    }
                }

                CRUDBooster::redirect(CRUDBooster::adminpath() . '/evaluation_summary_list', trans("Calculation complete."), 'success');
            }
        }
    }


    public function listApplicants()
    {
        return DB::select('select distinct applicant_id as app_id
        from merged_applicant_service_history t2
        left join vw_file_pormotion_applied t1 on t1.ap_id = t2.applicant_id
        where t2.is_current=:is_current and t2.is_approved=:is_approved',['is_current'=>1,'is_approved'=>1]);
    }


    public function getServiceHistory($id)
    {
        return DB::select('SELECT distinct
        sh.id AS sh_id,
        sh.vacancy_apply_id,
        applicant_id,
        working_office,
        designation,
        service_group,
        service_subgroup,
        work_level,
        date_from_bs,
        date_from_ad,
        date_to_bs,
        date_to_ad,
        is_office_incharge,
        incharge_date_from_bs,
        incharge_date_to_bs,
        incharge_date_from_ad,
        incharge_date_to_ad,
        seniority_date_bs,
        seniority_date_ad,
        minimum_qualification_degree as min_degree,
        minimum_qualification_division as min_division,
		additional_qualification_degree as add_degree,
        additional_qualification_division as add_division,
        distance_certificate,
        md.id AS md,
        md.name_en AS designation_en,
        md.name_np AS designation_np,
        sg.id AS sg,
        sg.name_en AS service_group_en,
        sg.name_np AS service_group_np,
        ssg.id AS ssg,
        ssg.name_en AS service_sub_group_en,
        ssg.name_np AS service_sub_group_np,
        wl.id AS wl,
        wl.name_en AS work_level_en,
        wl.name_np AS work_level_np,
        sh.is_current,
        sh.is_approved,
        eo.geo_category,
        ap.gender_id
        FROM
            merged_applicant_service_history AS sh
            LEFT JOIN mst_designation AS md ON md.id = sh.designation
            LEFT JOIN mst_work_service_group AS sg ON sg.id = sh.service_group
            LEFT JOIN mst_work_service_sub_group AS ssg ON ssg.id = sh.service_subgroup
            LEFT JOIN mst_work_level AS wl ON wl.id = sh.work_level
            LEFT JOIN vw_file_pormotion_applied t1 ON t1.ap_id = sh.applicant_id
            LEFT JOIN erp_organization eo ON eo.working_office_id = sh.working_office
            LEFT JOIN applicant_profile ap ON ap.id = sh.applicant_id
        WHERE
            sh.applicant_id =:id
            AND sh.is_current =:is_current
            AND sh.is_approved =:is_approved
            AND sh.date_to_ad =:date_to_ad
        ',['id'=>$id,'is_current'=>1,'is_approved'=>1,'date_to_ad'=>'2012-12-31']);
    }

    public function getEducationHistory($id,$vacancy_apply_id)
    {
        return DB::table('merged_applicant_education')
            ->select('division_id')
            ->where([['applicant_id', $id],['vacancy_apply_id', $vacancy_apply_id]])
            ->get();

        // return DB::select(DB::raw(
        //     "SELECT DISTINCT
        //     id AS ed_id,
        //     applicant_id AS app_id,
        //     edu_level_id,
        //     edu_degree_id,
        //     passed_year_ad,
        //     passed_year_bs,
        //     division_id
        // FROM
        //     merged_applicant_education t1
        //     LEFT JOIN vw_file_pormotion_applied t2 ON t2.ap_id = t1.applicant_id
        // WHERE
        //     t1.applicant_id = $id
        //     AND t1.is_approved = 1
        // ORDER BY
        //     t1.passed_year_ad DESC;"
        // ));
    }

    public function listApplicantToken($id)
    {
        return DB::table('vw_file_pormotion_applied')->distinct()->where([['is_cancelled', 0], ['is_rejected', 0]])->get(['token_number']);
    }

    public function getPointSetting($id)
    {
        return DB::table('mst_evaluation_setting')
            ->select('min_duration_months', 'annual_marks_rate', 'max_marks_obtainable', 'duration_carry_over')
            ->where('criteria_id', $id)
            ->get();
    }

    public function getEduSetting($id)
    {
        return DB::table('edu_points_setting')
            ->select('edu_level_id', 'edu_division_id', 'minimum_points', 'additional_points')
            ->where('edu_division_id', $id)
            ->get();
    }

    public function getGeoSetting($cat_id)
    {
        return DB::table('geo_points_setting')
            ->select('rate_male', 'rate_female')
            ->get();
    }

    public function getPreviousWorkingOffice($id)
    {
        return DB::table('applicant_service_history')
            ->select('date_from_ad', 'date_to_ad', 'incharge_date_from_ad', 'incharge_date_to_ad')
            ->where([['applicant_id', $id], ['is_current', 0], ['is_office_incharge', 1]])
            ->orderBy('incharge_date_from_ad', 'desc')
            ->first();
    }


    public function getLeaveDaysToBeDeducted($id, $start, $end)
    {

        $emp_code = DB::select(DB::raw("SELECT nt_staff_code FROM applicant_profile WHERE id = '$id'"));

        $leaves = DB::table('applicant_leave_details')
            ->select('date_from_ad', 'date_to_ad', 'leave_type_id')
            ->where('emp_no', '$emp_code')
            ->get();
        if ($leaves) {
            $count = count($leaves);
            $total_days = 0;
            $education_leave_days = 0;
            if ($count > 0) {
                for ($i = 0; $i < $count; $i++) {
                    $leave_start = Carbon::parse($leaves[$i]->date_from_ad);
                    $leave_end = Carbon::parse($leaves[$i]->date_to_ad);
                    if ($leaves[$i]->leave_type_id == 3) {

                        if ($leave_start < $end && $leave_end > $start) {
                            if ($leave_start >= $start)
                                $actual_start = $leave_start;
                            else
                                $actual_start = $start;
                            if ($leave_end >= $end)
                                $actual_end = $end;
                            else
                                $actual_end = $leave_end;

                            $length = $actual_end->diffInDays($actual_start) + 1;
                            $education_leave_days = $education_leave_days + $length;
                        }
                    } else {
                        if ($leave_start < $end && $leave_end > $start) {

                            if ($leave_start >= $start)
                                $actual_start = $leave_start;
                            else
                                $actual_start = $start;
                            if ($leave_end >= $end)
                                $actual_end = $end;
                            else
                                $actual_end = $leave_end;

                            $length = $actual_end->diffInDays($actual_start) + 1;
                            $total_days = $total_days + $length;
                        }
                    }
                }
            }
        }
        $absent_days = 0;
        $emp_code = DB::select(DB::raw("SELECT nt_staff_code FROM applicant_profile WHERE id = '$id'"));
        $absent_detail = DB::table('applicant_absent_details')
            ->select('date_from_ad', 'date_to_ad')
            ->where('emp_no', '$emp_code')
            ->get();
        if ($absent_detail) {
            $count = count($absent_detail);
            if ($count > 0) {
                for ($i = 0; $i < $count; $i++) {
                    $absent_start = Carbon::parse($absent_detail[$i]->date_from_ad);
                    $absent_end = Carbon::parse($absent_detail[$i]->date_to_ad);
                    if ($absent_start < $end && $absent_end > $start) {
                        if ($absent_start >= $start)
                            $actual_start = $absent_start;
                        else
                            $actual_start = $start;
                        if ($absent_end >= $end)
                            $actual_end = $end;
                        else
                            $actual_end = $absent_end;

                        $length = $actual_end->diffInDays($actual_start) + 1;
                        $absent_days = $absent_days + $length;
                    }
                }
            }
        }
        $total_days = $total_days + $education_leave_days;
        $data[0] = $total_days;
        $data[1] = $education_leave_days;
        $data[3] = $absent_days;
        return $data;
    }

    public function getLeastPoint($gender_id)
    {
        if ($gender_id == 1)
            $column_name = 'rate_male';
        else
            $column_name = 'rate_female';
        // note assuming category 5 is the lowest
        $rate = DB::table('geo_points_setting')
            ->select($column_name)
            ->where('category', 5)
            ->first();
        return $rate->$column_name;
    }

    public function checkForDepartmentAction($id)
    {
        $Job_opening_type = 3;
        $latestFPVacancyAd = DB::select(
            'SELECT date_to_publish_ad,
            last_date_for_application_ad,
            vacancy_extended_date_ad
            FROM vacancy_ad where id in (
                select max(id) from vacancy_ad where opening_type_id=?)
            ',
            [$Job_opening_type]
        );
        $department_action = DB::table('applicant_punishment_details')
            ->where('applicant_id', $id)->get();
        if ($department_action->count() == 0) {
            return false;
        } else {
            $AdPublishDate = Carbon::parse($latestFPVacancyAd[0]->date_to_publish_ad);
            $LastDateToApply = Carbon::parse($latestFPVacancyAd[0]->last_date_for_application_ad);
            $ExtendedDateToApply = Carbon::parse($latestFPVacancyAd[0]->vacancy_extended_date_ad);
            if (isset($ExtendedDateToApply)) {
                $LastDateToApply = $ExtendedDateToApply;
            }
            foreach ($department_action as $da) {
                // note assuming grade ghatuwa as id 4
                if ($da->punishment_type_id != 4) {
                    $action_from = Carbon::parse($da->date_from_ad);
                    $action_to = Carbon::parse($da->date_to_ad);
                    if ($action_from <= $LastDateToApply && $action_to >= $AdPublishDate)
                        return true;
                } else {
                    $action_from = Carbon::parse($da->date_from_ad);
                    $action_to = $action_from->addYear();
                    if (Carbon::parse($da->date_from_ad) < $LastDateToApply && $action_to > $AdPublishDate)
                        return true;
                }
            }
        }
        return false;
    }

}
