<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Handle file upload
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($_FILES['photo']['name']);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $comment = isset($_POST['comment']) ? $_POST['comment'] : '';

    // Check if file is a valid image
    $check = getimagesize($_FILES['photo']['tmp_name']);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "<p class='error'>File is not an image.</p>";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "<p class='error'>Sorry, file already exists.</p>";
        $uploadOk = 0;
    }

    // Check file size (optional)
    if ($_FILES['photo']['size'] > 5000000) { // 5MB limit
        echo "<p class='error'>Sorry, your file is too large.</p>";
        $uploadOk = 0;
    }

    // Allow certain file formats (optional)
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "<p class='error'>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</p>";
        $uploadOk = 0;
    }

    // Attempt to upload the file
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $target_file)) {
            // Save the image path and comment in the database
            $servername = "localhost";
            $dbUsername = "root";
            $dbPassword = "";
            $dbname = "mydb";

            $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Escape the file path and comment for security
            $image_path = $conn->real_escape_string($target_file);
            $escaped_comment = $conn->real_escape_string($comment);

            // Insert the image path and comment into the users table
            $sql = "INSERT INTO users (image_path, comment) VALUES ('$image_path', '$escaped_comment')";
            if ($conn->query($sql) === TRUE) {
                echo "<p class='message'>The file " . htmlspecialchars(basename($_FILES['photo']['name'])) . " has been uploaded with your comment.</p>";
            } else {
                echo "<p class='error'>Error: " . $sql . "<br>" . $conn->error . "</p>";
            }

            $conn->close();
        } else {
            echo "<p class='error'>Sorry, there was an error uploading your file.</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Upload Image</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #272A31;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .container {
            width: 90%;
            max-width: 800px;
            margin-top: 20px;
            text-align: center;
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        h2 {
            color: #FFE364;
        }
        form {
            margin: 0 auto;
            max-width: 600px;
            text-align: left;
        }
        input[type="file"], textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            font-size: 18px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: white;
            color: #4CAF50;
        }
        .message {
            color: green;
            margin-top: 10px;
        }
        .error {
            color: red;
            margin-top: 10px;
        }
        a {
            color: #4CAF50;
            text-decoration: none;
            font-size: 18px;
        }
        a:hover {
            text-decoration: underline;
        }
        .logout {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: #f44336;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 16px;
        }
        .logout:hover {
            background-color: white;
            color: #f44336;
        }
    </style>
</head> 
<body>

<a href="login.php" class="logout">Logout</a>

<div class="container">
    <h2>Upload New Image</h2>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        Select image to upload:
        <input type="file" name="photo" id="photo" required><br>
        
        Add a comment (optional):<br>
        <textarea name="comment" rows="4" cols="50"></textarea><br>

        <input type="submit" value="Upload Image" name="submit">
    </form>

    <br>
    <a href="../views/home.php">Go Back to Home</a>
</div>

</body>
</html>
