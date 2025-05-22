<?php

include("assets/navbar.php");

if (isset($_GET['course'])) {
    $course = $_GET['course'];
    $recipeQuery = "SELECT * FROM `recipes` r JOIN `recipe_states` rs ON r.recipe_id = rs.recipe_id WHERE rs.cource = $course";
} else if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $search_term = $con->real_escape_string($_POST['search_term'] ?? '');
    $sort_by = $_POST['sort_by'] ?? '';

    $recipeQuery = "SELECT * FROM `recipes` r JOIN `recipe_states` rs ON r.recipe_id = rs.recipe_id";

    $conditions = [];

    if (!empty($search_term)) {
        $conditions[] = "title LIKE '%$search_term%'";
    }

    if (!empty($conditions)) {
        $recipeQuery .= " WHERE " . implode(" AND ", $conditions);
    }

    // Add sorting
    switch ($sort_by) {
        case 'recent':
            $recipeQuery .= " ORDER BY r.created_at DESC";
            break;
        case 'az':
            $recipeQuery .= " ORDER BY r.title ASC";
            break;
        case 'za':
            $recipeQuery .= " ORDER BY r.title DESC";
            break;
        default:
            $recipeQuery .= " ORDER BY r.recipe_id DESC";
    }
    // }

} else {
    $recipeQuery = "SELECT `recipe_id`,`title`,`recipe_image` FROM `recipes`";
}

$result = $con->query($recipeQuery);
$total_rows = mysqli_num_rows($result);



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Recipes</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            color: #333333 !important;
            background-color: #f5f5f5 !important;
            font-weight: 400;
        }

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

        .search-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .filter-card {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .category-badge {
            background-color: #f8f9fa;
            color: #333;
            padding: 5px 15px;
            border-radius: 20px;
            margin: 5px;
            display: inline-block;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .category-badge:hover {
            background-color: #eb4a36;
            color: white;
        }

        .active-filter {
            background-color: #eb4a36;
            color: white;
        }

        .search-input {
            border: 2px solid #ddd !important;
            border-radius: 25px !important;
            padding: 10px 20px !important;
            margin-right: 10px;
        }

        .search-button {
            background-color: #eb4a36 !important;
            color: white !important;
            border: none !important;
            border-radius: 25px !important;
            padding: 10px 30px !important;
            transition: all 0.3s ease !important;
        }

        .search-button:hover {
            background-color: #eb4a36 !important;
        }

        .custom-select {
            border: 2px solid #ddd !important;
            border-radius: 25px !important;
            padding: 10px 20px !important;
        }
    </style>
    <script>
        $(".course-category-badge").click(function() {
            $(this).toggleClass("active");

            // Update hidden field with selected courses only
            let courses = [];
            $(".course-category-badge.active").each(function() {
                courses.push($(this).data("value"));
            });
            $("#selectedCourse").val(courses.join(","));
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


</head>

<body>

    <div class="container my-5">
        <!-- Search Section -->
        <form method="post" action="search.php">
            <div class="search-container">
                <div class="row">
                    <div class="col-md-8">
                        <div class="input-group mb-3">
                            <input type="text" name="search_term" class="form-control search-input" id="searchInput" placeholder="Search recipes..." aria-label="Search recipes">
                            <button class="btn search-button" name="search-btn" type="submit">
                                <i class="fas fa-search"></i> Search
                            </button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select class="form-select custom-select" name="sort_by" id="sort_by">
                            <option selected>Sort by</option>
                            <option value="recent">Recently Added</option>
                            <option value="az">A-Z</option>
                            <option value="za">Z-A</option>
                        </select>
                    </div>
                </div>
            </div>
        </form>


        <div class="row">
            <!-- Recipe Grid -->
            <div class="col-md-12">
                <div id="recipeResults" class="row row-cols-1 row-cols-md-3 g-4">
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
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
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>

<?php include_once "assets/footer.php"; ?>

