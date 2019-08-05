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
$query = "UPDATE Companies set companyStatus=(SELECT salesStageID from SalesStages WHERE salesStageName='Lead') WHERE companyStatus='lead'"; 

if (!$Result= mysql_db_query($DBName, $query, $Link)) {
           print "No database connection <br>".mysql_error();
        } 
        
print "Done Leads.....<br>";

$query = "UPDATE Companies set companyStatus=(SELECT salesStageID from SalesStages WHERE salesStageName='Mulighet') WHERE companyStatus='opportunity'"; 

if (!$Result= mysql_db_query($DBName, $query, $Link)) {
           print "No database connection <br>".mysql_error();
        } 
        
print "Done Opportunities......<br>";

$query = "UPDATE Companies set companyStatus=(SELECT salesStageID from SalesStages WHERE salesStageName='Kunde') WHERE companyStatus='customer'"; 

if (!$Result= mysql_db_query($DBName, $query, $Link)) {
           print "No database connection <br>".mysql_error();
        } 
        
print "Done Customers....<br>";

$query = "UPDATE Companies set companyStatus=(SELECT salesStageID from SalesStages WHERE salesStageName='Tapt') WHERE companyStatus='lost'"; 

if (!$Result= mysql_db_query($DBName, $query, $Link)) {
           print "No database connection <br>".mysql_error();
        } 
        
print "Done Lost...<br>";



?>
</body>
</html>