<?php
require_once 'connection.php'; // Include database connection script

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input parameters
    if (!isset($_POST['user_id']) || !isset($_POST['event_type'])) {
        echo json_encode(array("message" => "User ID and event type are required"));
        exit;
    }

    // Retrieve POST data
    $userId = $_POST['user_id'];
    $eventType = $_POST['event_type'];

    // Set m value based on event type
    $mValue = $eventType === 'new_message' ? 1 : 0;

    // Process the request and insert the event into the database
    $insertQuery = "INSERT INTO events (user_id, event_type, m) VALUES ('$userId', '$eventType', '$mValue')";
    if (mysqli_query($conn, $insertQuery)) {
        echo json_encode(array("message" => "Event added successfully"));
    } else {
        echo json_encode(array("message" => "Error adding event"));
    }
} else {
    // Invalid request method
    echo json_encode(array("message" => "Invalid request method"));
}
?>
