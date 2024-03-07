<?php
// Include the connection script
require_once("connection.php");

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if required fields are set
    if (isset($_POST['title']) && isset($_POST['contants'])) {
        // Retrieve data from POST request
        $title = $_POST['title'];
        $content = $_POST['contants'];

        // Insert new post into the 'posts' table
        $sql = "INSERT INTO posts (title, content) VALUES ('$title', '$content')";
        if ($conn->query($sql) === TRUE) {
            // Return success message in JSON format
            echo json_encode(array("message" => "Post created successfully"));
        } else {
            // Return error message in JSON format
            echo json_encode(array("message" => "Error creating post: " . $conn->error));
        }
    } else {
        // Return error message in JSON format if required fields are not set
        echo json_encode(array("message" => "Title and content are required"));
    }
} else {
    // Return error message in JSON format if request method is not POST
    echo json_encode(array("message" => "Invalid request method"));
}

// Close the database connection
$conn->close();
?>
