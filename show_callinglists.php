<?php session_start(); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta charset="utf-8" />
<title></title>
<?php include_once 'head.php'; ?>
</head>
<body style="font-size:12px">
<?php 
include_once "menu.php";
?>
<div id="main_table">

<h1 class="ui-widget-header ui-corner-all" style="padding:3px;">&nbsp; <?php print $LANG['calling_lists']; ?> <input id="allButton" style="visibility:hidden" type="button" onclick="showAllLists(document.getElementById('callingLists').value)" value="<?php print $LANG['show_all'];?>"> 

&nbsp;
<select id="callingLists" onchange="if(this.value!='') { showAllLists(this.value,'',''); }">
<option value=""><?php print $LANG['select_callinglist']; ?></option>

<?php 

// Find Calling List connected to user 
$query = "SELECT callingListName, callingListTableName FROM ".$callinglists." cl 
INNER JOIN ".$role_callinglist." rc ON cl.listID = rc.callingListID
INNER JOIN ".$user_role." ur ON ur.roleID = rc.roleID
WHERE ur.userID = ".$_SESSION['userID']." AND ur.to_date = '9999-01-01' AND rc.to_date = '9999-01-01'"; 


try {
	$result = $pdo->query($query);
} catch (PDOException $e) {
	echo "Data was not fetched, because: " . $e->getMessage();
}
	
$listnumber = 1;

foreach ($result as $Row) {  // list Callinglists for this user   
  

?>
<option  id="<?php print $Row['callingListTableName'];?>" value="<?php print $Row['callingListTableName'];?>"><?php print $Row['callingListName'];?></option>
<?php
if($listnumber==1) {
$listTableName = $Row['callingListTableName'];
}	
$listnumber++;
}
?>
</select>
&nbsp;
<?php print $LANG['search'];?>: 

<select id="searchColumn">

</select>



<input ID="searchField" type="text" name="searchField">
<input  type="button" onclick="searchCallingList(document.getElementById('callingLists').value,'','')" value="<?php print $LANG['search']; ?>"> 
</h1>


<div id="list"></div>

<div id="graphHead" style="visibility:hidden;"><h1><?php print $LANG['graphs_overview'];?> </h1></div>

<iframe src="" id="graphs" style="border:0;width:95%;height:180px;float:left;">

</iframe>



<div id="data" style="width:100%"></div>




</div>
<script type="text/javascript">

var oTable;

function deleteCustomer(companyName, companyStatus, ID) {
	y = confirm("<?php print $LANG['confirm_delete']; ?> "+companyName)
	if (y == true) {
	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function()  {
  		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
    alert(xmlhttp.responseText);
    showCustomers();
    }
  }
xmlhttp.open("GET","modules/sales/delete_customer.php?redirect="+companyStatus+"&ID="+ID,true);
xmlhttp.send();
	
		
		}
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

function loadInfo(regNumber)
{

	document.getElementById("graphHead").style.visibility='hidden';
	document.getElementById("allButton").style.visibility='visible';

xmlhttpi=new XMLHttpRequest();
xmlhttpi.onreadystatechange=function()
  {
  if (xmlhttpi.readyState==4 && xmlhttpi.status==200)
    {
    document.getElementById("list").innerHTML=xmlhttpi.responseText;
    }
  }
xmlhttpi.open("GET","modules/sales/get_info.php?regnumber="+regNumber,true);
xmlhttpi.send();
document.getElementById("statusBar").innerHTML="";


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


function getGraphs(regNumber, companyName) {
	document.getElementById("graphHead").style.visibility='visible';    
    document.getElementById("graphs").src="modules/sales/get_charts.php?regnumber="+regNumber+"&name="+companyName;

 	}



function showAllLists (tableName, limitStart, limitEnd) {

xmlhttp2=new XMLHttpRequest();
xmlhttp2.onreadystatechange=function()  {
  if (xmlhttp2.readyState==4 && xmlhttp2.status==200) {
    document.getElementById("list").innerHTML=xmlhttp2.responseText;
	getSearchOptions(tableName);
 oTable = $('#example').dataTable({
		"bJQueryUI": true,
		"bStateSave": true,
		"iDisplayLength": 25,		
		"sPaginationType": "full_numbers",
				"oLanguage": {
			"sLengthMenu": "<?php print $LANG['LengthMenu']; ?>",
			"sZeroRecords": "<?php print $LANG['ZeroRecords']; ?>",
			"sInfo": "<?php print $LANG['Info']; ?>",
			"sInfoEmpty": "<?php print $LANG['InfoEmpty']; ?>",
			"sInfoFiltered": "<?php print $LANG['InfoFiltered']; ?>",
			"sSearch": "<?php print $LANG['search']; ?>",
			"oPaginate": {
				"sFirst":    "<?php print $LANG['First']; ?>",
				"sPrevious": "<?php print $LANG['Previous']; ?>",
				"sNext":     "<?php print $LANG['Next']; ?>",
				"sLast":     "<?php print $LANG['Last']; ?>"
				}
		}
		});
    }
  }
xmlhttp2.open("GET","modules/sales/display_callinglists.php?tableName="+tableName+"&limitStart="+limitStart+"&limitEnd="+limitEnd,true);
xmlhttp2.send();
document.getElementById("data").innerHTML=""
document.getElementById("graphs").src=""
document.getElementById("graphHead").style.visibility='hidden';
document.getElementById("allButton").style.visibility='hidden';
	
}	
	

	
function searchCallingList (tableName, limitStart, limitEnd) {

if(document.getElementById("searchField").value!="") {  

xmlhttp2=new XMLHttpRequest();
xmlhttp2.onreadystatechange=function()  {
  if (xmlhttp2.readyState==4 && xmlhttp2.status==200) {
	
    document.getElementById("list").innerHTML=xmlhttp2.responseText;
 oTable = $('#example').dataTable({
		"bJQueryUI": true,
		"bStateSave": true,
		"iDisplayLength": 25,		
		"sPaginationType": "full_numbers",
				"oLanguage": {
			"sLengthMenu": "<?php print $LANG['LengthMenu']; ?>",
			"sZeroRecords": "<?php print $LANG['ZeroRecords']; ?>",
			"sInfo": "<?php print $LANG['Info']; ?>",
			"sInfoEmpty": "<?php print $LANG['InfoEmpty']; ?>",
			"sInfoFiltered": "<?php print $LANG['InfoFiltered']; ?>",
			"sSearch": "<?php print $LANG['search']; ?>",
			"oPaginate": {
				"sFirst":    "<?php print $LANG['First']; ?>",
				"sPrevious": "<?php print $LANG['Previous']; ?>",
				"sNext":     "<?php print $LANG['Next']; ?>",
				"sLast":     "<?php print $LANG['Last']; ?>"
				}
		}
		});
    }
  }
xmlhttp2.open("GET","modules/sales/display_callinglists.php?search=yes&tableName="+tableName+"&limitStart="+limitStart+"&limitEnd="+limitEnd+"&field="+document.getElementById("searchColumn").value+"&phrase="+document.getElementById("searchField").value,true);

xmlhttp2.send();
document.getElementById("allButton").style.visibility='visible';

} else {
document.getElementById("statusBar").innerHTML='<?php print $LANG['search_field_empty']; ?>';
}
}		
	

function convertStatus(regNumber, companyStatus)
{

	document.getElementById("graphHead").style.visibility='hidden';
	document.getElementById("allButton").style.visibility='visible';

xmlhttpi=new XMLHttpRequest();
xmlhttpi.onreadystatechange=function()
  {
  if (xmlhttpi.readyState==4 && xmlhttpi.status==200)
    {
    document.getElementById("list").innerHTML=xmlhttpi.responseText;
    }
  }
xmlhttpi.open("GET","modules/sales/convert_customer_status.php?regNumber="+regNumber+"&companyStatus="+companyStatus,true);
xmlhttpi.send();
}

function makeLeads(tableName) {
	
	var total="";
	if (!document.getElementById('listForm').makeLead.length && document.getElementById('listForm').makeLead.checked) {
		total = document.getElementById('listForm').makeLead.value + ","
	} else {	
	for(var i=0; i < document.getElementById('listForm').makeLead.length; i++) {
		if(document.getElementById('listForm').makeLead[i].checked)
		total +=document.getElementById('listForm').makeLead[i].value + ","
	}
	}
if(total=="") {
alert("Velg ett eller flere firma du vil lagre som Lead(s)") 
} else { //send data

document.getElementById("statusBar").innerHTML="<?php print $LANG['processing']."... ";?>";

xmlhttpi=new XMLHttpRequest();
xmlhttpi.onreadystatechange=function()
  {
  if (xmlhttpi.readyState==4 && xmlhttpi.status==200)
    {
    document.getElementById("statusBar").innerHTML=xmlhttpi.responseText;
    }
  }
xmlhttpi.open("GET","modules/sales/create_many_leads.php?tableName="+tableName+"&list="+total,true);
xmlhttpi.send();
showAllLists(tableName);
  
		}	// end send data
	
}


function getSearchOptions(tableName)
{

xmlhttpi=new XMLHttpRequest();
xmlhttpi.onreadystatechange=function()  {
  if (xmlhttpi.readyState==4 && xmlhttpi.status==200) {
	 
	var elSel = document.getElementById('searchColumn');
	// first destroy existing options	  	
  	 for (a = elSel.length - 1; a>=0; a--) {
          elSel.remove(a);
      } 
        	
  	var Fields = new Array();
  	Fields = xmlhttpi.responseText.split(",");
  	for (i=0;i<Fields.length;i++) { 
  	
 	var elOptNew = document.createElement('option');
  	elOptNew.text = Fields[i];
  	elOptNew.value = Fields[i];
  
	// then add new ones
  try {
    elSel.add(elOptNew, null); // standards compliant; doesn't work in IE
  }
  catch(ex) {
    elSel.add(elOptNew); // IE only
  }  	
  		
    
   }
    }
  }
xmlhttpi.open("GET","modules/sales/get_callinglist_field_names.php?tableName="+tableName,true);
xmlhttpi.send();
}


	
document.getElementById("statusBar").innerHTML="";
<?php 
if($listnumber==2) {
print "showAllLists('".$listTableName."','','')";	// Display callinglist if only one
print "\n";
print "document.getElementById('callingLists').options[1].selected=true";
}	
?>

</script>


</body>
</html>