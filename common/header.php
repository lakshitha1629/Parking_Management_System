<?php
error_reporting(E_ERROR | E_PARSE);

include('functions.php');
if (!isLoggedIn()) {
  $_SESSION['msg'] = "You must log in first";
  header('location: index.php');
}

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 900)) {
  // last request was more than 15 minutes ago
  session_unset();     // unset $_SESSION variable for the run-time 
  session_destroy();   // destroy session data in storage
}
$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Parking Management System</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" href="images/icons/favicon.ico" />
  <link rel="apple-touch-icon" href="/images/icons/favicon.png" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta name="theme-color" content="#4285f4">
  <script src="https://kit.fontawesome.com/f55ff8b89d.js" crossorigin="anonymous"></script>
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css">
</head>

<body id="page-top">