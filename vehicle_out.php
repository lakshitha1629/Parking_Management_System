<?php
require_once ('connect.php');

$id = $_GET['id']; // $id is now defined

date_default_timezone_set('Asia/Colombo');
$date = date('Y-m-d H:i:s');
$vehicle_out = $date;
      
mysqli_query($con,"UPDATE `parking_details` SET `vehicle_out`='$vehicle_out' WHERE `p_no` = '".$id."' ");

// $qry = "UPDATE `parking_details` SET `vehicle_out`='$vehicle_out' WHERE `p_no`= '$VehicleNo'";

mysqli_close($con);
header("Location: dashboard.php");
?>
