<?php
require_once './utils/functions.php';
require_once './includes/db.php';
if ( ! isset( $_POST['secret'] )) {
	header( 'Location: /php-varadp2000/404.php' );
	die( 'no secret' );
}
$stmt = $con->prepare( 'SELECT email FROM `subscribers` WHERE is_activated = 1' );
$stmt->execute();
$mailtoarr = array();
$stmt->store_result();
$stmt->bind_result( $mail );
if ($stmt->num_rows > 0) {
	while ($stmt->fetch()) {
		echo $mail;
	}
}
