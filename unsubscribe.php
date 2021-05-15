<?php

require('./includes/db.php');
$title = "Unsubscribe";
include './includes/header.php';

if(!$_GET){
    ?>
    <script>
    window.location.replace('/rtcamp_xkcd');
    </script>
    <?php
}

$url =  $_GET['url'];
$sql = "SELECT subscriber_name from subscribers WHERE unsubscribe_URL = '$url';";
$result = $conn->query($sql);
$sql = "UPDATE subscribers SET is_activated = 0 WHERE unsubscribe_URL = '$url' ";
if ($result->num_rows == 0 || !$conn->query($sql)) {
?>
    <link rel="stylesheet" href="./assets/styles/checkmark.css" />

    <div class="main-div center-box" style="background:black">
        <div>
            <h1 style="color:white">Woaps, Something went Wrong</h1>
            <svg class="crossmark addClass" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                <circle class="crossmark__circle addClass" cx="26" cy="26" r="25" fill="none" />
                <path class="cross__path cross__path--right addClass" fill="none" d="M16,16 l20,20" />
                <path class="cross__path cross__path--left addClass" fill="none" d="M16,36 l20,-20" />
            </svg>
            <h5 style="color:white;text-align:left">
                Failed to Unsubscribe. Please check your email <br />And try again
            </h5>
        </div>
    </div>
<?php
} else{
    while($row = $result->fetch_row()){
        $uname = $row[0];
    }
?>
<link rel="stylesheet" href="./assets/styles/checkmark.css" />

<div class="main-div center-box" style="background:black">
    <div>
        <h1 style="color:white">Successfully Unsubscribed</h1>
        <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
            <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none" />
            <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8" />
        </svg>
        <h5 style="color:white;text-align:left">
            Dear <?php echo $uname ?>
            <br />
            You have been successfully unsubscribed from Comic Newsletter.<br /> Head to <a href="index.php">here</a> to Subscribe again for newsletter.
        </h5>
    </div>
</div>

<?php
}
include './includes/footer.php';
?>