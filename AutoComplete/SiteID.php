<?php

  require_once ('../connect.php');

//   $searchTerm = $_GET['term']; 
  
// $query = $con->query("SELECT * FROM `standby_geny_list` WHERE `site_id` LIKE '%".$searchTerm."%' GROUP BY `site_id` ORDER BY `site_id` ASC");
// while ($row = $query->fetch_assoc()) {
//    $data[] = $row['site_id'];
//    $data[] = $row['site_name'];
// }
// echo json_encode($data);

if(isset($_POST['search'])){
 $search = $_POST['search'];

 $query = "SELECT * FROM `standby_geny_list` WHERE `site_id` LIKE '%".$search."%' GROUP BY `site_id` ORDER BY `site_id` ASC";
 $result = mysqli_query($con,$query);

 $response = array();
 while($row = mysqli_fetch_array($result) ){
   $response[] = array("value"=>$row['site_id'],"label"=>$row['site_name']);
 }

 echo json_encode($response);
}

exit;
