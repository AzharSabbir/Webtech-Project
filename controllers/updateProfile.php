<?php
require_once '../controllers/dashboardController.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_POST['user_id'];
    $username = $_POST['username'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];

    // Update user profile using the controller function
    $updateResult = updateUserProfile($userId, $username, $gender, $phone);

    if ($updateResult) {
        // Redirect to profile page or show success message
        header("Location: profile.php?success=Profile updated successfully");
    } else {
        // Handle update failure
        header("Location: profile.php?error=Failed to update profile");
    }
}
?>
