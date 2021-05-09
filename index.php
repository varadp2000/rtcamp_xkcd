<?php
$title = "Welcome to Comic Newsletter";
include './includes/header.php';
?>

<div class="main-div center-box">
    <div>
        <h1 style="color:white">Get XKCD Comics in your Email</h1>
        <div class="d-flex">
            <input name="email" id="email" type="email" class="form-control" placeholder="Email" style="height:40px;margin-right:10px" /><br />
            <button class="btn btn-dark" id="subscribeBtn" type="submit">Subscribe</button>
        </div>
        <div class="feedback-wrapper">
            <span id="feedbackDiv"></span>
        </div>
        <p style="color:white;text-align:left">Don't worry, we don't share your information with anyone</p>
    </div>
</div>

<?php
include './includes/footer.php'

?>