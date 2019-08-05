<?php
session_start();
if ($_SESSION['userID']!="") {  // User logged in

require_once "../system/db.php";
require_once "../../lang/".$_SESSION['lang'].".php";

$regNumber = $_GET['regNumber'];
$notes = $_GET['notes'];

$query = "UPDATE ".$companies." SET comments='".$notes."' WHERE regNumber=".$regNumber;
if (!$Result= mysql_db_query($DBName, $query, $Link)) {
           	print "No database connection <br>".mysql_error();
        } else {
				print $LANG['notes_saved'];
		  }

} else { // user not logged in
?>
<script language="Javascript">
document.location = "../login.php";
</script>
<?php
} 
?>