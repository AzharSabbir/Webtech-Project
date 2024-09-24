<?php
session_start();

if (!isset($_SESSION['email'])) {
    header('Location: ../views/login.php');
    exit;
}

$userEmail = $_SESSION['email'];

// Fetch enrolled courses from the database
$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbname = "course enroll project";

$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch enrolled courses
$learnings = $conn->query("SELECT c.course_name, l.enrollment_date 
                            FROM learnings l 
                            JOIN courses c ON l.course_id = c.course_id 
                            WHERE l.student_email = '$userEmail'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Your Learnings</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="dashboard.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333;
            color: white;
            padding: 10px 0;
            text-align: center;
        }

        nav {
            height: 100%;
            width: 200px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #333;
            padding-top: 20px;
        }

        nav ul {
            list-style-type: none;
            padding: 0;
        }

        nav ul li {
            padding: 8px;
            text-align: center;
        }

        nav ul li a {
            text-decoration: none;
            color: white;
            display: block;
        }

        nav ul li a:hover {
            background-color: #575757;
        }

        section {
            margin-left: 220px; /* Adjusted to fit the sidebar */
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ccc;
            padding: 10px;
        }

        th {
            background-color: #f2f2f2;
            text-align: left;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<nav>
    <ul>
        <li><a href="home.php">Profile</a></li>
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="learnings.php">Learnings</a></li>
        <li><a href="forgetpassword.php">Forget Password</a></li>
        <li><a href="changepassword.php">Change Password</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</nav>

<header>
    <h2>Your Enrolled Courses</h2>
</header>

<section>
    <table>
        <tr>
            <th>Course Name</th>
            <th>Enrollment Date</th>
        </tr>
        <?php while ($learning = $learnings->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($learning['course_name']); ?></td>
            <td><?php echo htmlspecialchars($learning['enrollment_date']); ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</section>

</body>
</html>
