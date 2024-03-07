<?php
require_once 'connection.php'; // Include database connection script

// Handle POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Retrieve POST data
    $userId = $_SESSION["user_id"];
    $content = $_POST["content"];

    // Check if all required fields are provided
    if (empty($content)) {
        echo json_encode(array("message" => "Content is required"));
        exit;
    }

    // File upload handling
    $targetDir = "uploads/"; // Directory where images will be stored
    $targetFile = $targetDir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            echo json_encode(array("message" => "File is not an image."));
            $uploadOk = 0;
            exit;
        }
    }

    // Check file size
    if ($_FILES["image"]["size"] > 500000) {
        echo json_encode(array("message" => "Sorry, your file is too large."));
        $uploadOk = 0;
        exit;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo json_encode(array("message" => "Sorry, only JPG, JPEG, PNG & GIF files are allowed."));
        $uploadOk = 0;
        exit;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo json_encode(array("message" => "Sorry, your file was not uploaded."));
        exit;
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            // Insert post into database
            $insertQuery = "INSERT INTO posts (user_id, content, image_path) VALUES ($userId, '$content', '$targetFile')";
            if (mysqli_query($conn, $insertQuery)) {
                echo json_encode(array("message" => "Post added successfully"));
            } else {
                echo json_encode(array("message" => "Error adding post"));
            }
        } else {
            echo json_encode(array("message" => "Sorry, there was an error uploading your file."));
        }
    }
}
?>
