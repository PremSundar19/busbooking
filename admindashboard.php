<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin DashBoard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <style>
        .button-container {
    width: 145px; 
    }
    .button-container1 {
    width: 145px; 
    display: inline-block;
    }

    </style>
</head>

<body>
     <?php
     $conn = mysqli_connect("localhost","root","","busbooking");
           if(isset($_POST["approve"])){
            $userId = $_POST["id"];
            $updateSql = "UPDATE register SET status='approved' WHERE id=$userId";
            mysqli_query($conn, $updateSql);
           }
           else if(isset($_POST["reject"])){
            $userId = $_POST["id"];
            $updateSql1 = " UPDATE register SET status = 'rejected' WHERE id = $userId";
            mysqli_query($conn, $updateSql1);
           }
     ?>

<div class="container">
        <h2>Registered Users</h2>
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Gender</th>
                    <th>status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include_once('config.php');
                $sql = "SELECT *  FROM register";
                $result = mysqli_query($conn,$sql);
              
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_array($result)) {
                        if($row["status"] == "pending"){
                            echo "<tr>";
                            echo "<td>" . $row["name"] . "</td>";
                            echo "<td>" . $row["email"] . "</td>";
                            echo "<td>" . $row["phone"] . "</td>";
                            echo "<td>" . $row["gender"] . "</td>";
                            echo "<td>" . $row["status"] . "</td>";
                            echo "<td>";
                            if ($row["status"] == "pending") {
                                echo "<div class='button-container'>";
                                echo "<form method='post'>";
                                echo "<input type='hidden' name='id' value='" . $row["id"] . "'>";
                                echo "<button type='submit' name='approve' class='btn btn-success'>Approve</button>";
                                echo "<button type='submit' name='reject' class='btn btn-danger'>Reject</button>";
                                echo "</form>";
                                echo "</div>";
                            }
                            echo "</td>";
                            echo "</tr>";
    
                        }    
                    }
                } else {
                    echo "<tr><td colspan='6'>No records found</td></tr>";
                }

                ?>
            </tbody>
        </table>    
    </div>    
</body>
</html>