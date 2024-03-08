<?php
// Include database connection script
require_once 'connection.php';

// Initialize response array
$response = array();

// Check if the request method is GET and event_id parameter is set
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['event_id'])) {
    // Sanitize the event_id parameter to prevent SQL injection
    $eventId = mysqli_real_escape_string($conn, $_GET['event_id']);

    // Fetch event details for the specified event ID
    $getEventQuery = "SELECT * FROM events WHERE id = $eventId";
    $result = mysqli_query($conn, $getEventQuery);

    // Check if event exists
    if (mysqli_num_rows($result) > 0) {
        // Fetch event details into an associative array
        $event = mysqli_fetch_assoc($result);

        // Add event details to the response
        $response['message'] = "Event details fetched successfully";
        $response['event'] = $event;
    } else {
        // Event not found for the specified ID
        $response['message'] = "Event not found for the specified ID";
    }
} else {
    // Event ID parameter is missing or request method is not GET
    $response['message'] = "Invalid request";
}

// Set response header to JSON
header('Content-Type: application/json');

// Send the JSON response
echo json_encode($response);
?>
