<?php
session_start();
if(!isset($_SESSION['userID'])) {
header("Location: ../login.php; Window-target: top");
}
require_once("db.php");
require_once("../../lang/".$_SESSION['lang'].".php");

$i=1;
?>
<br>
<style type="text/css">
input { 
width:300px; 
} 
</style>
<table style="border-spacing:5px">
<tr><td style="width:300px;vertical-align:top;text-align:center">

<h1 style="width:100%" class="ui-widget-header ui-corner-all"><?php print $LANG['profile_image']; ?></h1>


<?php 
// Check if userphoto is present
$dir    = "../../documents/users/".$_SESSION['userID']."/userphoto/thumbnails/";
$files = scandir($dir);
$userPhoto = $files[2]; // select the first file after . and .. 
if(is_file($dir.$userPhoto)) {
?>
<img src="documents/users/<?php print $_SESSION['userID']; ?>/userphoto/thumbnails/<?php print $userPhoto; ?>" alt="" style="border: solid 6px #CCCCCC;border-radius:7px" onclick="editUserPhoto('<?php print $_SESSION['userID']; ?>')" >
<?php 
} else {
?>	
<img src="images/userphoto.png" alt="" style="border: solid 6px #CCCCCC;border-radius:7px" onclick="editUserPhoto('<?php print $_SESSION['userID']; ?>')" >
<?php 
} // end photo present
print "<br><br>";
print $LANG['edit_profile_image'];
?>
<br><br>

<h1 style="width:100%" class="ui-widget-header ui-corner-all"><?php print $LANG['documents']; ?></h1>

<a href="#" onclick="JavaScript:showUserDocuments('<?php print $_SESSION['userID']; ?>')" style="text-decoration:none">
<img src="images/folder_32.png" style="vertical-align:middle" alt="" ><br>
<?php print $LANG['my_documents'];?></a>

</td>
<td style="width:550px;vertical-align:top;">
<h1 style="width:100%;text-align:center;" class="ui-widget-header ui-corner-all"><?php print $_SESSION['fullName']; ?></h1>

<?php // Profile area
$query = "SELECT *  FROM ".$users." WHERE userID=".$_SESSION['userID'];

try {
    $result = $pdo->query($query);
    $Row = $result->fetch();
    
} catch (PDOException $e) {
    echo "Data was not fetched, because: " . $e->getMessage();
}

?>
<table summary="User profile" style="margin-left:80px;font-weight:normal;width:400px" class="ui-widget-header ui-corner-all" >
<tr><td style="text-align:right"><?php print $LANG['userName'].": "; ?></td><td><?php print $Row['userName']; ?></td></tr>
<tr><td style="text-align:right"><?php print $LANG['jobTitle'].": "; ?></td><td><?php print $Row['jobTitle']; ?></td></tr>
<tr><td style="text-align:right"><?php print $LANG['departmentID'].": "; ?></td><td><?php 

$queryD = "SELECT departmentName  FROM ".$departments." WHERE departmentID=".$Row['departmentID'];
try {
    $resultD = $pdo->query($queryD);
    $Rowd = $resultD->fetch();
} catch (PDOException $e) {
    echo "Data was not fetched, because: " . $e->getMessage();
}
if($RowD['departmentName'] ) {

    
    print $RowD['departmentName']; 
	} else { 	
	print $LANG['nobody'];
	}
?></td></tr>

<tr><td style="text-align:right"><?php print $LANG['supervisorID'].": "; ?></td><td><?php 

$queryS = "SELECT fullName  FROM ".$users." WHERE userID=".$Row['supervisorID'];
try {
    $resultS = $pdo->query($queryS);
    $RowS = $resultS->fetch();
} catch (PDOException $e) {
    echo "Supervisor Data was not fetched, because: " . $e->getMessage();
}
if($RowS['fullName']) {
    print $RowS['fullName']; 
	} else { 	
	print $LANG['nobody'];
	}
?></td></tr>

<tr><td style="text-align:right"><?php print $LANG['startDate'].": "; ?></td><td><?php print $Row['startDate']; ?></td></tr>

</table>

<table summary="User profile" style="margin-left:80px;width:400px" >
<tr><th colspan="2"><?php print $LANG['contact_data']; ?></th></tr>
<form name="profileForm">
<tr><td style="text-align:right"><?php print $LANG['fullName'].": "; ?></td><td>
<input type="text" id="fullName" value="<?php print $Row['fullName']; ?>"></td></tr>
<tr><td style="text-align:right"><?php print $LANG['email'].": "; ?></td><td>
<input type="text" id="userEmail" value="<?php print $Row['userEmail']; ?>"></td></tr>
<tr><td style="text-align:right"><?php print $LANG['address'].": "; ?></td><td>
<input type="text"id="address" value="<?php print $Row['address']; ?>"></td></tr>
<tr><td style="text-align:right"><?php print $LANG['zipCode'].": "; ?></td><td>
<input type="text" id="zipCode" value="<?php print $Row['zipCode']; ?>"></td></tr>
<tr><td style="text-align:right"><?php print $LANG['city'].": "; ?></td><td>
<input type="text" id="city" value="<?php print $Row['city']; ?>"></td></tr>
<tr><td style="text-align:right"><?php print $LANG['phone'].": "; ?></td><td>
<input type="text" id="phone" value="<?php print $Row['phone']; ?>"></td></tr>
<tr><td style="text-align:right"><?php print $LANG['mobilePhone'].": "; ?></td><td>
<input type="text" id="mobilePhone" value="<?php print $Row['mobilePhone']; ?>"></td></tr>

<tr>
<td></td>
<td><input type="button" onclick="saveUserProfile()" style="width:100px;" value="<?php print $LANG['save'];?>"></td>
</form>
</tr>
</table>

</td></tr>
</table>

<br>
