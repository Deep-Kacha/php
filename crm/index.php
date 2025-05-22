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


// $recipeQuery = "SELECT `recipe_id`,`title`,`recipe_image` FROM `recipes`";
$result = $con->query($recipeQuery);
?>

<!DOCTYPE html>
<lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cooking Recipes</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href = "https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/css/bootstrap.min.css" rel="stylesheet">
    <script src = "https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
    <script src = "https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/js/bootstrap.min.js"></script>
    <style>
        body{
            color : #333333 ;
            background-color: #f5f5f5 !important;
            /* background-color:rgb(172, 75, 75) !important;   */
            font-weight: 400;
        }

        /* recipe card */
        .recipe-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            height: 350px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .block-quick-links span {
            background: #fafafa;
            border: 1px solid #eee;
            border-radius: 3px;
            color: #2F820C;
            display: inline-block;
            font-size: 15px;
            font-weight: 700;
            line-height: 1.2;
            padding: 4px 8px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%,-50%);
            z-index: 2;
        }

        a {
            text-decoration: none;
            color : inherit;
        }

        .recipe-card img {
            width: 100%;
            height: 280px;
            object-fit:cover;
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

        .recipe-card-text {
            font-size: 1rem;
            color: #555;
        }

        .recipe-card:hover {
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        .pagination {
            justify-content: center;
        }
    </style>
</head>
<body>
    <div class="container my-5">
        <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
        <?php
            while($row = mysqli_fetch_assoc($result)){ ?>
                <a href = "/crm/recipe.php?rid=<?php echo $row['recipe_id'];?>">
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
</body>
</html>

<?php include_once "assets/footer.php"; ?>