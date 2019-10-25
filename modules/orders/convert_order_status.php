<?php
session_start();
if(!isset($_SESSION['userID'])) { // check if user is logged in
header("Location: ../../index.php");
}


require_once "../system/db.php";
require_once "../../lang/".$_SESSION['lang'].".php";

$orderID = $_GET['orderID'];
$orderStatusID = $_GET['orderStatusID'];


$query = "UPDATE ".$orders." SET orderStatusID='".$orderStatusID."' WHERE orderID=".$orderID;

try {
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':orderStatusIDID', $orderStatusID );
    $stmt->bindParam(':orderID', $orderID );
    $stmt->execute();
	print $LANG['order_status_changed'];
} catch (PDOException $e) {
    echo "Order Status not changed, because: ".$e->getMessage();
}

