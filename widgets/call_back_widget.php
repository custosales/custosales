<?php			
session_start();
if (!isset($_SESSION['userID'])) { // check if user is logged in
    header("Location: ../index.php"); // if not go to login
}
require_once "../modules/system/db.php";  // get pdo connection settings
require_once "../lang/" . $_SESSION['lang'] . ".php"; // get language array

$projectID = $_SESSION['project'];
if($projectID=="all" || $projectID=="") {
$projectInclStr="";
} else {	
$projectInclStr = 	" AND ".$companies.".projectID = ".$projectID; 
}

// Get Callbacks

if(isset($_SESSION['admin']))  {  
// Check for admin rights
        $resultQuery = "SELECT regNumber, contactAgain, companyName   
	FROM ".$companies."  
	WHERE contactAgain != '0000-00-00' 
	".$projectInclStr."
	AND salesRepID=".$_SESSION['userID']." 
	ORDER BY contactAgain";
       

} else if(isset($_SESSION['supervisor']))  {  
// Check for supervisor rights
        $resultQuery = "SELECT regNumber, contactAgain, companyName   
	FROM ".$companies."  
	WHERE contactAgain != '0000-00-00' 
	".$projectInclStr."
	AND salesRepID=".$_SESSION['userID']." 
	ORDER BY contactAgain";
	
	

} else if(isset($_SESSION['salesModule']))  {  
// Get User's Callbacks

	$title = $LANG['call_back'];
	
	$resultQuery = "SELECT regNumber, contactAgain, companyName   
	FROM ".$companies."  
	WHERE contactAgain != '0000-00-00' 
	".$projectInclStr."
	AND salesRepID=".$_SESSION['userID']." 
	ORDER BY contactAgain";
	
	
} // End Callbacks 

try {
    $Result = $pdo->query($resultQuery);
} catch (PDOException $e) {
    echo "Data was not fetched, because: " . $e->getMessage();
}

?>
<html>
<head>

</head>
<body>
<table summary="" border="0" style="cell-spacing:0px;width:100%">
<tr>
<td><b><?php print $LANG['company_name']; ?></b></td>
<td><b><?php print $LANG['call_back']; ?></b></td>
<td><b><?php print $LANG['delete']; ?></b></td>

</tr>

	<?php
	foreach ($Result as $Row) { // List callbacks
	?>
<tr>
<td valign="top">
<?php
 
echo '<a href="javascript:document.location.href=\'show_companies.php?regNumber='.$Row['regNumber'].'\'">';

if($Row['companyName']=="") {
$companyName = " --- ";	
	} else {
$companyName =	$Row['companyName'];
}

echo $companyName;

echo '</a>';
?> 	
</td>
<td valign="top">
	<?php 
	if($Row['contactAgain']<=date('Y-m-d')) {
	print "<span style=\"color:red;\">";
	}	
	print $Row['contactAgain']; 
	if($Row['contactAgain']<=date('Y-m-d')) {
	print "</span>";
	}
	
	?> 	
</td>
<td>
<input type="checkbox" style="text-align:middle;margin:0" onclick="registerCallBack('<?php print $Row['regNumber'];?>','0000-00-00');">

</td>

</tr>
<?php } ?>
</table>
<div id="lastContacted" style="visibility:hidden" ></div>
</body>

</html>