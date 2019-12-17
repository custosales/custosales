let statusBar = document.getElementById("statusBar");

function sendInvoice() {
	let recipient = document.getElementById("recipient");
	if (recipient.value === '') {
		alert("obs: Ingen mottaker");
		recipient.focus()
		return;
	}
	let recipientEmail = document.getElementById("recipientEmail");
	if (recipientEmail.value === "") {
		alert("obs: Ingen Epostadresse...");
		recipientEmail.focus()
		return;
	}

	// 
document.orderConfirmationForm.submit();
	
}

function getOrder (orderID) {
	// avoid in-line styles. rewrite to class.
	// document.getElementById("allButton").style.visibility='visible';
	let allBtn = document.getElementById("allButton");
		allBtn.classList.add("visible-class");

	let list = document.getElementById("list");
	fetch(`modules/orders/display_order.php?orderID=${orderID}`)
	.then(res => list.innerHTML = res)
	// rewrite to fetch
	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function()  {
	if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		document.getElementById("list").innerHTML=xmlhttp.responseText;
			$( "#datepicker" ).datepicker();
		}
	}
	xmlhttp.open("GET","modules/orders/display_order.php?orderID="+orderID,true);
	xmlhttp.send();
	statusBar.innerHTML = "";

}	



function saveInvoice() {
	let queryString = "?orderDate=" + encodeURIComponent(document.getElementById("orderDate").value) + 
	"&unitPrice=" + encodeURIComponent(document.getElementById("unitPrice").value) +
	"&orderComments=" + encodeURIComponent(document.getElementById("orderComments").value) +
	"&creditDays=" + encodeURIComponent(document.getElementById("creditDays").value) +
	"&otherTerms=" + encodeURIComponent(document.getElementById("otherTerms").value) +
	"&customerContact=" + encodeURIComponent(document.getElementById("customerContact").value) +
	"&productID=" + encodeURIComponent(document.getElementById("productID").value) +
	"&regNumber=" + encodeURIComponent(document.getElementById("regNumber").value) +
	"&orderID=" + encodeURIComponent(document.getElementById("orderID").value)  	
	;
	
	fetch(`modules/invoices/process_invoice.php${queryString}`)
	.then(res => statusBar.innerHTML = res);
	// rewrite to fetch
// 	xmlhttpi=new XMLHttpRequest();
// 	xmlhttpi.onreadystatechange=function()
// 	  {
// 	  if (xmlhttpi.readyState==4 && xmlhttpi.status==200)
// 		{
// 		document.getElementById("statusBar").innerHTML=xmlhttpi.responseText;
// 		}
// 	  }

// xmlhttpi.open("GET","modules/invoices/process_invoice.php"+queryString,true);
// xmlhttpi.send();


}



	$(function() {
		$.datepicker.setDefaults( $.datepicker.regional[ "no" ] );
		$( "#orderDate" ).datepicker( $.datepicker.regional[ "no" ] );	
		});




function deleteOrder(companyName, invoiceID, confirm_delete_heading, confirm_delete_invoice) {


	jConfirm(confirm_delete_invoice+" "+companyName+" ?", confirm_delete_heading, function(y) {
		if(y === true) {
		fetch(`modules/orders/delete_invoice.php?invoiceID=${invoiceID}`)
		.then(res => statusBar.innerHTML = res)
		.then(() => showOrders(orderStatusID));
	// 	xmlhttp=new XMLHttpRequest();
	// 	xmlhttp.onreadystatechange=function()  {
	//   		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
	//     document.getElementById("statusBar").innerHTML=xmlhttp.responseText;
	//     showOrders(orderStatusID);
	//     }
	//   }
	// xmlhttp.open("GET","modules/orders/delete_invoice.php?invoiceID="+invoiceID,true);
	// xmlhttp.send();
		}
			
		
	});
}


function convertOrderStatus(orderID, orderStatusID) {
	// rewrite to CSS class
	document.getElementById("allButton").style.visibility='visible';
	
	fetch(`modules/orders/convert_order_status.php?orderID=${orderID}&orderStatusID=${orderStatusID}`)
	.then(res => statusBar.innerHTML = res);
	
// xmlhttpi=new XMLHttpRequest();
// xmlhttpi.onreadystatechange=function()
//   {
//   if (xmlhttpi.readyState==4 && xmlhttpi.status==200)
//     {
//     document.getElementById("statusBar").innerHTML=xmlhttpi.responseText;
//     }
//   }
// xmlhttpi.open("GET","modules/orders/convert_order_status.php?orderID="+orderID+"&orderStatusID="+orderStatusID,true);
// xmlhttpi.send();


}


function showInvoices() {

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
xmlhttp2.open("GET","modules/invoices/display_invoices.php",true);
xmlhttp2.send();
document.getElementById("data").innerHTML=""
document.getElementById("iFrame").src=""
document.getElementById("allButton").style.visibility='hidden';

}	
	
	