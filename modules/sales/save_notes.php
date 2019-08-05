<?php
session_start();
if(!isset($_SESSION['userID'])) { // check if user is logged in
header("Location: ../../index.php");
}


require_once "../system/db.php";
require_once "../../lang/".$_SESSION['lang'].".php";

$regNumber = $_GET['regNumber'];
$notes = $_GET['notes'];

$query = "UPDATE ".$companies." SET comments=:notes WHERE regNumber=:regNumber";

try {
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':notes', $notes);
    $stmt->bindParam(':regNumber', $regNumber);
    $stmt->execute();

} catch (PDOException $e) {
    echo "Data was not fetched, because: ".$e->getMessage();
}

print $LANG['notes_saved'];

