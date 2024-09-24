<?php
session_start();
require_once '../models/profileModel.php'; // Ensure the path is correct

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: ../views/login.php");
    exit();
}

// Initialize the ProfileModel
$profileModel = new ProfileModel();

// Fetch user data from the database using the email stored in session
$email = $_SESSION['email'];
$userData = $profileModel->getUserDataByEmail($email);

if ($userData === null) {
    // Redirect if user data is not found
    header("Location: ../views/login.php");
    exit();
}

// Extract user data
$username = htmlspecialchars($userData['username']);
$phone = htmlspecialchars($userData['phone']);
$gender = htmlspecialchars($userData['gender']);

// Initialize message variable
$updateMessage = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newUsername = $_POST['username'];
    $newPhone = $_POST['phone'];
    
    // Update username if it's different
    if ($newUsername !== $username) {
        if ($profileModel->updateUserData($email, 'username', $newUsername)) {
            $updateMessage = "Username updated successfully.";
        } else {
            $updateMessage = "Failed to update username.";
        }
    }

    // Update phone number if it's different
    if ($newPhone !== $phone) {
        if ($profileModel->updateUserData($email, 'phone', $newPhone)) {
            $updateMessage = "Phone number updated successfully.";
        } else {
            $updateMessage = "Failed to update phone number.";
        }
    }

    // Refresh user data after update
    $userData = $profileModel->getUserDataByEmail($email);
    $username = htmlspecialchars($userData['username']);
    $phone = htmlspecialchars($userData['phone']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="dashboard.css"> <!-- Link to your dashboard CSS file -->
    <link rel="stylesheet" href="profile.css"> <!-- Link to your profile CSS file -->
</head>
<body>
    <header>
        <h1>User Profile</h1>
    </header>
    
    <?php
    // Include the correct sidebar based on user status
if ($_SESSION['status'] === 'mentor') {
    include 'mentorSidebar.php';
} elseif ($_SESSION['status'] === 'student') {
    include 'studentSidebar.php'; // Make sure to create this file if it doesn't exist
} else {
    echo "Invalid user status!";
    exit;
}
    ?>
    <main class="main-content">
        <div class="profile-container">
            <h2>User Information</h2>
            <p><strong>Username:</strong> <?php echo $username; ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
            <p><strong>Phone:</strong> <?php echo $phone; ?></p>
            <p><strong>Gender:</strong> <?php echo $gender; ?></p>
            
            <!-- Display update message -->
            <?php if ($updateMessage): ?>
                <div class="message"><?php echo $updateMessage; ?></div>
            <?php endif; ?>

            <!-- Form for updating username and phone -->
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <label for="username">Change Username:</label>
                <input type="text" id="username" name="username" value="<?php echo $username; ?>" required>
                
                <label for="phone">Change Phone Number:</label>
                <input type="text" id="phone" name="phone" value="<?php echo $phone; ?>" required>
                
                <input type="submit" value="Update">
            </form>
        </div>
    </main>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> Your Company</p>
    </footer>
</body>
</html>
