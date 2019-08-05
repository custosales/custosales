<?php
session_start();
print $_SESSION['userID']; 
print_r($_POST); 

	$userWidgets = array(
	"title" => "Using MySQL and JSON",
	"date" => "25 April 2009",
	"timeOfWriting" => "15h34");
 
	$json = json_encode($userWidgets);
	echo "Encoded JSON: ".$json;
	echo "<br/>Decoded JSON (as associative array):<br/>";
	print_r(json_decode($json, true));
	echo "<br/>Decoded JSON (as stdClass object):<br/>";
	print_r(json_decode($json));


?>

 
