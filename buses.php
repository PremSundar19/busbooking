<?php 
session_start();

if (isset($_SESSION['userid'])) {
    $userId = $_SESSION['userid']; 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Information</title>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    body{ 
            background-color: powderblue;
        }
    </style>
</head>
<body> 
    <div class="container mt-4">
        <h2>Bus Information</h2>
        <table class="table table-striped table-bordered table-hover" >
            <thead>
                <tr>
                    <th>Bus Name</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Date</th>
                    <th>Departure Time</th>
                    <th>Arrival Time</th>
                    <th>Duration</th>
                    <th>Availability</th>
                    <th>Rate</th>
                    <th>Book</th>
                </tr>
            </thead>
            <tbody>
            <?php 
              if(isset($_POST['SEARCH'])){
                include_once('config.php');
                $from = strtolower( $_POST['from']);
                $to =  strtolower($_POST['to']);
                $date = $_POST['date'];
                
                $sql = "SELECT * FROM bus WHERE `from_loc`='$from' AND `to_loc`='$to'";
                $result = mysqli_query($con,$sql);
                
                if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_array($result)){
                        echo "<tr>";
                        echo "<td>{$row['bus_name']}</td>";
                        echo "<td>{$row['from_loc']}</td>";
                        echo "<td>{$row['to_loc']}</td>";
                        echo "<td>{$date}</td>";
                        echo "<td>{$row['departure_time']}</td>";
                        echo "<td>{$row['arrival_time']}</td>";
                        echo "<td>{$row['duration']}</td>";
                        echo "<td>{$row['availability']}</td>";
                        echo "<td>{$row['price']}</td>";
                        echo "<td><form method='post' action='ticket.php'>
                            <input type='number' name='price' id='price' value='{$row['price']}' style='display: none;'>
                            <input type='text' name='busno' id='busno' value='{$row['busno']}' style='display: none;'>  
                            <input type='submit' name='booksubmit' value='BOOK' class='btn btn-primary mb-2'>
                            </form>
                        </td>";
                        echo "</tr>";
                        $_SESSION['from'] = $row['from_loc'];
                        $_SESSION['to'] = $row['to_loc'];
                    }
                }else{
                    echo "<p>No buses found for entered location</p>";
                    echo "<a href='bus.php' name='sumbit'  class='btn btn-primary mb-2'>Home</a>";
                }
        }
      
            ?>      
        </tbody>
        </table>
    </div>

</body>
</html>
