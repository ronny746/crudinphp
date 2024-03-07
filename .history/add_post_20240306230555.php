<?php
require_once 'connection.php'; // Include database connection script

// Handle POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    try {
        // Check if user is logged in
        if (!isset($_SESSION["user_id"])) {
            throw new Exception("You must be logged in to add a post");
        }

        // Retrieve POST data
        $userId = $_SESSION["user_id"];
        $content = $_POST["content"];

        // Validate inputs (you should add more validation)
        if (empty($content)) {
            throw new Exception("Content is required");
        }

        // File upload handling
        $targetDir = "uploads/"; // Directory where images will be stored
        $targetFile = $targetDir . basename($_FILES["image"]["name"]);
        $uploadOk = 0;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if($check !== false) {
                $uploadOk = 1;
            } else {
                throw new Exception("File is not an image.");
            }
        }

        // Check file size
        if ($_FILES["image"]["size"] > 500000) {
            throw new Exception("Sorry, your file is too large.");
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            throw new Exception("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            throw new Exception("Sorry, your file was not uploaded.");
        } else {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                // Insert post into database
                $insertQuery = "INSERT INTO posts (user_id, content, image_path) VALUES ($userId, '$content', '$targetFile')";
                if (!mysqli_query($conn, $insertQuery)) {
                    throw new Exception("Error adding post");
                }
                echo json_encode(array("message" => "Post added successfully"));
            } else {
                throw new Exception($uploadOk);
            }
        }
    } catch (Exception $e) {
        echo json_encode(array("message" => $e->getMessage()));
    }
}
?>
