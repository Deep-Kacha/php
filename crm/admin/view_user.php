<?php 
    include("navbar.php");

    if(isset($_GET['uid'])){
        $uid = $_GET['uid'];
        $select_user = "SELECT * FROM `users` WHERE `id`='$uid'";
        $result = $con->query($select_user);
        $user_row = mysqli_fetch_assoc($result);
    }
?>
<?php include_once 'navbar.php';

$select = "SELECT * FROM `users`";
$result = $con->query($select);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Admin Panel - Users</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js\jquery-3.7.1.min.js"></script>
    <script src="js\jquery.validate.js"></script>
    <script src="js\additional-methods.js"></script>
    <script src="js\bundle.min.js"></script>
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        a {
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

        .card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
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

        .error {
            color: red;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }

        input,
        textarea,
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #f8f8f8;
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
    </style>
</head>

<body>
    <div class="container">
        <div class="content">
            <div class="card">
                <h2>View User</h2>
                <div class="form-group">
                    <label for="first-name">First Name</label>
                    <input type="text" id="first-name" value="<?php echo $user_row['first_name']; ?>" readonly class="form-control">
                </div>

                <div class="form-group">
                    <label for="last-name">Last Name</label>
                    <input type="text" id="last-name" value="<?php echo $user_row['last_name']; ?>" readonly class="form-control">
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" value="<?php echo $user_row['email']; ?>" readonly class="form-control">
                </div>

                <div class="form-group">
                    <label for="role">Role</label>
                    <input type="text" id="role" value="<?php echo $user_row['role']; ?>" readonly class="form-control">
                </div>
            </div>
        </div>
    </div>
</body>

</html>
