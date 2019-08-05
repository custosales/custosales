<h1><?php print $LANG['order_overview'];?></h1> 
<table summary="" class="ui-widget-content ui-corner-all" width="230" >
<tr>
<td><img src="images/spreadsheet_file_22.png" alt="" ></td>
<td><?php print $LANG['total'];?></td>
</tr>
<tr>
<td><?php print $LANG['order_value_total'];?>:</td>
<td>
<?php
$queryn = "SELECT sum(unitPrice) as orderValue FROM ".$orders;
if (!$Resultn= mysql_db_query($DBName, $queryn, $Link)) {
           print "No database connection <br>".mysql_error();
        } 
$orderValue = mysql_fetch_row($Resultn);
print $s_currency_symbol." ".number_format($orderValue[0], 0, ',', ' '); 
?>
</td>
</tr>

<tr>
<td><?php print $LANG['order_value_paid'];?>:</td>
<td>
<?php
$queryn = "SELECT sum(unitPrice) as orderValue FROM ".$orders." WHERE orderStatusID = '7'";
if (!$Resultn= mysql_db_query($DBName, $queryn, $Link)) {
           print "No database connection <br>".mysql_error();
        } 
$orderValue = mysql_fetch_row($Resultn);
print $s_currency_symbol." ".number_format($orderValue[0], 0, ',', ' '); 
?>
</td>
</tr>

<tr>
<td><?php print $LANG['order_value_outstanding'];?>:</td>
<td>
<?php
$queryn = "SELECT sum(unitPrice) as orderValue FROM ".$orders." WHERE orderStatusID != '7'";
if (!$Resultn= mysql_db_query($DBName, $queryn, $Link)) {
           print "No database connection <br>".mysql_error();
        } 
$orderValue = mysql_fetch_row($Resultn);
print $s_currency_symbol." ".number_format($orderValue[0], 0, ',', ' '); 
?>
</td>
</tr>

</table>	

<br>
<table summary="" class="ui-widget-content ui-corner-all" width="230" >
<tr>
<?php
$queryn = "SELECT sum(unitPrice) as orderValue FROM ".$orders." WHERE orderDate=DATE(NOW())";
if (!$Resultn= mysql_db_query($DBName, $queryn, $Link)) {
           print "No database connection <br>".mysql_error();
        } 
$orderValue = mysql_fetch_row($Resultn);


if($orderValue[0] > 0 && $orderValue[0] < 10000) {
	$iconfile="emotes_22/face-cool.png";
	} else if($orderValue[0] > 10000) {
	$iconfile="emotes_22/face-smile-big.png";
	} else {
	$iconfile="spreadsheet_file_22.png";
	}
?>
<td><img src="images/<?php print $iconfile;?>" alt="" ></td>
<td><?php print $LANG['order_value_total'];?></td>
</tr>
<tr>
<td><?php print $LANG['today'];?>:</td>
<td>
<?php
print $s_currency_symbol." ".number_format($orderValue[0], 0, ',', ' '); 
?>
</td>
</tr>

<tr>
<td><?php print $LANG['this_week'];?>:</td>
<td>
<?php
$queryn = "SELECT sum(unitPrice) as orderValue FROM ".$orders." WHERE WEEK(orderDate)=WEEK(NOW()) && YEAR(orderDate)=YEAR(NOW())";
if (!$Resultn= mysql_db_query($DBName, $queryn, $Link)) {
           print "No database connection <br>".mysql_error();
        } 
$orderValue = mysql_fetch_row($Resultn);
print $s_currency_symbol." ".number_format($orderValue[0], 0, ',', ' '); 
?>
</td>
</tr>

<tr>
<td><?php print $LANG['this_month'];?>:</td>
<td>
<?php
$queryn = "SELECT sum(unitPrice) as orderValue FROM ".$orders." WHERE MONTH(orderDate)=MONTH(NOW()) && YEAR(orderDate)=YEAR(NOW()) ";
if (!$Resultn= mysql_db_query($DBName, $queryn, $Link)) {
           print "No database connection <br>".mysql_error();
        } 
$orderValue = mysql_fetch_row($Resultn);
print $s_currency_symbol." ".number_format($orderValue[0], 0, ',', ' '); 
?>
</td>
</tr>

<tr>
<td><?php print $LANG['this_year'];?>:</td>
<td>
<?php
$queryn = "SELECT sum(unitPrice) as orderValue FROM ".$orders." WHERE YEAR(orderDate)=YEAR(NOW())";
if (!$Resultn= mysql_db_query($DBName, $queryn, $Link)) {
           print "No database connection <br>".mysql_error();
        } 
$orderValue = mysql_fetch_row($Resultn);
print $s_currency_symbol." ".number_format($orderValue[0], 0, ',', ' '); 
?>
</td>
</tr>

</table>	
