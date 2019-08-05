<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta charset="utf-8" />
<title></title>
<script language="javascript" type="text/javascript" src="lib/indexFunctions.js"></script> 
</head>
<?php 
include_once "menu.php";
?>
<script class="code" type="text/javascript">
var addProduct = "<?php print $LANG['addProduct'];  ?>"
var editProduct = "<?php print $LANG['editProduct'];  ?>"

var addUser = "<?php print $LANG['add_user'];  ?>"
var editUser = "<?php print $LANG['edit_user'];  ?>"

var addRole = "<?php print $LANG['add_role'];  ?>"
var editRole = "<?php print $LANG['edit_role'];  ?>"

var addCurrencie = "<?php print $LANG['add_currency'];  ?>"
var editCurrencie = "<?php print $LANG['edit_currency'];  ?>"

var addContract = "<?php print $LANG['add_contract'];  ?>"
var editContract = "<?php print $LANG['edit_contract'];  ?>"

var addOrderStatu = "<?php print $LANG['add_order_status'];  ?>"
var editOrderStatu = "<?php print $LANG['edit_order_status'];  ?>"

var addWorkplace = "<?php print $LANG['add_workplace'];  ?>"
var editWorkplace = "<?php print $LANG['edit_workplace'];  ?>"

var addDepartment = "<?php print $LANG['add_department'];  ?>"
var editDepartment = "<?php print $LANG['edit_department'];  ?>"

var dataSaved = "<?php print $LANG['data_saved'];  ?>"
</script> 

<body style="font-size:12px">
<div id="main_table">
<h1 class="ui-widget-header ui-corner-all" style="padding:3px 3px 3px 10px;"><span id="heading"><?php print $LANG['order_system']; ?></span></h1>

<?php 
if(isset($_SESSION['orderModule'])) {
?>
<div  style="float:left;width:94.5%;padding:4px" class="ui-widget-content ui-corner-all">

<table style="float:left;width:180px;font-weight:normal;font-size:1em;margin-right:15px;padding;0px">
<tr>
<td colspan="2" class="ui-widget-header ui-corner-all">
<h2 style="text-align:center;padding:0;margin:0"><?php print $LANG['order_processing'] ?></h2></td>
</tr>
<tr>
<td style="text-align:left;">
<?php
include_once "modules/orders/order_list.php";
?>
</td> 
</tr>
</table>		                

<table style="width:250px;font-weight:normal;font-size:1em;margin-bottom:0px;padding;0px" class="ui-widget-content ui-corner-all">
<td style="text-align:left;">
<?php
include_once "modules/orders/order_overview.php";
?>
</td> 
</tr>
</table>		                
</div>






<div id="adminArea" style="width:100%;"></div>

</div>



<script type="text/javascript">


	$(function() {
		$( "#datepicker" ).datepicker();
	});


</script>

<?php 
} 
?>		

</body>
</html>

