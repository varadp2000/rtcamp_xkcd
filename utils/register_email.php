<?php
require_once './functions.php';
require_once '../includes/db.php';
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
		$stmt = $con->prepare( 'SELECT is_activated FROM `subscribers` WHERE email=?' );
		$stmt->bind_param( 's', $email );
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result( $is_activated );
		$stmt->fetch();
		$numRows = $stmt->num_rows;
		if ($is_activated === 1) {
			http_response_code( 201 );
			returnResponse( 'Already Registered, please try different email address' );
			exit();
		}
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
		$SERVER_NAME = isset( $_SERVER['SERVER_NAME'] ) ? $_SERVER['SERVER_NAME'] : '';
		$mail_text   = "<h1>Welcome to XKCD Comic Mailer.</h1>\nYour OTP for email validation is $OTP.\nEnjoy!\n or";
		$mail_text  .= "click <a href='http://" . $SERVER_NAME . '/subscribe.php?email=' . $email . '&otp=' . md5( $OTP ) . "'>here.</a>";

		$mail_subject = 'XKCD Comic Mailer - OTP';
		sendMail( $email, $mail_subject, $mail_text, '' );
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