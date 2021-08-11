<?php
require_once './functions.php';

$data  = file_get_contents( 'php://input' );
$data  = json_decode( $data, true );
$email = $data['email'];
if ( ! filter_var( $email, FILTER_VALIDATE_EMAIL )) {
	http_response_code( 400 );
	returnResponse( 'Enter Valid Email' );
	exit();
}

$OTP = genetateOTP();
if ( $con ) {
	try {
		$stmt = $con->prepare( 'SELECT * FROM `subscribers` WHERE email=?' );
		$stmt->bind_param( 's', $email );
		$stmt->execute();
		$stmt->store_result();
		$numRows = $stmt->num_rows;
		if ($numRows === 0) {
			$email_hash = md5( $email );
			$stmt       = $con->prepare( 'INSERT INTO `subscribers` (`email`, `otp`, `email_hash`) VALUES (?, ?, ?)' );
			$stmt->bind_param( 'sis', $email, $OTP, $email_hash );
			$stmt->execute();
		} else {
			$stmt = $con->prepare( 'UPDATE `subscribers` SET `otp`=? WHERE `email`=?' );
			$stmt->bind_param( 'is', $OTP, $email );
			$stmt->execute();
		}
		http_response_code( 200 );
		returnResponse( 'Check your inbox for OTP' );
		exit();
	} catch (\Throwable $th) {
		echo $th;
		http_response_code( 500 );
		returnResponse( 'Something went wrong' );
		exit();
	}
}