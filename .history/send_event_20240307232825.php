<?php
require_once 'connection.php'; // Include database connection script

// Handle POST request to add an event
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input
    $eventName = $_POST["event_name"];
    $eventDetails = $_POST["event_details"];

    if (empty($eventName) || empty($eventDetails)) {
        echo json_encode(array("message" => "Event name and details are required"));
        exit;
    }

    // Insert the event into the database
    $insertEventQuery = "INSERT INTO events (event_name, event_details) VALUES ('$eventName', '$eventDetails')";
    if (mysqli_query($conn, $insertEventQuery)) {
        echo json_encode(array("message" => "Event added successfully"));
    } else {
        echo json_encode(array("message" => "Error adding event"));
    }
} else {
    // Invalid request method
    echo json_encode(array("message" => "Invalid request method"));
}
?>
