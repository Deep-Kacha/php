<?php
    session_start();
    include_once("database.php");
    include_once("functions.php");

    $query = "SELECT * FROM `settings` WHERE 1";
    $result = $con->query($query);
    $row = mysqli_fetch_assoc($result);
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cooking Recipes</title>

    <!-- Include the Bootstrap bundle which already includes Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script>
        const menuIcon = document.getElementById('menu-icon');
        const navLinks = document.querySelector('.nav-links');

        menuIcon.addEventListener('click', () => {
            navLinks.classList.toggle('active');
        });
    </script>
    <style>
        .custom-alert{
            position: fixed !important;
            top : 25px !important;
            right: 25px !important;
        }
        
        nav {
            border-bottom: 2px solid rgba(245, 245, 245, 0.9);
        }

        .nav-item {
            font-size : 20px;
            margin: 5px;
        }

        .nav-item.dropdown:hover .dropdown-menu {
            display: block;
        }

        
        .search-inputt {
            border: 2px solid #ddd !important;
            border-radius: 25px !important;
            padding: 10px 20px !important;
            margin-right: 10px;
            margin-top: 10px;
        }

        .search-buttonn {
            background-color: #eb4a36 !important;
            color: white !important;
            border: none !important;
            border-radius: 25px !important;
            padding: 10px 30px !important;
            transition: all 0.3s ease !important;
        }

        .search-buttonn:hover {
            background-color: #eb4a36 !important;
        }

        .dropdown-menu .dropdown-item {
            padding: 10px 15px; /* Increased padding */
            font-size: 16px; /* Larger font size */
        }

        .nav-item a:hover{
            color : #eb4a36;
        }

        .sign-up{
            background-color: #eb4a36;
            border-radius: 30px;
            padding: 3px 5px 5px 6px;
        }

        .sign-up a{
            color : white;
            font-weight: 600;
        }

        .sign-up a:hover{
            color : white;
        }

        .search-btn {
            border-color: #eb4a36 !important; 
            color: #eb4a36 !important;
        }

        .search-btn:hover {
            background-color: #eb4a36 !important;
            color: white !important;
            border-color: #eb4a36 !important;
        }
        
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg" style= "background-color: #FFFFFF;" >
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><?php echo $row['site_title']; ?></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse"  id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="/crm/index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/crm/about.php">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/crm/contact.php">Contact Us</a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link" href="/crm/search.php">Search</a>
                    </li>
                </ul>

                <form class="d-flex ms-auto" method="post" action="index.php" role="search">
                    <div class="search-containerr">
                        <div class="input-group mb-3">
                            <input type="text" name="search_term" class="form-control search-inputt" id="searchInput" placeholder="Search recipes..." aria-label="Search recipes">
                            <button class="btn search-buttonn" name="search-btn" type="submit">
                                <i class="fas fa-search"></i> Search
                            </button>
                        </div>
                    </div>
                </form>

                <?php if(isset($_SESSION['userLogin']) && $_SESSION['userLogin'] == true){ ?>
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="/crm/profile.php">
                                <i class="fas fa-user"></i> Profile
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/crm/logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> 
                                Logout
                            </a>
                        </li>
                    </ul>
                <?php }else{ ?>
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="/crm/login.php">Login</a>
                        </li>
                        <li class="nav-item sign-up">
                            <a class="nav-link" href="/crm/register.php">Sign up</a>
                        </li>
                    </ul>
                <?php } ?>
            </div>
        </div>
    </nav>
</body>
</html>