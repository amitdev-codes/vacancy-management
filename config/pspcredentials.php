<?php

return [
    'IpsCredentials' => [
        'APPID' => 'MER-172-APP-1',
        'APPNAME' => 'Dharan Municipality',
        'MERCHANTID' => '172',
        'URL' => 'https://uat.connectips.com:7443/connectipswebgw/loginpage',
        'VerificationURL' => 'https://uat.connectips.com:7443/connectipswebws/api/creditor/validatetxn',
        'TransactionDetailsURL' => 'https://uat.connectips.com:7443/connectipswebws/api/creditor/gettxndetail',
        'Username' => 'MER-172-APP-1',
        'password' => 'Abcd@123',
    ],

    'EsewaCredentials' => [
        'APPID' => '1',
        'APPNAME' => 'Dharan Municipality',
        'SERVICECODE' => 'epay_payment',
        'URL' => 'https://uat.esewa.com.np/epay/main',
        'VerificationURL' => 'https://uat.esewa.com.np/epay/transrec?',
        'TokenVerificationURL' => 'http://billpaytest.f1soft.com.np/shangrila/txn/verification',
        'Authkey' => 'dGVzdDp0ZXN0',
    ],

    'KhaltiCredentials' => [
        'APPID' => '1',
        'APPNAME' => 'Namuna Municipality',
        'URL' => 'https://eb6441d72cbd.ngrok.io/',
        'TokenVerificationURL' => 'https://eb6441d72cbd.ngrok.io/api/hl_order_status/',
        'AuthKey' => 'live_secret_key_5e0bc53006934c29aa6157b62dca3716',

        'WEB_VERIFICATION_URL' => 'https://khalti.com/api/v2/payment/verify/',
        'KHALTI_TEST_SECRET' => 'test_secret_key_dcae6abc1b094b9e9b35d2f4636e692e',
        'KHALTI_TEST_PUBLIC' => 'test_public_key_ab567844519a4a1aa96bc0309235095c',

        'TransactionDetailsURL' => 'https://khalti.com/api/v2/payment/status?',

    ],
    'apiCredentials'=>[
        'name'=>'superAdmin@ntc.net.np',
        'password'=>'NTC@#$938051@'
    ],
];
