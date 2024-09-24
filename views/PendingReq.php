<?php
session_start();

// Check if the user is logged in
// if (!isset($_SESSION['email'])) {
//     header('Location: ../views/login.php');
//     exit;
// }

//$mentorEmail = $_SESSION['email'];

$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbname = "course enroll project";

$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch pending requests assigned to the mentor
$requests = $conn->query("SELECT request_id, student_email, request_description FROM pending_requests WHERE mentor_email = '$mentorEmail'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Pending Requests</title>
    <meta charset="utf-8">
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 10px;
        }
        th, td {
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .reject-reason {
            display: none;
        }
    </style>
</head>
<body>

<h2>Pending Enrollment Requests</h2>
<table>
    <tr>
        <th>Student Email</th>
        <th>Request Description</th>
        <th>Action</th>
    </tr>
    <?php while ($request = $requests->fetch_assoc()): ?>
    <tr>
        <td><?php echo htmlspecialchars($request['student_email']); ?></td>
        <td><?php echo htmlspecialchars($request['request_description']); ?></td>
        <td>
            <form action="../controllers/handle_request.php" method="POST" onsubmit="return validateForm(this);">
                <input type="hidden" name="request_id" value="<?php echo $request['request_id']; ?>">
                
                <input type="radio" name="action" value="accept" onclick="hideRejectReason(this)" required> Accept
                <input type="radio" name="action" value="reject" onclick="showRejectReason(this)" required> Reject

                <!-- Reason input (for rejection only) -->
                <div class="reject-reason" id="reject-reason-<?php echo $request['request_id']; ?>">
                    <input type="text" name="reason" placeholder="Reason for rejection" id="reason-<?php echo $request['request_id']; ?>">
                </div>

                <input type="submit" value="Submit">
            </form>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<script>
// Show rejection reason input when 'Reject' is selected
function showRejectReason(radio) {
    var form = radio.closest('form');
    var rejectReasonDiv = form.querySelector('.reject-reason');
    rejectReasonDiv.style.display = 'block';
}

// Hide rejection reason input when 'Accept' is selected
function hideRejectReason(radio) {
    var form = radio.closest('form');
    var rejectReasonDiv = form.querySelector('.reject-reason');
    rejectReasonDiv.style.display = 'none';
}

// Validate form before submission
function validateForm(form) {
    var action = form.querySelector('input[name="action"]:checked').value;
    if (action === 'reject') {
        var reasonInput = form.querySelector('[name="reason"]');
        if (!reasonInput.value.trim()) {
            alert("Please provide a reason for rejection.");
            return false;
        }
    }
    return true;
}
</script>

</body>
</html>
<?php
$conn->close();
?>
