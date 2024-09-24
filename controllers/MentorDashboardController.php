<?php
session_start();
require_once '../model/Course.php';

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Database configuration
$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbname = "course enroll project";

// Create an instance of Course model
$courseModel = new Course($servername, $dbUsername, $dbPassword, $dbname);

// Handle course addition
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_course'])) {
    $courseName = $_POST['course_name'];
    $description = $_POST['description'];

    if ($courseModel->addCourse($courseName, $description)) {
        $_SESSION['success'] = "Course added successfully.";
    } else {
        $_SESSION['error'] = "Error adding course: " . $courseModel->conn->error;
    }
}

// Handle course deletion
if (isset($_POST['delete'])) {
    $courseName = $_POST['course_to_delete'];
    if ($courseModel->deleteCourse($courseName)) {
        $_SESSION['success'] = "Course deleted successfully.";
    } else {
        $_SESSION['error'] = "Error deleting course: " . $courseModel->conn->error;
    }
}

// Fetch courses for display
$courses = $courseModel->getCourses();
?>
