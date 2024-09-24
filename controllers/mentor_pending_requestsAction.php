<?php
// mentor_pending_requestsAction.php

session_start();

if (!isset($_SESSION['email'])) {
    header('Location: ../views/login.php');
    exit;
}

// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $request_id = $_POST['request_id'];
    $action = $_POST['action'];
    $reason = isset($_POST['reason']) ? $_POST['reason'] : null;

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

    // Update the request status based on action
    if ($action === 'accept') {
        // Update the pending_requests table
        $stmt = $conn->prepare("UPDATE pending_requests SET PreviousStatus = 'Yes' WHERE request_id = ?");
        $stmt->bind_param("i", $request_id);
        $stmt->execute();

        // Update the enrollments table status to 'accepted'
        $enrollmentStmt = $conn->prepare("UPDATE enrollments SET status = 'accepted' WHERE course_id = ? AND student_email = (SELECT student_email FROM pending_requests WHERE request_id = ?)");
        $enrollmentStmt->bind_param("ii", $course_id, $request_id);
        $enrollmentStmt->execute();

        $status = 'accepted';
    } elseif ($action === 'reject') {
        // Update the pending_requests table
        $stmt = $conn->prepare("UPDATE pending_requests SET PreviousStatus = 'Rejected', rejection_reason = ? WHERE request_id = ?");
        $stmt->bind_param("si", $reason, $request_id);
        $stmt->execute();

        // Update the enrollments table status to 'rejected'
        $enrollmentStmt = $conn->prepare("UPDATE enrollments SET status = 'rejected' WHERE course_id = ? AND student_email = (SELECT student_email FROM pending_requests WHERE request_id = ?)");
        $enrollmentStmt->bind_param("ii", $course_id, $request_id);
        $enrollmentStmt->execute();

        $status = 'rejected';
    }

    // Close the statements
    $stmt->close();
    if (isset($enrollmentStmt)) {
        $enrollmentStmt->close();
    }

    // Redirect back to the page with a status message
    header('Location: ../views/mentor_pending_requests.php?status=' . $status);
    exit;
}
