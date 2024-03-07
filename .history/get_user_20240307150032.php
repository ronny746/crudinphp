<?php
require_once 'connection.php'; // Include database connection script

// Handle GET request with user ID parameter
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['user_id'])) {
    $userId = $_GET['user_id'];

    // Fetch user details for the specified user ID
    $getUserQuery = "SELECT * FROM users WHERE id = $userId";
    $result = mysqli_query($conn, $getUserQuery);

    // Check if user exists
    if (mysqli_num_rows($result) > 0) {
        // Fetch user details into an array
        $user = mysqli_fetch_assoc($result);
        
        // Echo the JSON-encoded response
        echo json_encode(array("message" => "User details fetched successfully", "user" => $user));
    } else {
        // User not found for the specified ID
        echo json_encode(array("message" => "User not found for the specified ID"));
    }
} else {
    // User ID parameter is missing
    echo json_encode(array("message" => "User ID parameter is missing"));
}
?>
