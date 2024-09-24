<?php
session_start();
require "../models/changepasswordModel.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    // Initialize error and success messages
    $err = $success = '';

    if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
        $err = "All fields are required.";
    } elseif ($newPassword !== $confirmPassword) {
        $err = "New password and confirmation do not match.";
    } else {
        $userEmail = $_SESSION['email']; // Ensure email is set in session
        $result = changePassword($userEmail, $currentPassword, $newPassword);
        if (strpos($result, "successfully") !== false) {
            $success = $result;
        } else {
            $err = $result;
        }
    }

    header('Location: ../views/changepassword.php?err=' . urlencode($err) . '&success=' . urlencode($success));
    exit;
}
?>
