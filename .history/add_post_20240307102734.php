<?php
require_once 'db_connection.php'; // Include database connection script

// Handle POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    
    // Check if user is logged in
    if (!isset($_SESSION["user_id"])) {
        echo json_encode(array("message" => "You must be logged in to add a post"));
        exit;
    }

    // Retrieve POST data
    $userId = $_SESSION["user_id"];
    $content = $_POST["content"];

    // Check if all required fields are provided
    if (empty($content)) {
        echo json_encode(array("message" => "Content is required"));
        exit;
    }

    // File upload handling
    if (isset($_FILES["image"])) {
        $targetDirectory = "uploads/"; // Directory where images will be stored
        $targetFile = $targetDirectory . basename($_FILES["image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if file is an actual image or fake image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check === false) {
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

        // Allow only certain file formats
        if (!in_array($imageFileType, array("jpg", "jpeg", "png", "gif"))) {
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
                $insertQuery = "INSERT INTO posts (user_id, content, image_path) VALUES ($userId, '$content', '$targetFile')";
                if (mysqli_query($conn, $insertQuery)) {
                    echo jso
