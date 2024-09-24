<?php
require "../models/RegistrationModel.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Call the function to check if the email exists
    if (emailExists($email)) {
        echo "exists"; // Return "exists" if the email is already in the database
    } else {
        echo "available"; // Return "available" if the email is not in the database
    }
}

function emailExists($email) {
    $servername = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "mydb";

    // Create connection
    $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if email already exists
    $sql = "SELECT email FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    $exists = (mysqli_num_rows($result) > 0);

    $conn->close();

    return $exists;
}
?>
