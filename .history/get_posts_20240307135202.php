<!-- <?php
require_once 'connection.php'; // Include database connection script

// Handle GET request
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Fetch posts with full user details, likes, and last comment from the database
    $getPostsQuery = "SELECT posts.*, 
                            users.username, 
                            users.email, 
                            COUNT(DISTINCT likes.id) AS likes_count, 
                            COUNT(DISTINCT comments.id) AS comments_count,
                            MAX(comments.created_at) AS last_comment_at,
                            MAX(comments.id) AS last_comment_id,
                            MAX(comments.content) AS last_comment_content,
                            MAX(comments.user_id) AS last_comment_user_id,
                            u.username AS last_comment_username
                    FROM posts 
                    INNER JOIN users ON posts.user_id = users.id 
                    LEFT JOIN likes ON posts.id = likes.post_id 
                    LEFT JOIN comments ON posts.id = comments.post_id 
                    LEFT JOIN users u ON comments.user_id = u.id
                    GROUP BY posts.id";
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
?> -->


<?php
require_once 'connection.php'; // Include database connection script

// Handle GET request with user ID parameter
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['user_id'])) {
    $userId = $_GET['user_id'];

    // Fetch posts with user details and check if liked by the specified user
    $getPostsQuery = "SELECT posts.*, 
                            users.username, 
                            users.email,
                            COUNT(DISTINCT likes.id) AS likes_count,
                            COUNT(DISTINCT comments.id) AS comments_count,
                            IF(COUNT(likes.id) > 0, 1, 0) AS liked_by_user
                    FROM posts 
                    INNER JOIN users ON posts.user_id = users.id 
                    LEFT JOIN likes ON posts.id = likes.post_id AND likes.user_id = $userId
                    LEFT JOIN comments ON posts.id = comments.post_id
                    WHERE posts.user_id = $userId
                    GROUP BY posts.id";
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
        // No posts found for the user
        echo json_encode(array("message" => "No posts found for the specified user"));
    }
} else {
    // User ID parameter is missing
    echo json_encode(array("message" => "User ID parameter is missing"));
}
?>