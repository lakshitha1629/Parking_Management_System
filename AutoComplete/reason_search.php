<?php


  require_once ('../connect.php');

  $searchTerm = $_GET['term']; 

$query = $con->query("SELECT * FROM cbm_cell_block WHERE `reason` LIKE '%".$searchTerm."%' GROUP BY `reason` ORDER BY `reason` ASC");
while ($row = $query->fetch_assoc()) {
    $data[] = $row['reason'];
}
//return json data
echo json_encode($data);
?>
