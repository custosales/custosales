<?php

session_start();
if (!isset($_SESSION['userID'])) { // check if user is logged in
    header("Location: ../../index.php");
}

require_once "../system/db.php";
require_once "../../lang/" . $_SESSION['lang'] . ".php";

$regNumber = $_GET['regNumber'];
$companyStatus = $_GET['companyStatus'];

$query = "UPDATE " . $companies . " SET companyStatus='" . $companyStatus . "' WHERE regNumber=" . $regNumber;

try {
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    print $LANG['company_status_changed'];
} catch (PDOException $e) {
    echo "Company status was not changed, because: " . $e->getMessage();
}
