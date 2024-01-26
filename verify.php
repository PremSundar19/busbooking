<?php
 if(isset($_POST['ADMIN'])){
     
     header("Location: admindashboard.php");
     exit;
    $name = $_POST['name'];
    $password = $_POST['password'];

    // header("Location:admindashboard.php");
    
    // header("Refresh:0.5;admindashboard.php");
    // if ($name === "Admin" && $password === "Admin@123") {
        session_start();
        $_SESSION['admin'] = true;
    //     // echo $name;die;
    // } else {
    //     $loginError = "Admin credentials are incorrect.";
    // }

    // if($name === "Admin"){
    //     if($password === "Admin@123"){
    //         // echo "$password";die;
    //         // header('location: admindashboard.php');
            
    //         header("Location: admindashboard.php");
            
    //         exit;
    //     }else{
    //         $loginError =  "Admin Password Wrong";
    //     }
    // }else{
    //   $loginError =  "Admin Name Wrong";
    // }
}
else if (isset($_POST['USER'])) {
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
}
?>