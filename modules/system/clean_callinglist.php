<?php 
session_start();
require_once "db.php";
require_once "../../lang/".$_SESSION['lang'].".php";
$ownerID = $_SESSION['userID'];
?>

<html>
<head>
<meta charset="utf-8" />
<title></title>
</head>
<body>

<?php 

 // Remove duplicate companies 
 
$query = "Alter IGNORE table ".$callinglists." add unique key (Orgnr)"; 

if (!$Result= mysql_db_query($DBName, $query, $Link)) {
           print "No database connection <br>".mysql_error();
        } else {
        	print "Duplicate org.numbers removed";
        	}

// remove companies with no phone

$query = "DELETE FROM ".$callinglists." WHERE Telefon is null and Mobil is null"; 

if (!$Result= mysql_db_query($DBName, $query, $Link)) {
           print "No database connection <br>".mysql_error();
        } else {
        	print "<br>Records with no phone or mobile removed";
        	}




?>
</body>
</html>