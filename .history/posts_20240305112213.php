<?php
// handle_post.php
// require_once("connection.php");
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "loginsystem";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if required fields are set
    $title = $_POST['title'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    $sql = "INSERT INTO users (username, password, email) VALUES ('$username', '$password', '$email')";
        $action = $_POST['action'];

        if($action === 'create') {
            $title = $_POST['title'];
            $image = $_POST['image'];
            // Additional fields like user_id, etc. can be added

            // Insert post into database
            $sql = "INSERT INTO posts (title, image) VALUES ('$title', '$image')";
            if ($conn->query($sql) === TRUE) {
                echo "New post created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } elseif ($action === 'like') {
            // Handle like functionality
            // You would typically update the likes count for a post in the database
            echo "Liked!";
        } elseif ($action === 'comment') {
            // Handle comment functionality
            // You would typically insert the comment into a comments table linked to the post
            echo "Commented!";
        } else {
            echo "Invalid action";
        }
    
} else {
    echo "Invalid request method";
}
?>
