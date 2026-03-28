<?php


namespace App\Exports;


use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use crocodicstudio\crudbooster\export\DefaultExportXls;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class SelectedCandidates implements FromView,WithHeadings,ShouldAutoSize,WithEvents
{

    public function headings(): array
    {
        return [
            'S.NO',
            'Roll',
            'Applicant ID',
            'Nt Staff Code',
            'नाम',
            'Name',
            'D.O.B.',
            'Gender',
            'Address',
            'बुबा / आमा',
            'GrandFather',
            'बाजे',
            'Current Designation',
            'Work Level',
            'Seniority Date (B.S)',
            'योग्यता',
            'अनुभब',
            'Token No.',
            'Total Amount',
            'Paid Amount',
            'Receipt no',
            'Paid Date(AD)',
            'Seniority Date (B.S)',
            'Email',
            'Mobile',
            'Remarks',

        ];
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                // $cellRange = 'A7:W7'; // All headers
                $cellRange = 'A7:AE7';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont('Kalimati')->setSize(14);
                
            },

        ];

    }
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
    public function getMinDegree($ap_id,$id){

        $min_edu_level=DB::table('mst_designation_degree as mdd')->leftjoin('mst_edu_degree as med','med.id','mdd.edu_degree_id')
                       ->where([['mdd.is_for_internal',true],['mdd.designation_id',$id],['is_additional',false]])->distinct('edu_level_id')
                       ->first();
        $applicant_edu_info=DB::table('applicant_edu_info')->where([['is_deleted',false],['edu_level_id',$min_edu_level->edu_level_id],['applicant_id',$ap_id]])
                           ->select('edu_degree_id')->first();
                           return $applicant_edu_info->edu_degree_id;
      }
    public function view(): View
    {
        $data = [];

        $id=Session::get('selected_candidates_id');

        $designation_id = DB::table('vacancy_post')
            ->select('designation_id', 'vacancy_ad_id')
            ->where('id', $id)
            ->first();
        $opening_type = DB::table('vacancy_ad')
            ->select('opening_type_id')
            ->where('id', $designation_id->vacancy_ad_id)
            ->first();

        if ($opening_type->opening_type_id == 1) {
            $neededDegree = DB::table('mst_designation_degree as mdd')
                ->select('mdd.edu_degree_id as edi', 'med.name_en as name', 'mdd.is_training_required as is_training_required')
                ->leftjoin('mst_edu_degree as med', 'med.id', '=', 'mdd.edu_degree_id')
                ->where([['mdd.designation_id', $designation_id->designation_id], ['mdd.is_for_internal', 0]])
                ->get();
        } elseif ($opening_type->opening_type_id == 2) {
            $neededDegree = DB::table('mst_designation_degree as mdd')
                ->select('mdd.edu_degree_id as edi', 'med.name_en as name', 'mdd.is_training_required as is_training_required')
                ->leftjoin('mst_edu_degree as med', 'med.id', '=', 'mdd.edu_degree_id')
                ->where([['mdd.designation_id', $designation_id->designation_id], ['mdd.is_for_internal', 1]])
                ->get();
        } else {
            $neededDegree = DB::table('mst_designation_degree as mdd')
                ->select('mdd.edu_degree_id as edi', 'med.name_en as name', 'mdd.is_training_required as is_training_required')
                ->leftjoin('mst_edu_degree as med', 'med.id', '=', 'mdd.edu_degree_id')
                ->where('mdd.designation_id', $designation_id->designation_id)
                ->get();
        }

        $neededTraining = DB::table('mst_designation_training as mdt')
            ->select('mdt.training_id as ti', 'mt.name_en as name')
            ->leftjoin('mst_training as mt', 'mt.id', '=', 'mdt.training_id')
            ->where('mdt.designation_id', $designation_id->designation_id)
            ->get();


        if ($opening_type->opening_type_id == 2) {
            $candidate_data = DB::select('select
            distinct t2.exam_roll_no as roll,
            t1.*
            , ms.name_np as current_designation,
            mwl.name_np as work_level,
            t3.seniority_date_bs,mg.name_np as gender
        from
            vw_vacancy_post_applicant_profile t1
        left join vacancy_exam t2 on
            t1.vacancy_apply_id = t2.vacancy_apply_id
        left join applicant_service_history t3 on
            t1.ap_id = t3.applicant_id
        left join mst_designation ms on
            ms.id = t3.designation
        left join mst_gender mg on
            mg.id = t1.gender
        left join mst_work_level mwl on
            mwl.id = t3.work_level
        where
            t1.is_paid =:is_paid
            and t3.is_current =:is_current
            and t1.vp_id =:id
        and t3.date_to_ad in
        (select max(date_to_ad)from applicant_service_history where applicant_id=t1.ap_id and is_current=:is_current1)
        order by
            applicant_name_en', ['is_paid' => 1, 'is_current' => 1, 'id' => $id, 'is_current1' => 1]);

        } elseif ($opening_type->opening_type_id == 3) {
            $candidate_data = DB::select('select distinct t2.exam_roll_no as roll, t1.*,ms.name_np as current_designation,mwo.name_en as working_office,
            mwl.name_np as work_level,t3.seniority_date_bs,t3.minimum_qualification_degree,t3.additional_qualification_degree,t3.minimum_qualification_division,t3.additional_qualification_division,t3.remarks as service_history_remarks
                            from vw_vacancy_post_applicant_profile t1
                            left join vacancy_exam t2 on t1.vacancy_apply_id = t2.vacancy_apply_id
                            left join applicant_service_history t3 on t1.ap_id=t3.applicant_id
                            left join mst_designation ms on ms.id=t3.designation
                            left join mst_work_level mwl on mwl.id=t3.work_level
                            left join mst_working_office mwo on t3.working_office=mwo.id
                where t3.is_current=1 and t1.vp_id =:id
                order by applicant_name_en', ['id' => $id]);
        } else {
            $candidate_data= DB::table('vw_vacancy_post_applicant_profile as t1')
                ->leftjoin('vacancy_exam as t2','t1.vacancy_apply_id','t2.vacancy_apply_id')
                ->leftjoin('mst_gender as mg','t1.gender','mg.id')
                ->select( 't2.exam_roll_no as roll','t1.*','mg.name_np as gender')
                ->where([['t1.vp_id',$id],['is_paid',true]])
                ->orderBy('applicant_name_en')->distinct()->get();
        }

        if ($opening_type->opening_type_id == 3) {
            $candidate_data = collect($candidate_data);
            $candidate_data = $candidate_data->unique('ap_id');
        }
        $education_data = [];
        foreach ($candidate_data as $key=> $cd) {
        $education_data=DB::table('applicant_edu_info as aei')
                        ->select('aei.id','aei.applicant_id','mel.name_en as edu_level','med.name_en as edu_degree','mem.name_en as edu_major')
                        ->leftjoin('mst_edu_level as mel','aei.edu_level_id','mel.id')
                        ->leftjoin('mst_edu_degree as med','aei.edu_degree_id','med.id')
                        ->leftjoin('mst_edu_major as mem','aei.edu_major_id','mem.id')
                        ->where([['applicant_id',$cd->ap_id],['aei.is_deleted',false]])
                        ->orderBY('id','desc')
                        ->get();
            $cad_education_data[$cd->ap_id]=collect($education_data);
        }

        #education data
         $education_data = [];
         foreach ($candidate_data as $cd) {
             $edu_data = DB::table('applicant_edu_info')
                 ->where('applicant_id', $cd->ap_id)
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
                 $min_degree_id = $this->getMinDegree($cd->ap_id,$id);

                 // $edu_degree_data = DB::table('mst_edu_degree')
                 //     ->select('name_en')
                 //     ->where('id', $higest_degree_id)
                 //     ->first();
                 $edu_degree_data = DB::table('mst_edu_degree')
                 ->select('name_en')
                 ->where('id', $min_degree_id)
                 ->first();
                 // $edu_major_id = $edu_data = DB::table('applicant_edu_info')
                 //     ->select('edu_major_id')
                 //     ->where([['applicant_id', $cd->ap_id], ['edu_degree_id', $higest_degree_id]])
                 //     ->first();
                 $edu_major_id = $edu_data = DB::table('applicant_edu_info')
                 ->select('edu_major_id')
                 ->where([['applicant_id', $cd->ap_id], ['edu_degree_id', $min_degree_id],['is_deleted',false]])
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

        $intro_data = DB::select('SELECT
        va.notice_no,vp.ad_no, va.ad_title_en, vp.designation_id, wl.name_en as work_level, md.name_en as designation,
    vp.total_req_seats, vp.open_seats, vp.mahila_seats, vp.madheshi_seats, vp.janajati_seats, vp.remote_seats, vp.apanga_seats, vp.dalit_seats
    FROM
        vacancy_post vp
        LEFT JOIN vacancy_ad va ON va.id = vp.vacancy_ad_id
        left join mst_designation md on md.id = vp.designation_id
        left join mst_work_level wl on wl.id = md.work_level_id
        where vp.id =:id', ['id' => $id]);

        $data['intro_data'] = $intro_data;
        $data['training_data'] = $training_data;
        $data['education_data'] = $education_data;
        $data['candidate_education_data'] = $cad_education_data;
        $data['candidate_data'] = $candidate_data;
        $data['adno_data'] = $this->getVacancyAdNo();
        $data['designation_data'] = $this->getDesignation($this->ad_id);

        if ($opening_type->opening_type_id == 1) {
          return view("selected_candidate.open_excel_report",$data);
        } elseif ($opening_type->opening_type_id == 2) {
            return view("selected_candidate.internal_excel_report",$data);
        }else{
            return view("selected_candidate.file_promotion_excel",$data);
        }

    }

}