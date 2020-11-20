
<?php


  require_once ('../connect.php');

  $technology = $_GET['term']; 

$query = $con->query("SELECT * FROM cbm_cell_block WHERE `technology` LIKE '%".$technology."%' GROUP BY `technology` ORDER BY `technology` ASC");
while ($row = $query->fetch_assoc()) {
    $data[] = $row['technology'];
}
//return json data
echo json_encode($data);
?>
