  <?php 
  session_start();
  if(!session_destroy()){
      echo "Failed to log out";
  }
  else{
      unset($_SESSION['userid']);
      echo "Logged out successfully";
      header("refresh:2;url=login.php");
      exit;
  }

?>
