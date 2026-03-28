<?php

namespace App\Http\Controllers;

use CRUDBooster;
use DB;
use view;
use Session;

class CsrController extends BaseCBController
{
    
    public function getIndex() {
        //First, Add an auth
         if(!CRUDBooster::isView()) CRUDBooster::redirect(CRUDBooster::adminPath(),trans('crudbooster.denied_access'));
         
        //Create your own query 
        //  $data = [];
        //  $data['page_title'] = 'CSR Payments';
        
        $fiscal_year_id = Session::get('fiscal_year_id');
        
        $result = DB::table('vw_csr_payments')->where('fiscal_year_id', '=',  $fiscal_year_id)->get();

        // $result = DB::select('select * from vw_csr_payments where YEAR(applied_date_ad) = YEAR(CURDATE())');

         $total = DB::select("select sum(total_amount) as total_collection from vw_csr_payments where fiscal_year_id = $fiscal_year_id");

         //Create a view. Please use `view` method instead of view method from laravel.
         return view('csr.view', compact('result','total'));

      }
      
}
