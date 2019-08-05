<?php
session_start();
if (!isset($_SESSION['userID'])) {
    header("Location: ../../index.php");
}
require_once("../system/db.php");
require_once("../../lang/" . $_SESSION['lang'] . ".php");

// Get Sales Stages	
$querys = "SELECT salesStageID, salesStageName from " . $salesstages . " order by salesStageName";
try {
    $Results = $pdo->query($querys);
} catch (PDOException $e) {
    echo "1 - Data was not fetched, because: " . $e->getMessage();
}

// Get Sales Reps
$ResultRepQuery = "SELECT userID, fullName FROM " . $users . " ORDER BY fullName";
try {
    $ResultRep = $pdo->query($ResultRepQuery);
} catch (PDOException $e) {
    echo "2 - Data was not fetched, because: " . $e->getMessage();
}
?>

<style type="text/css">
    input.text { 
        width:300px; 
    } 
</style>

<table style="width:1080px;margin-top:4px">
    <tr><td style="vertical-align:top">

            <table style="width:580px;margin-right:5px;;font-size:12px">
                <tr><th colspan="6"><h1 style="width:100%" class="ui-widget-header ui-corner-all"><?php print $LANG['clients']; ?>

                            <select id="selectStatus" onchange="showClients(this.value, document.getElementById('selectSalesRep').value)">
                                <option value=""><?php print $LANG['select_company_status']; ?></option>
                                <?php
                                foreach ($Results as $Row) {
                                    if ($Row['salesStageID'] == $_GET['companyStatus']) {
                                        $selected = " selected ";
                                    } else {
                                        $selected = "";
                                    }
                                    print "<option value=\"" . $Row['salesStageID'] . "\" " . $selected . ">" . $Row['salesStageName'] . "</option>";
                                }
                                ?>
                            </select>	

                            <select id="selectSalesRep" onchange="showClients(document.getElementById('selectStatus').value, this.value)">
                                <option value=""><?php print $LANG['select_sales_rep']; ?></option>
                                <?php
                                foreach ($ResultRep as $RowRep) {
                                    if ($RowRep['userID'] == $_GET['salesRepID']) {
                                        $selected2 = " selected ";
                                    } else {
                                        $selected2 = "";
                                    }

                                    print "<option value=\"" . $RowRep['userID'] . "\" " . $selected2 . ">" . $RowRep['fullName'] . "</option>";
                                }
                                ?>
                            </select>	

                        </h1></th></tr>

                <tr><td>

                        <table class="display" id="clients" style="font-size:1em;">
                            <thead>
                            <th>#</th>
                            <th><?php print $LANG['regNumber']; ?></th>
                            <th><?php print $LANG['companyName']; ?></th>
                            <th><?php print $LANG['regDate']; ?></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            </thead>
                            <tbody>

                                <?php
                                if ($_GET['companyStatus'] != "" || $_GET['salesRepID'] != "") { // display companies with given status and/or sales rep	
                                    if ($_GET['companyStatus'] != "" && $_GET['salesRepID'] == "") {
                                        $wherestr = "companyStatus='" . $_GET['companyStatus'] . "'";
                                    }

                                    if ($_GET['companyStatus'] == "" && $_GET['salesRepID'] != "") {
                                        $wherestr = "salesRepID='" . $_GET['salesRepID'] . "'";
                                    }

                                    if ($_GET['companyStatus'] != "" && $_GET['salesRepID'] != "") {
                                        $wherestr = "companyStatus='" . $_GET['companyStatus'] . "' AND salesRepID='" . $_GET['salesRepID'] . "'";
                                    }

                                    $query = "SELECT ID, regNumber, companyName, DATE(regDate) as regDate from " . $companies . " WHERE " . $wherestr . " ORDER BY companyName";


                                    $Result = mysql_db_query($DBName, $query, $Link) or die(MySql_error());
                                    $i = 1;

                                    while ($Row = MySQL_fetch_array($Result)) {
                                        ?>	
                                        <tr>
                                            <td><?php print $i; ?></td>
                                            <td><?php print $Row['regNumber']; ?></td>
                                            <td><a href="#" onclick="editItem('Companies', 'edit', '<?php print $Row['ID']; ?>')" ><?php print htmlspecialchars($Row['companyName']); ?></a></td>
                                            <td><?php print $Row['regDate']; ?></td> 
                                            <td width="20">
        <?php
// Display contact Icon if contacts are available
        $ResultCon = mysql_query("SELECT COUNT(contactID) as contactNumber FROM " . $contacts . " WHERE contactCompanyID='" . $Row['regNumber'] . "'");
        $RowCon = mysql_fetch_assoc($ResultCon);
        if ($RowCon['contactNumber'] > 0) {
            ?>
                                                    <img src="images/contacts_16.png" title="<?php print $LANG['contacts']; ?>" onclick="listContacts('<?php print $Row['regNumber']; ?>', '<?php print $LANG['contacts'] . " - " . $Row['companyName']; ?>')" >
                                                    <?php
                                                }
                                                ?>
                                            </td>


                                            <td width="20"><img src="images/edit_16.png" title="<?php print $LANG['edit_client']; ?>" onclick="editItem('Companies', 'edit', '<?php print $Row['ID']; ?>')" alt="" > </td>
                                            <td width="20"><img src="images/cancel_16.png" title="<?php print $LANG['delete_client']; ?>" onclick="deleteItem('Companies', '<?php print $Row['ID']; ?>', '<?php print $LANG['confirm_delete'] . ": " . $Row['companyName'] . "?"; ?>', '<?php print $LANG['delete_client']; ?>')" alt="" > </td>
                                        </tr>

        <?php
        $i++;
    }
    ?>
                                <?php } // end if no status ?>
                            </tbody>
                        </table>	

                    </td></tr></table>

        </td>
        <td style="width:500px;vertical-align:top">

            <table style="width:500px;font-size:12px">
                <tr><th><h1 style="width:100%;padding:3px" class="ui-widget-header ui-corner-all"><span id="actionHeader"><?php print $LANG['actions']; ?></span></h1></th></tr>
                <tr>
                    <td style="text-align:center">
                        <div id="actionArea" style="text-align:center;">
                            <table style="text-align:center;width:70%;font-size:13px">
                                <tr>

                                    <td>
                                        <img src="images/clients_32.png" onclick="editItem('Companies', 'add', '')" alt="<?php print $LANG['add_client']; ?>" >
                                        <br>
                                        <?php print $LANG['add_client']; ?>
                                    </td>

                                </tr>
                            </table>
                        </div>
                    </td>

                </tr>
            </table>

        </td></tr>
</table>

<br>
