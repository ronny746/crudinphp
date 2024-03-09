<?php
require_once 'connection.php'; // Include database connection script

// Handle GET request
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Fetch posts with full user details, likes, and last comment from the database
    $getPostsQuery = "SELECT 
                        posts.*, 
                        users.username, 
                        users.email, 
                        COUNT(DISTINCT likes.id) AS likes_count, 
                        COUNT(DISTINCT comments.id) AS comments_count,
                        MAX(comments.created_at) AS last_comment_at,
                        MAX(comments.id) AS last_comment_id,
                        MAX(comments.content) AS last_comment_content,
                        MAX(comments.user_id) AS last_comment_user_id,
                        u.username AS last_comment_username,
                        
               ";

    $result = mysqli_query($conn, $getPostsQuery);

    // Check if there are any posts
    if (mysqli_num_rows($result) > 0) {
        // Fetch all posts with user details, likes, and last comment into an array
        $posts = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $posts[] = $row;
        }

        // Echo the JSON-encoded response
        echo json_encode(array("message" => "Posts fetched successfully", "posts" => $posts));
    } else {
        // No posts found
        echo json_encode(array("message" => "No posts found"));
    }
}
?>
