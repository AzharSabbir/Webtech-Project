<?php
session_start();

if (!isset($_SESSION['email'])) {
    header('Location: ../views/login.php');
    exit;
}

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

// Get the form data
$requestId = $_POST['request_id'];
$action = $_POST['action'];

// Fetch student email from pending_requests
$stmt = $conn->prepare("SELECT student_email FROM pending_requests WHERE request_id = ?");
$stmt->bind_param("i", $requestId);
$stmt->execute();
$stmt->bind_result($studentEmail);
$stmt->fetch();
$stmt->close();

if ($action === 'accept') {
    // Update the status to 'accepted' in enrollments
    $stmt = $conn->prepare("UPDATE enrollments SET status = 'accepted' WHERE student_email = ?");
    $stmt->bind_param("s", $studentEmail);
    $stmt->execute();
    $stmt->close();
    
    // Update PreviousStatus in pending_requests to 'Yes'
    $stmt = $conn->prepare("UPDATE pending_requests SET PreviousStatus = 'Yes' WHERE request_id = ?");
    $stmt->bind_param("i", $requestId);
    $stmt->execute();
    $stmt->close();

    // Redirect with success message
    header("Location: ../views/mentor_pending_requests.php");
    
} elseif ($action === 'reject') {
    // Handle rejection
    $reason = $_POST['reason'];
    
    // Update the status to 'rejected' and set rejection_reason in enrollments
    $stmt = $conn->prepare("UPDATE enrollments SET status = 'rejected', rejection_reason = ? WHERE student_email = ?");
    $stmt->bind_param("ss", $reason, $studentEmail);
    $stmt->execute();
    $stmt->close();
    
    // Update PreviousStatus in pending_requests to 'Yes'
    $stmt = $conn->prepare("UPDATE pending_requests SET PreviousStatus = 'Yes' WHERE request_id = ?");
    $stmt->bind_param("i", $requestId);
    $stmt->execute();
    $stmt->close();

    // Redirect with success message
    header("Location: ../views/mentor_pending_requests.php");
}

// Close the connection
$conn->close();
?>
