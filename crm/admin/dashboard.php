<?php
    include_once 'navbar.php';
    // require('../assets/functions.php');

    // Check admin login
    adminLogin();

    // Database queries for dashboard statistics
    $recipeQuery = "SELECT COUNT(*) as total_recipes FROM `recipes`";
    $result = $con->query($recipeQuery);
    $recipeCount = mysqli_fetch_assoc($result)['total_recipes'];

    $userQuery = "SELECT COUNT(*) as total_users FROM `users`";
    $result = $con->query($userQuery);
    $userCount = mysqli_fetch_assoc($result)['total_users'];

    $categoryQuery = "SELECT COUNT(DISTINCT cuisin) as total_categories FROM `recipe_states`";
    $result = $con->query($categoryQuery);
    $categoryCount = mysqli_fetch_assoc($result)['total_categories'];

    // Recent recipes
    $recentRecipesQuery = "SELECT r.recipe_id, r.title, rs.cuisin, u.first_name, r.created_at 
                          FROM `recipes` r 
                          JOIN `recipe_states` rs ON r.recipe_id = rs.recipe_id 
                          JOIN `users` u ON r.user_id = u.id 
                          ORDER BY r.created_at DESC LIMIT 5";
    $recentRecipes = $con->query($recentRecipesQuery);

    // Top users
    $topUsersQuery = "SELECT u.first_name, u.last_name, COUNT(r.recipe_id) as recipe_count 
                     FROM `users` u 
                     JOIN `user_profiles` up ON u.id = up.user_id 
                     LEFT JOIN `recipes` r ON u.id = r.user_id 
                     GROUP BY u.id 
                     ORDER BY recipe_count DESC LIMIT 5";
    $topUsers = $con->query($topUsersQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Admin Panel - Dashboard</title> 
    <script src="js\jquery-3.7.1.min.js"></script>
    <script src="js\bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        a{
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
        .welcome-text {
            color: #333;
            font-size: 16px;
            margin-bottom: 10px;
        }
        .stats-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 20px;
        }
        .stat-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        .stat-value {
            font-size: 28px;
            font-weight: bold;
            margin: 10px 0;
            color: #4CAF50;
        }
        .stat-label {
            color: #666;
            font-size: 14px;
        }
        .card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }
        .card-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table th, table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        table th {
            background-color: #f8f8f8;
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
        .btn-warning {
            background-color: #FF9800;
            color: white;
        }
        .status-badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
        }
        .status-approved {
            background-color: #4CAF50;
            color: white;
        }
        .status-pending {
            background-color: #FF9800;
            color: white;
        }
        .status-rejected {
            background-color: #f44336;
            color: white;
        }
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }
        .action-card {
            background-color: #4CAF50;
            color: white;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            cursor: pointer;
            transition: transform 0.3s, background-color 0.3s;
        }
        .action-card:hover {
            transform: translateY(-5px);
            background-color: #388E3C;
        }
        .action-card h3 {
            margin: 0;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="content">
            <div class="header">
                <h1>Admin Dashboard</h1>
            </div>
            
            <div class="stats-container">
                <div class="stat-card">
                    <div class="stat-value"><?php echo $recipeCount; ?></div>
                    <div class="stat-label">Total Recipes</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value"><?php echo $userCount; ?></div>
                    <div class="stat-label">Registered Users</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value"><?php echo $categoryCount; ?></div>
                    <div class="stat-label">Recipe Categories</div>
                </div>
            </div>

            <div class="quick-actions">
                <a href="recipe_management_page.php" class="action-card">
                    <h3>Manage Recipes</h3>
                </a>
                <a href="user_management_page.php" class="action-card">
                    <h3>Manage Users</h3>
                </a>
            </div>
            
            <div class="card-grid">
                <div class="card">
                    <h2>Recent Recipes</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Recipe Name</th>
                                <th>Author</th>
                                <th>Date Added</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = mysqli_fetch_assoc($recentRecipes)) { ?>
                                <tr>
                                    <td><?php echo $row['title']; ?></td>
                                    <td><?php echo $row['first_name']; ?></td>
                                    <td><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                                    <td>
                                        <a href="delete_recipe.php?rid=<?php echo $row['recipe_id']; ?>">
                                            <button class="btn btn-danger">Delete</button>
                                        </a> 
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="card">
                    <h2>Top Contributors</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Full Name</th>
                                <th>Recipes</th>
                                <!-- <th>Action</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($user = mysqli_fetch_assoc($topUsers)) { ?>
                                <tr>
                                    <td><?php echo $user['first_name'] ." " . $user['last_name'];; ?></td>
                                    <td><?php echo $user['recipe_count']; ?></td>
                                    <!-- <td>
                                        <a href="user_details.php?username=<?php echo $user['username']; ?>" class="btn btn-edit">View</a>
                                    </td> -->
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</body>
</html>