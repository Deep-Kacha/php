<?php include("assets/navbar.php"); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipes - Cooking Recipes</title>

    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <style>
        /* Card Styles */
        .recipe-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .recipe-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .recipe-card-body {
            padding: 15px;
        }

        .recipe-title {
            font-size: 1.25rem;
            font-weight: bold;
        }

        .recipe-category {
            font-size: 1rem;
            color: #555;
        }

        .recipe-card:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        /* Pagination Styling */
        .pagination {
            justify-content: center;
        }
    </style>
</head>

<body>
    <!-- Main Recipes Section -->
    <section class="container my-5">
        <h1 class="text-center mb-4">Browse Recipes</h1>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
            <!-- Recipe Card 1 -->
            <div class="col">
                <div class="recipe-card">
                    <img src="assets/images/cake.jpeg" alt="Recipe Image 1">
                    <div class="recipe-card-body">
                        <h5 class="recipe-title">Recipe Title 1</h5>
                        <p class="recipe-category">Category: Vegetarian</p>
                    </div>
                </div>
            </div>

            <!-- Recipe Card 2 -->
            <div class="col">
                <div class="recipe-card">
                    <img src="assets/images/paneer.jpeg" alt="Recipe Image 2">
                    <div class="recipe-card-body">
                        <h5 class="recipe-title">Recipe Title 2</h5>
                        <p class="recipe-category">Category: Vegan</p>
                    </div>
                </div>
            </div>

            <!-- Recipe Card 3 -->
            <div class="col">
                <div class="recipe-card">
                    <img src="assets/images/pani-puri-recipe.jpeg" alt="Recipe Image 3">
                    <div class="recipe-card-body">
                        <h5 class="recipe-title">Recipe Title 3</h5>
                        <p class="recipe-category">Category: Gluten-Free</p>
                    </div>
                </div>
            </div>

            <!-- Recipe Card 4 -->
            <div class="col">
                <div class="recipe-card">
                    <img src="assets\images\samosa-0-1152x1536.jpeg" alt="Recipe Image 4">
                    <div class="recipe-card-body">
                        <h5 class="recipe-title">Recipe Title 4</h5>
                        <p class="recipe-category">Category: Vegan</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pagination Section -->
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <li class="page-item">
                    <a class="page-link" href="#" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </section>


    <!-- Bootstrap 5 JS (Popper and Bootstrap JS) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>
</html>

<?php include("assets/footer.php"); ?>