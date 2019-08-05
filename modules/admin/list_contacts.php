<?php
session_start();
if(!isset($_SESSION['userID'])) {
header("Location: ../../index.php");
}
require_once("../system/db.php");
require_once("../../lang/".$_SESSION['lang'].".php");

$companyID = $_GET['companyID'];
$query = "SELECT contactID, contactName, contactMobilePhone, contactEmail from ".$contacts." WHERE contactCompanyID='".$companyID."' order by contactName"; 
$Result = mysql_db_query($DBName, $query, $Link) or die(MySql_error());
	
?>
<style type="text/css">
input.text { 
width:300px; 
} 
</style>
<tr><td style="vertical-align:top">
<table id="contacts" class="display" style="font-size:1em;">
<thead>
<tr>
<th>#</th>
<th><?php print $LANG['contactName'];?></th>
<th><?php print $LANG['mobile_phone'];?></th>
<th><?php print $LANG['email'];?></th>
</tr>
</thead>
<tbody>
<?php	
// display contacts with given type/category	

$i=1;

while($Row=MySQL_fetch_array($Result)) {
?>
<tr>
<td><?php print $i; ?></td>
<td><a href="#" onclick="editItem('Contacts', 'edit','<?php print $Row['contactID'];?>')" ><?php print htmlspecialchars($Row['contactName']);?></a></td>
<td><?php print $Row['contactMobilePhone']; ?></td>
<td><a href="mailto:<?php print $Row['contactEmail']; ?>"><?php print $Row['contactEmail']; ?></a></td>
</tr>
<?php 
$i++;
} ?>
</tbody>
</table>	

<br>
