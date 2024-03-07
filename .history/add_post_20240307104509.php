<?php
require_once 'connection.php';

// Check if image and content are set in the POST request
if (isset($_FILES['image']['name']) && isset($_POST['content'])) {
    $image = $_FILES['image']['name'];
    $content = $_POST['content'];
    $userId = 1; // Assuming user_id is hard-coded for simplicity

    $imagePath = 'uploads/' . $image;
    $tmp_name = $_FILES['image']['tmp_name'];

    // Move uploaded image to the target directory
    if (move_uploaded_file($tmp_name, $imagePath)) {
        // Prepare SQL query to insert post data into the database
        $insertQuery = "INSERT INTO posts (content, user_id, image_path) VALUES ('$content', '$userId', '$image')";
        
        // Execute the SQL query
        if (mysqli_query($conn, $insertQuery)) {
            echo json_encode(array("message" => "Post added successfully"));
        } else {
            echo json_encode(array("message" => "Error adding post"));
        }
    } else {
        echo json_encode(array("message" => "Error uploading image"));
    }
} else {
    echo json_encode(array("message" => "Image and content are required"));
}
?>
