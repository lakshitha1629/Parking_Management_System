<?php
session_start();

require_once('connect.php');

$request = $_REQUEST;
$col = array(
    0   =>  'siteID',
    1   =>  'siteName',
    2   =>  'supplyDate',
    3   =>  'startingBalance',
    4   =>  'noLitresPumped',
    5   =>  'currentMeter',
    6   =>  'previousSupplyDate'
);  //create column like table in database


$sql = "SELECT * FROM total_geny_records WHERE `active`='1'";
$query = mysqli_query($con, $sql);

$totalData = mysqli_num_rows($query);

$totalFilter = $totalData;

//Search
$sql = "SELECT * FROM total_geny_records WHERE 1=1 AND `active`='1'";
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
    $subdata[] = $row[3];
    $subdata[] = $row[4];
    $subdata[] = $row[6];
    $subdata[] = $row[7];
    $subdata[] = '<button type="button" id="getEdit" class="btn btn-secondary btn-xs" data-toggle="modal" data-target="#myModal" data-id="' . $row[0] . '"><i class="glyphicon glyphicon-pencil">&nbsp;</i>Vehicle Exit</button>';
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