<?php 
session_start();
if(!isset($_SESSION['userID'])) { // check if user is logged in
header("Location: ../index.php");
}

require_once "../system/db.php";
require_once "../../lang/".$_SESSION['lang'].".php";


$fromID = $_POST['sender'];

// Get FROM name and mail
if($fromID==$_SESSION['companyEmail']) {
// Check if sender is company mail
$from = $_SESSION['companyName']."<".$fromID.">";
} else {
// Find user email and full name
$query = "SELECT userEmail, fullName from ".$users." WHERE userID=".$fromID;
if (!$Result= mysql_db_query($DBName, $query, $Link)) {
           print "No database connection <br>".mysql_error();
        } 
$Row = mysql_fetch_array($Result);
// From name and email
$from = $Row['fullName']." <".$Row['userEmail'].">";
}



$recipient = $_POST['recipient'];

$to = $_POST['recipient']." <".$_POST['recipientEmail'].">";

$message = $_POST['confirmationMail'];

$subject = "Ordrebekreftelse fra Norsk verdivurdering";
$files = ""; // add file here 

//multi_attach_mail($to, $files, $from)


// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'To:  '.$to. "\r\n";
$headers .= 'From: '.$from. "\r\n";
$headers .= 'Bcc: terje@axenna.com' . "\r\n";

if(mail($to, $subject, $message, $headers)) {
	print "mail sent";
	}


?>