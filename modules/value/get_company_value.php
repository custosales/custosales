<?php
include_once "../../lang/".$_SESSION['lang'].".php";
include_once "../system/db.php";

include_once "valueclass.php";


$regNumber = $_GET['regNumber'];

$query = "SELECT 
`Sum driftsinntekter` as driftsinntekt,
`Vareforbruk` as varekost,
`". utf8_decode('Lønnskostnader')."` as lonn,
`". utf8_decode('Ordinære avskrivninger')."` as avskrivninger,
`Andre driftskostnader` as driftskostnader,
companyName
from Accounts, Companies WHERE Accounts.regNumber = Companies.RegNumber and Accounts.regNumber=".$regNumber."";


if (!$Result= mysql_db_query($DBName, $query, $Link)) {
           print "No database connection <br>".mysql_error();
        }

$Row=mysql_fetch_array($Result);

$driftsinntekt = $Row['driftsinntekt'];
$varekost = $Row['varekost'];
$lonn = $Row['lonn'];
$avskrivninger = $Row['avskrivninger'];
$driftskostnader = $Row['driftskostnader'];


$factor = 5;
$years = 3;

print "<h1>Firmaverdi for ".$Row['companyName']."</h1>";
 
$CV = new valueComputation();
$CV -> computeCompanyValue ($factor, $driftsinntekt, $varekost, $lonn, $avskrivninger, $andreDriftskostnader, $years)    	

 
	
?>
