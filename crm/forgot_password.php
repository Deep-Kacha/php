<?php
session_start();
include_once "database.php";
include_once "assets/functions.php";


date_default_timezone_set('Asia/Kolkata');
$current_time = date("Y-m-d H:i:s");
$delete_query = "DELETE FROM password_token WHERE expires_at < '$current_time'";
$con->query($delete_query);
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

        .forgot-password-container {
            min-height: calc(100vh - 200px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 0;
        }

        .forgot-password-card {
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
    </script>
</head>
<body>
    <div class="forgot-password-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="forgot-password-card">
                        <div class="icon-container">
                            <i class="fas fa-lock lock-icon"></i>
                        </div>
                        <h2 class="form-title">Forgot Password?</h2>
                        <p class="form-text">
                            Enter your email address below and we'll send you instructions to reset your password.
                        </p>

                        <form id="forgotPasswordForm" action="forgot_password.php" method="post">
                            <div class="mb-4">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email address" required>
                                <div class="error" id="emailError"></div>
                            </div>
                            <button type="submit" name="submit"class="submit-btn">
                                Send Reset Instructions
                            </button>
                        </form>
                        
                        <a href="login.php" class="back-link">
                            <i class="fas fa-arrow-left me-2"></i>
                            Back to Login
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<?php

if (isset($_POST['submit'])) {
    $email = $_POST['email'];

    $select_q = "SELECT * FROM `users` WHERE `email`='$email'";
    $res = $con->query($select_q);
    if($res->num_rows == 1){
        $query = "SELECT * FROM `password_token` WHERE `email` = '$email'";
        $result = mysqli_fetch_assoc($con->query($query));
        $otp = rand(100000, 999999);
        $body = "<html>
            <head>
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                    .container { max-width: 600px; margin: 0 auto; padding: 20px; background-color: #f9f9f9; border: 1px solid #ddd; border-radius: 5px; }
                    h1 { color: black; }
                    .otp { font-size: 24px; font-weight: bold; color:  #dc3545; }
                    .footer { margin-top: 20px; font-size: 0.8em; color: #777; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <h1>Forgot Your Password?</h1>
                    <p>We received a request to reset your password. Here is your One-Time Password (OTP):</p>
                    <p class='otp'>$otp</p>
                    <p>Please enter this OTP on the website to proceed with resetting your password.</p>
                    <p>If you did not request a password reset, please ignore this email.</p>
                    <div class='footer'>
                        <p>This is an automated message, please do not reply to this email.</p>
                    </div>
                </div>
            </body>
            </html>
            ";

        $subject = "Password Reset - OTP";
        $email_time = date("Y-m-d H:i:s");
        $expiry_time = date("Y-m-d H:i:s", strtotime('+1 minutes'));
        if ($result) {
            $attempts = $result['otp_attempts'];
            if ($attempts >= 3) {
                // Email exists, display error message and redirect to OTP form
                alert('error', "The maximum limit for generating OTP is reached you can generate a new OTP after 24 hours from the last OTP generated time.");
                redirect('login.php');
            } else {
                $q = "UPDATE `password_token` SET `otp`=$otp, `otp_attempts`=$attempts+1, `last_resend`=now(), `created_at` = '$email_time', `expires_at`='$expiry_time' WHERE `email`='$email'";
            }
        } else {
            $attempts = 0;
            $q = "INSERT INTO `password_token`  (`email`, `otp`, `created_at`,`expires_at`,`otp_attempts`,`last_resend`) VALUES ('$email', '$otp', '$email_time','$expiry_time',$attempts,now())";
        }
        if (sendEmail($email, $subject, $body, "")) {
            if ($con->query($q)) {
                $_SESSION['forgot_email'] = $email;
                alert('success', 'OTP sent to registered email address. the OTP will expire in 2 Minutes.');
                redirect('otp_form.php');  
            } else {
                alert('error', 'Failed to generate OTP and store it in the database');
            }
        } else {
            alert('error', 'Failed to send the OTP in mail. Please try after sometime.');
        }
    }else{
        alert('error', 'Email is not registrated');
    }
}
?>