<?php
require_once ('connect.php');

$id = $_GET['id']; // $id is now defined
$active = $_GET['active'];
// column is indeed an int
// $id = (int)$_GET['id'];
if($active =='1'){
    mysqli_query($con,"UPDATE `user_account` SET `activated`='0' WHERE `user_id`='".$id."'");

}else{
    mysqli_query($con,"UPDATE `user_account` SET `activated`='1' WHERE `user_id`='".$id."'");

}

mysqli_close($con);
header("Location: Registration.php");
?> 