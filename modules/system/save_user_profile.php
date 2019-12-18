<?php
session_start();
if(!isset($_SESSION['userID'])) {
header("Location: ../../index.php");
}
require_once("db.php");
require_once("../../lang/".$_SESSION['lang'].".php");

$fullName = $_POST['fullName'];
$userEmail = $_POST['userEmail'];
$address = $_POST['address'];
$zipCode = $_POST['zipCode'];
$city = $_POST['city'];
$phone = $_POST['phone'];
$mobilePhone = $_POST['mobilePhone'];

$query = "UPDATE ".$users." SET 

fullName = '".$fullName."', 
userEmail = '".$userEmail."', 
address = '".$address."', 
zipCode = '".$zipCode."', 
city = '".$city."', 
phone = '".$phone."', 
mobilePhone = '".$mobilePhone."' 

WHERE userID =".$_SESSION['userID'];

try {
    $stmt = $pdo->query($query);
    print $LANG['data_saved'];
} catch (PDOException $e) {
    print $LANG['data_not_saved']." ".$e->getMessage();
}


?>