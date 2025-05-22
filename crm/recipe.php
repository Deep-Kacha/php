<?php
include_once("assets/navbar.php");
include_once("assets/functions.php");

if (isset($_GET['rid'])) {

    $rid = $_GET['rid'];
    $recipeQuery = "SELECT * FROM `recipes` r JOIN `recipe_states` rs ON r.recipe_id = rs.recipe_id WHERE r.recipe_id='$rid'";
    $result = $con->query($recipeQuery);
    $row = mysqli_fetch_assoc($result);

    $uid = $row['user_id'];

    $select_user = "SELECT * FROM `users` u JOIN `user_profiles` up ON u.id = up.user_id WHERE `user_id`='$uid'";
    $user_result = $con->query(($select_user));
    $user = mysqli_fetch_assoc($user_result);

    $review = "SELECT * FROM `reviews` r JOIN `users` u ON r.user_id = u.id WHERE `recipe_id`='$rid'";
    $review_result = $con->query($review);

    $dynamic_query = "SELECT 
                COUNT(*) AS total_reviews,
                AVG(rating) AS average_rating,
                SUM(CASE WHEN rating = 5 THEN 1 ELSE 0 END) AS five_star,
                SUM(CASE WHEN rating = 4 THEN 1 ELSE 0 END) AS four_star,
                SUM(CASE WHEN rating = 3 THEN 1 ELSE 0 END) AS three_star,
                SUM(CASE WHEN rating = 2 THEN 1 ELSE 0 END) AS two_star,
                SUM(CASE WHEN rating = 1 THEN 1 ELSE 0 END) AS one_star
            FROM reviews
            WHERE recipe_id = $rid";

    $dynamic_result = $con->query($dynamic_query);
    $data = mysqli_fetch_assoc($dynamic_result);


    $total = max((int)$data['total_reviews'], 1); // prevent divide by 0
    $avg = round($data['average_rating'], 1);

    $percent = [
        5 => round(($data['five_star'] / $total) * 100),
        4 => round(($data['four_star'] / $total) * 100),
        3 => round(($data['three_star'] / $total) * 100),
        2 => round(($data['two_star'] / $total) * 100),
        1 => round(($data['one_star'] / $total) * 100),
    ];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $row['title']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Nunito&display=swap" rel="stylesheet"> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="\crm\assets\css\recipe_card.css">
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.19.3/jquery.validate.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <?php include_once("assets/functions.php"); ?>

    <script>
        function showAlert(message, type = 'success') {
            const alertBox = $('<div class="alert custom-alert alert-' + type + ' alert-dismissible fade show mt-3" role="alert">' +
                message +
                '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                '</div>');

            $(".container").prepend(alertBox);

            setTimeout(() => {
                alertBox.alert('close');
                // alertBox.remove(); 
            }, 3000);
        }

        $(document).ready(function() {
            $("#reviewForm").validate({
                rules: {
                    title: {
                        required: true,
                        minlength: 3,
                        maxlength: 50
                    },
                    review: {
                        required: true,
                        minlength: 10,
                        maxlength: 500
                    },
                    rating: {
                        required: true
                    }
                },
                messages: {
                    title: {
                        required: "Please enter a review title",
                        minlength: "Title must be at least 3 characters long",
                        maxlength: "Title must be less than 50 characters"
                    },
                    review: {
                        required: "Please share your experience with this recipe",
                        minlength: "Review must be at least 10 characters long",
                        maxlength: "Review must be less than 500 characters"
                    },
                    rating: {
                        required: "Please select a rating from 1 to 5 stars"
                    }
                },
            });
        });
    </script>
    <script>
        $(document).on('click', '.save-recipe-btn', function() {
            var recipeId = $(this).data('recipe-id');
            var button = $(this);
            $.ajax({
                url: 'save_recipes.php',
                type: 'POST',
                data: {
                    recipe_id: recipeId
                },
                success: function(response) {

                    if (response === 'saved') {
                        button.html('<i class="bi bi-bookmark-check-fill"></i> Saved');
                        button.removeClass('btn-outline-success').addClass('btn-success');


                        showAlert('Recipe saved successfully!', 'success');

                    } else if (response == 'removed') {
                        button.html('<i class="bi bi-bookmark"></i> Save Recipe');
                        button.removeClass('btn-success').addClass('btn-outline-success');

                        showAlert('Recipe removed from saved recipes.', 'success');
                    } else {
                        showAlert('Something went wrong.', 'danger');
                    }

                },

            });
        });
    </script>

    <script>
        $(document).on('click', '.follow-user-btn', function() {
            var followingId = $(this).data('user-id');
            var button = $(this);

            $.ajax({
                url: 'follow_functionality.php',
                type: 'POST',
                data: {
                    following_id: followingId
                },
                success: function(response) {
                    if (response === 'followed') {
                        button.html('<i class="bi bi-person-dash"></i> Unfollow');
                        button.removeClass('btn-outline-danger').addClass('btn-danger');

                        showAlert('You are now following this user!', 'success');
                    } else if (response === 'unfollowed') {
                        button.html('<i class="bi bi-person-plus"></i> Follow');
                        button.removeClass('btn-danger').addClass('btn-outline-danger');

                        showAlert('You have unfollowed this user.', 'success');
                    } else if (response === 'login_required') {
                        showAlert('Please login to follow users.', 'warning');
                    } else {
                        showAlert('Something went wrong.', 'danger');
                    }
                }
            });
        });
    </script>
</head>

<body>
    <div class="container">
        <!-- Recipe Header -->
        <div class="row">
            <div class="col-lg-8">
                <div class="recipe-header">
                    <h1 class="recipe-title"><?php echo $row['title']; ?> </h1>
                    <div class="recipe-meta">
                        <div class="meta-item">
                            <i class="bi bi-clock"></i>
                            <span>Prep Time: <?php echo $row['prep_time']; ?> mins</span>
                        </div>
                        <div class="meta-item">
                            <i class="bi bi-fire"></i>
                            <span>Cook Time: <?php echo $row['cooking_time']; ?> mins</span>
                        </div>
                        <div class="meta-item">
                            <i class="bi bi-people"></i>
                            <span>Course: <?php echo json_decode($row['course']); ?></span>
                        </div>
                    </div>
                    <p class="lead"><?php echo $row['description']; ?></p>
                </div>
            </div>
        </div>
        <!-- Add this code below the recipe header div and before the row that contains main content and sidebar -->
        <div class="row mb-4">
            <div class="col-lg-8">
                <div class="author-section card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="author-img me-3">
                                <img src="assets/images/profile_picture/<?php echo $user['profile_picture'] ?>" alt="Recipe Author" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
                            </div>
                            <div class="author-info">
                                <h3 class="author-name mb-1"><?php echo $user['first_name'] . " " . $user['last_name']; ?></h3>
                                <!-- <p class="author-title text-muted mb-2">Recipe Developer & Food Blogger</p> -->
                                <p class="author-bio mb-2"><?php echo $user['bio']; ?></p>
                                <div class="author-social">
                                    <a href="#" class="text-decoration-none me-2"><i class="bi bi-facebook"></i></a>
                                    <a href="#" class="text-decoration-none me-2"><i class="bi bi-instagram"></i></a>
                                    <a href="#" class="text-decoration-none me-2"><i class="bi bi-twitter"></i></a>
                                    <a href="#" class="text-decoration-none"><i class="bi bi-youtube"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-light">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="text-muted"><i class="bi bi-calendar3"></i> Published: <?php echo date("F j, Y", strtotime($row['created_at'])); ?></span>
                                <!-- <span class="text-muted ms-3"><i class="bi bi-pencil"></i> Updated: -- </span> -->
                            </div>
                            <a href="#" class="btn btn-sm btn-outline-primary">Follow</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Recipe Image -->
                <img src="\crm\assets\images\recipes\<?php echo $row['recipe_image'] ?>" alt="<?php echo $row['title']; ?>" class="img-fluid recipe-image">

                <!-- Recipe Stats -->
                <div class="recipe-stats row">
                    <div class="col-3 stat-item">
                        <div class="stat-label">Prep Time</div>
                        <div class="stat-value"><?php echo $row['prep_time']; ?> min</div>
                    </div>
                    <div class="col-3 stat-item">
                        <div class="stat-label">Cook Time</div>
                        <div class="stat-value"><?php echo $row['cooking_time']; ?> mins</div>
                    </div>
                    <div class="col-3 stat-item">
                        <div class="stat-label">Total Time</div>
                        <div class="stat-value"><?php echo ($row['prep_time'] + $row['cooking_time']); ?> min</div>
                    </div>
                    <div class="col-3 stat-item">
                        <div class="stat-label">Course</div>
                        <div class="stat-value"><?php echo json_decode($row['course']); ?></div>
                    </div>
                    <div class="col-3 stat-item">
                        <div class="stat-label">Cuisine</div>
                        <div class="stat-value"><?php echo json_decode($row['cuisin']); ?></div>
                    </div>
                    <div class="col-3 stat-item">
                        <div class="stat-label">Diet</div>
                        <div class="stat-value"><?php
                                                $dietArray = json_decode($row['diet'], true);
                                                if (!empty($dietArray)) {
                                                    echo implode(", ", array_filter($dietArray)); // Filters out empty values and joins with comma
                                                } ?>
                        </div>
                    </div>
                </div>

                <!-- Ingredients Section -->
                <div class="ingredients-section">
                    <h2 class="section-title">Ingredients Essentials</h2>

                    <?php
                    $ingredients = json_decode($row['ingredients'], true);
                    $i = 0;

                    foreach ($ingredients as $item) {
                        $i++;
                        $parts = explode(":", $item, 2);

                        $title = trim($parts[0]);
                        $desc = isset($parts[1]) ? trim($parts[1]) : ''; ?>

                        <div class="step-item">
                            <div class="step-number"><?php echo $i; ?></div>

                            <span style="font-weight : bold"><?php echo $title; ?> </span>
                            <p class="steps-instruction"><?php echo $desc; ?></p>
                        </div>

                    <?php }
                    ?>

                </div>

                <!-- Instructions Section -->
                <div class="steps-section">
                    <h2 class="section-title">Instructions</h2>
                    <?php
                    $instructions = json_decode($row['instructions'], true);
                    $i = 1;

                    foreach ($instructions as $step) { ?>
                        <div class="step-item">
                            <div class="step-number"><?php echo $i; ?></div>
                            <p class="steps-instruction"><?php echo $step; ?></p>
                        </div>
                    <?php $i++;
                    } ?>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="recipe-actions">
                    <button class="btn btn-outline-primary action-button">
                        <i class="bi bi-printer"></i> Print Recipe
                    </button>
                    <?php if (isset($_SESSION['userLogin']) && $_SESSION['userLogin'] == true) {
                        $user_id = $_SESSION['userID'];

                        //check for save
                        $check_saved = "SELECT * FROM `favorites` WHERE `user_id` = $user_id AND `recipe_id` = $rid";
                        $saved_result = $con->query($check_saved);
                        $is_saved = $saved_result->num_rows > 0;

                        //check for follow
                        $check_follow = "SELECT * FROM `followers` WHERE `follower_id` = $user_id AND `following_id` = $uid";
                        $follow_result = $con->query($check_follow);
                        $is_following = $follow_result->num_rows > 0;

                        if ($user_id != $uid) {
                    ?>
                            <!-- Follow button -->
                            <button class="btn <?php echo $is_following ? 'btn-danger' : 'btn-outline-danger'; ?> action-button follow-user-btn" data-user-id="<?= $uid ?>">
                                <i class="bi bi-<?php echo $is_following ? 'person-dash' : 'person-plus'; ?>"></i>
                                <?php echo $is_following ? 'Unfollow' : 'Follow'; ?>
                            </button>

                        <?php } else { ?>
                            <a href="profile.php" class="btn btn-outline-info action-button">
                                <i class="bi bi-person-circle"></i> View Your Profile
                            </a>
                        <?php } ?>

                        <!-- Save Recipe Button -->
                        <button class="btn <?php echo $is_saved ? 'btn-success' : 'btn-outline-success'; ?> action-button save-recipe-btn" data-recipe-id="<?= $rid ?>">
                            <i class="bi bi-<?php echo $is_saved ? 'bookmark-check-fill' : 'bookmark'; ?>"></i>
                            <?php echo $is_saved ? 'Saved' : 'Save Recipe'; ?>
                        </button>

                    <?php } else { ?>
                        <a href="login.php" class="btn btn-outline-primary action-button">
                            <i class="bi bi-box-arrow-in-right"></i> Login for more
                        </a>
                    <?php } ?>

                    <!-- Share Buttons -->
                    <div class="share-buttons mt-4">
                        <h4>Share Recipe</h4>
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-primary flex-grow-1">
                                <i class="bi bi-facebook"></i>
                            </button>
                            <button class="btn btn-outline-info flex-grow-1">
                                <i class="bi bi-twitter"></i>
                            </button>
                            <button class="btn btn-outline-danger flex-grow-1">
                                <i class="bi bi-pinterest"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Recipe Card -->
                    <div class="card mt-4">
                        <div class="card-body">
                            <h4 class="card-title">Recipe Card</h4>
                        </div>
                        <div class="card-body">
                            <div class="nutrition-info">
                                <div class="d-flex justify-content-between">
                                    <span>Cuisine</span>
                                    <span><?php echo json_decode($row['cuisin']); ?></span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Course</span>
                                    <span><?php echo json_decode($row['course']); ?></span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Diet</span>
                                    <span><?php $dietArray = json_decode($row['diet'], true);
                                            if (!empty($dietArray)) {
                                                echo implode(", ", array_filter($dietArray));
                                            } ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>



                    <!-- Nutrition Card -->
                    <div class="card mt-4">
                        <div class="card-body">
                            <h4 class="card-title">Nutrition Information</h4>
                        </div>
                        <div class="card-body">
                            <div class="nutrition-info">
                                <div class="d-flex justify-content-between">
                                    <span>Calories</span>
                                    <span><?php echo json_decode($row['calories']); ?></span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Protein</span>
                                    <span><?php echo json_decode($row['protein']); ?></span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Carbohydrates</span>
                                    <span><?php echo json_decode($row['carbohydrates']); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Comments and Ratings Section -->
        <div class="row mt-5">
            <div class="col-lg-8">
                <div class="comments-section">
                    <h2 class="section-title">Comments & Ratings</h2>

                    <!-- Rating Summary -->
                    <div class="rating-summary card mb-4">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-4 text-center">
                                    <h3 class="mb-0"><?php echo $avg; ?></h3>
                                    <div class="stars">
                                        <?php
                                        $fullStars = floor($avg);
                                        $halfStar = ($avg - $fullStars) >= 0.5;
                                        for ($i = 1; $i <= 5; $i++) {
                                            if ($i <= $fullStars) {
                                                echo '<i class="bi bi-star-fill text-warning"></i>';
                                            } elseif ($halfStar && $i == $fullStars + 1) {
                                                echo '<i class="bi bi-star-half text-warning"></i>';
                                            } else {
                                                echo '<i class="bi bi-star text-warning"></i>';
                                            }
                                        }
                                        ?>
                                    </div>
                                    <p class="text-muted"><?php echo (int)$data['total_reviews'] ?></p>
                                </div>
                                <div class="col-md-8">
                                    <div class="rating-bars">
                                        <?php
                                        $colors = [
                                            5 => 'bg-success',
                                            4 => 'bg-success',
                                            3 => 'bg-warning',
                                            2 => 'bg-danger',
                                            1 => 'bg-danger',
                                        ];

                                        foreach ([5, 4, 3, 2, 1] as $star) {
                                            echo '<div class="rating-bar d-flex align-items-center mb-2">';
                                            echo "<span class='me-2'>$star</span>";
                                            echo "<div class='progress flex-grow-1' style='height: 12px;'>
                                                        <div class='progress-bar {$colors[$star]}' style='width: {$percent[$star]}%'></div>
                                                    </div>";
                                            echo "<span class='ms-2'>{$percent[$star]}%</span>";
                                            echo '</div>';
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Add Review Form -->
                    <?php if (isset($_SESSION['userLogin']) && $_SESSION['userLogin'] == true) { ?>
                        <div class="add-review card mb-4">
                            <div class="card-body">
                                <h4>Add Your Review</h4>
                                <form id="reviewForm" method="POST">
                                    <div class="mb-3">
                                        <label class="form-label">Your Rating</label>
                                        <div class="rating-input">
                                            <input type="radio" id="star5" name="rating" value="5">
                                            <label for="star5"><i class="bi bi-star-fill"></i></label>
                                            <input type="radio" id="star4" name="rating" value="4">
                                            <label for="star4"><i class="bi bi-star-fill"></i></label>
                                            <input type="radio" id="star3" name="rating" value="3">
                                            <label for="star3"><i class="bi bi-star-fill"></i></label>
                                            <input type="radio" id="star2" name="rating" value="2">
                                            <label for="star2"><i class="bi bi-star-fill"></i></label>
                                            <input type="radio" id="star1" name="rating" value="1">
                                            <label for="star1"><i class="bi bi-star-fill"></i></label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="reviewText" class="form-label">Your Review</label>
                                        <textarea class="form-control" id="reviewText" name="review" rows="4" required></textarea>
                                    </div>
                                    <button type="submit" name="submit" class="btn btn-primary">Submit Review</button>
                                </form>
                            </div>
                        </div>
                    <?php } ?>

                    <!-- Comments List -->

                    <div class="comments-list">
                        <h4 class="mb-4">Comments</h4>
                        <!-- Single Comment -->
                        <?php
                        while ($review_row = mysqli_fetch_assoc($review_result)) { ?>
                            <div class="comment card mb-3">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div class="comment-meta text-muted">
                                            <small>By <?php echo $review_row['first_name'] . " " . $review_row['last_name']; ?> - <?php echo date("F j, Y", strtotime($row['created_at'])); ?></small>
                                        </div>
                                        <div class="stars">
                                            <?php
                                            for ($i = 1; $i <= 5; $i++) {
                                                if ($i <= $review_row['rating']) {
                                                    echo '<i class="bi bi-star-fill text-warning"></i>';
                                                } else {
                                                    echo '<i class="bi bi-star text-warning"></i>';
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <p class="card-text"><?php echo $review_row['review']; ?></p>
                                </div>
                            </div>
                        <?php } ?>

                        <!-- More comments would be dynamically added here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php include("assets/footer.php");

if (isset($_POST['submit'])) {

    $uid = $_SESSION['userID'];
    $rating = $_POST['rating'];
    $review = $con->real_escape_string($_POST['review']);

    $insert = "INSERT INTO `reviews`(`user_id`, `recipe_id`, `rating`, `review`) VALUES ($uid, $rid, $rating, '$review')";

    if ($con->query($insert)) {
        alert('success', 'Reviews submitted successfully.');
        redirect("recipe.php?rid=$rid");
    } else {
        alert('error', 'Failed in submitting review.');
    }
}


?>