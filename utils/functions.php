<?php

function genetateOTP () {
	return random_int( 100000, 999999 );
}

function returnResponse( $msg) {
	echo json_encode( $msg );
}

function sendMail( $to, $subject, $message ) {
	$headers = 'From: team@xkcd_mailer.com' . "\r\n";

	mail( $to, $subject, $message, $headers );
}