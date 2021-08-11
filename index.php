<?php
$page_title = "Welcome to XKCD Comic Mailer, Let's Get Started";
require_once __DIR__ . '\includes\navbar.php';
?>
<div class="main-div center-div">
	<div id="email-input">
		<!--- Take email as input -->
		<span class="label">Email:</span>
		<input type="email" name="email" id="email" placeholder="Enter your email">

		<!--- Verify Email Button -->
		<button class="submit-btn" id="email-submit-btn" type="submit" name="verify">Verify Email</button>
	</div>
	<div id="otp-input">
		<!--- Take email as input -->
		<span class="label">OTP:</span>
		<input type="number" name="OTP" id="OTP" placeholder="Enter your OTP">
		<!--- Verify Email Button -->
		<button class="submit-btn" id="otp-submit-btn" type="submit" name="verify">Verify OTP</button>

	</div>
	<div id="register-success">
		<h1 style="color:white">Successfully Subscribed</h1>
		<svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
			<circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none" />
			<path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8" />
		</svg>
		<h5 style="color:white;text-align:left">
			Dear <span id="new-user-name"></span>,
			<br />
			Welcome to the XKCD Comic Mailer. You have successfully subscribed. <br />
			Expect your first email to be sent in a few minutes. <br />
			Enjoy the comics!
		</h5>
	</div>
	<h4 id="alert-msg"></h4>
</div>
<?php
require_once __DIR__ . '\includes\footer.php';
?>