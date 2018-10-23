<?php
	$conn = new mysqli('localhost', 'root', '', 'empatt');

	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	
?>