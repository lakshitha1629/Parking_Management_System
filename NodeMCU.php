<?php

require_once('connect.php');

date_default_timezone_set('Asia/Colombo');
$time = date('H:i:s');

// If values send by NodeMCU are not empty then insert into MySQL database table

if (!empty($_POST['sendval']) && !empty($_POST['sendval2'])) {

    $val2 = $_POST['sendval2'];
    $space_no = $_POST['sendval'];

    // Update your tablename here
    $sql = "UPDATE `parking_slot` SET `vehicle_entering`='$time',`status`='$val2' WHERE `space_no`= '$space_no'";

    if ($con->query($sql) === TRUE) {
        echo "Values inserted in MySQL database table.";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
}

// Close MySQL connection
$con->close();
