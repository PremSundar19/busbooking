<?php
session_start();

if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION['userid'];
$date = $_SESSION['date'] ?? null;

include_once('config.php');

if (isset($_POST['submit'])) {
    $busnumber = $_POST['busno'];
    $from = $_SESSION['from'];
    $to = $_SESSION['to'];
    $counted = $_SESSION['count'];
    $form = [];

    for ($i = 0; $i < $counted; $i++) {
        $seatNumber = $_POST['seat'][$i];
        $seatnum = $seatNumber;
        $name = $_POST['name'][$i];
        $gender = $_POST['gender'][$i];
        $input = strtotime($_POST['dob'][$i]);
        $dob = date('Y-m-d', $input);
        $age = intval($_POST['age'][$i]);
        $updatedprice = doubleval($_POST['price1'][$i]);
        $from_loc = $_POST['from'][$i];
        $to_loc = $_POST['to'][$i];

        $form[] = [
            'seat' => $seatNumber,
            'name' => $name,
            'gender' => $gender,
            'dob' => $dob,
            'age' => $age,
            'price' => $updatedprice,
            'from' => $from_loc,
            'to' => $to_loc,
            'date' => $date,
            'userId' => $userId,
            'busId' => $busnumber,
        ];

        $_SESSION['formData'] = $form;

        $before = $seatnum - 1;
        $after = $seatnum + 1;

        if (in_array($seatNumber, ['14', '24', '34', '44', '54', '64', '74', '84'])) {
            femaleSeat($con, $after);
        } elseif (in_array($seatNumber, ['15', '25', '35', '45', '55', '65', '75', '85'])) {
            femaleSeat($con, $before);
        } else {
            femaleSeat($con, $after);
            femaleSeat($con, $before);
        }
    }

    payment();
}

function femaleSeat($con, $seatNumber)
{
    global $gender;
    $query = "SELECT * FROM passenger WHERE seatno=$seatNumber";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_array($result);
    if($row['gender'] === 'female' &&  $gender !== 'female' ){
        warningMessage();
    }
}

function payment()
{
    header("location: payment.php");
    exit;
}

function warningMessage()
{
    header('location: warningMessage.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passenger Information Form</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <style>
         body {
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
        }
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
<?php if (isset($_POST['bookSeatsButton'])) { 
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
<?php if($count > 0) { ?>
        <?php for ($i = 0; $i < $count; $i++) {  ?>
    <div class="container mt-5">
    <form class="passenger-form" method='POST' action="booking.php">
        <input type="text" class="form-control" name="count" value="<?php echo $count; ?>" style='display: none;'>
        <input type="text" class="form-control" name="busno" value="<?php echo $busno; ?>" style='display: none;'>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="passengerform">
                        <div class="form-group">
                            <label for="seatnum">Seat Number</label>
                            <input type="text" class="form-control" name="seat[]" id="seat" value="<?php echo $selectedSeats[$i]; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="passengerName">Passenger Name</label>
                            <input type="text" class="form-control" name="name[]" id="name " placeholder="Enter passenger name" required>
                        </div>
                        <div class="form-group">
                            <label for="Gender">Gender</label>
                            <select class="form-control" name="gender[]" required>
                                <option >Select</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="dob">Date Of Birth</label>
                            <input type="date" class="form-control" name="dob[]" id="dob" required>
                            <small class="text-danger" id="dobError"></small>
                        </div>
                        <div class="form-group">
                            <label for="age">Age</label>
                            <input type="number" class="form-control" name="age[]" id= "age" readonly>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="from" class="form-label">From</label>
                                <input type="text" class="form-control" name="from[]" value='<?php echo $from;?>' readonly >
                            </div>
                            <div class="col-md-6">
                                <label for="to" class="form-label">To</label>
                                <input type="text" class="form-control" name="to[]" value='<?php echo $to;?>' readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" class="form-control" name="price1[]" id="price1" value='<?php  echo $price; ?>' readonly>
                        </div>
                    </div>
                </div>
            </div>
            <br>
        <?php }?>
        <div class="row justify-content-center mt-4">
            <input type="submit" name='submit'  class="btn btn-primary" value='Book-Seats'>
        </div>
    </form>
</div>
<?php }else{
            header("Location:selectticket_message.php");
            exit;
        }  ?>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script>
   $(document).ready(function(){
       $(document).on("change",".passengerform #dob",function(){
         var input = $(this).val();
         var dob =  new Date(input);
         var today = new Date();
         var age = today.getFullYear() - dob.getFullYear();
             if(dob > today){
                $(this).closest('.passengerform').find('#dobError').text('Please Select Proper Date');
             }else{ 
                $(this).closest('.passengerform').find('#dobError').text('');
                if (today.getMonth() < dob.getMonth() || (today.getMonth() === dob.getMonth() && today.getDate() < dob.getDate())) {
              age--;
              }              
               $(this).closest('.passengerform').find('#age').val(age);
                if (age >= 0 && age <= 4) {
                    $(this).closest('.passengerform').find('#price1').val(0);
                } else if (age >= 5 && age <= 8) {
                    var price = <?php if(isset($price)){ echo $price; } ?>;
                    $(this).closest('.passengerform').find('#price1').val(price / 2);
                }else{
                    var price = <?php if(isset($price)){ echo $price;}?>;
                    $(this).closest('.passengerform').find('#price1').val(price);
                }
            }
            });
   });
</script>
</body>
</html>