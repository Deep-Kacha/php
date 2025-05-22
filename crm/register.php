<?php
include 'database.php';
include("assets/functions.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Cooking Recipes</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js\jquery-3.7.1.min.js"></script>
    <script src="js\jquery.validate.js"></script>
    <script src="js\additional-methods.js"></script>
    <script src="js\bundle.min.js"></script> 

    <style>
        .custom-alert {
            position: fixed;
            top: 25px;
            right: 25px;
        }

        .error {
            color: red;
        }

        body {
            color: #333333;
            background-color: #f5f5f5 !important;
            font-weight: 400;
        }

        .auth-container {
            min-height: calc(100vh - 200px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 0;
        }

        .auth-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 40px;
            max-width: 500px;
            width: 100%;
        }

        .form-title {
            color: #eb4a36;
            margin-bottom: 30px;
            text-align: center;
        }

        .form-control {
            border: 2px solid #ddd;
            border-radius: 25px;
            padding: 12px 20px;
            margin-bottom: 20px;
        }

        .form-control:focus {
            border-color: #eb4a36;
            box-shadow: 0 0 0 0.2rem rgba(47, 130, 12, 0.25);
        }

        .themed-label {
            color:rgba(172, 45, 28, 0.77);
            font-weight: 600;
            margin-bottom: 8px;
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
            background-color: #d03a2e;
        }

        .auth-link {
            color: #eb4a36;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .auth-link:hover {
            color: #d03a2e;
        }

        .social-login {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }

        .social-btn {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border-radius: 25px;
            border: 2px solid #ddd;
            background: white;
            transition: all 0.3s ease;
        }

        .social-btn:hover {
            background: #f8f9fa;
            border-color: #eb4a36;
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #666;
        }
    </style>
    <script>
        $(document).ready(function() {
            $("#registerForm").validate({
                rules: {
                    firstName: {
                        required: true,
                        pattern: /^[A-Za-z]+$/,
                        minlength: 2,
                        maxlength: 15,
                    },
                    lastName: {
                        required: true,
                        pattern: /^[A-Za-z]+$/,
                        minlength: 2,
                        maxlength: 15,
                    },
                    email: {
                        required: true,
                        email: true,
                    },
                    registerPassword: {
                        required: true,
                        minlength: 8,
                        maxlength: 20,
                        pattern: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%#*?&])[A-Za-z\d@$!%*?#&]{8,20}$/,
                    },
                    confirmPassword: {
                        required: true,
                        equalTo: "#registerPassword",
                    }
                },
                messages: {
                    firstName: {
                        required: "Please enter your Firstname",
                        pattern: "Name can only contain letters.",
                        minlength: "It must contain atleast 2 character.",
                        maxlength: "It must contain maximum 15 character.",
                    },
                    lastName: {
                        required: "Please enter your Lastname",
                        pattern: "Name can only contain letters.",
                        minlength: "It must contain atleast 2 character.",
                        maxlength: "It must contain maximum 15 character.",
                    },
                    email: {
                        required: "Please enter your email",
                        email: "Please enter valid email",
                    },
                    registerPassword: {
                        required: "Please enter your password",
                        minlength: "It must contain atleast 8 character.",
                        maxlength: "It must contain maximum 20 character.",
                        pattern: "It must include @,$,!,%,*,?,#,&.",
                    },
                    confirmPassword: {
                        required: "Please confirm your password",
                        equalTo: "Password doesn't match",
                    }
                },
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
                        if (response == 'true') {
                            $('#emailError').text('Email already registered.').show();
                            $('#email').addClass('is-invalid');
                            $('#email').removeClass('is-valid');
                            $('#emailError').addClass('text-danger');
                            $('#emailError').removeClass('text-success');
                        } else {
                            $('#emailError').text('This email is available').show();
                            $('#email').removeClass('is-invalid');
                            $('#email').addClass('is-valid');
                            $('#emailError').addClass('text-success');
                            $('#emailError').removeClass('text-danger');
                        }
                    }
                });
            });
        });
    </script>
</head>

<body>
    <div class="auth-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="auth-card">
                        <h2 class="form-title">Create Your Account</h2>

                        <form id="registerForm" method="post" action="register.php">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="firstName" class="form-label themed-label">First Name</label>
                                    <input type="text" class="form-control" id="firstName" name="firstName" placeholder="First Name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="lastName" class="form-label themed-label">Last Name</label>
                                    <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Last Name" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label themed-label">Email Address</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="Email Address" required>
                                <div class="error" id="emailError"></div>
                            </div>
                            <div class="mb-3">
                                <label for="registerPassword" class="form-label themed-label">Password</label>
                                <input type="password" class="form-control" id="registerPassword" name="registerPassword" placeholder="Password" required>
                            </div>
                            <div class="mb-3">
                                <label for="confirmPassword" class="form-label themed-label">Confirm Password</label>
                                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" required>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="terms" required>
                                <label class="form-check-label" for="terms">
                                    I agree to the <a href="#" class="auth-link">Terms of Service</a> and
                                    <a href="#" class="auth-link">Privacy Policy</a>
                                </label>
                            </div>
                            <button type="submit" name="register" class="submit-btn mb-3">Create Account</button>
                            <p class="text-center">
                                Already have an account?
                                <a href="login.php" class="auth-link">Login</a>
                            </p>
                        </form>

                        <div class="social-login">
                            <p class="text-center mb-3">Or sign up with</p>
                            <button class="social-btn mb-2">
                                <i class="fab fa-google me-2"></i> Continue with Google
                            </button>
                            <button class="social-btn">
                                <i class="fab fa-facebook-f me-2"></i> Continue with Facebook
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>


<?php

if (isset($_POST['register'])) {
    $fname = $_POST['firstName'];
    $lname = $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['registerPassword'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    if (empty($fname) || empty($lname) || empty($email) || empty($password)) {
        alert('error', 'All fields are required');
    }else{
        $token = md5(uniqid(rand(), true));

        $check_email = "SELECT `email` FROM `users` WHERE `email`='$email' LIMIT 1";
        $check_email_run = $con->query($check_email);

        if ($check_email_run->num_rows > 0) {
            alert('error', 'Email Id already exists');
        } else {
            $register_query = "INSERT INTO `users`(`first_name`, `last_name`, `email`, `password`, `verification_token`) VALUES ('$fname','$lname','$email','$hashed_password','$token')";

            if ($con->query($register_query)) {
                $link = 'http://localhost/crm/verify_email.php?email=' . $email . '&token=' . $token;
                $body = "<div style='background-color: #f8f9fa; padding: 20px; border-radius: 5px;'>
                            <h2 style='color: #dc3545; text-align: center;'>Account Verification</h2>
                            <p style='text-align: center;'>Click on the button below to verify your account</p>
                            <a href='" . $link . "' style='display: block; width: 200px; margin: 0 auto; text-align: center; background-color: #dc3545; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Verify Account</a>
                        </div>";
                $subject = "Account Verification Mail";

                if (sendEmail($email, $subject, $body, "")) {
                    alert('success', 'Registration Successfull. Account verification link has been sent to your email. Verify your email to login.');
                    // setcookie('success', 'Registration Successfull. Account verification link has been sent to your email. Verify your email to login.', time() + 5);
                } else {
                    alert('error', 'Failed to send the registration link');
                    // setcookie('error', 'Failed to send the registration link', time() + 5);
                }
            } else {
                alert('error', 'Registration falied');
            }
        }

        // redirect('index.php');
        // alert('success', 'Registration Successfully! Please verify your email');
    }

}
?>