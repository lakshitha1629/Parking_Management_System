<?php
require_once ('connect.php');

$id = $_GET['id']; // $id is now defined

mysqli_query($con,"UPDATE `total_geny_records` SET `request`='Approved',`active`='1' WHERE `id` = '".$id."' ");

mysqli_close($con);
header("Location: Vendor_Requests.php");
?> 