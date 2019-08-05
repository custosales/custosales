<?php
session_start();
if(!isset($_SESSION['userID'])) { // check if user is logged in
header("Location: ../../index.php");
}

require_once "../system/db.php";
require_once "../../lang/".$_SESSION['lang'].".php";

$regNumber = $_GET['regNumber'];
$notes = $_GET['notes'];

$query = "UPDATE ".$companies." SET lastContacted=NOW() WHERE regNumber=:regNumber";

try {
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':regNumber', $regNumber);
    $stmt->execute();

} catch (PDOException $e) {
    echo "Data was not updated, because: ".$e->getMessage();
}

$querys = "SELECT lastContacted from ".$companies." WHERE regNumber=:regNumber";

try {
    $stmt = $pdo->prepare($querys);
    $stmt->bindParam(':regNumber', $regNumber);
    $stmt->execute();
    $Rows = $stmt->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Data was not fetched, because: ".$e->getMessage();
}

print $Rows['lastContacted'];

