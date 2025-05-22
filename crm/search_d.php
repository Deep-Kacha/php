<?php
include("assets/navbar.php");

// Initialize variables
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 9; // 9 recipes per page (3x3 grid)
$offset = ($page - 1) * $limit;
$search = isset($_GET['search']) ? $con->real_escape_string($_GET['search']) : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'recent';
$category = isset($_GET['category']) ? $con->real_escape_string($_GET['category']) : '';
$cuisine = isset($_GET['cuisine']) ? $con->real_escape_string($_GET['cuisine']) : '';
$vegetarian = isset($_GET['vegetarian']) ? 1 : 0;
$vegan = isset($_GET['vegan']) ? 1 : 0;
$glutenFree = isset($_GET['glutenFree']) ? 1 : 0;
$cookingTime = isset($_GET['cookingTime']) ? $con->real_escape_string($_GET['cookingTime']) : '';

// Get all categories for the filter
$categoryQuery = "SELECT DISTINCT category FROM recipes ORDER BY category";
$categoryResult = $con->query($categoryQuery);

// Get all cuisines for the filter
$cuisineQuery = "SELECT DISTINCT cuisine FROM recipes ORDER BY cuisine";
$cuisineResult = $con->query($cuisineQuery);

// Build the WHERE clause for filtering
$whereClause = [];
$params = [];

if (!empty($search)) {
    $whereClause[] = "(title LIKE ? OR ingredients LIKE ? OR description LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

if (!empty($category) && $category != 'All') {
    $whereClause[] = "category = ?";
    $params[] = $category;
}

if (!empty($cuisine) && $cuisine != 'All') {
    $whereClause[] = "cuisine = ?";
    $params[] = $cuisine;
}

if ($vegetarian) {
    $whereClause[] = "is_vegetarian = 1";
}

if ($vegan) {
    $whereClause[] = "is_vegan = 1";
}

if ($glutenFree) {
    $whereClause[] = "is_gluten_free = 1";
}

if (!empty($cookingTime)) {
    switch ($cookingTime) {
        case 'under30':
            $whereClause[] = "cooking_time <= 30";
            break;
        case '30to60':
            $whereClause[] = "cooking_time > 30 AND cooking_time <= 60";
            break;
        case 'over60':
            $whereClause[] = "cooking_time > 60";
            break;
    }
}

// Combine WHERE clauses
$whereSQL = '';
if (!empty($whereClause)) {
    $whereSQL = "WHERE " . implode(" AND ", $whereClause);
}

// Build the ORDER BY clause for sorting
$orderBy = "";
switch ($sort) {
    case 'popular':
        $orderBy = "ORDER BY view_count DESC";
        break;
    case 'recent':
        $orderBy = "ORDER BY created_at DESC";
        break;
    case 'az':
        $orderBy = "ORDER BY title ASC";
        break;
    case 'za':
        $orderBy = "ORDER BY title DESC";
        break;
    default:
        $orderBy = "ORDER BY created_at DESC";
}

// Count total records for pagination
$countQuery = "SELECT COUNT(*) as total FROM recipes $whereSQL";
$stmt = $con->prepare($countQuery);

if (!empty($params)) {
    $types = str_repeat('s', count($params));
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$countResult = $stmt->get_result();
$totalRecords = $countResult->fetch_assoc()['total'];
$totalPages = ceil($totalRecords / $limit);

// Get filtered recipes
$recipeQuery = "SELECT recipe_id, title, recipe_image FROM recipes $whereSQL $orderBy LIMIT ? OFFSET ?";
$stmt = $con->prepare($recipeQuery);

if (!empty($params)) {
    $types = str_repeat('s', count($params)) . 'ii';
    $bindParams = array_merge($params, [$limit, $offset]);
    $stmt->bind_param($types, ...$bindParams);
} else {
    $stmt->bind_param('ii', $limit, $offset);
}

$stmt->execute();
$result = $stmt->get_result();
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
            background-color: #fff ;
            padding: 30px ;
            border-radius: 10px ;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1) ;
            margin-bottom: 30px ;
        }

        .filter-card {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
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
        
        a {
            text-decoration: none;
            color: inherit;
        }
        
        .pagination .page-item.active .page-link {
            background-color: #eb4a36;
            border-color: #eb4a36;
        }
        
        .pagination .page-link {
            color: #333;
        }
        
        .pagination .page-link:hover {
            color: #eb4a36;
        }
        
        .no-results {
            text-align: center;
            padding: 50px 0;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

    <div class="container my-5">
        <!-- Search Section -->
        <form method="GET" action="search.php" id="searchForm">
            <div class="search-container">
                <div class="row">
                    <div class="col-md-8">
                        <div class="input-group mb-3">
                            <input type="text" name="search" class="form-control search-input" placeholder="Search recipes..." value="<?php echo htmlspecialchars($search); ?>">
                            <button class="btn search-button" type="submit">
                                <i class="fas fa-search"></i> Search
                            </button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select class="form-select custom-select" name="sort" onchange="document.getElementById('searchForm').submit()">
                            <option value="recent" <?php echo ($sort == 'recent') ? 'selected' : ''; ?>>Recently Added</option>
                            <option value="popular" <?php echo ($sort == 'popular') ? 'selected' : ''; ?>>Most Popular</option>
                            <option value="az" <?php echo ($sort == 'az') ? 'selected' : ''; ?>>A-Z</option>
                            <option value="za" <?php echo ($sort == 'za') ? 'selected' : ''; ?>>Z-A</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Filters Sidebar -->
                <div class="col-md-3">
                    <!-- Categories Filter -->
                    <div class="filter-card">
                        <h5 class="mb-3">Categories</h5>
                        <div class="d-flex flex-wrap">
                            <a href="javascript:void(0)" onclick="setCategory('All')" class="category-badge <?php echo (empty($category) || $category == 'All') ? 'active-filter' : ''; ?>">All</a>
                            <?php while($catRow = mysqli_fetch_assoc($categoryResult)): ?>
                                <a href="javascript:void(0)" onclick="setCategory('<?php echo $catRow['category']; ?>')" class="category-badge <?php echo ($category == $catRow['category']) ? 'active-filter' : ''; ?>">
                                    <?php echo $catRow['category']; ?>
                                </a>
                            <?php endwhile; ?>
                        </div>
                        <input type="hidden" name="category" id="categoryInput" value="<?php echo htmlspecialchars($category); ?>">
                    </div>

                    <!-- Cuisine Filter -->
                    <div class="filter-card">
                        <h5 class="mb-3">Cuisine</h5>
                        <div class="d-flex flex-wrap">
                            <a href="javascript:void(0)" onclick="setCuisine('All')" class="category-badge <?php echo (empty($cuisine) || $cuisine == 'All') ? 'active-filter' : ''; ?>">All</a>
                            <?php while($cuisineRow = mysqli_fetch_assoc($cuisineResult)): ?>
                                <a href="javascript:void(0)" onclick="setCuisine('<?php echo $cuisineRow['cuisine']; ?>')" class="category-badge <?php echo ($cuisine == $cuisineRow['cuisine']) ? 'active-filter' : ''; ?>">
                                    <?php echo $cuisineRow['cuisine']; ?>
                                </a>
                            <?php endwhile; ?>
                        </div>
                        <input type="hidden" name="cuisine" id="cuisineInput" value="<?php echo htmlspecialchars($cuisine); ?>">
                    </div>

                    <!-- Dietary Preferences -->
                    <div class="filter-card">
                        <h5 class="mb-3">Dietary Preferences</h5>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="vegetarian" id="vegetarian" <?php echo $vegetarian ? 'checked' : ''; ?> onchange="this.form.submit()">
                            <label class="form-check-label" for="vegetarian">Vegetarian</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="vegan" id="vegan" <?php echo $vegan ? 'checked' : ''; ?> onchange="this.form.submit()">
                            <label class="form-check-label" for="vegan">Vegan</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="glutenFree" id="glutenFree" <?php echo $glutenFree ? 'checked' : ''; ?> onchange="this.form.submit()">
                            <label class="form-check-label" for="glutenFree">Gluten Free</label>
                        </div>
                    </div>

                    <!-- Cooking Time -->
                    <div class="filter-card">
                        <h5 class="mb-3">Cooking Time</h5>
                        <div class="d-flex flex-wrap">
                            <a href="javascript:void(0)" onclick="setCookingTime('under30')" class="category-badge <?php echo ($cookingTime == 'under30') ? 'active-filter' : ''; ?>">Under 30 mins</a>
                            <a href="javascript:void(0)" onclick="setCookingTime('30to60')" class="category-badge <?php echo ($cookingTime == '30to60') ? 'active-filter' : ''; ?>">30-60 mins</a>
                            <a href="javascript:void(0)" onclick="setCookingTime('over60')" class="category-badge <?php echo ($cookingTime == 'over60') ? 'active-filter' : ''; ?>">Over 60 mins</a>
                            <?php if (!empty($cookingTime)): ?>
                                <a href="javascript:void(0)" onclick="setCookingTime('')" class="category-badge">Clear</a>
                            <?php endif; ?>
                        </div>
                        <input type="hidden" name="cookingTime" id="cookingTimeInput" value="<?php echo htmlspecialchars($cookingTime); ?>">
                    </div>
                </div>
                
                <!-- Recipe Grid -->
                <div class="col-md-9">
                    <?php if ($result->num_rows > 0): ?>
                        <div class="row row-cols-1 row-cols-md-3 g-4">
                            <?php while($row = mysqli_fetch_assoc($result)): ?>
                                <div class="col">
                                    <a href="/crm/recipe.php?rid=<?php echo $row['recipe_id']; ?>">
                                        <div class="recipe-card">
                                            <img src="assets/images/recipes/<?php echo $row['recipe_image']; ?>" class="img-fluid" alt="<?php echo htmlspecialchars($row['title']); ?>">
                                            <div class="recipe-card-body">
                                                <h5 class="recipe-card-title"><?php echo htmlspecialchars($row['title']); ?></h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php endwhile; ?>
                        </div>

                        <!-- Pagination -->
                        <?php if ($totalPages > 1): ?>
                            <nav class="mt-5">
                                <ul class="pagination justify-content-center">
                                    <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                                        <a class="page-link" href="<?php echo ($page <= 1) ? '#' : '?'.http_build_query(array_merge($_GET, ['page' => $page-1])); ?>">Previous</a>
                                    </li>
                                    
                                    <?php for($i = 1; $i <= $totalPages; $i++): ?>
                                        <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                                            <a class="page-link" href="?<?php echo http_build_query(array_merge($_GET, ['page' => $i])); ?>"><?php echo $i; ?></a>
                                        </li>
                                    <?php endfor; ?>
                                    
                                    <li class="page-item <?php echo ($page >= $totalPages) ? 'disabled' : ''; ?>">
                                        <a class="page-link" href="<?php echo ($page >= $totalPages) ? '#' : '?'.http_build_query(array_merge($_GET, ['page' => $page+1])); ?>">Next</a>
                                    </li>
                                </ul>
                            </nav>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="no-results">
                            <h3>No recipes found</h3>
                            <p>Try adjusting your search criteria or filters.</p>
                            <a href="search.php" class="btn search-button mt-3">Clear All Filters</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </form>
    </div>

    <?php include_once "assets/footer.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function setCategory(category) {
            document.getElementById('categoryInput').value = category;
            document.getElementById('searchForm').submit();
        }
        
        function setCuisine(cuisine) {
            document.getElementById('cuisineInput').value = cuisine;
            document.getElementById('searchForm').submit();
        }
        
        function setCookingTime(time) {
            document.getElementById('cookingTimeInput').value = time;
            document.getElementById('searchForm').submit();
        }
    </script>
</body>
</html>