<?php
include 'dbh.php';

if (isset($_POST)){
	$username = $_POST['username'];
	$email = $_POST['email'];
	$password = $_POST['password'];

	$sql = "SELECT user_name, user_email FROM users";
	$result = $conn->query($sql);
	
	$available = true;

	if ($result->num_rows > 0) {
		$i = 0; 
    	while($row = $result->fetch_assoc()) {
			$users[$i]["user_name"] = $row["user_name"];
			$users[$i]["email"] = $row["user_email"];
			$i++;
		}

		foreach ($users as $user){
			if ( $user["user_name"] == $username or $user["email"] == $email){
				$available = false;
			break;
			}
		}
	}
	
	if($available){
		$sql = "INSERT INTO users (user_id, user_name, user_email, user_password) VALUES ('$email','$username','$email','$password')";//na mpei aes encrypt sto id
		if(mysqli_query($conn, $sql)){
			echo "1"; //OKAY
		} else{
			echo "ERROR: Was not able to execute $sql. " . mysqli_error($conn);; //MYSQL ERROR
		}
	}else {
		echo "2"; //EXISTS
	}
}
?>