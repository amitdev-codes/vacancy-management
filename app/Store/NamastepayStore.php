<?php

namespace App\Store;

use App\Models\WebPaymentLog;
use Illuminate\Support\Facades\Session;

class NamastepayStore
{
    public function create($request)
    {

        try {
            $inquiryId = Session::get('inqid');
            $webData = WebPaymentLog::find($inquiryId);
            $webData->namastepay_generated_token = $request['token']['access_token'];
            $webData->namastepay_serviceRequestId = $request['serviceRequestId'];
            $webData->save();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        return true;
    }

}