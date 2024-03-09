<?php
require_once 'connection.php'; // Include database connection script

// Handle GET request
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Fetch posts with full user details, likes, and last comment from the database
    SELECT posts.*, 
       users.username AS post_username, 
       users.email AS post_email, 
       COUNT(DISTINCT likes.id) AS likes_count, 
       COUNT(DISTINCT comments.id) AS comments_count,
       MAX(comments.created_at) AS last_comment_at,
       MAX(comments.id) AS last_comment_id,
       MAX(comments.content) AS last_comment_content,
       MAX(comments.user_id) AS last_comment_user_id,
       MAX(likes.created_at) AS last_like_at,
       users_like.username AS last_like_username
FROM posts 
INNER JOIN users ON posts.user_id = users.id 
LEFT JOIN likes ON posts.id = likes.post_id 
LEFT JOIN comments ON posts.id = comments.post_id 
LEFT JOIN users AS users_like ON likes.user_id = users_like.id
GROUP BY posts.id;

    $result = mysqli_query($conn, $getPostsQuery);

    // Check if there are any posts
    if (mysqli_num_rows($result) > 0) {
       // Fetch all posts with user details into an array
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
