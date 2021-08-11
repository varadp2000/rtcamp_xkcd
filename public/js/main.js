//DOM Elements
const email_submit         = document.getElementById( "email-submit-btn" );
const alert_msg            = document.getElementById( "alert-msg" );
const email                = document.getElementById( "email" );
const email_input          = document.getElementById( "email-input" );
const otp_input            = document.getElementById( "otp-input" );
const otp_submit           = document.getElementById( "otp-submit-btn" );
const otp                  = document.getElementById( "OTP" );
const registration_success = document.getElementById( "register-success" );
const new_user_name        = document.getElementById( "new-user-name" );

//Event Listeners
email_submit.addEventListener(
	"click",
	function () {
		console.log( "Email Submit Button Clicked" );
		if (ValidateEmail( email.value )) {
			showOTPDiv();
			sessionStorage.setItem( "email", email.value );
			alert_msg.innerHTML = "Thank you for your email!";

		} else {
			alert_msg.innerHTML = "Please enter a valid email address!";
		}
	}
)

otp_submit.addEventListener(
	"click",
	function () {
		console.log( "OTP Submit Button Clicked" );
		if (ValidateOTP( otp.value )) {
			showRegisterSuccessDiv();
			new_user_name.innerHTML = sessionStorage.getItem( "email" );
		} else {
			alert_msg.innerHTML = "Please enter a valid OTP!";
		}
	}
)


//Functions
const ValidateEmail = function (email) {
	if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test( email )) {
		return (true)
	}
	return (false)
}

const showOTPDiv = function () {
	email_input.style = "display:none";
	otp_input.style   = "display:block";
}

const ValidateOTP = function (otp) {
	if (otp.length > 0 && otp.length == 6) {
		return (true)
	}
	return (false)
}

const showRegisterSuccessDiv   = () => {
	otp_input.style            = "display:none";
	registration_success.style = "display:block";
}