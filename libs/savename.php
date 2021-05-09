<?php
require '../includes/db.php';

$email = $_POST['email'];
$name = $_POST['name'];

$SQL = "SELECT email FROM subscribers WHERE email = '$email' AND is_activated = 1";
$result = $conn->query($SQL);
if($result->num_rows == 1){
    http_response_code(426);
    echo 'You Have Already Registered';
    return;
}


$sql = "UPDATE subscribers SET subscriber_name = '$name', is_activated = 1, OTP = NULL WHERE email = '$email' ";

if(!$conn->query($sql)){
    echo $sql;
    echo mysqli_error($conn);
    http_response_code(426);
    echo 'Woaps! Something went wrong. Please Try again';
    return;
}
else{
    http_response_code(200);
    echo "Registration Success";
}
