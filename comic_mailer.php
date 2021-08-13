<?php
require_once './utils/functions.php';
require_once './includes/db.php';
$secret = '';
if ( ! isset( $_POST['secret'] )) {
	die( 'Token Not FOund' );
} else {
	$secret = $_POST['secret'];
}
if (strlen( $secret ) !== getenv( 'HTTP_SECRET_LEN' ) && $secret !== getenv( 'HTTP_CRON_SECRET' )) {
	die( 'Invalid TOken' );
}
$SERVER_NAME = isset( $_SERVER['SERVER_NAME'] ) ? $_SERVER['SERVER_NAME'] : '';
$stmt        = $con->prepare( 'SELECT email FROM `subscribers` WHERE is_activated = 1' );
$stmt->execute();
$mailtoarr = array();
$stmt->store_result();
$stmt->bind_result( $mail );
if ($stmt->num_rows > 0) {
	$comic = getComicFromXKCD();
	$title = 'Your New Comic' . $comic['safe_title'];

	$file         = file_get_contents( $comic['img'] );
	$encoded_file = chunk_split( base64_encode( $file ) );   //Embed image in base64 to send with email

	$attachments[] = array(
		'name'     => $comic['title'] . '.jpg',
		'data'     => $encoded_file,
		'type'     => 'application/pdf',
		'encoding' => 'base64',
	);

	while ($stmt->fetch()) {
		$Body = '
        <p >Hello Subscriber</p>
        Here is your Comic for the day
        <h3>' . $comic['safe_title'] . "</h3>
        <img src='" . $comic['img'] . "' alt='some comic hehe'/>
        <br />
        To read the comic head to <a target='_blank' href='https://xkcd.com/" . $comic['num'] . "'>Here</a><br />
        To unsubscribe kindly visit <a href='http://" . $SERVER_NAME . '/unsubscribe.php?email=' . $mail . '&id=' . md5( $mail ) . "'>here.</a>
        ";
		sendComic( $mail, $title, $Body, $attachments );
	}
	echo 'Sent Successfully';
}