<?php
include 'pdo.php';

if (!empty($_POST)) {
    $id = $_POST["ID"];
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM `parking_slot` WHERE `space_no` = '$id'";

    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();

    echo $data['status'];
}
