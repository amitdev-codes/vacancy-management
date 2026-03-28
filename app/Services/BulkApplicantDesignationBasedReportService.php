<?php

namespace App\Services;

use App\Models\VwVacancyApplicant;
use Illuminate\Support\Facades\DB;

class BulkApplicantDesignationBasedReportService
{

    public function openCandidatesReport($request)
    {
//        $open_vacancy_ad = 11;
//        $page_limit=$request->limit??10;
//        $query = VwVacancyApplicant::query()
//            ->fetched($open_vacancy_ad)->select('work_level',
//                'designation_np',
//                'designation_id',
//                'token_number',
//                'name_np',
//                'mobile_no',
//                'photo',
//                'nt_staff_code',
//                'paid_receipt_no',
//                'applied_date_bs',
//                'total_paid_amount',
//                'applied_group',
//                'date_of_birth'
//            )->with(['educationInfos.eduLevel', 'gender']);
//        if ($request->has('designation')) {
//            $query->where('designation_id', $request->designation);
//        }
//        if($request->action=='excel') {
//            return $query->orderBy('name_en', 'asc')->get();
//        }
//        return $query->orderBy('name_en', 'asc')->paginate($page_limit);

        $open_vacancy_ad = 11;
        $page_limit=$request->limit??10;
        $query = DB::table('vw_vacancy_applicant as va')
            ->leftJoin('applied_applicant_edu_info as aei', 'va.token_number', '=', 'aei.vacancy_apply_id')
            ->leftJoin('mst_edu_level as mel', 'aei.edu_level_id', '=', 'mel.id')
            ->leftJoin('mst_gender as mg', 'va.gender', '=', 'mg.id')
            ->select(
                'va.id',
                'va.name_np',
                'va.date_of_birth',
                'va.token_number',
                'va.nt_staff_code',
                'va.designation_np',
                'va.total_amount',
                'va.applied_date_bs',
                'va.paid_receipt_no',
                'va.work_level',
                'va.mobile_no',
                'va.photo',
                'va.applied_group',
                'mg.name_np as gender',
                DB::raw("GROUP_CONCAT(DISTINCT mel.name_en ORDER BY mel.name_en ASC SEPARATOR ', ') as education_degrees")
            )
            ->where('va.vacancy_ad_id', $open_vacancy_ad)
            ->where('va.fiscal_year_id', 84)
            ->where('va.is_paid', 1)
            ->where('va.is_cancelled', 0)
            ->where('va.is_rejected', 0)
            ->groupBy(
                'va.id',
                'va.name_np',
                'va.date_of_birth',
                'va.token_number',
                'va.nt_staff_code',
                'va.designation_np',
                'va.total_amount',
                'va.applied_date_bs',
                'va.paid_receipt_no',
                'va.work_level',
                'va.mobile_no',
                'va.photo',
                'va.applied_group',
                'mg.name_np'
            );

        if ($request->has('designation')) {
            $query->where('va.designation_id', $request->designation);
        }

        if ($request->action == 'excel') {
            return $query->orderBy('va.name_np', 'asc')->get();
        }


        return $query->orderBy('va.name_np', 'asc')->paginate($page_limit);
    }

}