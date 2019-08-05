<?php
session_start();
if(!isset($_SESSION['userID'])) { // check if user is logged in
header("Location: ../../index.php");
}

include_once "../../lang/".$_SESSION['lang'].".php";
include_once "../system/db.php";


$orgn = str_replace(" ", "", $_GET['regNumber']);


$dataURL = 'http://data.brreg.no/enhetsregisteret/enhet/'.trim($orgn).'.json';

// Get JSON from brreg 
$jsont = file_get_contents($dataURL);

// convert into associative array
print $jsont;
   	    


 

