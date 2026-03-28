<?php

namespace App\Helpers;

use App\Helpers\GsmEncoder;
// use SMPP;
// use SmppAddress;
use App\Helpers\SmppClient;
use App\Helpers\SocketTransport;

	// require_once 'smppclient.class.php';
	// require_once 'gsmencoder.class.php';
	// require_once 'sockettransport.class.php';

class SMShelper {

 public static function sendsms($mobile,$message){

 	// Construct transport and client
	$transport = new SocketTransport(array('10.26.140.160'),5016);
	$transport->setRecvTimeout(60000);
	$smpp = new SmppClient($transport);
	
	// Open the connection
	$transport->open();
	// $smpp->bindTransmitter("Test420","PASSWORD");
	$smpp->bindTransmitter("NTvacancy","NepTel11");
	
	// Prepare message
	// $message = 'Hello World €$£';
	$encodedMessage = GsmEncoder::utf8_to_gsm0338($message);
	// $from = new SmppAddress('977420');
	$from = new SmppAddress('NT_Vacancy',SMPP::TON_ALPHANUMERIC);
	$to = new SmppAddress($mobile,SMPP::TON_INTERNATIONAL,SMPP::NPI_E164);
	
	// Send
	$messageID = $smpp->sendSMS($from,$to,$encodedMessage,$tags);

	// dd($messageID);
	
	// Close connection
	$smpp->close();
 }
	
	
}