<?php
require_once('connect.php');

$request = $_REQUEST;
$col = array(
    0   =>  'siteID',
    1   =>  'siteName',
    2   =>  'supplyDate',
    3   =>  'startingBalance',
    4   =>  'noLitresPumped',
    5   =>  'currentMeter',
    6   =>  'previousSupplyDate',
    7   =>  'previousMeter',
    8   =>  'dieselConsumption',
    9   =>  'runningHours',
    10   =>  'consumptionLH',
    11   =>  'amountforDiesel',
    12   =>  'labourTransport',
    13   =>  'NBT',
    14   =>  'VAT',
    15   =>  'totalAmount',
    16   =>  'TPRate',
    17   =>  'totalAmount',
    18   =>  'runningDays',
    19   =>  'invoiceNo',
    20   =>  'invoiceDate',
    21   =>  'invoicePdDate',
    22   =>  'remark'
);  //create column like table in database

// (`id`, `siteID`, `siteName`, `supplyDate`, `startingBalance`, `noLitresPumped`, 
// `currentMeter`, `previousSupplyDate`, `previousMeter`, `dieselConsumption`, `runningHours`, `consumptionLH`, 
// `amountforDiesel`, `labourTransport`, 
// `NBT`, `VAT`, `totalAmount`, `TPRate`, `runningDays`, `invoiceNo`, `invoiceDate`, `invoicePdDate`, `remark`)

$sql = "SELECT * FROM total_geny_records WHERE `request`='Pending..'";
$query = mysqli_query($con, $sql);

$totalData = mysqli_num_rows($query);

$totalFilter = $totalData;

//Search
$sql = "SELECT * FROM total_geny_records WHERE 1=1 AND `request`='Pending..'";
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
 //   $a= $row[0];
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
    $subdata[] = $row[15];
    $subdata[] = $row[16];
    $subdata[] = $row[17];
    $subdata[] = $row[18];
    $subdata[] = $row[19];
    $subdata[] = $row[20];
    $subdata[] = $row[21];
    $subdata[] = $row[22];
    $subdata[] = $row[23];
     $subdata[] = '<a onClick=\"return confirm("Are you sure you want to approve requestor?")\" href=\"approve_Requestor.php?id=" . $row["id"] . "\" class="btn"><i class="fas fa-mail-bulk" style="font-size:20px;color:blue"></i></a>
                  <a onClick=\"return confirm("Are you sure you want to delete?")\" href=\"delete_Requestor.php?id=" . $row["id"] . "\" class="btn"><i class="fa fa-window-close" style="font-size:20px;color:red"></i></a>';
    $data[] = $subdata;
}

$json_data = array(
    "draw"              =>  intval($request['draw']),
    "recordsTotal"      =>  intval($totalData),
    "recordsFiltered"   =>  intval($totalFilter),
    "data"              =>  $data
);

echo json_encode($json_data);
