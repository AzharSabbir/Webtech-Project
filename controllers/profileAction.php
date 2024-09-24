<?php
session_start();
require_once '../models/ProfileModel.php'; // Ensure the path is correct

class profileAction { // Class name changed to lowercase to match file name
    private $profileModel;

    public function __construct() {
        $this->profileModel = new ProfileModel();
    }

    public function handleRequest() {
        // Check if the user is logged in
        if (!isset($_SESSION['email'])) {
            header("Location: ../views/login.php");
            exit();
        }

        // Fetch user data from the database
        $email = $_SESSION['email'];
        $userData = $this->profileModel->getUserDataByEmail($email);

        if ($userData === null) {
            header("Location: ../views/login.php"); // Redirect if user data is not found
            exit();
        }

        // Initialize variables for the view
        $username = htmlspecialchars($userData['username']);
        $phone = htmlspecialchars($userData['phone']);
        $gender = htmlspecialchars($userData['gender']);
        $updateMessage = ""; // Initialize the variable here

        // Handle form submission for updating user information
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newUsername = trim($_POST['username']);
            $newPhone = trim($_POST['phone']);

            // Update username if it's provided
            if (!empty($newUsername) && $newUsername !== $username) {
                if ($this->profileModel->updateUserData($email, 'username', $newUsername)) {
                    $updateMessage = "Username updated successfully!";
                    $username = htmlspecialchars($newUsername); // Update displayed username
                } else {
                    $updateMessage = "Failed to update username.";
                }
            }

            // Update phone number if it's provided
            if (!empty($newPhone) && $newPhone !== $phone) {
                if ($this->profileModel->updateUserData($email, 'phone', $newPhone)) {
                    $updateMessage = "Phone number updated successfully!";
                    $phone = htmlspecialchars($newPhone); // Update displayed phone number
                } else {
                    $updateMessage = "Failed to update phone number.";
                }
            }
        }

        // Pass user data and messages to the view
        include '../views/profile.php'; // Load the profile view
    }
}

// Instantiate the profileAction and handle the request
$profileAction = new profileAction(); // Class name changed to lowercase to match file name
$profileAction->handleRequest();
?>
