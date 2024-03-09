<?php
require_once 'connection.php'; // Include database connection script

// Handle GET request
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Fetch all posts with their details
    $getPostsQuery = "SELECT posts.*, 
                            users.username, 
                            users.email,
                            COUNT(DISTINCT likes.id) AS likes_count,
                            COUNT(DISTINCT comments.id) AS comments_count,
                            MAX(likes.created_at) AS last_like_by

                    FROM posts 
                    INNER JOIN users ON posts.user_id = users.id 
                    LEFT JOIN likes ON posts.id = likes.post_id 
                    LEFT JOIN comments ON posts.id = comments.post_id 
                    GROUP BY posts.id";
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
