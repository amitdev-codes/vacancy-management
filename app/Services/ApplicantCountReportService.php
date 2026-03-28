<?php

namespace App\Services;

use App\Models\VacancyApply;
use Illuminate\Support\Facades\DB;

class ApplicantCountReportService
{

    public function openCandidatesReport()
    {
        return VacancyApply::select([
            'vacancy_post.ad_no AS adv_name',
            'mst_designation.name_np AS designation_name',
            'mst_work_level.name_np AS work_level',
            'mst_work_service.name_np AS service_group',
            'mst_work_service_group.name_np AS service_group_name',
            'vacancy_post.total_req_seats AS vacant_seats',
            DB::raw('COUNT(vacancy_apply.id) AS applied_users'),
            DB::raw('COUNT(CASE WHEN vacancy_apply.is_paid IS TRUE THEN 1 END) AS accepted_applicants'),
            DB::raw('COUNT(CASE WHEN vacancy_apply.is_cancelled IS TRUE THEN 1 END) AS cancelled_applicants')
        ])
            ->leftJoin('vacancy_post', 'vacancy_apply.vacancy_post_id', '=', 'vacancy_post.id')
            ->leftJoin('mst_designation', 'vacancy_post.designation_id', '=', 'mst_designation.id')
            ->leftJoin('mst_work_level', 'mst_designation.work_level_id', '=', 'mst_work_level.id')
            ->leftJoin('mst_work_service', 'mst_designation.work_service_id', '=', 'mst_work_service.id')
            ->leftJoin('mst_work_service_group', 'mst_designation.service_group_id', '=', 'mst_work_service_group.id')
            ->whereIn('vacancy_post.id', function ($query) {
                $query->select('id')
                    ->from('vacancy_post')
                    ->where('vacancy_ad_id', 11)
                    ->where('is_deleted', false);
            })
            ->where('vacancy_apply.fiscal_year_id', 84)
            ->where('vacancy_apply.is_paid', true)
            ->groupBy(
                'vacancy_post.ad_no',
                'mst_designation.name_np',
                'mst_work_level.name_np',
                'mst_work_service_group.name_np',
                'mst_work_service_group.name_np',
                'vacancy_post.total_req_seats'
            )
            ->get();
    }

    public function internalCandidatesReport()
    {
        return VacancyApply::select([
            'vacancy_post.ad_no AS adv_name',
            'mst_designation.name_np AS designation_name',
            'mst_work_level.name_np AS work_level',
            'mst_work_service.name_np AS service_group',
            'mst_work_service_group.name_np AS service_group_name',
            'vacancy_post.total_req_seats AS vacant_seats',
            DB::raw('COUNT(vacancy_apply.id) AS applied_users'),
            DB::raw('COUNT(CASE WHEN vacancy_apply.is_paid IS TRUE THEN 1 END) AS accepted_applicants'),
            DB::raw('COUNT(CASE WHEN vacancy_apply.is_cancelled IS TRUE THEN 1 END) AS cancelled_applicants')
        ])
            ->leftJoin('vacancy_post', 'vacancy_apply.vacancy_post_id', '=', 'vacancy_post.id')
            ->leftJoin('mst_designation', 'vacancy_post.designation_id', '=', 'mst_designation.id')
            ->leftJoin('mst_work_level', 'mst_designation.work_level_id', '=', 'mst_work_level.id')
            ->leftJoin('mst_work_service', 'mst_designation.work_service_id', '=', 'mst_work_service.id')
            ->leftJoin('mst_work_service_group', 'mst_designation.service_group_id', '=', 'mst_work_service_group.id')
            ->whereIn('vacancy_post.id', function ($query) {
                $query->select('id')
                    ->from('vacancy_post')
                    ->where('vacancy_ad_id', 9)
                    ->where('is_deleted', false);
            })
            ->where('vacancy_apply.fiscal_year_id', 84)
            ->where('vacancy_apply.is_paid', true)
            ->groupBy(
                'vacancy_post.ad_no',
                'mst_designation.name_np',
                'mst_work_level.name_np',
                'mst_work_service_group.name_np',
                'mst_work_service_group.name_np',
                'vacancy_post.total_req_seats'
            )
            ->get();

    }

}