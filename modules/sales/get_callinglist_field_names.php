<?php
session_start();
if(!isset($_SESSION['userID'])) { // check if user is logged in
header("Location: ../../index.php");
}

require_once "../system/db.php";
require_once "../../lang/".$_SESSION['lang'].".php";

$tableName = $_GET['tableName'];

$query = "SHOW FIELDS FROM `".$tableName."`";


try {
	$Result = $pdo->query($query);
} catch (PDOException $e) {
	echo "Data was not fetched, because: " . $e->getMessage();
}


foreach($Result as $Row)  {

    $fields .= $Row[0].",";
}
print substr($fields, 0, strlen($fields)-1);
?>