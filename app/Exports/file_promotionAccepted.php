<?php


namespace App\Exports;


use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Carbon\Carbon;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use Request;
use Session;
use crocodicstudio\crudbooster\export\DefaultExportXls;

class file_promotionAccepted implements FromView
{
    public function getVacancyAdNo()
    {
        // $adno_data = DB::select(DB::raw("select id,ad_title_en from vacancy_ad"));
        $fiscal_year_id = Session::get('fiscal_year_id');
        $today = Carbon::now();
        $adno_data = DB::table('vacancy_ad as va')
            ->select('va.id', 'ad_title_en', 'mj.name_np as opening_type')
            ->leftjoin('mst_job_opening_type as mj', 'va.opening_type_id', 'mj.id')
            ->where([['va.is_deleted', false], ['fiscal_year_id', $fiscal_year_id], ['vacancy_extended_date_ad', '>=', $today]])
            ->get();
        return $adno_data;

    }

    public function getDesignation($id)
    {
        $designation_data = DB::table('vacancy_post as vp')
            ->select('md.name_en as designation', 'md.id as designation_id', 'vp.id')
            ->leftjoin('mst_designation as md', 'vp.designation_id', 'md.id')
            ->where([['vacancy_ad_id', $id], ['vp.is_deleted', false]])
            ->get();
        return $designation_data;
    }

    public function getHighestDegree($ap_id)
    {
        $edu_data = DB::table('applicant_edu_info')
            ->where('applicant_id', $ap_id)
            ->get();
        foreach ($edu_data as $ed) {
            if ($ed->edu_level_id == 3) {
                return $ed->edu_degree_id;
            }
        }
        foreach ($edu_data as $ed) {
            if ($ed->edu_level_id == 4) {
                return $ed->edu_degree_id;
            }
        }
        foreach ($edu_data as $ed) {
            if ($ed->edu_level_id == 1) {
                return $ed->edu_degree_id;
            }
        }
        foreach ($edu_data as $ed) {
            if ($ed->edu_level_id == 5) {
                return $ed->edu_degree_id;
            }
        }
        foreach ($edu_data as $ed) {
            if ($ed->edu_level_id == 2) {
                return $ed->edu_degree_id;
            }
        }

    }

    public function view(): View
    {


        $data = [];
        $id=Session::get('file_promotion_accepted_candidates_id');

        $designation_id = DB::table('vacancy_post')
            ->select('designation_id', 'vacancy_ad_id')
            ->where('id', $id)
            ->first();
        $opening_type = DB::table('vacancy_ad')
            ->select('opening_type_id')
            ->where('id', $designation_id->vacancy_ad_id)
            ->first();

        $neededDegree = DB::table('mst_designation_degree as mdd')
            ->select('mdd.edu_degree_id as edi', 'med.name_en as name', 'mdd.is_training_required as is_training_required')
            ->leftjoin('mst_edu_degree as med', 'med.id', '=', 'mdd.edu_degree_id')
            ->where('mdd.designation_id', $designation_id->designation_id)
            ->get();

        $neededTraining = DB::table('mst_designation_training as mdt')
            ->select('mdt.training_id as ti', 'mt.name_en as name')
            ->leftjoin('mst_training as mt', 'mt.id', '=', 'mdt.training_id')
            ->where('mdt.designation_id', $designation_id->designation_id)
            ->get();

        $candidate_data = DB::select('select distinct t2.exam_roll_no as roll, t1.*,ms.name_np as current_designation,t1.gender,
            mwl.name_np as work_level,mwo.name_en as working_office,t3.seniority_date_bs,t3.minimum_qualification_degree,t3.additional_qualification_degree,t3.minimum_qualification_division,t3.additional_qualification_division,t3.remarks as service_history_remarks
                            from vw_file_pormotion_applied t1
                            left join vacancy_exam t2 on t1.vacancy_apply_id = t2.vacancy_apply_id
                            left join applicant_service_history t3 on t1.ap_id=t3.applicant_id
                            left join mst_designation ms on ms.id=t3.designation
                            left join mst_work_level mwl on mwl.id=t3.work_level
                            left join mst_working_office mwo on mwo.id=t3.working_office
                where  t1.is_rejected=0 and t1.vp_id =:id
                order by applicant_name_en', ['id' => $id]);
        $candidate_data = collect($candidate_data);
        $candidate_data = $candidate_data->unique('ap_id');

//         $sql = "select distinct t2.exam_roll_no as roll, t1.* from vw_vacancy_post_applicant_profile t1
        // left join vacancy_exam t2 on t1.ap_id = t2.applicant_id where t2.vacancy_post_id=".$id ." order by applicant_name_en";

        //$candidate_data = DB::select(DB::raw($sql));

        //education data
        $education_data = [];
        foreach ($candidate_data as $cd) {
            $edu_data = DB::table('applicant_edu_info')
                ->where('applicant_id', $cd->ap_id)
            //->orderBY('id','desc')
                ->get();
            foreach ($edu_data as $ed) {
                foreach ($neededDegree as $nd) {
                    if ($nd->edi === $ed->edu_degree_id) {
                        $edu_major_data = DB::table('mst_edu_major')
                            ->select('name_en')
                            ->where('id', $ed->edu_major_id)
                            ->first();
                        $education_data[$cd->ap_id] = $nd->name . '/' . $edu_major_data->name_en;
                        if ($nd->is_training_required == 0) {
                            goto targetLocation;
                        }
                    }
                }
            }
            targetLocation:
            if (!isset($education_data[$cd->ap_id])) {
                $higest_degree_id = $this->getHighestDegree($cd->ap_id);
                $edu_degree_data = DB::table('mst_edu_degree')
                    ->select('name_en')
                    ->where('id', $higest_degree_id)
                    ->first();
                $edu_major_id = $edu_data = DB::table('applicant_edu_info')
                    ->select('edu_major_id')
                    ->where([['applicant_id', $cd->ap_id], ['edu_degree_id', $higest_degree_id]])
                    ->first();
                $edu_major_data = DB::table('mst_edu_major')
                    ->select('name_en')
                    ->where('id', $edu_major_id->edu_major_id)
                    ->first();
                $education_data[$cd->ap_id] = $edu_degree_data->name_en . '/' . $edu_major_data->name_en;

            }
        }

        // training data
        $training_data = [];
        foreach ($candidate_data as $cd) {
            $trng_data = DB::table('applicant_training_info')
                ->where('applicant_id', $cd->ap_id)
                ->get();
            foreach ($trng_data as $td) {
                foreach ($neededTraining as $nt) {
                    if ($nt->ti === $td->training_id) {
                        $training_data[$cd->ap_id] = $nt->name . '/' . $td->institute_name;
                        goto nextTarget;
                    }
                }
            }
            nextTarget:
            if (!isset($education_data[$cd->ap_id])) {
                $training_data[$cd->ap_id] = $trng_data[0]->training_title . '/' . $trng_data[0]->institute_name;
            }
        }

        // dd($candidate_data);
        $intro_data = DB::select('SELECT mws.name_en as service,mwsg.name_en as service_group,
        va.notice_no,vp.ad_no, va.ad_title_en, vp.designation_id, wl.name_en as work_level, md.name_en as designation,
        vp.total_req_seats
        FROM
            vacancy_post vp
            LEFT JOIN vacancy_ad va ON va.id = vp.vacancy_ad_id
            left join mst_designation md on md.id = vp.designation_id
            left join mst_work_level wl on wl.id = md.work_level_id
						LEFT JOIN mst_work_service mws on mws.id=md.work_service_id
						left JOIN mst_work_service_group mwsg on mwsg.id=md.service_group_id
            where vp.id =:id', ['id' => $id]);

        $data['level'] = DB::table('vw_published_vacancy_posts_all')
            ->select('level')
            ->where('id', $id)
            ->first();
        if ($data['level']->level == 8 || $data['level']->level == 9) {
            $expereince_data = [];
            foreach ($candidate_data as $cd) {
                $exp_data = DB::table('applicant_exp_info')
                    ->where('applicant_id', $cd->ap_id)
                    ->get();
                foreach ($exp_data as $exd) {
                    // $expereince_data[$cd->ap_id][$exd->id]=$exd->working_office.'('.$exd->date_from_bs.'/'.$exd->date_to_bs.')';
                    $expereince_data[$cd->ap_id][] = $exd->working_office . '(' . $exd->date_from_bs . '/' . $exd->date_to_bs . ')';

                }

            }

            $data['expereince_data'] = $expereince_data;
        }

        // for($i=0; $i<count($expereince_data['1466']); $i++){
        //     echo $expereince_data['1466'][$i];
        // }
        $page = Request::get('page');
        if ($page == '1' || $page == null) {
            $i = 1;
        } else {
            $i = ((int) $page - 1) * 50 + 1;
        }

        foreach ($candidate_data as $cd) {
            $cd->rn = $i;
            $i++;
        }
        $data['training_data'] = $training_data;
        $data['education_data'] = $education_data;
        $data['candidate_data'] = $candidate_data;
        $data['intro_data'] = $intro_data;
        $data['adno_data'] = $this->getVacancyAdNo();
        $data['designation_data'] = $this->getDesignation($this->ad_id);
        $data['opening_type_id'] = $opening_type->opening_type_id;
        $designation_name = DB::table('mst_designation')
            ->select('name_np')
            ->where('id', $designation_id->designation_id)
            ->first();

        // dd($data);
        return view("selected_candidate.file_pormotion_accepted_xl_report",$data);




    }
}