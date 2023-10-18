<?php 
session_start();
  $userId = $_SESSION['userid'] ;
if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit;
}
?>
<?php 
if(isset($_POST['submit'])){
    include_once('config.php');
    $busnumber = $_POST['busno'];$userId = $_SESSION['userid']; $from = $_SESSION['from'];
    $to = $_SESSION['to']; $counted = $_SESSION['count'];
    if($counted == 1){
        for ($i = 0; $i < $counted; $i++) {
            $seatNumber = $_POST['seatnumber'][$i]; $seatNum = $seatNumber; $passengerName = $_POST['passengerName'][$i];$passengerGender = $_POST['passengerGender'][$i];$input = strtotime($_POST['dob'][$i]);$dob = Date('Y-m-d', $input);$age = intval($_POST['age'][$i]);$updatedprice = doubleval($_POST['price1'][$i]) ; $from_loc = $_POST['from'][$i];$to_loc = $_POST['to'][$i];
            
            if($seatNumber === '14'||$seatNumber === '24' || $seatNumber === '34' || $seatNumber === '44' ||$seatNumber === '54'||$seatNumber === '64' || $seatNumber == '74' || $seatNumber == '84'){
                $after = $seatNum + 1;
                $femaleAfter = femaleSeat($con,$after);
                if($femaleAfter &&  $passengerGender !== 'female' ){
                    header('location:warningMessage.php');
                    exit;
                }else{
                    $insertPassenger = "INSERT INTO passenger(seatno,passenger_name,gender,dob,age,from_location,to_location,price,user_id,bus_id) VALUES($seatNumber,'$passengerName','$passengerGender','$dob',$age,'$from_loc','$to_loc',$updatedprice,$userId,$busnumber)";
                    $result =  mysqli_query($con,$insertPassenger);
                    if($result){
                        $exAvailability = seatAvailability($con,$busnumber);
                        $updatedAvailability = $exAvailability - 1;
                        updateBus($con,$updatedAvailability,$busnumber);
                        header("location:ticket_message.php");
                        exit;
                   }
                }
            }elseif($seatNumber === '15'||$seatNumber === '25' || $seatNumber === '35' || $seatNumber === '45' ||$seatNumber === '55'||$seatNumber === '65' || $seatNumber == '75' || $seatNumber == '85'){
                $before = $seatNum - 1;
                $femaleBefore = femaleSeat($con,$before);
                if($femaleBefore &&  $passengerGender !== 'female' ){
                    header('location:warningMessage.php');
                    exit;
                }else{
                    $insertPassenger = "INSERT INTO passenger(seatno,passenger_name,gender,dob,age,from_location,to_location,price,user_id,bus_id) VALUES($seatNumber,'$passengerName','$passengerGender','$dob',$age,'$from_loc','$to_loc',$updatedprice,$userId,$busnumber)";
                    $result =  mysqli_query($con,$insertPassenger);
                   if($result){
                    $exAvailability = seatAvailability($con,$busnumber);
                    $updatedAvailability = $exAvailability - 1;
                    updateBus($con,$updatedAvailability,$busnumber);
                    header("location:ticket_message.php");
                    exit;
               }
             }
            }else{
                $before = $seatNum - 1; $after = $seatNum + 1;
                $femaleBefore = femaleSeat($con,$after);
                $femaleBefore = femaleSeat($con,$before);
                if(($femaleBefore &&  $passengerGender !== "female")|| ($femaleAfter && $passengerGender !== "female")){
                       header('location:warningMessage.php');
                       exit;
                   }else{
                        $insertPassenger = "INSERT INTO passenger(seatno,passenger_name,gender,dob,age,from_location,to_location,price,user_id,bus_id) VALUES($seatNumber,'$passengerName','$passengerGender','$dob',$age,'$from_loc','$to_loc',$updatedprice,$userId,$busnumber)";
                        $result =  mysqli_query($con,$insertPassenger);
                        if($result){
                            $exAvailability = seatAvailability($con,$busnumber);
                            $updatedAvailability = $exAvailability - 1;
                            updateBus($con,$updatedAvailability,$busnumber);
                            header("location:ticket_message.php");
                            exit;
                       }
                 }
            }
        }
    }elseif($counted >= 2){
        $formData = array();
        for ($i = 0; $i < $counted; $i++) {
            $seatNumber = $_POST['seatnumber'][$i]; $seatNum = $seatNumber; $passengerName = $_POST['passengerName'][$i];$passengerGender = $_POST['passengerGender'][$i];$input = strtotime($_POST['dob'][$i]);$dob = Date('Y-m-d', $input);$age = intval($_POST['age'][$i]);$updatedprice = doubleval($_POST['price1'][$i]) ; $from_loc = $_POST['from'][$i];$to_loc = $_POST['to'][$i];

            // $before = $seatNum - 1; $after = $seatNum + 1;
            // $beforeSeat = "SELECT gender FROM passenger WHERE seatno=$before";
            // $beforeSeatResult =  mysqli_query($con,$beforeSeat);
            // $beforeRowData = mysqli_fetch_array($beforeSeatResult);

            // $afterSeat = "SELECT gender FROM passenger WHERE seatno=$after";
            // $afterSeatResult =  mysqli_query($con,$afterSeat);
            // $afterRowData = mysqli_fetch_array($afterSeatResult);
    
    
            // if(($beforeRowData['gender'] === 'female' && $passengerGender !== 'female')||($afterRowData['gender'] === 'female'  && $passengerGender !== 'female')){
            //     header('location:warningMessage.php');
            //     exit;
            // }else{
            //      $insertPassenger = "INSERT INTO passenger(seatno,passenger_name,gender,dob,age,from_location,to_location,price,user_id,bus_id) VALUES($seatNumber,'$passengerName','$passengerGender','$dob',$age,'$from_loc','$to_loc',$updatedprice,$userId,$busnumber)";
            //      $passengerResult =  mysqli_query($con,$insertPassenger);
            //      if($passengerResult){
            //         $exAvailability = seatAvailability($con,$busnumber);
            //         $updatedAvailability = $exAvailability - 1;
            //         updateBus($con,$updatedAvailability,$busnumber);
            //    }
            // }
            
            $formData[] = array(
                'seatNumber' => $seatNumber,
                'passengerName' => $passengerName,
                'passengerGender' => $passengerGender,
                'dob' => $dob,
                'age' => $age,
                'updatedprice' => $updatedprice,
                'from_loc' => $from_loc,
                'to_loc' => $to_loc,
                'userId'=> $userId,
                'busId'=>$busnumber
            );
        }
        //  echo count($formData);

            for($j=0;$j<count($formData);$j++){

                $gender = $formData[0]['passengerGender'];
                //   echo $gender;
                if($gender === 'male'){
                    header('Location.warningMessage.php');
                    exit;
                }else{
                    
                    $seat_number = $formData[$j]['seatNumber'];
                    $passenger_name = $formData[$j]['passengerName'];
                    $passenger_gender = $formData[$j]['passengerGender'];
                    $passenger_dob = $formData[$j]['dob'];
                    $passenger_age = $fo rmData[$j]['age'];
                    $passenger_price = $formData[$j]['updateprice'];
                    $passenger_from = $formData[$j]['from_loc'];
                    $passenger_to = $formData[$j]['to_loc'];
                    $user_Id = $formData[$j]['userId'];
                    $busId = $formData[$j]['busId'];

                  $insertPassenger = "INSERT INTO passenger(seatno,passenger_name,gender,dob,age,from_location,to_location,price,user_id,bus_id)  VALUES($seat_number,'$passenger_name','$passenger_gender','$passenger_dob',$passenger_age,'$passenger_from','$passenger_to_loc',$passenegr_price,$user_Id,$busId)";
                  $passengerResult =  mysqli_query($con,$insertPassenger);
                 if($passengerResult){
                    $exAvailability = seatAvailability($con,$busnumber);
                    $updatedAvailability = $exAvailability - 1;
                    updateBus($con,$updatedAvailability,$busnumber);
               } 
                }

            }
            header("location:ticket_message.php");
            exit;  
    }
}
function femaleSeat($con,$seatNumber){
    $query = "SELECT * FROM passenger WHERE seatno=$seatNumber";
    $result = mysqli_query($con,$query);
    $row = mysqli_fetch_array($result);
    return $row['gender'] === 'female';
}
function seatAvailability($con,$busnumber){
    $query ="Select availability from bus where busno=$busnumber";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_array($result);
    return $exAvailability = $row['availability'];
}

function updateBus($con,$updatedAvailability,$busnumber){
    $query = "UPDATE bus SET availability=$updatedAvailability where busno=$busnumber";
    mysqli_query($con,$query);
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
<?php if(isset($count) > 0) { ?>
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
                            <input type="text" class="form-control" name="seatnumber[]" id="seatnumber" value="<?php echo $selectedSeats[$i]; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="passengerName">Passenger Name</label>
                            <input type="text" class="form-control" name="passengerName[]" id="passengername " placeholder="Enter passenger name" required>
                        </div>
                        <div class="form-group">
                            <label for="passengerGender">Gender</label>
                            <select class="form-control" name="passengerGender[]" required>
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
        <?php } ?>
        <div class="row justify-content-center mt-4">
            <input type="submit" name='submit'  class="btn btn-primary" value='Book-Seats'>
        </div>
    </form>
</div>
<?php }   ?>
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