<?php
// LoginAction.php

session_start(); // Only one session start here
require "../models/LoginModel.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Clear previous errors
    $_SESSION['err1'] = $_SESSION['err2'] = $_SESSION['err3'] = '';

    // Validation
    if (empty($email)) {
        $_SESSION['err1'] = "Email is required";
        header("Location: ../views/login.php");
        exit();
    }
    if (empty($password)) {
        $_SESSION['err2'] = "Password is required";
        header("Location: ../views/login.php");
        exit();
    }

    // Attempt to match credentials and get user status
    $status = matchCredentials($email, $password);
    if ($status) {
        $_SESSION['email'] = $email; // Store email in session
        $_SESSION['status'] = $status; // Store status in session

        // Redirect based on status
        if ($status === 'mentor') {
            header("Location: ../views/mentor_pending_requests.php"); // Redirect to mentor dashboard
        } elseif ($status === 'student') {
            header("Location: ../views/dashboard.php"); // Redirect to student dashboard
        } else {
            $_SESSION['err3'] = "Invalid status!";
            header("Location: ../views/login.php");
        }
        exit();
    } else {
        // Set error message and redirect back to login
        $_SESSION['err3'] = "Invalid email or password!";
        header("Location: ../views/login.php");
        exit();
    }
}

?>
