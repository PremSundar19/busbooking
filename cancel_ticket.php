<?php 
session_start();
$userId = $_SESSION['userid'] ;
if (!isset($_SESSION['userid'])) {
//   header("location:login.php");
//   exit;
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
        <h2 style='display:inline'>Booked Tickets</h2>
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
                    <th>Cancel-Ticket</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include_once('config.php');
                $query = "SELECT *  FROM passenger WHERE user_id=$userId";
                $result = mysqli_query($con,$query);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_array($result)) {
                            echo "<tr>";
                            echo "<td>" . $row["seatno"] . "</td>";
                            echo "<td>" . $row["passenger_name"] . "</td>";
                            echo "<td>" . $row["from_location"] . "</td>";
                            echo "<td>" . $row["to_location"] . "</td>";
                            echo "<td>" . $row["price"] . "</td>";
                                echo "<td>";
                                echo "<div class='button-container'>";
                                echo "<form method='post' action='cancel_ticket.php'>";
                                echo "<input type='hidden' name='seatno' value='" . $row["seatno"] . "'>";
                                echo "<input id='CANCEL' class='btn btn-danger' value='CANCEL' type='submit' name='CANCEL'>";
                                echo "</form>";
                                echo "</div>";
                                echo "</td>";
                            }
                            echo "</tr>";
                        }  else {
                    echo "<tr><td colspan='6'>No records found</td></tr>";
                }
                ?>
            </tbody>
        </table>    
    </div>
    <?php 
       if(isset($_POST['CANCEL'])){
         $seatNumber = $_POST['seatno'];
         $query = "SELECT * FROM passenger where seatno=$seatNumber";
         $result = mysqli_query($con,$query);
         $row = mysqli_fetch_array($result);

         $name = $row['passenger_name'];
         $from = $row['from_location'];
         $to = $row['to_location'];
         $price = $row['price'];
         $busno = $row['bus_id'];
         $userId =$row['user_id'];
         $status = "Cancelled";

       $reductionAmount = ($price * 6) / 100;

       $final = $price - $reductionAmount;

        $deleteQuery = "DELETE FROM passenger WHERE seatno=$seatNumber";
        $result = mysqli_query($con,$deleteQuery);
            if($result){
                $queryInsert = "INSERT INTO passengercopy(seatno,name,from_loc,to_loc,price,status,refundable_price,user_id) VALUES($seatNumber,'$name','$from','$to',$price,'$status',$final,$userId)";
                mysqli_query($con,$queryInsert);
                $query = "SELECT availability FROM bus where busno=$busno";
                $result = mysqli_query($con,$query);
                $row = mysqli_fetch_array($result);
                $exAvailability = $row['availability'];
                $updatedAvailability = $exAvailability + 1;
                $updateQuery = "UPDATE bus SET availability=$updatedAvailability where busno=$busno";
                mysqli_query($con,$updateQuery);
                header("location:ticketCancelledMessage.php");
                exit;
            }
       }
    ?>
</body>
</html>