<?php
session_start();
require "../models/RegistrationModel.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    $registerAs = $_POST['register_as'];
    $username = $_POST['username']; // Capture the username

    // Username validation
    if (empty($username)) {
        $_SESSION['err8'] = "Username cannot be empty.";
        header("Location: ../views/registration.php");
        exit();
    } elseif (!preg_match("/^[a-zA-Z0-9_]{3,20}$/", $username)) { // Validate username format
        $_SESSION['err8'] = "Invalid username. Only letters, numbers, and underscores allowed. Length: 3-20.";
        header("Location: ../views/registration.php");
        exit();
    }

    // Email validation with regular expression
    $emailPattern = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";

    // Input validation
    if (empty($email)) {
        $_SESSION['err1'] = "Email cannot be empty.";
        header("Location: ../views/registration.php");
        exit();
    } elseif (!preg_match($emailPattern, $email)) { // Validate email format
        $_SESSION['err1'] = "Invalid email format.";
        header("Location: ../views/registration.php");
        exit();
    } elseif (empty($phone)) {
        $_SESSION['err2'] = "Phone number cannot be empty.";
        header("Location: ../views/registration.php");
        exit();
    } elseif (empty($gender)) {
        $_SESSION['err3'] = "Please select your gender.";
        header("Location: ../views/registration.php");
        exit();
    } elseif (empty($password)) {
        $_SESSION['err4'] = "Password cannot be empty.";
        header("Location: ../views/registration.php");
        exit();
    } elseif (strlen($password) < 8) { // Check password length
        $_SESSION['err4'] = "Password must be at least 8 characters long.";
        header("Location: ../views/registration.php");
        exit();
    } elseif ($password !== $confirmPassword) {
        $_SESSION['err5'] = "Passwords do not match. Please try again.";
        header("Location: ../views/registration.php");
        exit();
    } elseif (empty($registerAs)) { // Validation for the "Register As" field
        $_SESSION['err6'] = "Please select whether you are registering as a student or mentor.";
        header("Location: ../views/registration.php");
        exit();
    } else {
        // Register the user
        if (registerUser($email, $phone, $gender, $password, $registerAs, $username)) { // Pass "username" to the function
            $_SESSION['success'] = "Registration successful! Please log in.";
            header("Location: ../views/login.php");
            exit();
        } else {
            $_SESSION['err7'] = "Registration failed. Email or username already exists.";
            header("Location: ../views/registration.php");
            exit();
        }
    }
}
?>
