<?php
session_start();
$userId = $_SESSION['userid'];

if (!isset($userId)) {
    header("Location: login.php");
    exit;
}

include_once("config.php");

if (isset($_SESSION['formData'])) {
    $formData = $_SESSION['formData'];
}

if (isset($_POST['submit'])) {
    $dateInput = strtotime($_POST['date']);
    $travelDate = date('Y-m-d', $dateInput);
    $seats = [];

    foreach ($formData as $passenger) {
        $result = insertPassenger($con, $passenger);
        if ($result) {
            $exAvailability = seatAvailability($con, $passenger['busId']);
            updateBus($con, $exAvailability - 1, $passenger['busId']);
        }
    }

    $_SESSION['seats'] = array_column($formData, 'seat');
    $_SESSION['busno'] = $formData[0]['busId'];

    header("location:ticket_message.php");
}

function insertPassenger($con, $passenger)
{
    $query = "INSERT INTO passenger(seatno,passenger_name,gender,dob,age,from_location,to_location,Date_Of_Travel,price,user_id,bus_id,payment_status)  
    VALUES({$passenger['seat']},'{$passenger['name']}','{$passenger['gender']}','{$passenger['dob']}',{$passenger['age']},'{$passenger['from']}','{$passenger['to']}','{$passenger['travelDate']}',{$passenger['price']},{$passenger['userId']},{$passenger['busId']},'Paid')";
    return mysqli_query($con, $query);
}

function seatAvailability($con, $busnumber)
{
    $query = "SELECT availability FROM bus WHERE busno=$busnumber";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_array($result);
    return $row['availability'];
}

function updateBus($con, $updatedAvailability, $busnumber)
{
    $query = "UPDATE bus SET availability=$updatedAvailability WHERE busno=$busnumber";
    mysqli_query($con, $query);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Head section remains unchanged -->
</head>
<body>
<div class="row justify-content-center">
    <h1 class="text-center">Payment Form</h1>
</div>

<?php
if (isset($_SESSION['formData'])) {
    $form = $_SESSION['formData'];
    $count = count($form);
    $total = array_sum(array_column($form, 'price'));

    if (isset($_SESSION['date'])) {
        $date = $_SESSION['date'];
    }
}
?>

<?php for ($i = 0; $i < $count; $i++) { ?>
    <div class="container" style="max-width: 500px;">
        <form class="passenger-form" method='POST' action="payment.php" id="form">
            <!-- Form fields remain unchanged -->
        </form>
    </div>
<?php } ?>

<script>
    var totalAmount = <?php echo json_encode($total); ?>;
    $(document).ready(function () {
        $("#total").val(totalAmount);
    });
</script>
</body>
</html>
