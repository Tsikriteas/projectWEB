<?php
include 'dbh.php';
include 'user_autheticate.php.php';


    if (isset($_POST)) {
        
        $username1 = $_POST['username1'];
        $new_pwd1 = $_POST['pwd1'];
        $new_pwd2 = $_POST['pwd2'];
        $password1 = $_POST['password'];

        //if (strlen($password1) > 0) {
            if ( $new_pwd1 !== $new_pwd2) {                
                    echo "Unmatching new passwords";           
            }elseif($new_pwd1==null){
              $query = "UPDATE users SET user_name = '$username1' WHERE user_name = '$user'";    
              $updateUserAndPasswords = true;
              if(mysqli_query($conn, $query)){
                  $curr_user = $username1;
                  echo "ok";
              }else{
                  echo "error $query." . mysqli_error($conn)."<br>";
              }
            }else{
                $query = "UPDATE users SET user_password = '$new_pwd1' WHERE user_name = '$user'";    
              $updateUserAndPasswords = true;
              if(mysqli_query($conn, $query)){
                  $curr_user = $username1;
                  echo "ok";
              }else{
                  echo "error $query." . mysqli_error($conn)."<br>";
              }
            }
        //}
    }
?>