<?php
include_once('assets/navbar.php');

if (isset($_GET['email']) && isset($_GET['token'])) {
    $email = $_GET['email'];
    $token = $_GET['token'];

    $sql = "SELECT * FROM `users` WHERE `email`='$email' AND `verification_token`='$token'";

    $count = $con->query($sql);
    $r = mysqli_fetch_assoc($count);
    if ($count->num_rows == 1) {
        if ($r['email_verified'] == 0) {
            $update = "UPDATE `users` SET `email_verified` = 1 WHERE `email` = '$email'";

            if ($con->query($update)) {
                $_SESSION['userLogin'] = true;
                $_SESSION['userID'] = $r['id'];
                $_SESSION['userEmail'] = $email;
                $id = $r['id'];

                $profile_q = "INSERT INTO `user_profiles`(`user_id`) VALUES ($id)";
                $con->query($profile_q);


                alert('success', 'Account Verification Successful');
                redirect('index.php');
                // setcookie('success', 'Account Verification Successful', time() + 5);
            } else {
                redirect('login.php');
                alert('error', 'Error in verifying email');
                // setcookie('error', 'Error in verifying email', time() + 5);
            }
            
        } else {
            alert('success', 'Email already verified');
            // setcookie('success', 'Email already verified', time() + 5);
        }
    } else {
        alert('error', 'Email not registered');
        // setcookie('error', 'Email not registered', time() + 5);
    }
}
?>
