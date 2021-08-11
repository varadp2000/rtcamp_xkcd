<?php

$host = getenv( 'HTTP_DB_HOST' );
$user = getenv( 'HTTP_DB_USER' );
$db   = getenv( 'HTTP_DB_NAME' );

if (getenv( 'HTTP_DB_PASSWORD' )) {
	$pwd = getenv( 'HTTP_DB_PASSWORD' );
} else {
	$pwd = '';
}
$con = new mysqli( $host, $user, $pwd, $db );
if ($con->connect_errno) {
	die( 'Connection failed: ' . $con->connect_error );
}
