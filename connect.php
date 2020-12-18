<?php
// $hostname = 'localhost';
// $username = 'root';
// $password = '';
// $dbname = 'pms_db';

$hostname = 'us-cdbr-east-02.cleardb.com';
$username = 'b7937c0332948e';
$password = '1114bc27';
$dbname = 'heroku_25074421fa4c861';

$con = new mysqli($hostname, $username, $password, $dbname);

if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
