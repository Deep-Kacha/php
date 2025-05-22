<?php include("assets/navbar.php"); 
    $uid = $_SESSION['userID']; 

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password - Let's Cook</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/js/bootstrap.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <script src="js\jquery-3.7.1.min.js"></script>
    <script src="js\jquery.validate.js"></script>
    <script src="js\additional-methods.js"></script>
    <script src="js\bundle.min.js"></script>
    
    <style>
        body {
            color: #333333;
            background-color: #f5f5f5 !important;
            font-weight: 400;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        /* Form styling */
        .form-label {
            font-weight: 500;
        }

        .form-control:focus {
            border-color: #eb4a36;
            box-shadow: 0 0 0 0.25rem rgba(235, 74, 54, 0.25);
        }

        .form-section {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 25px;
            margin-bottom: 25px;
        }

        .form-section h4 {
            color: #333;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        /* Buttons styling */
        .btn-primary {
            background-color: #eb4a36;
            border-color: #eb4a36;
        }

        .btn-primary:hover {
            background-color: #d43b28;
            border-color: #d43b28;
        }

        .btn-outline-primary {
            color: #eb4a36;
            border-color: #eb4a36;
        }

        .btn-outline-primary:hover {
            background-color: #eb4a36;
            color: white;
        }

        .forgot-password {
            color: #eb4a36;
            text-decoration: none;
        }

        .forgot-password:hover {
            text-decoration: underline;
            color: #d43b28;
        }

        .error {
            color: #eb4a36;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
    </style>
    
    <script>
        $(document).ready(function() {
            $("#passwordForm").validate({
                rules: {
                    current_password: {
                        required: true
                    },
                    new_password: {
                        required: true,
                        minlength: 8,
                        maxlength: 20,
                        pattern: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%#*?&])[A-Za-z\d@$!%*?#&]{8,20}$/
                    },
                    confirm_password: {
                        required: true,
                        equalTo: "#new_password"
                    }
                },
                messages: {
                    current_password: {
                        required: "Please enter your current password"
                    },
                    new_password: {
                        required: "Please enter your new password",
                        minlength: "Password must contain at least 8 characters",
                        maxlength: "Password cannot exceed 20 characters",
                        pattern: "Password must include at least one uppercase letter, one lowercase letter, one number, and one special character (@,$,!,%,*,?,#,&)"
                    },
                    confirm_password: {
                        required: "Please confirm your new password",
                        equalTo: "Passwords don't match with new password"
                    }
                },
                errorElement: "div",
                errorClass: "error"
            });
        });
    </script>
</head>

<body>
    <div class="container my-5">
        <div class="row">
            <div class="col-12 mb-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="profile.php">My Profile</a></li>
                        <li class="breadcrumb-item"><a href="edit_profile.php">Edit Profile</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Change Password</li>
                    </ol>
                </nav>
                <h2 class="mb-0">Change Your Password</h2>
                <p class="text-muted">Update your password for enhanced security</p>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="form-section">
                    <h4>Password Settings</h4>
                    
                    <form id="passwordForm" action="change_password.php" method="POST">
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input type="password" class="form-control" id="current_password" name="current_password">
                        </div>
                        
                        <div class="mb-3">
                            <label for="new_password" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="new_password" name="new_password">
                            <div class="form-text">
                                Password must be 8-20 characters and include at least one uppercase letter, 
                                one lowercase letter, one number, and one special character (@,$,!,%,*,?,#,&)
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                        </div>
                        
                        <div class="mb-3 text-end">
                            <a href="forgot_password.php" class="forgot-password">Forgot your password?</a>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="edit_profile.php" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Back to Profile
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-key me-1"></i> Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include_once "assets/footer.php"; ?>
</body>
</html>

<?php

if(isset($_POST['confirm_password'])){
    $crt_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];

    $select_query = "SELECT `password` FROM `users` WHERE `id`= $uid";
    $result = $con->query($select_query);
    $row = mysqli_fetch_assoc($result);


    if(password_verify($crt_password,  $row['password'])){
        $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $update_password = "UPDATE `users` SET `password`='$new_hashed_password' WHERE `id`=$uid";
        if($con->query($update_password)){
            alert('success', 'Password changed successfully');
        }else{
            alert('error', "Error in changing password!");
        }




    }else{ 
        alert('error', "Incorrect current password!");


    }
    // password_verify($password, $row['password'])


  

}


?>