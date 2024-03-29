<?php
require_once 'connection.php'; // Include database connection script

// Handle POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Retrieve POST data
    $userId = $_POST["user_id"];
    $postId = $_POST["post_id"];
    $content = $_POST["content"];

     // Check if the user exists in the database
	$checkUserQuery = "SELECT * FROM users WHERE id = '$userId'";
    $userResult = mysqli_query($conn, $checkUserQuery);
    if (mysqli_num_rows($userResult) == 0) {
        echo json_encode(array("message" => "User does not exist"));
        exit;
    }

    // Validate inputs (you should add more validation)
    if (empty($postId) || empty($content)) {
        echo json_encode(array("message" => "Post ID and content are required"));
        exit;
    }


    // Insert comment into database
    $insertQuery = "INSERT INTO comments (user_id, post_id, content) VALUES ($userId, $postId, '$content')";
    if (mysqli_query($conn, $insertQuery)) {
        echo json_encode(array("message" => "Comment added successfully"));
    } else {
        echo json_encode(array("message" => "Error adding comment"));
    }
}
?>
