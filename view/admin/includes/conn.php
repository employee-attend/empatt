<?php
	$conn = new mysqli('localhost', 'root', '', 'employee_attend');

	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	
?>