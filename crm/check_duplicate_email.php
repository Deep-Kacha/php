<?php
include_once 'database.php';

if (isset($_GET['email1'])) {
    $email = $_GET['email1'];
    $q = "SELECT * FROM `users` WHERE `email`='$email'";
    $result = $con->query($q);
    if ($result->num_rows > 0) {
        echo 'true';
    } else {
        echo 'false';
    }
}
