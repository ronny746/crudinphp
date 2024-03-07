<?php
// Include the connection script
require_once("connection.php");

// Perform operations on the 'posts' table

// Example: Select all posts
$sql = "SELECT * FROM posts";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $posts = array();
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $posts[] = $row;
    }
    // Return response in JSON format
    header('Content-Type: application/json');
    echo json_encode($posts);
} else {
    // Return error message in JSON format if no results found
    echo json_encode(array("message" => "No posts found"));
}

// Close the database connection
$conn->close();
?>
