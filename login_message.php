<?php 
session_start();
if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        body {
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
        }
        .login{
            background-color: #fff;
            padding: 35px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
<div class="container loginmessage">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="login">
                        <div class="alert alert-success" role="alert">Logged in Successfully!!</div>
                    </div>
                </div>
            </div>
        </div>
       <?php 
       header("Refresh:2;bus.php");
       exit;
       ?>
</body>
</html>