$(document).ready(function () {
    $('#subscribeBtn').on('click', function (e) {
        var $input = $('#email');
        action($input);
    });

    $('#OTPBtn').on('click', function (e) {
        var $input = $('#otp');
        validateOTP($input);
    });

    $('#nameBtn').on('click', function (e) {
        var $input = $('#fullName');
        saveName($input);
    });

    function saveName(passData) {
        let params = new URLSearchParams(location.search);
        let email = params.get('email');
        var $input = passData
            , value = $input.val()
            , data = {
                name: value,
                email
            };
        if (!value) {
            $('#feedbackDiv').css('color', 'red').html("Please Enter Your Name");
        } else {
            $.ajax({
                method: 'POST',
                url: 'libs/savename.php',
                data: data,
                success: function (returnData) {
                    $('#feedbackDiv').css('color', 'green').html(returnData);
                    setTimeout(function () { window.location.href = 'registration_success.php'; }, 1000);
                },
                error: function (xhr, status, error) {
                    $('#feedbackDiv').css('color', 'red').html("Woaps, Something Went Wrong");
                },
                dataType: 'text'
            });
        }
    }

    function validateOTP(passData) {
        let params = new URLSearchParams(location.search);
        let email = params.get('email');
        console.log(email);
        var $input = passData
            , value = $input.val()
            , data = {
                otp: value,
                email
            };
        if (!value || value.length != 6) {

            $('#feedbackDiv').css('color', 'red').html("Please Enter Valid OTP");
        } else {
            $.ajax({
                method: 'POST',
                url: 'libs/validateOTP.php',
                data: data,
                success: function (returnData) {
                    document.cookie = "step=2"
                    $('#feedbackDiv').css('color', 'green').html(returnData);
                    setTimeout(function () { location.reload(); }, 1000);
                },
                error: function (xhr, status, error) {
                    $('#feedbackDiv').css('color', 'red').html("OTP Missmatch");
                },
                dataType: 'text'
            });
        }
    }

    function action(passData) {

        var $input = passData
            , value = $input.val()
            , data = {
                email: value
            };

        // if empty alert message would disappear
        if (value != "") {
            // Pre validate email on client side to reduce the server lookup
            if (validateEmailOnClientSide(value)) {
                $.ajax({
                    method: 'POST',
                    url: 'libs/subscribe.php',
                    data: data,
                    // if server return valid email then we get Green text
                    success: function (returnData) {
                        $('#feedbackDiv').css('color', 'green').html(returnData);
                        //disableBtn(true);
                    },
                    // if server return invalid email then we get Red text
                    error: function (xhr, status, error) {
                        $('#feedbackDiv').css('color', 'red').html("Already Registered");
                        //disableBtn(false);
                    },
                    dataType: 'text'
                });
            } else {
                // Red text from browser side
                $('#feedbackDiv').css('color', 'red').html("Enter a valid email");
                //disableBtn(false);
            }
        } else {
            // Emptying text
            $('#feedbackDiv').html("");
            //disableBtn(false);
        }

    }

    function validateEmailOnClientSide(email) {
        var re = /\S+@\S+\.\S+/;
        return re.test(email);
    }

    function disableBtn(btnID, boolean) {
        $(`#${btnID}`).attr("disabled", boolean);
    }

    var $post = $(".addClass");
    $post.toggleClass("animateElement");
    setInterval(function () {
        $post.removeClass("animateElement");
        setTimeout(function () {
            $post.addClass("animateElement");
        }, 1000);
    }, 4000);

});