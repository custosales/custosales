import { get } from "../../../utils/fetchLib";

function sendOrderConfirmation() {
  let recipient = document.getElementById("recipient");

  if (!recipient.value) {
    alert("obs: Ingen mottaker");
    recipient.focus();
    return;
  }
  let recipientEmail = document.getElementById("recipientEmail");
  if (!recipientEmail.value) {
    alert("obs: Ingen Epostadresse...");
    recipientEmail.focus();
    return;
  }

  document.orderConfirmationForm.submit();
}

function getOrder(orderID) {
  // avoid inline styles, add a visible class to CSS.
  document.getElementById("allButton").style.visibility = "visible";
  fetch(`modules/orders/display_order.php?orderID=${orderID}`).then((res) => {
    if (res.status === 200) {
      document.getElementByI("list").innerHTML = res;
      $("#datepicker").datepicker();
    }
  });
  document.getElementById("statusBar").innerHTML = "";
}

function setPrice(priceID) {
  document.getElementById("unitPrice").value = price[priceID];
}

function saveOrder() {
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
  document.getElementById("statusBar").innerHTML = get(
    `modules/orders/process_order.php${queryString}`
  );
}

$(function () {
  $.datepicker.setDefaults($.datepicker.regional["no"]);
  $("#orderDate").datepicker($.datepicker.regional["no"]);
});

function deleteOrder(companyName, orderStatusID, orderID) {
  jConfirm(
    "<?php print $LANG['confirm_delete_order']; ?> " + companyName + " ?",
    "<?php print $LANG['confirm_delete_heading'];?>",
    function (y) {
      if (y == true) {
        // !! This could be rewritten to an http delete request.
        document.getElementById("statusBar").innerHTML = get(
          `modules/orders/delete_order.php?orderID=${orderID}`
        ).then(() => showOrders(orderStatusID));
      }
    }
  );
}

function convertOrderStatus(orderID, orderStatusID) {
  // avoid inline styles, rewrite to class
  document.getElementById("allButton").style.visibility = "visible";
  document.getElementById("statusBar").innerHTML = get(
    `modules/orders/convert_order_status.php?orderID=${orderID}&orderStatusID=${orderStatusID}`
  );
}

function convertSalesRepID(orderID, salesRepID) {
  document.getElementById("allButton").style.visibility = "visible";
  document.getElementById("statusBar").innerHTML = get(
    `modules/orders/convert_sales_rep.php?orderID=${orderID}&salesRepID=${salesRepID}`
  );
}

export function showOrders(orderStatusID) {
  if (orderStatusID !== "all") {
    getOrderName(orderStatusID);
  } else {
    document.getElementById("heading").innerHTML =
      "<?php print $LANG['all_orders'];?>";
  }

	get(`modules/orders/convert_sales_rep.php?orderID=${orderID}&salesRepID=${salesRepID}`)
	.then(res => {
		document.getElementById('list').innerHTML = res;
		oTable = $("#example").dataTable({
			bJQueryUI: true,
			bStateSave: true,
			iDisplayLength: 25,
			sPaginationType: "full_numbers",
			oLanguage: {
				sLengthMenu: lLengthMenu,
				sZeroRecords: lZeroRecords,
				sInfo: lInfo,
				sInfoEmpty: lInfoEmpty,
				sInfoFiltered: lInfoFiltered,
				sSearch: lSearch,
				oPaginate: {
					sFirst: lFirst,
					sPrevious: lPrevious,
					sNext: lNext,
					sLast: lLast,
				},
			},
		});
	})
  document.getElementById("data").innerHTML = "";
  document.getElementById("iFrame").src = "";
  document.getElementById("allButton").style.visibility = "hidden";
}

function getOrderName(orderStatusID) {
  document.getElementById('heading').innerHTML = get(
    `modules/orders/get_order_name.php?orderStatusID=${orderStatusID}`
  )
}
