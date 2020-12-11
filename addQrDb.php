<?php
require_once('connect.php');

date_default_timezone_set('Asia/Colombo');
$date = date('Y-m-d H:i:s');

$VehicleCategories = "Customer_Vehicle";
$Remark = "Automate QR BOT";
$vehicle_in = $date;
$vehicle_out = $date;

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    $query = "SELECT * FROM `user_account` WHERE `user_id`='$id'";
    $res = $con->query($query);

    if (mysqli_num_rows($res) == 1) {

        while ($data1 = $res->fetch_assoc()) {
            $VehicleNo = $data1['number_plate'];
        }

        $check = mysqli_query($con, "SELECT * FROM `parking_details` WHERE `vehicle_no`='$VehicleNo' AND `vehicle_out` IS NULL");
        $checkrows = mysqli_num_rows($check);
        if ($checkrows > 0) {
            $qry1 = "UPDATE `parking_details` SET `vehicle_out`='$vehicle_out' WHERE `vehicle_no` = '$VehicleNo'";
            if (!mysqli_query($con, $qry1)) {
                die('Error: ' . mysqli_error($con));
            }
            $response = "Car Exited the Parking  System.";
        } else {
            $qry2 = "INSERT INTO `parking_details`(`vehicle_no`, `vehicle_categorie`, `remark`, `vehicle_in`) VALUES ('$VehicleNo','$VehicleCategories ','$Remark','$vehicle_in')";
            if (!mysqli_query($con, $qry2)) {
                die('Error: ' . mysqli_error($con));
            }
            $response = "Car Entered the Parking System.";
            // echo "Your record Added Successfully";
        }

        echo json_encode($response);
    }
}
exit;
