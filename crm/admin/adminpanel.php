<?php
    include_once 'navbar.php';
    // require('../assets/functions.php');

    $recipeQuery = "SELECT * FROM `recipes` r JOIN `recipe_states` rs ON r.recipe_id = rs.recipe_id";
    $result = $con->query($recipeQuery);
    // $row = mysqli_fetch_assoc($result);

    $select_user = "SELECT * FROM `users` u JOIN `user_profiles` up ON u.id = up.user_id";
    $user_result = $con->query(($select_user));
    $user = mysqli_fetch_assoc($user_result); 

    adminLogin(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Admin Panel - Dashboard</title> 
    <script src="js\jquery-3.7.1.min.js"></script>
    <script src="js\jquery.validate.js"></script>
    <script src="js\additional-methods.js"></script>
    <script src="js\bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#add_recipe").validate({
                rules: {
                    recipe_name:{
                        required: true,
                    },
                    Category:{
                        required: true,
                    },
                    prepTime: {
                        required: true,
                        number: true,
                        min: 1,
                    },
                    cookingTime: {
                        required: true,
                        number: true,
                        min: 1,
                    },
                    serving: {
                        required: true,
                        number: true,
                        min: 1,
                    },
                    ingred: {
                        required: true,
                    },
                    inst: {
                        required: true,
                    },
                    rimg: {
                        required: true,
                        url: true,
                    }
                },
                messages: {
                    recipe_name:{
                        required: "Please enter valid recipe name",
                    },
                    Category:{
                        required: "Please select the category",
                    },
                    prepTime: {
                        required: "Please enter preparation time.",
                        number: "Please enter a valid number.",
                        min: "Preparation time must be at least 1 minute.",
                    },
                    cookingTime: {
                        required: "Please enter cooking time.",
                        number: "Please enter a valid number.",
                        min: "Cooking time must be at least 1 minute.",
                    },
                    serving: {
                        required: "Please enter number of servings.",
                        number: "Please enter a valid number.",
                        min: "Servings must be at least 1."
                    },
                    ingred: {
                        required: "Please enter the ingredients.",
                    },
                    inst: {
                        required: "Please enter cooking instructions.",
                    },
                    rimg: {
                        required: "Please enter recipe image URL.",
                        url: "Please enter a valid URL.",
                    }
                }
            });
        });
    </script>
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        a{
            text-decoration: none;
            color : white;
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
        .error {
        color: red;
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
        .ingredients-list {
            padding: 0;
            list-style-position: inside;
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
                <h2>Recent Recipes</h2>
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
                        while($row = mysqli_fetch_assoc($result)){ ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $row['title']; ?></td>
                                <td><?php echo json_decode($row['cuisin']);?></td>
                                <td><?php echo $row['title']; ?></td>
                                <td><?php echo $row['created_at']; ?></td>
                                <td>
                                    <button class="btn btn-danger">Delete</button>
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