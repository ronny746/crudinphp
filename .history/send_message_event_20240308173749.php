<?php
require_once 'connection.php'; // Include database connection script

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve POST data from the request body

    // Validate required fields
    if (!isset($_POST['user_id']) || !isset($_POST['sender_name']) || !isset($_POST['message'])) {
        echo json_encode(array("message" => "User ID , sender name  and are required"));
        exit;
    }

    
    $userId = $_POST['user_id'];
    $senderName = $_POST['sender_name'];

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
