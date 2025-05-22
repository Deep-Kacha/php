<?php include_once 'navbar.php';


$review = "SELECT 
    r.id AS review_id,
    r.review,
    r.created_at AS review_created_at,
    u.first_name,
    u.last_name,
    rec.title AS recipe_title
FROM reviews r
LEFT JOIN users u ON r.user_id = u.id
LEFT JOIN recipes rec ON r.recipe_id = rec.recipe_id
ORDER BY r.created_at DESC";

$review_result = $con->query($review);

// $review = mysqli_fetch_assoc($review_result);
// print_r($review);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Admin Panel - Comments</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        body {
            margin: 0;
            padding: 0;
            background-color: #f1f1f1;
        }
        .container {
            display: flex;
            min-height: 100vh;
        }
        .content {
            flex: 1;
            padding: 30px;
        }
        .header {
            margin-bottom: 30px;
        }
        .header h1 {
            font-size: 28px;
            color: #333;
        }
        .comment-card {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0px 4px 10px rgba(0,0,0,0.05);
            transition: transform 0.2s ease;
        }
        .comment-card:hover {
            transform: translateY(-5px);
        }
        .comment-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .comment-author {
            font-weight: 600;
            color: #222;
            font-size: 18px;
        }
        .comment-date {
            font-size: 14px;
            color: #888;
        }
        .comment-content {
            margin: 15px 0;
            font-size: 16px;
            color: #555;
            line-height: 1.6;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        .comment-info {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
        }
        .comment-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }
        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        .btn-danger {
            background-color: #e74c3c;
            color: #fff;
        }
        .btn-danger:hover {
            background-color: #c0392b;
        }
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 30px;
            gap: 8px;
        }
        .pagination a {
            padding: 10px 18px;
            text-decoration: none;
            color: #555;
            border: 1px solid #ddd;
            border-radius: 6px;
            transition: background-color 0.3s, color 0.3s;
        }
        .pagination a:hover {
            background-color: #4CAF50;
            color: #fff;
        }
        .pagination a.active {
            background-color: #4CAF50;
            color: #fff;
            border-color: #4CAF50;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="content">

        <div class="header">
            <h1>Comments Management</h1>
        </div>

        <?php while($row = mysqli_fetch_assoc($review_result)) { ?>
            <div class="comment-card">
                <div class="comment-header">
                    <span class="comment-author"><?php echo $row['first_name'] . " " . $row['last_name']; ?></span>
                    <span class="comment-date"><?php echo date("F j, Y", strtotime($row['review_created_at'])); ?></span>
                </div>
                <div class="comment-content">
                    <?php echo htmlspecialchars($row['review']); ?>
                </div>
                <div class="comment-info">
                    On: <strong><?php echo htmlspecialchars($row['recipe_title']); ?></strong>
                </div>
                <div class="comment-actions">
                    <a href="delete_comment.php?rid=<?php echo $row['review_id']; ?>">
                        <button class="btn btn-danger">Delete</button>
                    </a>         
                </div>
            </div>
        <?php } ?>
    </div>
</div>

</body>
</html>