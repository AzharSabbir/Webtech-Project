<?php
session_start();
require_once '../models/mentorDashboardModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $mentorEmail = $_SESSION['email'];

        if ($_POST['action'] === 'addCourse') {
            $courseName = $_POST['courseName'];
            $courseDescription = $_POST['courseDescription'];
            $result = addCourse($mentorEmail, $courseName, $courseDescription);
            echo json_encode(['success' => $result]);
        }

        if ($_POST['action'] === 'deleteCourse') {
            $courseId = $_POST['courseId'];
            $result = deleteCourse($courseId);
            echo json_encode(['success' => $result]);
        }
    }
}
?>
