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
    <meta charset='UTF-8'>
    <meta name="viewport' content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css'>
    <title>Ticket Receipt</title>
    <style>
    .ticket {
        border: 1px solid #ccc;
        padding: 10px;
        margin-bottom: 10px;
    }
</style>

</head>
<body>
    <div class="container" id="bill">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card mt-5">
                    <div class="card-header">
                        <h3>Ticket Receipt</h3>
                    </div>
                        <?php 
                        
                        include('config.php');
                        if(isset($_SESSION['seats'])){
                            $seats = $_SESSION['seats'];
                            $busno = $_SESSION['busno'];
                            for($i=0;$i<count($seats);$i++){
                                $query = "SELECT passenger.*,bus.bus_name FROM passenger JOIN bus ON passenger.bus_id = bus.busno WHERE passenger.seatno=$seats[$i] AND passenger.bus_id=$busno";
                                $result = mysqli_query($con,$query);
                                while($row = mysqli_fetch_array($result)){
                                    echo "<div class='ticket'>";
                                    echo "<div class='row'>";
                                    echo "<div class='col-md-6'>";
                                    echo "<p><strong>Name : </strong>".$row['passenger_name']."</p>";     
                                    echo "<p><strong>From : </strong>".$row['from_location']."</p>";    
                                    echo "<p><strong>To : </strong>".$row['to_location']."</p>";    
                                    echo "<p><strong>Payment : </strong>".$row['payment_status']."</p>";    
                                    echo "</div>";
                                    echo "<div class='col-md-6'>"; 
                                    echo "<p><strong>Seat Number : </strong>".$row['seatno']."</p>";
                                    echo "<p><strong>Bus Name : </strong>".$row['bus_name']."</p>";    
                                    echo "<p><strong>Price : </strong>".$row['price']."</p>";
                                    echo "<p><strong>Travel : </strong>".$row['Date_Of_Travel']."</p>";
                                    echo "</div>";
                                    echo "</div>";
                                    echo "</div>";
                              }}
                              echo "<a href='bus.php'>Home</a>";
                              } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>