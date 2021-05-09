<?php
require '../includes/db.php';

$email = $_POST['email'];
$otp = $_POST['otp'];
$sql = "SELECT otp FROM subscribers WHERE email = '$email' ";
$result = $conn->query($sql);

if($result->num_rows >2 || $result->num_rows < 1){
    http_response_code(426);
    echo 'Woaps! Something went wrong. Please Try again';
    return;
}
$dbOTP;
while ($row = $result->fetch_array()) {
    $dbOTP = $row[0];
}
if($otp == $dbOTP){
    http_response_code(200);
    echo "OTP Validation Success, Please Wait";
}else {
    http_response_code(400);
}

?>