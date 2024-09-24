<?php 
require_once '../controllers/dashboardController.php'; 

// Fetch data from controller
$notifications = $notifications; // From the controller
$userEmail = $userEmail; // From the controller

// Include course data fetching logic (as it wasn't included in the controller)
// Assuming the logic to fetch $courses and $enrollmentData is added here

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="styles/dashboard.css">
    <script src="dashboard.js" defer></script> <!-- Link to the external JS file -->
</head>
<body>

<!-- Sidebar -->
<?php include 'studentSidebar.php' ?>

<header>
    <h2>Welcome to Your Dashboard, <?php echo htmlspecialchars($userEmail); ?>!</h2>
    <div id="cartIcon" onclick="toggleCartModal()">🛒</div>
    <div id="notificationIcon" onclick="toggleNotificationModal()">🔔 
        <span id="notificationCount">
            <?php echo $notificationCount; ?> <!-- This will show the number of new notifications -->
        </span>
    </div>
</header>

<section>
    <h3>Available Courses for Enrollment</h3>
    <div class="course-container">
        <?php while ($course = $courses->fetch_assoc()): ?>
        <div class="course-card">
            <h4><?php echo htmlspecialchars($course['course_name']); ?></h4>
            <p><?php echo htmlspecialchars($course['course_description']); ?></p>
            <?php
            $courseId = $course['course_id'];
            if (isset($enrollmentData['status'])) {    
                if ($enrollmentData['status'] == 'pending') {
                    echo '<p style="color: orange;">Pending</p>';
                } elseif ($enrollmentData['status'] == 'accepted') {
                    echo '<p style="color: green;">Enrolled</p>';
                }
            } else {
                echo '<button class="enroll-btn" onclick="openEnrollmentForm(' . $courseId . ')">Enroll Now</button>';
            }
            ?>
            <button class="cart-btn" id="cart-btn-<?php echo $courseId; ?>" onclick="toggleCart(<?php echo $courseId; ?>)">Add to Cart</button>
        </div>
        <?php endwhile; ?>
    </div>
</section>

<!-- Enrollment Form Modal -->
<div id="enrollmentFormModal">
    <div>
        <h4>Enrollment Form</h4>
        <form id="enrollmentForm" action="../controllers/enroll.php" method="POST">
            <input type="hidden" name="course_id" id="course_id">
            <label for="class">Which class are you reading?</label>
            <input type="text" name="class" required>
            <label for="learned">Learned Flutter/C++/ML:</label>
            <select name="learned" required>
                <option value="no">No</option>
                <option value="flutter">Flutter</option>
                <option value="c++">C++</option>
                <option value="ml">Machine Learning</option>
            </select>
            <label for="status">Student or Employee:</label>
            <select name="status" required>
                <option value="student">Student</option>
                <option value="employee">Employee</option>
            </select>
            <input type="hidden" name="student_email" value="<?php echo htmlspecialchars($userEmail); ?>">
            <input type="submit" value="Submit">
            <button type="button" onclick="closeEnrollmentForm()">Cancel</button>
        </form>
    </div>
</div>

<!-- Cart Modal -->
<div id="cartModal">
    <div id="cartModalContent">
        <h4>Cart Items</h4>
        <ul id="cartItemsList"></ul>
        <button onclick="closeCartModal()">Close</button>
    </div>
</div>

<!-- Notification Modal -->
<div id="notificationModal">
    <div id="notificationModalContent">
        <h4>Notifications</h4>
        <ul>
            <?php foreach ($notifications as $notification): ?>
                <li>
                    <?php echo htmlspecialchars($notification['message']); ?>
                    <span class="notification-time">
                        <?php echo date('d M Y, H:i', strtotime($notification['created_at'])); ?>
                    </span>
                </li>
            <?php endforeach; ?>
        </ul>
        <button onclick="closeNotificationModal()">Close</button>
    </div>
</div>

<footer>
    <p>Lab Assignment | Date: 21/09/2024</p>
</footer>   
</body>
</html>
