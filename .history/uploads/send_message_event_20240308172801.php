<?php
require_once 'connection.php'; // Include database connection script

$userId = 1; 
$senderName = "John Doe"; // Replace "John Doe" with the actual sender's name

// Update the messages_by field for the specified user
$updateQuery = "UPDATE userevent SET messages_by = '$senderName' WHERE user_id = $userId";

// Execute the update query
if (mysqli_query($conn, $updateQuery)) {
    echo json_encode(array("message" => "Sender name updated successfully"));
} else {
    echo json_encode(array("message" => "Error updating sender name: " . mysqli_error($conn)));
}
?>
