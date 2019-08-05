<?php
session_start();
if(!isset($_SESSION['userID'])) { // check if user is logged in
header("Location: ../../index.php");
}

require_once "../system/db.php";
require_once "../../lang/".$_SESSION['lang'].".php";

$tableName = $_GET['tableName'];

$query = "SHOW FIELDS FROM `".$tableName."`";
if (!$Result= mysql_query($query, $Link)) {
         	print "No database connection <br>".mysql_error();
    } 

while($Row = mysql_fetch_row($Result) ) {
$fields .= $Row[0].",";
}
print substr($fields, 0, strlen($fields)-1);
?>