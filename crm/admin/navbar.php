<?php 
session_start();
include_once("../assets/functions.php"); 
include_once("../database.php"); 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar-custom {
            background-color: #333;
            padding: 15px 0px;
        }

        .navbar-custom .navbar-nav .nav-link {
            color: #fff;
            font-size: 18px;
            padding: 10px 15px;
        }

        .navbar-custom .navbar-nav .nav-link:hover {
            color: #ddd;
        }

        .navbar-custom .navbar-brand {
            color: #fff;
            font-size: 24px;
        }

        .navbar-custom .navbar-brand:hover {
            color: #ddd;
        }
        
        .custom-alert{
            position: fixed;
            top : 25px;
            right: 25px;
        }

    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Admin Panel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="comments_management_page.php">Comments</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="recipe_management_page.php">Recipe Management</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="user_management_page.php">User</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="setting_page.php">Settings</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link ms-auto" href="admin_logout.php" class="logout-btn">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
