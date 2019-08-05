<?php 
session_start();
if(!isset($_SESSION['userID'])) { // check if user is logged in
header("Location: ../index.php");
}

require_once "../system/db.php";
require_once "../../lang/".$_SESSION['lang'].".php";


$fromID = $_POST['sender'];
$orderID = $_POST['orderID'];
$regNumber = $_POST['regNumber'];

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
$from = $Row['userEmail'];
}


$attachement_name = "create_order_confirmation_pdf.php?outputForm=D&orderID=".$orderID;

$recipient = $_POST['recipient'];

$to = $_POST['recipientEmail'];

$message = $_POST['confirmationMail'];

$subject = "Ordrebekreftelse fra sett inn firmanavn";

$random_hash = md5(date('r', time()));

// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= "\r\nContent-Type: multipart/mixed; boundary=\"PHP-mixed-".$random_hash."\r\n";

// Additional headers
$headers .= 'To:  '.$to. "\r\n";
$headers .= 'From: '.$from. "\r\n";
$headers .= 'Bcc: terje@axenna.com' . "\r\n";

//read the atachment file contents into a string,
//encode it with MIME base64,
//and split it into smaller chunks
$attachment = chunk_split(base64_encode(file_get_contents($attachement_name)));
//define the body of the message.
ob_start(); //Turn on output buffering
?>


--PHP-mixed-<?php echo $random_hash; ?> 
Content-Type: multipart/alternative; boundary="PHP-alt-<?php echo $random_hash; ?>"

--PHP-alt-<?php echo $random_hash; ?> 
Content-Type: text/plain; charset="iso-8859-1"
Content-Transfer-Encoding: 7bit



--PHP-alt-<?php echo $random_hash; ?> 
Content-Type: text/html; charset="utf-8"
Content-Transfer-Encoding: 7bit

<?php print $message; ?>

--PHP-alt-<?php echo $random_hash; ?>--

--PHP-mixed-<?php echo $random_hash; ?> 
Content-Type: application/pdf; name="Ordrebekreftelse_<?php print $orderID;?>_<?php print $regNumber;?>.pdf" 
Content-Transfer-Encoding: base64 
Content-Disposition: attachment 

<?php echo $attachment; ?>
--PHP-mixed-<?php echo $random_hash; ?>--

<?php
//copy current buffer contents into $message variable and delete current output buffer
$message = ob_get_clean();
//send the email
$mail_sent = @mail( $to, $subject, $message, $headers );
//if the message is sent successfully print "Mail sent". Otherwise print "Mail failed"
echo $mail_sent ? "Mail sendt til ".$to : "Mail ikke sendt";
?> 
