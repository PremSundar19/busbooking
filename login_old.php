<?php
//new code
if(isset($_POST['ADMIN'])){
    $name = $_POST['name'];
    $password = $_POST['password'];
    if($name === "Admin" && $password === "Password@123"){
        header("location:demo.php");
        exit;
    }else{
        $loginError = 'Admin credentials are incorrect.';
    }
}else if(isset($_POST['USER'])){
$name = $_POST['name'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
include_once('config.php');
$result = mysqli_query($con,"SELECT id,status FROM register WHERE name ='{$_POST['name']}' and password='". password_hash($_POST['password'], PASSWORD_BCRYPT) ."'"); 
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        $id = $row['id'];
        if($row['status'] === "approved"){
            session_start();
            $_SESSION['userid'] = $id;
            header("location:login_message.php");
            exit;
        }else{
            $loginError = "Your account is pending approval or has been rejected by the admin.";
        }
    }else{
        $loginError = 'User credentials are incorrect.';
    }
}
    ?>
 
<?php

//original code
if (isset($_POST['USER'])) {
    $name = $_POST['name']; 
    $password = $_POST['password'];
    include_once('config.php');
    $query = "SELECT id,password,status FROM register WHERE name = '$name'";
    $result = mysqli_query($con, $query);  
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        $storedHashedPassword = $row['password'];
        $id = $row['id'];
        if (password_verify($password, $storedHashedPassword) ) {
           if($row['status'] === "approved"){
               session_start();
               $_SESSION['userid'] = $id;
               header("location:login_message.php");
               exit;
           }else{
               $loginError = "Your account is pending approval or has been rejected by the admin.";
           }
        } else {
            $loginError = "Incorrect password. Please try again.";
        }
    } else {
        $loginError = "Please register or check your name.";
    }
}else if(isset($_POST['ADMIN'])){
    $name = $_POST['name'];
    $password = $_POST['password'];
    if($name === "Admin"){
        if($password === "Admin@123"){
            header("Location: admindashboard.php");
            exit;
        }else{
            $loginError =  "Admin Password Wrong";
        }
    }else{
      $loginError =  "Admin Name Wrong";
    }
}
?>