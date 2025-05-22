<?php 
try {
    $con = mysqli_connect("localhost", "root", "", "COOKING");
} catch (Exception $e) {
    echo "error in connecting database";
}

// $user = "CREATE TABLE users (
//     id INT PRIMARY KEY AUTO_INCREMENT,
//     first_name VARCHAR(50) NOT NULL,
//     last_name VARCHAR(50) NOT NULL,
//     email VARCHAR(150) UNIQUE NOT NULL,
//     password VARCHAR(255) NOT NULL,
//     role ENUM('admin', 'user') DEFAULT 'user',
//     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
// )";

// $user_profiles = "CREATE TABLE user_profiles (
//     user_id INT PRIMARY KEY,
//     profile_picture VARCHAR(255) NULL,
//     bio TEXT NULL,
//     location VARCHAR(200),
//     cuisine_preferences TEXT NULL,
//     dietary_preferences TEXT NULL,
//     FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
// )";

// $password_token = "CREATE TABLE `password_token` (
//     `id` int AUTO_INCREMENT PRIMARY KEY,
//     `email` varchar(255) NOT NULL,
//     `otp` int DEFAULT NULL,
//     `created_at` datetime NOT NULL,
//     `expires_at` datetime NOT NULL,
//     `otp_attempts` int NOT NULL,
//     `last_resend` timestamp NULL DEFAULT CURRENT_TIMESTAMP
// ) ";

// $settings = "CREATE TABLE `settings` (
//     `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY (`id`)
//     `site_title` VARCHAR(100) NOT NULL ,
//     `site_description` TEXT NOT NULL ,
//     `site_logo` VARCHAR(300) NOT NULL ,
//     `youtube` VARCHAR(200) NOT NULL ,
//     `facebook` VARCHAR(200) NOT NULL ,
//     `twitter` VARCHAR(200) NOT NULL ,
//     `instagram` VARCHAR(200) NOT NULL ,
//  );"




// $recipes = "CREATE TABLE recipes (
//     recipe_id INT AUTO_INCREMENT PRIMARY KEY,
//     user_id INT,
//     title VARCHAR(255) NOT NULL,
//     description TEXT,
//     instructions JSON,
//     ingredients JSON,
//     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//     FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
// );";



// $recipe_states = "CREATE TABLE recipe_states (
// recipe_states_id INT AUTO_INCREMENT PRIMARY KEY,
// recipe_id INT,
// cooking_time INT,
// prep_time INT,
// course JSON,
// diet JSON,
// cuisin JSON,
// FOREIGN KEY (recipe_id) REFERENCES recipes(recipe_id) ON DELETE CASCADE
// );";


// $contact_us = "CREATE TABLE contact_us (
//     contact_id INT PRIMARY KEY AUTO_INCREMENT,
//     user_id INT,
//     name VARCHAR(255) NULL,
//     email VARCHAR(255) NULL,
//     message TEXT NULL,
//     FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
// )";

// $review = "CREATE TABLE reviews (
//     id INT AUTO_INCREMENT PRIMARY KEY,
//     user_id INT,
//     recipe_id INT,
//     rating INT CHECK (rating BETWEEN 1 AND 5),
//     review TEXT NOT NULL,
//     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//     FOREIGN KEY (user_id) REFERENCES users(id),
//     FOREIGN KEY (recipe_id) REFERENCES recipes(recipe_id)
// );";

// $favourite = "CREATE TABLE `favorites` (
//     `id` INT AUTO_INCREMENT PRIMARY KEY,
//     `user_id` INT NOT NULL,
//     `recipe_id` INT NOT NULL,
//     `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//     FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
//     FOREIGN KEY (`recipe_id`) REFERENCES `recipes`(`recipe_id`) ON DELETE CASCADE
// );";

// $user_follows = "CREATE TABLE `followers` (
//     `id` INT AUTO_INCREMENT PRIMARY KEY,
//     `follower_id` int(11) NOT NULL,
//     `following_id` int(11) NOT NULL,
//     `followed_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//     UNIQUE (follower_id, following_id),

//     FOREIGN KEY (follower_id) REFERENCES users(id) ON DELETE CASCADE,
//     FOREIGN KEY (following_id) REFERENCES users(id) ON DELETE CASCADE
// );";

// if($con->query($user_follows)){
//     echo "table created successfully";
// }

?>