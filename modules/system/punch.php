<?php

session_start();
if (!isset($_SESSION['userID'])) {
    header("Location: ../../login.php");
}
require_once("db.php");
require_once("../../lang/" . $_SESSION['lang'] . ".php");

$type = $_GET['Type'];
if ($type == "In") {
    $registered = $LANG['punchedin'];
    $_SESSION['punched'] = "in: " . date("d. M - H:i");
    $color = "blue";
} else {
    $registered = $LANG['punchedout'];
    $_SESSION['punched'] = "out: " . date("d. M - H:i");
    $color = "red";
}

$userID = $_GET['userID'];

$query = "INSERT INTO Workhours SET Type='" . $type . "', userID='" . $userID . "', Stamp=NOW()";

try {
    $stmt = $pdo->prepare($query);
    $stmt->execute();
} catch (PDOException $e) {
    echo "Data was not saved, because: " . $e->getMessage();
}

print "<span style=\"color:" . $color . "\">" . $registered . ": " . date("d. M - H:i") . "</span>";

