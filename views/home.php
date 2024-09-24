<?php
session_start();

if (!isset($_SESSION['email'])) {
    header('Location: ../views/login.php');
    exit;
}

$userEmail = $_SESSION['email'];

// Fetch user details from the database
$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbname = "mydb";

$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("SELECT gender FROM users WHERE Email = ?");
$stmt->bind_param("s", $userEmail);
$stmt->execute();
$stmt->bind_result($gender);
$stmt->fetch();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Home Page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="home.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<header>
    <h2>Welcome, <?php echo htmlspecialchars($gender); ?>!</h2>
</header>

<section>
    <nav>
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="home.php">Profile</a></li>
            <li><a href="forgetpassword.php">Forget Password</a></li>
            <li><a href="changepassword.php">Change Password</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <article>
        <h2>Your Gender: <span id="genderDisplay"><?php echo htmlspecialchars($gender); ?></span></h2>
        <form id="updateProfileForm">
            <label for="gender">Update Gender:</label>
            <select name="gender" id="gender">
                <option value="">Select Gender</option>
                <option value="male" <?php echo (isset($_SESSION['gender']) && $_SESSION['gender'] == 'male') ? 'selected' : ''; ?>>Male</option>
                <option value="female" <?php echo (isset($_SESSION['gender']) && $_SESSION['gender'] == 'female') ? 'selected' : ''; ?>>Female</option>
                <option value="other" <?php echo (isset($_SESSION['gender']) && $_SESSION['gender'] == 'other') ? 'selected' : ''; ?>>Other</option>
            </select>
            <input type="submit" value="Update Gender">
        </form>
        <p id="profileMessage"></p>
    </article>
</section>

<footer>
    <p>Lab Assignment | Date : 21/09/2024</p>
</footer>

<script>
$(document).ready(function() {
    $('#updateProfileForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: '../controllers/updateProfile.php', // Adjust if needed
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                $('#genderDisplay').text($('#gender').val());
                $('#profileMessage').text('Profile updated successfully!').css('color', 'green');
            },
            error: function(xhr, status, error) {
                $('#profileMessage').text('Error updating profile: ' + xhr.responseText).css('color', 'red');
            }
        });
    });
});
</script>

</body>
</html>
