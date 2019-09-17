<?php
session_start();
if (!isset($_SESSION['userID'])) { // check if user is logged in
    header("Location: ../../index.php");
}

require_once "../system/db.php";
require_once "../../lang/" . $_SESSION['lang'] . ".php";

$regNumber = trim($_GET['regnumber']);

$query = "SELECT * FROM " . $companies . " WHERE regNumber=:regNumber";

try {
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':regNumber', $regNumber);
    $stmt->execute();
    $Row = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Data was not fetched, because: " . $e->getMessage();
}

?>

<span style="width:95%;text-align:left;margin-right:20px">

    <table class="ui-widget-content ui-corner-all" style="float:left;height:200px;font-size:12px;" cellpadding="0" cellspacing="4">
        <tr>
            <td valign="top" style="width:450px;margin-right:10px;">
                <table class="ui-widget-content" style="border:none;font-size:12px;padding:10px;height:100%;width:450px;">
                    <tr>
                        <td>
                            <?php

                            $query = "SELECT count(*) as orders from " . $orders . " WHERE regNumber =:regNumber";

                            try {
                                $stmt = $pdo->prepare($query);
                                $stmt->bindParam(':regNumber', $Row['regNumber']);
                                $stmt->execute();
                                $RowO = $stmt->fetch(PDO::FETCH_ASSOC);
                            } catch (PDOException $e) {
                                echo "Data was not fetched, because: " . $e->getMessage();
                            }

                            if ($RowO['orders'] > 0) { // orders are made, so get customer icon


                                $companyStatus = $LANG['customer'];
                                $companyIcon = "folder_yellow_32.png";
                            } else { // get sales stage icon
                                $queryi = "SELECT salesStageIcon FROM " . $salesstages . " WHERE salesStageID=:salesStageID";

                                try {
                                    $stmt = $pdo->prepare($queryi);
                                    $stmt->bindParam(':salesStageID', $Row['companyStatus']);
                                    $stmt->execute();
                                    $Rowi = $stmt->fetch(PDO::FETCH_ASSOC);
                                } catch (PDOException $e) {
                                    echo "Data was not fetched, because: " . $e->getMessage();
                                }

                                $companyIcon = $Rowi['salesStageIcon'];
                            } // end if customer
                            ?>
                            <img id="appleIcon" src="images/sales_icons/<?php print $companyIcon; ?>" style="width:32px;vertical-align:middle;margin-right:5px;">

                            <?php print $LANG['org_number']; ?>:</td>
                        <td>
                            <span id="regNumber"><?php print $Row['regNumber']; ?></span> &nbsp;
                            <input type="image" style="vertical-align:middle" src="images/logo-proff.png" value="<?php print $LANG['get_data']; ?>" onclick="getProff('<?php print $Row['regNumber']; ?>','<?php print $Row['companyName']; ?>')">
                            &nbsp;
                            <select id="companyStatus" name="status" onchange="javaScript:convertStatus('<?php print $Row['regNumber']; ?>',this.value)">


                                <?php
                                $selected = "";

                                // Get sales Stages for project
                                if ($_SESSION['project'] != "" && $_SESSION['project'] != "all") {

                                    $queryStages = "SELECT projectSalesStages FROM " . $projects . " WHERE projectID=" . $_SESSION['project'];

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
                                    $Results = $pdo->query($querys);
                                } catch (PDOException $e) {
                                    echo "Data was not fetched, because: " . $e->getMessage();
                                }

                                foreach ($Results as $Rows) {

                                    if ($Rows['salesStageID'] == $Row['companyStatus']) {
                                        $selected = "selected";
                                    } else {
                                        $selected = "";
                                    }

                                    ?>
                                    <option id="<?php print $Rows['salesStageID']; ?>" value="<?php print $Rows['salesStageID']; ?>" <?php print $selected; ?>><?php print $Rows['salesStageName']; ?></option>
                                <?php } ?>
                            </select>

                        </td>
                    </tr>

                    <tr>
                        <td><?php print $LANG['company_name']; ?>:</td>
                        <td><b><?php print $Row['companyName']; ?></b></td>
                    </tr>

                    <tr>
                        <td><?php print $LANG['company_type']; ?>:</td>
                        <td><?php print $Row['companyType']; ?></td>
                    </tr>

                    <tr>
                        <td><?php print $LANG['company_address']; ?>:</td>
                        <td><?php print $Row['companyAddress'] . ", " . $Row['companyZipCode'] . " " . $Row['companyCity']; ?></td>
                    </tr>

                    <tr>
                        <td><?php print $LANG['company_manager']; ?>:</td>
                        <td><?php print $Row['companyManager']; ?></td>
                    </tr>

                    <tr>
                        <td><?php print $LANG['business_branch']; ?>:</td>
                        <td><?php print $Row['branchCode'] . " - " . $Row['branchText']; ?> </td>
                    </tr>
                </table>


            </td>
            <td valign="top" style="width:300px">
                <table class="ui-widget-content" style="border:none;font-size:12px;padding:10px;height:100%;width:300px">
                    <tr>
                        <td><a href="mailto:<?php print $Row['companyEmail']; ?>"><?php print $LANG['email']; ?></a>:</td>
                        <td>
                            <input type="text" id="companyEmail" name="companyEmail" style="color:black" disabled value="<?php print $Row['companyEmail']; ?>">
                        </td>
                        <td rowspan="3" valign="top">
                            <img id="companyEditIcon" src="images/edit_16.png" title="<?php print $LANG['edit']; ?>" onmouseover="document.body.style.cursor='pointer';" onmouseout="document.body.style.cursor='default';" onclick="editCompany();" border="0" alt="">
                            <img id="companySaveContactDataIcon" src="images/save_16.png" title="<?php print $LANG['save']; ?>" style="visibility: hidden;margin-top:5px;" onmouseover="document.body.style.cursor='pointer';" onmouseout="document.body.style.cursor='default';" onclick="saveCompanyContactData(<?php print $regNumber ?>);" border="0" alt="">
                        </td>
                    </tr>
                    <tr>
                        <td><a href="http://<?php print $Row['companyInternet']; ?>" target="_blank">WWW</a>:</td>
                        <td colspan="2"><input type="text" id="companyInternet" name="companyInternet" style="color:black" disabled value="<?php print $Row['companyInternet']; ?>"></td>
                    </tr>
                    <tr>
                        <td><?php print $LANG['phone']; ?>:</td>
                        <td colspan="2"><input type="text" id="companyPhone" name="companyPhone" style="color:black" disabled value="<?php print $Row['companyPhone']; ?>"></td>
                    </tr>
                    <tr>
                        <td><?php print $LANG['mobile_phone']; ?>:</td>
                        <td colspan="2"><input type="text" id="companyMobilePhone" name="companyMobilePhone" style="color:black" disabled value="<?php print $Row['companyMobilePhone']; ?>"></td>
                    </tr>
                    <tr>
                        <td><?php print $LANG['fax']; ?>:</td>
                        <td colspan="2"><input type="text" id="companyFax" name="companyFax" style="color:black" disabled value="<?php print $Row['companyFax']; ?>"></td>
                    </tr>
                    <tr>
                        <td><?php print $LANG['post_address']; ?>:</td>
                        <td colspan="2"><input type="text" id="companyPostAddress" name="companyPostAddress" style="color:black" disabled value="<?php print $Row['companyPostAddress']; ?>"></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!--  Display Calls Table  -->
    <table class="ui-widget-content ui-corner-all" style="font-size:12px;float:left;height:200px;margin-left:5px;" cellpadding="0" cellspacing="4">
        <tr>
            <td valign="top">
                <table class="ui-widget-content" style="border:none;padding:0px;float:left;height:100%;width:400px;font-size:12px;">
                    <tr>
                        <td valign="top">
                            <b><?php print $LANG['notes']; ?></b> &nbsp; <img id="notesButton" onclick="maxNotes()" src="images/go_down_16.png" alt="">
                            <a href="#" onclick="saveNotes(<?php print $regNumber ?>)"><img src="images/save_16.png" border="0" align="right" title="<?php print $LANG['save']; ?>" alt="<?php print $LANG['save']; ?>" /></a>

                            <form name="callForm" id="callForm" method="post">

                                <textarea id="notes" name="notes" style="width:100%;height:130px;">
<?php print $Row['comments']; ?>
</textarea>
                            </form>
                            <?php print $LANG['last_contacted'] . ": " ?> <span id="lastContacted"><?php print $Row['lastContacted']; ?></span> &nbsp; <a href="#" onclick="saveCallingDate(document.getElementById('regNumber').innerHTML)"><img id="registerCallButton" src="images/voicecall_16.png" style="border:0px;vertical-align:bottom" title="<?php print $LANG['register_calling_date']; ?>" alt="<?php print $LANG['register_calling_date']; ?>" /></a>
                            &nbsp; <?php print $LANG['call_back'] . ": " ?> <input type="text" style="width:90px" id="callBackDate" value="<?php print $Row['contactAgain']; ?>" onchange="registerCallBack(<?php print $Row['regNumber']; ?>,this.value)">

                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <div id="salesArea" style="width:50%;visibility:visible">

        <div class="clear">&nbsp;</div>
        <h1 class="ui-widget-header ui-corner-all" style="width:100%;text-align:center;font-weight:bold"><?php print $LANG['sales']; ?></h1>

                                


        <?php
        // Get Order entries, if any

        $querys = "SELECT orderID, orderDate, productName, fullName, " . $orders . ".unitPrice FROM " . $orders . " , " . $products . " , " . $users . " WHERE " . $orders . ".productID=" . $products . ".productID and " . $orders . ".salesRepID=" . $users . ".userID and regNumber=" . $Row['regNumber'];

        try {
            $Results = $pdo->query($querys);
        } catch (PDOException $e) {
            echo "Data was not fetched, because: " . $e->getMessage();
        }

        if ($Results->rowCount()>0) {  // Show sales if there are orders

            ?>
            <table id="sales" class="display" style="font-size:1.1em">
                <thead>
                    <th><?php print $LANG['order']; ?></th>
                    <th><?php print $LANG['order_date']; ?></th>
                    <th><?php print $LANG['product_name']; ?></th>
                    <th><?php print $LANG['price']; ?></th>
                    <th><?php print $LANG['sales_rep']; ?></th>
                    <?php
                        if (isset($_SESSION['admin'])) {
                            ?>
                        <th>&nbsp;</th>
                    <?php } ?>
                </thead>
                <?php


                    foreach ($Results as $Rows) { // list sales data rows


                        print "<tr><td>" . $Rows['orderID'] . "</td><td>" . $Rows['orderDate'] . "</td><td>" . $Rows['productName'] . "</td><td>" . $Rows['unitPrice'] . "</td><td>" . $Rows['fullName'] . "</td>";
                        if (isset($_SESSION['admin'])) {
                            print "<td><a href=\"#\" onclick=\"editSales(" . $regNumber . "," . $Rows['orderID'] . ");\"><img src=\"images/edit_16.png\"></a>";
                            print "&nbsp;<a href=\"#\" onclick=\"deleteSales(" . $regNumber . "," . $Rows['orderID'] . ");\"><img src=\"images/cancel_16.png\"></a></td>";
                        }
                        print "</tr>";
                    } // end list sales data rows 

                    ?>
            </table>
        <?php } // end show sales  
        ?>
    </div>
</span>