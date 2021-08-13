<?php
$page_title = 'Unsubscribe';
require_once './includes/navbar.php';


if ( ! isset( $_GET['email'] ) && ! isset( $_GET['id'] )) {
	header( 'Location: /404.php' );
}

$email = $_GET['email'];
$id    = $_GET['id'];

if ( ! filter_var( $email, FILTER_VALIDATE_EMAIL ) && strlen( $id ) !== 32 ) {
	header( 'Location: /404.php' );
}
try {
	$stmt = $con->prepare( 'SELECT email, email_hash FROM `subscribers` WHERE email = ? AND email_hash = ? ' );
	$stmt->bind_param( 'ss', $email, $id );
	$stmt->execute();
	$stmt->bind_result( $db_email, $email_hash );
	$stmt->fetch();
	$stmt->close();
} catch (\Throwable $th) {
	echo $th->getMessage();
	header( 'Location: /404.php' );
}
if ( $email !== $db_email || $email_hash !== $id ) {
	header( 'Location: /404.php' );
} else {
	try {
		$stmt = $con->prepare( 'UPDATE `subscribers` SET is_activated = 0 WHERE email = ?' );
		$stmt->bind_param( 's', $email );
		$stmt->execute();
	} catch (\Throwable $th) {
		echo $th->getMessage();
		header( 'Location: /404.php' );
	}



	?>
<div class="main-div center-div">
	<div style="height:30vh">
		<h1 style="color:white">Successfully Unsubscribed</h1>
		<svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
			<circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none" />
			<path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8" />
		</svg>
		<h5 style="color:white;text-align:left">
		Dear <?php echo $email; ?>
		<br />
			You have been successfully unsubscribed from Comic Newsletter.<br /> Head to <a href="index.php">here</a> to Subscribe again for newsletter.
		</h5>
	</div>
</div>
	<?php
}

require_once './includes/footer.php';

