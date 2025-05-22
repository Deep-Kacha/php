<?php
include_once "database.php";

$query = "SELECT * FROM `settings` WHERE 1";
$result = $con->query($query);
$row = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <style>
        a{
            text-decoration: none;
            color : inherit;
        }

        .footer {
            background-color: #2d2d2d;
            color: #fff;
            padding: 60px 0 30px;
        }

        .ft-text{
            color : #a8a8a8;
        }

        .footer h4 {
            color: #fff;
            font-size: 20px;
            margin-bottom: 25px;
            font-weight: 600;
        }

        .footer-links {
            padding-left: 0;
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 15px;
        }

        .footer-links a {
            color: #a8a8a8;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-links a:hover {
            color: #fff;
            text-decoration: none;
        }

        .social-icons {
            margin-top: 20px;
        }

        .social-icons a {
            display: inline-block;
            width: 35px;
            height: 35px;
            background: #424242;
            color: #fff;
            text-align: center;
            line-height: 35px;
            border-radius: 50%;
            margin-right: 10px;
            transition: background-color 0.3s;
            text-decoration: none;
        }

        .social-icons a:hover {
            background: #007bff;
        }

        .newsletter-form {
            position: relative;
            margin-top: 20px;
        }

        .newsletter-form input {
            padding: 12px 15px;
            border-radius: 4px;
            width: 100%;
            border: none;
            background: #424242;
            color: #fff;
        }

        .newsletter-form button {
            position: absolute;
            right: 5px;
            top: 5px;
            padding: 7px 15px;
            border-radius: 4px;
        }

        .footer-bottom {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #424242;
        }

        .footer-bottom a {
            color: #a8a8a8;
        }

        .footer-bottom p {
            color: #a8a8a8;
            margin-bottom: 0;
        }

        .custom-input::placeholder{
            color : white;
        }
    </style>
</head>
<body>

<footer class="footer">
    <div class="container">
        <div class="row">
            <!-- About Section -->
            <div class="col-md-3 col-sm-6 mb-4">
                <h4>About Us</h4>
                <p class="ft-text"><?php echo $row['site_about']; ?></p>
                <div class="social-icons">
                    <a href="<?php echo $row['facebook_link']; ?> "><i class="fab fa-facebook-f"></i></a>
                    <a href="<?php echo $row['twitter_link']; ?> "><i class="fab fa-twitter"></i></a>
                    <a href="<?php echo $row['instagram_link']; ?> "><i class="fab fa-instagram"></i></a>
                    <a href="<?php echo $row['youtube_link']; ?> "><i class="fab fa-youtube"></i></a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-md-3 col-sm-6 mb-4">
                <h4>Quick Links</h4>
                <ul class="footer-links">
                    <li><a href="#">Popular Recipes</a></li>
                    <li><a href="#">Latest Recipes</a></li>
                    <li><a href="#">Recipe Categories</a></li>
                    <li><a href="#">Meal Plans</a></li>
                    <li><a href="#">Cooking Tips</a></li>
                </ul>
            </div>

            <!-- Recipe Categories -->
            <div class="col-md-3 col-sm-6 mb-4">
                <h4>Recipe Categories</h4>
                <ul class="footer-links">
                    <li><a href="#">Breakfast</a></li>
                    <li><a href="#">Main Course</a></li>
                    <li><a href="#">Desserts</a></li>
                    <li><a href="#">Vegetarian</a></li>
                    <li><a href="#">Healthy Options</a></li>
                </ul>
            </div>

            <!-- Newsletter -->
            <div class="col-md-3 col-sm-6 mb-4">
                <h4>Stay Updated</h4>
                <p class="ft-text">Subscribe to our newsletter for new recipes and cooking tips!</p>
                <div class="newsletter-form">
                    <input type="email" placeholder="Enter your email" class="form-control custom-input">
                    <button class="btn btn-primary">Subscribe</button>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <div class="row">
                <div class="col-md-6 mb-3 mb-md-0">
                    <p>&copy; 2024 Your Recipe Website. All rights reserved.</p>
                </div>
                
                <div class="col-md-6 text-md-end">
                    <a href="#" class="me-3">Privacy Policy</a>
                    <a href="#" class="me-3">Terms of Service</a>
                    <a href="contact.php" class="me-3">Contact Us</a>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- Font Awesome for icons -->
<script src="https://kit.fontawesome.com/your-kit-code.js" crossorigin="anonymous"></script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>