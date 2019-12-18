let statusBarL = document.getElementById("statusBar");
let reportAreaL = document.getElementById("reportArea");

function showRepSales(repID, year) {

    // Show user Graphs	
    let graphAreaL = document.getElementById("repGraphArea");
    // Rewrite styles to use a CSS class instead
    graphAreaL.style.height = '1750px';
    graphAreaL.style.width = '550px';
    graphAreaL.style.visibility = 'visible';

    graphAreaL.src = "modules/reports/get_salesrep_charts.php?year=" + year + "&userID=" + repID;

    // Show User Tables	
    // rewrite to fetch
    let repL = document.getElementById("repArea");
    fetch(`modules/reports/rep_monthly_sales.php?userID=${repID}&year=${year}`)
        .then(res => repL.innerHTML = res);

    xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
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
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("reportArea").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "modules/reports/display_time_sheet.php?userID=" + userID, true);
        xmlhttp.send();
        displaySheet = true;
    } else {
        reportAreaL.innerHTML = "";
        statusBarL.innerHTML = ""
        displaySheet = false;
    }

}

function showSalesReport() {

    statusBarL.innerHTML = ""; // clean Status Bar

    if (salesReport == false) {
        // rewrite to fetch
        fetch(`modules/reports/display_sales_report.php`)
            .then(res => reportAreaL = res);

        xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("reportArea").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "modules/reports/display_sales_report.php", true);
        xmlhttp.send();
        salesReport = true;
    } else {
        reportAreaL.innerHTML = "";
        // document.getElementById("reportArea").innerHTML = "";
        salesReport = false;
    }

}