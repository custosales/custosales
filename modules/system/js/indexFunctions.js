var displaySheet = false;
var salesReport = false;
var templates = false;


function showSalesListWidget(projectID) {

    xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("salesListWidgetArea").innerHTML = xmlhttp.responseText;

        }
    }
    xmlhttp.open("GET", "widgets/sales_list_widget.php?projectID=" + projectID, true);
    xmlhttp.send();

}

function registerCallBack(regNumber, callDate) {
    xmlhttpi = new XMLHttpRequest();
    xmlhttpi.onreadystatechange = function() {
        if (xmlhttpi.readyState == 4 && xmlhttpi.status == 200) {
            document.getElementById("lastContacted").innerHTML = xmlhttpi.responseText;
            if (callDate == "0000-00-00") {
                document.location = 'index.php';
            }
        }
    }
    xmlhttpi.open("GET", "modules/sales/save_callback_date.php?regNumber=" + regNumber + "&callDate=" + callDate, true);
    xmlhttpi.send();



}



function showDatePicker(fieldID) {
    $(function() {
        $.datepicker.setDefaults($.datepicker.regional[lang]);
        var field = "#" + fieldID;
        $(field).datepicker($.datepicker.regional[lang]);
    });
}




function showProfile(userID) {

    xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("adminArea").innerHTML = xmlhttp.responseText;

        }
    }
    xmlhttp.open("GET", "modules/system/display_user_profile.php", true);
    xmlhttp.send();

}

function showUserDocuments(userID) {

    xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("adminArea").innerHTML = xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET", "modules/system/display_user_documents.php", true);
    xmlhttp.send();

}



function punch(Type, userID) {

    document.getElementById("statusBar").innerHTML = ""; // clean Status Bar

    xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("punchArea").innerHTML = xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET", "modules/system/punch.php?Type=" + Type + "&userID=" + userID, true);
    xmlhttp.send();
}





function getRepSales(year) {

    xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("salesGraph").innerHTML = xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET", "modules/sales/get_sales_charts.php?year=" + year, true);
    xmlhttp.send();

}




// Graph Functions

function show(showType) {

    document.getElementById("graphFrame").src = "modules/orders/get_order_charts.php?orderStatusID=" + showType

} // end function show

function editUserPhoto(userID) {
    window.open("documents/index.php?photo=userphoto/&userID=" + userID, '', "titlebar=no,location=no,top=50,left=200,height=300,width=700")
}


function saveUserProfile() {

    var url = "modules/system/save_user_profile.php";

    var params = "fullName=" + encodeURIComponent(document.getElementById('fullName').value);
    params += "&userEmail=" + encodeURIComponent(document.getElementById('userEmail').value);
    params += "&address=" + encodeURIComponent(document.getElementById('address').value);
    params += "&zipCode=" + encodeURIComponent(document.getElementById('zipCode').value);
    params += "&city=" + encodeURIComponent(document.getElementById('city').value);
    params += "&phone=" + encodeURIComponent(document.getElementById('phone').value);
    params += "&mobilePhone=" + encodeURIComponent(document.getElementById('mobilePhone').value);


    http = new XMLHttpRequest();

    http.open("POST", url, true);

    // Send the proper header information along with the request
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.setRequestHeader("Content-length", params.length);
    http.setRequestHeader("Connection", "close");

    http.onreadystatechange = function() { //Call a function when the state changes.

        if (http.readyState == 4 && http.status == 200) {

            document.getElementById('statusBar').innerHTML = http.responseText;

        }
    }

    http.send(params);

} // end saveUserProfile function