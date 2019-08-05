<?php 
session_start();
require_once "db.php";
//require_once "../../lang/".$_SESSION['lang'].".php";
//$ownerID = $_SESSION['userID'];
?>

<html>
<head>
<meta charset="utf-8" />
<title></title>
</head>
<body>

<?php 

 // Remove duplicate companies 
$i=1; 
$query = "SELECT Orgnr, Bransjekode, Bransjetekst, Fylke from NyeFirmaer"; 

if (!$Result= mysql_db_query($DBName, $query, $Link)) {
           print "No database connection <br>".mysql_error();
        } 
        
while($Row = mysql_fetch_array($Result)) {        

// update or add

$queryi = "UPDATE Companies SET companyCounty='".$Row['Fylke']."', branchCode='".$Row['Bransjekode']."', branchText='".$Row['Bransjetekst']."' 
WHERE regNumber=".$Row['Orgnr']; 

if (!$Resulti= mysql_db_query($DBName, $queryi, $Link)) {
           print "Not updated <br>".mysql_error();
        } else {
        	print "<br>Record ".$i."updated...";
        	}

$i++;
} // end while


?>
</body>
</html>