<?php
include "config.php";

if(isset($_POST['registrebutton'])){
  $name = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
  
 
  $sqll = "SELECT email from users where email = '$email'";
  $result = mysqli_query($connection,$sqll);
  if(mysqli_num_rows($result)>0){
    echo "<script>alert('Already have an account');</script>";
  }else{
    $sql = "INSERT INTO users  (username, email,   password_hash) VALUES ('$name', '$email', '$hashedPassword')";
    mysqli_query($connection,$sql);
    echo "<script>alert('Registre Sucsessfully');</script>";
  }
  }

?>