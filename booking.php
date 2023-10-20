<?php 
session_start();
if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit;
}
$userId = $_SESSION['userid'] ;
?>
<?php 
 include_once('config.php');
 $form =array();
if(isset($_POST['submit'])){
    $busnumber = $_POST['busno']; $from = $_SESSION['from'];
    $to = $_SESSION['to']; $counted = $_SESSION['count'];
    if($counted == 1){
        for ($i = 0; $i < $counted; $i++) {
             $seatNumber = $_POST['seat'][$i];$seatnum = $seatNumber; $name = $_POST['name'][$i];$gender = $_POST['gender'][$i];$input = strtotime($_POST['dob'][$i]);$dob = Date('Y-m-d', $input);$age = intval($_POST['age'][$i]);$updatedprice = doubleval($_POST['price1'][$i]) ; $from_loc = $_POST['from'][$i];$to_loc = $_POST['to'][$i];
             $form[] = array('seat' => $seatNumber,'name' => $name,'gender'=>$gender,'dob'=>$dob,'age'=>$age,'price' => $updatedprice,'from'=>$from_loc,'to'=>$to_loc,'userId'=>$userId,'busId'=>$busnumber);
             $_SESSION['formData'] = $form;
            if($seatNumber === '14'||$seatNumber === '24' || $seatNumber === '34' || $seatNumber === '44' ||$seatNumber === '54'||$seatNumber === '64' || $seatNumber === '74' || $seatNumber === '84'){
                $after = $seatnum + 1;
                $femaleAfter = femaleSeat($con,$after);
                if($femaleAfter &&  $gender !== 'female' ){
                    warningMessage();
                }
                else{
                    payment();
                }
            }elseif($seatNumber === '15'||$seatNumber === '25' || $seatNumber === '35' || $seatNumber === '45' ||$seatNumber === '55'||$seatNumber === '65' || $seatNumber === '75' || $seatNumber === '85'){
                $before = $seatnum - 1;
                $femaleBefore = femaleSeat($con,$before);
                if($femaleBefore &&  $gender !== 'female' ){
                    warningMessage();
                }else{
                    payment();
                }
            }else{
                $before = $seatnum - 1; $after = $seatnum + 1;
                $femaleAfter = femaleSeat($con,$after);
                $femaleBefore = femaleSeat($con,$before);
                   if(($femaleAfter && $gender !== "female" || $femaleBefore &&  $gender !== "female")){
                        warningMessage();
                   }else{
                    payment();
                 }
            }
        }
    }elseif($counted >= 2){
        for ($i = 0; $i < $counted; $i++) {
             $seatNumber = $_POST['seat'][$i];$seatnum = $seatNumber; $name = $_POST['name'][$i];$gender = $_POST['gender'][$i];$input = strtotime($_POST['dob'][$i]);$dob = Date('Y-m-d', $input);$age = intval($_POST['age'][$i]);$updatedprice = doubleval($_POST['price1'][$i]) ; $from_loc = $_POST['from'][$i];$to_loc = $_POST['to'][$i];
             $form[] = array('seat' => $seatNumber,'name' => $name,'gender'=>$gender,'dob'=>$dob,'age'=>$age,'price' => $updatedprice,'from'=>$from_loc,'to'=>$to_loc,'userId'=>$userId,'busId'=>$busnumber);
             $_SESSION['formData'] = $form;
            if(($seatNumber === "21" && $gender === 'female')||($seatNumber === "31" && $gender === 'female')||($seatNumber === "41" && $female === 'female')||($seatNumber === "51" && $female === 'female')||($seatNumber === "61" && $female === 'female')||($seatNumber === "71" && $female === 'female')||($seatNumber === "81" && $female === 'female')){
                $twoSeatAfter = $seatnum + 2;
                $oneSeatAfer = $seatnum +1;
                $oneAfter =femaleSeat($con,$oneSeatAfer);
                $after2 = femaleSeat($con,$twoSeatAfter);
                if($after2){
                   warningMessage();
                }  
                if($oneAfter){
                    warningMessage();
                }
           }else if($seatNumber === '13' ||$seatNumber === '23' || $seatNumber === '33' || $seatNumber === '43'||$seatNumber === '53' || $seatNumber === '63' || $seatNumber === '73'||$seatNumber === '83'){
                $before = $seatnum - 1;
                $beforeFemale = femaleSeat($con,$before);
                if($gender !== "female" && $beforeFemale){ 
                  warningMessage();
                }
            }else {
                     $before = $seatnum - 1;$after = $seatnum  + 1;
                     $beforeFemale = femaleSeat($con,$before);
                     $afterFemale = femaleSeat($con,$after);  
                if(($beforeFemale && $gender !== "female") || ($afterFemale  && $gender !== "female")){
                    warningMessage();
                }
            }
        }
        payment();
    }
}
function femaleSeat($con,$seatNumber){
    $query = "SELECT * FROM passenger WHERE seatno=$seatNumber";
    $result = mysqli_query($con,$query);
    $row = mysqli_fetch_array($result);
    return $row['gender'] === 'female';
}
function payment(){
    header("location:payment.php");
    exit; 
}
function warningMessage(){
    header('location:warningMessage.php');
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