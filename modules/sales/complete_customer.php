<?php
session_start();
if(!isset($_SESSION['userID'])) { // check if user is logged in
header("Location: ../../index.php");
} else {
header('Content-type: text/xml');
}

require_once("db.php");
// Get Area Names for Javascript select boxes
print"<?xml version=\"1.0\"?>\n";
print "<complete>\n";
$mask = $_GET['mask'];

$query = "SELECT ID, regNumber, companyName from ".$companies." WHERE companyName like '".mysql_real_escape_string($mask)."%' order by companyName";

try {
     $Result = $pdo->query($query);
 } catch (PDOException $e) {
     echo "Data was not fetched, because: ".$e->getMessage();
 }

foreach($Result as $Row) {

print"<option value=\"".$Row['regNumber']."\">".$Row['companyName']."</option>\n";
}
print "</complete>";
?>

