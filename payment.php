<?php
 session_start();
 include_once("config.php");
 if(isset($_SESSION['formData'])){
    $formData  = $_SESSION['formData'];     
   }
 
 if(isset($_POST['submit'])){
    for($i=0;$i<count($formData);$i++){
       $seat = $formData[$i]['seat'];
       $name = $formData[$i]['name'];
       $gender = $formData[$i]['gender'];
       $dob  = $formData[$i]['dob'];
       $age  = $formData[$i]['age'];
       $from = $formData[$i]['from'];
       $to   = $formData[$i]['to'];
       $price  = $formData[$i]['price'];
       $userId = $formData[$i]['userId'];
       $busId  = $formData[$i]['busId'];
       $paid = "Paid";
        $result = insertPassenger($con,$seat,$name,$gender,$dob,$age,$from,$to,$price,$userId,$busId,$paid);
        if($result){
            $exAvailability = seatAvailability($con,$busId);
            $updatedAvailability = $exAvailability - 1;
            updateBus($con,$updatedAvailability,$busId);
       }
    }
    header("location:ticket_message.php");
 }
 function insertPassenger($con,$seat_number,$name,$gender,$dob,$age,$from,$to,$price,$userid,$busId,$paid){
    $query = "INSERT INTO passenger(seatno,passenger_name,gender,dob,age,from_location,to_location,price,user_id,bus_id,payment_status)  
    VALUES($seat_number,'$name','$gender','$dob',$age,'$from','$to',$price,$userid,$busId,'$paid')";
    return mysqli_query($con,$query);
}
function femaleSeat($con,$seatNumber){
    $query = "SELECT * FROM passenger WHERE seatno=$seatNumber";
    $result = mysqli_query($con,$query);
    $row = mysqli_fetch_array($result);
    return $row['gender'] === 'female';
}
function seatAvailability($con,$busnumber){
    $query ="SELECT availability FROM bus WHERE busno=$busnumber";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_array($result);
    return $exAvailability = $row['availability'];
}

function updateBus($con,$updatedAvailability,$busnumber){
    $query = "UPDATE bus SET availability=$updatedAvailability WHERE busno=$busnumber";
    mysqli_query($con,$query);
}

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        body {
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 25px;
        }
        .passenger-form {
            background-color: #fff;
            padding: 20px;
            border-radius: 1px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
<div class="row justify-content-center">
    <h1 class="text-center">Payment Form</h1>
</div>
<?php
if(isset($_SESSION['formData'])){
    $form  = $_SESSION['formData'];
    $count = count($form);
           $total = 0;
           for ($j = 0; $j < $count; $j++) {
               $total += $form[$j]['price'];
           }
}
?>
  <?php for($i = 0; $i <$count; $i++) {  ?>
        <div class="container" style="max-width: 500px;">
            <form class="passenger-form" method='POST' action="payment.php" id="form">
            <input type="hidden" class="form-control" name="count" value="<?php echo $count; ?>">
                <div class="row justify-content-center">
                    <div class="passengerform">
                    <div class="row">
                            <div class="col-md-4">
                                <?php if($i == 0){ ?> 
                                    <label for="seatNumber">Seat No</label>
                             <?php }?>
                                    <input type="number" class="form-control" id="seat" name="seat[]" value="<?php echo $form[$i]['seat']; ?>"/>
                            </div>
                            <div class="col-md-4">
                            <?php if($i == 0){ ?>
                                   <label for="passengerName">Name</label>
                             <?php }?>
                                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $form[$i]['name']?>">
                            </div>
                            <div class="col-md-4">
                            <?php if($i == 0){ ?>
                                   <label for="Price">Price</label>
                             <?php }?>
                                <input type="number" class="form-control" id="price" name="price" value="<?php echo $form[$i]['price'];?>"/>
                            </div>
                        </div> 
                    <?php }?>
                    <div class="row">
                            <div class="col-md-6">
                                    <label for="totalAmount">TotalAmount</label>
                                    <input type="number" class="form-control" name="total" id="total" readonly>
                            </div>
                    </div>
                <br>
                <div class="row mb-3">
                            <div class="col-md-6">
                            <input type="submit" name="submit" value="Pay" class="btn btn-primary btn-block">
                            </div>
                            <div class="col-md-6">
                                <a href="ticket.php" name="cancel" class="btn btn-danger btn-block">Cancel</a>
                            </div>
                </div> 
            </div>  
            </form>
        </div>
<script>
    var totalAmount = <?php echo json_encode($total); ?>;
    $(document).ready(function(){  $("#total").val(totalAmount); });
  
    // $(document).ready(function() {
    // $("#form").on("submit", function(event) {
    //     event.preventDefault(); 
    //     var payable = $('#payable').val(); 
    //     if (payable == totalAmount) {
    //         $(this).unbind("submit").submit();
    //     } else {
    //         alert("Please enter the correct amount (" + totalAmount + ").");
    //     }    
    // });
// });
</script>
</body>
</html>