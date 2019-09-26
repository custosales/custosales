<?php
session_start();
require_once("db.php");

$userName = filter_input(INPUT_POST,'userName',FILTER_SANITIZE_STRING);
$pwd = md5($_POST['pwd']);

// SET SESSION USER VARIABLES

if(!isset($_SESSION['lang'])) {
$_SESSION['lang']="nb_NO";
}	


$query = "SELECT userID, fullName, userEmail, phone, active, mobilePhone from ".$users." WHERE userName = :userName and pwd=:pwd";

try {
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':userName', $userName);
    $stmt->bindParam(':pwd', $pwd);
    $stmt->execute();
    $Row = $stmt->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "User data was not fetched, because: ".$e->getMessage();
}


if($Row['userID']!="") {  // user ecists

if($Row['active']) { // user is active, set variables
	
$_SESSION['userID'] = $Row['userID'];
$_SESSION['fullName'] = $Row['fullName'];
$_SESSION['userEmail'] = $Row['userEmail'];
$_SESSION['phone'] = $Row['phone'];
$_SESSION['mobilePhone'] = $Row['mobilePhone'];

// SET SESSION COMPANY VARIABLES
$queryc = "SELECT * from ".$preferences." WHERE companyID=1 ";

try {
    $stmt = $pdo->prepare($queryc);
    $stmt->execute();
    $Rowc = $stmt->fetch();
} catch (PDOException $e) {
    echo "Company data was not fetched, because: ".$e->getMessage();
 }


$_SESSION['companyName'] = $Rowc['companyName'];
$_SESSION['companyEmail'] = $Rowc['companyEmail'];
$_SESSION['creditDays'] = $Rowc['defaultCreditDays'];
$_SESSION['currency'] = $Rowc['defaultCurrency'];
$_SESSION['regNumber'] = $Rowc['companyRegNumber'];
$_SESSION['companyInternet'] = $Rowc['companyInternet'];
$_SESSION['companyPhone'] = $Rowc['companyPhone'];
$_SESSION['companyBankAccount'] = $Rowc['companyBankAccount'];


// SET SESSION ROLE AND MODULE RIGHTS
$queryRoles = "SELECT roleID from ".$user_role." WHERE userID=:userID and to_date = '9999-01-01'";

$userID = $Row['userID'];

try {
    $stmt = $pdo->prepare($queryRoles);
    $stmt->bindParam(':userID', $userID);
    $stmt->execute();
    $rowRoles = $stmt->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Role IDs were not fetched, because: ".$e->getMessage();
}



foreach ($rowRoles as $Role) {  // loop roles

// Set admin rights - admin is always roleID 1

    if($Role['roleID']==1) { 
	    $_SESSION['admin'] = "yes";
	}

// Get user's roles

$queryr = "SELECT * from ".$roles." WHERE roleID like ".$Role['roleID'];

try {
    $stmt = $pdo->prepare($queryr);
    $stmt->execute();
    $Rowr = $stmt->fetch();
} catch (PDOException $e) {
    echo "Role Data was not fetched, because: ".$e->getMessage();
}

$userProjects = $userProjects.",".$Rowr['roleProjectID'];

if($Rowr['supervisorRights']==1) {
	$_SESSION['supervisor'] = "yes";
	}
if($Rowr['salesModule']==1) {
	$_SESSION['salesModule'] = "yes";
	}
if($Rowr['orderModule']==1) {
	$_SESSION['orderModule'] = "yes";
	}
if($Rowr['reportModule']==1) {
	$_SESSION['reportModule'] = "yes";
	}

// get rid of first comma for user's project IDs
$userProjects = substr($userProjects, 1);

$_SESSION['userProjects'] = $userProjects;

if(!strstr($userProjects,",")) { // User has only one project

$_SESSION['project'] = $userProjects;

$queryPN = "SELECT projectName, projectFirstSalesStage, projectFirstOrderStage from ".$projects." WHERE projectID=".$userProjects."";

try {
    $stmt = $pdo->prepare($queryPN); 
    $stmt->execute(); 
    $RowPN = $stmt->fetch();
} catch (PDOException $e) {
    echo "Data was not fetched, because: ".$e->getMessage();
 }

$_SESSION['projectName'] = $RowPN['projectName'];
$_SESSION['projectFirstSalesStage'] = $RowPN['projectFirstSalesStage'];
$_SESSION['projectFirstOrderStage'] = $RowPN['projectFirstOrderStage'];
 
} // end if user has one project

} // end loop roles

print $_SESSION['fullName'];   // Send full name to login form 

} else { // user account is inactive
print "inactive";
}

} else {  // user name or pwd is not found 
print "nologin";
}
?>

