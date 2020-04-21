import { get } from "../../../utils/fetchLib";
import { showOrders } from "../../orders/js/orderFunctions";

function sendInvoice() {
  let recipient = document.getElementById("recipient");
  if (recipient.value === "") {
    alert("obs: Ingen mottaker");
    recipient.focus();
    return;
  }
  let recipientEmail = document.getElementById("recipientEmail");
  if (recipientEmail.value === "") {
    alert("obs: Ingen Epostadresse...");
    recipientEmail.focus();
    return;
  }

  //
  document.orderConfirmationForm.submit();
}

function getOrder(orderID) {
  // avoid in-line styles. rewrite to class.
  // document.getElementById("allButton").style.visibility='visible';
  document.getElementById("allButton").classList.add("visible-class");
  get(`modules/orders/display_order.php?orderID=${orderID}`)
  .then((res) => {
    document.getElementById("list").innerHTML = res;
    $("#datepicker").datepicker();
    document.getElementById("statusBar").innerHTML = "";
  });
}

function saveInvoice() {
  let queryString =
    "?orderDate=" +
    encodeURIComponent(document.getElementById("orderDate").value) +
    "&unitPrice=" +
    encodeURIComponent(document.getElementById("unitPrice").value) +
    "&orderComments=" +
    encodeURIComponent(document.getElementById("orderComments").value) +
    "&creditDays=" +
    encodeURIComponent(document.getElementById("creditDays").value) +
    "&otherTerms=" +
    encodeURIComponent(document.getElementById("otherTerms").value) +
    "&customerContact=" +
    encodeURIComponent(document.getElementById("customerContact").value) +
    "&productID=" +
    encodeURIComponent(document.getElementById("productID").value) +
    "&regNumber=" +
    encodeURIComponent(document.getElementById("regNumber").value) +
    "&orderID=" +
    encodeURIComponent(document.getElementById("orderID").value);
 
    document.getElementById('statusBar').innerHTML = get(
    `modules/invoices/process_invoice.php${queryString}`,
  );
}
// TODO: Should this run inside a function?
$(function () {
  $.datepicker.setDefaults($.datepicker.regional["no"]);
  $("#orderDate").datepicker($.datepicker.regional["no"]);
});

async function deleteOrder(
  companyName,
  invoiceID,
  confirm_delete_heading,
  confirm_delete_invoice
) {
  jConfirm(
    `${confirm_delete_invoice} ${companyName}?`,
    confirm_delete_heading,
    (y) => {
      if (y) {
        document.getElementById('statusBar').innerHTML = await get(
          `modules/orders/delete_invoice.php?invoiceID=${invoiceID}`
        )
    // TODO: Needs a rewrite to get sequence in order.
		if (data) {
			// TODO: orderStatusID is not a global variable. Possibly rewrite to invoiceID.
			showOrders(orderStatusID);
		} 
      }
    }
  );
}

function convertOrderStatus(orderID, orderStatusID) {
  // rewrite to CSS class
  document.getElementById("allButton").style.visibility = "visible";
	document.getElementById('statusBar').innerHTML = get(
		`modules/orders/convert_order_status.php?orderID=${orderID}&orderStatusID=${orderStatusID}`
	);
}

function showInvoices() {
  get("modules/invoices/display_invoices.php")
  .then(res => {
    document.getElementById('list').innerHTML = res;
    oTable = $("#example").dataTable({
      bJQueryUI: true,
      bStateSave: true,
      iDisplayLength: 25,
      sPaginationType: "full_numbers",
      oLanguage: {
        sLengthMenu: "<?php print $LANG['LengthMenu']; ?>",
        sZeroRecords: "<?php print $LANG['ZeroRecords']; ?>",
        sInfo: "<?php print $LANG['Info']; ?>",
        sInfoEmpty: "<?php print $LANG['InfoEmpty']; ?>",
        sInfoFiltered: "<?php print $LANG['InfoFiltered']; ?>",
        sSearch: "<?php print $LANG['search']; ?>",
        oPaginate: {
          sFirst: "<?php print $LANG['First']; ?>",
          sPrevious: "<?php print $LANG['Previous']; ?>",
          sNext: "<?php print $LANG['Next']; ?>",
          sLast: "<?php print $LANG['Last']; ?>",
        },
      },
    });
  });
  document.getElementById("data").innerHTML = "";
  document.getElementById("iFrame").src = "";
  document.getElementById("allButton").style.visibility = "hidden";
}
