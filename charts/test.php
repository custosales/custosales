<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title></title>
</head>
<body>
<?php
require_once '../lib/db.php';
require_once '../OpenChart/php-ofc-library/open-flash-chart.php';
require_once "../lang/no_nb.php";

$query = " SELECT * FROM ".$accounts." WHERE customerID='1' ORDER BY Aar";
        // Connect to databas
        if (!$Result= mysql_db_query($DBName, $query, $Link)) {
           print "No database connection <br>".mysql_error();
           }
$data_1 = array();
           
while($Row=MySQL_fetch_array($Result)) {
	$data_1[$Row['Aar']] = $Row['Varekostnad'];
   	}         

?>
</body>
</html>