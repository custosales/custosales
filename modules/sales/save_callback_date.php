<?php
session_start();
if(!isset($_SESSION['userID'])) { // check if user is logged in
header("Location: ../../index.php");
}

require_once "../system/db.php";
require_once "../../lang/".$_SESSION['lang'].".php";

$regNumber = $_GET['regNumber'];
$callDate = $_GET['callDate'];

$query = "UPDATE ".$companies." SET contactAgain=:callDate  WHERE regNumber=:regNumber";

try {
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':callDate', $callDate);
    $stmt->bindParam(':regNumber', $regNumber);
    $stmt->execute();

} catch (PDOException $e) {
    echo "Data was not updated, because: ".$e->getMessage();
}

$querys = "SELECT contactAgain from ".$companies." WHERE regNumber=:regNumber";
try {
    $stmt = $pdo->prepare($querys);
    $stmt->bindParam(':regNumber', $regNumber);
    $stmt->execute();
    $Rows = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e)  {

    echo "Data was not updated, because: ".$e->getMessage();
}

print $Rows['contactAgain'];

