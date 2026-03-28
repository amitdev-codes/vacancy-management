<?php
namespace App\Utils\VaarsReport;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;

class applicant_count extends VaarsReportContentBase
{
    public $template_name ="report/VaarsReportContent/applicant_count";
    function __construct()
    {
        $this->filename = "applicant_count.html";
    }
    public function LoadData($params)
    {
        $results = DB::table('vw_vacancy_applicant')
        ->select(DB::raw('count(1) as cnt,ad_no,designation_en as post'))
        ->groupBy('ad_no', 'designation_en')
        ->get();

        $total = DB::table('vw_vacancy_applicant')
        ->select(DB::raw('count(1) as tot'))
        ->get();

        $arr = array("results"=>$results,"total"=>$total);
       
        return $arr;
    }
} 