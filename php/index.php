<?php 
  session_start();
 
  if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){ 
      header("location: welcome.php");
      exit;
  }else{
    header("location: login.php");
    exit; 
  }
?>