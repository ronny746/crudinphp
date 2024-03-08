<?php
require_once 'connection.php'; // Include database connection script

// Handle POST request for user registration
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input parameters
    if (!isset($_POST['username']) || !isset($_POST['email']) || !isset($_POST['password'])) {
        echo json_encode(array("message" => "Username, email, and password are required"));
        exit;
    }

    // Retrieve POST data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $checkUserQuery = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $checkUserQuery);
    if (mysqli_num_rows($result) > 0) {
        // User already exists, return an error message
        echo json_encode(array("message" => "User with email $email already exists"));
        exit;
    }

    // Insert new user into the database
    $insertQuery = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
    if (mysqli_query($conn, $insertQuery)) {
        // Retrieve the inserted user's ID
        $userId = mysqli_insert_id($conn);

        // Insert events for the new user
        $addEventQuery = "INSERT INTO userevent (user_id, new_message, general_message, timestamp)
                          VALUES ('$userId', 'Welcome to our platform! Start exploring.', 'You have successfully registered.', NOW())";
        if (mysqli_query($conn, $addEventQuery)) {
            echo json_encode(array("message" => "User registered successfully with events"));
        } else {
            echo json_encode(array("message" => "User registered successfully, but failed to add events"));
        }
    } else {
        echo json_encode(array("message" => "Error registering user"));
    }
} else {
    // Invalid request method
    echo json_encode(array("message" => "Invalid request method"));
}
?>
