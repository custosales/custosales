<?php
session_start();
if(!isset($_SESSION['userID'])) { // check if user is logged in
header("Location: ../index.php");
}

require_once "../system/db.php";
require_once "../../lang/".$_SESSION['lang'].".php";

$orderStatusID = $_GET['orderStatusID'];

$query = "SELECT orderStatusName FROM OrderStatus WHERE orderStatusID=".$orderStatusID;
if (!$Result= mysql_db_query($DBName, $query, $Link)) {
           	print "No database connection <br>".mysql_error();
        } else {
			$Row=MySQL_fetch_array($Result);
			print $Row['orderStatusName'];
			}

?>