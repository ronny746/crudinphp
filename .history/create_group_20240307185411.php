<?php
require_once 'connection.php'; // Include database connection script

// Handle POST request to create a group
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input
    $groupName = $_POST["group_name"];
    $adminId = $_POST["admin_id"]; // ID of the user who creates the group

    // Insert group into the database
    $insertGroupQuery = "INSERT INTO groups (name, admin_id) VALUES ('$groupName', '$adminId')";
    if (mysqli_query($conn, $insertGroupQuery)) {
        // Get the ID of the newly inserted group
        $groupId = mysqli_insert_id($conn);

        // Insert admin user into user_groups table
        $insertAdminGroupQuery = "INSERT INTO user_groups (user_id, group_id) VALUES ('$adminId', '$groupId')";
        mysqli_query($conn, $insertAdminGroupQuery);

        echo json_encode(array("message" => "Group created successfully"));
    } else {
        echo json_encode(array("message" => "Error creating group"));
    }
} else {
    // Invalid request method
    echo json_encode(array("message" => "Invalid request method"));
}
?>

<?php
// Handle POST request to join a group
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input
    $userId = $_POST["user_id"]; // ID of the user who wants to join the group
    $groupId = $_POST["group_id"]; // ID of the group to join

    // Insert user into the group
    $insertUserGroupQuery = "INSERT INTO user_groups (user_id, group_id) VALUES ('$userId', '$groupId')";
    if (mysqli_query($conn, $insertUserGroupQuery)) {
        echo json_encode(array("message" => "User joined the group successfully"));
    } else {
        echo json_encode(array("message" => "Error joining the group"));
    }
} else {
    // Invalid request method
    echo json_encode(array("message" => "Invalid request method"));
}
?>
