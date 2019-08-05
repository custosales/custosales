<?php
session_start();
if(!isset($_SESSION['userID'])) {
header("Location: ../../index.php");
}
require_once("../system/db.php");
require_once("../../lang/".$_SESSION['lang'].".php");

$query = "SELECT * from ".$departments." order by departmentName"; 
$Result = mysql_db_query($DBName, $query, $Link) or die(MySql_error());
$i=1;
?>
<style type="text/css">
input.text { 
width:300px; 
} 
</style>
<table style="width:900px;margin-top:4px">
<tr><td style="vertical-align:top">
<table style="width:400px;margin-right:5px;;font-size:13px">
<tr><th colspan="5"><h1 style="width:100%" class="ui-widget-header ui-corner-all"><?php print $LANG['departments']; ?></h1></th></tr>

<?php
while($Row=MySQL_fetch_array($Result)) {

?>
<tr >
<td># <?php print $i; ?></td>
<td><a href="#" onclick="editItem('Departments','edit','<?php print $Row['departmentID'];?>')" ><?php print htmlspecialchars($Row['departmentName']);?></a></td>
<td width="20"><img src="images/edit_16.png" title="<?php print $LANG['edit_department'];?>" onclick="editItem('Departments', 'edit','<?php print $Row['departmentID'];?>')" alt="" > </td>
<td width="20"><img src="images/cancel_16.png" title="<?php print $LANG['delete_department'];?>" onclick="deleteItem('Departments', '<?php print $Row['departmentID'];?>','<?php print $LANG['confirm_delete'].": ".$Row['departmentName']."?";?>','<?php print $LANG['delete_department'];?>')" alt="" > </td>
</tr>

<?php 
$i++;
} ?>
</table>	

</td>
<td style="width:500px;vertical-align:top">

<table style="width:500px;font-size:13px">
<tr><th><h1 style="width:100%" class="ui-widget-header ui-corner-all"><span id="actionHeader"><?php print $LANG['actions']; ?></span></h1></th></tr>
<tr>
<td style="text-align:center">
<div id="actionArea" style="text-align:center;">
<table style="text-align:center;width:70%;font-size:13px">
<tr>

<td>
<img src="images/departments_32.png" onclick="editItem('Departments','add','')" alt="<?php print $LANG['add_department']; ?>" >
<br>
<?php print $LANG['add_department']; ?>
</td>

</tr>
</table>
</div>
</td>

</tr>
</table>

</td></tr>
</table>

<br>
