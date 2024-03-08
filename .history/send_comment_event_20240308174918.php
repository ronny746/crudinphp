<?php
require_once 'connection.php'; // Include database connection script

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate required fields
    if (!isset($_POST['user_id']) || !isset($_POST['commented_by'])) {
        echo json_encode(array("message" => "User ID and commented_by are required"));
        exit;
    }

    $userId = $_POST['user_id'];
    $liked_by = $_POST['commented_by'];
   

    $updateQuery = "UPDATE userevent SET liked_by = '$liked_by' WHERE user_id = $userId";

    if (mysqli_query($conn, $updateQuery)) {
        echo json_encode(array("message" => "Event Sent successfully"));
    } else {
        echo json_encode(array("message" => "Error updating sender name: " . mysqli_error($conn)));
    }
} else {
    // Invalid request method
    echo json_encode(array("message" => "Invalid request method"));
}
?>
