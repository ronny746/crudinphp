<?php
require_once 'db_connection.php'; // Include database connection script

// Handle POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    // Check if user is logged in
    if (!isset($_SESSION["user_id"])) {
        echo json_encode(array("message" => "You must be logged in to add a comment"));
        exit;
    }
    
    // Retrieve POST data
    $userId = $_SESSION["user_id"];
    $postId = $_POST["post_id"];
    $content = $_POST["content"];

    // Validate inputs (you should add more validation)
    if (empty($postId) || empty($content)) {
        echo json_encode(array("message" => "Post ID and content are required"));
        exit;
    }

    // Insert comment into database
    $insertQuery = "INSERT INTO comments (user_id, post_id, content) VALUES ($userId, $postId, '$content')";
    if (mysqli_query($conn, $insertQuery)) {
        echo json_encode(array("message" => "Comment added successfully"));
    } else {
        echo json_encode(array("message" => "Error adding comment"));
    }
}
?>
