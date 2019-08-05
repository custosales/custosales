<table style="width:100%;font-weight:normal" class="ui-widget-header ui-corner-all" >
<tr>
<td style="text-align:center;width:100px">
<a href="#" onclick="JavaScript:showProfile('<?php print $_SESSION['userID']; ?>')" style="text-decoration:none">
<img src="images/user_list_32.png" style="vertical-align:middle" alt="" ><br>
<?php print $LANG['my_profile'];?></a>
</td>                           

<?php 
if(isset($_SESSION['admin'])) {
?>
<td style="text-align:center;width:100px">
<a href="#" onclick="document.location='admin_main.php'" style="text-decoration:none">
<img src="images/admin_32.png" style="vertical-align:middle" alt="" ><br> 
<?php print $LANG['administration'];?></a>
</td><?php
} 
?>	
<td>
&nbsp;
</td>

</tr>
</table>		                


<div id="adminArea"></div>

