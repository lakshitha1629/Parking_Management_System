<?php
include 'pdo.php';

if (!empty($_POST)) {
    $id = $_POST["ID"];
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM `parking_slots` WHERE `parking_slot` = '$id'";

    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();

    $status = $data['status'];
    $slot_status = $data['slot_status'];

    echo $status;
    echo $slot_status;
}
