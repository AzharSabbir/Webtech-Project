<?php

function changePassword($email, $currentPassword, $newPassword) {
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

    // Verify current password
    $stmt = $conn->prepare("SELECT password FROM users WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($storedPassword);
    $stmt->fetch();
    $stmt->close();

    // Check if the password matches the stored hash
    if (!$storedPassword || !password_verify($currentPassword, $storedPassword)) {
        $conn->close();
        return "Current password is incorrect.";
    }

    // Hash new password and update
    $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE Email = ?");
    $stmt->bind_param("ss", $hashedNewPassword, $email);
    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        return "Password changed successfully.";
    } else {
        $stmt->close();
        $conn->close();
        return "Failed to change password.";
    }
}
?>
