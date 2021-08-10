<?php
require "./includes/db.php";

if (!isset($_POST['auth']) || $_POST['auth'] != 'admincansendmail') {
    http_response_code(400);
    echo "Error";
}
if ($_POST['auth'] == 'admincansendmail') {
    http_response_code(200);
    echo("Success");
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



    $sql = "SELECT email, subscriber_name, unsubscribe_URL FROM subscribers WHERE is_activated = 1";
    $result = $conn->query($sql);


    $file = file_get_contents($response->img);
    $encoded_file = chunk_split(base64_encode($file));


    $attachments[] = array(
        'name' => 'image.jpg', // Set File Name
        'data' => $encoded_file, // File Data
        'type' => 'application/pdf', // Type
        'encoding' => 'base64' // Content-Transfer-Encoding
    );


    while ($email = $result->fetch_row()) {
        $Body = "
        <p >Hello Subscriber</p>
        Here is your Comic for the day
        <h3>$response->title</h3>
        <img src='$response->img' />
        <br />
        To read the comic head to <a target='_blank' href='https://xkcd.com/' . $XKCD_ID'>Here</a><br />
        To unsubscribe kindly visit <a href='http://" . $_SERVER['SERVER_NAME'] . "/rtcamp_xkcd/unsubscribe.php?url=$email[2]'>here.</a>
        ";
        $subject = "Hello " . $email[1] . ", Here is your new comic";
        sendMail($email[0], $Body, $subject, $attachments);
    }
}


function sendMail(
    $email = "",
    $text = "",
    $subject = "",
    $attachments = array()
) {
    if (!$email || !$text) {
        return false;
    }

    $headers   = array();
    $headers[] = "To: {$email}";
    $headers[] = "From: Team Comic <comics@varad.com>";
    $headers[] = "Reply-To: CAPS Consortium <contact@capsconsortium.com>";
    $headers[] = "Subject: {$subject}";
    $headers[] = "X-Mailer: PHP/" . phpversion();

    $headers[] = "MIME-Version: 1.0";

    if (!empty($attachments)) {
        $boundary = md5(time());
        $headers[] = "Content-type: multipart/mixed;boundary=\"" . $boundary . "\"";
        // Have attachment, different content type and boundary required.
    } else {
        $headers[] = "Content-type: text/html; charset=UTF-8";
    }

    $html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
            <title>CAPS Consortium</title>
            <style>table { border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; }</style>
        </head>
        <body style="font-family: arial;" width="100%">
            [text]
        </body>
    </html>';
    $generated = date('jS M Y H:i:s');
    $subject = ($subject ? $subject : 'Default Subject');
    $message = $html;

    $message = str_replace("[text]", $text, $message);

    if (!empty($attachments)) {
        $output   = array();
        $output[] = "--" . $boundary;
        $output[] = "Content-type: text/html; charset=\"utf-8\"";
        $output[] = "Content-Transfer-Encoding: 8bit";
        $output[] = "";
        $output[] = $message;
        $output[] = "";
        foreach ($attachments as $attachment) {
            $output[] = "--" . $boundary;
            $output[] = "Content-Type: " . $attachment['type'] . "; name=\"" . $attachment['name'] . "\";";
            if (isset($attachment['encoding'])) {
                $output[] = "Content-Transfer-Encoding: " . $attachment['encoding'];
            }
            $output[] = "Content-Disposition: attachment;";
            $output[] = "";
            $output[] = $attachment['data'];
            $output[] = "";
        }
        return mail($email, $subject, implode("\r\n", $output), implode("\r\n", $headers));
    } else {
        return mail($email, $subject, $message, implode("\r\n", $headers));
    }
}


function getComicID()
{
    return rand(1, 2460);
}
