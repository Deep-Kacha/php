<?php
    include("navbar.php");

    if (isset($_GET['uid'])) {
        $uid = $_GET['uid'];

        $delete_query = "DELETE FROM `users` WHERE `id` = '$uid'";

        if ($con->query($delete_query)) {
            echo "<script>alert('User deleted successfully!'); window.location.href='user_management_page.php';</script>";
        } else {
            echo "<script>alert('Error deleting user. Please try again later.'); window.location.href='user_management_page.php';</script>";
        }
    }
?>
