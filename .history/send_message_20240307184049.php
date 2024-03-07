<?php

require_once 'connection.php'; // Include database connection script
// Handle POST request to send a message
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input
    $senderId = $_POST["sender_id"];
    $receiverId = $_POST["receiver_id"];
    $message = $_POST["message"];

    // Save message to the database
    $insertQuery = "INSERT INTO messages (sender_id, receiver_id, message) VALUES ('$senderId', '$receiverId', '$message')";
    // Execute insert query and handle response
}

?>