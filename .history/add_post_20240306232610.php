<?php
$targetDirectory = "uploads/"; // Directory where uploaded images will be stored

// Check if file was uploaded without errors
if (isset($_FILES["image"]) && $_FILES["image"]["error"] === 0) {
    $targetFile = $targetDirectory . basename($_FILES["image"]["name"]);
    
    // Check if file already exists
    if (file_exists($targetFile)) {
        echo "Sorry, file already exists.";
    } else {
        // Move uploaded file to target directory
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            echo "The file " . basename($_FILES["image"]["name"]) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
} else {
    echo "Error: " . $_FILES["image"]["error"];
}
?>
