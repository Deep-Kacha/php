<?php include_once 'navbar.php';

    $recipeQuery = "SELECT * FROM `recipes` r JOIN `recipe_states` rs ON r.recipe_id = rs.recipe_id";
    $result = $con->query($recipeQuery);
    $row = mysqli_fetch_assoc($result);

    $select_user = "SELECT * FROM `users` u JOIN `user_profiles` up ON u.id = up.user_id";
    $user_result = $con->query(($select_user));
    $user = mysqli_fetch_assoc($user_result); 

    $recentRecipesQuery = "SELECT r.recipe_id, r.title, rs.cuisin, u.first_name, r.created_at 
    FROM `recipes` r 
    JOIN `recipe_states` rs ON r.recipe_id = rs.recipe_id 
    JOIN `users` u ON r.user_id = u.id 
    ORDER BY r.created_at";
    $recentRecipes = $con->query($recentRecipesQuery);
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Admin Panel - Recipes</title>
    <style> 
        a{
            text-decoration: none;
            color : white;
        }
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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
        .card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
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
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }
        input, textarea, select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .search-bar {
            display: flex;
            margin-bottom: 20px;
        }
        .search-bar input {
            flex: 1;
            margin-right: 10px;
        }
        .filter-options {
            display: flex;
            margin-bottom: 20px;
        }
        .filter-options select {
            margin-right: 10px;
            width: auto;
        }
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .pagination a {
            color: black;
            padding: 8px 16px;
            text-decoration: none;
            border: 1px solid #ddd;
            margin: 0 4px;
        }
        .pagination a.active {
            background-color: #4CAF50;
            color: white;
            border: 1px solid #4CAF50;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="content">
            <div class="header">
                <h1>Recipes Management</h1>
            </div>

            <div class="card">
                <h2>Recipes</h2>
                <table>

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Recipe Name</th>
                            <th>Category</th>
                            <th>Author</th>
                            <th>Date Added</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                        $i = 1;
                        while($row = mysqli_fetch_assoc($recentRecipes)){ ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $row['title']; ?></td>
                                <td><?php echo json_decode($row['cuisin']);?></td>
                                <td><?php echo $row['first_name']; ?></td>
                                <td><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                                <td>         
                                    <a href="delete_recipe.php?rid=<?php echo $row['recipe_id']; ?>">
                                        <button class="btn btn-danger">Delete</button>
                                    </a>           
                                </td>
                            </tr>
                        <?php $i++;} ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>