<?php
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
$branchCode = $_POST['14'];
$sectorCode = $_POST['15'];


if($_GET['ID']!="") {  //Update record

$query = "UPDATE ".$companies." SET 
regNumber = '".$regNumber."',
companyName = '".$companyName."',
companyType = '".$companyType."',
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
sectorCode = '".$sectorCode."' 
WHERE ID = ".$_GET['ID']."
";
	
	} else { // Create new record

$query = "INSERT INTO ".$companies." SET 
regNumber = '".$regNumber."',
companyName = '".$companyName."',
companyType = '".$companyType."',
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
sectorCode = '".$sectorCode."'
";
}

 if (!$Result= mysql_db_query($DBName, $query, $Link)) {
           print "Record not saved <br>".mysql_error();
        } else {
           print  "Record saved";
        }

?>