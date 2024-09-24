<?php
require_once 'models/mentorProfileModel.php'; // Include the model for mentor profile

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assuming the logged-in mentor's email is stored in the session
    $email = $_SESSION['mentor_email'];

    // Get the submitted form data
    $username = $_POST['username'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];

    // Update mentor profile in the database
    if (updateMentorData($email, $username, $phone, $gender)) {
        // Redirect to the profile page after a successful update
        header('Location: mentorProfile.php');
    } else {
        // Optionally, display an error message
        echo "Error updating profile.";
    }

    exit();
}
?>
