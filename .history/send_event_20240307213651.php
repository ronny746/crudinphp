<?php
require_once 'connection.php'; // Include database connection script

// Handle POST request to create an event
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Parse the request body as JSON
    $requestData = json_decode(file_get_contents('php://input'), true);
    
    // Check if the required data is present
    if (isset($requestData['event_name']) && isset($requestData['event_details'])) {
        // Extract event details from the request
        $eventName = $requestData['event_name'];
        $eventDetails = $requestData['event_details'];

        // Insert the event into the database
        $insertEventQuery = "INSERT INTO events (event_name, event_details) VALUES ('$eventName', '$eventDetails')";
        if (mysqli_query($conn, $insertEventQuery)) {
            // Event inserted successfully
            echo json_encode(array("message" => "Event created successfully"));
        } else {
            // Failed to insert event
            echo json_encode(array("message" => "Failed to create event"));
        }
    } else {
        // Required data is missing
        echo json_encode(array("message" => "Event name or details are missing"));
    }
} else {
    // Invalid request method
    echo json_encode(array("message" => "Invalid request method"));
}
?>
