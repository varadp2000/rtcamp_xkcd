<?php
$title = "Successfully Registered";
require './includes/header.php' ;
?>

<link rel="stylesheet" href="./assets/styles/checkmark.css" />

<div class="main-div center-box" style="background:black">
    <div>
        <h1 style="color:white">Registration Success</h1>
        <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
            <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none" />
            <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8" />
        </svg>
        <h5 style="color:white">
            Thank you so much for registering with us for XKCD Comic Newsletter.ṣ
            <br />
            You will receive next Comic in couple of Moments
        </h5>
    </div>
</div>


<?php
require './includes/footer.php';
?>