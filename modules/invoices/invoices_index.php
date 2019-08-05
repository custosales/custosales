<table summary="" style="border:0px;cell-spacing:0px;width:950px;">
<tr>
<td valign="top"> 
	<h1><?php print $LANG['order_processing'];?></h1>
<?php
$querys = "SELECT * FROM ".$orderstatus." ORDER by orderStatusID";
if (!$Results= mysql_db_query($DBName, $querys, $Link)) {
           print "No database connection <br>".mysql_error();
        } 
while($Rows=MySQL_fetch_array($Results)) {         

$queryn = mysql_query("SELECT orderID from ".$orders." WHERE orderStatusID=".$Rows['orderStatusID']);
$number = mysql_num_rows($queryn); 
         
echo'&nbsp;<a href="show_orders.php?status='.$Rows['orderStatusID'].'"><img src="images/folder_blue_22.png" style="border:0px;vertical-align:middle;" alt="" /></a>&nbsp;<a href="show_orders.php?status='.$Rows['orderStatusID'].'">'.$Rows['orderStatusName'].'</a> <span style="color:#777777">('.$number.')</span><br>';

}
?>

</td>
<td width="10">&nbsp;</td>
<td  valign="top">

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

	
	
</td>

<td valign="top">
<h1><?php print $LANG['graph_overview'];?> &nbsp;
<select style="font-size:13px;" onchange="show(this.value)">
<option value=""><?php print $LANG['show'];?></option>
<option value="0"><?php print $LANG['cash_flow'];?></option> >
<?php

$selected="";
$querys = "SELECT * FROM ".$orderstatus." ORDER by orderStatusID";
if (!$Results= mysql_db_query($DBName, $querys, $Link)) {
           print "No database connection <br>".mysql_error();
        } 
while($Rows=MySQL_fetch_array($Results)) {
if($Rows['orderStatusName']==$Row['orderStatus']) { 
$selected="selected";
} else {
$selected="";
}


?>
<option id="<?php print $Rows['orderStatusID'];?>" value="<?php print $Rows['orderStatusID'];?>"  <?php print $selected;?> ><?php print $LANG['show']." ".$Rows['orderStatusName'];?></option>
<?php } ?>

</select>
</h1>
<iframe id="graphFrame" style="width:450px;height:300px;border:none" src=""></iframe>

</td>
</tr>		                        
</table>                       
