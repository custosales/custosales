<?php
require_once "../system/db.php";

$listName = $_POST['listName'];
$ownerID = $_POST['ownerID'];
$comments = $_POST['comments'];
$place = $_POST['place'];
$branch = $_POST['branch'];


if($_GET['listID']!="") {  //Update list table

$query = "UPDATE ".$companies." SET 
listName = '".$listName."',
ownerID = '".$ownerID."',
place = '".$place."',
branch = '".$branch."',
comments = '".$comments."',
WHERE listID = ".$_GET['listID']."
";
	
	} else { // Create new record in list table

$query = "INSERT INTO ".$_SESSION['userCallingLists']." SET 
listName = '".$listName."',
ownerID = '".$ownerID."',
place = '".$place."',
branch = '".$branch."',
comments = '".$comments."',
dateCreated = NOW()
";
}

 if (!$Result= mysql_db_query($DBName, $query, $Link)) {
           print "List not saved <br>".mysql_error();
        } else {
           print  "List saved";
        }

$listID = mysql_insert_id($Link);

for($a=1; $a<=count($_POST['regNumber']); $a++ ) {
$query = "INSERT INTO ".$callinglistcompanies." SET 
listID = '".$listID."',
regNumber = '".$_POST['regNumber'][$a]."',
companyName = '".$_POST['companyName'][$a]."',
ownerID = '".$ownerID."',
dateCreated = NOW()
";

$Result= mysql_db_query($DBName, $query, $Link);

}

?>
<script type="text/javascript" >
document.location="../calling_list.php";
</script>