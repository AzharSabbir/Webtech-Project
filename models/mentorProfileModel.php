<?php
// mentorProfileModel.php

function getMentorDataByEmail($email) {
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

    // Use a prepared statement to fetch data only for mentors
    $stmt = $conn->prepare("SELECT username, phone, gender FROM users WHERE email = ? AND status = 'mentor'");

    // Bind parameters (email)
    $stmt->bind_param("s", $email);

    // Execute the statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Fetch the data if the mentor exists
    if ($result->num_rows > 0) {
        $mentorData = $result->fetch_assoc();
    } else {
        $mentorData = null; // Return null if no mentor found
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();

    return $mentorData;
}

function updateMentorData($email, $username, $phone, $gender) {
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

    // Use a prepared statement to update mentor data securely
    $stmt = $conn->prepare("UPDATE users SET username = ?, phone = ?, gender = ? WHERE email = ? AND status = 'mentor'");

    // Bind parameters
    $stmt->bind_param("ssss", $username, $phone, $gender, $email);

    // Execute the statement
    $result = $stmt->execute();

    // Close statement and connection
    $stmt->close();
    $conn->close();

    return $result; // Returns true if the update was successful, false otherwise
}
?>
