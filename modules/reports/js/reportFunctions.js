import { get } from "../../../utils/fetchLib";

function showRepSales(repID, year) {
  // Show user Graphs

	// TODO: Rewrite styles to use a CSS class instead
  let graphArea = document.getElementById("repGraphArea");
  graphArea.style.height = "1750px";
  graphArea.style.width = "550px";
  graphArea.style.visibility = "visible";
  graphArea.src =
    "modules/reports/get_salesrep_charts.php?year=" + year + "&userID=" + repID;
  // Show User Tables
  document.getElementById("repArea").innerHTML = get(
    `modules/reports/rep_monthly_sales.php?userID=${repID}&year=${year}`
  );
}

function showTimeSheet(userID) {
  // where does displaySheet come from?
  if (!displaySheet) {
    document.getElementById("reportArea").innerHTML = get(
      `modules/reports/display_time_sheet.php?userID=${userID}`
    );
    displaySheet = true;
  } else {
    reportArea.innerHTML = "";
    statusBar.innerHTML = "";
  }
}

function showSalesReport() {
	document.getElementById("statusBar").innerHTML = "";
  let reportArea = document.getElementById("reportArea");
  if (!salesReport) {
    // rewrite to fetch
    reportArea.innerHTML = get(`modules/reports/display_sales_report.php`);
    salesReport = true;
  } else {
    reportArea.innerHTML = "";
  }
}