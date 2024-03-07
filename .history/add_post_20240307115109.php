<?php
require_once 'connection.php'; // Include database connection script

// Handle POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are provided
    if (!isset($_POST['content']) || !isset($_FILES['image'])) {
        echo json_encode(array("message" => "Content and image are required"));
        exit;
    }

    // Retrieve POST data
    $content = $_POST['content'];
    $userId = 1; // Assuming user_id is hard-coded for simplicity

    // File upload handling
    $targetDirectory = "uploads/";
    $targetFile = $targetDirectory . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check === false) {
        echo json_encode(array("message" => "File is not an image."));
        $uploadOk = 0;
        exit;
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
        // If everything is ok, try to upload file
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            // Insert post into database with image path
            // $imagePath = $targetFile;
            // $insertQuery = "INSERT INTO posts (user_id, content, image_path) VALUES ('$userId', '$content', '$imagePath')";
            // if (mysqli_query($conn, $insertQuery)) {
            //     echo json_encode(array("message" => "Post added successfully"));
            // } else {
            //     echo json_encode(array("message" => "Error adding post"));
            // }
        } else {
            echo json_encode(array("message" => "Sorry, there was an error uploading your file."));
        }
    }
}
?>