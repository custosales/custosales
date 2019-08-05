<?php
session_start();
if(!isset($_SESSION['userID'])) { // check if user is logged in
header("Location: ../../index.php");
}

require_once "../system/db.php";

$regNumber = str_replace(" ", "", $_POST['0']);
$companyName = $_POST['1'];
$companyType = $_POST['2'];
$companyAddress = $_POST['3'];
$companyCity = $_POST['4'];
$companyPostAddress = $_POST['5'];
$companyEmail = $_POST['6'];
$companyInternet = $_POST['7'];
$companyPhone = str_replace(" ", "", $_POST['8']);
$companyMobilePhone = str_replace(" ", "", $_POST['9']);
$companyFax = str_replace(" ", "", $_POST['10']);
$dateRegistered = $_POST['11'];
$dateIncorporated = $_POST['12'];
$companyManager = $_POST['13'];
$branchCode = rtrim($_POST['14']);

if($branchCode=="") {   //  Check for existing Forretningsfører and ajust accordingly
$branchCode = utf8_decode(rtrim($_POST['15']));
$branchCode =  str_replace(" ","", $branchCode);
$branchCode =  str_replace("?","", $branchCode);
$sectorCode = rtrim($_POST['16']);
} else {
$sectorCode = rtrim($_POST['15']);	
}	

if(substr($branchCode, 0, 1)=="0") {
	$branchCode = substr($branchCode, 1);
	}

$companyStatus = $_POST['companyStatus'];


   $redirect = $companyStatus;

	



if($_GET['ID']!="") {  //Update record

$query = "UPDATE ".$companies." SET 
regNumber = '".$regNumber."',
companyName = '".$companyName."',
companyType = '".$companyType."',
companyStatus = '".$companyStatus."',
companyEmail = '".$companyEmail."',
companyInternet = '".$companyInternet."',
companyPhone = '".$companyPhone."',
companyMobilePhone = '".$companyMobilePhone."',
companyFax = '".$companyFax."',
companyAddress = '".$companyAddress."',
companyPostAddress = '".$companyPostAddress."',
companyCity = '".$companyCity."',
dateRegistered = '".$dateRegistered."',
dateIncorporated = '".$dateIncorporated."',
companyManager = '".$companyManager."',
branchCode = '".$branchCode."',
sectorCode = '".$sectorCode."', 
salesRepID = '".$_SESSION['userID']."'

WHERE ID = ".$_GET['ID']."
";
	
	} else { // Create new record

$query = "INSERT INTO ".$companies." SET 
regNumber = '".$regNumber."',
companyName = '".$companyName."',
companyType = '".$companyType."',
companyStatus = '".$companyStatus."',
companyEmail = '".$companyEmail."',
companyInternet = '".$companyInternet."',
companyPhone = '".$companyPhone."',
companyMobilePhone = '".$companyMobilePhone."',
companyFax = '".$companyFax."',
companyAddress = '".$companyAddress."',
companyPostAddress = '".$companyPostAddress."',
companyCity = '".$companyCity."',
dateRegistered = '".$dateRegistered."',
dateIncorporated = '".$dateIncorporated."',
companyManager = '".$companyManager."',
branchCode = '".$branchCode."',
sectorCode = '".$sectorCode."',
regDate = NOW(),
salesRepID = '".$_SESSION['userID']."'
";
}

 if (!$Result= mysql_db_query($DBName, $query, $Link)) {
           print "Record not saved <br>".mysql_error();
        } else {
           print  "Record saved";
        }


$queryl = "UPDATE ".$_SESSION['userCallingLists']." SET salesRepID=".$_SESSION['userID']." WHERE Orgnr=".$regNumber; 

if (!$Resultl= mysql_db_query($DBName, $queryl, $Link)) {
           print "Record not updated<br>".mysql_error();
        } else {
           print  "Record updated";
        }


?>

<script type="text/javascript" >
history.back();
</script>
