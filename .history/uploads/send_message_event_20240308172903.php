<?php
require_once 'connection.php'; // Include database connection script

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve POST data from the request body
    $postData = json_decode(file_get_contents("php://input"), true);

    // Validate required fields
    if (!isset($postData['user_id']) || !isset($postData['sender_name'])) {
        echo json_encode(array("message" => "User ID and sender name are required"));
        exit;
    }

    
    $userId = $postData['user_id'];
    $senderName = $postData['sender_name'];

    // Update the messages_by field for the specified user
    $updateQuery = "UPDATE userevent SET messages_by = '$senderName' WHERE user_id = $userId";

    // Execute the update query
    if (mysqli_query($conn, $updateQuery)) {
        echo json_encode(array("message" => "Sender name updated successfully"));
    } else {
        echo json_encode(array("message" => "Error updating sender name: " . mysqli_error($conn)));
    }
} else {
    // Invalid request method
    echo json_encode(array("message" => "Invalid request method"));
}
?>
