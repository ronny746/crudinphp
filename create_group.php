<?php
require_once 'connection.php'; // Include database connection script

// Handle POST request to create a group
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input
    $groupName = $_POST["group_name"];

    // Insert group into the database
    $insertGroupQuery = "INSERT INTO groups (name) VALUES ('$groupName')";
    
    if (mysqli_query($conn, $insertGroupQuery)) {
        echo json_encode(array("message" => "Group created successfully"));
    } else {
        echo json_encode(array("message" => "Error creating group"));
    }
} else {
    // Invalid request method
    echo json_encode(array("message" => "Invalid request method"));
}
?>
