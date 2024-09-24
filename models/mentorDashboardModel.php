<?php
function dbConnection() {
    $host = 'localhost';
    $db = 'course enroll project';
    $user = 'root';
    $pass = '';
    
    return new PDO("mysql:host=$host;dbname=$db", $user, $pass);
}

function getCourses() {
    $conn = dbConnection();
    $stmt = $conn->prepare("SELECT * FROM courses");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function addCourse($name, $description) {
    $conn = dbConnection();
    $stmt = $conn->prepare("INSERT INTO courses (course_name, course_description) VALUES (:name, :description)");
    $stmt->execute(['name' => $name, 'description' => $description]);
}

function deleteCourse($id) {
    $conn = dbConnection();
    $stmt = $conn->prepare("DELETE FROM courses WHERE course_id = :id");
    $stmt->execute(['id' => $id]);
}
?>
