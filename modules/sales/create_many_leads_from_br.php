<?php
session_start();
if(!isset($_SESSION['userID'])) {
header("Location: ../../index.php");
}

require_once "../system/db.php";
require_once "../../lang/".$_SESSION['lang'].".php";
include_once "../../classes/getinfoclass.php";

$length = strlen($_GET['list'])-1;

$regNumberList = substr($_GET['list'], 0, $length); 

if($regNumberList!="") {  // create Leads if list is not empty

$listArray = explode(",", $regNumberList);

//$result = count($listArray);

$leadslagret=0;

foreach ($listArray as $regNumber) {

$info = new getInfo;
$info -> regNumber = $regNumber;
$info -> DBName = $DBName;
$info -> conn = $Link;
$info -> companies = $companies;
$info -> callinglists = $_SESSION['userCallingLists'];
$info -> userID = $_SESSION['userID'];


// Insert Lead
$info -> getContactData ($regNumber);


$leadssaved++; 


} // end foreach

print($leadssaved." ".$LANG['leads']." ".strtolower($LANG['saved']));


} // end if list not empty
?>
