<?php
session_start();
if(!isset($_SESSION['userID'])) {
header("Location: ../../index.php");
}
require_once "../system/db.php";
require_once "../../lang/".$_SESSION['lang'].".php";

$ID = $_GET['ID'];
$regNumber = $_GET['regNumber'];
$callinglistTable  = $_GET['tableName'];
$redirect = $_GET['redirect'];

$query = "DELETE FROM Companies WHERE regNumber=".$regNumber;
if (!$Result= mysql_db_query($DBName, $query, $Link)) {
           	print "No database connection <br>".mysql_error();
        } else {
			print $LANG['customer_deleted'];
		  }

if($regNumber!="") {
$queryL = "UPDATE ".$callinglistTable." SET salesRepID=0 WHERE Orgnr=".$regNumber;
	if (!$ResultL= mysql_db_query($DBName, $queryL, $Link)) {
           	print "No database connection <br>".mysql_error();
        } else {
        	print "Moved back to callinglist";
     }   	
}	
?>