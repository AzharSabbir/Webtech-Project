<?php
session_start();
require_once '../models/mentorDashboardModel.php';

$action = $_POST['action'] ?? '';

if ($action === 'addCourse') {
    $courseName = $_POST['name'] ?? '';
    $courseDescription = $_POST['description'] ?? '';
    
    if (!empty($courseName) && !empty($courseDescription)) {
        addCourse($courseName, $courseDescription);
        header('Location: ../views/mentorDashboard.php?msg=Course added successfully!');
    } else {
        header('Location: ../views/mentorDashboard.php?err=Please fill in all fields.');
    }
}

if ($action === 'deleteCourse') {
    $courseId = $_POST['courseId'] ?? '';
    if (!empty($courseId)) {
        deleteCourse($courseId);
        header('Location: ../views/mentorDashboard.php?msg=Course deleted successfully!');
    } else {
        header('Location: ../views/mentorDashboard.php?err=Invalid course ID.');
    }
}

?>
