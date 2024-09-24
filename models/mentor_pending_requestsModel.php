<?php
// mentor_pending_requestsModel.php

function getPendingRequests($mentorEmail) {
    // Database connection
    $servername = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "course enroll project";

    $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch pending requests assigned to the mentor that haven't been processed yet
    $stmt = $conn->prepare("SELECT request_id, student_email, request_description, PreviousStatus FROM pending_requests WHERE PreviousStatus = 'No'");
    $stmt->execute();
    $result = $stmt->get_result();

    $requests = $result->fetch_all(MYSQLI_ASSOC);

    // Close the connection
    $stmt->close();
    $conn->close();

    return $requests;
}
