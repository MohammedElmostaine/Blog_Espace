
<?php


include "config.php";

session_start(); 



if( isset($_POST['loginbutton'])){
  $email_user = $_POST['email'];    
  $pass = $_POST['password'];
  $sql = "SELECT id,email,password_hash, role from users where email='$email_user'";
  $result = mysqli_query($connection,$sql);

  if($result && mysqli_num_rows($result)>0){
    $i = mysqli_fetch_assoc($result);
    if(password_verify($pass,$i['password_hash'])){
      $_SESSION["user"] = $i['id'];
      $_SESSION["role"] = $i['role'];
      if($i['role']=="admin"){
        header("Location: assets/pages/dashboardadmin.php");

      }else{
        header("Location: assets/pages/dashboarduser.php");
      }
    }else {
      echo "<script>alert('Mot de passe incorrect');</script>";
  }
} else {
  echo "<script>alert('Email non trouvé');</script>";
}
  }

?>