<?php
require_once 'connection.php'; // Include database connection script

// Handle POST request to create a group
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input
    $groupName = $_POST["group_name"];
    $adminId = $_POST["admin_id"];
    $userIds = isset($_POST["user_ids"]) ? $_POST["user_ids"] : array(); // User IDs to be added to the group

    // Insert group into the database
    $insertGroupQuery = "INSERT INTO groups (name, admin_id) VALUES ('$groupName', '$adminId')";
    if (mysqli_query($conn, $insertGroupQuery)) {
        // Get the ID of the newly inserted group
        $groupId = mysqli_insert_id($conn);
        
        // Associate admin with the group
        $insertAdminGroupQuery = "INSERT INTO user_groups (user_id, group_id) VALUES ('$adminId', '$groupId')";
        mysqli_query($conn, $insertAdminGroupQuery);

        // Associate other users with the group
        foreach ($userIds as $userId) {
            $insertUserGroupQuery = "INSERT INTO user_groups (user_id, group_id) VALUES ('$userId', '$groupId')";
            mysqli_query($conn, $insertUserGroupQuery);
        }

        echo json_encode(array("message" => "Group created successfully"));
    } else {
        echo json_encode(array("message" => "Error creating group"));
    }
} else {
    // Invalid request method
    echo json_encode(array("message" => "Invalid request method"));
}
?>
