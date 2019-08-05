<?php
session_start();
if(!isset($_SESSION['userID'])) { // check if user is logged in
header("Location: ../../index.php");
}

include_once "../../lang/".$_SESSION['lang'].".php";
include_once "../system/db.php";



$customer ="";
$orgn = str_replace(" ", "", $_GET['regNumber']);

$query = "SELECT companyName from ".$companies."  WHERE regNumber=".$orgn;

try {
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $Row = $stmt->fetch();
     } catch (PDOException $e) {
        echo "2 - Data was not fetched, because: " . $e->getMessage();
    }

	
    if($Row['companyName']!="") {
		
     print($Row['companyName']); 
  
    } else {
     print "na";	
    }	
?>