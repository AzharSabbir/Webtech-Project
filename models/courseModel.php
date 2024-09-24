<?php
class CourseModel {
    private $conn;

    public function __construct() {
        $this->conn = new mysqli("localhost", "root", "", "course enroll project");
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function fetchEnrollmentStatus($userEmail) {
        $enrollmentStatus = $this->conn->query("SELECT course_id, status FROM enrollments WHERE student_email = '$userEmail'");
        $enrollmentData = [];
        while ($row = $enrollmentStatus->fetch_assoc()) {
            $enrollmentData[$row['course_id']] = $row['status'];
        }
        return $enrollmentData;
    }

    public function fetchAvailableCourses() {
        return $this->conn->query("SELECT course_id, course_name, course_description FROM courses");
    }

    public function __destruct() {
        $this->conn->close();
    }
}
?>
