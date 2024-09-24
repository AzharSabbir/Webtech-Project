<?php

function registerUser($email, $phone, $gender, $password) {
    $servername = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "mydb";

    // Create connection
    $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if email already exists
    $sql = "SELECT email FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // Email already exists
        $conn->close();
        return false;
    } else {
        // Insert the new user with email, phone, gender, and password
        $sql = "INSERT INTO users (Email, Phone, Gender, Password) VALUES ('$email', '$phone', '$gender', '$password')";
        $success = mysqli_query($conn, $sql);

        $conn->close();
        return $success;
    }
}
?>
