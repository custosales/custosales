<?php
session_start();
if(!isset($_SESSION['userID'])) {
header("Location: ../../login.php");
}

require_once "../system/db.php";
require_once "../../lang/".$_SESSION['lang'].".php";

$regNumber = $_GET['regNumber'];
$companyInternet = $_GET['companyInternet'];
$companyEmail = $_GET['companyEmail'];
$companyPhone = $_GET['companyPhone'];
$companyMobilePhone = $_GET['companyMobilePhone'];
$companyFax = $_GET['companyFax'];
$companyPostAddress = $_GET['companyPostAddress'];

$query = "UPDATE ".$companies." SET 
companyInternet=:companyInternet, 
companyEmail=:companyEmail,
companyPhone=:companyPhone,
companyMobilePhone=:companyMobilePhone,
companyFax=:companyFax,
companyPostAddress=:companyPostAddress  
WHERE regNumber=:regNumber";

try {
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':companyInternet', $companyInternet);
    $stmt->bindParam(':companyEmail', $companyEmail);
    $stmt->bindParam(':companyPhone', $companyPhone);
    $stmt->bindParam(':companyMobilePhone', $companyMobilePhone);
    $stmt->bindParam(':companyFax', $companyFax);
    $stmt->bindParam(':companyPostAddress', $companyPostAddress);
    $stmt->bindParam(':regNumber', $regNumber);
    $stmt->execute();

    print $LANG['company_contact_data_saved'];

} catch (PDOException $e) {
    echo "Data was not saved, because: ".$e->getMessage();
}

?>
