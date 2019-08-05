<?php
session_start();
if(!isset($_SESSION['userID'])) { // check if user is logged in
header("Location: ../index.php");
}


require_once "../system/db.php";
require_once "../../lang/".$_SESSION['lang'].".php";

$regNumber = trim($_GET['regNumber']);

if($_GET['orderID']!="") {
$orderID = $_GET['orderID'];
} else {
$orderID="";	
$formAction = "Insert";
}


if($orderID!="") { // GET Order Data

$formAction = "Update";

$query = "SELECT  
".$orders.".salesRepID as orderRepID, 
".$companies.".salesRepID as customerRepID,
".$companies.".companyName,
".$orders.".regNumber,
".$orders.".orderID,
".$orders.".orderStatusID,
".$orders.".unitPrice,
".$orders.".otherTerms,
".$orders.".creditDays,
".$orders.".customerContact, 
".$orders.".orderDate,
".$orders.".orderComments 
 
FROM ".$orders." JOIN ".$companies." ON ".$orders.".regNumber = ".$companies.".regNumber and ".$orders.".orderID=".$orderID;
if (!$Result= mysql_db_query($DBName, $query, $Link)) {
         print "No database connection <br>".mysql_error();
    } 
if(!$Row=MySQL_fetch_array($Result)) {
      print "No order found <br>".$query;
	}

if($Row['creditDays']=="") {
	$creditDays = "10";
	} else {
	$creditDays = $Row['creditDays'];
	}  

if($Row['customerContact']=="") {
		// Get company manager from company table		
		$queryc = "SELECT companyManager FROM ".$companies." WHERE regNumber=".$regNumber;
			if (!$Resultc= mysql_db_query($DBName, $queryc, $Link)) {
           print "No database connection <br>".mysql_error();
        	} else { 
        		$Rowc=MySQL_fetch_array($Resultc);
			}        
		
	$customerContact = $Rowc['companyManager'];
	
	} else {
	$customerContact = $Row['customerContact'];
		
	}


$orderDate = $Row['orderDate'];	
$orderComments = $Row['orderComments'];
$orderRepID = $Row['orderRepID'];

}
  
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
</head>

<body style="margin:0px">

<table class="ui-widget-content ui-corner-all" style="float:left;margin-right:5px;font-size:13px;height:270px;" align="left">
<form id="registerForm">
<input type="hidden" id="regNumber" name="regNumber" value="<?php print $Row['regNumber'];?>">
<input type="hidden" id="orderID" name="orderID" value="<?php print $orderID;?>">
<tr>
<td colspan="4" class="ui-widget-header ui-corner-all" style="text-align:center;font-size:16px" ><?php print strtoupper($LANG['order']); ?></td>
</tr>

<tr>
<td><?php print $LANG['order_status'];?>:</td>
<td>
<select id="statusID" name="orderStatusID" onchange="javaScript:convertOrderStatus('<?php print $Row['orderID'];?>',this.value)">
<?php

$selected="";
$querys = "SELECT * FROM ".$orderstatus." ORDER by orderStatusID";
if (!$Results= mysql_db_query($DBName, $querys, $Link)) {
           print "No database connection <br>".mysql_error();
        } 
while($Rows=MySQL_fetch_array($Results)) {
if($Rows['orderStatusID']==$Row['orderStatusID']) { 
$selected="selected";
} else {
$selected="";
}

?>
<option id="<?php print $Rows['orderStatusID'];?>" value="<?php print $Rows['orderStatusID'];?>"  <?php print $selected;?> ><?php print $Rows['orderStatusName'];?></option>
<?php } ?>
</select>

</td>
<td align="right">
<?php print $LANG['order_number'].": ";?>
</td>
<td>
<?php print $Row['orderID']; ?>

</td>
</tr>

<tr>
<td width="150"><b><?php print $LANG['customer']; ?></b>:</td>
<td>
<b><?php print $Row['companyName'] ?></b>
</td>
<td align="right">
<?php print $LANG['sales_rep'].": ";?>
</td>
<td>
<select name="salesRepID" onchange="javaScript:convertSalesRepID('<?php print $Row['orderID'];?>',this.value)">
<?php 

$queryu = "SELECT userID, fullName FROM ".$users." ORDER by fullName";
if (!$Resultu= mysql_db_query($DBName, $queryu, $Link)) {
           print "No database connection <br>".mysql_error();
        } 
        
while($Rowu=MySQL_fetch_array($Resultu)) { // list users
	
	if($Rowu['userID']==$orderRepID) { // select user that is sales rep for this order
	$sel="selected=\"true\"";
	} 
?>
<option value="<?php print $Rowu['userID']; ?>"  <?php print $sel; ?> ><?php print $Rowu['fullName']; ?></option>
<?php
$sel=""; 
} // end while loop 
?>
</select>


</td>

</tr>

<tr>
<td width="150"><?php print $LANG['product']; ?>:</td>
<td>
<select style="width:250px;" id="productID" name="productID" onchange="setPrice(this.options[this.selectedIndex].value)">
<?php

$selected="";
$querys = "SELECT * FROM ".$products." ORDER by productName desc";
if (!$Results= mysql_db_query($DBName, $querys, $Link)) {
           print "No database connection <br>".mysql_error();
        } 
while ($Rows=MySQL_fetch_array($Results)) { // list products 
	
if($Rows['productID']==$Row['productID']) { 
$selected="selected";
} else {
$selected="";
}
?>
<option id="<?php print $Rows['productID'];?>" value="<?php print $Rows['productID'];?>"  <?php print $selected;?> ><?php print $Rows['productName'];?></option>
<?php 
} 
?>
</select>
&nbsp;
</td>
<td align="right">
<?php print $LANG['order_date'].": ";?>
</td>
<td valign="top">
<input type="text" style="width:150px;" id="orderDate" name="orderDate" value="<?php print $orderDate; ?>" >
</td>
</tr>

<tr>
<td><?php print $LANG['negotiated_price'];?></td>
<td>
<input type="text" style="width:250px;" id="unitPrice" name="unitPrice"  value="<?php print $Row['unitPrice']; ?>"> <?php print $LANG['currency_symbol']; ?>
</td>
<td align="right">
<?php print $LANG['notes'].": ";?>
</td>
<td valign="top" rowspan="3">
<textarea style="width:250px;height:98px" id="orderComments" name="orderComments" >
<?php print $orderComments; ?>
</textarea>
</td>
</tr>

<tr>
<td><?php print $LANG['credit_days']; ?>:</td>
<td>
<input type="text" style="width:250px;" id="creditDays" name="creditDays"  value="<?php print $creditDays; ?>">
</td>
</tr>

<tr>
<td valign="top"><?php print $LANG['other_terms']; ?>:</td>
<td>
<textarea style="width:250px;height:50px" id="otherTerms" name="otherTerms" >
<?php print $Row['otherTerms']; ?>
</textarea>
</td>
</tr>

<tr>
<td><?php print $LANG['contact_person']; ?>:</td>
<td><input type="text" style="width:250px;" id="customerContact" name="customerContact"  value="<?php print htmlspecialchars($customerContact); ?>"></td>
<td></td>
<td valign="top">
<input type="image"  id="companyregisterOrderButton" src="images/save_22.png" title="<?php print $LANG['save'];?>" onclick="saveOrder()" style="float:left;border:none" onmouseover="document.body.style.cursor='pointer';" onmouseout="document.body.style.cursor='default';"  border="0" alt="" >
&nbsp;

</td>
</form>
</tr>

</table>

<table class="ui-widget-content ui-corner-all" style="float:left;font-size:13px;height:270px;width:350px">
<tr>
<td colspan="4" class="ui-widget-header ui-corner-all" style="height:24px;text-align:center;font-size:16px" ><?php print strtoupper($LANG['actions']); ?></td>
</tr>

<tr>
<td valign="top" align="center">
<br>
<input type="image" style="border:none" src="images/pdf_32.png" onclick="document.getElementById('iFrame').src='modules/orders/create_order_confirmation_pdf.php?outputForm=D&orderID=<?php print $orderID;?>';" title="<?php print $LANG['show_order_confirmation']; ?>">
<br>
<?php print $LANG['show_order_confirmation']; ?>
</td>

<td valign="top" align="center">
<br>
<input type="image" style="border:none" src="images/email_32.png" onclick="document.getElementById('list').innerHTML='';document.getElementById('iFrame').src='modules/orders/order_confirmation.php?orderID=<?php print $orderID;?>';" title="<?php print $LANG['send_order_confirmation']; ?>">
<br>
<?php print $LANG['send_order_confirmation']; ?>
</td>

</tr>


</body>
</html>