<?php

require_once('../connect.php');

if (isset($_POST['search'])) {
  $search = $_POST['search'];

  $query = "SELECT * FROM `user_account` WHERE `number_plate` LIKE '%" . $search . "%' GROUP BY `number_plate`";
  $result = mysqli_query($con, $query);

  $response = array();
  while ($row = mysqli_fetch_array($result)) {
    $response[] = array("value" => $row['number_plate']);
  }

  echo json_encode($response);
}

exit;
