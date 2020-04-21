import { get } from "../utils/fetchLib";
import { encodeElement } from "../utils/encoder";

// TODO: Find a non-global home for these variables.
var displaySheet = false;
var salesReport = false;
var templates = false;

function showSalesListWidget(projectID) {
  document.getElementById("salesListWidgetArea").innerHTML = get(
    `widgets/sales_list_widget.php?projectID=${projectID}`
  );
}

function registerCallBack(regNumber, callDate) {
  get(
    `modules/sales/save_callback_date.php?regNumber=${regNumber}&callDate=${callDate}`
  ).then((res) => {
    document.getElementById("lastContacted").innerHTML = res;
    if (callDate == "0000-00-00") {
      document.location = "index.php";
    }
  });
}

function showDatePicker(fieldID) {
  $(function () {
    $.datepicker.setDefaults($.datepicker.regional[lang]);
    var field = "#" + fieldID;
    $(field).datepicker($.datepicker.regional[lang]);
  });
}

function showProfile(userID) {
  document.getElementById("adminArea").innerHTML = get(
    `modules/system/display_user_profile.php`
  );
}

function showUserDocuments(userID) {
  document.getElementById("adminArea").innerHTML = get(
    "modules/system/display_user_documents.php"
  );
}

function punch(Type, userID) {
  document.getElementById("statusBar").innerHTML = ""; // clean Status Bar
  document.getElementById("punchArea").innerHTML = get(
    `modules/system/punch.php?Type=${Type}&userID=${userID}`
  );
}

function getRepSales(year) {
  document.getElementById("salesGraph").innerHTML = get(
    `modules/sales/get_sales_charts.php?year=${year}`
  );
}

// Graph Functions
function show(showType) {
  document.getElementById("graphFrame").src =
    "modules/orders/get_order_charts.php?orderStatusID=" + showType;
}

function editUserPhoto(userID) {
  window.open(
    "documents/index.php?photo=userphoto/&userID=" + userID,
    "",
    "titlebar=no,location=no,top=50,left=200,height=300,width=700"
  );
}

function saveUserProfile() {
  let url = "modules/system/save_user_profile.php";

	let params = `fullName=${encodeElement("fullName")}
								&userEmail=${encodeElement("userEmail")}
								&address=${encodeElement("address")}
								&zipCode=${encodeElement("zipCode")}
								&city=${encodeElement("city")}
								&phone=${encodeElement("phone")}
								&mobilePhone=${encodeElement("mobilePhone")}`;

	fetch(url, {
		method: 'POST',
		body: params,
		headers: {
			'Content-Type': "application/x-www-form-urlencoded",
			"Content-length": params.length,
			"Connection": "close"
		},
	})
	.then(res => document.getElementById('statusBar').innerHTML = res.text());
}
