<?php

session_start();
include_once("assets/functions.php");
include_once 'database.php';

if(isset($_SESSION['userLogin']) && $_SESSION['userLogin'] == true && isset($_POST['following_id'])) {
    
    $follower_id = $_SESSION['userID']; // Current logged in user
    $following_id = $_POST['following_id']; // User to follow/unfollow
    
    // Check if already following
    $check_follow = "SELECT * FROM `followers` WHERE `follower_id` = $follower_id AND `following_id` = $following_id";
    $follow_result = $con->query($check_follow);
    
    if($follow_result->num_rows > 0) {
        // Already following, so unfollow
        $unfollow_query = "DELETE FROM `followers` WHERE `follower_id` = $follower_id AND `following_id` = $following_id";
        
        if($con->query($unfollow_query)) {
            echo 'unfollowed';
        } else {
            echo 'error';
        }
    } else {
        // Not following, so follow
        $follow_query = "INSERT INTO `followers` (`follower_id`, `following_id`) VALUES ($follower_id, $following_id)";
        
        if($con->query($follow_query)) {
            echo 'followed';
        } else {
            echo 'error';
        }
    }
} else {
    echo 'login_required';
}
?>