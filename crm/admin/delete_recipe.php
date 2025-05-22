<?php
    include("navbar.php");

    if (isset($_GET['rid'])) {
        $rid = $_GET['rid'];

        $delete_query = "DELETE FROM `recipes` WHERE `recipe_id` = '$rid'";

        if ($con->query($delete_query)) {
            echo "<script>alert('User deleted successfully!'); window.location.href='recipe_management_page.php';</script>";
        } else {
            echo "<script>alert('Error deleting user. Please try again later.'); window.location.href='recipe_management_page.php';</script>";
        }
    }
?>
