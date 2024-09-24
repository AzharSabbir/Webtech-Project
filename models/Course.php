<?php
class Course {
    private $conn;

    public function __construct($servername, $dbUsername, $dbPassword, $dbname) {
        $this->conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

        // Check connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function addCourse($courseName, $description) {
        // Escape values for security
        $courseName = $this->conn->real_escape_string($courseName);
        $description = $this->conn->real_escape_string($description);

        // Insert course into the database
        $sql = "INSERT INTO courses (course_name, description) VALUES ('$courseName', '$description')";
        return $this->conn->query($sql);
    }

    public function getCourses() {
        $sql = "SELECT course_name, description FROM courses";
        $result = $this->conn->query($sql);
        $courses = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $courses[] = $row;
            }
        }
        return $courses;
    }

    public function deleteCourse($courseName) {
        $courseName = $this->conn->real_escape_string($courseName);
        $sql = "DELETE FROM courses WHERE course_name = '$courseName'";
        return $this->conn->query($sql);
    }

    public function __destruct() {
        $this->conn->close();
    }
}
?>
