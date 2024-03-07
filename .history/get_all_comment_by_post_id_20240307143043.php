<?php
require_once 'connection.php'; // Include database connection script

// Handle GET request with post ID parameter
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['post_id'])) {
    $postId = $_GET['post_id'];

    // Fetch comments, user IDs, and creation timestamps for the specified post ID
    $getCommentsQuery = "SELECT content, user_id, created_at
                         FROM comments 
                         WHERE post_id = $postId";
    $result = mysqli_query($conn, $getCommentsQuery);

    // Check if there are any comments
    if (mysqli_num_rows($result) > 0) {
        // Fetch comments, user IDs, and creation timestamps into an array
        $comments = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $comments[] = $row;
        }

        // Echo the JSON-encoded response
        echo json_encode(array("message" => "Comments fetched successfully", "comments" => $comments));
    } else {
        // No comments found for the specified post ID
        echo json_encode(array("success"=>"true","message" => "No comments found for the specified post ID"));
    }
} else {
    // Post ID parameter is missing
    echo json_encode(array("success"=>"false","message" => "Post ID parameter is missing"));
}
?>
