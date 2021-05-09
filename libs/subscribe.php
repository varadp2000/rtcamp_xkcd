<?php
include '../includes/db.php';
require_once "../vendor/autoload.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


if (isset($_POST['email'])) {
    $email = $_POST['email'];
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        
        $sql = "SELECT * FROM subscribers WHERE email = '$email' AND is_activated = '0'";
        $result = $conn->query($sql);
        if($result->num_rows ==  1){
            $OTP = mt_rand(100000, 999999);


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
            $mail->Subject = "Your OTP for Comic Newsletter Subscription";
            $mail->Body = "

                <p >Hello Subscriber</p>
                Please use this OTP to activate your account
                <h3>$OTP</h3>
                <br />
                To activate account manually head to <a href='http://" . $_SERVER['SERVER_NAME'] . "/rtcamp_xkcd/confirm.php?email=$email'>Here</a>
                ";

            $mail->AddAddress($email);



            try {
                
                $URL = md5($email);
                $sql = "UPDATE subscribers SET is_activated = 0, OTP = $OTP, unsubscribe_URL = '$URL' WHERE email = '$email'";
                $result = $conn->query($sql);
                if (mysqli_error($conn)) {
                    echo mysqli_error($conn);
                }
                $mail->send();
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
            $mail->Subject = "Your OTP for Comic Newsletter Subscription";
            $mail->Body = "

                <p >Hello Subscriber</p>
                Please use this OTP to activate your account
                <h3>$OTP</h3>
                <br />
                To activate account manually head to <a href='http://" . $_SERVER['SERVER_NAME'] . "/rtcamp_xkcd/confirm.php?email=$email'>Here</a>
                ";

            $mail->AddAddress($email);
            try{
                $unsubscribe_URL = md5($email);
                $sql = "INSERT INTO subscribers (email, is_activated, OTP, unsubscribe_URL) VALUES ('$email', 0, $OTP, '$unsubscribe_URL')";
                $result = $conn->query($sql);
                if(mysqli_error($conn)){
                    echo mysqli_error($conn);
                }
                $mail->send();
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
?>