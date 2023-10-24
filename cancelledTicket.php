<?php 
session_start();
$userId = $_SESSION['userid'] ;
if (!isset($_SESSION['userid'])) {
  header("location:login.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
        body {
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
        }
      .logout{
        float : right;
      }
      .home {
  position:absolute;
  top: 0px;
  left: 75%;
}
    </style>
</head>
<body>
<div class="container mt-5">
        <h2 style='display:inline'>Cancelled Tickets</h2>
        <a class="btn btn-primary home" href="bus.php">Home</a>
        <a class="btn btn-danger logout" href="logout_message.php">Log Out</a>
        <table class="table table-striped table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>Seat No</th>
                    <th>Passenger Name</th>
                    <th>From_location</th>
                    <th>To_location</th>
                    <th>Price</th>
                    <th>refundable price</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include_once('config.php');
                $query = "SELECT *  FROM passengercopy WHERE user_id=$userId";
                $result = mysqli_query($con,$query);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_array($result)) {
                            echo "<tr>";
                            echo "<td>" . $row["seatno"] . "</td>";
                            echo "<td>" . $row["name"] . "</td>";
                            echo "<td>" . $row["from_loc"] . "</td>";
                            echo "<td>" . $row["to_loc"] . "</td>";
                            echo "<td>" . $row["price"] . "</td>";
                            echo "<td>" . $row["refundable_price"] . "</td>";
                            echo "<td>" . $row["status"] . "</td>";
                            
                            echo "</tr>";
                            }
                        }  else {
                    echo "<tr><td colspan='6'>No records found</td></tr>";
                }
                ?>
            </tbody>
        </table>    
    </div>
</body>
</html>