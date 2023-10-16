
<?php 
session_start();

if (isset($_SESSION['userid'])) {
    $userId = $_SESSION['userid']; 
}
if(isset($_POST['booksubmit'])){
   $price = $_POST['price'];
   $busno = $_POST['busno'];
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Ticket Seat Selection</title>
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .seat {
            background-color: #38D3CA;
            border :1px solid black;
            color :white;
        }

        .selected {
            background-color: #F1F26E ;
            color: black;
        }

        .pink {
            background-color: #DE39C7 ;
            color: #fff;
            cursor: not-allowed;
        }

        .disabled {
            background-color: #E85958;
            cursor: not-allowed;
        }
        #circle1{
            border-radius : 25px;
            background-color:red;
            width : 20px;
            height : 20px;
        }
        #price #busno {
            display : inline;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Bus Seat Selection</h1>
        <div class="row mt-4">
            <div class="col-md-8 offset-md-2">
                <div class="text-center">
                    <h2>Select Your Seat</h2>
                    <p>Available seats are marked in Lite Green</p>
                    <form>
                        <div id='circle1'></div>
                    </form>
                </div>
                <div class="text-center">
                    <?php
                    $totalRows = 8; 
                    $seatsPerRow = 5;
                    $i = 11;
                    for ($row = 1;$row <= $totalRows; $row++) {
                        echo '<div class="md-2 ">';
                        for ($seat = 1; $seat <= $seatsPerRow; $seat++) {
                            if($seat == 1||$seat==2||$seat==3){
                                echo '<button class="btn seat" id='.$i.' value='.$i.'>'.$i.'</button>';
                                $i++;
                              }else{
                                if($seat == 4){
                                echo "&emsp;&emsp;&emsp;";
                                echo '<button class="btn seat"  id='.$i.' value='.$i.'>'.$i.'</button>';
                                $i++;
                                }else{
                                    echo '<button class="btn seat"  id='.$i.'  value='.$i.'>'.$i.'</button>';
                                    $i++;
                                }
                            }
                        }
                        echo '</div>';
                    }
                    ?>
                </div>
                    <form action="booking.php" method="post">
                    <input type="hidden" name="selectedSeats" id="selectedSeatsInput">
                 <div class="text-center mt-4">
                      <input type='number' name='price' id='price'  value="<?php echo  $price; ?>" style='display: none;'>
                      <input type='text' name='busno' id='busno' value="<?php echo $busno; ?>" style='display: none;'>
                      <input id="bookSeatsButton" class="btn btn-primary" value="Book-Seats" type="submit" name="bookSeatsButton">
                     </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<?php 
   
    include_once("config.php");
    $sql = "SELECT * FROM passenger";
    $result = mysqli_query($con, $sql);
    $bookedSeats = array();
    $femaleSeats = array();
    while ($row = mysqli_fetch_assoc($result)) {
        if($row['gender'] === 'male'){
            $bookedSeats[] = $row['seatno'];
        }
        if($row['gender'] === 'female'){
            $femaleSeats[] = $row['seatno'];
        }
    }
?>
<script>
    $(document).ready(function() {
        var selectedSeats = [];
        var bookedSeats = <?php echo json_encode($bookedSeats); ?>;
        var femaleSeats = <?php  echo json_encode($femaleSeats);?>;
        $('.seat').click(function() {
            var $seat = $(this);
            var value = $seat.val();
            if ($seat.hasClass('disabled')) {
                return;
            }
            if ($seat.hasClass('selected')) {
                $seat.removeClass('selected');
                var index = selectedSeats.indexOf(value);
                if (index !== -1) {
                    selectedSeats.splice(index, 1);
                }
            } else {
                $seat.addClass('selected');
                selectedSeats.push(value);
            }
        });
        for (var i = 0; i < bookedSeats.length; i++) {
            $('#' + bookedSeats[i]).addClass('disabled').prop('disabled', true);
        }
        for(var i=0;i<femaleSeats.length;i++){
            $('#' + femaleSeats[i]).addClass('pink').prop('disabled',true);
        }
        $('#bookSeatsButton').click(function() {
            var selectedSeatsJSON = JSON.stringify(selectedSeats);
            $('#selectedSeatsInput').val(selectedSeatsJSON);
        });
    });
</script>

</body>
</html>
