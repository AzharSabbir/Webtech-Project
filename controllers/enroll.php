<?php
session_start();

if (!isset($_SESSION['email'])) {
    header('Location: ../views/login.php');
    exit;
}

$userEmail = $_SESSION['email'];
$courseId = $_POST['course_id'];
$class = $_POST['class'];
$learned = $_POST['learned'];
$status = 'pending';
$enrollmentDate = date('Y-m-d'); // Get current date for enrollment

// Database connection
$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbname = "course enroll project";

$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert the enrollment request into the enrollments table
$stmt = $conn->prepare("INSERT INTO enrollments (student_email, course_id, status) VALUES (?, ?, ?)");
$stmt->bind_param("sis", $userEmail, $courseId, $status); // 's' for string, 'i' for integer
$stmt->execute();
$stmt->close();

// Assuming you have the course_id available
$course_id = $_POST['course_id']; // Get the course_id from the request

// Prepare the SQL statement to fetch mentor email
$query = "SELECT m.mentor_email 
          FROM courses c 
          JOIN mentors m ON c.mentor_id = m.mentor_id 
          WHERE c.course_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $course_id); // Assuming course_id is an integer
$stmt->execute();
$result = $stmt->get_result();

// Fetch the mentor email
$mentorEmail = null;
if ($row = $result->fetch_assoc()) {
    $mentorEmail = $row['mentor_email']; // Store the fetched email
}

// Close the statement
$stmt->close();

// Now you can use $mentorEmail for your pending_requests insertion
if ($mentorEmail) {
    // Insert the enrollment request into pending_requests
    $requestDescription = "Class: $class, Learned: $learned, Status: $status";
    $stmt = $conn->prepare("INSERT INTO pending_requests (student_email, mentor_email, request_description) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $userEmail, $mentorEmail, $requestDescription); 
    $stmt->execute();
    $stmt->close();
} else {
    // Handle the case where no mentor email is found
    echo "No mentor associated with this course.";
}

// Close the connection
$conn->close();

// Redirect back to dashboard
header('Location: ../views/dashboard.php');
exit;
?>
