<?php
include('functions.php');
if (!isLoggedIn()) {
    $_SESSION['msg'] = "You must log in first";
    header('location: index.php');
}

$user = $_SESSION['email'];
date_default_timezone_set('Asia/Colombo');
$date = date('Y-m-d H:i:s');
$vehicle_out = $date;
$status = 'Inactive';
$email = ' ';

if (isset($_POST['id'])) {
    $id = $_POST['id']; // $id is now defined
    $SpaceNo = $_POST['ParkingSlot'];
    $VehicleIn_pre = $_POST['VehicleIn'];
    $VehicleIn = date('Y-m-d H:i:s', $VehicleIn_pre);
    $timediff = strtotime($vehicle_out) - strtotime($VehicleIn);

    if ($timediff <= 7200) {
        $cost = 50;
    } else {
        $cost = (($timediff - 7200) * 2) + 50;
    }

    $qry2 = "INSERT INTO `smart_wallet`(`date`, `email`, `price`) VALUES ('$vehicle_out', '$user', '$cost')";
    $qry1 = "UPDATE `parking_details` SET `vehicle_out`='$vehicle_out' WHERE `p_no` = '" . $id . "'";
    $qry = "UPDATE `parking_slots` SET `status`='$status',`email`='$email' WHERE `parking_slot`='" . $SpaceNo . "'";

    mysqli_query($con, $qry);
    mysqli_query($con, $qry2);

    $result = mysqli_query($con, $qry1)
        or die('Error: ' . mysqli_error($con));
    $response = "Parking Fee Rs " . $cost;

    echo json_encode($response);
}
exit;
