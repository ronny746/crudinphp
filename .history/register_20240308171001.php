<?php
require_once 'connection.php'; // Include database connection script

// Handle POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve POST data
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Validate inputs (you should add more validation)
    if (empty($username) || empty($email) || empty($password)) {
        echo json_encode(array("message" => "All fields are required"));
        exit;
    }

    // Check if username/email already exists
    $checkQuery = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
    $result = mysqli_query($conn, $checkQuery);
    if (mysqli_num_rows($result) > 0) {
        echo json_encode(array("message" => "Username or email already exists"));
        exit;
    }

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert user into database
    $insertQuery = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashedPassword')";
    if (mysqli_query($conn, $insertQuery)) {
        $selectUserQuery = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $selectUserQuery);
        $userData = mysqli_fetch_assoc($result);
        $userId = 
        $insertQuery = "INSERT INTO userevent (user_id) VALUES ('$userId', '$eventValue')";
        echo json_encode(array("message" => "User registered successfully"));

    } else {
        echo json_encode(array("message" => "Error registering user"));
    }
}
?>
