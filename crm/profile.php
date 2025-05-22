<?php
include("assets/navbar.php");

$email = $_SESSION['userEmail'];
$id = $_SESSION['userID'];
$select_user = "SELECT * FROM `users` u JOIN `user_profiles` up ON u.id = up.user_id WHERE `user_id`='$id'";

$result = $con->query($select_user);
$user_row = mysqli_fetch_assoc($result);

$cp = explode(",", $user_row['cuisine_preferences']);
$dp = explode(",", $user_row['dietary_preferences']);

$recipeQuery = "SELECT `recipe_id`,`title`,`recipe_image` FROM `recipes` WHERE `user_id`=$id";
$recipeResult = $con->query($recipeQuery);

$savedQuery = "SELECT r.recipe_id, r.title, r.recipe_image FROM `favorites` f JOIN `recipes` r ON f.recipe_id = r.recipe_id WHERE f.user_id=$id";
$savedResult = $con->query($savedQuery);

$followers_query = "SELECT COUNT(*) as followers FROM followers WHERE following_id = $id";
$followers_result = $con->query($followers_query);
$followers = mysqli_fetch_assoc($followers_result)['followers'];

$following_query = "SELECT COUNT(*) as following FROM followers WHERE follower_id = $id";
$following_result = $con->query($following_query);
$following = mysqli_fetch_assoc($following_result)['following'];

$recipe_count_query = "SELECT COUNT(*) as total_recipes FROM recipes WHERE user_id = $id";
$recipe_count_result = $con->query($recipe_count_query);
$recipe_count = mysqli_fetch_assoc($recipe_count_result)['total_recipes'];

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - Let's Cook</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/js/bootstrap.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

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

        .profile-stats {
            display: flex;
            justify-content: space-around;
            padding: 20px 0;
            border-top: 1px solid #eee;
            border-bottom: 1px solid #eee;
            margin-bottom: 30px;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 24px;
            font-weight: bold;
            color: #eb4a36;
        }

        .stat-label {
            color: #777;
            font-size: 14px;
        }

        /* Recipe card styling */
        .recipe-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            height: 350px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .recipe-card img {
            width: 100%;
            height: 280px;
            object-fit: cover;
        }

        .recipe-card-body {
            padding: 15px;
        }

        .recipe-card-title {
            font-size: 1.25rem;
            font-weight: bold;
        }

        .recipe-card:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        /* Tabs styling */
        .profile .nav-tabs .nav-link {
            color: #333 !important;
            font-weight: 500 !important;
            border: none !important;
            padding: 15px 20px !important;
        }

        .profile .nav-tabs .nav-link.active {
            color: #eb4a36 !important;
            border-bottom: 3px solid #eb4a36 !important;
            background-color: transparent !important;
        }

        .tab-content {
            padding: 30px 0 !important;
        }

        .nav-item a:hover {
            color: #eb4a36;
        }

        /* Buttons styling */
        .btn-primary {
            background-color: #eb4a36 !important;
            border-color: #eb4a36 !important;
        }

        .btn-primary:hover {
            background-color: #d43b28 !important;
            border-color: #d43b28 !important;
        }

        .btn-outline-primary {
            color: #eb4a36 !important;
            border-color: #eb4a36 !important;
        }

        .btn-outline-primary:hover {
            background-color: #eb4a36 !important;
            color: white !important;
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

        /* Settings form styling */
        .form-label {
            font-weight: 500;
        }

        .form-control:focus {
            border-color: #eb4a36;
            box-shadow: 0 0 0 0.25rem rgba(235, 74, 54, 0.25);
        }
    </style>
</head>

<body>
    <!-- Navbar will be included via PHP include -->


    <div class="container my-5">
        <div class="row">
            <!-- Profile Information -->
            <div class="col-lg-4">
                <div class="profile-container">
                    <div class="profile-header">
                        <img src="assets/images/profile_picture/<?php echo $user_row['profile_picture']; ?>" alt="Profile Picture" class="profile-picture">
                        <div>
                            <h2><?php echo $user_row['first_name'] . ' ' . $user_row['last_name']; ?></h2>
                            <p class="text-muted">Joined : <?php echo date("F j, Y", strtotime($user_row['created_at'])); ?></p>
                            <a href="edit_profile.php">
                                <button class="btn btn-outline-primary btn-sm"><i class="fas fa-edit me-1"></i> Edit Profile</button>
                            </a>
                        </div>
                    </div>

                    <div class="profile-stats">
                        <div class="stat-item">
                            <div class="stat-number"><?php echo $recipe_count; ?></div>
                            <div class="stat-label">Recipes</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number"><?php echo $followers; ?></div>
                            <div class="stat-label">Followers</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number"><?php echo $following; ?></div>
                            <div class="stat-label">Following</div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h5>About Me</h5>
                        <p><?php echo $user_row['bio']; ?></p>
                    </div>

                    <div class="mb-4">
                        <h5>Favorite Cuisines</h5>
                        <div><?php
                                foreach ($cp as $element) { ?>
                                <span class="badge"><?php echo "$element"; ?></span>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="mb-4">
                        <h5>Dietary Preferences</h5>
                        <div><?php
                                foreach ($dp as $element) { ?>
                                <span class="badge"><?php echo "$element"; ?></span>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="col-lg-8">
                <div class="profile-container">
                    <div class="profile">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" id="profileTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="recipes-tab" data-bs-toggle="tab" data-bs-target="#recipes" type="button" role="tab" aria-controls="recipes" aria-selected="true">My Recipes</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="saved-tab" data-bs-toggle="tab" data-bs-target="#saved" type="button" role="tab" aria-controls="saved" aria-selected="false">Saved Recipes</button>
                            </li>
                        </ul>
                    </div>

                    <!-- Tab panes -->

                    <div class="tab-content">
                        <!-- My Recipes Tab -->
                        <div class="tab-pane fade show active" id="recipes" role="tabpanel" aria-labelledby="recipes-tab">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4>My Recipes</h4>
                                <a href="add_recipe.php">
                                    <button class="btn btn-primary"><i class="fas fa-plus me-1"></i> Add New Recipe</button>
                                </a>
                            </div>

                            <?php
                            if (mysqli_num_rows($recipeResult) > 0) { ?>
                                <div class="row row-cols-1 row-cols-md-3 g-4">
                                    <?php while ($row = mysqli_fetch_assoc($recipeResult)) { ?>
                                        <a href="/crm/recipe.php?rid=<?php echo $row['recipe_id']; ?>">
                                            <div class="col">
                                                <div class="recipe-card">
                                                    <img src="assets/images/recipes/<?php echo $row['recipe_image'] ?>" class="img-fluid" alt="<?php echo $row['title'] ?>">
                                                    <div class="recipe-card-body">
                                                        <h5 class="recipe-card-title"><?php echo $row['title'] ?></h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    <?php } ?>
                                </div>
                            <?php } else { ?>

                                <div style="height: 250px;" class="d-flex justify-content-center align-items-center">
                                    <div class="text-center">
                                        <i class="fas fa-utensils fa-3x mb-3 text-muted"></i>
                                        <h4>No Recipes Added Yet</h4>
                                        <p class="text-muted">Start sharing your culinary creations!</p>
                                    </div>
                                </div>

                            <?php } ?>

                            <?php if (mysqli_num_rows($recipeResult) > 0) { ?>
                                <!-- Pagination -->
                                <nav class="mt-4">
                                    <ul class="pagination justify-content-center">
                                        <li class="page-item disabled">
                                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                                        </li>
                                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                        <li class="page-item">
                                            <a class="page-link" href="#">Next</a>
                                        </li>
                                    </ul>
                                </nav>
                            <?php } ?>
                        </div>

                        <!-- Saved Recipes Tab -->
                        <div class="tab-pane fade" id="saved" role="tabpanel" aria-labelledby="saved-tab">
                            <h4 class="mb-4">Saved Recipes</h4>
                            <?php
                            if (mysqli_num_rows($savedResult) > 0) { ?>
                                <div class="row row-cols-1 row-cols-md-3 g-4">
                                    <?php while ($savedRow = mysqli_fetch_assoc($savedResult)) { ?>
                                        <a href="/crm/recipe.php?rid=<?php echo $savedRow['recipe_id']; ?>">
                                            <div class="col">
                                                <div class="recipe-card">
                                                    <img src="assets/images/recipes/<?php echo $savedRow['recipe_image'] ?>" class="img-fluid" alt="<?php echo $savedRow['title'] ?>">
                                                    <div class="recipe-card-body">
                                                        <h5 class="recipe-card-title"><?php echo $savedRow['title'] ?></h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    <?php } ?>
                                </div>
                            <?php } else { ?>

                                <div style="height: 250px;" class="d-flex justify-content-center align-items-center">
                                    <div class="text-center">
                                        <i class="fas fa-utensils fa-3x mb-3 text-muted"></i>
                                        <h4>No Recipes Added Yet</h4>
                                        <p class="text-muted">Start sharing your culinary creations!</p>
                                    </div>
                                </div>

                            <?php } ?>

                            <?php if (mysqli_num_rows($recipeResult) > 0) { ?>
                                <!-- Pagination -->
                                <nav class="mt-4">
                                    <ul class="pagination justify-content-center">
                                        <li class="page-item disabled">
                                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                                        </li>
                                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                        <li class="page-item">
                                            <a class="page-link" href="#">Next</a>
                                        </li>
                                    </ul>
                                </nav>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // JavaScript to handle tab switching
        var triggerTabList = [].slice.call(document.querySelectorAll('#profileTabs a'))
        triggerTabList.forEach(function(triggerEl) {
            var tabTrigger = new bootstrap.Tab(triggerEl)
            triggerEl.addEventListener('click', function(event) {
                event.preventDefault()
                tabTrigger.show()
            })
        })
    </script>
</body>

</html>


<!-- Footer will be included via PHP include -->
<?php
include_once "assets/footer.php";
?>