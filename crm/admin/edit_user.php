<?php 
    include("navbar.php");

    if(isset($_GET['uid'])){
        $uid = $_GET['uid'];
        $select_user = "SELECT * FROM `users` WHERE `id`='$uid'";
        $result = $con->query($select_user);
        $user_row = mysqli_fetch_assoc($result);
    }
?>
<?php include_once 'navbar.php';

$select = "SELECT * FROM `users`";
$result = $con->query($select);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Admin Panel - Users</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js\jquery-3.7.1.min.js"></script>
    <script src="js\jquery.validate.js"></script>
    <script src="js\additional-methods.js"></script>
    <script src="js\bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $("form").attr("id", "userForm");
            $("#userForm").validate({
                rules: {
                    email: {
                        required: true,
                        email: true,
                    },
                    first_name: {
                        required: true,
                        pattern: /^[A-Za-z]+$/,
                        minlength: 2,
                        maxlength: 15,
                    },
                    last_name: {
                        required: true,
                        pattern: /^[A-Za-z]+$/,
                        minlength: 2,
                        maxlength: 15,
                    },
                    password: {
                        required: true,
                        minlength: 8,
                        maxlength: 20,
                        pattern: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%#*?&])[A-Za-z\d@$!%*?#&]{8,20}$/,
                    },
                    confirm_password: {
                        required: true,
                        equalTo: "#password",
                    },
                    role: {
                        required: true,
                    },
                },
                messages: {
                    email: {
                        required: "Please enter an email address",
                        email: "Please enter a valid email address",
                    },
                    first_name: {
                        required: "Please enter a first name",
                        pattern: "First name can only contain letters",
                        minlength: "First name must be at least 2 characters",
                        maxlength: "First name cannot exceed 15 characters"
                    },
                    last_name: {
                        required: "Please enter a last name",
                        pattern: "Last name can only contain letters",
                        minlength: "Last name must be at least 2 characters",
                        maxlength: "Last name cannot exceed 15 characters",
                    },
                    password: {
                        required: "Please enter a password",
                        minlength: "Password must be at least 8 characters",
                        maxlength: "Password cannot exceed 20 characters",
                        pattern: "Password must include at least one uppercase letter, one lowercase letter, one number, and one special character (@,$,!,%,*,?,#,&)",
                    },
                    confirm_password: {
                        required: "Please confirm your password",
                        equalTo: "Passwords do not match",
                    },
                    role: {
                        required: "Please select a role",
                    },
                }
            });
        });
    </script>
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        a {
            text-decoration: none;
            color: white;
        }

        body {
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        .container {
            display: flex;
            min-height: 100vh;
        }

        .content {
            flex: 1;
            padding: 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        .btn {
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
            transition: background-color 0.3s;
        }

        .btn-primary {
            background-color: #4CAF50;
            color: white;
        }

        .btn-danger {
            background-color: #f44336;
            color: white;
        }

        .btn-edit {
            background-color: #2196F3;
            color: white;
        }

        .error {
            color: red;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }

        input,
        textarea,
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #f8f8f8;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }
        input, textarea, select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .search-bar {
            display: flex;
            margin-bottom: 20px;
        }
        .search-bar input {
            flex: 1;
            margin-right: 10px;
        }
        .filter-options {
            display: flex;
            margin-bottom: 20px;
        }
        .filter-options select {
            margin-right: 10px;
            width: auto;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="content">
            <div class="card">
                <h2>Add/Edit User</h2>
                <form id="userForm" method="post" action="edit_user.php">
                
                <input type="text" id="uid" value="<?php echo $user_row['id']; ?>" name="uid" placeholder="Enter first name" hidden>

                    <div class="form-group">
                        <label for="first-name">First Name</label>
                        <input type="text" id="first-name" value="<?php echo $user_row['first_name']; ?>" name="first_name" placeholder="Enter first name">
                    </div>

                    <div class="form-group">
                        <label for="last-name">Last Name</label>
                        <input type="text" id="last-name" value="<?php echo $user_row['last_name']; ?>" name="last_name" placeholder="Enter last name">
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email"  value="<?php echo $user_row['email']; ?>" name="email" readonly placeholder="Enter email address">
                    </div>

                    <div class="form-group">
                        <label for="role">Role</label>
                        <select id="role" name="role">
                            <option value="user" <?php echo ($user_row['role'] === 'user') ? 'selected' : ''; ?>>User</option>
                            <option value="admin" <?php echo ($user_row['role'] === 'admin') ? 'selected' : ''; ?>>Admin</option>
                        </select>
                    </div>
                    <button type="submit" name="save_user" class="btn btn-primary">Save User</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>


<?php
    if(isset($_POST['save_user'])){
        $uid = $_POST['uid'];
        $fname = $_POST['first_name'];
        $lname = $_POST['last_name'];
        $email = $_POST['email'];
        $role = $_POST['role'];


        $update = "UPDATE `users` SET `first_name`='$fname',`last_name`='$lname',`email`='$email', `role`='$role' WHERE `id`=$uid";

        if($con->query($update)){
            alert('success', 'Profile updates successfully!!');
        }


        redirect("edit_user.php?uid=$uid");

    }


?>