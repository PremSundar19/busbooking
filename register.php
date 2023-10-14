<?php 
  if(isset($_POST['REGISTER'])){   
    $name = $_POST['name'];
    $email = $_POST['email'];   
    $phone = intval($_POST['phone']);
    $dateInput = strtotime($_POST['dob']);
    $dob = date('Y-m-d', $dateInput);
    $age = intval($_POST['age']);
    $gender = $_POST['gender'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    include('config.php');
    $sql = "INSERT INTO register (name,email,phone,dob,age,gender,password) VALUES('$name','$email',$phone,'$dob',$age,'$gender','$password');";
    if(mysqli_query($con,$sql)){
        header("location:login.php");
        exit;
    }else{
        echo "something Went Wrong";
    }
  }
?>