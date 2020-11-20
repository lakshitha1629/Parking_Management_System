<?php
session_start();

require_once('connect.php');

$request = $_REQUEST;
$col = array(
    0   =>  'request',
    1   =>  'siteID',
    2   =>  'siteName',
    3   =>  'supplyDate',
    4   =>  'startingBalance',
    5   =>  'noLitresPumped',
    6   =>  'currentMeter',
    7   =>  'previousSupplyDate',
    8   =>  'previousMeter',
    9   =>  'dieselConsumption',
    10   =>  'runningHours',
    11   =>  'consumptionLH',
    12   =>  'amountforDiesel',
    13   =>  'labourTransport',
    17   =>  'totalAmount'
);  //create column like table in database

$Vendor = $_SESSION['user_name'];

// $sql = "SELECT * FROM total_geny_records";
$sql = "SELECT * FROM `total_geny_records` WHERE vendor = '" . $Vendor . "'";

$query = mysqli_query($con, $sql);

$totalData = mysqli_num_rows($query);

$totalFilter = $totalData;

//Search
$sql = "SELECT * FROM total_geny_records WHERE 1=1 AND vendor = '" . $Vendor . "'";
if (!empty($request['search']['value'])) {
    $sql .= " AND (siteID Like '" . $request['search']['value'] . "%' ";
    $sql .= " OR siteName Like '" . $request['search']['value'] . "%' ";
    $sql .= " OR supplyDate Like '" . $request['search']['value'] . "%' ";
    $sql .= " OR startingBalance Like '" . $request['search']['value'] . "%' )";
}

// (`id`, `siteID`, `siteName`, `supplyDate`, `startingBalance`, `noLitresPumped`, `currentMeter`, 
// `previousSupplyDate`, `previousMeter`, `dieselConsumption`, `runningHours`, `consumptionLH`, 
// `amountforDiesel`, `labourTransport`, `NBT`, `VAT`, `totalAmount`, `TPRate`, `runningDays`,
//  `invoiceNo`, `invoiceDate`, `invoicePdDate`, `remark`)
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
    $subdata[] = $row[3];
    $subdata[] = $row[4];
    $subdata[] = $row[5];
    $subdata[] = $row[6];
    $subdata[] = $row[7];
    $subdata[] = $row[8];
    $subdata[] = $row[9];
    $subdata[] = $row[10];
    $subdata[] = $row[11];
    $subdata[] = $row[12];
    $subdata[] = $row[13];
    $subdata[] = $row[14];
    $subdata[] = $row[17];
   
    $data[] = $subdata;
}

$json_data = array(
    "draw"              =>  intval($request['draw']),
    "recordsTotal"      =>  intval($totalData),
    "recordsFiltered"   =>  intval($totalFilter),
    "data"              =>  $data
);

echo json_encode($json_data);

?>