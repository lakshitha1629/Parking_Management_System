<?php
session_start();
require_once('connect.php');

$request = $_REQUEST;
$col = array(
    0   =>  'p_no',
    1   =>  'vehicle_no',
    2   =>  'vehicle_categorie',
    3   =>  'remark',
    4   =>  'vehicle_in',
    5   =>  'vehicle_out',
    6   =>  'user_id',
    7   =>  'name',
    8   =>  'email',
    9   =>  'user_type',
    10   =>  'password',
    11   =>  'activated',
    12   =>  'number_plate',
    13   =>  'vehicle_type',
    14   =>  'phone'
);  //create column like table in database

$user = $_SESSION['email'];
$sql = "SELECT * FROM parking_details JOIN user_account ON parking_details.vehicle_no = user_account.number_plate  WHERE parking_details.vehicle_out IS NULL";
$query = mysqli_query($con, $sql);

$totalData = mysqli_num_rows($query);

$totalFilter = $totalData;

//Search
$sql = "SELECT * FROM parking_details JOIN user_account ON parking_details.vehicle_no = user_account.number_plate WHERE 1=1 AND parking_details.vehicle_out IS NULL";
if (!empty($request['search']['value'])) {
    $sql .= " AND (vehicle_no Like '" . $request['search']['value'] . "%' ";
    $sql .= " OR vehicle_categorie Like '" . $request['search']['value'] . "%' ";
    $sql .= " OR name Like '" . $request['search']['value'] . "%' ";
    $sql .= " OR email Like '" . $request['search']['value'] . "%' ";
    $sql .= " OR vehicle_type Like '" . $request['search']['value'] . "%' ";
    $sql .= " OR phone Like '" . $request['search']['value'] . "%' )";
}

$query = mysqli_query($con, $sql);
$totalData = mysqli_num_rows($query);

//Order
$sql .= " ORDER BY " . $col[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'] . "  LIMIT " .
    $request['start'] . "  ," . $request['length'] . "  ";

$query = mysqli_query($con, $sql);

$data = array();

while ($row = mysqli_fetch_array($query)) {
    $subdata = array();
    $subdata[] = $row[1];
    $subdata[] = $row[2];
    $subdata[] = $row[7];
    $subdata[] = $row[8];
    $subdata[] = $row[13];
    $subdata[] = $row[14];
    $subdata[] = $row[4];
    $subdata[] = $row[5];
    $data[] = $subdata;
}

$json_data = array(
    "draw"              =>  intval($request['draw']),
    "recordsTotal"      =>  intval($totalData),
    "recordsFiltered"   =>  intval($totalFilter),
    "data"              =>  $data
);

echo json_encode($json_data);
