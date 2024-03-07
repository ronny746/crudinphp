<?php
require_once 'connection.php'; // Include database connection script

// Handle POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve POST data
    $userId = $_POST["user_id"];
    $postId = $_POST["post_id"];
    

    
    // Validate inputs (you should add more validation)
    if (empty($userId) || empty($postId)) {
        echo json_encode(array("message" => "User ID and Post ID are required"));
        exit;
    }

    // Check if the user has already liked the post
    $selectQuery = "SELECT * FROM likes WHERE user_id = $userId AND post_id = $postId";
    $result = mysqli_query($conn, $selectQuery);
    
    if (mysqli_num_rows($result) > 0) {
        // If the user has already liked the post, delete the like (unlike)
        $deleteQuery = "DELETE FROM likes WHERE user_id = $userId AND post_id = $postId";
        if (mysqli_query($conn, $deleteQuery)) {
            echo json_encode(array("message" => "Post unliked successfully"));
        } else {
            echo json_encode(array("message" => "Error unliking post"));
        }
    } else {
        // If the user hasn't liked the post, insert a new like
        $insertQuery = "INSERT INTO likes (user_id, post_id) VALUES ($userId, $postId)";
        if (mysqli_query($conn, $insertQuery)) {
            echo json_encode(array("message" => "Post liked successfully"));
        } else {
            echo json_encode(array("message" => "Error liking post"));
        }
    }
}
?>
