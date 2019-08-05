<?php
session_start();
if(!isset($_SESSION['userID'])) {
header("Location: ../../index.php");
}

require_once "../system/db.php";
require_once "../../lang/".$_SESSION['lang'].".php";
include_once "createLeadsClass.php";

$length = strlen($_GET['list'])-1;

$callingListTable = $_GET['tableName'];





$regNumberList = substr($_GET['list'], 0, $length); 

if($regNumberList!="") {  // create Leads if list is not empty

$listArray = explode(",", $regNumberList);

//$result = count($listArray);

$leadslagret=0;

foreach ($listArray as $regNumber) {

$lead = new Leads;
$lead -> regNumber = $regNumber;
$lead -> DBName = $DBName;
$lead -> conn = $Link;
$lead -> companies = $companies;
$lead -> callingListTable = $callingListTable; 
$lead -> userID = $_SESSION['userID'];
$lead -> projectFirstSalesStage = $_SESSION['projectFirstSalesStage'];


// Insert Lead
$lead -> createLead ($regNumber);


$leadssaved++; 


} // end foreach

print($leadssaved." ".$LANG['leads']." ".strtolower($LANG['saved']));


} // end if list not empty
?>
