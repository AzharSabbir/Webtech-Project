<?php
// mentor_pending_requests.php

session_start();

if (!isset($_SESSION['email'])) {
    header('Location: ../views/login.php');
    exit;
}

$mentorEmail = $_SESSION['email'];

// Include the model to fetch pending requests
include '../models/mentor_pending_requestsModel.php';

$requests = getPendingRequests($mentorEmail);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Pending Requests</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="mentor_pending_requests.css">
    <script src="../controllers/mentor_pending_requestsjsValidation.js"></script>
</head>
<body>

<!-- Include Sidebar -->
<?php include 'mentorSidebar.php'; ?>

<div class="main-content">
    <h2>Pending Enrollment Requests</h2>
    <table>
        <tr>
            <th>Student Email</th>
            <th>Request Description</th>
            <th>Action</th>
        </tr>
        <?php foreach ($requests as $request): ?>
        <tr>
            <td><?php echo htmlspecialchars($request['student_email']); ?></td>
            <td><?php echo htmlspecialchars($request['request_description']); ?></td>
            <td>
            <form action="../controllers/mentor_pending_requestsAction.php" method="POST" onsubmit="return validateForm(this);">
                <input type="hidden" name="request_id" value="<?php echo $request['request_id']; ?>">
                <input type="radio" name="action" value="accept" onclick="hideRejectReason(this)" required> Accept
                <input type="radio" name="action" value="reject" onclick="showRejectReason(this)" required> Reject
                <div id="reject-reason-<?php echo $request['request_id']; ?>" style="display:none;">
                    <input type="text" name="reason" placeholder="Reason for rejection" id="reason-<?php echo $request['request_id']; ?>">
                </div>
                <input type="submit" value="Submit">
            </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <?php if (isset($_GET['status'])): ?>
        <div style="color: green;">
            Enrollment request has been successfully <?php echo htmlspecialchars($_GET['status']); ?>.
        </div>
    <?php endif; ?>
</div>

</body>
</html>
