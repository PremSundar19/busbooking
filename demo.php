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
    <title>Passenger Information Form</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .container {
            margin-top: 50px;
        }
        .passengerform {
            background-color: #fff;
            padding: 35px;
            border-radius: 1px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
<?php
if (isset($_POST['bookSeatsButton'])) {
    // Retrieve data from the previous page
    $from = $_SESSION['from'];
    $to = $_SESSION['to'];
    $price = $_POST['price'];
    $busno = $_POST['busno'];
    $selectedSeatsJSON = $_POST['selectedSeats'];
    $selectedSeats = json_decode($selectedSeatsJSON);
    $count = count($selectedSeats);
    $_SESSION['count'] = $count;
}
?>
<div class="row justify-content-center">
    <h1 class="text-center">Passenger Information</h1>
</div>
<?php
if (isset($count)) {
    for ($i = 0; $i < $count; $i++) {
        $seatNumber = $selectedSeats[$i];

        // Check if the seat is already booked by a female passenger
        $isSeatBooked = isSeatBooked($seatNumber, $busno);

        // Prevent booking if the seat is booked by a female
        if ($isSeatBooked) {
            echo "<div class='container mt-5'>";
            echo "<p>Seat $seatNumber is already booked by a female passenger.</p>";
            echo "</div>";
        } else {
            // Display the passenger information form
            echo "<div class='container mt-5'>";
            echo "<form class='passenger-form' method='POST' action='booking.php'>";
            // ... Rest of your form ...
            echo "</form>";
            echo "</div>";
        }
    }
}
?>

</body>
</html>
