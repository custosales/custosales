<?php
session_start();
if (!isset($_SESSION['userID'])) {
    header("Location: ../../index.php");
}
require_once("../system/db.php");
require_once("../../lang/" . $_SESSION['lang'] . ".php");


$query = "SELECT contactTypeID, contactTypeName from " . $contacttypes . " order by contactTypeName";

try {
    $result = $pdo->query($query);
} catch (PDOException $e) {
    echo "Data was not fetched, because: " . $e->getMessage();
}
?>
<style type="text/css">
    input.text { 
        width:300px; 
    } 
</style>
<table style="width:900px;margin-top:4px">
    <tr><td style="vertical-align:top">
            <table style="width:400px;margin-right:5px;;font-size:13px">
                <tr><th colspan="5"><h1 style="width:100%" class="ui-widget-header ui-corner-all"><?php print $LANG['contacts']; ?>


                            <select id="selectStatus" onchange="showContacts(this.value)">
                                <option value=""><?php print $LANG['select_contact_type']; ?></option>
                                <?php
                                foreach ($result as $Row) {

                                    print "<option value=\"" . $Row['contactTypeID'] . "\">" . $Row['contactTypeName'] . "</option>";
                                }
                                ?>
                            </select>	

                        </h1></th></tr>

                <?php
                if ($_GET['contactType'] == "") {
                    ?>	
                    <tr><td>

                        </td></tr>	
    <?php
} else { // display contacts with given type/category	
    $query = "SELECT * from " . $contacts . " WHERE contactType='" . $_GET['contactType'] . "' order by contactName";
    try {
        $result = $pdo->query($query);
    } catch (PDOException $e) {
        echo "Data was not fetched, because: " . $e->getMessage();
    }

    $i = 1;

    foreach ($result as $Row) {
        ?>
                        <tr >
                            <td># <?php print $i; ?></td>
                            <td><a href="#" onclick="editItem('Contacts', 'edit', '<?php print $Row['contactID']; ?>')" ><?php print htmlspecialchars($Row['contactName']); ?></a></td>
                            <td width="20"><img src="images/edit_16.png" title="<?php print $LANG['edit_contact']; ?>" onclick="editItem('Contacts', 'edit', '<?php print $Row['contactID']; ?>')" alt="" > </td>
                            <td width="20"><img src="images/cancel_16.png" title="<?php print $LANG['delete_contact']; ?>" onclick="deleteItem('Contacts', '<?php print $Row['contactID']; ?>', '<?php print $LANG['confirm_delete'] . ": " . $Row['contactName'] . "?"; ?>', '<?php print $LANG['delete_contact']; ?>')" alt="" > </td>
                        </tr>

        <?php
        $i++;
    }
    ?>
                <?php } // end if no status ?>
            </table>	


        </td>
        <td style="width:500px;vertical-align:top">

            <table style="width:500px;font-size:13px">
                <tr><th><h1 style="width:100%" class="ui-widget-header ui-corner-all"><span id="actionHeader"><?php print $LANG['actions']; ?></span></h1></th></tr>
                <tr>
                    <td style="text-align:center">
                        <div id="actionArea" style="text-align:center;">
                            <table style="text-align:center;width:70%;font-size:13px">
                                <tr>

                                    <td>
                                        <img src="images/contacts_32.png" onclick="editItem('Contacts', 'add', '')" alt="<?php print $LANG['add_contact']; ?>" >
                                        <br>
<?php print $LANG['add_contact']; ?>
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
