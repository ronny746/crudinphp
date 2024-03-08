<?php
require_once 'connection.php'; // Include database connection script

// Handle POST request to update an event
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input
    $eventId = $_POST["id"]; // Event ID to be updated
    $eventName = $_POST["event_name"];
    $eventDetails = $_POST["event_details"];

    if (empty($eventId) || empty($eventName) || empty($eventDetails)) {
        echo json_encode(array("message" => "Event ID, name, and details are required"));
        exit;
    }

    // Update the event in the database
    $updateEventQuery = "UPDATE events SET event_name = '$eventName', event_details = '$eventDetails' WHERE id = $eventId";
    if (mysqli_query($conn, $updateEventQuery)) {
        echo json_encode(array("message" => "Event updated successfully"));
    } else {
        echo json_encode(array("message" => "Error updating event"));
    }
} else {
    // Invalid request method
    echo json_encode(array("message" => "Invalid request method"));
}
?>
