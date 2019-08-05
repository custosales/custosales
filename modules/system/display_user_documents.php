<?php
session_start();
if(!isset($_SESSION['userID'])) {
header("Location: ../login.php; Window-target: top");
}
require_once("db.php");
require_once("../../lang/".$_SESSION['lang'].".php");


$query = "SELECT * from ".$users." WHERE userID=".$_SESSION['userID'];	

$Result = mysql_db_query($DBName, $query, $Link) or die(MySql_error());
$i=1;
?>
<br>
<iframe style="margin:0;padding:0;border:none;width:1005px;height:10000px" src="documents/index.php?userID=<?php print $_SESSION['userID']; ?>"></iframe>
