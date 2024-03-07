<?php
require_once 'connection.php'; // Include database connection script

// Handle GET request
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Fetch all posts with the details of the last like for each post
    $getPostsQuery = "SELECT p.*, 
                            u.username, 
                            u.email,
                            COUNT(DISTINCT likes.id) AS likes_count,
                            COUNT(DISTINCT comments.id) AS comments_count,
                            (SELECT l.user_id FROM likes l WHERE l.post_id = p.id ORDER BY l.created_at DESC LIMIT 1) AS last_like_user_id
                    FROM posts p
                    INNER JOIN users u ON p.user_id = u.id
                    LEFT JOIN likes ON p.id = likes.post_id
                    LEFT JOIN comments ON p.id = comments.post_id
                    GROUP BY p.id";
    $result = mysqli_query($conn, $getPostsQuery);

    // Check if there are any posts
    if (mysqli_num_rows($result) > 0) {
        // Fetch all posts with details of the last like into an array
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
