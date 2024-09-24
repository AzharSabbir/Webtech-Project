<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include the database connection file
include '../models/db.php'; // Adjust the path to your database connection

// Initialize variables
$userEmail = isset($_SESSION['email']) ? $_SESSION['email'] : '';
$courses = [];
$enrollmentData = [];
$notifications = [];
$notificationCount = 0;

// Fetch available courses
$sql = "SELECT * FROM courses"; // Replace 'courses' with your actual table name
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->execute();
    $courses = $stmt->get_result(); // Fetch courses to use in the dashboard view
} else {
    die("Error preparing statement: " . $conn->error);
}

// Fetch user enrollment status for each course
$enrollmentQuery = "SELECT course_id, status FROM enrollments WHERE student_email = ?";
$enrollStmt = $conn->prepare($enrollmentQuery);

if ($enrollStmt) {
    $enrollStmt->bind_param("s", $userEmail);
    $enrollStmt->execute();
    $result = $enrollStmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $enrollmentData[$row['course_id']] = $row['status'];
    }
    $enrollStmt->close();
} else {
    die("Error preparing enrollment statement: " . $conn->error);
}

// Fetch notification count for the user
$notificationCountQuery = "SELECT COUNT(*) AS notification_count FROM notifications WHERE student_email = ? AND seen = 0";
$notificationStmt = $conn->prepare($notificationCountQuery);

if ($notificationStmt) {
    $notificationStmt->bind_param("s", $userEmail);
    $notificationStmt->execute();
    $notificationResult = $notificationStmt->get_result();
    $notificationData = $notificationResult->fetch_assoc();
    $notificationCount = $notificationData['notification_count']; // Total number of unseen notifications
    $notificationStmt->close();
} else {
    die("Error preparing notification statement: " . $conn->error);
}

// Prepare the query to fetch notifications
$query = "SELECT * FROM notifications WHERE student_email = ?";
$stmt = $conn->prepare($query);

// Bind the parameter
$stmt->bind_param("s", $userEmail);

// Execute the query
$stmt->execute();

// Get the result
$result = $stmt->get_result();

// Fetch all notifications as an associative array
while ($row = $result->fetch_assoc()) {
    $notifications[] = $row;
}

// Close the statement and connection
$stmt->close();
$conn->close();

// Return data for the view
return [
    'notifications' => $notifications,
    'userEmail' => $userEmail,
    'courses' => $courses,
    'enrollmentData' => $enrollmentData,
    'notificationCount' => $notificationCount,
];
?>
