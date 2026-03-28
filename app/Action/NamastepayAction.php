<?php

namespace App\Action;

use App\Models\NamastepayWebCredential;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class NamastepayAction
{
    public function generateToken()
    {
        $credentials = NamastepayWebCredential::with('mst_payment_method:id,name_en')->first();
        Session::put('namastePayCredentials', $credentials);
        $identifierValue = $credentials->namastepay_identifierValue;
        $authKey = $credentials->namastepay_authenticationValue;
        #generrate Token

        $params = [
            'bearerCode' => 'WEB',
            'language' => 'en',
            'workspaceId' => 'BUSINESS',
            'identifierType' => 'MSISDN',
            'identifierValue' => $identifierValue,
            'authenticationValue' => $authKey,
            'isTokenRequired' => 'Y',
            'deviceInfo' => [
                'appName' => 'Namaste NT-HR Checkout Pay',
                'appVersion' => 10.2,
                'deviceId' => 'bc1qugrtknpjz52vc4m559q7zumkc4268kp7skrsee',
                'browser' => '',
                'isPublicDevice' => 'N',
                'latitude' => '',
                'longitude' => '',
                'mac' => '',
                'model' => '',
                'networkOperator' => '',
                'networkType' => '',
                'os' => '',
                'providerIpAddress' => '',
            ],
        ];
        $url = $credentials->namastepay_tokenGenerationUrl;
        return Http::withHeaders(['Accept' => 'application/json'])->post($url, $params);
    }

    public function generateOtp($request)
    {
        $SenderIdValue = $request->name;
        $credentials = Session::get('namastePayCredentials');
        $identifierValue = $credentials->namastepay_identifierValue;
        $url = $credentials->namastepay_otpGenerationUrl;
        $paymentData = Session::get('payment_data');
        $token = $paymentData['token'];
        $credentials = NamastepayAction::generateToken();
        $response = $credentials->json();
        $access_token = $response['token']['access_token'];
        Session::put('access_token', $access_token);
        $amt = $paymentData['amt'];
        $productId = $paymentData['transactionid'];
        $params = [
            "serviceFlowId" => "MERCHPAYOAP",
            "initiator" => "receiver",
            "currency" => "101",
            "bearerCode" => "USSD",
            "language" => "en",
            "requestedBy" => "US.47771617785088690",
            "isFinancial" => true,
            "externalReferenceId" => $productId,
            "remarks" => "NTC payment",
            "transactionMode" => "",
            "requestedServiceCode" => "",
            "productOwnerCode" => "",
            "productBrand" => "",
            "productCategory" => "",
            "USSDPUSHREQ" => "",
            "callBackUrl" => "",
            "callBackUrlReq" => "",
            "partnerData" => (object) [],
            "receiver" => [
                "idType" => "mobileNumber",
                "idValue" => $identifierValue,
                "productId" => "12",
                "userRole" => "Channel",
            ],
            "sender" => [
                "paymentInstruments" => [[
                    "amount" => $amt,
                    "instrumentType" => "WALLET",
                    "productId" => "12",
                ]],
                "idType" => "mobileNumber",
                "idValue" => $SenderIdValue,
                "userRole" => "CUSTOMER",
            ],
            "deviceInfo" => [
                "appVersion" => "2.6.0",
                "deviceId" => "b42184c9-f8b3-4459-9459-b154e994a85c",
                "model" => "motorola motorola one action",
                "os" => "ANDROID",
            ],
        ];
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $access_token,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->post($url, $params);

        if ($response->successful()) {
            return $response->json();
        }
        return false;
    }

    public function validateOtp($request)
    {
        $credentials = Session::get('namastePayCredentials');
        $url = $credentials->namastepay_validateOtpUrl;
        $otp = $request->otp;
        $serviceRequestId = $request->serviceRequestId;
        $access_token = Session::get('access_token');
        $params = ["resumeServiceRequestId" => $serviceRequestId, "transactionStatus" => "true", "otp" => $otp];
        $response = Http::withHeaders(['Authorization' => 'Bearer ' . $access_token, 'Content-Type' => 'application/json'])->post($url, $params);
        if ($response->successful()) {
            return $response->json();
        }
        return false;
    }

    public function resendOtp($id)
    {
        $credentials = Session::get('namastePayCredentials');
        $url = $credentials->namastepay_resendOtpUrl;
        $access_token = Session::get('access_token');
        $params = ["resumeServiceRequestId" => $id];
        $response = Http::withHeaders(['Authorization' => 'Bearer ' . $access_token, 'Content-Type' => 'application/json'])->post($url, $params);
        if ($response->successful()) {
            return $response->json();
        }
        return false;

    }
    public function inquiry($request)
    {
        $credentials = NamastepayAction::generateToken();
        $response = $credentials->json();
        $access_token = $response['token']['access_token'];
        $data = Session::get('namastePayCredentials');
        $identifierValue = $data->namastepay_identifierValue;
        $externalReferenceId = $request->transactionId;
        $identifierType = 'MSISDN';
        $workspaceId = 'BUSINESS';
        $url = $data->namastepay_transactionDetailsUrl;
        $full_url = $url . '/' . $externalReferenceId . '?identifierType=' . $identifierType . '&identifierValue=' . $identifierValue . '&workspaceId=' . $workspaceId;
        $response = Http::withToken($access_token)->withHeaders(['Accept' => 'application/json', 'Content-Type' => 'application/json'])
            ->get($full_url);
        if ($response->successful()) {
            return $response->json();
        }
        return false;
    }
}
