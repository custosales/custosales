<?php
session_start();
if(!isset($_SESSION['userID'])) { // check if user is logged in
header("Location: ../../index.php");
}

require_once "../system/db.php";
require_once "../../lang/".$_SESSION['lang'].".php";

$orderID = $_GET['orderID'];

$query = "DELETE FROM ".$orders." WHERE orderID=".$orderID;

try {
	$Result = $pdo->query($query);
	print $LANG['order_deleted'];
} catch (PDOException $e) {
	echo "Order was not deleted, because: " . $e->getMessage() . $resultQuery;
}

?>