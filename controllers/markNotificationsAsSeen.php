<?php
session_start();
require_once '../db.php'; // Include your database configuration

if (isset($_POST['email'])) {
    $studentEmail = $_POST['email'];

    // Prepare the SQL statement to mark notifications as seen
    $stmt = $conn->prepare("UPDATE notifications SET seen = 1 WHERE student_email = ?");
    $stmt->bind_param("s", $studentEmail);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Email not provided']);
}
?>
