<?php
require_once 'connection.php'; // Include database connection script

// Handle GET request
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Fetch all posts with their details
    $getPostsQuery = "SELECT 
    posts.*, 
    users.username, 
    users.email, 
    COUNT(DISTINCT likes.id) AS likes_count, 
    COUNT(DISTINCT comments.id) AS comments_count,
    last_comment.user_id AS last_comment_user_id,
    last_like.user_id AS last_like_user_id,
    last_like.username AS last_like_username,
    last_like.email AS last_like_email
FROM posts 
INNER JOIN users ON posts.user_id = users.id 
LEFT JOIN likes ON posts.id = likes.post_id 
LEFT JOIN (
    SELECT 
        post_id, 
        MAX(created_at) AS max_created_at,
        user_id
    FROM comments
    GROUP BY post_id
) AS last_comment ON posts.id = last_comment.post_id
LEFT JOIN (
    SELECT 
        post_id, 
        MAX(created_at) AS max_created_at,
        user_id,
        u.username,
        u.email
    FROM likes
    INNER JOIN users AS u ON likes.user_id = u.id
    GROUP BY post_id
) AS last_like ON posts.id = last_like.post_id
GROUP BY posts.id;
";
    $result = mysqli_query($conn, $getPostsQuery);

    // Check if there are any posts
    if (mysqli_num_rows($result) > 0) {
        // Fetch all posts with their details into an array
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
