<?php
require_once 'connection.php'; // Include database connection script

// Handle GET request to fetch all events
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Select all events from the database
    $selectEventsQuery = "SELECT * FROM events";
    $result = mysqli_query($conn, $selectEventsQuery);

    // Prepare array to hold events
    $events = array();

    // Check if there are any events
    if (mysqli_num_rows($result) > 0) {
        // Fetch events and store them in the array
        while ($row = mysqli_fetch_assoc($result)) {
            $event = array(
                'id' => $row['id'],
                'event_name' => $row['event_name'],
                'event_details' => $row['event_details'],
                'created_at' => $row['created_at']
                // Add more fields if needed
            );
            $events[] = $event;
        }
        // Return JSON response with events
        echo json_encode(array("message" => "Events fetched successfully", "events" => $events));
    } else {
        // No events found
        echo json_encode(array("message" => "No events found"));
    }
} else {
    // Invalid request method
    echo json_encode(array("message" => "Invalid request method"));
}
?>
