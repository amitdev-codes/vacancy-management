<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class ValidationController extends Controller
{
    public function checkvalidage(Request $request)
    {
        $dob = $request['dob_bs'];
        $dob_bs = explode('-', $dob);
        $year = $dob_bs[0];
        $month = $dob_bs[1];
        $day = $dob_bs[2];

        $date = app('App\Helpers\Helper')->get_eng_date($year, $month, $day);
        $year_ad = $date['y'];
        $month_ad = $date['m'];
        $day_ad = $date['d'];

        $todays_date = Carbon::now();
        $current_date = $todays_date->toDateString();
        $date_upto = explode('-', $current_date);
        $year_to = $date_upto[0];
        $month_to = $date_upto[1];
        $day_to = $date_upto[2];

        $date_from = Carbon::createFromDate($year_ad, $month_ad, $day_ad);
        $date_to = Carbon::createFromDate($year_to, $month_to, $day_to);

        $age = $date_from->diff($date_to)->format('%y');
        if ($age >= 16) {
            return ['success' => true, 'message' => 'Age is valid !!'];
        } else {
            return ['success' => false, 'message' => 'Age is invalid !!'];
        }

    }
}
