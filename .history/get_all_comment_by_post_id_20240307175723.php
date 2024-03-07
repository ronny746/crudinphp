<?php
require_once 'connection.php'; // Include database connection script

// Function to recursively retrieve nested comments
function getNestedComments($postId, $parentId = null) {
    global $conn;
    $comments = array();

    $query = "SELECT * FROM comments WHERE post_id = $postId AND parent_comment_id " . ($parentId ? "= $parentId" : "IS NULL");
    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        $comment = array(
            'id' => $row['id'],
            'user_id' => $row['user_id'],
            'content' => $row['content'],
            'created_at' => $row['created_at'],
            'replies' => array()
        );

        // Recursively get nested comments
        $comment['replies'] = getNestedComments($postId, $row['id']);

        $comments[] = $comment;
    }

    return $comments;
}

// Handle GET request with post ID parameter
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['post_id'])) {
    $postId = $_GET['post_id'];

    // Fetch top-level comments for the specified post ID
    $topLevelComments = getNestedComments($postId);

    // Echo the JSON-encoded response
    echo json_encode(array("message" => "Comments fetched successfully", "comments" => $topLevelComments));
} else {
    // Post ID parameter is missing
    echo json_encode(array("message" => "Post ID parameter is missing"));
}
?>
