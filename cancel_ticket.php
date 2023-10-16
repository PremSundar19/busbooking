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
      .logout{
        float : right;
      }
      
      .home {
  position:absolute;
  top: 0px;
  left:80%;
}
    </style>
</head>
<body>
<?php 
session_start();
$userId = $_SESSION['userid'] ;

    ?>

<div class="container mt-5">
        <h2 style='display:inline'>Booked Tickets</h2>
        <a class="btn btn-primary home" href="bus.php">Home</a>
        <a class="btn btn-danger logout" href="logout_message.php">Log Out</a>
        <table class="table table-striped table-bordered table-hover">
            <thead>
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
                $sql = "SELECT *  FROM passenger WHERE user_id=$userId";
                $result = mysqli_query($con,$sql);
            
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
         include_once('config.php');
         $psql = "SELECT * FROM passenger where seatno=$seatNumber";
         $presult = mysqli_query($con,$psql);
         $prow = mysqli_fetch_array($presult);
         $busno = $prow['bus_id'];
         $seatno = $prow['seatno'];


        $dsql = "DELETE FROM passenger WHERE seatno=$seatNumber";
        $result = mysqli_query($con,$dsql);
            if($result){
                $bsql = "SELECT * FROM bus where busno=$busno";
                $bresult = mysqli_query($con,$bsql);
                $brow = mysqli_fetch_array($bresult);
                $exAvailability = $brow['availability'];
                $updatedAvailability = $exAvailability + 1;
                $USQL = "UPDATE bus SET availability=$updatedAvailability where busno=$busno";
                mysqli_query($con,$USQL);
                $seatQuery = "UPDATE seat SET status=0 WHERE seatno=$seatno";
                mysqli_query($con,$seatQuery);
                header("location:ticket_cancelled_message.php");
                exit;
            }
       }
    ?>
</body>
</html>