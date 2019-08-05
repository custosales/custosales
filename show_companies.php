<?php session_start(); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <script language="javascript" type="text/javascript" src="lib/indexFunctions.js"></script>
        <?php include_once('head.php'); ?>
    </head>
    <body style="font-size:12px">
        <?php
        include_once("menu.php");
                $companyStatus = $_GET['status'];
        $regNumber = $_GET['regNumber'];

        if ($_GET['regNumber'] == "") {
// set icon for customers
            if ($companyStatus == $LANG['customer']) {
                $salesStageIcon = "folder_yellow_22.png";
            } else {

// set salesStageIcon
                $queryi = "SELECT salesStageIcon FROM " . $salesstages . " WHERE salesStageID=" . $companyStatus;

                try {
                    $stmt = $pdo->prepare($queryi);
                    $stmt->execute();
                    $Rowi = $stmt->fetch(PDO::FETCH_ASSOC);
                } catch (PDOException $e) {
                    echo "Data was not fetched, because: " . $e->getMessage();
                }

                $salesStageIcon = str_replace('32', '22', $Rowi['salesStageIcon']);
            }
        } // end if no regnumber
        ?>

        <div id="main_table">

            <h1 class="ui-widget-header ui-corner-all" style="padding:3px;width:100%"><span id="heading"><?php print $heading1; ?></span> 
                <img id="logoIcon" src="" align="left" alt="Logo" style="border:0px;vertical-align:middle;margin-left:10px;margin-top:5px;"/>&nbsp;
                <input id="allButton" class="ui-button ui-button-text-only ui-widget ui-state-default ui-corner-all" style="font-size:13px;padding:4px;width:80px" onclick="showCustomers(document.getElementById('status').value)" value="<?php print $LANG['show_all']; ?>"> 
                &nbsp; 

                <select id="status" name="status" onchange="javaScript:showCustomers(this.value)">

<?php
$selected = "";
// Get sales Stages for project
if ($_SESSION['project'] != "" && $_SESSION['project'] != "all") {

    $queryStages = "SELECT projectSalesStages FROM " . $projects . " WHERE projectID=:project";

    try {
        $stmt = $pdo->prepare($queryStages);
        $stmt->bindParam(':project', $_SESSION['project']);
        $stmt->execute();
        $RowStages = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Data was not fetched, because: " . $e->getMessage();
    }

    $stageStr = "=" . str_replace(",", " OR salesStageID=", $RowStages['projectSalesStages']) . "";

    $querys = "SELECT * FROM " . $salesstages . " WHERE salesStageID " . $stageStr . " ORDER by salesStageID";
} else { // Get all relevant sales stages for the role of the user 
    $querys = "SELECT * FROM " . $salesstages . " ORDER by salesStageID";
}

try {
    $results = $pdo->query($querys);
} catch (PDOException $e) {
    echo "Data was not fetched, because: " . $e->getMessage();
}

foreach ($results as $Rows) {

    if ($Rows['salesStageID'] == $Row['companyStatus']) {
        $selected = "selected";
    } else {
        $selected = "";
    }

    $statusName = $Rows['salesStageName'];
    ?>
                        <option id="<?php print $Rows['salesStageID']; ?>" value="<?php print $Rows['salesStageID']; ?> <?php print str_replace('32', '22', $Rows['salesStageIcon']); ?>"  <?php print $selected; ?> ><?php print $statusName; ?></option>
                    <?php } ?>
                    <option id="<?php print $LANG['customer']; ?>" value="<?php print $LANG['customer']; ?> folder_yellow_22.png"  <?php print $selected; ?> ><?php print $LANG['customer']; ?></option>

                </select>
                &nbsp;
                <a href="#" onclick="document.getElementById('salesArea').style.height = '1px';document.getElementById('salesArea').innerHTML = '';registerSale(document.getElementById('regNumber').innerHTML)"><img id="registerSaleButton" src="images/sales_32.png" style="border:0px;vertical-align:middle;visibility:hidden" title="<?php print $LANG['register_sale']; ?>"  alt="<?php print $LANG['register_sale']; ?>" ></a>
                &nbsp;
                <a href="#" onclick="saveCallingDate(document.getElementById('regNumber').innerHTML)" ><img id="registerCallButton" src="images/voicecall_32.png" style="border:0px;vertical-align:middle;visibility:hidden" title="<?php print $LANG['register_calling_date']; ?>" alt="<?php print $LANG['register_calling_date']; ?>" /></a>

<?php print($LANG['project'] . ": " . $_SESSION['projectName']); ?>


            </h1>


            <div id="list" style="padding-bottom:10px;"></div>
            <div class="clear" style="height:5px;"></div>
            <div id="graphHead" style="visibility:hidden;margin:0px"><h1><?php print $LANG['graphs_overview']; ?></h1></div>

            <iframe src="" id="graphs" style="border:0;width:100%;height:100px;float:left;">

            </iframe>


            <div id="data" style="width:100%"></div>


        </div>




        <script type="text/javascript">


            function showDatePicker(fieldID) {
                $(function () {
                    $.datepicker.setDefaults($.datepicker.regional[ lang ]);
                    var field = "#" + fieldID;
                    $(field).datepicker({
                        changeMonth: true,
                        changeYear: true
                    });

                });
            }

            var buttonValue = "down";



            function maxNotes() {
                if (buttonValue == "down") {
                    document.getElementById("notes").style.height = "450px";
                    document.getElementById("notesButton").src = "images/go_up_16.png"
                    buttonValue = "up";
                } else {
                    document.getElementById("notes").style.height = "130px";
                    document.getElementById("notesButton").src = "images/go_down_16.png"
                    buttonValue = "down";
                }

            }

            function deleteCustomer(regNumber, companyName, companyStatus, ID, tableName) {

                jConfirm("<?php print $LANG['confirm_delete']; ?> " + companyName + "<?php print $LANG['back_to_callinglist']; ?> ?", "<?php print $LANG['confirm_delete_heading']; ?>", function (y) {
                    if (y === true) {
                        xmlhttp = new XMLHttpRequest();
                        xmlhttp.onreadystatechange = function () {
                            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                                document.getElementById("statusBar").innerHTML = xmlhttp.responseText;
                                showCustomers(companyStatus);
                            }
                        };
                        xmlhttp.open("GET", "modules/sales/delete_customer.php?regNumber=" + regNumber + "&redirect=" + companyStatus + "&ID=" + ID + "&tableName=" + tableName, true);
                        xmlhttp.send();
                    }
                });

            }


            function getProff(regNumber) {
                document.getElementById("graphs").style.height = '1500px';
                //document.getElementById("graphHead").innerHTML='<h1>Informasjon fra Proff</h1>';
                document.getElementById("graphs").src = 'http://www.proff.no/bransjes%C3%B8k?q=' + regNumber;

            }


            function getCustomer(regNumber) {
                document.getElementById("graphHead").style.visibility = 'hidden';
                document.getElementById("allButton").style.visibility = 'visible';
                document.getElementById("registerSaleButton").style.visibility = 'visible';
                document.getElementById("registerCallButton").style.visibility = 'hidden';


                xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function () {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        document.getElementById("list").innerHTML = xmlhttp.responseText;
                        showDatePicker('callBackDate');
                        salesTable = $('#sales').dataTable({
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
                                    "sFirst": lFirst,
                                    "sPrevious": lPrevious,
                                    "sNext": lNext,
                                    "sLast": lLast
                                }
                            }
                        });
                    }
                }
                xmlhttp.open("GET", "modules/sales/display_customer_data.php?regnumber=" + regNumber, true);

                xmlhttp.send();
                document.getElementById("statusBar").innerHTML = "";

            }


            function convertStatus(regNumber, companyStatus)
            {

                document.getElementById("graphHead").style.visibility = 'hidden';
                document.getElementById("allButton").style.visibility = 'visible';



                xmlhttpi = new XMLHttpRequest();
                xmlhttpi.onreadystatechange = function ()
                {
                    if (xmlhttpi.readyState == 4 && xmlhttpi.status == 200)
                    {
                        document.getElementById("statusBar").innerHTML = xmlhttpi.responseText;
                    }
                }
                xmlhttpi.open("GET", "modules/sales/convert_customer_status.php?regNumber=" + regNumber + "&companyStatus=" + companyStatus, true);
                xmlhttpi.send();

                getCustomer(regNumber);

            }


            function loadInfo()
            {
                xmlhttpi = new XMLHttpRequest();
                xmlhttpi.onreadystatechange = function ()
                {
                    if (xmlhttpi.readyState == 4 && xmlhttpi.status == 200)
                    {
                        document.getElementById("list").innerHTML = xmlhttpi.responseText;
                    }
                }
                xmlhttpi.open("GET", "modules/sales/get_info.php?regnumber=" + document.getElementById('regButton').value, true);
                xmlhttpi.send();
                document.getElementById("statusBar").innerHTML = "";

            }


            function editCompany() {

                if (document.getElementById("companySaveContactDataIcon").style.visibility == "hidden") {
                    document.getElementById("companyInternet").disabled = false;
                    document.getElementById("companyEmail").disabled = false;
                    document.getElementById("companyPhone").disabled = false;
                    document.getElementById("companyMobilePhone").disabled = false;
                    document.getElementById("companyFax").disabled = false;
                    document.getElementById("companyPostAddress").disabled = false;
                    document.getElementById("companySaveContactDataIcon").style.visibility = "visible";
                    document.getElementById("statusBar").innerHTML = "";

                } else {
                    document.getElementById("companyInternet").disabled = true;
                    document.getElementById("companyEmail").disabled = true;
                    document.getElementById("companyPhone").disabled = true;
                    document.getElementById("companyMobilePhone").disabled = true;
                    document.getElementById("companyFax").disabled = true;
                    document.getElementById("companyPostAddress").disabled = true;
                    document.getElementById("companySaveContactDataIcon").style.visibility = "hidden";
                }

            }


            function saveCompanyContactData(regNumber) {
                document.getElementById("companyInternet").disabled = true;
                document.getElementById("companyEmail").disabled = true;
                document.getElementById("companyPhone").disabled = true;
                document.getElementById("companyMobilePhone").disabled = true;
                document.getElementById("companyFax").disabled = true;
                document.getElementById("companyPostAddress").disabled = true;

                xmlhttpi = new XMLHttpRequest();
                xmlhttpi.onreadystatechange = function ()
                {
                    if (xmlhttpi.readyState == 4 && xmlhttpi.status == 200)
                    {
                        document.getElementById("statusBar").innerHTML = xmlhttpi.responseText;
                    }
                }
                xmlhttpi.open("GET", "modules/sales/save_company_contact_data.php?regNumber=" + regNumber
                        + "&companyInternet=" + document.getElementById('companyInternet').value
                        + "&companyEmail=" + document.getElementById('companyEmail').value
                        + "&companyPhone=" + document.getElementById('companyPhone').value
                        + "&companyMobilePhone=" + document.getElementById('companyMobilePhone').value
                        + "&companyFax=" + document.getElementById('companyFax').value
                        + "&companyPostAddress=" + document.getElementById('companyPostAddress').value
                        , true);
                xmlhttpi.send();


                document.getElementById("companySaveContactDataIcon").style.visibility = "hidden";

            }



            function saveNotes(regNumber)
            {
                xmlhttpi = new XMLHttpRequest();
                xmlhttpi.onreadystatechange = function ()
                {
                    if (xmlhttpi.readyState == 4 && xmlhttpi.status == 200)
                    {
                        document.getElementById("statusBar").innerHTML = xmlhttpi.responseText;
                    }
                }
                xmlhttpi.open("GET", "modules/sales/save_notes.php?regNumber=" + regNumber + "&notes=" + document.getElementById('notes').value, true);
                xmlhttpi.send();

            }

            function saveCallingDate(regNumber)
            {
                xmlhttpi = new XMLHttpRequest();
                xmlhttpi.onreadystatechange = function ()
                {
                    if (xmlhttpi.readyState == 4 && xmlhttpi.status == 200)
                    {
                        document.getElementById("lastContacted").innerHTML = xmlhttpi.responseText;
                    }
                }
                xmlhttpi.open("GET", "modules/sales/save_calling_date.php?regNumber=" + regNumber, true);
                xmlhttpi.send();

            }


            function registerCallBack(regNumber, callDate)
            {
                xmlhttpi = new XMLHttpRequest();
                xmlhttpi.onreadystatechange = function ()
                {
                    if (xmlhttpi.readyState == 4 && xmlhttpi.status == 200)
                    {
                        document.getElementById("lastContacted").innerHTML = xmlhttpi.responseText;
                    }
                }
                xmlhttpi.open("GET", "modules/sales/save_callback_date.php?regNumber=" + regNumber + "&callDate=" + callDate, true);
                xmlhttpi.send();

            }

            function getData(regNumber, companyName) {

                xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function () {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        document.getElementById("data").innerHTML = xmlhttp.responseText;
                    }
                }
                xmlhttp.open("GET", "modules/sales/get_accounts.php?regnumber=" + regNumber + "&name=" + companyName, true);
                xmlhttp.send();

                document.getElementById("graphHead").style.visibility = 'visible';
                document.getElementById("graphs").style.height = '180px';
                document.getElementById("graphs").src = "modules/sales/get_charts.php?regnumber=" + regNumber + "&name=" + companyName;
                document.getElementById("statusBar").innerHTML = "";
            }


            function registerSale(regNumber) {
                document.getElementById("graphHead").style.visibility = 'visible';
                document.getElementById("graphHead").innerHTML = '<h1 class="ui-widget-header ui-corner-all" style="padding:2px;">&nbsp; <?php print $LANG['register_sale']; ?></h1>';
                document.getElementById("graphs").style.height = '300px';
                document.getElementById("graphs").src = "modules/sales/register_sale.php?regnumber=" + regNumber;
                document.getElementById("statusBar").innerHTML = "";
            }

            function editSales(regNumber, orderID) {
                document.getElementById("salesArea").innerHTML = '';
                document.getElementById("salesArea").style.visibility = 'hidden';
                document.getElementById("graphHead").style.visibility = 'visible';
                document.getElementById("graphHead").innerHTML = '<h1 class="ui-widget-header ui-corner-all" style="padding:2px;">&nbsp; <?php print $LANG['edit_sale']; ?></h1>';
                document.getElementById("graphs").style.height = '300px';
                document.getElementById('graphs').src = "modules/sales/register_sale.php?regnumber=" + regNumber + "&orderID=" + orderID;
                document.getElementById("statusBar").innerHTML = "";
            }

            function deleteSales(regNumber, orderID) {
                jConfirm("<?php print $LANG['confirm_delete'] . " " . $LANG['order'] . ": "; ?>" + orderID + "", "<?php print $LANG['confirm_delete_heading']; ?>", function (y) {
                    if (y == true) {
                        xmlhttp = new XMLHttpRequest();
                        xmlhttp.onreadystatechange = function () {
                            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                                document.getElementById("statusBar").innerHTML = xmlhttp.responseText;
                                getCustomer(regNumber);
                            }
                        }
                        xmlhttp.open("GET", "modules/orders/delete_order.php?orderID=" + orderID, true);
                        xmlhttp.send();
                    }
                });

            }



            function showCustomers(companyStatusStr) {

                var companyParams = companyStatusStr.split(' ');

                var companyStatus = companyParams[0];
                var salesStageIcon = companyParams[1];

                customerStatus = companyStatus;

                document.getElementById("registerSaleButton").style.visibility = 'hidden';
                document.getElementById("registerCallButton").style.visibility = 'hidden';
                document.getElementById("graphs").src = "";
                document.getElementById('logoIcon').src = 'images/sales_icons/' + salesStageIcon;


                xmlhttp2 = new XMLHttpRequest();
                xmlhttp2.onreadystatechange = function () {
                    if (xmlhttp2.readyState == 4 && xmlhttp2.status == 200) {
                        document.getElementById("list").innerHTML = xmlhttp2.responseText;
                        oTable = $('#example').dataTable({
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
                                    "sFirst": lFirst,
                                    "sPrevious": lPrevious,
                                    "sNext": lNext,
                                    "sLast": lLast
                                }
                            }
                        });
                    }
                }
                xmlhttp2.open("GET", "modules/sales/display_customers.php?companyStatus=" + companyStatus, true);
                xmlhttp2.send();
                document.getElementById("data").innerHTML = ""
                document.getElementById("graphs").src = ""
                document.getElementById("graphHead").style.visibility = 'hidden';
                document.getElementById("allButton").style.visibility = 'hidden';
                //document.getElementById("allButton").onclick = 'showCustomers('+customerStatus+')';
                document.getElementById("statusBar").innerHTML = "";
                document.getElementById(companyStatus).defaultSelected = true;
            }


            regNumber = '<?php print $_GET['regNumber']; ?>';

            if (regNumber != "") {
                getCustomer(regNumber);
            } else {
                showCustomers('<?php print $companyStatus; ?> <?php print $salesStageIcon; ?>');
                    }
        </script>
    </body>
</html>

