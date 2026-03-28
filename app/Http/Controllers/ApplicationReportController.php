<?php

namespace App\Http\Controllers;


use DB;
use Session;
use Request;
use CRUDBooster;

class ApplicationReportController extends BaseCBController
{
    public function AllApplications(Request $request)
    {
        $results = DB::table('vw_vacancy_applicant')
        ->select(DB::raw('count(1) as cnt,ad_no,designation_en as post'))
        ->groupBy('ad_no', 'designation_en')
        ->get();

        $total = DB::table('vw_vacancy_applicant')
        ->select(DB::raw('count(1) as tot'))
        ->get();
        return view('reports.total_applications', ["results" => $results,"total" => $total]);
    }
}
