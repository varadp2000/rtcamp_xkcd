<?php
require_once './functions.php';
require_once '../includes/db.php';
$data  = file_get_contents( 'php://input' );
$data  = json_decode( $data, true );
$email = $data['email'];
$otp   = $data['otp'];
if ( ! filter_var( $email, FILTER_VALIDATE_EMAIL )) {
	http_response_code( 400 );
	returnResponse( 'Enter Valid Email' );
	exit();
}
if ( $otp < 100000 || $otp > 999999 ) {
	http_response_code( 400 );
	returnResponse( 'Enter Valid OTP' );
	exit();
}
$db_otp = 0;
try {
	//Select the user from the database with email
	$stmt = $con->prepare( 'SELECT otp, is_activated FROM `subscribers` WHERE email = ?' );
	$stmt->bind_param( 's', $email );
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result( $db_otp, $is_activated );
	$stmt->fetch();
	$db_otp  = intval( $db_otp );
	$otp     = intval( $otp );
	$numRows = $stmt->num_rows;
	if ( $numRows === 0) {
		http_response_code( 404 );
		returnResponse( 'User Not Found' );
		exit();
	} elseif ($is_activated === 1) {
		http_response_code( 401 );
		returnResponse( 'Already Registered' );
		exit();
	} else {
		if ($db_otp !== $otp) {
			http_response_code( 400 );
			returnResponse( 'Invalid OTP' );
			exit();
		} else {
			//set subscriber as activated in db
			$stmt = $con->prepare( 'UPDATE `subscribers` SET is_activated = 1 WHERE email = ?' );
			$stmt->bind_param( 's', $email );
			$stmt->execute();
			$stmt->close();
			http_response_code( 200 );
			returnResponse( 'Registration Success' );
			exit();
		}
	};
} catch (\Throwable $th) {
	echo $th;
	http_response_code( 500 );
	returnResponse( 'Internal Server Error' );
	exit();
}