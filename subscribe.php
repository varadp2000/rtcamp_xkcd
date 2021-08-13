<?php
$page_title = 'Unsubscribe';
require_once './includes/navbar.php';


if ( ! isset( $_GET['email'] ) && ! isset( $_GET['otp'] )) {
	echo 'Param Not Set';
	header( 'Location: /404.php' );
}

$email = $_GET['email'];
$otp   = $_GET['otp'];

if ( ! filter_var( $email, FILTER_VALIDATE_EMAIL ) && strlen( $otp ) !== 32 ) {
	echo 'Invalid Params';
	header( 'Location: /404.php' );
}
try {
	$stmt = $con->prepare( 'SELECT email, otp FROM `subscribers` WHERE email = ? ' );
	$stmt->bind_param( 's', $email );
	$stmt->execute();
	$stmt->bind_result( $db_email, $db_otp );
	$stmt->fetch();
	$stmt->close();
	$otp_hash = md5( $db_otp );
} catch (\Throwable $th) {
	echo $th->getMessage();
	header( 'Location: /404.php' );
}
if ( $email !== $db_email || $otp !== $otp_hash ) {
	echo 'Credentials Missmatch';
	header( 'Location: /404.php' );
} else {
	try {
		$stmt = $con->prepare( 'UPDATE `subscribers` SET is_activated = 1 WHERE email = ?' );
		$stmt->bind_param( 's', $email );
		$stmt->execute();
	} catch (\Throwable $th) {
		echo $th->getMessage();
		header( 'Location: /404.php' );
	}



	?>
<div class="main-div center-div">
	<div style="height:30vh">
		<h1 style="color:white">Successfully Subscribed</h1>
		<svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
			<circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none" />
			<path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8" />
		</svg>
		<h5 style="color:white;text-align:left">
		Dear <?php echo $email; ?>
		<br />
			You have successfully subscribed<br /> Your first comic will reach to you shortly.
		</h5>
	</div>
</div>
	<?php
}

require_once './includes/footer.php';

