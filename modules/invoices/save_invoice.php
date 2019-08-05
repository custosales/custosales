<?php
session_start();
if(!isset($_SESSION['userID'])) { // check if user is logged in
header("Location: ../../index.php");
}

require_once "../system/db.php";
require_once "../../lang/".$_SESSION['lang'].".php";

$formAction = $_GET['formAction'];
$orderID = $_POST['orderID'];
$regNumber = $_POST['regNumber'];
$productID = $_POST['productID'];
$unitPrice = $_POST['unitPrice'];
$orderDate = $_POST['orderDate'];
$customerContact = $_POST['customerContact'];
$creditDays = $_POST['creditDays'];
$otherTerms = $_POST['otherTerms'];
$orderComments = $_POST['comments'];

if($_POST['orderStatusID']!="") {
$orderStatusID = $_POST['orderStatusID'];
} else {
$orderStatusID = 1;
}

if($formAction=="Insert") {
	$queryType = "INSERT INTO";
	$queryEnd="";
} elseif($formAction=="Update") {
	$queryType = "UPDATE";
	$queryEnd="WHERE orderID=".$orderID."";
}

$query =  $queryType." ".$orders." SET 
regNumber='".$regNumber."', 
productID='".$productID."',
orderStatusID = '".$orderStatusID."',
salesRepID='".$_SESSION['userID']."',
unitPrice='".$unitPrice."',
orderDate='".$orderDate."',
customerContact='".$customerContact."',
creditDays='".$creditDays."',
otherTerms='".$otherTerms."',
orderComments='".$orderComments."',
regDate=NOW() ".$queryEnd.";";


if (!$Result= mysql_db_query($DBName, $query, $Link)) {
           	print "Order not saved <br>".$query."<br>".mysql_error();
        } else {
 if($formAction=="Insert") {   // new sales registered, now get orderID and change companyStatus    	
 	$orderID = mysql_insert_id($Link); //get OrderID 

	$querycs = "UPDATE ".$companies." SET companyStatus='customer' WHERE regNumber=".$regNumber; 
		if (!$Resultcs= mysql_db_query($DBName, $querycs, $Link)) {  // update companyStatus
		print "company status not updated<br>".mysql_error();
		
		}

 }      	
?>				
<script type="text/javascript" >
document.location = "../sales/register_sale.php?orderID=<?php print $orderID; ?>"
</script>				
<?php				
		  }
?>
