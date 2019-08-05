<?php
session_start();
if(!isset($_SESSION['userID'])) { // check if user is logged in
header("Location: ../../index.php");
}

require_once "../system/db.php";
include_once "../../lang/".$_SESSION['lang'].".php";

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<script type="text/javascript" src="orderFunctions.js"></script>
		<script type="text/javascript" src="../../lib/jquery/js/jquery-ui-1.8.5.custom.min.js"></script>
	<script type="text/javascript" src="../../lib/jquery/development-bundle/ui/jquery.ui.core.js"></script>
<script type="text/javascript" src="../../lib/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
	<link rel="stylesheet" href="../../lib/jquery/development-bundle/themes/<?php print $_SESSION['style'] ?>/jquery.ui.all.css">
	<link rel="stylesheet" href="../../lib/jquery/jquery.alerts.css">
	<link href="../../css/styles.css" type="text/css" rel="stylesheet">
	
	<script type="text/javascript">
	function loadTiny() {
	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		theme_advanced_toolbar_location : "top",
	
		});
		}
		</script>
<title></title>
</head>
<body>
<script type="text/javascript" >
var template = new Array();
</script>
<?php
$orderID = $_GET['orderID'];
 
$query = "SELECT * FROM ".$orders." JOIN ".$companies." ON ".$orders.".regNumber = ".$companies.".regNumber and ".$orders.".orderID=".$orderID;
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
		$queryc = "SELECT companyManager FROM ".$companies." WHERE regNumber=".$Row['regNumber'];
			if (!$Resultc= mysql_db_query($DBName, $queryc, $Link)) {
           print "No database connection <br>".mysql_error();
        	} else { 
        		$Rowc=MySQL_fetch_array($Resultc);
			}        
		
	$customerContact = $Rowc['companyManager'];
	
	} else {
	$customerContact = $Row['customerContact'];
		
	}


$querya = "SELECT companyEmail,companyPostAddress FROM ".$companies." WHERE regNumber=".$Row['regNumber'];
			if (!$Resulta= mysql_db_query($DBName, $querya, $Link)) {
           print "No database connection <br>".mysql_error();
        	} else { 
        		$Rowa=MySQL_fetch_array($Resulta);
			}        
		

$orderDate = $Row['orderDate'];	
$orderComments = $Row['orderComments'];
$companyEmail = $Rowa['companyEmail'];
$salesRepID = $Row['salesRepID'];

// Get templates
$queryt = "SELECT * FROM ".$templates;
if (!$Resultt= mysql_db_query($DBName, $queryt, $Link)) {
           print "No database connection <br>".mysql_error();
        } 
while ($Rowt=MySQL_fetch_array($Resultt)) { // list products 
$content = str_replace("%avsender%", $_SESSION['fullName'], $Rowt['templateContent']); 
$content = str_replace(utf8_decode("%år%"), date("Y"), $content); 
$content = str_replace("%mottaker%", $customerContact, $content); 
$content = str_replace("%kontaktdato%",  substr($orderDate,8,2).".".substr($orderDate,5,2).".".substr($orderDate,0,4), $content); 
?>
<script type="text/javascript" >
template[<?php print $Rowt['templateID'];?>] = "<?php print $content; ?>";
</script>
<?php 
} // end get templates



?>

<script type="text/javascript" >
function setTemplate(templateID) {
document.getElementById("confirmationMail").value = template[templateID];
loadTiny();
}
</script>



<h1 class="ui-widget-header ui-corner-all" style="padding: 2px 15px;font-size:18px;font-family:arial, sans"><?php print $LANG['order_confirmation'];?></h1>
<table summary="" class="ui-widget-content ui-corner-all" style="float:left; margin-right:5px;font-family:arial,sans; font-size:13px;padding:2px" >
<tr>
<td colspan="2" style="text-align:center;">
<table class="ui-widget-header ui-corner-all" style="width:100%;font-weight:normal">
<tr><td>
<input type="image" style="border:none" src="../../images/edit_22.png" onclick="document.location='../sales/register_sale.php?orderID=<?php print $orderID;?>';" alt="<?php print $LANG['edit_order']; ?>" title="<?php print $LANG['edit_order']; ?>">
<br>
<?php print $LANG['edit_order']; ?>
</td>
<td>
<input type="image" style="border:none" src="../../images/pdf_22.png" onclick="document.location='create_order_confirmation_pdf.php?outputForm=D&orderID=<?php print $orderID;?>';" alt="<?php print $LANG['show_order_confirmation']; ?>" title="<?php print $LANG['show_order_confirmation']; ?>">
<br>
<?php print $LANG['show_order_confirmation']; ?>
</td></tr>
</table>
</td>
</tr>

<tr>
<td colspan="2" class="ui-widget-header ui-corner-all" style="width:100%;text-align:center;">
<?php print $LANG['send_order_confirmation']; ?>
</td>
</tr>

<tr>
<td style="width:70px">
<?php print $LANG['send_from'].": ";?> 
</td>
<td>
<form name="orderConfirmationForm" method="post" action="send_order_confirmation.php">
<select name="sender" id="sender" name="sender">
<option id="companyEmail" value="<?php print $_SESSION['companyEmail']; ?>"><?php print $_SESSION['companyEmail']; ?></option>
<?php 

$selected="";
$queryu = "SELECT userID, fullName, userEmail FROM ".$users." WHERE active=true";
if (!$Resultu= mysql_db_query($DBName, $queryu, $Link)) {
           print "No database connection <br>".mysql_error();
        } 
while ($Rowu=MySQL_fetch_array($Resultu)) { // list users
	
if($Rowu['userID']==$salesRepID) { 
$selected="selected";
} else {
$selected="";
}
?>
<option id="<?php print $Rowu['userID'];?>" value="<?php print $Rowu['userID'];?>"  <?php print $selected; ?> ><?php print $Rowu['fullName'];?></option>
<?php 
} 
?>
</select>

</td>
</tr>


<tr>
<td>
<?php print $LANG['send_to'].": ";?> 
</td>
<td>
<input style="width:250px;" name="recipient" id="recipient" type="text" value="<?php print $customerContact; ?>">
</td>
</tr>

<tr>
<td>
<?php print $LANG['email'].": ";?> 
</td>
<td>
<input style="width:250px;" name="recipientEmail" id="recipientEmail" type="text" value="<?php print $companyEmail; ?>">
</td>
</tr>


<tr>
<td>

</td>
<td>
<input type="button" value="<?php print $LANG['send_order_confirmation'];?> " onclick="JavaScript:sendOrderConfirmation();">
</td>
</tr>

</table>


<table summary="" class="ui-widget-content ui-corner-all" style="font-family:arial,sans; font-size:13px;padding:2px" >
<tr>
<td>


<select onchange="setTemplate(this.options[this.selectedIndex].value)">
<option value=""><?php print $LANG['select_template']." ";?></option>
<?php

$queryt = "SELECT * FROM ".$templates;
			if (!$Resultt= mysql_db_query($DBName, $queryt, $Link)) {
           print "No database connection <br>".mysql_error();
        	} else { 
        	
        		while($Rowt=MySQL_fetch_array($Resultt)) {  // get templates
			
				print "<option value=\"".$Rowt['templateID']."\">".$Rowt['templateType']."</otion>";			
			
				} // end get templates
			}        		

?>


</select>


</td>
</tr>
<tr>
<td>
<textarea name="confirmationMail" id="confirmationMail" style="width:700px;height:300px">

</textarea>
</form>
</td>
</tr>


</table>

</body>
</html>