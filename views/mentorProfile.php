<?php
session_start();

// Check if 'mentor_email' is set in the session or another source
if (isset($_SESSION['mentor_email'])) {
    $mentor_email = $_SESSION['mentor_email'];
} else {
    // Handle the case where the mentor_email is not set (redirect, show error, etc.)
    echo "Mentor email is not set. Please log in.";
    exit; // Stop the script execution if email is not set
}

// Now you can proceed to fetch the mentor data
$mentorData = getMentorDataByEmail($mentor_email);

if ($mentorData) {
    // Display mentor data
} else {
    echo "No mentor data found.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/mentorProfile.css"> <!-- Link to CSS file -->
    <title>Mentor Profile</title>
</head>
<body>
    <h1>Mentor Profile</h1>

    <?php if ($mentorData): ?>
    <form method="POST" action="mentorProfileAction.php">
        <label for="username">Username:</label>
        <input type="text" name="username" value="<?php echo htmlspecialchars($mentorData['username']); ?>" required><br>

        <label for="phone">Phone:</label>
        <input type="text" name="phone" value="<?php echo htmlspecialchars($mentorData['phone']); ?>" required><br>

        <label for="gender">Gender:</label>
        <select name="gender" required>
            <option value="Male" <?php if ($mentorData['gender'] == 'Male') echo 'selected'; ?>>Male</option>
            <option value="Female" <?php if ($mentorData['gender'] == 'Female') echo 'selected'; ?>>Female</option>
            <option value="Other" <?php if ($mentorData['gender'] == 'Other') echo 'selected'; ?>>Other</option>
        </select><br>

        <button type="submit">Update Profile</button>
    </form>
    <?php else: ?>
        <p>No profile data found.</p>
    <?php endif; ?>
</body>
</html>
