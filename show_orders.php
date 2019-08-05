<?php 
session_start();
if(!isset($_SESSION['userID'])) { // check if user is logged in
header("Location:login.php");
}
include_once("head.php");

$orderStatusID = $_GET['status'];
if($orderStatusID=="") { $orderStatusID="all"; } 
?>
<!DOCTYPE HTML>
<html>
<head>
<?php include_once("head.php"); ?>

<script language="javascript" type="text/javascript" src="lib/indexFunctions.js"></script> 
<script type="text/javascript" src="modules/orders/orderFunctions.js"></script>
</head>
<body style="font-size:12px" >
<script type="text/javascript" >
var price = new Array();
var productDescription = new Array();
</script>
 
<?php 
include_once("menu.php");

$querys = "SELECT * FROM ".$products." ORDER by productName desc";

try {
    $results = $pdo->query($querys);
} catch (PDOException $e) {
    echo "Data was not fetched, because: ".$e->getMessage();
}

foreach($results as $Rows) {
?>
<script type="text/javascript" >
price[<?php print $Rows['ID'];?>] = '<?php print $Rows['unitPrice']; ?>';
productDescription[<?php print $Rows['ID'];?>] = '<?php print $Rows['productDescription']; ?>';
</script>
<?php
}
?>
<div id="main_table">

<h1  class="ui-widget-header ui-corner-all" style="padding:3px;">&nbsp; <span id="heading"><?php print $heading1; ?></span> 
&nbsp; 
<input id="allButton" type="button" onclick="showOrders('<?php print $orderStatusID; ?>')" value="<?php print $LANG['show_all'];?>"> 

&nbsp; 
<select id="status" name="status" onchange="javaScript:showOrders(this.options[this.selectedIndex].value)">
<option value="all"><?php print $LANG['show_all']; ?></option>
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
&nbsp;
</h1>


<div id="list"></div>

<iframe src="" id="iFrame" style="border:0;width:95%;height:450px;float:left;"></iframe>

<div id="data" style="width:100%"></div></div>




<script type="text/javascript">
	
showOrders('<?php print $orderStatusID; ?>'); // display orders at page load 
</script>

</body>
</html>
