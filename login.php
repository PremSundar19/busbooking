
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        body {
            background-image: url('login_bc.jpeg');
            background-size: cover;
            background-attachment: fixed;
            background-repeat: no-repeat;
            background-position: center;
            font-family: Arial, sans-serif;
            display: flex;
            align-items: center;
            height: 75vh;
        }
        .container {
            margin-top: 50px;
        }
        .login-form {
            background-color: #fff;
            background-attachment: fixed;
            padding: 35px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border: 1px solid black;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="login-form">
                    <h2 class="text-center">Login Here</h2>
                    <?php if (isset($loginError)) { ?>
                        <div class="alert alert-danger"><?php echo $loginError; ?></div>
                    <?php } ?>
                    <form action="verify.php" method="post" id="form">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password"  required>
                            <small class="text-danger" id="passwordError"></small>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                            <input type="submit" name="USER" value="User Log In" class="btn btn-primary btn-block">
                            </div>
                            <div class="col-md-6">
                            <input type="submit" name="ADMIN" value="Admin Log In" class="btn btn-primary btn-block">
                            </div>
                        </div> 
                            <div class="row justify-content-center">
                            <a class="btn btn-primary" style="width : 40%;" href="register.php">Register</a>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

