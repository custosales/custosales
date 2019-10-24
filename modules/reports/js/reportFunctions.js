function showRepSales(repID, year) {

	// Show user Graphs	
	document.getElementById('repGraphArea').style.height = '1750px';
	document.getElementById('repGraphArea').style.width = '550px';
	document.getElementById('repGraphArea').style.visibility = 'visible';
	document.getElementById('repGraphArea').src = "modules/reports/get_salesrep_charts.php?year=" + year + "&userID=" + repID;

	// Show User Tables	
	xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			document.getElementById("repArea").innerHTML = xmlhttp.responseText;
		}
	}

	xmlhttp.open("GET", "modules/reports/rep_monthly_sales.php?userID=" + repID + "&year=" + year, true);
	xmlhttp.send();

} // end showSalesReport


function showTimeSheet(userID) {

	if (displaySheet == false) {

		xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function () {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				document.getElementById("reportArea").innerHTML = xmlhttp.responseText;
			}
		}
		xmlhttp.open("GET", "modules/reports/display_time_sheet.php?userID=" + userID, true);
		xmlhttp.send();
		displaySheet = true;
	} else {
		document.getElementById("reportArea").innerHTML = "";
		document.getElementById("statusBar").innerHTML = ""; // clean Status Bar
		displaySheet = false;
	}

}

function showSalesReport() {

	document.getElementById("statusBar").innerHTML = ""; // clean Status Bar

	if (salesReport == false) {

		xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function () {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				document.getElementById("reportArea").innerHTML = xmlhttp.responseText;
			}
		}
		xmlhttp.open("GET", "modules/reports/display_sales_report.php", true);
		xmlhttp.send();
		salesReport = true;
	} else {
		document.getElementById("reportArea").innerHTML = "";
		salesReport = false;
	}

}

