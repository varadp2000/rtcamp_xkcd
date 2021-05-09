<?php

include './includes/header.php';

echo "
    <script>
        document.cookie = 'step=1'
    </script>
";

if (!isset($_GET['email'])) {

    echo "
            <script>
                window.location.replace('http://localhost/rtcamp_xkcd/');
            </script>
            ";
}

$email = $_GET['email'];
$sql = "SELECT * FROM subscribers WHERE email = '$email' ";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "
            <script>
                window.location.replace('http://localhost/rtcamp_xkcd/');
            </script>
            ";
}

if ($_COOKIE['step'] == 1) {
?>
    <div>
        <div class="main-div center-box">
            <div>
                <h1 style="color:white">Enter Your OTP</h1>
                <div class="d-flex">
                    <input id="otp" name="otp" type="number" class="form-control" placeholder="OTP" maxlength="6" style="height:40px;margin-right:10px" /><br />
                    <button class="btn btn-dark" id="OTPBtn">Validate</button>
                </div>
                <div class="feedback-wrapper">
                    <span id="feedbackDiv"></span>
                </div>
                <p style="color:white;text-align:left">We need to verify your Email</p>
            </div>
        </div>
    </div>

<?php
} else {
?>
    <div>
        <div class="main-div center-box">
            <div style="width:500px">
                <h1 style="color:white">Please Enter your name</h1>
                <div class="d-flex">
                    <input id="fullName" name="fullname" type="text" class="form-control" placeholder="Enter Name" maxlength="20" style="height:40px;margin-right:10px" /><br />
                    <button class="btn btn-dark" id="nameBtn">Submit</button>
                </div>
                <div class="feedback-wrapper">
                    <span id="feedbackDiv"></span>
                </div>
                <p style="color:white;text-align:left">Thank you for your patience. This is the last step</p>
            </div>
        </div>
    </div>

<?php

}
include './includes/footer.php';
?>