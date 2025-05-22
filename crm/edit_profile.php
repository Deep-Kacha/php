<?php 

    include("assets/navbar.php"); 

    $email = $_SESSION['userEmail'];
    $id = $_SESSION['userID'];

    $select_user = "SELECT * FROM `users` u JOIN `user_profiles` up ON u.id = up.user_id WHERE `user_id`='$id'";
    $result = $con->query($select_user);
    $user_row = mysqli_fetch_assoc($result);
    $dp = explode(",", $user_row['dietary_preferences']);
    $cp = explode(",", $user_row['cuisine_preferences']);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - Let's Cook</title>
    
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

        a {
            text-decoration: none;
            color: inherit;
        }

        /* Profile container */
        .profile-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-bottom: 30px;
        }

        .profile-header {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
        }

        .profile-picture {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid #f5f5f5;
            margin-right: 30px;
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

        /* Badge styling */
        .badge {
            background-color: #eb4a36;
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            margin-right: 5px;
            margin-bottom: 5px;
            display: inline-block;
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

        .upload-area {
            border: 2px dashed #ccc;
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            margin-bottom: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .upload-area:hover {
            border-color: #eb4a36;
        }

        .upload-icon {
            font-size: 40px;
            color: #eb4a36;
            margin-bottom: 10px;
        }

        .preview-image {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            margin-top: 15px;
        }

        .skill-level {
            margin-bottom: 20px;
        }

        .skill-level label {
            display: block;
            margin-bottom: 10px;
        }

        .range-labels {
            display: flex;
            justify-content: space-between;
            margin-top: 5px;
        }

        .range-labels span {
            font-size: 12px;
            color: #777;
        }

        .cooking-level-slider {
            margin-bottom: 10px;
        }
    </style>
     <script>
        $(document).ready(function() {
            $("#profileForm").validate({
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
                    bio: {
                        maxlength: 200
                    }
                },
                messages: {
                    firstName: {
                        required: "Please enter your First Name",
                        pattern: "Name can only contain letters.",
                        minlength: "It must contain at least 2 characters.",
                        maxlength: "It must contain maximum 15 characters.",
                    },
                    lastName: {
                        required: "Please enter your Last Name",   
                        pattern: "Name can only contain letters.",
                        minlength: "It must contain at least 2 characters.",
                        maxlength: "It must contain maximum 15 characters.",  
                    },
                    email: {
                        required: "Please enter your email",
                        email: "Please enter valid email",
                    },
                    bio: {
                        maxlength: "Bio cannot exceed 200 characters"
                    }
                }
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
                        <li class="breadcrumb-item active" aria-current="page">Edit Profile</li>
                    </ol>
                </nav>
                <h2 class="mb-0">Edit Your Profile</h2>
                <p class="text-muted">Update your personal information and preferences</p>
            </div>
        </div>

        <form id="profileForm" action="edit_profile.php" method="POST" enctype="multipart/form-data">
            <div class="row">
                <!-- Left Column -->
                <div class="col-lg-4">
                    <!-- Profile Picture Section -->
                    <div class="form-section">
                        <h4>Profile Picture</h4>
                        <div class="text-center mb-4">
                            <img src="assets/images/profile_picture/<?php echo $user_row['profile_picture'];?>" alt="Current Profile Picture" class="profile-picture">
                            <div class="d-grid">
                                <label for="profile-upload" class="btn btn-outline-primary">
                                    <i class="fas fa-camera me-2"></i>Change Photo
                                </label>
                                <input type="file" id="profile-upload" name="profile_picture" accept="image/*" class="d-none">
                            </div>
                        </div>  
                        <div class="small text-muted text-center">
                            Recommended: Square image, at least 300×300 pixels
                        </div>
                    </div>
    
                    <!-- Account Settings -->
                    <div class="form-section">
                        <h4>Account Settings</h4>
                        <div class="d-grid gap-2 mb-3">
                            <a href="change_password.php" class="btn btn-outline-primary">
                                <i class="fas fa-key me-2"></i>Change Password
                            </a>
                        </div>
                        
                        <button type="button" class="btn btn-outline-danger btn-sm">
                            <i class="fas fa-trash-alt me-1"></i> Delete Account
                        </button>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-lg-8">
                    <!-- Personal Information -->
                    <div class="form-section">
                        <h4>Personal Information</h4>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="firstName" class="form-label">First Name</label>
                                <input type="text" value="<?php echo $user_row['first_name']; ?>" class="form-control" id="firstName" name="firstName" required>
                            </div>
                            <div class="col-md-6">
                                <label for="lastName" class="form-label">Last Name</label>
                                <input type="text" value="<?php echo $user_row['last_name']; ?>" class="form-control" id="lastName" name="lastName" required>
                            </div>
                            <div class="col-md-12">
                                <label for="email" class="form-label">Email Address (readonly)</label>
                                <input type="email" value="<?php echo $user_row['email']; ?>" class="form-control" id="email" name="email" readonly>
                            </div>
                            <div class="col-12">
                                <label for="location" class="form-label">Location</label>
                                <input type="text" class="form-control" id="location" value="<?php echo $user_row['location']; ?>" name="location">
                                <div class="form-text">City, Country (Optional)</div>
                            </div>
                            <div class="col-12">
                                <label for="bio" class="form-label">About Me</label>
                                <textarea class="form-control" id="bio" name="bio" rows="4"><?php echo $user_row['bio']; ?></textarea>
                                <div class="form-text">Tell others about yourself and your cooking journey (max 200 characters)</div>
                            </div>
                        </div>
                    </div>

                    <!-- Cuisine Preferences -->
                    <div class="form-section">
                        <h4>Cuisine Preferences</h4>
                        <p class="text-muted mb-3">Select the cuisines you enjoy cooking the most</p>
                        <div class="row">
                            <div class="col-md-3 col-6 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="Indian" id="indianCuisine" name="cuisines[]" <?php
                                                        if (in_array("Indian", $cp)) {
                                                            echo "checked";
                                                        } ?>>
                                    <label class="form-check-label" for="indianCuisine">
                                        Indian
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-3 col-6 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="Italian" id="italianCuisine" name="cuisines[]" <?php
                                                        if (in_array("Italian", $cp)) {
                                                            echo "checked";
                                                        } ?>>
                                    <label class="form-check-label" for="italianCuisine">
                                        Italian
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Diet & Preferences -->
                    <div class="form-section">
                        <h4>Dietary Preferences</h4>
                        <p class="text-muted mb-3">Help us customize your experience</p>
                        <div class="row">
                            <div class="col-md-4 col-6 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="Vegetarian" id="vegetarian" name="diet[]" <?php
                                                        if (in_array("Vegetarian", $dp)) {
                                                            echo "checked";
                                                        } ?>>
                                    <label class="form-check-label" for="vegetarian">
                                        Vegetarian
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4 col-6 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="vegan" id="vegan" name="diet[]" <?php
                                            if (in_array("vegan", $dp)) {
                                                echo "checked";
                                            } ?>>
                                    <label class="form-check-label" for="vegan">
                                        Vegan
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4 col-6 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="low-carb" id="lowCarb" name="diet[]" <?php
                                            if (in_array("low-carb", $dp)) {
                                                echo "checked";
                                            } ?>>
                                    <label class="form-check-label" for="lowCarb">
                                        Low-Carb
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Save Buttons -->
                    <div class="d-flex justify-content-between mb-5">
                        <a href="profile.php" name="cancel" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-1"></i> Cancel
                        </a>
                        <button type="submit" name="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Save Changes
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

</body>
</html>

<?php include_once "assets/footer.php"; 
    if(isset($_POST['submit'])){
        $fname = $_POST['firstName'];
        $lname = $_POST['lastName'];
        $email = $_POST['email'];
        $location = $_POST['location'];
        $bio = $_POST['bio'];
        $c = $_POST['cuisines'];
        $cuisine = implode(",", $c);
        $d = $_POST['diet'];
        $diet = implode(",", $d);
 
        $user_profile_update = "UPDATE `user_profiles` SET `bio`='$bio',`location`='$location',`cuisine_preferences`='$cuisine',`dietary_preferences`='$diet'";

        if ($_FILES['profile_picture']['name'] != "") {
            $profile_picture = uniqid() ."_" . $_FILES["profile_picture"]["name"];
            $old_photo_query = "SELECT `profile_picture` FROM `user_profiles` WHERE `user_id`=$id";
        
            $row = mysqli_fetch_assoc($con->query($old_photo_query));
            $old_profile_picture = $row['profile_picture'];

            $user_profile_update = $user_profile_update . ", `profile_picture`='$profile_picture'";
        }
        $user_profile_update = $user_profile_update . " WHERE `user_id`=$id";

        $user_update = "UPDATE `users` SET `first_name`='$fname',`last_name`='$lname' WHERE `id`=$id";


        if ($con->query($user_profile_update) && $con->query($user_update)) {
            if ($_FILES['profile_picture']['name'] != ""); {
                move_uploaded_file($_FILES['profile_picture']['tmp_name'], "assets/images/profile_picture/" . $profile_picture);
                if($old_profile_picture != ""){
                    unlink("assets/images/profile_picture/" . $old_profile_picture);
                }
                redirect("profile.php");
            }
            alert("success", "Profile updated successfully");
        }else{
            alert("error", "Failed to update Profile");
        }
    }

















?>