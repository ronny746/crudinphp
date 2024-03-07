<?php
require_once 'connection.php'; // Include database connection script

// Handle GET request
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Fetch all posts along with their nested comments
    $getPostsQuery = "WITH RECURSIVE NestedComments AS (
                            SELECT id, parent_comment_id, content, user_id, created_at
                            FROM comments
                            WHERE parent_comment_id IS NULL
                            UNION ALL
                            SELECT c.id, c.parent_comment_id, c.content, c.user_id, c.created_at
                            FROM comments c
                            JOIN NestedComments nc ON c.parent_comment_id = nc.id
                        )
                        SELECT posts.*, 
                            users.username, 
                            users.email,
                            COUNT(DISTINCT likes.id) AS likes_count,
                            COUNT(DISTINCT comments.id) AS comments_count,
                            JSON_ARRAYAGG(JSON_OBJECT('id', NestedComments.id, 'parent_comment_id', NestedComments.parent_comment_id, 'content', NestedComments.content, 'user_id', NestedComments.user_id, 'created_at', NestedComments.created_at)) AS nested_comments
                        FROM posts 
                        INNER JOIN users ON posts.user_id = users.id 
                        LEFT JOIN likes ON posts.id = likes.post_id 
                        LEFT JOIN comments ON posts.id = comments.post_id 
                        LEFT JOIN NestedComments ON comments.id = NestedComments.parent_comment_id
                        GROUP BY posts.id";
    
    $result = mysqli_query($conn, $getPostsQuery);

    // Check if there are any posts
    if (mysqli_num_rows($result) > 0) {
        // Fetch all posts with their nested comments into an array
        $posts = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $row['nested_comments'] = json_decode($row['nested_comments'], true); // Decode nested comments JSON
            $posts[] = $row;
        }

        // Echo the JSON-encoded response
        echo json_encode(array("message" => "Posts with nested comments fetched successfully", "posts" => $posts));
    } else {
        // No posts found
        echo json_encode(array("message" => "No posts found"));
    }
}
?>
