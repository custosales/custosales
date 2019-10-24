<?php
session_start();
if(!isset($_SESSION['userID'])) { // check if user is logged in
header("Location: ../index.php");
}

require_once "../system/db.php";
require_once "../../lang/".$_SESSION['lang'].".php";
require_once "sales_class.php";

$userID = $_GET['userID'];

if($_GET['year']!="") {
$year = $_GET['year'];
} else {
$year = date("Y");
}

$SalesReport = new SalesReport();

$SalesReport->userMonthlySales($userID,'month',$year,'tr',$pdo,$LANG);
print "<br>";
$SalesReport->userMonthlySales($userID,'week',$year,'tr',$pdo,$LANG);
print "<br>";
$SalesReport->userMonthlySales($userID,'day',$year,'tr',$pdo,$LANG);


?>



