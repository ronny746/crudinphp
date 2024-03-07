<?php
require_once 'connection.php'; // Include database connection script

// Handle POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   

    // Retrieve POST data
    $userId = $_POST["user_id"];
    $content = $_POST["content"];

    // Check if all required fields are provided
    if (empty($content)) {
        echo json_encode(array("message" => "Content is required"));
        exit;
    }

    // Check file size
    $maxFileSize = 500000; // Maximum file size in bytes (e.g., 500KB)
    if ($_FILES["image"]["size"] > $maxFileSize) {
        $maxFileSizeKB = $maxFileSize / 1000; // Convert bytes to kilobytes
        echo json_encode(array("message" => "Sorry, your file is too large. Maximum file size allowed is $maxFileSizeKB KB."));
        exit;
    }

    // File upload handling
    $targetDir = "uploads/"; // Directory where images will be stored
    $targetFile = $targetDir . basename($_FILES["image"]["name"]);
   
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
        // Insert post into database
        $insertQuery = "INSERT INTO posts (user_id, czontent, image_path) VALUES ($userId, '$content', '$targetFile')";
        if (mysqli_query($conn, $insertQuery)) {
            echo json_encode(array("message" => "Post added successfully"));
        } else {
            echo json_encode(array("message" => "Error adding post"));
        }
    } else {
        echo json_encode(array("message" => "Sorry, there was an error uploading your file."));
    }
}
?>
