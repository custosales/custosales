function makeAnXMLRequest(url, type = 'GET', displayElement) {
	const xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = () => {
	 if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
		 if (displayElement) {
			 document.getElementById(displayElement).innerHTML = xmlhttp.responseText;
		 }
		 return xmlhttp.responseText;
	 } 
	}
	xmlhttp.open(type, url, true);
	xmlhttp.send();
}

function showDatePicker(fieldID) {
	$(function() {
		$.datepicker.setDefaults( $.datepicker.regional[ lang ] );
		let field = "#"+fieldID;
			$(field).datepicker({ 
			changeMonth: true,
			changeYear: true		
		});
		
		});
}


function getFromBrreg(regNumber) {
	
	if(!regNumber) {
		alert(insert_regnumber);
		document.getElementById("value1").focus();
		exit;	
	}
		const companyName = makeAnXMLRequest(`modules/sales/get_company_name.php?regNumber=${regNumber}`);
			if (companyName === "na") {
				getFromBrregReal(regNumber)
			} else {
			let updateText = `Oppdatere ${companyName} fra Brreg?`,
			 headingText = "Oppdatere fra Brreg";
					jConfirm(updateText, headingText, (y) => {
					if (y) {
						getFromBrregReal(regNumber)
					}
				});
			}						
		 }

function getFromBrregReal(regNumber) {
		
                            
$.getJSON("http://data.brreg.no/enhetsregisteret/enhet/"+regNumber+".json", (json) =>{
		const {
			navn,
			organisasjonsform,
			epost,
			hjemmeside,
			telefon,
			postadresse,
			forretningsadresse,
			naeringskode1,
		} = json; 
    	document.getElementById("value2").value = navn;		
		document.getElementById("value4").value = organisasjonsform;		
		document.getElementById("value5").value = epost;		
		document.getElementById("value6").value = hjemmeside;	
		document.getElementById("value7").value = telefon;	
		document.getElementById("value8").value = '8';	
		document.getElementById("value9").value = '9';
		document.getElementById("value10").value = forretningsadresse.adresse;		
	 	document.getElementById("value11").value = postadresse.adresse;
		document.getElementById("value12").value = postadresse.postnummer;		
		document.getElementById("value13").value = postadresse.poststed;		
		document.getElementById("value15").value = '15';
		document.getElementById("value16").value = '16';
		document.getElementById("value17").value = '17';
		document.getElementById("value18").value = naeringskode1.kode;
		document.getElementById("value19").value = naeringskode1.beskrivelse;
		const now = new Date();		
		document.getElementById("value24").value = now.getFullYear()+'-'+(now.getMonth()+1)+'-'+now.getDate();	
}); 
 
}

async function editItem(itemType, action, itemID) {

	let addHeading = eval("add"+itemType.substring(0, itemType.length-1)); 	
	let editHeading = eval("edit"+itemType.substring(0, itemType.length-1));
	
	if (action === "add") {
	document.getElementById('actionHeader').innerHTML=addHeading;
	}
	if (action === "edit") {
	document.getElementById('actionHeader').innerHTML=editHeading;
	}
	

	const data = makeAnXMLRequest(`modules/admin/edit_item.php?itemType=${itemType}&action=${action}&itemID=${itemID}`);
			if (action ==="edit" || action ==="add") {
    			document.getElementById("actionArea").innerHTML = await data;

		    	if (itemType==='Users') {	// register Date Pickers for user form
    			showDatePicker('value9');
    			showDatePicker('value10');
    			}

				if (itemType==='Projects') {	// register Date Pickers for user form
    			showDatePicker('value3');
    			showDatePicker('value4');
    			}

				if (itemType==='Companies') {	// register Date Pickers for company form
    			showDatePicker('value15');
    			showDatePicker('value16');
    			showDatePicker('value20');
    			showDatePicker('value21');
    			showDatePicker('value24');
    			}

    			
			} 
			if (action==="delete") { 
				document.getElementById("statusBar").innerHTML = await data;				
			}
     }


function deleteItem(itemType,itemID,deleteText,headingText) {
// TODO> Locate showadminarea, refactor eval.
// Move confirm out of jquery and use makeanxmlrequest function.
document.getElementById("statusBar").innerHTML=""; // clean Status Bar
let xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function()  {
  		if (xmlhttp.readyState===4 && xmlhttp.status===200) {
				document.getElementById("statusBar").innerHTML=xmlhttp.responseText;				
			ShowAdminArea = false;			
			 eval("show"+itemType+"()");  // Show updated records

     }
  }

	jConfirm(deleteText, headingText, function(y) {
		if(y===true) {
		xmlhttp.open("GET","modules/admin/edit_item.php?itemType="+itemType+"&action=delete&itemID="+itemID,true);
		xmlhttp.send();		
		}
	});
	
	
}

function saveItem(itemType, action, itemID, valueNumber) {

document.getElementById("statusBar").innerHTML=""; // clean Status Bar

let  valueStr = '"'+document.getElementById('value1').value+'"|';

for(i=2;i<valueNumber;i++) {
	
		if(document.getElementById('value'+i).getAttribute('type') === 'checkbox') {  
			valueStr += '"'+document.getElementById('value'+i).checked+'"|';			
		} else if (document.getElementById('value'+i).getAttribute('name') === 'roles' || document.getElementById('value'+i).getAttribute('name') === 'projectOrderStages' || document.getElementById('value'+i).getAttribute('name') === 'projectSalesStages' || document.getElementById('value'+i).getAttribute('name') === 'roleCallingLists'  ) { 
			let selObj = document.getElementById('value'+i);
			let a = 0;
			let selectedStr="";
  			
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

		const url = `modules/admin/save_item.php?itemType=${itemType}&action=${action}&itemID=${itemID}&values=${valueStr}`
	makeAnXMLRequest(url, 'GET', 'statusBar');
			ShowAdminArea = false;			
			 eval("show"+itemType+"()");  // Show updated records
		     
     }

function listContacts(companyID,contactsHeading) {

document.getElementById("statusBar").innerHTML=""; // clean Status Bar
document.getElementById('actionHeader').innerHTML=contactsHeading;

	makeAnXMLRequest(`modules/admin/list_contacts.php?companyID=${companyID}`, 'GET', 'actionArea')
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
function displayContactData(contactID) {
	
	
}

function showPreferences() {
	document.getElementById("statusBar").innerHTML=""; // clean Status Bar
	makeAnXMLRequest(`modules/admin/display_preferences.php`, 'GET', 'adminArea');
}

function savePreferences() {
	const companyName = document.getElementById('companyName').value,
		companyRegNumber = document.getElementById('companyRegNumber').value,
		companyAddress = document.getElementById('companyAddress').value,
	companyZip = document.getElementById('companyZip').value,
		companyCity = document.getElementById('companyCity').value,
		companyPhone = document.getElementById('companyPhone').value,
		companyEmail = document.getElementById('companyEmail').value,
		companyInternet = document.getElementById('companyInternet').value,
		companyFax = document.getElementById('companyFax').value,
		companyChatDomain = document.getElementById('companyChatDomain').value,
		defaultCurrency = document.getElementById('defaultCurrency').value,
		defaultCreditDays = document.getElementById('defaultCreditDays').value,
		companyBankAccount = document.getElementById('companyBankAccount').value,
		companyManagerID = document.getElementById('companyManagerID').value,
		queryString = "?companyName=" + encodeURIComponent(companyName) + 
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

makeAnXMLRequest(`modules/admin/save_preferences.php${queryString}`, 'GET', 'statusBar')
}

function showProductCategories() {
	makeAnXMLRequest(`modules/admin/display_product_categories.php`, 'GEt', 'adminArea');
}
function showProducts() {
	makeAnXMLRequest(`modules/admin/display_products.php`, 'GET', 'adminArea')
}
function showContacts(contactType) {
	makeAnXMLRequest(`modules/admin/display_contacts.php?contactType=${contactType}`, 'GET', 'adminArea')
}

function showUsers() {
	makeAnXMLRequest(`modules/admin/display_users.php`, 'GET', 'adminArea')
}

function showUserDocuments(userID) {
	// TODO: eliminate/locate userid variable
		makeAnXMLRequest(`modules/system/display_user_documents.php`, 'GET', 'adminArea')
}
function showLinks() {
	makeAnXMLRequest(`modules/admin/display_links.php`, 'GET', 'adminArea');
}
function showProjects() {
	makeAnXMLRequest(`modules/admin/display_projects.php`, 'GET', 'adminArea');
}

function showClients(companyStatus,salesRepID) {
	const url = `modules/admin/display_clients.php?companyStatus=${companyStatus}&salesRepID=${salesRepID}`
	makeAnXMLRequest(url, 'GET', 'adminArea')
				// TODO: locate contactsTable.
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

function showSalesStages() {
makeAnXMLRequest(`modules/admin/display_sales_stages.php`, 'GET', 'adminArea');
}
function showContactTypes() {
		makeAnXMLRequest(`modules/admin/display_contact_types.php`, 'GET', 'adminArea')
}
function showRoles() {
	makeAnXMLRequest("modules/admin/display_roles.php", 'GET', 'adminArea');
}
function showOrderStages(){
	makeAnXMLRequest(`modules/admin/display_order_stages.php`, 'GET', 'adminArea');
}

function showCallingLists(){
	makeAnXMLRequest("modules/admin/display_calling_lists.php", 'GET', 'adminArea');
}

function showCurrencies() {
	makeAnXMLRequest("modules/admin/display_currencies.php", 'GET', 'adminArea');
}

function showContracts() {
	makeAnXMLRequest("modules/admin/display_contracts.php", 'GET', 'adminArea');
}

function showWorkplaces() {
	makeAnXMLRequest("modules/admin/display_workplaces.php", 'GET', 'adminArea');
}

function showDepartments() {
	makeAnXMLRequest(`modules/admin/display_departments.php`, 'GET', 'adminArea');
}

function checkUsername(userName,elementID) {
		const data = makeAnXMLRequest(`modules/system/check_user_name.php?userName=${userName}`)
  		if (data !=='OK') {
  			alert(data);
				document.getElementByID('elementID').value='';
				document.getElementByID('elementID').focus();
				return false;
			}
			return true;
}
function showUserDocuments(userID) {
	// TODO: move action out of variable?
 let Y = window.open("documents/index.php?userID="+userID);	
}	


