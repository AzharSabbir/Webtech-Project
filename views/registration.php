<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registration</title>
    <link rel="stylesheet" href="registration.css"> <!-- Link to external CSS file -->
    <script type="text/javascript" src="registrationjsvalidation.js" defer></script> <!-- Link to JavaScript validation file -->
</head>
<body>

    <div class="container">
        <h2>Register</h2>
        <form method="post" action="../controllers/RegistrationAction.php" novalidate onsubmit="return isValid(this)">

            <!-- Username Field -->
            <label for="username">Username</label>
            
            <input type="text" name="username" id="username" value="<?php echo empty($_SESSION['username']) ? '' : htmlspecialchars($_SESSION['username']); ?>">
            <span id="usernameerr" class="error-message">
            <?php echo empty($_SESSION['err8']) ? '' : htmlspecialchars($_SESSION['err8']); ?>
            </span>


            <!-- Email Field -->
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?php echo empty($_SESSION['email']) ? '' : htmlspecialchars($_SESSION['email']); ?>">
            <span id="emailerr" class="error-message">
                <?php echo empty($_SESSION['err1']) ? '' : htmlspecialchars($_SESSION['err1']); ?>
            </span>

            <!-- Phone Field -->
            <label for="phone">Phone</label>
            <input type="tel" name="phone" id="phone" value="<?php echo empty($_SESSION['phone']) ? '' : htmlspecialchars($_SESSION['phone']); ?>">
            <span id="phoneerr" class="error-message">
                <?php echo empty($_SESSION['err2']) ? '' : htmlspecialchars($_SESSION['err2']); ?>
            </span>

            <!-- Gender Field -->
            <label for="gender">Gender</label>
            <select name="gender" id="gender">
                <option value="">Select Gender</option>
                <option value="male" <?php echo (isset($_SESSION['gender']) && $_SESSION['gender'] == 'male') ? 'selected' : ''; ?>>Male</option>
                <option value="female" <?php echo (isset($_SESSION['gender']) && $_SESSION['gender'] == 'female') ? 'selected' : ''; ?>>Female</option>
            </select>
            <span id="gendererr" class="error-message">
                <?php echo empty($_SESSION['err3']) ? '' : htmlspecialchars($_SESSION['err3']); ?>
            </span>

            <!-- Password Field -->
            <label for="password">Password</label>
            <input type="password" name="password" id="password" value="<?php echo empty($_SESSION['password']) ? '' : htmlspecialchars($_SESSION['password']); ?>">
            <span id="passworderr" class="error-message">
                <?php echo empty($_SESSION['err4']) ? '' : htmlspecialchars($_SESSION['err4']); ?>
            </span>

            <!-- Confirm Password Field -->
            <label for="confirm_password">Confirm Password</label>
            <input type="password" name="confirm_password" id="confirm_password" value="<?php echo empty($_SESSION['confirm_password']) ? '' : htmlspecialchars($_SESSION['confirm_password']); ?>">
            <span id="confirmPassworderr" class="error-message">
                <?php echo empty($_SESSION['err5']) ? '' : htmlspecialchars($_SESSION['err5']); ?>
            </span>

            <!-- Registration Option Field -->
            <div>
                <input type="radio" name="register_as" id="student" value="student" <?php echo (isset($_SESSION['register_as']) && $_SESSION['register_as'] == 'student') ? 'checked' : ''; ?>>
                <label for="student">Student</label>

                <input type="radio" name="register_as" id="mentor" value="mentor" <?php echo (isset($_SESSION['register_as']) && $_SESSION['register_as'] == 'mentor') ? 'checked' : ''; ?>>
                <label for="mentor">Mentor</label>
            </div>
            <span id="registeraserr" class="error-message">
                <?php echo empty($_SESSION['err6']) ? '' : htmlspecialchars($_SESSION['err6']); ?>
            </span>

            <!-- Submit Button -->
            <input type="submit" value="Register">
        </form>

        <div class="create-account">
            <a href="login.php">Back to Login</a>
        </div>
    </div>

</body>
</html>
<?php session_destroy(); ?>
