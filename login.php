<?php
include 'dbh.php';

session_start();
if (isset($_POST)){
    $username = $_POST['username'];
	$password = $_POST['password'];
	
	$sql = "SELECT * FROM users WHERE user_name = '$username'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();

	if($row['user_password'] != ""){
		if ($row['user_password'] == $password){
			if($row['is_admin'] == '1'){
				echo "admin";
			}else{
				echo "1"; //success
			$_SESSION['user'] = $row['user_name'];//mporw na balw id alla thelei apokruptografhsh
			}

 		} else {
			echo "0"; //wrong password
	 	}
	}else{
		echo "2"; //wrong username
	}
}
?>