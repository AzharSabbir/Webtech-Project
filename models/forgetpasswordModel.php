<?php

function checkEmailExists($email) {
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

    // Use a prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT Email FROM users WHERE Email = ?");
    
    // Bind parameters
    $stmt->bind_param("s", $email);

    // Execute the statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Check if any row exists
    $emailExists = $result->num_rows > 0;

    // Close statement and connection
    $stmt->close();
    $conn->close();

    return $emailExists;
}
?>
