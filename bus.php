<?php 
session_start();
$_SESSION['userid'] ;
if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit;
}
?>  
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Booking</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
  .Search{
    padding: 8px;
    width: 7rem;
    font-weight: bolder;
  }
 
body {
    background-image: url('bus.jpeg');
    background-size: cover;
    background-attachment: fixed;
    background-repeat: no-repeat;
    background-position: center;
    /* font-family: Arial, sans-serif; */
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    align-items: center;
}
.container {
    background-color:white;
    padding: 30px;
    border-radius: 20px;
    width: auto;
    color: black;  

}
.heading {
    font-size: 24px;
    font-weight: bold;
    margin-top: 110px;
    color: rgb(11, 12, 11);
}
#box{
margin-top: 4rem;
}
</style>
</head>
<body>
        <nav class="navbar navbar-expand-lg  navbar-light bg-light fixed-top">
        <span class="navbar-brand" href="#">
            <img src="bus_logo1.png" width="50" height="50" class="mr-2">
            Bus Booking
        </span>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto"> 
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="myAccountDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    My Account
                    </a>
                    <div class="dropdown-menu" aria-labelledby="myAccountDropdown">
                        <a class="dropdown-item" href="#">Profile</a>
                        <form action="usertickets.php" method="post">
                        <button type="submit" name="viewtickets" id="viewtickets" class="btn btn-default dropdown-item"  style=" color: black;">View Bookings</button>
                        </form>
                        <form action="cancel_ticket.php" method="post">
                        <button type="submit" name="CANCELTICKETS" id="CANCELTICKETS" class="btn btn-default dropdown-item"  style=" color: black;">Cancel Tickets</button>
                        </form>
                        <form action="cancelledTicket.php" method="post">
                        <button type="submit" name="CANCELLED_TICKETS" id="CANCELTICKETS" class="btn btn-default dropdown-item"  style=" color: black;">Cancelled Tickets</button>
                        </form>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="logout_message.php">Logout</a>
                    </div>
                </li>
                <li class="nav-item">
                    <span class="nav-link" href="#">
                        <img src="help_logo.png" alt="Help" width="30" height="30" class="mr-2">Help
                    </span>
                </li> 
            </ul>
        </div>
    </nav>
    <p class="heading">Best Bus Booking App</p>
    <div class="container" id="box" >
        <form class="form-inline"  action="buses.php" method="post">
        <div class="form-group">
            <label for="from">From :&ensp;</label>
            <select class="form-control" id="from" name="from" required>
                <option value="Chennai">Chennai</option>
                <option value="Bangalore">Bangalore</option>
                <option value="krishnagiri">krishnagiri</option>
                <option value="Salem">salem</option>
                <option value="Ooty">Ooty</option>
                <option value="Dharmapuri">Dharmapuri</option>
            </select>
        </div>
            <div class="form-group">
            <label for="to">&ensp;To :&ensp;</label>
            <select class="form-control" id="to" name="to" required>
                <option value="Bangalore">Bangalore</option>
                <option value="Chennai">Chennai</option>
                <option value="krishnagiri">krishnagiri</option>
                <option value="Salem">salem</option>
                <option value="Ooty">Ooty</option>
                <option value="Dharmapuri">Dharmapuri</option>
            </select>
        </div>
            <div class="form-group">
                <label for="TravelDate">&ensp;Travel Date : &ensp;</label>
                <input type="date" class="form-control" id="date" name="date"  required>
                <small class="text-danger" id="dateError"></small>
                &ensp;
            </div>
            <div class="form-group" >
                <button type="submit" name="SEARCH" id="SEARCH" class="btn btn-default Search"  style="background-color: chocolate; color: white;">SEARCH</button>
            </div>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function(){
           $('#date').change(function(){ 
             var dateInput = $('#date').val();
             var date =new Date(dateInput);
             var today = new Date();

             var yesterday = new Date(Date.now() - 86400000);//24hours * 60 minute * 60secound * 1000 millisec

             if(date < yesterday){
                $('#dateError').text("Please Select Proper Date.");
             }else{
                $('#dateError').text("");
             }
           });           
        });
    </script>
</body>
</html>
