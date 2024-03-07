<?php
require_once 'connection.php'; // Include database connection script

// Handle POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve POST data
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Validate inputs (you should add more validation)
    if (empty($email) || empty($password)) {
        echo json_encode(array("message" => "email and password are required"));
        exit;
    }

    // Check credentials
    $selectQuery = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $selectQuery);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row["password"])) {
            session_start();
            $_SESSION["user_id"] = $row["id"];
            $_SESSION["email"] = $row["email"];
            echo json_encode(array("message" => "Login successful", "user_id" => $row));
        } else {
            echo json_encode(array("message" => "Invalid password"));
        }
    } else {
        echo json_encode(array("message" => "User not found"));
    }
}
?>
