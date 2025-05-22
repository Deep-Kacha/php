<?php
    include("navbar.php");

    if (isset($_GET['rid'])) {
        $rid = $_GET['rid'];
        $delete = "DELETE FROM reviews WHERE `id` = $rid";


        if ($con->query($delete)) {
            echo "<script>alert('Comment deleted successfully!'); window.location.href='comments_management_page.php';</script>";
        } else {
            echo "<script>alert('Error deleting Comment. Please try again later.'); window.location.href='comments_management_page.php';</script>";
        }
    }
?>
