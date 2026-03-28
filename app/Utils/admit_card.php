<?php
namespace App\Utils;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;

class admit_card extends AdmitCardContentBase
{
    public $template_name ="admit_card/content/admit_card";
    function __construct()
    {
        $this->filename = "admit_card.html";
    }

    public function LoadData($params)
    {

        $sql = "SELECT
	vp.ad_no,
	concat( ap.first_name_en, ' ', COALESCE ( ap.mid_name_np, '' ), ' ', ap.last_name_en ) AS applicant_name,
	ap.photo,
	d.name_en AS designation,
	ap.signature_upload AS signature_sample,
	wl.name_en AS work_level,
	ws.name_en AS work_service,
	sg.name_en AS service_group,
	ssg.name_en AS service_sub_group,
	ve.exam_date_bs,
	ve.exam_roll_no,
	ve.exam_center,
	va.is_open,
	va.is_female,
	va.is_janajati,
	va.is_dalit,
	va.is_madhesi,
	va.is_handicapped,
	va.is_remote_village
FROM
	vacancy_exam AS ve
	LEFT JOIN vacancy_apply va ON va.id = ve.applicant_id
	LEFT JOIN vacancy_post vp ON vp.id = ve.vacancy_post_id
	LEFT JOIN applicant_profile ap ON ap.id = ve.applicant_id
	LEFT JOIN mst_designation d ON d.id = ve.designation_id
	LEFT JOIN mst_work_level wl ON wl.id = d.work_level_id
	LEFT JOIN mst_work_service ws ON ws.id = d.work_service_id
	LEFT JOIN mst_work_service_group sg ON sg.id = ap.service_group_id
	LEFT JOIN mst_work_service_sub_group ssg ON ssg.id = ap.service_sub_group_id

ORDER BY
	exam_roll_no
                ";

        $query = DB::select(DB::raw($sql));

        $arr = array("result"=>$query);

        return $arr;
    }
}
