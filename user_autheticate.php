<?php 
include 'dbh.php';
    session_start();
    if (!isset($_SESSION['user'])) {
        header('Location: ./index.html');
        die();
    }
    $user = &$_SESSION['user'];

    $query = "SELECT user_id FROM `users` WHERE user_name= '$user' ";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $user_id= $row['user_id'];
    }}
?>