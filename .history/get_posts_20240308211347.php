<?php
require_once 'connection.php'; // Include database connection script

// Handle GET request
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Fetch posts with full user details, likes, and last comment from the database
    $getPostsQuery = "";
    $result = mysqli_query($conn, $getPostsQuery);

    // Check if there are any posts
    if (mysqli_num_rows($result) > 0) {
        // Fetch all posts with user details, likes, and last comment into an array
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
