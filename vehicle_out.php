<?php
require_once('connect.php');

$id = $_GET['id']; // $id is now defined
$SpaceNo = $_GET['ParkingSlot'];

date_default_timezone_set('Asia/Colombo');
$date = date('Y-m-d H:i:s');
$vehicle_out = $date;
$status = 'Inactive';
$email = ' ';

// mysqli_query($con, "UPDATE `parking_details` SET `vehicle_out`='$vehicle_out' WHERE `p_no` = '" . $id . "' ");

// $qry = "UPDATE `parking_details` SET `vehicle_out`='$vehicle_out' WHERE `p_no`= '$VehicleNo'";
$qry1 = "UPDATE `parking_details` SET `vehicle_out`='$vehicle_out' WHERE `p_no` = '" . $id . "'";
$qry = "UPDATE `parking_slots` SET `status`='$status',`email`='$email' WHERE `parking_slot`='" . $SpaceNo . "'";

mysqli_query($con, $qry);

$result = mysqli_query($con, $qry1)
    or die('Error: ' . mysqli_error($con));
echo "Your record Added Successfully";

// mysqli_close($con);
header("Location: dashboard.php");
