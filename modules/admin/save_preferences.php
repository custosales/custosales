<?php

session_start();
if (!isset($_SESSION['userID'])) {
    header("Location: ../../index.php");
}
require_once("../system/db.php");
require_once("../../lang/" . $_SESSION['lang'] . ".php");

$query = "UPDATE " . $preferences . " SET 
companyName = :companyName, 
companyRegNumber =:companyRegNumber, 
companyAddress =:companyAddress, 
companyZip =:companyZip, 
companyCity =:companyCity, 
companyPhone =:companyPhone, 
companyFax =:companyFax, 
companyChatDomain = :companyChatDomain, 
companyEmail =:companyEmail, 
companyInternet =:companyInternet, 
defaultCurrency =:defaultCurrency, 
defaultCreditDays =:defaultCreditDays,  
companyBankAccount =:companyBankAccount,  
companyManagerID =:companyManagerID  
WHERE companyID = 1 ;";

try {
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':companyName', $_GET['companyName']);
    $stmt->bindParam(':companyRegNumber', $_GET['companyRegNumber']);
    $stmt->bindParam(':companyAddress', $_GET['companyAddress']);
    $stmt->bindParam(':companyZip', $_GET['companyZip']);
    $stmt->bindParam(':companyCity', $_GET['companyCity']);
    $stmt->bindParam(':companyPhone', $_GET['companyPhone']);
    $stmt->bindParam(':companyFax', $_GET['companyFax']);
    $stmt->bindParam(':companyChatDomain', $_GET['companyChatDomain']);
    $stmt->bindParam(':companyEmail', $_GET['companyEmail']);
    $stmt->bindParam(':companyInternet', $_GET['companyInternet']);
    $stmt->bindParam(':defaultCurrency', $_GET['defaultCurrency']);
    $stmt->bindParam(':defaultCreditDays', $_GET['defaultCreditDays']);
    $stmt->bindParam(':companyBankAccount', $_GET['companyBankAccount']);
    $stmt->bindParam(':companyManagerID', $_GET['companyManagerID']);
    $stmt->execute();
    print $LANG['data_saved'];
} catch (PDOException $e) {
    echo "Data was not fetched, because: " . $e->getMessage();
}