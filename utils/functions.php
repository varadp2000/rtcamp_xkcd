<?php

require_once '../includes/db.php';

function genetateOTP () {
	return random_int( 100000, 999999 );
}

function returnResponse( $msg) {
	echo json_encode( $msg );
}