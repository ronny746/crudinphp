<?php
require_once 'connection.php'; // Include database connection script

// Handle GET request to fetch messages between two users
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Validate input
    $userId1 = $_GET["user_id_1"];
    $userId2 = $_GET["user_id_2"];

    // Fetch messages from the database
    $selectQuery = "SELECT * FROM messages WHERE (sender_id = '$userId1' AND receiver_id = '$userId2') OR (sender_id = '$userId2' AND receiver_id = '$userId1') ORDER BY sent_at DESC";
    $result = mysqli_query($conn, $selectQuery);

    // Prepare array to hold messages
    $messages = array();

    // Check if there are any messages
    if (mysqli_num_rows($result) > 0) {
        // Fetch messages and store them in the array
        while ($row = mysqli_fetch_assoc($result)) {
            $message = array(
                'id' => $row['id'],
                'sender_id' => $row['sender_id'],
                'receiver_id' => $row['receiver_id'],
                'message' => $row['message'],
                'sent_at' => $row['sent_at']
            );
            $messages[] = $message;
        }
        // Return JSON response with messages
        echo json_encode(array("message" => "Messages fetched successfully", "messages" => $messages));
    } else {
        // No messages found
        echo json_encode(array("message" => "No messages found"));
    }
} else {
    // Invalid request method
    echo json_encode(array("message" => "Invalid request method"));
}
?>
