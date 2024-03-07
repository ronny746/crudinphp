<?php
require_once 'connection.php'; // Include database connection script

// Handle DELETE request with post ID and user ID parameters
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['post_id']) && isset($_GET['user_id'])) {
    $postId = $_GET['post_id'];
    $userId = $_GET['user_id'];

    // Check if the post exists and the user owns the post
    $checkPostQuery = "SELECT * FROM posts WHERE id = $postId AND user_id = $userId";
    $checkResult = mysqli_query($conn, $checkPostQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        // Delete the post
        $deletePostQuery = "DELETE FROM posts WHERE id = $postId";
        if (mysqli_query($conn, $deletePostQuery)) {
            echo json_encode(array("message" => "Post deleted successfully"));
        } else {
            echo json_encode(array("message" => "Error deleting post"));
        }
    } else {
        // Post not found or user does not own the post
        echo json_encode(array("message" => "Either the post does not exist or you do not have permission to delete it"));
    }
} else {
    // Post ID or User ID parameter is missing
    echo json_encode(array("message" => "Post ID or User ID parameter is missing or invalid"));
}
?>
