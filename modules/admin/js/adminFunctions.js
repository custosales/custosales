
function showDatePicker(fieldID) {
	$(function() {
		$.datepicker.setDefaults( $.datepicker.regional[ lang ] );
		var field = "#"+fieldID;
			$(field).datepicker({ 
			changeMonth: true,
			changeYear: true		
		});
		
		});
}


function getFromBrreg(regNumber) {
	
	if(regNumber=="") {
		alert(insert_regnumber);
		document.getElementById("value1").focus();
		exit;	
	}
		
	xmlhttp1=new XMLHttpRequest();
	xmlhttp1.onreadystatechange=function()  {
  		if (xmlhttp1.readyState==4 && xmlhttp1.status==200) {
			var companyName = xmlhttp1.responseText;
		
			if (companyName=="na") {
				getFromBrregReal(regNumber)
			} else {
			var updateText = "Oppdatere "+companyName+" fra Brreg?";
			var headingText = "Oppdatere fra Brreg";


					jConfirm(updateText, headingText, function(y) {
					if(y==true) {
						getFromBrregReal(regNumber)
					}
					});
					
			}				
					
		 }
      }	
	xmlhttp1.open("GET","modules/sales/get_company_name.php?regNumber="+regNumber,true);
	xmlhttp1.send();		
	
}


function getFromBrregReal(regNumber) {
		
                            
$.getJSON("http://data.brreg.no/enhetsregisteret/enhet/"+regNumber+".json", function(json){
  
var val = json;
    
    document.getElementById("value2").value = val.navn;		
		document.getElementById("value4").value = val.organisasjonsform;		
		document.getElementById("value5").value = val.epost;		
		document.getElementById("value6").value = val.hjemmeside;	
		document.getElementById("value7").value = val.telefon;	
		document.getElementById("value8").value = '8';	
		document.getElementById("value9").value = '9';
		
		document.getElementById("value10").value = val.forretningsadresse.adresse;		
	 	document.getElementById("value11").value = val.postadresse.adresse;
	 			
		document.getElementById("value12").value = val.postadresse.postnummer;		
		document.getElementById("value13").value = val.postadresse.poststed;		

		document.getElementById("value15").value = '15';
		
		
		document.getElementById("value16").value = '16';

		document.getElementById("value17").value = '17';
		
		document.getElementById("value18").value = val.naeringskode1.kode;
		document.getElementById("value19").value = val.naeringskode1.beskrivelse;
		var now = new Date();		
		document.getElementById("value24").value = now.getFullYear()+'-'+(now.getMonth()+1)+'-'+now.getDate();	
}); 
 
}

function editItem(itemType, action, itemID) {

	var addHeading = eval("add"+itemType.substring(0, itemType.length-1)); 	
	var editHeading = eval("edit"+itemType.substring(0, itemType.length-1));
	
	if(action=="add") {
	document.getElementById('actionHeader').innerHTML=addHeading;
	}
	if(action=="edit") {
	document.getElementById('actionHeader').innerHTML=editHeading;
	}
	
	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function()  {
  		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			if(action=="edit" || action=="add") {
    			document.getElementById("actionArea").innerHTML=xmlhttp.responseText;

		    	if(itemType=='Users') {	// register Date Pickers for user form
    			showDatePicker('value9');
    			showDatePicker('value10');
    			}

				if(itemType=='Projects') {	// register Date Pickers for user form
    			showDatePicker('value3');
    			showDatePicker('value4');
    			}

				if(itemType=='Companies') {	// register Date Pickers for company form
    			showDatePicker('value15');
    			showDatePicker('value16');
    			showDatePicker('value20');
    			showDatePicker('value21');
    			showDatePicker('value24');
    			}

    			
			} 
			if(action=="delete") { 
				document.getElementById("statusBar").innerHTML=xmlhttp.responseText;				
			}
     }
  }

	xmlhttp.open("GET","modules/admin/edit_item.php?itemType="+itemType+"&action="+action+"&itemID="+itemID,true);
	xmlhttp.send();		
	
}


function deleteItem(itemType,itemID,deleteText,headingText) {

document.getElementById("statusBar").innerHTML=""; // clean Status Bar

xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function()  {
  		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
				document.getElementById("statusBar").innerHTML=xmlhttp.responseText;				
			ShowAdminArea = false;			
			 eval("show"+itemType+"()");  // Show updated records

     }
  }

	jConfirm(deleteText, headingText, function(y) {
		if(y==true) {
		xmlhttp.open("GET","modules/admin/edit_item.php?itemType="+itemType+"&action=delete&itemID="+itemID,true);
		xmlhttp.send();		
		}
	});
	
	
}

function saveItem(itemType, action, itemID, valueNumber) {

document.getElementById("statusBar").innerHTML=""; // clean Status Bar

var  valueStr = '"'+document.getElementById('value1').value+'"|';

for(i=2;i<valueNumber;i++) {
	
		if(document.getElementById('value'+i).getAttribute('type') == 'checkbox') {  
			valueStr += '"'+document.getElementById('value'+i).checked+'"|';			
		} else if (document.getElementById('value'+i).getAttribute('name') == 'roles' || document.getElementById('value'+i).getAttribute('name') == 'projectOrderStages' || document.getElementById('value'+i).getAttribute('name') == 'projectSalesStages' || document.getElementById('value'+i).getAttribute('name') == 'roleCallingLists'  ) { 
			var selObj = document.getElementById('value'+i);
			var a = 0;
			var selectedStr="";
  			
  				for (a=0; a<selObj.options.length; a++) {
    				if (selObj.options[a].selected) {
      				selectedStr += selObj.options[a].value+',';
      			}
  				}
  			selectedStr = selectedStr.substring(0, selectedStr.length-1); 	
  			valueStr += '"'+selectedStr+'"|';
  			} else  {	
			valueStr += '"'+document.getElementById('value'+i).value+'"|';
		}
		}

	valueStr = encodeURIComponent(valueStr.substring(0, valueStr.length-1)); 


	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function()  {
  		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
    document.getElementById("statusBar").innerHTML=xmlhttp.responseText;
			ShowAdminArea = false;			
			 eval("show"+itemType+"()");  // Show updated records
		     
     }
  }
xmlhttp.open("GET","modules/admin/save_item.php?itemType="+itemType+"&action="+action+"&itemID="+itemID+"&values="+valueStr,true);
xmlhttp.send();	
	
	
}


function listContacts(companyID,contactsHeading) {

document.getElementById("statusBar").innerHTML=""; // clean Status Bar
document.getElementById('actionHeader').innerHTML=contactsHeading;

	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function()  {
  		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
  			document.getElementById("actionArea").innerHTML=xmlhttp.responseText;
	contactsTable = $('#contacts').dataTable({
		"bJQueryUI": true,
		"bStateSave": true,
		"iDisplayLength": 25,
		"sPaginationType": "full_numbers",
		"oLanguage": {
			"sLengthMenu": lLengthMenu,
			"sZeroRecords": lZeroRecords,
			"sInfo": lInfo,
			"sInfoEmpty": lInfoEmpty,
			"sInfoFiltered": lInfoFiltered,
			"sSearch": lSearch,
			"oPaginate": {
				"sFirst":    lFirst,
				"sPrevious": lPrevious,
				"sNext":     lNext,
				"sLast":     lLast
				}

		}
		});      			
  			
  	   }
  }
xmlhttp.open("GET","modules/admin/list_contacts.php?companyID="+companyID,true);
xmlhttp.send();

}

function displayContactData(contactID) {
	
	
}

function showPreferences() {

document.getElementById("statusBar").innerHTML=""; // clean Status Bar

	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function()  {
  		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
  			document.getElementById("adminArea").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","modules/admin/display_preferences.php",true);
xmlhttp.send();

}


function savePreferences() {

	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function()  {
  		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
    document.getElementById("statusBar").innerHTML=xmlhttp.responseText;
      }
  }

	var companyName = document.getElementById('companyName').value;
	var companyRegNumber = document.getElementById('companyRegNumber').value;
	var companyAddress = document.getElementById('companyAddress').value;

	var companyZip = document.getElementById('companyZip').value;
	var companyCity = document.getElementById('companyCity').value;
	var companyPhone = document.getElementById('companyPhone').value;
	var companyEmail = document.getElementById('companyEmail').value;
	var companyInternet = document.getElementById('companyInternet').value;
	var companyFax = document.getElementById('companyFax').value;
	var companyChatDomain = document.getElementById('companyChatDomain').value;
	var defaultCurrency = document.getElementById('defaultCurrency').value;
	var defaultCreditDays = document.getElementById('defaultCreditDays').value;
	var companyBankAccount = document.getElementById('companyBankAccount').value;
	var companyManagerID = document.getElementById('companyManagerID').value;

		var queryString = "?companyName=" + encodeURIComponent(companyName) + 
	"&companyRegNumber=" + encodeURIComponent(companyRegNumber) +
	"&companyAddress=" + encodeURIComponent(companyAddress) +
	"&companyZip=" + encodeURIComponent(companyZip) +
	"&companyCity=" + encodeURIComponent(companyCity) +
	"&companyPhone=" + encodeURIComponent(companyPhone) +
	"&companyEmail=" + encodeURIComponent(companyEmail) +
	"&companyInternet=" + encodeURIComponent(companyInternet) +
	"&companyFax=" + encodeURIComponent(companyFax) +
	"&companyChatDomain=" + encodeURIComponent(companyChatDomain) +
	"&defaultCurrency=" + encodeURIComponent(defaultCurrency) +
	"&defaultCreditDays=" + encodeURIComponent(defaultCreditDays) +
	"&companyBankAccount=" + encodeURIComponent(companyBankAccount) +
	"&companyManagerID=" + companyManagerID 	
	;
	
	xmlhttp.open("GET", "modules/admin/save_preferences.php"+queryString,true);
	xmlhttp.send();	
}


function showProductCategories() {

	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function()  {
  		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
  			document.getElementById("adminArea").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","modules/admin/display_product_categories.php",true);
xmlhttp.send();

}


function showProducts() {

	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function()  {
  		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
  			document.getElementById("adminArea").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","modules/admin/display_products.php",true);
xmlhttp.send();

}

function showContacts(contactType) {

	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function()  {
  		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
  			document.getElementById("adminArea").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","modules/admin/display_contacts.php?contactType="+contactType,true);
xmlhttp.send();

}



function showUsers() {

	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function()  {
  		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
  			document.getElementById("adminArea").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","modules/admin/display_users.php",true);
xmlhttp.send();

}


function showUserDocuments(userID) {

	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function()  {
  		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
  			document.getElementById("adminArea").innerHTML=xmlhttp.responseText;
  			    }
  }
xmlhttp.open("GET","modules/system/display_user_documents.php",true);
xmlhttp.send();

}


function showLinks() {

	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function()  {
  		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
  			document.getElementById("adminArea").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","modules/admin/display_links.php",true);
xmlhttp.send();

}


function showProjects() {

	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function()  {
  		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
  			document.getElementById("adminArea").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","modules/admin/display_projects.php",true);
xmlhttp.send();

}

function showClients(companyStatus,salesRepID) {

	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function()  {
  		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
  			document.getElementById("adminArea").innerHTML=xmlhttp.responseText;
contactsTable = $('#clients').dataTable({
		"bJQueryUI": true,
		"bStateSave": true,
		"iDisplayLength": 25,
		"sPaginationType": "full_numbers",
		"oLanguage": {
			"sLengthMenu": lLengthMenu,
			"sZeroRecords": lZeroRecords,
			"sInfo": lInfo,
			"sInfoEmpty": lInfoEmpty,
			"sInfoFiltered": lInfoFiltered,
			"sSearch": lSearch,
			"oPaginate": {
				"sFirst":    lFirst,
				"sPrevious": lPrevious,
				"sNext":     lNext,
				"sLast":     lLast
				}
		}
		});      			
  	


    }
  }
xmlhttp.open("GET","modules/admin/display_clients.php?companyStatus="+companyStatus+"&salesRepID="+salesRepID,true);
xmlhttp.send();

}


function showSalesStages() {

	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function()  {
  		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
  			document.getElementById("adminArea").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","modules/admin/display_sales_stages.php",true);
xmlhttp.send();

}


function showContactTypes() {

	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function()  {
  		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
  			document.getElementById("adminArea").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","modules/admin/display_contact_types.php",true);
xmlhttp.send();

}



function showRoles() {

	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function()  {
  		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
  			document.getElementById("adminArea").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","modules/admin/display_roles.php",true);
xmlhttp.send();

}

function showOrderStages(){

	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function()  {
  		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
  			document.getElementById("adminArea").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","modules/admin/display_order_stages.php",true);
xmlhttp.send();

}

function showCallingLists(){

	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function()  {
  		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
  			document.getElementById("adminArea").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","modules/admin/display_calling_lists.php",true);
xmlhttp.send();

}


function showCurrencies() {

	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function()  {
  		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
  			document.getElementById("adminArea").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","modules/admin/display_currencies.php",true);
xmlhttp.send();

}

function showContracts() {

	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function()  {
  		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
  			document.getElementById("adminArea").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","modules/admin/display_contracts.php",true);
xmlhttp.send();

}

function showWorkplaces() {

	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function()  {
  		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
  			document.getElementById("adminArea").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","modules/admin/display_workplaces.php",true);
xmlhttp.send();

}

function showDepartments() {

	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function()  {
  		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
  			document.getElementById("adminArea").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","modules/admin/display_departments.php",true);
xmlhttp.send();

}

function checkUsername(userName,elementID) {

	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function()  {
  		if (xmlhttp.readyState==4 && xmlhttp.status==200 && xmlhttp.responseText!='OK') {
				  			
  			alert(xmlhttp.responseText);
			document.getElementByID('elementID').value='';
  			document.getElementByID('elementID').focus();

    	}
  	}
xmlhttp.open("GET","modules/system/check_user_name.php?userName="+userName,true);
xmlhttp.send();
}

function showUserDocuments(userID) {
 var Y = window.open("documents/index.php?userID="+userID);	
	
}	


