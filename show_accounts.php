<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
  <link href="css/styles.css" type="text/css" rel="stylesheet">
<title></title>

<script type="text/javascript">

function loadInfo()
{
xmlhttp=new XMLHttpRequest();
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("accform").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","modules/sales/get_accounts.php?regnumber="+document.getElementById('regnumber').value,true);
xmlhttp.send();

}
</script>


</head>
<body>
<?php
require_once "lang/".$_SESSION['lang'].".php";
include_once "menu.php";
?>
<div class="mainTable">
<h1><?php print $LANG['show_accounts'];?></h1>
<img src="images/logo_32.png" alt="Logo" align="left" valign="baseline"/>&nbsp;

<?php print $LANG['write_org_number'];?>: <input ID="regnumber" type="text" name="regnumber">
<input  type="button" onclick="loadInfo()" value="<?php print $LANG['get_accounts']; ?>">

<br /><br />
<div id="accform">

</div>


</div>
</body>
</html>