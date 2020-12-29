<?php
require_once('connect.php');

$id = $_GET['id']; // $id is now defined
$space_no = $_GET['space_no'];

$qry = "UPDATE `booking_parking` SET `book_status`='Canceled' WHERE `booking_no`='" . $id . "'";
$qry1 = "UPDATE `parking_slots` SET `status`='Inactive',`email`='' WHERE `parking_slot`='$space_no'";

mysqli_query($con, $qry);

$result = mysqli_query($con, $qry1)
    or die('Error: ' . mysqli_error($con));

mysqli_close($con);
header("Location: dashboard_Customer.php");
