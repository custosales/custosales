<?php
session_start();
if(!isset($_SESSION['userID'])) {
header("Location: ../../index.php");
}
require_once("../system/db.php");
require_once("../../lang/".$_SESSION['lang'].".php");


$query = "SELECT * from ".$preferences.""; 
try {
    $result = $pdo->query($query);
    $Row = $result->fetch();
    
} catch (PDOException $e) {
    echo "Data was not fetched, because: " . $e->getMessage();
}

?>
<style type="text/css">
input { 
width:300px;
font-size:13px; 
}

select {
font-size:13px;	
}	 
</style>
<form name="prefForm">
<table style="width:600px;margin-top:4px;font-size:13px">
<tr><th colspan="2"><h1 class="ui-widget-header ui-corner-all"><?php print $LANG['preferences']; ?></h1></th></tr>
<tr>
<td><b><?php print $LANG['company_name'];?>:</b></td>
<td><input type="text" id="companyName" value="<?php print htmlspecialchars($Row['companyName']);?>"></td>
</tr>
<tr>
<td><b><?php print $LANG['org_number'];?>:</b></td>
<td><input type="text" id="companyRegNumber" value="<?php print $Row['companyRegNumber'];?>"></td>
</tr>

<tr>
<td><b><?php print $LANG['company_address'];?>:</b></td>
<td><input type="text" id="companyAddress" value="<?php print htmlspecialchars($Row['companyAddress']);?>"></td>
</tr>

<tr>
<td><b><?php print $LANG['contact_zipcode'];?>:</b></td>
<td><input type="text" id="companyZip" value="<?php print $Row['companyZip'];?>"></td>
</tr>

<tr>
<td><b><?php print $LANG['contact_city'];?>:</b></td>
<td><input type="text" id="companyCity" value="<?php print $Row['companyCity'];?>"></td>
</tr>

<tr>
<td><b><?php print $LANG['phone'];?>:</b></td>
<td><input type="text" id="companyPhone" value="<?php print $Row['companyPhone'];?>"></td>
</tr>

<tr>
<td><b><?php print $LANG['fax'];?>:</b></td>
<td><input type="text" id="companyFax" value="<?php print $Row['companyFax'];?>"></td>
</tr>

<tr>
<td><b><?php print $LANG['companyChatDomain'];?>:</b></td>
<td><input type="text" id="companyChatDomain" value="<?php print $Row['companyChatDomain'];?>"></td>
</tr>


<tr>
<td><b><?php print $LANG['email'];?>:</b></td>
<td><input type="text" id="companyEmail" value="<?php print $Row['companyEmail'];?>"></td>
</tr>

<tr>
<td><b><?php print $LANG['internet'];?>:</b></td>
<td><input type="text" id="companyInternet" value="<?php print $Row['companyInternet'];?>"></td>
</tr>

<tr>
<td><b><?php print $LANG['default_currency'];?>:</b></td>
<td><input type="text" id="defaultCurrency" value="<?php print htmlspecialchars($Row['defaultCurrency']);?>"></td>
</tr>

<tr>
<td><b><?php print $LANG['default_credit_days'];?>:</b></td>
<td><input type="text" id="defaultCreditDays" value="<?php print $Row['defaultCreditDays'];?>"></td>
</tr>

<tr>
<td><b><?php print $LANG['bank_account'];?>:</b></td>
<td><input type="text" id="companyBankAccount" value="<?php print $Row['companyBankAccount'];?>"></td>
</tr>

<tr>
<td><b><?php print $LANG['company_manager'];?>:</b></td>
<td>
<select id="companyManagerID">
<?php
$idquery = "Select userID, fullName FROM ".$users."";
try {
    $resultID = $pdo->query($idquery);
} catch (PDOException $e) {
    echo "Data was not fetched, because: " . $e->getMessage();
}
foreach($resultID as $RowID) {

    if($Row['companyManagerID'] == $RowID['userID']) { 
	$selected = "selected";
	} else {
	$selected = "";
		}
print "<option value=\"".$RowID['userID']."\" ".$selected."  >".$RowID['fullName']."</option>";
}
?>
</select>
</td>
</tr>

<tr><td></td><td><input style="ui-button" type="button" onclick="savePreferences()" value="<?php print $LANG['save']; ?>"> </td></tr>

</table>	
</form>
<br>
