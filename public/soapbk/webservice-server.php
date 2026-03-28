<?php

/**
  @Description: examinee Information Server Side Web Service:
  This Sctript creates a web service using NuSOAP php library.
  fetchExamineeData function accepts token_number and sends back examinee information.
  @Author:  http://programmerblog.net/
  @Website: http://programmerblog.net/
 */
require_once('dbconn.php');
require_once('lib/nusoap.php');
$server = new nusoap_server();

/* Method to insert a new payment */
function makePayment($token_number,$paid_receipt_no,$total_paid_amount, $is_paid)
{
  global $dbconn;

  // Check id already paid
  $sqlSelect = "select is_paid from vacancy_apply where token_number= :token and total_paid_amount >= total_amount";
  $stmt = $dbconn->prepare($sqlSelect);
  $stmt->bindParam(":token", $token_number, PDO::PARAM_INT);
  $stmt->execute();
  $data = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($data) {
    return json_encode(array('status' => 400, 'msg' => 'paid'));
  } else {
    // Update a record
    $sql = "UPDATE vacancy_apply SET total_paid_amount= :tpa,is_paid= :ispaid, paid_receipt_no= :receipt_no WHERE token_number= :token";
    $stmt = $dbconn->prepare($sql);
    $stmt->bindParam(":tpa", $total_paid_amount, PDO::PARAM_INT);
    $stmt->bindParam(":ispaid", $is_paid, PDO::PARAM_INT);
    $stmt->bindParam(":receipt_no", $paid_receipt_no, PDO::PARAM_STR);
    $stmt->bindParam(":token", $token_number, PDO::PARAM_STR);
    $result = $stmt->execute();
    if ($result) {
      // echo "Updated {$stmt->affected_rows} rows";
      return json_encode(array('status' => 200, 'msg' => 'success'));
    } else {
      // echo "FAILURE!!! " . $stmt->error;
      return json_encode(array('status' => 400, 'msg' => 'fail'));
    }
  }
  $dbconn = null;
}

/* Fetch 1 examinee data */
function fetchExamineeData($token_number)
{
  global $dbconn;
  $sql = "SELECT token_number, upper(name_en) as name_en, mobile_no, applied_group, designation_en, ad_no, total_amount, total_paid_amount, paid_receipt_no, upper(paid) as paid
  FROM vw_vacancy_applicant
  WHERE token_number = :token_number";
  // prepare sql and bind parameters
  $stmt = $dbconn->prepare($sql);
  $stmt->bindParam(':token_number', $token_number);
  // insert a row
  $stmt->execute();
  $data = $stmt->fetch(PDO::FETCH_ASSOC);

  return json_encode($data);
  $dbconn = null;
}
$server->configureWSDL('examineeServer', 'urn:examinee');
$server->register(
  'fetchExamineeData',
  array('token_number' => 'xsd:string'),  //parameter
  array('data' => 'xsd:string'),  //output
  'urn:examinee',   //namespace
  'urn:examinee#fetchExamineeData' //soapaction
);
$server->register(
  'makePayment',
  array('token_number' => 'xsd:string', 'paid_receipt_no'=>'xsd:string','total_paid_amount' => 'xsd:string', 'is_paid' => 'xsd:string'),  //parameter
  array('data' => 'xsd:string'),  //output
  'urn:examinee',   //namespace
  'urn:examinee#fetchExamineeData' //soapaction
);
$server->service(file_get_contents("php://input"));
