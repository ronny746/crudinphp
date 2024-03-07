<?php
require_once 'connection.php'; // Include database connection script

// Handle GET request
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Fetch posts with full user details, last comment, last like, and last like user name from the database
    $getPostsQuery = "SELECT posts.*, 
                            users.username, 
                            users.email, 
                            COUNT(DISTINCT likes.id) AS likes_count, 
                            COUNT(DISTINCT comments.id) AS comments_count,
                            MAX(comments.created_at) AS last_comment_at,
                            MAX(likes.created_at) AS last_like_at,
                            (SELECT username FROM users AS u INNER JOIN likes AS l ON u.id = l.user_id WHERE l.post_id = posts.id ORDER BY l.created_at DESC LIMIT 1) AS last_like_username
                    FROM posts 
                    INNER JOIN users ON posts.user_id = users.id 
                    LEFT JOIN likes ON posts.id = likes.post_id 
                    LEFT JOIN comments ON posts.id = comments.post_id 
                    GROUP BY posts.id";
    $result = mysqli_query($conn, $getPostsQuery);

    // Check if there are any posts
    if (mysqli_num_rows($result) > 0) {
        // Fetch all posts with user details, likes count, comments count, last comment, last like, and last like username into an array
        $posts = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $posts[] = $row;
        }

        // Group posts by user id
        $users = array();
        foreach ($posts as $post) {
            $userId = $post['user_id'];
            if (!isset($users[$userId])) {
                $users[$userId] = array(
                    'id' => $post['user_id'],
                    'username' => $post['username'],
                    'email' => $post['email'],
                    'posts' => array()
                );
            }
            // Remove user details from post and add it to user's posts
            unset($post['user_id']);
            unset($post['username']);
            unset($post['email']);
            $users[$userId]['posts'][] = $post;
        }

        // Echo the JSON-encoded response with users variable
        echo json_encode(array("message" => "Posts fetched successfully", "users" => array_values($users)));
    } else {
        // No posts found
        echo json_encode(array("message" => "No posts found"));
    }
}
?>
