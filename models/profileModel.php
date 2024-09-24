<?php
class ProfileModel {
    private $mysqli;

    public function __construct() {
        // Database connection
        $this->mysqli = new mysqli('localhost', 'root', '', 'course enroll project'); // Replace with your DB credentials

        if ($this->mysqli->connect_error) {
            die("Connection failed: " . $this->mysqli->connect_error); // Handle connection error
        }
    }

    // Fetch user data by email
    public function getUserDataByEmail($email) {
        $stmt = $this->mysqli->prepare("SELECT username, email, gender, phone FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc(); // Return the user data as an associative array
    }

    // Update user data
    public function updateUserData($email, $field, $newValue) {
        $allowedFields = ['username', 'gender', 'phone'];
        if (!in_array($field, $allowedFields)) {
            throw new Exception("Invalid field name");
        }
    
        $stmt = $this->mysqli->prepare("UPDATE users SET $field = ? WHERE email = ?");
        if (!$stmt) {
            error_log("Prepare failed: (" . $this->mysqli->errno . ") " . $this->mysqli->error);
            return false; // Return false if prepare fails
        }
    
        $stmt->bind_param("ss", $newValue, $email);
        $success = $stmt->execute();
        if (!$success) {
            error_log("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
        }
        return $success; // Return true if successful
    }

    public function __destruct() {
        $this->mysqli->close(); // Close the database connection
    }
}
?>
