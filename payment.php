<?php 
 include_once("config.php");
 if(isset($_POST['submit'])){
     $count = $_POST['count'];
     
     if(isset($count)){
          for($i=0;$i<$count;$i++){
             $seatnumber = $_POST['seat'][$i];
          }
     }

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
            padding: 25px;
            border-radius: 1px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
    
</head>
<body>

       <?php 
        session_start();
         if(isset($_SESSION['formData'])){
           $formData  = $_SESSION['formData'];
           $count = count($formData);
           $total = 0;
           for ($j = 0; $j < $count; $j++) {
               $total += $formData[$j]['price'];
           }
        } ?>


<div class="row justify-content-center">
    <h1 class="text-center">Payment Form</h1>
</div>
<?php if(isset($count) > 0) { ?>
  <?php for($i = 0; $i <$count; $i++) {  ?>
        <div class="container" style="max-width: 700px;">
            <form class="passenger-form" method='POST' action="payment.php" id="form">
            <input type="hidden" class="form-control" name="count" value="<?php echo $count; ?>">
                <div class="row justify-content-center">
                    <div class="passengerform">
                    <div class="row mb-3">
                            <div class="col-md-4">
                                <?php if($i == 0){ ?> 
                                    <label for="seatNumber">Seat Number</label>
                             <?php }?>
                                    <input type="number" class="form-control" id="seat" name="seat[]" value="<?php echo $formData[$i]['seat']; ?>"/>
                            </div>
                            <div class="col-md-4">
                            <?php if($i == 0){ ?>
                                   <label for="passengerName">Passenger Name</label>
                             <?php }?>
                                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $formData[$i]['name']?>">
                            </div>
                            <div class="col-md-4">
                            <?php if($i == 0){ ?>
                                   <label for="Price">Price</label>
                             <?php }?>
                                <input type="number" class="form-control" id="price" name="price" value="<?php echo $formData[$i]['price'];?>"/>
                            </div>
                        </div> 
                
                    <?php }?>
                        <div class="row">
                            <div class="col-md-6">
                                    <label for="payable">Payable Amount</label>
                                    <input type="number" class="form-control" id="payable" name="payable" required>
                            </div>
                            <div class="col-md-6">
                                    <label for="totalAmount">TotalAmount</label>
                                    <input type="number" class="form-control" name="total" id="total" readonly>
                            </div>
                        </div>
                </div>   
                <div class="row justify-content-center mt-4">
                    <input type="submit" name='submit' id="pay"  class="btn-lg btn-primary" value='Pay-Amount'>
                </div>
            </form>
        </div>
<?php }   ?>

<script>
    var totalAmount = <?php echo json_encode($total); ?>;
    $("#total").val(totalAmount);
    $(document).ready(function() {
    $("#form").on("submit", function(event) {
        event.preventDefault(); 
        var payable = $('#payable').val(); 
        if (payable == totalAmount) {
            $(this).unbind("submit").submit();
        } else {
            alert("Please enter the correct amount (" + totalAmount + ").");
        }    
    });
});

</script>

   

       
</body>
</html>