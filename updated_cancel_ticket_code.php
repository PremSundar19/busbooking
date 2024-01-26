<?php 
       if(isset($_POST['CANCEL'])){
        include_once('config.php');
         $seatNumber = $_POST['seatno'];
         $busId = $_POST['busid'];
         $query = "SELECT p.*,b.availability FROM passenger p JOIN bus b ON p.bus_id = b.busno WHERE p.bus_id=$busId AND seatno=$seatNumber";
         $result = mysqli_query($con,$query);
         $row = mysqli_fetch_array($result);
        
         $updatedAvailability = $row['availability'] + 1;
         $status = "Cancelled";
         $price = $row['price'];
         $refundable = $price - ($price * 6) / 100;
 
        $deleteQuery = "DELETE FROM passenger WHERE seatno=$seatNumber AND bus_id=$busId";
        $result = mysqli_query($con,$deleteQuery);
            if($result){
                $query = "INSERT INTO `passengercopy`( `seatno`, `name`, `from_loc`, `to_loc`, `busname`, `price`, `status`, `refundable_price`, `user_id`) 
                VALUES ('$seatNumber','{$row['passenger_name']}','{$row['from_location']}','{$row['to_location']}','{$_POST['busname']}','$price','Cancelled','$refundable','{$row['user_id']}')";
                mysqli_query($con,$query);

                $updateQuery = "UPDATE bus SET availability=$updatedAvailability where busno=$busno";
                mysqli_query($con,$updateQuery);
                header("location:ticketCancelledMessage.php");
                exit;
            }
       }
    ?>
