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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="forgetpassword.css">
</head>
<body>
<header>
    <h2>Forgot Password</h2>
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
        <h2>Forgot Password</h2><br>
        <form method="post" action="../controllers/forgetpasswordAction.php">
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" required><br>
            <input type="submit" value="Submit">
        </form>
        <?php
        if (isset($_GET['err']) && !empty($_GET['err'])) {
            echo "<p style='color:red;'>{$_GET['err']}</p>";
        }
        if (isset($_GET['success']) && !empty($_GET['success'])) {
            echo "<p style='color:green;'>{$_GET['success']}</p>";
        }
        ?>
    </article>
</section>

<footer>
    <p>Lab Assignment | Date : 21/09/2024</p>
</footer>

</body>
</html>
