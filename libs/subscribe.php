<?php
include '../includes/db.php';

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        
        $sql = "SELECT * FROM subscribers WHERE email = '$email' AND is_activated = '0'";
        $result = $conn->query($sql);
        if($result->num_rows ==  1){
            try {
                $OTP = mt_rand(100000, 999999);
                $URL = md5($email);
                $sql = "UPDATE subscribers SET is_activated = 0, OTP = $OTP, unsubscribe_URL = '$URL' WHERE email = '$email'";
                $result = $conn->query($sql);
                if (mysqli_error($conn)) {
                    echo mysqli_error($conn);
                }
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
            http_response_code(200);
            try{
                $OTP = mt_rand(100000, 999999);
                $unsubscribe_URL = md5($email);
                $sql = "INSERT INTO subscribers (email, is_activated, OTP, unsubscribe_URL) VALUES ('$email', 0, $OTP, '$unsubscribe_URL')";
                $result = $conn->query($sql);
                if(mysqli_error($conn)){
                    echo mysqli_error($conn);
                }
            }catch(Exception $e){
                echo $e;
            }
            // echo "
            // <script>
            //     window.location.replace('http://localhost/rtcamp_xkcd/confirm.php?email=$email');
            // </script>
            // ";
                
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