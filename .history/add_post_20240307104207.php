<?php
	
    require_once 'connection.php';
	$image = $_FILES['image']['name'];
	$name = $_POST['name'];

	$imagePath = 'uploads/'.$image;
	$tmp_name = $_FILES['image']['tmp_name'];

	move_uploaded_file($tmp_name, $imagePath);

	$db->query("INSERT INTO person(name,image)VALUES('".$name."','".$image."')");


?>