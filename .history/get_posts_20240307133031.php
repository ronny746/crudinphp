<?php
require_once 'connection.php'; // Include database connection script

// Retrieve posts with user details
$selectQuery = "SELECT posts.*, users.username, users.email FROM posts INNER JOIN users ON posts.user_id = users.id";
$result = mysqli_query($conn, $selectQuery);

if (mysqli_num_rows($result) > 0) {
    $posts = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $post = array(
            "id" => $row["id"],
            "user_id" => $row["user_id"],
            "username" => $row["username"],
            "email" => $row["email"],
            "content" => $row["content"],
            "created_at" => $row["created_at"]
        );
        $posts[] = $post;
    }
    echo json_encode(array("posts" => $post));
} else {
    echo json_encode(array("message" => "No posts found"));
}
?>
