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
            $email = $data1['email'];
        }

        $sql_slot = "SELECT * FROM `parking_slots` WHERE `status`!='Active' AND `status`!='Reserved' LIMIT 1";
        $result_slot = mysqli_query($con, $sql_slot);
        while ($row_slot = mysqli_fetch_array($result_slot)) {
            $ParkingSlot = $row_slot["parking_slot"];
        }

        $check = mysqli_query($con, "SELECT * FROM `parking_details` WHERE `vehicle_no`='$VehicleNo' AND `vehicle_out` IS NULL");
        $checkrows = mysqli_num_rows($check);
        if ($checkrows > 0) {
            while ($checkrows = mysqli_fetch_array($check)) {
                $check_vehicle_in = $checkrows["vehicle_in"];
            }

            $timediff = strtotime($vehicle_out) - strtotime($check_vehicle_in);

            if ($timediff <= 7200) {
                $cost = 50;
            } else {
                $cost = (($timediff - 7200) * 2) + 50;
            }

            $qry0 = "INSERT INTO `smart_wallet`(`date`, `email`, `price`) VALUES ('$vehicle_out', '$email', '-$cost')";
            $qry1 = "UPDATE `parking_details` SET `vehicle_out`='$vehicle_out', `parking_slot`='$ParkingSlot' WHERE `vehicle_no` = '$VehicleNo'";
            $qry11 = "UPDATE `parking_slots` SET `status`='Inactive',`email`='' WHERE `email`='$email'";

            mysqli_query($con, $qry0);
            mysqli_query($con, $qry11);
            $result = mysqli_query($con, $qry1)
                or die('Error: ' . mysqli_error($con));

            $response = "Car Exited the Parking  System.<br> <strong style='font-size: 20px;'>Parking Fee Rs " . $cost . "</strong>";
        } else {
            $qry2 = "INSERT INTO `parking_details`(`vehicle_no`, `vehicle_categorie`, `remark`,`parking_slot`, `vehicle_in`) VALUES ('$VehicleNo','$VehicleCategories ','$Remark','$ParkingSlot','$vehicle_in')";
            $qry22 = "UPDATE `parking_slots` SET `status`='Reserved',`email`='$email' WHERE `parking_slot`='" . $ParkingSlot . "'";

            mysqli_query($con, $qry22);
            $result = mysqli_query($con, $qry2)
                or die('Error: ' . mysqli_error($con));

            $response = "Car Entered the Parking System.";
            // echo "Your record Added Successfully";
        }

        echo json_encode($response);
    }
}
exit;
