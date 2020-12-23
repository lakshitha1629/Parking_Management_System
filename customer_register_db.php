<?php
if (isset($_POST['reg_btn'])) {
    require_once('connect.php');

    date_default_timezone_set('Asia/Colombo');
    $date = date('Y-m-d H:i:s');

    //$date = $_POST['date'];
    $user_id = uniqid();
    $name = $_POST['FirstName'] . ' ' . $_POST['LastName'];
    $VehicleNumberPlate = $_POST['VehicleNumberPlate'];
    $VehicleTypes = $_POST['VehicleTypes'];
    $PhoneNumber = $_POST['PhoneNumber'];
    $Email = $_POST['Email'];
    $password1 = $_POST['Password'];
    $password2 = $_POST['RepeatPassword'];
    $type = '2';
    $active = '1';

    // QR Code
    require_once('./phpqrcode/qrlib.php');
    // include './phpqrcode/qrlib.php';
    $path = 'images/QR/';
    $QR_Code = $path . $user_id . ".png";
    $ecc = 'L';
    $pixel_Size = 10;
    $frame_Size = 10;

    // Generates QR Code and Stores it in directory given 
    QRcode::png($user_id, $QR_Code, $ecc, $pixel_Size);

    if ($password1 != $password2) {
        echo "The two passwords do not match";
    } else {
        $password = md5($password1);
        $qry = "INSERT INTO `user_account`(`user_id`,`name`, `email`, `user_type`, `password`, `activated`, `number_plate`, `vehicle_type`, `phone`) VALUES ('$user_id','$name','$Email','$type','$password','$active','$VehicleNumberPlate','$VehicleTypes','$PhoneNumber')";
        $qry1 = "INSERT INTO `smart_wallet`(`date`, `email`, `price`) VALUES ('$date', '$Email', '1000')";

        mysqli_query($con, $qry);
        $result = mysqli_query($con, $qry1)
            or die('Error: ' . mysqli_error($con));

        header("Location: index.php?status=success");
        // echo "<br><div class='form'>
        //             You are registered successfully. Click here to <a href='index.php'>Login</a>
        //         </div>";
    }
}
