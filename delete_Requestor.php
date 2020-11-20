<?php
require_once ('connect.php');

$id = $_GET['id']; // $id is now defined

// column is indeed an int
// $id = (int)$_GET['id'];

mysqli_query($con,"DELETE FROM `total_geny_records` WHERE `id`='".$id."'");

// if(mysqli_affected_rows($con)==0)
//   {
//     echo (mysqli_affected_rows($con)==0);
//     echo ("<script language='javascript'>
//              window.alert('Alredy blocked.. Can't remove recode!')
//              window.location.href='javascript:history.back()'
//            </script>");
//   }
//   else
//   {
//     echo (mysqli_affected_rows($con)==0);
//     echo ("<script language='javascript'>
//              window.alert('Deleted!')
//              window.location.href='dashboard_Requestor.php'
//            </script>");
//   } 
  mysqli_close($con);
  header("Location: Vendor_Requests.php");
?> 