<?php
	
    require_once 'connection.php';
	$image = $_FILES['image']['name'];
	$name = $_POST['content'];

	$imagePath = 'uploads/'.$image;
	$tmp_name = $_FILES['image']['tmp_name'];

	move_uploaded_file($tmp_name, $imagePath);

	$insertQuery = "INSERT INTO posts (content, user_id, password) VALUES ('$username', '$email', '$hashedPassword')";


?>