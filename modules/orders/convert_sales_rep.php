<?php
session_start();
if(!isset($_SESSION['userID'])) { // check if user is logged in
header("Location: ../../index.php");
}


require_once "../system/db.php";
require_once "../../lang/".$_SESSION['lang'].".php";


$query = "UPDATE ".$orders." SET salesRepID=:salesRepIDID WHERE orderID=:orderID";
try {
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':salesRepID', $_GET['salesRepID'] );
    $stmt->bindParam(':orderID', $_GET['orderID'] );
    $stmt->execute();

} catch (PDOException $e) {
    echo "Data was not saved, because: ".$e->getMessage();
}


if (!$Result= mysql_db_query($DBName, $query, $Link)) {
           	print "No database connection <br>".mysql_error();
        } else {
				print $LANG['sales_rep_changed'];
		  }

