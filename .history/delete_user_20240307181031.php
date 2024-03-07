<?php
require_once 'connection.php'; // Include database connection script

// Function to delete a user and related data
function deleteUser($userId) {
    global $conn;

    // Delete user
    $deleteUserQuery = "DELETE FROM users WHERE id = $userId";
    $result = mysqli_query($conn, $deleteUserQuery);

    if ($result) {
        // User deleted successfully
        return true;
    } else {
        // Error deleting user
        return false;
    }
}

// Handle DELETE request with user ID parameter
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['user_id'])) {
    $userId = $_GET['user_id'];

    // Delete user and related data
    if (deleteUser($userId)) {
        echo json_encode(array("message" => "User and related data deleted successfully"));
    } else {
        echo json_encode(array("message" => "Error deleting user and related data"));
    }
} else {
    // User ID parameter is missing
    echo json_encode(array("message" => "User ID parameter is missing"));
}
?>
