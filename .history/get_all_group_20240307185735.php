<?php
require_once 'connection.php'; // Include database connection script

// Handle GET request to fetch all groups
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Select all groups from the database
    $selectGroupsQuery = "SELECT * FROM groups";
    $result = mysqli_query($conn, $selectGroupsQuery);

    // Prepare array to hold groups
    $groups = array();

    // Check if there are any groups
    if (mysqli_num_rows($result) > 0) {
        // Fetch groups and store them in the array
        while ($row = mysqli_fetch_assoc($result)) {
            $group = array(
                'id' => $row['id'],
                'name' => $row['name']
                // Add more fields if needed
            );
            $groups[] = $group;
        }
        // Return JSON response with groups
        echo json_encode(array("message" => "Groups fetched successfully", "groups" => $groups));
    } else {
        // No groups found
        echo json_encode(array("message" => "No groups found"));
    }
} else {
    // Invalid request method
    echo json_encode(array("message" => "Invalid request method"));
}
?>
