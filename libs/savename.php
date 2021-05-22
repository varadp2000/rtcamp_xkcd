<?php
require '../includes/db.php';

if (!isset($_POST['email']) || $isset($_POST['name'])) {
    echo "
            <script>
                window.location.replace('http://localhost/rtcamp_xkcd/confirm.php?email=$email');
            </script>
            ";
    return;
}

$email = $_POST['email'];
$name = $_POST['name'];

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(426);
    echo 'Enter Valid Email';
}

if (strlen($name) > 10) {
    http_response_code(426);
    echo 'Enter Valid Name';
}

$SQL = "SELECT email FROM subscribers WHERE email = '$email' AND is_activated = 1";
$result = $conn->query($SQL);
if ($result->num_rows == 1) {
    http_response_code(426);
    echo 'You Have Already Registered';
    return;
}


$sql = "UPDATE subscribers SET subscriber_name = '$name', is_activated = 1, OTP = NULL WHERE email = '$email' ";

if (!$conn->query($sql)) {
    echo $sql;
    echo mysqli_error($conn);
    http_response_code(426);
    echo 'Woaps! Something went wrong. Please Try again';
    return;
} else {
    http_response_code(200);
    echo "Registration Success";
}
