<?php
session_start();
include '../models/loginModel.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Call the function to check credentials
    if (matchCredentials($email, $password)) {
        // Set session variables
        $_SESSION['email'] = $email;

        // Redirect to the home page or profile page
        header('Location: ../views/dashboard.php');
        exit;
    } else {
        // Handle login failure
        $err = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="login.css">
</head>
<body>

    <div class="container">
        <h2>Login</h2>
        <form method="post" action="../controllers/LoginAction.php" novalidate>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>">
            <span><?php echo isset($_SESSION['err1']) ? $_SESSION['err1'] : ''; ?></span>

            <label for="password">Password</label>
            <input type="password" name="password" id="password">
            <span><?php echo isset($_SESSION['err2']) ? $_SESSION['err2'] : ''; ?></span>

            <input type="submit" value="Login">
            <span><?php echo isset($_SESSION['err3']) ? $_SESSION['err3'] : ''; ?></span>
        </form>

        <div class="create-account">
            <a href="registration.php">Create New Account</a>
        </div>
    </div>

    <script src="loginjsvalidation.js"></script>
</body>
</html>

