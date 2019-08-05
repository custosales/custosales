<?php 
session_start();
if(!isset($_SESSION['userID'])) { // check if user is logged in
header("Location: ../../index.php");
}
require_once "../system/db.php";
require_once "../../lang/".$_SESSION['lang'].".php";


$reidrect = "";
$companyStatus = $_GET['companyStatus'];

$projectID = $_SESSION['project'];

if($projectID=="" || $projectID=="all" || $projectID==0 ) {
// Get companies from all projects
$projectIncStr = "";
// Get companies from selected project
} else {	 
$projectIncStr = "AND projectID = ".$projectID.""; 
}

if(isset($_SESSION['admin']) ) {   // check for admin rights	

	if($companyStatus==$LANG['customer']) {
	// get customers
	$query = "SELECT DISTINCT ID, ".$companies.".regNumber, companyName, companyManager, companyPhone, companyMobilePhone, 
	companyEmail, companyCity, companyCounty, branchCode, branchText, lastContacted, comments, callingListTable, 
	".$companies.".regDate, ".$companies.".salesRepID, ".$users.".fullName 
	FROM ".$companies.", ".$users.", ".$orders." 
	WHERE ".$orders.".regNumber=".$companies.".regNumber 
	".$projectIncStr."  
	AND ".$orders.".salesRepID=".$users.".userID
	ORDER by regDate DESC"; 
	
	} else { 
	// Get non customers 
	$query = "SELECT ID, ".$companies.".regNumber, companyName, companyManager, companyPhone, companyMobilePhone, 
	companyEmail, companyCity, companyCounty, branchCode, branchText, lastContacted, comments, callingListTable, 
	".$companies.".regDate, ".$companies.".salesRepID, ".$users.".fullName 
	FROM ".$companies.", ".$users." 
	WHERE companyStatus='".$companyStatus."' 
	".$projectIncStr."  
	AND regNumber not in (SELECT regNumber FROM ".$orders.") AND ".$companies.".salesRepID=".$users.".userID 
	ORDER by regDate DESC"; 
	}


} else if(isset($_SESSION['supervisor']) ) {   // check for supervisor rights	

	if($companyStatus==$LANG['customer']) {
	// get customers
	$query = "SELECT DISTINCT ID, regNumber, companyName, companyManager, companyPhone, companyMobilePhone, 
	companyEmail, companyCity, companyCounty, branchCode, branchText, lastContacted, comments, callingListTable, ".$companies.".regDate, ".$orders.".salesRepID   
	FROM ".$companies." ".$orders." 
	WHERE ".$orders.".regNumber=".$companies.".regNumber 
	AND companyStatus='".$companyStatus."' 
	AND salesRepID in (SELECT userID FROM ".$users." WHERE supervisorID=".$_SESSION['userID'].") 
	".$projectIncStr."  	
	OR salesRepID=".$_SESSION['userID']." 
	ORDER by regDate DESC"; 
	} else { 
	// Get non customers 
	$query = "SELECT ID, regNumber, companyName, companyManager, companyPhone, companyMobilePhone, 
	companyEmail, companyCity, companyCounty, branchCode, branchText, lastContacted, comments, callingListTable, ".$companies.".regDate, ".$companies.".salesRepID   
	FROM ".$companies." WHERE companyStatus='".$companyStatus."'
	AND regNumber not in (SELECT regNumber FROM ".$orders.") 
	".$projectIncStr."  	
	AND salesRepID in (SELECT userID FROM ".$users." WHERE supervisorID=".$_SESSION['userID'].") 
	OR salesRepID=".$_SESSION['userID']."  
	ORDER by regDate DESC";
	}

} else {  // Display user's companies

	if($companyStatus==$LANG['customer']) {
	// get customers
	$query = "SELECT DISTINCT ".$companies.".regNumber, ID, companyName, companyManager, companyPhone, companyMobilePhone, 
	companyEmail, companyCity, companyCounty, branchCode, branchText, lastContacted, comments, callingListTable, ".$companies.".regDate, ".$companies.".salesRepID, ".$users.".fullName 
	FROM ".$companies.", ".$users.", ".$orders." 
	WHERE ".$orders.".regNumber=".$companies.".regNumber 
	AND ".$orders.".salesRepID=".$users.".userID 
	".$projectIncStr."  	
	AND userID=".$_SESSION['userID']." 
	ORDER by regDate DESC";
	} else {
	// Get non customers 
	$query = "SELECT ID, regNumber, companyName, companyManager, companyPhone, companyMobilePhone, 
	companyEmail, companyCity, companyCounty, branchCode, branchText, lastContacted, comments, callingListTable, ".$companies.".regDate, ".$companies.".salesRepID, ".$users.".fullName 
	FROM ".$companies.", ".$users." 
	WHERE companyStatus='".$companyStatus."' 
	".$projectIncStr."  	
	AND regNumber not in (SELECT regNumber FROM ".$orders.") 
	AND  userID=".$_SESSION['userID']." 
	AND ".$companies.".salesRepID=".$users.".userID  
	ORDER by regDate DESC"; 
	}

}


try {
    $Result = $pdo->query($query);
} catch (PDOException $e) {
    echo "Data was not fetched, because: ".$e->getMessage();
}

echo '<table id="example" cellpadding="0" cellspacing="0" border="0" class="display" style="width:100%;font-size:1em;margin:0;padding:0" >';
echo '<thead>';
echo '<tr><th>#</th><th>'.$LANG['company_name'].'</th>
<th>'.$LANG['company_manager'].'</th>
<th>'.$LANG['phone'].'</th>
<th>'.$LANG['email'].'</th>
<th>'.$LANG['place'].'</th>
<th>'.$LANG['county'].'</th>
<th>'.$LANG['branch_code'].'</th>
<th>'.$LANG['business_branch'].'</th>
<th>'.$LANG['sales_rep'].'</th>
<th>'.$LANG['last_contacted'].'</th>
<th>'.$LANG['comments'].'</th>
<th></th></tr>';
echo '</thead>';
echo '<tbody>';

$i=1;

foreach($Result as $Row) {

if (($Row['companyPhone']=="-" or $Row['companyPhone']=="") && $Row['companyMobilePhone']!="-" ) {
	$Row['companyPhone']=$Row['companyMobilePhone'];
  }	

echo '<tr><td>'.$i.'</td><td>';

echo '<a href="javascript:getCustomer(\''.$Row['regNumber'].'\')">';

if($Row['companyName']=="") {
$companyName = " --- ";	
	} else {
$companyName =	$Row['companyName'];
}

echo $companyName;

echo '</a>';

echo '</td><td width="150">'.$Row['companyManager'].'</td>';

echo '<td>'.$Row['companyPhone'].'</td>
<td><a href="mailto:'.$Row['companyEmail'].'">'.$Row['companyEmail'].'</a></td>
<td>'.$Row['companyCity'].'</td>
<td>'.$Row['companyCounty'].'</td>
<td>'.$Row['branchCode'].'</td>
<td>'.$Row['branchText'].'</td>
<td>'.substr($Row['fullName'],0, strpos($Row['fullName']," ")).'</td>
<td>'.$Row['lastContacted'].'</td>';

echo '<td>'.substr($Row['comments'],0,15).'...</td><td>';


if(($Row['salesRepID']==$_SESSION['userID'] || isset($_SESSION['admin']) || isset($_SESSION['supervisor'])) && $companyStatus!=$LANG['customer'] ) {   
// Show delete button if admin or supervisor rights, or sales Rep is owner, and if company is not customer
echo '<a href="javascript:deleteCustomer(\''.$Row['regNumber'].'\',\''.$Row['companyName'].'\', \''.$redirect.'\', \''.$Row['ID'].'\', \''.$Row['callingListTable'].'\' )"><img src="images/cancel_16.png" border=0 title="'.$LANG['delete'].'"></a>';
}
echo '</td>';
'</tr>';
$i++;
    	}
echo '</tbody>';
echo '</table>';
