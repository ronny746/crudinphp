<?php
require_once 'connection.php'; // Include database connection script

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

    // Validate inputs (you should add more validation)
    if (empty($content)) {
        echo json_encode(array("message" => "Content is required"));
        exit;
    }

    // Insert post into database
    $insertQuery = "INSERT INTO posts (user_id, content) VALUES ($userId, '$content')";
    if (mysqli_query($conn, $insertQuery)) {
        echo json_encode(array("message" => "Post added successfully"));
    } else {
        echo json_encode(array("message" => "Error adding post"));
    }
}
?>
