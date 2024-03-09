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
    last_comment.id AS last_comment_id,
    last_comment.content AS last_comment_content,
    last_comment.created_at AS last_comment_created_at,
    last_comment.user_id AS last_comment_user_id,
    last_comment.username AS last_comment_username
FROM posts 
INNER JOIN users ON posts.user_id = users.id 
LEFT JOIN likes ON posts.id = likes.post_id 
LEFT JOIN (
    SELECT 
        c1.id, 
        c1.content, 
        c1.created_at, 
        c1.user_id, 
        u.username
    FROM comments c1
    INNER JOIN (
        SELECT 
            post_id, 
            MAX(created_at) AS max_created_at
        FROM comments
        GROUP BY post_id
    ) c2 ON c1.post_id = c2.post_id AND c1.created_at = c2.max_created_at
    LEFT JOIN users u ON c1.user_id = u.id
) AS last_comment ON posts.id = last_comment.post_id
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
