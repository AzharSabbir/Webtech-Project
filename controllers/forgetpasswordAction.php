<?php
session_start();
require "../models/forgetpasswordModel.php"; // Make sure this path is correct

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    
    if (empty($email)) {
        $err = "Email is required.";
    } else {
        // Check if the email exists in the database
        if (checkEmailExists($email)) {
            $success = "An email has been sent with instructions to reset your password.";
            // You would typically send an email here with a reset link.
            // For demonstration, we're just showing a success message.
        } else {
            $err = "No account found with that email address.";
        }
    }
    
    // Redirect with the appropriate message
    header('Location: ../views/forgetpassword.php?err=' . urlencode($err) . '&success=' . urlencode($success));
    exit();
}
?>
