<?php
session_start();
require_once '../models/mentorDashboardModel.php';
$courses = getCourses();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Mentor Dashboard</title>
</head>
<body>
    <?php include 'mentorSidebar.php'; ?>

    <div class="dashboard">
        <h1>Mentor Dashboard</h1>

        <?php if (isset($_GET['msg'])): ?>
            <p class="success"><?php echo htmlspecialchars($_GET['msg']); ?></p>
        <?php endif; ?>
        <?php if (isset($_GET['err'])): ?>
            <p class="error"><?php echo htmlspecialchars($_GET['err']); ?></p>
        <?php endif; ?>

        <h2>Courses</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($courses as $course): ?>
                <tr>
                    <td><?php echo htmlspecialchars($course['course_id']); ?></td>
                    <td><?php echo htmlspecialchars($course['course_name']); ?></td>
                    <td><?php echo htmlspecialchars($course['course_description']); ?></td>
                    <td>
                        <form method="POST" action="../controllers/mentorDashboardAction.php">
                            <input type="hidden" name="courseId" value="<?php echo $course['course_id']; ?>">
                            <input type="hidden" name="action" value="deleteCourse"> <!-- Ensure the action is specified -->
                            <input type="submit" value="Delete Course">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <h3>Add New Course</h3>
        <form method="POST" action="../controllers/mentorDashboardAction.php">
            <input type="text" name="name" placeholder="Course Name" required>
            <textarea name="description" placeholder="Course Description" required></textarea>
            <input type="hidden" name="action" value="addCourse">
            <input type="submit" value="Add Course">
        </form>
    </div>

    <script src="scripts.js"></script>
</body>
</html>
