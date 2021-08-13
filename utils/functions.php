<?php

function genetateOTP () {
	return random_int( 100000, 999999 );
}

function returnResponse( $msg) {
	echo json_encode( $msg );
}

function sendComic( $to, $subject, $message, $attachments = array() ) {
	$headers   = array();
	$headers[] = "To: {$to}";
	$headers[] = 'From: Team Comic <comics@varad.com>';
	$headers[] = 'Reply-To: Varad Patil <varadpatil@gmail.com>';
	$headers[] = 'X-Mailer: PHP/' . phpversion();

	$headers[] = 'MIME-Version: 1.0';

	if ( ! empty( $attachments )) {
		$boundary  = md5( time() );
		$headers[] = 'Content-type: multipart/mixed;boundary="' . $boundary . '"';
	} else {
		$headers[] = 'Content-type: text/html; charset=UTF-8';
	}
		$output   = array();
		$output[] = '--' . $boundary;
		$output[] = 'Content-type: text/html; charset="utf-8"';
		$output[] = 'Content-Transfer-Encoding: 8bit';
		$output[] = '';
		$output[] = $message;
		$output[] = '';
	foreach ($attachments as $attachment) {
		$output[] = '--' . $boundary;
		$output[] = 'Content-Type: ' . $attachment['type'] . '; name="' . $attachment['name'] . '";';
		if (isset( $attachment['encoding'] )) {
			$output[] = 'Content-Transfer-Encoding: ' . $attachment['encoding'];
		}
		$output[] = 'Content-Disposition: attachment;';
		$output[] = '';
		$output[] = $attachment['data'];
		$output[] = '';
	}
		mail( $to, $subject, implode( "\r\n", $output ), implode( "\r\n", $headers ) );
}

function sendMail( $to, $subject, $message ) {
	$headers  = 'From: team@xkcd_mailer.com' . "\r\n";
	$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

	mail( $to, $subject, $message, $headers );
}

function getComicFromXKCD() {
	$url = 'https://c.xkcd.com/random/comic/';
	try {
		$head       = get_headers( $url );
		$comic_link = $head[7];
		preg_match( '/[0-9]+/', $comic_link, $matches );
		$rand_comic = $matches[0];
	} catch (\Throwable$th) {
		print($th->getMessage());
	}

	$url    = 'https://xkcd.com/' . $rand_comic . '/info.0.json';
	$result = json_decode( file_get_contents( $url ), true );
	return $result;
}