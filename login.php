<?php 
session_start();
if($_GET['logout']!="yes") {
session_unset();  // unset all session variables
session_destroy();
}	
if(isset($_COOKIE['style'])) {
		$_SESSION['style'] = $_COOKIE['style'];
	} else {
		$_SESSION['style'] = "smoothness";
	}

if(isset($_COOKIE['lang'])) {
		$_SESSION['lang'] = $_COOKIE['lang'];
	} else {
		$_SESSION['lang'] = "nb_NO";
	}

if($_SESSION['lang'] =="") {
$_SESSION['lang'] = "nb_NO";
}		

require_once "lang/".$_SESSION['lang'].".php";
require_once "modules/system/db.php";

// SET SESSION COMPANY VARIABLES
$query = "SELECT * from ".$preferences." WHERE companyID=1 ";
try {
     $result = $pdo->query($query);
 } catch (PDOException $e) {
     echo "Data was not fetched, because: ".$e->getMessage();
 }

foreach($result as $Row) {
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title><?php print $LANG['login_text'].$Row['companyName']; ?></title>
	<link href="css/styles.css" type="text/css" rel="stylesheet">
	<link rel="stylesheet" href="lib/jquery/development-bundle/themes/<?php print $_SESSION['style'] ?>/jquery.ui.all.css">
</head>

<script>
function doLogin() {
	if(document.getElementById("userName").value=="") { 
	alert("<?php print $LANG['enter_user_name']; ?>");
	document.getElementById("userName").focus();
	return;
}

if(document.getElementById("pwd").value=="") { 
	alert("Skriv inn passord");
	document.getElementById("pwd").focus();
	return;
}

let url = "modules/system/do_login.php";
let params = "userName="+document.getElementById('userName').value+"&pwd="+document.getElementById('pwd').value;

http=new XMLHttpRequest();

http.open("POST", url, true);

//Send the proper header information along with the request
http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
http.setRequestHeader("Content-length", params.length);
http.setRequestHeader("Connection", "close");

http.onreadystatechange = function() {//Call a function when the state changes.
	if(http.readyState == 4 && http.status == 200) {

		 if(!http.responseText.indexOf("nologin")) {
    	   document.getElementById("loginResponse").innerHTML="<span class=\"error\"><br><?php print $LANG['wrong_user_name']; ?></span>"
		 } else if(!http.responseText.indexOf("inactive")) {
	       document.getElementById("loginResponse").innerHTML="<span class=\"error\"><br><?php print $LANG['inactive_user']; ?></span>"
		 } else {
			 document.getElementById("loginResponse").innerHTML="	<span class=\"message\"><br><?php print $LANG['welcome']; ?>, "+http.responseText+"</span>";  
		
		setTimeout("document.location='index.php'",550);
	    }
}
}
http.send(params);
}
</script>

<body>
<table class="logintable ui-widget-content ui-corner-all">
	<tr><td colspan="2"><img src="images/logo/logo1.png" alt="" style="display:block;margin-left:auto;margin-right:auto"></td></tr>
	<tr><td colspan="2" align="center"><b><?php print $LANG['login_text'].$Row['companyName'];?></b><br><br></td></tr>
	<tr><td><?php print $LANG['user_name'];?>: </td><td><input type="text" id="userName" name="userName" style="width:200px;"></td></tr>
	<tr><td><?php print $LANG['pwd'];?>: </td><td><input type="password" id="pwd" name="pwd" style="width:200px;"></td></tr>
	<tr><td></td><td><input type="button" name="login" value="<?php print $LANG['login'];?>" onclick="doLogin()" style="width:80px;"></td></tr>
	<tr><td colspan="2" align="center">
	<div id="loginResponse" style="width:100%; height=40px;text-align:center;"> </div>
	</td></tr>
</table>
<?php
if($_GET['logout']=="yes") {
print "<script language=\"JavaScript\">";
print "document.getElementById(\"loginResponse\").innerHTML=\"".$_SESSION['fullName']." ".$LANG['logged_out']."\"";
print "</script>";

session_unset();  // unset all session variables
session_destroy();
}
}
?>

<script type="text/javascript" >
	document.getElementById("userName").focus();
</script>

</body>
</html>
