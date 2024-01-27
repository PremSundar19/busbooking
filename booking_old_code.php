<?php 
session_start();
if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
    exit;
}
$userId = $_SESSION['userid'] ;

if(isset($_SESSION['date'])){
    $date = $_SESSION['date'];
}
 include_once('config.php');
 $form =array();
if(isset($_POST['submit'])){
    $busnumber = $_POST['busno']; $from = $_SESSION['from'];
    $to = $_SESSION['to']; $counted = $_SESSION['count'];
    if($counted == 1){
        for ($i = 0; $i < $counted; $i++) {
             $seatNumber = $_POST['seat'][$i];$seatnum = $seatNumber; $name = $_POST['name'][$i];$gender = $_POST['gender'][$i];$input = strtotime($_POST['dob'][$i]);$dob = Date('Y-m-d', $input);$age = intval($_POST['age'][$i]);$updatedprice = doubleval($_POST['price1'][$i]) ; $from_loc = $_POST['from'][$i];$to_loc = $_POST['to'][$i];
             $form[] = array('seat' => $seatNumber,'name' => $name,'gender'=>$gender,'dob'=>$dob,'age'=>$age,'price' => $updatedprice,'from'=>$from_loc,'to'=>$to_loc,'date'=>$date,'userId'=>$userId,'busId'=>$busnumber);
             $_SESSION['formData'] = $form;
            if($seatNumber === '14'||$seatNumber === '24' || $seatNumber === '34' || $seatNumber === '44' ||$seatNumber === '54'||$seatNumber === '64' || $seatNumber === '74' || $seatNumber === '84'){
                $after = $seatnum + 1;
                $femaleAfter = femaleSeat($con,$after);
                if($femaleAfter &&  $gender !== 'female' ){
                    warningMessage();
                }
            }elseif($seatNumber === '15'||$seatNumber === '25' || $seatNumber === '35' || $seatNumber === '45' ||$seatNumber === '55'||$seatNumber === '65' || $seatNumber === '75' || $seatNumber === '85'){
                $before = $seatnum - 1;
                $femaleBefore = femaleSeat($con,$before);
                if($femaleBefore &&  $gender !== 'female' ){
                    warningMessage();
                }
            }else{
                $before = $seatnum - 1; $after = $seatnum + 1;
                $femaleAfter = femaleSeat($con,$after);
                $femaleBefore = femaleSeat($con,$before);
                   if(($femaleAfter && $gender !== "female" || $femaleBefore &&  $gender !== "female")){
                        warningMessage();
                   }
            }
        }
        payment();
    }elseif($counted >= 2){
        for ($i = 0; $i < $counted; $i++) {
             $seatNumber = $_POST['seat'][$i];$seatnum = $seatNumber; $name = $_POST['name'][$i];$gender = $_POST['gender'][$i];$input = strtotime($_POST['dob'][$i]);$dob = Date('Y-m-d', $input);$age = intval($_POST['age'][$i]);$updatedprice = doubleval($_POST['price1'][$i]) ; $from_loc = $_POST['from'][$i];$to_loc = $_POST['to'][$i];
             $form[] = array('seat' => $seatNumber,'name' => $name,'gender'=>$gender,'dob'=>$dob,'age'=>$age,'price' => $updatedprice,'from'=>$from_loc,'to'=>$to_loc,'date'=>$date,'userId'=>$userId,'busId'=>$busnumber);
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