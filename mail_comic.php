<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once "vendor/autoload.php";
require "./includes/db.php";


function getComicID()
{
    return rand(1, 2460);
}

$curl = curl_init();
$XKCD_ID = getComicID();
$XKCD_URL = 'https://xkcd.com/' . $XKCD_ID . '/info.0.json';
curl_setopt_array($curl, array(
    CURLOPT_URL => $XKCD_URL,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
));

$response = curl_exec($curl);
$response = json_decode($response);
curl_close($curl);
echo json_encode($response) . ".\n";



$mail = new PHPMailer(true);
$mail->isSMTP();
$mail->Host = 'smtp.mailtrap.io';
$mail->SMTPAuth = true;
$mail->Port = 2525;
$mail->Username = 'c2848f14bdeffa';
$mail->Password = '8ab109b4c9792c';

$mail->From = "teamcomicprovider@var-ad.tech";
$mail->FromName = "Team Provider";
$mail->isHTML(true);

$mail->Body = "

<p >Hello Subscriber</p>
Here is your Comic for the day
<h3>$response->title</h3>
<img src='$response->img' />
<br />
To read the comic head to <a target='_blank' href='https://xkcd.com/' . $XKCD_ID'>Here</a>
";

$sql = "SELECT email, subscriber_name, unsubscribe_URL FROM subscribers WHERE is_activated = 1";
$result = $conn->query($sql);
$mail->addStringAttachment(file_get_contents($response->img), 'Comic.png');
while ($email = $result->fetch_row()) {
    $mail->AddAddress($email[0]);
    $mail->Subject = "Hello ".$email[1].", Here is your new comic";

    $mail->Body = "
        <p >Hello Subscriber</p>
        Here is your Comic for the day
        <h3>$response->title</h3>
        <img src='$response->img' />
        <br />
        To read the comic head to <a target='_blank' href='https://xkcd.com/' . $XKCD_ID'>Here</a><br />
        To unsubscribe kindly visit <a href='http://" . $_SERVER['SERVER_NAME'] ."/rtcamp_xkcd/unsubscribe.php?url=$email[2]'>here.</a>
        ";
    try {
        $mail->send();
        echo "Message has been sent successfully";
    } catch (Exception $e) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    }
    $mail->ClearAllRecipients();
}

?>