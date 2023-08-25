<?php
    $dbServername = 'localhost';
	$dbUsername = 'root';
	$dbPassword = '';
	$dbName = 'Web';

	$conn = mysqli_connect($dbServername,$dbUsername,$dbPassword,$dbName);	//connection to the db
	if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
	}
    
?>