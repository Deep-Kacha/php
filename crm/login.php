<?php
session_start();
    include 'database.php'; 
    include("assets/functions.php");

    if((isset($_SESSION['adminLogin']) && $_SESSION['adminLogin'] == true)){
        redirect('admin/adminpanel.php');
    }else if((isset($_SESSION['userLogin']) && $_SESSION['userLogin'] == true)){
        redirect('index.php');
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Cooking Recipes</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="js\jquery-3.7.1.min.js"></script>
    <script src="js\jquery.validate.js"></script>
    <script src="js\additional-methods.js"></script>
    <script src="js\bundle.min.js"></script>
    <style>
        .error {
            color: red;
        }

        body {
            color: #333333;
            background-color: #f5f5f5 !important;
            font-weight: 400;
        }
        
        .themed-label {
            color:rgba(172, 45, 28, 0.77);
            font-weight: 600;
            margin-bottom: 8px;
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

        .custom-alert{
            position: fixed;
            top : 25px;
            right: 25px;
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
            $("#loginForm").validate({
                rules: {
                    email: {
                        required: true,
                        email: true,
                    },
                    pswd: {
                        required: true,
                        minlength: 8,
                        maxlength: 20,
                        pattern: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%#*?&])[A-Za-z\d@$!%*?#&]{8,20}$/
                    }

                },
                messages: {
                    email: {
                        required: "Please enter your email address.",
                        email: "Please enter valid email address."
                    },
                    pswd: {
                        required: "Please enter your password",
                        minlength: "It must contain atleast 8 character.",
                        maxlength: "It must contain maximum 20 character.",
                        pattern: "It must include @,$,!,%,*,?,#,&."
                    }
                }
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
                        <h2 class="form-title">Login to Your Account</h2>

                        <form id="loginForm" method="post" action="login.php">
                            <div class="mb-3">
                                <label for="loginEmail" class="form-label themed-label">Email Address</label>
                                <input type="email" class="form-control" id="loginEmail" placeholder="Email address" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="loginPassword" class="form-label themed-label">Password</label>
                                <input type="password" class="form-control" id="loginPassword" placeholder="Password" name="pswd" required>
                            </div>
                            <div class="mb-3 d-flex justify-content-between">
                                <a href="forgot_password.php" class="auth-link ms-auto">Forgot Password?</a>
                            </div>
                            <div>
                                <button type="submit" name="login" class="submit-btn mb-3">Login</button>
                            </div>
                            <p class="text-center">
                                Don't have an account?
                                <a href="register.php" name="sign_up" class="auth-link">Sign up</a>
                            </p>
                        </form>

                        <div class="social-login">
                            <p class="text-center mb-3">Or login with</p>
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

<!-- Display error message if login fails -->
<?php if (isset($error_message)): ?>
    <p style="color:red;"><?php echo $error_message; ?></p>
<?php endif; ?>

<?php
if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['pswd'];
    $select = "SELECT * FROM `users` WHERE `email` = '$email'";
    $result = $con->query($select);
    if($result->num_rows == 1){
        $row = mysqli_fetch_assoc($result);
        if(password_verify($password, $row['password'])){

            if($row['role'] == 'admin'){
                $_SESSION['adminLogin'] = true;
                $_SESSION['adminID'] = $row['id'];
                $_SESSION['adminEmail'] = $email;

                redirect('admin/dashboard.php');
                alert('success', 'Logged in successfully');

            }else{
                $_SESSION['userLogin'] = true;
                $_SESSION['userID'] = $row['id'];
                $_SESSION['userEmail'] = $email;

                redirect('index.php');
                alert('success', 'Logged in successfully');

    
            }
        }else{
            alert('error', 'Login Failed - Invalid Password!');
        } 
    }else{
       alert('error', 'Login Failed - Invalid Credentials!');
    }

}

?> 