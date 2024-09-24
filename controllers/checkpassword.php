<?php
session_start();
require "../models/changepasswordModel.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_SESSION['email']; // Get the email from the session
    $currentPassword = $_POST['currentPassword'];
    
    // Call the function to verify password
    $result = changePassword($email, $currentPassword, 'dummy'); // New password is dummy because we only check the current password
    if ($result === "Current password is incorrect.") {
        echo 'incorrect';
    } else {
        echo 'correct';
    }
}
?>
