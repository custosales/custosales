
<h1 class="ui-widget-header ui-corner-all" style="width:95%;padding:3px 3px 3px 10px;"><?php print $LANG['orders'];?></h1>

<table style="cell-spacing:0px;width:100%;">
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

try {
    $results = $pdo->query($querys);
} catch (PDOException $e) {
    echo "Data was not fetched, because: ".$e->getMessage();
}

foreach($results as $Rows) {

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
<iframe id="graphFrame" style="border:none;;width:450px;height:220px;" src="modules/orders/get_order_charts.php"></iframe>

</td>
</tr>		                        
</table>                       
