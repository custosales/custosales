<?php
session_start();
if(!isset($_SESSION['userID'])) { // check if user is logged in
header("Location: ../../index.php");
}

require_once("../system/db.php");
require_once("../../lang/".$_SESSION['lang'].".php");

$userID = $_GET['userID'];

$query = "SELECT Type, Day(Stamp) as Day, Month(Stamp) as Month, Week(Stamp) as Week, Time(Stamp) as Time 
from Workhours WHERE userID=".$userID."   ORDER by Month,Week,Day,ID";

$Result = mysql_db_query($DBName, $query, $Link) or die(MySql_error());
?>



<?php
$i=1;
$a = 0;
print("<br>");
print "<table width=100%>
<tr><th colspan=\"10\"><h1 class=\"ui-widget-header\">".$LANG['my_timesheet']."</h1></th></tr>
<tr><td>";


while($Row=MySQL_fetch_array($Result)) {


$week[$i] = $Row['Week'];

if($week[$i] != $week[$i-1]) {

if($i>1) { 
print "<tr><td colspan=4><b>".$LANG['hours_this_week'].": ".$weektime."</b></td></tr>";
print "</table>"; 
$weektime=null;

}
if($a==4) { print "</td></tr><tr><td valign=\"top\">";   }
$a++;	
?>	
<table summary="" class="ui-widget-content ui-corner-all" style="float:left;margin-left:5px">
<tr><td colspan="4" class="ui-widget-header ui-corner-all" style="padding:1px;margin;1px;text-align:center"><b><?php print $s_week." ".$week[$i];?></b></td></tr>
<?php 
} ?>
<tr>
<td><?php print $Row['Day'].".".$Row['Month'];?></td>
<td><?php print $Row['Type'];?></td>
<td><?php print $Row['Time'];
if($Row['Type']=="In") {
$starttime=$Row['Time'];
} else {
$endtime = $Row['Time'];	
	}
?></td>
<td><?php 
if($Row['Type']=="Out") {
$daytime = $endtime-$starttime;
print $LANG['hours'].": ".$daytime;
$weektime += $daytime;
$starttime=null;
$endtime=null;
}
?></td>
</tr>


	
<?php
$i++;
if($a>4) { $a=1; }

} // end loop
print "<tr><td colspan=4><b>".$LANG['hours_this_week'].": ".$weektime."</b></td></tr>";
print "</td></tr></table>";

?>

