<?php
// loginMode.php

function matchCredentials($email, $password) {
    $servername = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "course enroll project";

    // Create connection
    $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Use a prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT status FROM users WHERE email = ? AND password = ?");
    
    // Bind parameters (ss means both are strings)
    $stmt->bind_param("ss", $email, $password); // $email and $password are inserted into the ? placeholders

    // Execute the statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Check if any row exists
    if ($result->num_rows > 0) {
        // Fetch the status
        $row = $result->fetch_assoc();
        $status = $row['status']; // Assuming 'status' column contains 'mentor' or 'student'
        return $status; // Return the user status
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();

    return null; // Return null if no user is found
}

?>
