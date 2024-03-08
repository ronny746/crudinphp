<?php
require_once 'connection.php'; // Include database connection script

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate required fields
    if (!isset($_POST['user_id']) || !isset($_POST['liked_by'])) {
        echo json_encode(array("message" => "User ID and liked_by are required"));
        exit;
    }

    
    $userId = $_POST['user_id'];
    $senderName = $_POST['liked_by'];
   

    $updateQuery = "UPDATE userevent SET messages_by = '$senderName',new_message = '$message' WHERE user_id = $userId";

    if (mysqli_query($conn, $updateQuery)) {
        echo json_encode(array("message" => "Event Sent successfully"));
    } else {
        echo json_encode(array("message" => "Error updating sender name: " . mysqli_error($conn)));
    }
} else {
    // Invalid request method
    echo json_encode(array("message" => "Invalid request method"));
}
?>
