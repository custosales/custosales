<?php 
// weekly sales

$query = "SELECT 
Day(orderDate) as Day, 
Month(orderDate) as Month, 
Week(orderDate) as Week, 
salesRepID,
sum(unitPrice) as Sales 
from Orders  
GROUP by orderDate 
ORDER by Month,Week,Day";

$Result = mysql_db_query($DBName, $query, $Link) or die(MySql_error());

$i=1;
$a = 0;


print "<br>";
print "<table width=100%>
<tr><th colspan=\"10\"><h1 class=\"ui-widget-header ui-corner-all\">".$LANG['sales_per_week']."</h1></th></tr>
<tr><td>";

while($Row=MySQL_fetch_array($Result)) {


$week[$i] = $Row['Week'];
//$month[$a] = $Row['Month'];

if($week[$i] != $week[$i-1]) {

if($i>1) { 
print "<tr style=\"font-weight:bold\"><td>".$LANG['sum']."</td><td>".$LANG['currency_symbol']." ".number_format($weekSales, 0, ',', ' ')."</td></tr>";
print "</table>"; 
$weekSales = 0;
}
if($a==6) { print "</td></tr><tr><td valign=\"top\">";   }
$a++;
?>	
<table summary="" class="ui-widget-content ui-corner-all" style="width:150px;float:left;margin-left:5px">
<tr><td colspan="3" class="ui-widget-header ui-corner-all" style="padding:1px;margin;1px;text-align:center"><b><?php print $LANG['week']." ".$week[$i];?></b></td></tr>
<tr><td><b><?php print $LANG['day'];?></b></td><td><b><?php print $LANG['sales'];?></b></td></tr>
<?php 
} ?>
<tr>
<td><?php print $Row['Day'].".".$Row['Month'];?></td>
<td><?php 
print $LANG['currency_symbol']." ".number_format($Row['Sales'], 0, ',', ' ');
$weekSales += $Row['Sales'];
?></td>
</tr>
	
<?php
//if($a>5) { $a=1; }
$i++;
if($a>6)	{ $a=1; }
} // end loop
print "<tr style=\"font-weight:bold\"><td>".$LANG['sum']."</td><td>".$LANG['currency_symbol']." ".number_format($weekSales, 0, ',', ' ')."</td></tr>";
print "</td></tr></table>";
print "</td></tr></table>";
print "<br \>";
?>
