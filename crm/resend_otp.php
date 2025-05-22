<?php

session_start();
include 'database.php';
include 'assets/functions.php';

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


if (isset($_SESSION['forgot_email'])) {
    $email = $_SESSION['forgot_email'];
    echo $email;
    echo "<br>";
    // Fetch OTP attempts and last resend time
    $query = "SELECT otp_attempts, last_resend FROM password_token WHERE email = '$email'";
    $result = $con->query($query);
    $row = mysqli_fetch_assoc($result);
    print_r($row);
    $attempts = $row['otp_attempts'];
    // $lastResend = strtotime($row['last_resend']);

    // // Check time difference (2 minutes = 120 seconds)
    // if (time() - $lastResend < 120) {
    //     echo "<script>alert('Please wait for 2 minutes before resending OTP.'); window.location.href='otp_form.php';</script>";
    //     exit();
    // }

    // Block further resends after 3 attempts
    if ($attempts >= 3) {
        alert('error', "OTP resend limit reached. you can generate a new OTP after 24 hours.");
        redirect('login.php');
        exit();
    }
    $email_time = date("Y-m-d H:i:s");
    $expiry_time = date("Y-m-d H:i:s", strtotime('+1 minutes'));
    // Generate a new OTP
    $new_otp = rand(100000, 999999);
    $updateQuery = "UPDATE password_token SET otp=$new_otp, otp_attempts=$attempts+1, last_resend=now(), created_at='$email_time', expires_at='$expiry_time' WHERE email='$email'";
    if ($con->query($updateQuery)) {
        $to = $email;
        $subject = "Reset password";
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
                <p class='otp'>$new_otp</p>
                <p>Please enter this OTP on the website to proceed with resetting your password.</p>
                <p>If you did not request a password reset, please ignore this email.</p>
                <div class='footer'>
                    <p>This is an automated message, please do not reply to this email.</p>
                </div>
            </div>
        </body>
        </html>
        ";
        if (sendEmail($to, $subject, $body, "")) {
            alert("success", "OTP for reset password is sent successfully");
            redirect("otp_form.php");

        } else {
            alert("error", "Error in sending OTP for reset password");
            redirect("forgot_password.php");
        }
    }


    // Send OTP via email (replace with your mailing function)

    echo "<script>alert('New OTP sent.'); window.location.href='otp_form.php';</script>";
}