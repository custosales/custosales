<?php
session_start();
if(!isset($_SESSION['userID'])) {
header("Location: ../../index.php");
}
require_once("db.php");
require_once("../../lang/".$_SESSION['lang'].".php");

$fullName = utf8_decode($_POST['fullName']);
$userEmail = utf8_decode($_POST['userEmail']);
$address = utf8_decode($_POST['address']);
$zipCode = $_POST['zipCode'];
$city = utf8_decode($_POST['city']);
$phone = utf8_decode($_POST['phone']);
$mobilePhone = utf8_decode($_POST['mobilePhone']);

$query = "UPDATE ".$users." SET 

fullName = '".$fullName."', 
userEmail = '".$userEmail."', 
address = '".$address."', 
zipCode = '".$zipCode."', 
city = '".$city."', 
phone = '".$phone."', 
mobilePhone = '".$mobilePhone."' 

WHERE userID =".$_SESSION['userID'];

if($Result = mysql_query($query, $Link)) {
 print $LANG['data_saved'];
} else {
 print $LANG['data_not_saved']." ".mysql_error();	
}	
?>