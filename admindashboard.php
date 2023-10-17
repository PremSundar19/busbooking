<?php
           include_once("config.php");
           if(isset($_POST["approve"])){
            $userId = $_POST["id"];
            $updatePassenger = "UPDATE register SET status='approved' WHERE id=$userId";
            mysqli_query($con, $updatePassenger);
           }
           else if(isset($_POST["reject"])){
            $userId = $_POST["id"];
            $updatePassenger = " UPDATE register SET status = 'rejected' WHERE id = $userId";
            mysqli_query($con, $updatePassenger);
           }
     ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin DashBoard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
         body {
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
        }
        .button-container {
    width: 145px; 
    }
    .logout{
        float : right;
      }
    </style>
</head>
<body>
<div class="container">
        <h2 style='display:inline' >Registered Users</h2> <a class="btn btn-primary logout" href="logout_message.php">Log Out</a>
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Gender</th>
                    <th>status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $fetchPassengers = "SELECT *  FROM register";
                $passengersResult = mysqli_query($con,$fetchPassengers);
                if (mysqli_num_rows($passengersResult) > 0) {
                    while ($row = mysqli_fetch_array($passengersResult)) {
                        if($row["status"] == "pending"){
                            echo "<tr>";
                            echo "<td>" . $row["name"] . "</td>";
                            echo "<td>" . $row["email"] . "</td>";
                            echo "<td>" . $row["phone"] . "</td>";
                            echo "<td>" . $row["gender"] . "</td>";
                            echo "<td>" . $row["status"] . "</td>";
                            echo "<td>";
                            if ($row["status"] == "pending") {
                                echo "<div class='button-container'>";
                                echo "<form method='post'>";
                                echo "<input type='hidden' name='id' value='" . $row["id"] . "'>";
                                echo "<button type='submit' name='approve' class='btn btn-success'>Approve</button>";
                                echo "<button type='submit' name='reject' class='btn btn-danger'>Reject</button>";
                                echo "</form>";
                                echo "</div>";
                            }
                            echo "</td>";
                            echo "</tr>";
                        }    
                    }
                } else {
                    echo "<tr><td colspan='6'>No records found</td></tr>";
                }
                ?>
            </tbody>
        </table>    
    </div>    
</body>
</html>