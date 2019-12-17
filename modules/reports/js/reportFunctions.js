let statusBar = document.getElementById("statusBar");
let reportArea = document.getElementById("reportArea");

function showRepSales(repID, year) {

	// Show user Graphs	
	let graphArea = document.getElementById("repGraphArea");
	// Rewrite styles to use a CSS class instead
	graphArea.style.height = '1750px';
	graphArea.style.width = '550px';
	graphArea.style.visibility = 'visible';
	
	graphArea.src = "modules/reports/get_salesrep_charts.php?year=" + year + "&userID=" + repID;

	// Show User Tables	
	// rewrite to fetch
	let rep = document.getElementById("repArea");
	fetch(`modules/reports/rep_monthly_sales.php?userID=${repID}&year=${year}`)
	.then(res => rep.innerHTML = res);

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
	// update to strict equality?
	// where does displaySheet come from?
	if (displaySheet == false) {
		
		// rewrite to fetch
		fetch(`modules/reports/display_time_sheet.php?userID=${userID}`)
		.then(res => reportArea.innerHTML = res);

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
		reportArea.innerHTML = "";
		statusBar.innerHTML = ""
		displaySheet = false;
	}

}

function showSalesReport() {

	statusBar.innerHTML = ""; // clean Status Bar

	if (salesReport == false) {
		// rewrite to fetch
		fetch(`modules/reports/display_sales_report.php`)
		.then(res => reportArea = res);
		
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
		reportArea.innerHTML = "";
		// document.getElementById("reportArea").innerHTML = "";
		salesReport = false;
	}

}

