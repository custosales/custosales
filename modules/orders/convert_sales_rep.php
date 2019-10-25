<?php
session_start();
if(!isset($_SESSION['userID'])) { // check if user is logged in
header("Location: ../../index.php");
}


require_once "../system/db.php";
require_once "../../lang/".$_SESSION['lang'].".php";


$query = "UPDATE ".$orders." SET salesRepID=:salesRepID WHERE orderID=:orderID";

$salesRepID = $_GET['salesRepID'];
$orderID = $_GET['orderID'];

try {
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':salesRepID', $salesRepID );
    $stmt->bindParam(':orderID', $orderID );
    $stmt->execute();
    print $LANG['sales_rep_changed'];
} catch (PDOException $e) {
    echo "Sales Rep not changed, because: ".$e->getMessage();
}

