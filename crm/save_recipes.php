<?php
session_start();
include_once("assets/functions.php");
include_once 'database.php';


// Check if recipe_id is provided
if (!isset($_POST['recipe_id']) || empty($_POST['recipe_id'])) {
    alert('error', 'Recipe ID is required');
    exit;
}


$recipe_id = $_POST['recipe_id'];
$user_id = $_SESSION['userID'];


$check_query = "SELECT * FROM `favorites` WHERE `user_id` = $user_id AND `recipe_id` = $recipe_id";
$check_result = $con->query($check_query);

if ($check_result->num_rows > 0) {
    $delete_query = "DELETE FROM `favorites` WHERE `user_id` = $user_id AND `recipe_id` = $recipe_id";
    
    if ($con->query($delete_query)) {
        echo 'removed';
    } 

} else {

    $save_query = "INSERT INTO `favorites` (`user_id`, `recipe_id`) VALUES ($user_id, $recipe_id)";
    
    if ($con->query($save_query)) {
        echo 'saved';
    } 

}


?>
