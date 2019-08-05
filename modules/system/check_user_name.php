<?php

session_start();
if (!isset($_SESSION['userID'])) { // check if user is logged in
    header("Location: ../index.php");
}

require_once "db.php";
require_once "../../lang/" . $_SESSION['lang'] . ".php";

$userName = $_GET['userName'];

$query = "SELECT userID FROM " . $users . " WHERE userName='" . $userName . "'";
// Check if username exists
try {
    $stmt = $pdo->query($query);
    $count = $stmt->rowCount();
} catch (PDOException $e) {
    "User name not checked, because: " . $e->getMessage();
}

if ($count > 0) {
    print $LANG['user_name_exists'];
} else {
    echo "OK";
}