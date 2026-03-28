<?php

/*  
	  ini_set('display_errors', true);
	  error_reporting(E_ALL); 
	 */

require_once('lib/nusoap.php');
$error  = '';
$result = array();
$response = '';
// $wsdl = "http://vaars-soap.test/webservice-server.php?wsdl";
$wsdl = "http://192.168.116.113:8081/webservice-server.php?wsdl";
if (isset($_POST['sub'])) {
	$token_number = trim($_POST['token_number']);
	if (!$token_number) {
		$error = 'token_number cannot be left blank.';
	}

	if (!$error) {

		//create client object
		$client = new nusoap_client($wsdl, true);
		$err = $client->getError();
		if ($err) {
			echo '<h2>Constructor error</h2>' . $err;
			// At this point, you know the call that follows will fail
			exit();
		}
		try {
			$result = $client->call('fetchExamineeData', array($token_number));
			$result = json_decode($result);
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
	}
}

/* Add new payment **/
if (isset($_POST['addbtn'])) {
	$paid_receipt_no = trim($_POST['paid_receipt_no']);
	$total_paid_amount = trim($_POST['total_paid_amount']);
	$token_number = trim($_POST['token_number']);
	$is_paid = 1;
	//Perform all required validations here
	if (!$paid_receipt_no || !$total_paid_amount || !$token_number) {
		$error = 'All fields are required.';
	}

	if (!$error) {

		//create client object
		$client = new nusoap_client($wsdl, true);
		$err = $client->getError();
		if ($err) {
			echo '<h2>Constructor error</h2>' . $err;
			// At this point, you know the call that follows will fail
			exit();
		}
		try {

			/** Call make payment method */
			$response =  $client->call('makePayment', array($total_paid_amount, $is_paid, $paid_receipt_no, $token_number));
			$response = json_decode($response);
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
	}
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Examinee Web Service</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>

	<div class="container">
		<h2>Examinee SOAP Web Service</h2>
		<p>Enter <strong>token_number</strong> of examinee and click <strong>Fetch Examinee Information</strong> button.</p>
		<br />
		<div class='row'>
			<form class="form-inline" method='post' name='form1'>
				<?php if ($error) { ?>
					<div class="alert alert-danger fade in">
						<a href="#" class="close" data-dismiss="alert">&times;</a>
						<strong>Error!</strong>&nbsp;<?php echo $error; ?>
					</div>
				<?php } ?>
				<div class="form-group">
					<label for="email">Token Number :</label>
					<input type="text" class="form-control" name="token_number" id="token_number" placeholder="Enter token number" required>
				</div>
				<button type="submit" name='sub' class="btn btn-default">Fetch Examinee Information</button>
			</form>
		</div>
		<br />
		<h2>Examinee Information</h2>
		<table class="table">
			<thead>
				<tr>
					<th>Token</th>
					<th>Name</th>
					<th>Mobile No.</th>
					<th>Applied Group</th>
					<th>Designation</th>
					<th>Total Amount</th>
					<th>Paid Amount</th>
					<th>Receipt No.</th>
					<th>Paid</th>
				</tr>
			</thead>
			<tbody>
				<?php if ($result) { ?>

					<tr>
						<td><?php echo $result->token_number; ?></td>
						<td><?php echo $result->name_en; ?></td>
						<td><?php echo $result->mobile_no; ?></td>
						<td><?php echo $result->applied_group; ?></td>
						<td><?php echo $result->designation_en; ?></td>
						<td><?php echo $result->total_amount; ?></td>
						<td><?php echo $result->total_paid_amount; ?></td>
						<td><?php echo $result->paid_receipt_no; ?></td>
						<td><?php echo $result->paid; ?></td>
					</tr>
				<?php
				} else { ?>
					<tr>
						<td colspan='5'>Insert Correct Token Number</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
		<div class='row'>
			<h2>Make Payment</h2>
			<?php if (isset($$response->status)) {

				if ($response->status == 200) { ?>
					<div class="alert alert-success fade in">
						<a href="#" class="close" data-dismiss="alert">&times;</a>
						<strong>Success!</strong>&nbsp; Payment successful.
					</div>
				<?php } elseif (isset($response) && $response->status != 200) { ?>
					<div class="alert alert-danger fade in">
						<a href="#" class="close" data-dismiss="alert">&times;</a>
						<strong>Error!</strong>&nbsp; Please try again.
					</div>
			<?php }
			}
			?>
			<form class="form-inline" method='post' name='form1'>
				<?php if ($error) { ?>
					<div class="alert alert-danger fade in">
						<a href="#" class="close" data-dismiss="alert">&times;</a>
						<strong>Error!</strong>&nbsp;<?php echo $error; ?>
					</div>
				<?php } ?>
				<div class="form-group">
					<label for="email"></label>
					<input type="text" class="form-control" name="paid_receipt_no" id="paid_receipt_no" placeholder="Receipt No." required>
					<input type="text" class="form-control" name="token_number" id="token_number" placeholder="Token No." required>
					<input type="text" class="form-control" name="total_paid_amount" id="total_paid_amount" placeholder="Paid Amount" required>
				</div>
				<button type="submit" name='addbtn' class="btn btn-default">Pay Now</button>
			</form>
		</div>
	</div>

</body>

</html>
