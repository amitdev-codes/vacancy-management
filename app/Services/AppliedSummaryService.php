<?php

namespace App\Services;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;

class AppliedSummaryService
{

    public function exportOpenAppliedData()
    {
        $sql = "SELECT
ap.user_id AS applicant_id,
ap.first_name_np AS full_name,
mg.name_np AS gender,
ap.is_handicapped,
ap.dob_bs,
ap.photo,
ap.citizenship_no,
ap.citizenship_issued_date_bs,
ap.nt_staff_code,
md.name_np AS district_name,
mll.name_np AS loacl_level,
temp_ward_no,
ward_no,
tmp_md.name_np AS temp_district_name,
tmp_mll.name_np AS temp_loacl_level,
afi.father_name_np AS father_name,
afi.mother_name_np AS mother_name,
afi.spouse_name_np AS spouse_name,
ash.working_office AS current_office_name,
ash.date_from_bs AS date_bs,
ash.date_to_bs AS date_to_bs,
ash.designation,
ash.work_level,
ash.service_group,
ash.service_subgroup,
ashs.working_office AS current_office_name,
ashs.date_from_bs AS date_bs,
ashs.date_to_bs AS date_to_bs,
ashs.designation,
ashs.work_level,
ashs.service_group,
ashs.service_subgroup,
aei.edu_level_id,
aei.edu_degree_id,
va.designation_id,
va.token_number,
va.is_female,
va.is_open,
va.is_janajati,
va.is_dalit,
va.is_madhesi,
va.is_handicapped,
va.is_remote_village,
va.applied_date_bs,
va.total_paid_amount 
FROM
	applicant_profile AS ap
	LEFT JOIN vacancy_apply AS va ON ap.user_id = va.applicant_id
	LEFT JOIN mst_gender AS mg ON ap.gender_id = mg.id
	LEFT JOIN mst_local_level AS mll ON ap.local_level_id = mll.id
	LEFT JOIN mst_local_level AS tmp_mll ON ap.temp_local_level_id = tmp_mll.id
	LEFT JOIN mst_district AS md ON ap.district_id = md.id
	LEFT JOIN mst_district AS tmp_md ON ap.temp_district_id = tmp_md.id
	LEFT JOIN applicant_family_info AS afi ON afi.applicant_id = ap.user_id
	LEFT JOIN applicant_service_history AS ash ON ( ash.applicant_id = ap.user_id AND is_current IS TRUE )
	LEFT JOIN applicant_service_history AS ashs ON ( ashs.applicant_id = ap.user_id AND ashs.seniority_date_bs IS NOT NULL AND ashs.is_deleted IS FALSE )
	LEFT JOIN (
	SELECT
		applicant_id,
		MAX( edu_level_id ) AS edu_level_id,
		MAX( division_id ) AS division_id,
		MAX( edu_degree_id ) AS edu_degree_id 
	FROM
		applicant_edu_info 
	GROUP BY
		applicant_id 
	) AS aei ON aei.applicant_id = ap.user_id 
WHERE
	ap.user_id = 28776 
	AND va.is_deleted IS FALSE 
	AND va.fiscal_year_id = 82";

    }

    public function exportInternalAppliedData()
    {
        $sql = "SELECT
ap.user_id AS applicant_id,
ap.first_name_np AS full_name,
mg.name_np AS gender,
ap.is_handicapped,
ap.dob_bs,
ap.photo,
ap.citizenship_no,
ap.citizenship_issued_date_bs,
ap.nt_staff_code,
md.name_np AS district_name,
mll.name_np AS loacl_level,
temp_ward_no,
ward_no,
tmp_md.name_np AS temp_district_name,
tmp_mll.name_np AS temp_loacl_level,
afi.father_name_np AS father_name,
afi.mother_name_np AS mother_name,
afi.spouse_name_np AS spouse_name,
ash.working_office AS current_office_name,
ash.date_from_bs AS date_bs,
ash.date_to_bs AS date_to_bs,
ash.designation,
ash.work_level,
ash.service_group,
ash.service_subgroup,
ashs.working_office AS current_office_name,
ashs.date_from_bs AS date_bs,
ashs.date_to_bs AS date_to_bs,
ashs.designation,
ashs.work_level,
ashs.service_group,
ashs.service_subgroup,
aei.edu_level_id,
aei.edu_degree_id,
va.designation_id,
va.token_number,
va.is_female,
va.is_open,
va.is_janajati,
va.is_dalit,
va.is_madhesi,
va.is_handicapped,
va.is_remote_village,
va.applied_date_bs,
va.total_paid_amount 
FROM
	applicant_profile AS ap
	LEFT JOIN vacancy_apply AS va ON ap.user_id = va.applicant_id
	LEFT JOIN mst_gender AS mg ON ap.gender_id = mg.id
	LEFT JOIN mst_local_level AS mll ON ap.local_level_id = mll.id
	LEFT JOIN mst_local_level AS tmp_mll ON ap.temp_local_level_id = tmp_mll.id
	LEFT JOIN mst_district AS md ON ap.district_id = md.id
	LEFT JOIN mst_district AS tmp_md ON ap.temp_district_id = tmp_md.id
	LEFT JOIN applicant_family_info AS afi ON afi.applicant_id = ap.user_id
	LEFT JOIN applicant_service_history AS ash ON ( ash.applicant_id = ap.user_id AND is_current IS TRUE )
	LEFT JOIN applicant_service_history AS ashs ON ( ashs.applicant_id = ap.user_id AND ashs.seniority_date_bs IS NOT NULL AND ashs.is_deleted IS FALSE )
	LEFT JOIN (
	SELECT
		applicant_id,
		MAX( edu_level_id ) AS edu_level_id,
		MAX( division_id ) AS division_id,
		MAX( edu_degree_id ) AS edu_degree_id 
	FROM
		applicant_edu_info 
	GROUP BY
		applicant_id 
	) AS aei ON aei.applicant_id = ap.user_id 
WHERE
	ap.user_id = 28776 
	AND va.is_deleted IS FALSE 
	AND va.fiscal_year_id = 82";

    }

    public function exportFilePromotionAppliedData()
    {
        $sql = "SELECT
ap.user_id AS applicant_id,
ap.first_name_np AS full_name,
mg.name_np AS gender,
ap.is_handicapped,
ap.dob_bs,
ap.photo,
ap.citizenship_no,
ap.citizenship_issued_date_bs,
ap.nt_staff_code,
md.name_np AS district_name,
mll.name_np AS loacl_level,
temp_ward_no,
ward_no,
tmp_md.name_np AS temp_district_name,
tmp_mll.name_np AS temp_loacl_level,
afi.father_name_np AS father_name,
afi.mother_name_np AS mother_name,
afi.spouse_name_np AS spouse_name,
ash.working_office AS current_office_name,
ash.date_from_bs AS date_bs,
ash.date_to_bs AS date_to_bs,
ash.designation,
ash.work_level,
ash.service_group,
ash.service_subgroup,
ashs.working_office AS current_office_name,
ashs.date_from_bs AS date_bs,
ashs.date_to_bs AS date_to_bs,
ashs.designation,
ashs.work_level,
ashs.service_group,
ashs.service_subgroup,
aei.edu_level_id,
aei.edu_degree_id,
va.designation_id,
va.token_number,
va.is_female,
va.is_open,
va.is_janajati,
va.is_dalit,
va.is_madhesi,
va.is_handicapped,
va.is_remote_village,
va.applied_date_bs,
va.total_paid_amount 
FROM
	applicant_profile AS ap
	LEFT JOIN vacancy_apply AS va ON ap.user_id = va.applicant_id
	LEFT JOIN mst_gender AS mg ON ap.gender_id = mg.id
	LEFT JOIN mst_local_level AS mll ON ap.local_level_id = mll.id
	LEFT JOIN mst_local_level AS tmp_mll ON ap.temp_local_level_id = tmp_mll.id
	LEFT JOIN mst_district AS md ON ap.district_id = md.id
	LEFT JOIN mst_district AS tmp_md ON ap.temp_district_id = tmp_md.id
	LEFT JOIN applicant_family_info AS afi ON afi.applicant_id = ap.user_id
	LEFT JOIN applicant_service_history AS ash ON ( ash.applicant_id = ap.user_id AND is_current IS TRUE )
	LEFT JOIN applicant_service_history AS ashs ON ( ashs.applicant_id = ap.user_id AND ashs.seniority_date_bs IS NOT NULL AND ashs.is_deleted IS FALSE )
	LEFT JOIN (
	SELECT
		applicant_id,
		MAX( edu_level_id ) AS edu_level_id,
		MAX( division_id ) AS division_id,
		MAX( edu_degree_id ) AS edu_degree_id 
	FROM
		applicant_edu_info 
	GROUP BY
		applicant_id 
	) AS aei ON aei.applicant_id = ap.user_id 
WHERE
	ap.user_id = 28776 
	AND va.is_deleted IS FALSE 
	AND va.fiscal_year_id = 82";

    }

//    public function exportFilePromotionReport($vacancy_post_id): array
//    {
//        $vacancy_ad = Cache::get('file_promotion_type_settings');
//        $fiscal_year_id = Cache::get('fiscal_year_id');
//        $data['notice_no'] = $vacancy_ad->notice_no;
//        $data['ad_title_en'] = $vacancy_ad->ad_title_en;
//
//        $applicants = DB::table('vw_vacancy_applicant')
//            ->where([
//                ['vacancy_post_id', $vacancy_post_id],
//                ['fiscal_year_id', $fiscal_year_id],
//                ['is_open', null],
//                ['vacancy_ad_id', $vacancy_ad->id],
//            ])
//            ->get([
//                'token_number',
//                'applicant_id',
//                'designation_np',
//                'vacancy_post_id',
//                'ad_no',
//                'work_level',
//                'service_group',
//                'applied_date_bs',
//                'nt_staff_code',
//                'name_np'
//            ]);
//
//        foreach ($applicants as $app) {
//            $applicant_id = $applicants->applicant_id;
//            $data['vacancy_ad_no'] = $applicants->ad_no;
//            $data['token_no'] = $applicants->token_number;
//            $data['work_level'] = $applicants->work_level;
//            $data['service_group'] = $applicants->service_group;
//
//            $data['sub_group'] = $applicants->sub_group;
//            $data['designation_np'] = $applicants->designation_np;
//            $data['applied_date_bs'] = $applicants->applied_date_bs;
//            $data['nt_staff_code'] = $applicants->nt_staff_code;
//            $data['name_np'] = $applicants->name_np;
//            $data['photo'] = $applicants->photo;
//            $data['signature_upload'] = $applicants->signature_upload;
//
//            $data['family_info'] = DB::table('applicant_family_info')
//                ->where('applicant_id', $applicant_id)
//                ->where('is_deleted', false)
//                ->first(['father_name_np', 'mother_name_np', 'grand_father_name_np', 'spouse_name_np']);
//
//            $data['starting_office'] = DB::table('applicant_service_history as ash')
//                ->select(
//                    'eo.district AS district',
//                    'mwo.name_en AS working_office',
//                    'mwsg.name_np as service_group',
//                    'mwss.name_np as service_subgroup',
//                    'mwl.name_np as work_level',
//                    'md.name_np as designation',
//                    'ash.date_from_ad',
//                    'ash.date_to_ad',
//                    'ash.date_from_bs',
//                    'ash.date_to_bs',
//                    'ash.is_current',
//                    'ash.is_office_incharge',
//                    'ash.incharge_date_from_ad',
//                    'ash.incharge_date_to_ad'
//                )
//                ->leftjoin('mst_working_office as mwo', 'ash.working_office', 'mwo.id')
//                ->leftjoin('mst_work_service_group as mwsg', 'ash.service_group', 'mwsg.id')
//                ->leftjoin('mst_work_service_sub_group as mwss', 'ash.service_subgroup', 'mwss.id')
//                ->leftjoin('mst_work_level as mwl', 'ash.work_level', 'mwl.id')
//                ->leftjoin('mst_designation as md', 'ash.designation', 'md.id')
//                ->leftJoin('erp_organization AS eo', function ($join) {
//                    $join->on('eo.working_office_id', '=', 'ash.working_office')
//                        ->whereNotNull('eo.district');
//                })
//                ->where('ash.applicant_id', $applicant_id)
//                ->where('ash.is_deleted', false)
//                ->whereNotNull('seniority_date_bs')
//                ->distinct()
//                ->first();
//
//            $data['applicant_service_history'] = DB::table('applicant_service_history as ash')
//                ->select(
//                    'eo.district AS district',
//                    'mwo.name_en AS working_office',
//                    'ash.date_from_ad',
//                    'ash.date_to_ad',
//                    'ash.date_from_bs',
//                    'ash.date_to_bs',
//                    'ash.is_current',
//                    'ash.is_office_incharge',
//                    'ash.incharge_date_from_ad',
//                    'ash.incharge_date_to_ad'
//                )
//                ->leftjoin('mst_working_office as mwo', 'ash.working_office', 'mwo.id')
//                ->leftJoin('erp_organization AS eo', function ($join) {
//                    $join->on('eo.working_office_id', '=', 'ash.working_office')
//                        ->whereNotNull('eo.district');
//                })
//                ->where('ash.applicant_id', $applicant_id)
//                ->where('ash.is_deleted', false)
//                ->distinct()
//                ->get();
//
//            $data['current_position'] = DB::table('applicant_service_history as ash')
//                ->select(
//                    'mwo.name_en AS working_office',
//                    'md.name_en as designation',
//                    'mwl.name_en as work_level',
//                    'sg.name_np as service_group',
//                    'ssg.name_np as service_sub_group',
//                    'seniority_date_bs',
//                    'ash.date_from_bs'
//                )
//                ->leftjoin('mst_designation as md', 'md.id', '=', 'ash.designation')
//                ->leftjoin('mst_work_level as mwl', 'mwl.id', '=', 'ash.work_level')
//                ->leftjoin('mst_work_service_group as sg', 'ash.service_group', '=', 'sg.id')
//                ->leftjoin('mst_work_service_sub_group as ssg', 'ash.service_subgroup', '=', 'ssg.id')
//                ->leftjoin('mst_working_office as mwo', 'ash.working_office', 'mwo.id')
//                ->leftJoin('erp_organization AS eo', function ($join) {
//                    $join->on('eo.working_office_id', '=', 'ash.working_office')
//                        ->whereNotNull('eo.district');
//                })
//                ->where([['ash.applicant_id', $applicant_id], ['ash.is_current', true]])
//                ->first();
//
//            $data['office_incharge'] = DB::table('applicant_service_history as ash')
//                ->select(
//                    'md.name_np as district',
//                    'mw.name_en as working_office',
//                    'ash.is_office_incharge',
//                    'ash.incharge_date_from_bs',
//                    'ash.incharge_date_to_bs',
//                    'ash.leave_letter'
//                )
//                ->leftjoin('mst_working_office as mw', 'mw.id', '=', 'ash.working_office')
//                ->leftjoin('mst_district as md', 'md.id', '=', 'mw.district_id')
//                ->where([['ash.applicant_id', $applicant_id], ['ash.is_office_incharge', true], ['ash.is_deleted', false]])
//                ->orderBy('ash.date_from_ad')
//                ->get();
//
//            $data['address'] = DB::table('applicant_profile as ap')
//                ->select(
//                    'md.name_np as temp_district',
//                    'mll.name_np as temp_local_level',
//                    'ap.temp_ward_no',
//                    'ap.temp_tole_name',
//                    'pmd.name_np as perm_district',
//                    'pmll.name_np as perm_local_level',
//                    'ap.ward_no',
//                    'ap.tole_name',
//                    'cmd.name_np as citizenship_issued_district'
//                )
//                ->leftjoin('mst_local_level as mll', 'ap.temp_local_level_id', '=', 'mll.id')
//                ->leftjoin('mst_local_level as pmll', 'ap.local_level_id', '=', 'pmll.id')
//                ->leftjoin('mst_district as md', 'ap.temp_district_id', '=', 'md.id')
//                ->leftjoin('mst_district as pmd', 'ap.district_id', '=', 'pmd.id')
//                ->leftjoin('mst_district as cmd', 'ap.citizenship_issued_from', '=', 'cmd.id')
//                ->where('user_id', $applicant_id)
//                ->first();
//
//            $data['education'] = DB::table('applicant_edu_info as edu')
//                ->select('mel.name_np as level', 'edu.country_name as country',
//                    'ed.name_np as edu_degree',
//                    'edu.degree_name', 'edu.university', 'edu.specialization', 'edv.name_en as division', 'my.year_bs as passed_year_bs', 'edu.passed_year_ad')
//                ->leftjoin('mst_edu_degree as ed', 'ed.id', '=', 'edu.edu_degree_id')
//                ->leftjoin('mst_edu_division as edv', 'edv.id', '=', 'edu.division_id')
//                ->leftjoin('mst_year as my', 'edu.passed_year_bs', '=', 'my.id')
//                ->leftjoin('mst_edu_level as mel', 'edu.edu_level_id', '=', 'mel.id')
//                ->leftjoin('mst_university as mu', 'edu.university', '=', 'mu.id')
//                ->where([['edu.applicant_id', $applicant_id], ['edu.is_deleted', false]])
//                ->orderBy('edu.passed_year_ad', 'desc')
//                ->get();
//
//            $data['leave_details'] = DB::table('applicant_leave_details as ald')
//                ->leftjoin('mst_leave_type as mlt', 'ald.leave_type_id', '=', 'mlt.id')
//                ->where([['ald.applicant_id', $applicant_id], ['ald.is_deleted', false]])
//                ->get(['mlt.name_np as leave_type', 'date_from_bs', 'date_to_bs']);
//
//            $data['training_details'] = DB::table('applicant_training_info as ati')
//                ->leftjoin('mst_training as mt', 'ati.training_id', '=', 'mt.id')
//                ->leftjoin('mst_training_major as mtm', 'ati.training_major_id', '=', 'mtm.id')
//                ->where([['ati.applicant_id', $applicant_id], ['ati.is_deleted', false]])
//                ->get(['training_title', 'institute_name', 'institute_address', 'year_bs', 'duration_period', 'mt.name_np AS training', 'mtm.name_np AS training_major']);
//
//            $html = View::make('admin.reports.file_promotion_report', $data);
//            $filePath = storage_path('app/public/file_promotion_report/file_promotion_report.html');
//            File::put($filePath, $html);
//            return ['status' => true];
//        }
//        return ['status' => false];
//    }

    public function exportFilePromotionReport($vacancy_post_id)
    {
        $vacancy_ad = Cache::get('file_promotion_type_settings');
        $fiscal_year_id = Cache::get('fiscal_year_id');

        $applicants = DB::table('vw_vacancy_applicant')
            ->where([
                ['vacancy_post_id', $vacancy_post_id],
                ['fiscal_year_id', $fiscal_year_id],
                ['is_open', null],
                ['vacancy_ad_id', $vacancy_ad->id],
            ])
            ->get();
        foreach ($applicants as $applicant) {
            $data = [
                'notice_no' => $vacancy_ad->notice_no,
                'ad_title_en' => $vacancy_ad->ad_title_en,
                'vacancy_ad_no' => $applicant->ad_no,
                'token_no' => $applicant->token_number,
                'work_level' => $applicant->work_level,
                'service_group' => $applicant->service_group,
                'sub_group' => $applicant->sub_group,
                'designation_np' => $applicant->designation_np,
                'applied_date_bs' => $applicant->applied_date_bs,
                'nt_staff_code' => $applicant->nt_staff_code,
                'name_np' => $applicant->name_np,
                'photo' => $applicant->photo,
                'signature_upload' => $applicant->signature_upload,
                'family_info' => DB::table('applicant_family_info')
                    ->where('applicant_id', $applicant->applicant_id)
                    ->where('is_deleted', false)
                    ->first(['father_name_np', 'mother_name_np', 'grand_father_name_np', 'spouse_name_np']),
                'starting_office' => DB::table('applicant_service_history as ash')
                    ->select(
                        'eo.district AS district',
                        'mwo.name_en AS working_office',
                        'mwsg.name_np as service_group',
                        'mwss.name_np as service_subgroup',
                        'mwl.name_np as work_level',
                        'md.name_np as designation',
                        'ash.date_from_ad',
                        'ash.date_to_ad',
                        'ash.date_from_bs',
                        'ash.date_to_bs',
                        'ash.is_current',
                        'ash.is_office_incharge',
                        'ash.incharge_date_from_ad',
                        'ash.incharge_date_to_ad'
                    )
                    ->leftJoin('mst_working_office as mwo', 'ash.working_office', 'mwo.id')
                    ->leftJoin('mst_work_service_group as mwsg', 'ash.service_group', 'mwsg.id')
                    ->leftJoin('mst_work_service_sub_group as mwss', 'ash.service_subgroup', 'mwss.id')
                    ->leftJoin('mst_work_level as mwl', 'ash.work_level', 'mwl.id')
                    ->leftJoin('mst_designation as md', 'ash.designation', 'md.id')
                    ->leftJoin('erp_organization AS eo', function ($join) {
                        $join->on('eo.working_office_id', '=', 'ash.working_office')
                            ->whereNotNull('eo.district');
                    })
                    ->where('ash.applicant_id', $applicant->applicant_id)
                    ->where('ash.is_deleted', false)
                    ->whereNotNull('seniority_date_bs')
                    ->distinct()
                    ->first(),
                'applicant_service_history' => DB::table('applicant_service_history as ash')
                    ->select(
                        'md.name_np AS district',
                        'mwo.name_en AS working_office',
                        'ash.date_from_ad',
                        'ash.date_to_ad',
                        'ash.date_from_bs',
                        'ash.date_to_bs',
                        'ash.is_current',
                        'ash.is_office_incharge',
                        'ash.incharge_date_from_ad',
                        'ash.incharge_date_to_ad',
                        'mgc.name_np as varga'
                    )
                    ->leftJoin('mst_working_office as mwo', 'ash.working_office', 'mwo.id')
                    ->leftJoin('mst_geo_category as mgc', 'mwo.geo_category', 'mgc.id')
                    ->leftJoin('erp_organization AS eo', function ($join) {
                        $join->on('eo.working_office_id', '=', 'ash.working_office')
                            ->whereNotNull('eo.district');
                    })
                    ->leftJoin('mst_district as md', 'eo.district', 'md.id')
                    ->where('ash.applicant_id', $applicant->applicant_id)
                    ->where('ash.is_deleted', false)
                    ->distinct()
                    ->get(),
                'current_position' => DB::table('applicant_service_history as ash')
                    ->select(
                        'mwo.name_en AS working_office',
                        'md.name_en as designation',
                        'mwl.name_en as work_level',
                        'sg.name_np as service_group',
                        'ssg.name_np as service_sub_group',
                        'seniority_date_bs',
                        'ash.date_from_bs'
                    )
                    ->leftJoin('mst_designation as md', 'md.id', '=', 'ash.designation')
                    ->leftJoin('mst_work_level as mwl', 'mwl.id', '=', 'ash.work_level')
                    ->leftJoin('mst_work_service_group as sg', 'ash.service_group', '=', 'sg.id')
                    ->leftJoin('mst_work_service_sub_group as ssg', 'ash.service_subgroup', '=', 'ssg.id')
                    ->leftJoin('mst_working_office as mwo', 'ash.working_office', 'mwo.id')
                    ->leftJoin('erp_organization AS eo', function ($join) {
                        $join->on('eo.working_office_id', '=', 'ash.working_office')
                            ->whereNotNull('eo.district');
                    })
                    ->where([['ash.applicant_id', $applicant->applicant_id], ['ash.is_current', true]])
                    ->first(),
                'office_incharge' => DB::table('applicant_service_history as ash')
                    ->select(
                        'md.name_np as district',
                        'mw.name_en as working_office',
                        'ash.is_office_incharge',
                        'ash.incharge_date_from_bs',
                        'ash.incharge_date_to_bs',
                        'ash.leave_letter'
                    )
                    ->leftJoin('mst_working_office as mw', 'mw.id', '=', 'ash.working_office')
                    ->leftJoin('mst_district as md', 'md.id', '=', 'mw.district_id')
                    ->where([['ash.applicant_id', $applicant->applicant_id], ['ash.is_office_incharge', true], ['ash.is_deleted', false]])
                    ->orderBy('ash.date_from_ad')
                    ->get(),
                'address' => DB::table('applicant_profile as ap')
                    ->select(
                        'md.name_np as temp_district',
                        'mll.name_np as temp_local_level',
                        'ap.temp_ward_no',
                        'ap.temp_tole_name',
                        'pmd.name_np as perm_district',
                        'pmll.name_np as perm_local_level',
                        'ap.ward_no',
                        'ap.tole_name',
                        'cmd.name_np as citizenship_issued_district'
                    )
                    ->leftJoin('mst_local_level as mll', 'ap.temp_local_level_id', '=', 'mll.id')
                    ->leftJoin('mst_local_level as pmll', 'ap.local_level_id', '=', 'pmll.id')
                    ->leftJoin('mst_district as md', 'ap.temp_district_id', '=', 'md.id')
                    ->leftJoin('mst_district as pmd', 'ap.district_id', '=', 'pmd.id')
                    ->leftJoin('mst_district as cmd', 'ap.citizenship_issued_from', '=', 'cmd.id')
                    ->where('user_id', $applicant->applicant_id)
                    ->first(),
                'education' => DB::table('applicant_edu_info as edu')
                    ->select('mel.name_np as level', 'edu.country_name as country',
                        'ed.name_np as edu_degree',
                        'edu.degree_name', 'mu.name_np as university', 'edu.specialization', 'edv.name_en as division', 'my.year_bs as passed_year_bs', 'edu.passed_year_ad')
                    ->leftJoin('mst_edu_degree as ed', 'ed.id', '=', 'edu.edu_degree_id')
                    ->leftJoin('mst_edu_division as edv', 'edv.id', '=', 'edu.division_id')
                    ->leftJoin('mst_year as my', 'edu.passed_year_bs', '=', 'my.id')
                    ->leftJoin('mst_edu_level as mel', 'edu.edu_level_id', '=', 'mel.id')
                    ->leftJoin('mst_university as mu', 'edu.university', '=', 'mu.id')
                    ->where([['edu.applicant_id', $applicant->applicant_id], ['edu.is_deleted', false]])
                    ->orderBy('edu.passed_year_ad', 'desc')
                    ->get(),
                'leave_details' => DB::table('applicant_leave_details as ald')
                    ->leftJoin('mst_leave_type as mlt', 'ald.leave_type_id', '=', 'mlt.id')
                    ->where([['ald.applicant_id', $applicant->applicant_id], ['ald.is_deleted', false]])
                    ->get(['mlt.name_np as leave_type', 'date_from_bs', 'date_to_bs']),
                'training_details' => DB::table('applicant_training_info as ati')
                    ->select('training_title', 'institute_name', 'institute_address', 'year_bs', 'duration_period', 'mt.name_np AS training', 'mtm.name_np AS training_major')
                    ->leftJoin('mst_training as mt', 'ati.training_id', '=', 'mt.id')
                    ->leftJoin('mst_training_major as mtm', 'ati.training_major_id', '=', 'mtm.id')
                    ->where([['ati.applicant_id', $applicant->applicant_id], ['ati.is_deleted', false]])
                    ->get()
            ];
            $html_content = View::make('admin.reports.file_promotion_report', $data);
            $filePath = 'bulk_reports/file_promotion_report/'.$vacancy_post_id.'/'.$applicant->token_number.'_'.$applicant->name_en. '.html';
            Storage::put($filePath, $html_content);
        }
        return ['status' => true];
    }
    public function exportInternalReport($vacancy_post_id): array
    {
        $vacancy_ad = Cache::get('file_promotion_type_settings');
        $fiscal_year_id = Cache::get('fiscal_year_id');

        $applicants = DB::table('vw_vacancy_applicant')
            ->where([
                ['vacancy_post_id', $vacancy_post_id],
                ['fiscal_year_id', $fiscal_year_id],
                ['is_open', null],
                ['vacancy_ad_id', $vacancy_ad->id],
            ])
            ->get();

        foreach ($applicants as $applicant) {
            $data = [
                'notice_no' => $vacancy_ad->notice_no,
                'ad_title_en' => $vacancy_ad->ad_title_en,
                'vacancy_ad_no' => $applicant->ad_no,
                'token_no' => $applicant->token_number,
                'work_level' => $applicant->work_level,
                'service_group' => $applicant->service_group,
                'sub_group' => $applicant->sub_group,
                'designation_np' => $applicant->designation_np,
                'applied_date_bs' => $applicant->applied_date_bs,
                'nt_staff_code' => $applicant->nt_staff_code,
                'name_np' => $applicant->name_np,
                'photo' => $applicant->photo,
                'signature_upload' => $applicant->signature_upload,
                'family_info' => DB::table('applicant_family_info')
                    ->where('applicant_id', $applicant->applicant_id)
                    ->where('is_deleted', false)
                    ->first(['father_name_np', 'mother_name_np', 'grand_father_name_np', 'spouse_name_np']),
                'starting_office' => DB::table('applicant_service_history as ash')
                    ->select(
                        'eo.district AS district',
                        'mwo.name_en AS working_office',
                        'mwsg.name_np as service_group',
                        'mwss.name_np as service_subgroup',
                        'mwl.name_np as work_level',
                        'md.name_np as designation',
                        'ash.date_from_ad',
                        'ash.date_to_ad',
                        'ash.date_from_bs',
                        'ash.date_to_bs',
                        'ash.is_current',
                        'ash.is_office_incharge',
                        'ash.incharge_date_from_ad',
                        'ash.incharge_date_to_ad'
                    )
                    ->leftJoin('mst_working_office as mwo', 'ash.working_office', 'mwo.id')
                    ->leftJoin('mst_work_service_group as mwsg', 'ash.service_group', 'mwsg.id')
                    ->leftJoin('mst_work_service_sub_group as mwss', 'ash.service_subgroup', 'mwss.id')
                    ->leftJoin('mst_work_level as mwl', 'ash.work_level', 'mwl.id')
                    ->leftJoin('mst_designation as md', 'ash.designation', 'md.id')
                    ->leftJoin('erp_organization AS eo', function ($join) {
                        $join->on('eo.working_office_id', '=', 'ash.working_office')
                            ->whereNotNull('eo.district');
                    })
                    ->where('ash.applicant_id', $applicant->applicant_id)
                    ->where('ash.is_deleted', false)
                    ->whereNotNull('seniority_date_bs')
                    ->distinct()
                    ->first(),
                'applicant_service_history' => DB::table('applicant_service_history as ash')
                    ->select(
                        'eo.district AS district',
                        'mwo.name_en AS working_office',
                        'ash.date_from_ad',
                        'ash.date_to_ad',
                        'ash.date_from_bs',
                        'ash.date_to_bs',
                        'ash.is_current',
                        'ash.is_office_incharge',
                        'ash.incharge_date_from_ad',
                        'ash.incharge_date_to_ad'
                    )
                    ->leftJoin('mst_working_office as mwo', 'ash.working_office', 'mwo.id')
                    ->leftJoin('erp_organization AS eo', function ($join) {
                        $join->on('eo.working_office_id', '=', 'ash.working_office')
                            ->whereNotNull('eo.district');
                    })
                    ->where('ash.applicant_id', $applicant->applicant_id)
                    ->where('ash.is_deleted', false)
                    ->distinct()
                    ->get(),
                'current_position' => DB::table('applicant_service_history as ash')
                    ->select(
                        'mwo.name_en AS working_office',
                        'md.name_en as designation',
                        'mwl.name_en as work_level',
                        'sg.name_np as service_group',
                        'ssg.name_np as service_sub_group',
                        'seniority_date_bs',
                        'ash.date_from_bs'
                    )
                    ->leftJoin('mst_designation as md', 'md.id', '=', 'ash.designation')
                    ->leftJoin('mst_work_level as mwl', 'mwl.id', '=', 'ash.work_level')
                    ->leftJoin('mst_work_service_group as sg', 'ash.service_group', '=', 'sg.id')
                    ->leftJoin('mst_work_service_sub_group as ssg', 'ash.service_subgroup', '=', 'ssg.id')
                    ->leftJoin('mst_working_office as mwo', 'ash.working_office', 'mwo.id')
                    ->leftJoin('erp_organization AS eo', function ($join) {
                        $join->on('eo.working_office_id', '=', 'ash.working_office')
                            ->whereNotNull('eo.district');
                    })
                    ->where([['ash.applicant_id', $applicant->applicant_id], ['ash.is_current', true]])
                    ->first(),
                'office_incharge' => DB::table('applicant_service_history as ash')
                    ->select(
                        'md.name_np as district',
                        'mw.name_en as working_office',
                        'ash.is_office_incharge',
                        'ash.incharge_date_from_bs',
                        'ash.incharge_date_to_bs',
                        'ash.leave_letter'
                    )
                    ->leftJoin('mst_working_office as mw', 'mw.id', '=', 'ash.working_office')
                    ->leftJoin('mst_district as md', 'md.id', '=', 'mw.district_id')
                    ->where([['ash.applicant_id', $applicant->applicant_id], ['ash.is_office_incharge', true], ['ash.is_deleted', false]])
                    ->orderBy('ash.date_from_ad')
                    ->get(),
                'address' => DB::table('applicant_profile as ap')
                    ->select(
                        'md.name_np as temp_district',
                        'mll.name_np as temp_local_level',
                        'ap.temp_ward_no',
                        'ap.temp_tole_name',
                        'pmd.name_np as perm_district',
                        'pmll.name_np as perm_local_level',
                        'ap.ward_no',
                        'ap.tole_name',
                        'cmd.name_np as citizenship_issued_district'
                    )
                    ->leftJoin('mst_local_level as mll', 'ap.temp_local_level_id', '=', 'mll.id')
                    ->leftJoin('mst_local_level as pmll', 'ap.local_level_id', '=', 'pmll.id')
                    ->leftJoin('mst_district as md', 'ap.temp_district_id', '=', 'md.id')
                    ->leftJoin('mst_district as pmd', 'ap.district_id', '=', 'pmd.id')
                    ->leftJoin('mst_district as cmd', 'ap.citizenship_issued_from', '=', 'cmd.id')
                    ->where('user_id', $applicant->applicant_id)
                    ->first(),
                'education' => DB::table('applicant_edu_info as edu')
                    ->select('mel.name_np as level', 'edu.country_name as country',
                        'ed.name_np as edu_degree',
                        'edu.degree_name', 'edu.university', 'edu.specialization', 'edv.name_en as division', 'my.year_bs as passed_year_bs', 'edu.passed_year_ad')
                    ->leftJoin('mst_edu_degree as ed', 'ed.id', '=', 'edu.edu_degree_id')
                    ->leftJoin('mst_edu_division as edv', 'edv.id', '=', 'edu.division_id')
                    ->leftJoin('mst_year as my', 'edu.passed_year_bs', '=', 'my.id')
                    ->leftJoin('mst_edu_level as mel', 'edu.edu_level_id', '=', 'mel.id')
                    ->leftJoin('mst_university as mu', 'edu.university', '=', 'mu.id')
                    ->where([['edu.applicant_id', $applicant->applicant_id], ['edu.is_deleted', false]])
                    ->orderBy('edu.passed_year_ad', 'desc')
                    ->get(),
                'leave_details' => DB::table('applicant_leave_details as ald')
                    ->leftJoin('mst_leave_type as mlt', 'ald.leave_type_id', '=', 'mlt.id')
                    ->where([['ald.applicant_id', $applicant->applicant_id], ['ald.is_deleted', false]])
                    ->get(['mlt.name_np as leave_type', 'date_from_bs', 'date_to_bs']),
                'training_details' => DB::table('applicant_training_info as ati')
                    ->leftJoin('mst_training as mt', 'ati.training_id', '=', 'mt.id')
                    ->leftJoin('mst_training_major as mtm', 'ati.training_major_id', '=', 'mtm.id')
                    ->where([['ati.applicant_id', $applicant->applicant_id], ['ati.is_deleted', false]])
                    ->get(['training_title', 'institute_name', 'institute_address', 'year_bs', 'duration_period', 'mt.name_np AS training', 'mtm.name_np AS training_major'])
            ];
            $html = View::make('admin.reports.file_promotion_report', $data);
            $filePath = storage_path('app/public/internal_report/'.$vacancy_post_id.'/'.$applicant->token_number.'.html');
            File::put($filePath, $html);
            return ['status' => true];
        }
        return ['status' => false];
    }
    public function exportOpenReport($vacancy_post_id): array
    {
        $vacancy_ad = Cache::get('file_promotion_type_settings');
        $fiscal_year_id = Cache::get('fiscal_year_id');

        $applicants = DB::table('vw_vacancy_applicant')
            ->where([
                ['vacancy_post_id', $vacancy_post_id],
                ['fiscal_year_id', $fiscal_year_id],
                ['is_open', null],
                ['vacancy_ad_id', $vacancy_ad->id],
            ])
            ->get();

        foreach ($applicants as $applicant) {
            $data = [
                'notice_no' => $vacancy_ad->notice_no,
                'ad_title_en' => $vacancy_ad->ad_title_en,
                'vacancy_ad_no' => $applicant->ad_no,
                'token_no' => $applicant->token_number,
                'work_level' => $applicant->work_level,
                'service_group' => $applicant->service_group,
                'sub_group' => $applicant->sub_group,
                'designation_np' => $applicant->designation_np,
                'applied_date_bs' => $applicant->applied_date_bs,
                'nt_staff_code' => $applicant->nt_staff_code,
                'name_np' => $applicant->name_np,
                'photo' => $applicant->photo,
                'signature_upload' => $applicant->signature_upload,
                'family_info' => DB::table('applicant_family_info')
                    ->where('applicant_id', $applicant->applicant_id)
                    ->where('is_deleted', false)
                    ->first(['father_name_np', 'mother_name_np', 'grand_father_name_np', 'spouse_name_np']),
                'starting_office' => DB::table('applicant_service_history as ash')
                    ->select(
                        'eo.district AS district',
                        'mwo.name_en AS working_office',
                        'mwsg.name_np as service_group',
                        'mwss.name_np as service_subgroup',
                        'mwl.name_np as work_level',
                        'md.name_np as designation',
                        'ash.date_from_ad',
                        'ash.date_to_ad',
                        'ash.date_from_bs',
                        'ash.date_to_bs',
                        'ash.is_current',
                        'ash.is_office_incharge',
                        'ash.incharge_date_from_ad',
                        'ash.incharge_date_to_ad'
                    )
                    ->leftJoin('mst_working_office as mwo', 'ash.working_office', 'mwo.id')
                    ->leftJoin('mst_work_service_group as mwsg', 'ash.service_group', 'mwsg.id')
                    ->leftJoin('mst_work_service_sub_group as mwss', 'ash.service_subgroup', 'mwss.id')
                    ->leftJoin('mst_work_level as mwl', 'ash.work_level', 'mwl.id')
                    ->leftJoin('mst_designation as md', 'ash.designation', 'md.id')
                    ->leftJoin('erp_organization AS eo', function ($join) {
                        $join->on('eo.working_office_id', '=', 'ash.working_office')
                            ->whereNotNull('eo.district');
                    })
                    ->where('ash.applicant_id', $applicant->applicant_id)
                    ->where('ash.is_deleted', false)
                    ->whereNotNull('seniority_date_bs')
                    ->distinct()
                    ->first(),
                'applicant_service_history' => DB::table('applicant_service_history as ash')
                    ->select(
                        'eo.district AS district',
                        'mwo.name_en AS working_office',
                        'ash.date_from_ad',
                        'ash.date_to_ad',
                        'ash.date_from_bs',
                        'ash.date_to_bs',
                        'ash.is_current',
                        'ash.is_office_incharge',
                        'ash.incharge_date_from_ad',
                        'ash.incharge_date_to_ad'
                    )
                    ->leftJoin('mst_working_office as mwo', 'ash.working_office', 'mwo.id')
                    ->leftJoin('erp_organization AS eo', function ($join) {
                        $join->on('eo.working_office_id', '=', 'ash.working_office')
                            ->whereNotNull('eo.district');
                    })
                    ->where('ash.applicant_id', $applicant->applicant_id)
                    ->where('ash.is_deleted', false)
                    ->distinct()
                    ->get(),
                'current_position' => DB::table('applicant_service_history as ash')
                    ->select(
                        'mwo.name_en AS working_office',
                        'md.name_en as designation',
                        'mwl.name_en as work_level',
                        'sg.name_np as service_group',
                        'ssg.name_np as service_sub_group',
                        'seniority_date_bs',
                        'ash.date_from_bs'
                    )
                    ->leftJoin('mst_designation as md', 'md.id', '=', 'ash.designation')
                    ->leftJoin('mst_work_level as mwl', 'mwl.id', '=', 'ash.work_level')
                    ->leftJoin('mst_work_service_group as sg', 'ash.service_group', '=', 'sg.id')
                    ->leftJoin('mst_work_service_sub_group as ssg', 'ash.service_subgroup', '=', 'ssg.id')
                    ->leftJoin('mst_working_office as mwo', 'ash.working_office', 'mwo.id')
                    ->leftJoin('erp_organization AS eo', function ($join) {
                        $join->on('eo.working_office_id', '=', 'ash.working_office')
                            ->whereNotNull('eo.district');
                    })
                    ->where([['ash.applicant_id', $applicant->applicant_id], ['ash.is_current', true]])
                    ->first(),
                'office_incharge' => DB::table('applicant_service_history as ash')
                    ->select(
                        'md.name_np as district',
                        'mw.name_en as working_office',
                        'ash.is_office_incharge',
                        'ash.incharge_date_from_bs',
                        'ash.incharge_date_to_bs',
                        'ash.leave_letter'
                    )
                    ->leftJoin('mst_working_office as mw', 'mw.id', '=', 'ash.working_office')
                    ->leftJoin('mst_district as md', 'md.id', '=', 'mw.district_id')
                    ->where([['ash.applicant_id', $applicant->applicant_id], ['ash.is_office_incharge', true], ['ash.is_deleted', false]])
                    ->orderBy('ash.date_from_ad')
                    ->get(),
                'address' => DB::table('applicant_profile as ap')
                    ->select(
                        'md.name_np as temp_district',
                        'mll.name_np as temp_local_level',
                        'ap.temp_ward_no',
                        'ap.temp_tole_name',
                        'pmd.name_np as perm_district',
                        'pmll.name_np as perm_local_level',
                        'ap.ward_no',
                        'ap.tole_name',
                        'cmd.name_np as citizenship_issued_district'
                    )
                    ->leftJoin('mst_local_level as mll', 'ap.temp_local_level_id', '=', 'mll.id')
                    ->leftJoin('mst_local_level as pmll', 'ap.local_level_id', '=', 'pmll.id')
                    ->leftJoin('mst_district as md', 'ap.temp_district_id', '=', 'md.id')
                    ->leftJoin('mst_district as pmd', 'ap.district_id', '=', 'pmd.id')
                    ->leftJoin('mst_district as cmd', 'ap.citizenship_issued_from', '=', 'cmd.id')
                    ->where('user_id', $applicant->applicant_id)
                    ->first(),
                'education' => DB::table('applicant_edu_info as edu')
                    ->select('mel.name_np as level', 'edu.country_name as country',
                        'ed.name_np as edu_degree',
                        'edu.degree_name', 'edu.university', 'edu.specialization', 'edv.name_en as division', 'my.year_bs as passed_year_bs', 'edu.passed_year_ad')
                    ->leftJoin('mst_edu_degree as ed', 'ed.id', '=', 'edu.edu_degree_id')
                    ->leftJoin('mst_edu_division as edv', 'edv.id', '=', 'edu.division_id')
                    ->leftJoin('mst_year as my', 'edu.passed_year_bs', '=', 'my.id')
                    ->leftJoin('mst_edu_level as mel', 'edu.edu_level_id', '=', 'mel.id')
                    ->leftJoin('mst_university as mu', 'edu.university', '=', 'mu.id')
                    ->where([['edu.applicant_id', $applicant->applicant_id], ['edu.is_deleted', false]])
                    ->orderBy('edu.passed_year_ad', 'desc')
                    ->get(),
                'leave_details' => DB::table('applicant_leave_details as ald')
                    ->leftJoin('mst_leave_type as mlt', 'ald.leave_type_id', '=', 'mlt.id')
                    ->where([['ald.applicant_id', $applicant->applicant_id], ['ald.is_deleted', false]])
                    ->get(['mlt.name_np as leave_type', 'date_from_bs', 'date_to_bs']),
                'training_details' => DB::table('applicant_training_info as ati')
                    ->leftJoin('mst_training as mt', 'ati.training_id', '=', 'mt.id')
                    ->leftJoin('mst_training_major as mtm', 'ati.training_major_id', '=', 'mtm.id')
                    ->where([['ati.applicant_id', $applicant->applicant_id], ['ati.is_deleted', false]])
                    ->get(['training_title', 'institute_name', 'institute_address', 'year_bs', 'duration_period', 'mt.name_np AS training', 'mtm.name_np AS training_major'])
            ];
            $html = View::make('admin.reports.file_promotion_report', $data);
            $filePath = storage_path('app/public/open_report/'.$vacancy_post_id.'/'.$applicant->token_number.'.html');
            File::put($filePath, $html);
            return ['status' => true];
        }
        return ['status' => false];
    }


}