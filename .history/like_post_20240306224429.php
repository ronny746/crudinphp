<?php
require_once 'connection.php'; // Include database connection script

// Handle POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    // Check if user is logged in
    if (isset($_SESSION["user_id"])) {
        echo json_encode(array("message" => "You must be logged in to like a post"));
        exit;
    }
    
    // Retrieve POST data
    $userId = $_SESSION["user_id"];
    $postId = $_POST["post_id"];

    // Validate inputs (you should add more validation)
    if (empty($postId)) {
        echo json_encode(array("message" => "Post ID is required"));
        exit;
    }

    // Check if the user has already liked the post
    $selectQuery = "SELECT * FROM likes WHERE user_id = $userId AND post_id = $postId";
    $result = mysqli_query($conn, $selectQuery);
    if (mysqli_num_rows($result) > 0) {
        echo json_encode(array("message" => "You have already liked this post"));
        exit;
    }

    // Insert like into database
    $insertQuery = "INSERT INTO likes (user_id, post_id) VALUES ($userId, $postId)";
    if (mysqli_query($conn, $insertQuery)) {
        echo json_encode(array("message" => "Post liked successfully"));
    } else {
        echo json_encode(array("message" => "Error liking post"));
    }
}
?>
