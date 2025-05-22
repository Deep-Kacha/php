<?php
session_start();

    include_once "database.php";
    include_once "assets/functions.php";

    date_default_timezone_set('Asia/Kolkata');
    $current_time = date("Y-m-d H:i:s");
    // $delete_query = "DELETE FROM password_token WHERE expires_at < '$current_time'";
    // $con->query($delete_query);
    $q = "UPDATE password_token 
    SET otp_attempts = 0 
    WHERE TIMESTAMPDIFF(HOUR, last_resend, NOW()) >= 24";
    $con->query($q);
    $remove_otp = "update password_token set otp=NULL WHERE expires_at < '$current_time'";
    $con->query($remove_otp);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Cooking Recipes</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="js\jquery-3.7.1.min.js"></script>
    <script src="js\jquery.validate.js"></script>
    <script src="js\additional-methods.js"></script>
    <script src="js\bundle.min.js"></script>
    <style>
        .custom-alert{
            position: fixed !important;
            top : 25px !important;
            right: 25px !important;
        }

        .error{
            color : red;
        } 

        body {
            color: #333333;
            background-color: #f5f5f5 !important;
            font-weight: 400;
        }

        .otp-form-container {
            min-height: calc(100vh - 200px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 0;
        }

        .otp-form-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 40px;
            max-width: 500px;
            width: 100%;
        }

        .form-title {
            color: #333333;
            margin-bottom: 30px;
            text-align: center;
        }

        .form-control {
            border: 2px solid #ddd !important;
            border-radius: 25px !important;
            padding: 12px 20px !important;
            margin-bottom: 20px !important;
        }

        .form-control:focus {
            border-color: red;
            box-shadow: 0 0 0 0.2rem rgba(47, 130, 12, 0.25);
        }

        .submit-btn {
            background-color: #eb4a36;
            color: white;
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
            width: 100%;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .submit-btn:hover {
            background-color:rgb(228, 0, 0);
        }

        .back-link {
            color: #eb4a36;
            text-decoration: none;
            display: block;
            text-align: center;
            margin-top: 20px;
            transition: color 0.3s ease;
        }

        .back-link:hover {
            color:rgb(228, 0, 0);

        }

        .icon-container {
            text-align: center;
            margin-bottom: 30px;
        }

        .lock-icon {
            font-size: 40px;
            color: #eb4a36;
        }

        .alert {
            border-radius: 25px;
            padding: 15px 20px;
            margin-bottom: 20px;
        }

        .form-text {
            color: #666;
            text-align: center;
            margin-bottom: 25px;
        }
    </style>
    <script>
        $(document).ready(function() {
            $('#email').on('blur', function() {
                var email = $(this).val();
                $.ajax({
                    type: 'GET',
                    url: 'check_duplicate_email.php',
                    data: {
                        email1: email
                    },
                    success: function(response) {
                        if (response == 'false') {
                            $('#emailError').text('Email is not registered. Please enter registered email addrerss').show();
                            $('#email').addClass('is-invalid');
                        }
                    }
                });
            });
        });

        $(document).ready(function(){
            $("#forgotPasswordForm").validate({
                rules : {
                    email : {
                        required : true,
                        email : true,
                    },
                },
                messages : {
                    email : {
                        required : "Please enter your email address.",
                        email : "Please enter valid email address."
                    },
                }
            });
        });
    </script>
</head>
<body>
    <div class="otp-form-container">
        <div class="container py-5">
        <div class="row justify-content-center">
            <div class="otp-form-card card otp-card">
                <div class="card-body">
                    <h2 class="text-center mb-4">Enter OTP</h2>
                    <p class="text-muted text-center mb-4">Please enter the verification code sent to your email</p>

                    <form action="otp_form.php" method="post">
                        <div class="d-flex justify-content-center mb-4" name="otp">
                            <input type=" text" class="form-control otp-input" maxlength="1" autofocus oninput="moveToNext(this, 0)" name="otp1">

                            <input type="text" class="form-control otp-input" maxlength="1" oninput="moveToNext(this, 1)" name="otp2">

                            <input type="text" class="form-control otp-input" maxlength="1" oninput="moveToNext(this, 2)" name="otp3">
                            <input type="text" class="form-control otp-input" maxlength="1" oninput="moveToNext(this, 3)" name="otp4">
                            <input type="text" class="form-control otp-input" maxlength="1" oninput="moveToNext(this, 4)" name="otp5">
                            <input type="text" class="form-control otp-input" maxlength="1" oninput="moveToNext(this, 5)" name="otp6">
                        </div>
                        <div class="error" id="otpError"></div>

                        <div id="timer" class="text-danger"></div>
                        <br>
                        <div class="d-flex justify-content-center mb-4" name="otp">
                            <button type="button" id="resend_otp" class="btn w-100" style="display:none; color:#eb4a36;">Resend OTP
                            </button>
                        </div>
                        <script>
                            
                            let timeLeft = 60; // Default timer value
                            const timerDisplay = document.getElementById('timer');
                            const resendButton = document.getElementById('resend_otp');

                            // Function to check if the user is refreshing or coming from another page
                            function isPageRefresh() {
                                return !!sessionStorage.getItem('otpTimer'); // If otpTimer exists, it's a refresh
                            }

                            // If the page is refreshed, use sessionStorage value
                            if (isPageRefresh()) {
                                timeLeft = parseInt(sessionStorage.getItem('otpTimer'), 10);
                            } else {
                                // If the user comes from another page, reset timer
                                sessionStorage.setItem('otpTimer', 60);
                                timeLeft = 60;
                            }

                            function startCountdown() {
                                resendButton.style.display = "none"; // Hide the button initially
                                timerDisplay.innerHTML = `Resend OTP in ${timeLeft} seconds`;

                                const countdown = setInterval(() => {
                                    if (timeLeft <= 0) {
                                        clearInterval(countdown);
                                        timerDisplay.innerHTML = "You can now resend the OTP.";
                                        resendButton.style.display = "inline";
                                        sessionStorage.removeItem('otpTimer'); // Clear sessionStorage after timer ends
                                    } else {
                                        timerDisplay.innerHTML = `Resend OTP in ${timeLeft} seconds`;
                                        timeLeft -= 1;
                                        sessionStorage.setItem('otpTimer', timeLeft); // Update sessionStorage
                                    }
                                }, 1000);
                            }

                            // Start countdown only if the timer is above 0
                            if (timeLeft > 0) {
                                startCountdown();
                            } else {
                                resendButton.style.display = "inline";
                                timerDisplay.innerHTML = "You can now resend the OTP.";
                            }

                            resendButton.onclick = function(event) {
                                event.preventDefault(); // Prevent default form submission
                                sessionStorage.setItem('otpTimer', 60); // Reset timer
                                window.location.href = 'resend_otp.php';
                            };
                        </script>
                        <button type="submit" class="btn submit-btn btn-outline-danger w-100 mb-3" name="otp_btn">Verify OTP</button>
                    </form>


                    <div class="text-center">
                        <a href="login.php" class="text-danger text-decoration-none">Back to Login</a>
                    </div>

                </div>
            </div>
            </div>
        </div>

        <script>
            function moveToNext(input, index) {
                if (input.value.length === input.maxLength) {
                    if (index < 5) {
                        input.parentElement.children[index + 1].focus();
                    }
                }
            }
        </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </div>
</body>
</html>



<?php
if (isset($_POST['otp_btn'])) {
    if(isset($_SESSION['forgot_email'])) {

        $email = $_SESSION['forgot_email'];
        $otp1 = $_POST['otp1'];
        $otp2 = $_POST['otp2'];
        $otp3 = $_POST['otp3'];
        $otp4 = $_POST['otp4'];
        $otp5 = $_POST['otp5'];
        $otp6 = $_POST['otp6'];

        $otp = $otp1 . $otp2 . $otp3 . $otp4 . $otp5 . $otp6;

        // Fetch the OTP from the database for the given email
        $query = "SELECT otp FROM password_token WHERE email = '$email' ";
        $result = $con->query($query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $db_otp = $row['otp'];
            if (!$db_otp) {
                alert('error', 'OTP has expired. Regenerate New OTP');
                redirect('forgot_password.php');
            }
            // Compare the OTPs
            else {
                if ($otp == $db_otp) {
                    // Redirect to new password page
                    redirect('reset_password.php');

                } else {
                    alert('error', 'Incorrect OTP');
                    redirect('otp_form.php');
                }
            }
        } else {
            alert('error', 'OTP has expired. Regenerate New OTP');
            redirect('forgot_password.php');
        }
    }
}
?>