<?php
if (strpos($_SERVER['HTTP_USER_AGENT'], 'Netscape') )  {
     $browser = 'Netscape';
     $styles = "dhtmlXCombo.css";
} else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox') )  {
     $browser = 'Firefox';
     $styles = "dhtmlXCombo.css";
} else if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') ) {
     $browser = 'IE';
     $styles = "dhtmlXCombo_IE.css";
} else if (strpos($_SERVER['HTTP_USER_AGENT'], 'pera') )  {
     $browser = 'Opera';
	  $styles = "dhtmlXCombo_IE.css";
} else {
     $browser = 'Other';
     $styles = "dhtmlXCombo.css";
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta charset="utf-8" />
<title>Generate Calling lists</title>
<script src="lib/dhtmlXCommon.js"></script> 
 	<script src="lib/dhtmlXCombo.js"></script>
 	<link rel="STYLESHEET" type="text/css" href="css/<?php print $styles; ?>">
</head>
<body id="dt_example">
<?php
include_once "menu.php";
?>
<script type="text/javascript">
function loadInfo()
{
xmlhttp=new XMLHttpRequest();
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("list").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","modules/sales/get_callinglist.php?place="+document.getElementById('sted').value+"&SN2007="+document.callform.SN2007.value,true);
xmlhttp.send();

document.getElementById("graphHead").style.visibility='hidden';
document.getElementById("data").innerHTML='';
document.getElementById("graphs").src='';


}

function displayListItems(listID)
{
document.getElementById("allButton").value='<?php print $LANG['show_all'];?>';	
document.getElementById("allButton").style.visibility='visible';
document.getElementById("getForm").style.visibility='hidden';
document.getElementById("graphHead").style.visibility='hidden';
document.getElementById("data").innerHTML='';
document.getElementById("graphs").src='';

xmlhttp=new XMLHttpRequest();
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("list").innerHTML=xmlhttp.responseText;
     oTable = $('#example').dataTable({
		"bJQueryUI": true,
		});
    
    }
  }
xmlhttp.open("GET","modules/sales/display_callinglist_items.php?listID="+listID,true);
xmlhttp.send();
}

function displayCompany(ID,regNumber,listID)
{
	document.getElementById("listButton").onclick=new Function("displayListItems("+ listID +")");
	document.getElementById("listButton").style.visibility='visible';
	document.getElementById("allButton").style.visibility='visible';
	document.getElementById("getForm").style.visibility='hidden';
	document.getElementById("graphHead").style.visibility='hidden';
document.getElementById("data").innerHTML='';
document.getElementById("graphs").src='';
		
xmlhttp2=new XMLHttpRequest();
xmlhttp2.onreadystatechange=function()
  {
  if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
    {
    document.getElementById("list").innerHTML=xmlhttp2.responseText;
    oTable = $('#example').dataTable({
		"bJQueryUI": true,
		});
    
    }
  }
xmlhttp2.open("GET","modules/sales/display_company.php?ID="+ID+"&reg_number="+regNumber,true);
xmlhttp2.send();
}

function displayCallinglists()
{
document.getElementById("allButton").style.visibility='hidden';
document.getElementById("listButton").style.visibility='hidden';
document.getElementById("getForm").style.visibility='visible';
document.getElementById("graphHead").style.visibility='hidden';
document.getElementById("data").innerHTML='';
document.getElementById("graphs").src='';
	
xmlhttp3=new XMLHttpRequest();
xmlhttp3.onreadystatechange=function()
  {
  if (xmlhttp3.readyState==4 && xmlhttp3.status==200)
    {
    document.getElementById("list").innerHTML=xmlhttp3.responseText;
     
     oTable = $('#example').dataTable({
		"bJQueryUI": true,
		 		});

    }
  }
xmlhttp3.open("GET","modules/sales/display_callinglists.php",true);
xmlhttp3.send();
}



function getData(regNumber, companyName) {
	
xmlhttp=new XMLHttpRequest();
xmlhttp.onreadystatechange=function()  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200) {
    document.getElementById("data").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","modules/sales/get_accounts.php?regnumber="+regNumber+"&name="+companyName,true);
xmlhttp.send();	

	document.getElementById("graphHead").style.visibility='visible';    
    document.getElementById("graphs").src="modules/sales/get_charts.php?regnumber="+regNumber+"&name="+companyName;

	}
	

function getCustomer (regNumber) {
	document.getElementById("graphHead").style.visibility='hidden';
	document.getElementById("allButton").style.visibility='visible';
	 
xmlhttp=new XMLHttpRequest();
xmlhttp.onreadystatechange=function()  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200) {
    document.getElementById("list").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","modules/sales/display_customer_data.php?regnumber="+regNumber,true);
xmlhttp.send();

}	

	
function getInfo(regNumber)
{
xmlhttp=new XMLHttpRequest();
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("list").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","modules/sales/get_info.php?regnumber="+regNumber,true);
xmlhttp.send();
document.getElementById("listButton").style.visibility='visible';


}


function HttpRequest(url){
pageRequest = false

if (!pageRequest && typeof XMLHttpRequest != 'undefined')
   pageRequest = new XMLHttpRequest()

if (pageRequest){ //if pageRequest is not false
   pageRequest.open('GET', url, false) //get page synchronously 
   pageRequest.send(null)
   embedpage(pageRequest)
   }
}

function embedpage(request){
//if viewing page offline or the document was successfully retrieved online (status code=2000)
if (window.location.href.indexOf("http")==-1 || request.status==200)
   the_result = request.responseText;
}


$(document).ready(function() {
	oTable = $('#example').dataTable({
		"bRetrieve": true,
		
	});
} );
</script>


<script type="text/javascript">
//<![CDATA[
    function setGeo(type, id, value) {
			document.getElementById('sted').value=value        
         }
        
//]]>
</script>

<h1><?php print $s_generate_calling_list; ?> <span style="width:150px;"><input type="button" ID="allButton" onclick="displayCallinglists()" value="<?php print $LANG['show_all']; ?>"> &nbsp; <input type="button" ID="listButton" onclick="" value="<?php print $LANG['show_calling_list']; ?>"></span>
</h1>


<iframe src="modules/sales/select_location.php" id="selector" style="border:0;width:225px;height:250px;float:left;">

</iframe>

<form name="callform" ID="getForm" method="post" action="modules/sales/get_callinglist.php">
<span style="float:left;width:60px;"><?php print $LANG['place']; ?>:  </span><input name="hvor" type="text" class="inputfield" id="sted" value=""/> <br>
<span style="float:left;width:60px;"><?php print $LANG['business_branch']; ?>:&nbsp; </span>  <span id="combo_branch" style="margin-top:2px;width:240px;float:left;height:15px;"></span> 
<span style="float:left"><input type="button" ID="getButton" onclick="loadInfo()" value="<?php print $LANG['get_calling_list']; ?>"></span>
 </form>
 
<br />
<div id="list" style="float:left" ></div>

<div id="graphHead" style="visibility:hidden;"><h1><?php print $LANG['graphs_overview'];?> </h1></div>

<iframe src="" id="graphs" style="border:0;width:95%;height:380px;float:left;">

</iframe>

<div id="data" style="width:100%"></div>


<script language="JavaScript" type="text/javascript">
var o=new dhtmlXCombo("combo_branch","SN2007",220)
o.enableFilteringMode(true,"modules/sales/complete_branch.php",true);
// o.setComboText("<?php print $Rowo['name'];?>");

displayCallinglists()

function setlist(place, branch) {
document.getElementById("sted").value = place
o.setComboText(branch);
}


</script>

</body>
</html>