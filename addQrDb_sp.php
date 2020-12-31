<?php
require_once('connect.php');

date_default_timezone_set('Asia/Colombo');
$date = date('Y-m-d H:i:s');

if (isset($_POST['slot'])) {
    $id = $_POST['id'];
    $ParkingSlot = $_POST['slot'];

    $query = "SELECT * FROM `user_account` INNER JOIN `parking_slots` ON `user_account`.`email` = `parking_slots`.`email` WHERE `user_id`='$id'";
    $res = $con->query($query);

    if (mysqli_num_rows($res) == 1) {

        while ($data1 = $res->fetch_assoc()) {
            $email = $data1['email'];
            $parking_slot = $data1['parking_slot'];
        }

        if ($parking_slot == $ParkingSlot) {
            $check = mysqli_query($con, "SELECT * FROM `parking_slots` WHERE `email`='$email' AND `slot_status`='1'");
            $checkrows = mysqli_num_rows($check);

            if ($checkrows > 0) {
                $qry1 = "UPDATE `parking_slots` SET `slot_status`='0' WHERE `email`='" . $email . "'";
                $result = mysqli_query($con, $qry1)
                    or die('Error: ' . mysqli_error($con));

                $response = "<strong style='font-size: 20px;'>Slot Number " . $ParkingSlot . "- </strong><br>Car Exited the Parking Slot.";
            } else {
                $qry2 = "UPDATE `parking_slots` SET `slot_status`='1' WHERE `email`='" . $email . "'";
                $result = mysqli_query($con, $qry2)
                    or die('Error: ' . mysqli_error($con));

                $response = "<strong style='font-size: 20px;'>Slot Number " . $ParkingSlot . "- </strong><br>Car Entered the Parking Slot.";
            }


            // echo json_encode($response);
        } else {
            print($parking_slot);
        }
        echo json_encode($response);
    }
}
exit;
