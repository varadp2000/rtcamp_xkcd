<?php
require('../includes/db.php');

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        
        $sql = "SELECT * FROM subscribers WHERE email = '$email' AND is_activated = '0'";
        $result = $conn->query($sql);
        if($result->num_rows ==  1){
            $OTP = mt_rand(100000, 999999);

            $Subject = "Your OTP for Comic Newsletter Subscription";
            $Body = "

                <p >Hello Subscriber</p>
                Please use this OTP to activate your account
                <h3>$OTP</h3>
                <br />
                To activate account manually head to <a href='http://" . $_SERVER['SERVER_NAME'] . "/rtcamp_xkcd/confirm.php?email=$email'>Here</a>
                ";

            try {
                
                $URL = md5($email);
                $sql = "UPDATE subscribers SET is_activated = 0, OTP = $OTP, unsubscribe_URL = '$URL' WHERE email = '$email'";
                $result = $conn->query($sql);
                if (mysqli_error($conn)) {
                    echo mysqli_error($conn);
                }
                sendMail($email, $Body, $Subject, []);
            } catch (Exception $e) {
                echo $e;
            }
            echo "
            <script>
                window.location.replace('http://localhost/rtcamp_xkcd/confirm.php?email=$email');
            </script>
            ";
            return;
        }


        $sql = "SELECT * FROM subscribers WHERE email = '$email' AND is_activated = '1'";
        $result = $conn->query($sql);
        if($result->num_rows == 0){
            $OTP = mt_rand(100000, 999999);
            http_response_code(200);
            $OTP = mt_rand(100000, 999999);
            $Subject = "Your OTP for Comic Newsletter Subscription";
            $Body = "

                <p >Hello Subscriber</p>
                Please use this OTP to activate your account
                <h3>$OTP</h3>
                <br />
                To activate account manually head to <a href='http://" . $_SERVER['SERVER_NAME'] . "/rtcamp_xkcd/confirm.php?email=$email'>Here</a>
                ";
            try{
                $unsubscribe_URL = md5($email);
                $sql = "INSERT INTO subscribers (email, is_activated, OTP, unsubscribe_URL) VALUES ('$email', 0, $OTP, '$unsubscribe_URL')";
                $result = $conn->query($sql);
                if(mysqli_error($conn)){
                    echo mysqli_error($conn);
                }
                sendMail($email, $Body, $Subject, []);
            }catch(Exception $e){
                echo $e;
            }
            echo "
            <script>
                window.location.replace('http://localhost/rtcamp_xkcd/confirm.php?email=$email');
            </script>
            ";
                
        }
        else{
            http_response_code(412);
            echo $email . ' is Already Registered';
        }
        
    } else {
        http_response_code(412);
        // Do something else or just leave it as is
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
?>