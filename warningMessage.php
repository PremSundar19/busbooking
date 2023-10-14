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
                .login-form {
            background-color: #fff;
            padding: 35px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>

</head>
<body>
    
<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="login-form">
                        <div class="alert alert-warning ">You Can't book this Ticket Please select another Ticket</div>
                    </div>
                </div>
            </div>
        </div>
       <?php 
       session_start();
       header('location:ticket.php');
       ?>

</body>
</html>