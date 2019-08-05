<table summary="" style="border:0px;cell-spacing:0px;width:950px;">
<tr>
<td valign="top"> 

<h1><?php print $LANG['order_processing'];?></h1>
<?php
include_once "order_list.php";
?>

</td>
<td width="10">&nbsp;</td>
<td  valign="top">

<?php
include_once "order_overview.php";
?>
	
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
