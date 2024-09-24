<?php
session_start();

if (!isset($_SESSION['email'])) {
    // User is not logged in, redirect to login page
    header('Location: ../views/login.php');
    exit;
}

$userEmail = $_SESSION['email'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Change Password</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="changepassword.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#currentPassword').on('input', function() {
                var currentPassword = $(this).val();
                $.ajax({
                    url: '../controllers/checkpassword.php',
                    method: 'POST',
                    data: { currentPassword: currentPassword },
                    success: function(response) {
                        if (response === 'incorrect') {
                            $('#passwordError').text('Current password is incorrect.');
                        } else {
                            $('#passwordError').text('');
                        }
                    }
                });
            });
        });
    </script>
</head>
<body>

<header>
    <h2>Change Password</h2>
</header>

<section>
    <nav>
        <ul>
            <li><a href="home.php">Profile</a></li>
            <li><a href="forgetpassword.php">Forget Password</a></li>
            <li><a href="changepassword.php">Change Password</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <article>
        <h2>Change Password</h2>
        <form method="post" action="../controllers/changepasswordAction.php" novalidate>
            <label for="currentPassword">Current Password:</label><br>
            <input type="password" id="currentPassword" name="currentPassword" required><br>
            <span id="passwordError" style="color:red;"></span><br>
            <label for="newPassword">New Password:</label><br>
            <input type="password" name="newPassword" required><br><br>
            <label for="confirmPassword">Confirm New Password:</label><br>
            <input type="password" name="confirmPassword" required><br><br>
            <input type="submit" value="Change Password">
        </form>

        <?php
        if (isset($_GET['err']) && !empty($_GET['err'])) {
            echo "<p style='color:red;'>".$_GET['err']."</p>";
        }
        if (isset($_GET['success']) && !empty($_GET['success'])) {
            echo "<p style='color:green;'>".$_GET['success']."</p>";
        }
        ?>
    </article>
</section>

<footer>
    <p>Lab Assignment | Date : 21/09/2024</p>
</footer>

</body>
</html>
