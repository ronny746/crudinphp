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
    $parentCommentId = $_POST["parent_comment_id"];
    $content = $_POST["content"];

    // Validate inputs (you should add more validation)
    if (empty($postId) || empty($parentCommentId) || empty($content)) {
        echo json_encode(array("message" => "Post ID, parent comment ID, and content are required"));
        exit;
    }

    // Insert nested comment into database
    $insertQuery = "INSERT INTO comments (user_id, post_id, parent_comment_id, content) VALUES ($userId, $postId, $parentCommentId, '$content')";
    if (mysqli_query($conn, $insertQuery)) {
        echo json_encode(array("message" => "Nested comment added successfully"));
    } else {
        echo json_encode(array("message" => "Error adding nested comment"));
    }
}
?>
