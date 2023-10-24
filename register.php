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
    $query = "INSERT INTO register (name,email,phone,dob,age,gender,password) VALUES('$name','$email',$phone,'$dob',$age,'$gender','$password');";
    if(mysqli_query($con,$query)){
        header('location:register_message.php');
        exit;
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <style>
       body {
            background-image: url('register_bc.png');
            background-size: cover;
            background-attachment: fixed;
            background-repeat: no-repeat;
            background-position: center;
            font-family: Arial, sans-serif;
            display: flex;
            align-items: center;
            height: 100vh;
            justify-content: center;
        }
        .form-container {
            background-color : rgba(45, 35, 35, 0.9); 
            padding: 45px;
            position: relative;
            border-radius: 20px;
            color: white;
            margin-top: 50px;
        }
    </style> 
</head>
<body>
    <div class="container">
        <div class="row"> 
            <div class="col-md-6 form-container">
                <div class="register-form">
                    <h2>Register Here</h2>
                    <form action="register.php" method="post" >
                        <div class="row mb-3">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                                <small class="text-danger" id="nameError"></small>
                            </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email"   required>
                            <small class="text-danger" id="emailError"></small>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="phone" name="phone" pattern="[6-9][0-9]{9}" oninput="validatePhone(this);" maxlength="10" required>
                            <small class="text-danger" id="phoneError"></small>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="dob" class="form-label">Date Of Birth</label>
                                <input type="date" class="form-control" id="dob" name="dob" required>
                                <small class="text-danger" id="doberror"></small>
                            </div>
                            <div class="col-md-6">
                                <label for="age" class="form-label">Age</label>
                                <input type="number" class="form-control" id="age" name="age" readonly>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="gender" class="form-label">Gender</label><br>
                            <input type="radio" id="male" name="gender" value="male" required>
                            <label for="male">Male</label>
                            <input type="radio" id="female" name="gender" value="female" required>
                            <label for="female">Female</label>
                            <input type="radio" id="others" name="gender" value="others" required>
                            <label for="others">Others</label>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            <small class="text-danger" id="passwordError"></small>
                        </div>
                        <br>
                        <input type="submit" name="REGISTER" value="REGISTER" class="btn btn-primary btn-block" ><br>
                </div>
                    </form>
                    <small id="errorpassword" class="text-danger"></small>
                    <div style="text-align:left;">
                        <p style="display: inline;">Already have an account?.</p>
                    <a href="login.php" name="sumbit2" class="btn btn-primary mb-2">LOG IN</a>
                    </div>
                </div>
            </div>
            </div>
        </div>
        <script>  
            function validatePhone(input){
                var regex = /[A-Za-z!@#$%^&*()_+{}\[\]:;|/='"<>,.?~\\-]/;
                var phoneErr =  document.getElementById("phoneError");
                var phone = input.value;
                if(regex.test(input.value)){
                    input.value= input.value.replace(/[^0-9]/g, '');
                }
               if(phone >= 6000000000 && phone <= 9999999999){
                phoneErr.textContent = '';
               }else if(phone < 6000000000 || phone > 9999999999){
                phoneErr.textContent = '*phone number should between 6000000000 - 9999999999';
               }else if(phone < 0){
                phoneErr.textContent = '* negative value not allowed';
               }
            }
        $(document).ready(function(){
               $('#name').on("input",function(){
                var regex = /[0-9!@#$%^&*()_+{}\[\]:;|/='"<>,.?~\\-]/;
                if(regex.test($(this).val())){
                $('#nameError').text('* Number / Symbol not Allowed');   
                }else{
                $('#nameError').text(''); 
                }
            });
              $('#password').on("input",function(){
                var passwordPattern = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
                var password = $('#password').val();
                if (password.match(passwordPattern)) { 
                    $('#passwordError').text('');
                    } else {
                    $('#passwordError').text('*Password should contains one capital letter,one symbol,one number');
                    }      
              });
                $('#email').on("input",function(){
                   var email = $('#email').val();
                   var emailpattern =  /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
                    if (!emailPattern.match(email)) {
                        $('#emailError').text('');
                    } else {
                        $('#emailError').text('* Please enter a valid email address.');
                   }
                });
                $('#dob').change(function(){
                 var date = $('#dob').val();
                 var dob = new Date(date);
                 var today = new Date();
                 if(dob > today){
                      $('#doberror').text('Please Select Proper Date');
                 }else{
                    $('#doberror').text('');
                    var age = today.getFullYear() - dob.getFullYear();
                    if( today.getMonth() < dob.getMonth() || (dob.getMonth() === today.getMonth() && today.getDate() < dob.getDate())){
                    age--;
                    }
                   $('#age').val(age);
                 }
                });
            });
        </script> 
</body>
</html>