
<?php
session_start();
include_once "database.php";
include_once "assets/functions.php";


// date_default_timezone_set('Asia/Kolkata');
// $current_time = date("Y-m-d H:i:s");
// $delete_query = "DELETE FROM password_token WHERE expires_at < '$current_time'";
// $con->query($delete_query);
// $q = "UPDATE password_token 
// SET otp_attempts = 0 
// WHERE TIMESTAMPDIFF(HOUR, last_resend, NOW()) >= 24";
// $con->query($q);
// $remove_otp = "update password_token set otp=NULL WHERE expires_at < '$current_time'";
// $con->query($remove_otp);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Cooking Recipes</title>
    
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

        .reset-password-container {
            min-height: calc(100vh - 200px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 0;
        }

        .reset-password-card {
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
</head>
<body>
<div class="reset-password-container">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="card reset-password-card">
                <div class="card-body p-4">
                    <h2 class="form-title">Reset Password</h2>
                    <p class="text-muted text-center mb-4">Please enter your new password below.</p>

                    <form action="reset_password.php" method="post">
                        <div class="mb-4">
                            <label for="newPassword" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="newPassword" placeholder="Enter new password"
                                data-validation="required strongPassword min max" data-min="8" data-max="25" name="newPassword">
                            <div class="error" id="newPasswordError"></div>
                        </div>

                        <div class="mb-4">
                            <label for="confirmPassword" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm new password"
                                data-validation="required confirmPassword" data-password-id="newPassword" name="confirmPassword">
                            <div class="error" id="confirmPasswordError"></div>
                        </div>

                        <button type="submit" class="btn submit-btn btn-outline-danger w-100 mb-3" name="reset_pwd_btn">Update Password</button>

                        <div class="text-center">
                            <a href="login.php" class="text-danger text-decoration-none">Back to Login</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<?php
if (isset($_POST['reset_pwd_btn'])) {
    if (isset($_SESSION['forgot_email'])) {
        $email = $_SESSION['forgot_email'];
        $password = $_POST['newPassword'];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        

        // Update the user's password in the users table (assuming the table is named 'users')
        $update_query = "UPDATE `users` SET `password`='$hashed_password' WHERE `email` = '$email'";
        if ($con->query( $update_query)) {
            // Delete the token from the password_token table
            $delete_query = "DELETE FROM `password_token` WHERE `email` = '$email'";
            $con->query($delete_query);
            unset($_SESSION['forgot_email']);

            alert('success', 'Password has been reset successfully.');
            redirect( 'index.php');

        } else {
            alert('error', 'Error in resetting Password.');
            redirect( 'forgot_password.php');
        }
    } else {
        alert('error', 'No email found for resetting password.');
        redirect( 'forgot_password.php');

    }
}
?>