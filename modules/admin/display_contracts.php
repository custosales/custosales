<?php
session_start();
if (!isset($_SESSION['userID'])) {
    header("Location: ../../index.php");
}
require_once("../system/db.php");
require_once("../../lang/" . $_SESSION['lang'] . ".php");

$query = "SELECT * from " . $contracts . "";
try {
    $result = $pdo->query($query);
} catch (PDOException $e) {
    echo "Data was not fetched, because: " . $e->getMessage();
}
$i = 1;
?>
<style type="text/css">
    input.text { 
        width:300px; 
    } 

    .sized {
        font-size: 13px;
    } 

</style>

<table style="width:900px">
    <tr><td style="vertical-align:top">

            <table class="sized" style="width:400px;margin-right:5px;">
                <tr><th colspan="5"><h1 style="width:100%" class="ui-widget-header ui-corner-all"><?php print $LANG['contracts']; ?></h1></th></tr>

                <?php
                foreach ($result as $Row) {
                    ?>
                    <tr >
                        <td># <?php print $i; ?></td>
                        <td><a href="#" onclick="editItem('Contracts', 'edit', '<?php print $Row['contractID']; ?>')" ><?php print htmlspecialchars($Row['contractName']); ?></a></td>
                        <td width="20"><img src="images/edit_16.png" title="<?php print $LANG['edit_contract']; ?>" onclick="editItem('Contracts', 'edit', '<?php print $Row['contractID']; ?>')" alt="" > </td>
                        <td width="20"><img src="images/cancel_16.png" title="<?php print $LANG['delete_contract']; ?>" onclick="deleteItem('Departments', '<?php print $Row['contractID']; ?>', '<?php print $LANG['confirm_delete'] . ": " . $Row['contractName'] . "?"; ?>', '<?php print $LANG['delete_contract']; ?>')" alt="" > </td>
                    </tr>

                    <?php
                    $i++;
                }
                ?>
            </table>	

        </td>
        <td style="width:500px;vertical-align:top;">

            <table class="sized" style="width:500px">
                <tr><th><h1 style="width:100%" class="ui-widget-header ui-corner-all"><span id="actionHeader"><?php print $LANG['actions']; ?></span></h1></th></tr>
                <tr>
                    <td style="text-align:center">
                        <div id="actionArea" style="text-align:center;">
                            <table class="sized" style="text-align:center;width:70%">
                                <tr>

                                    <td>
                                        <img src="images/contracts_32.png" onclick="editItem('Contracts', 'add', '')" alt="<?php print $LANG['add_contract']; ?>" >
                                        <br>
<?php print $LANG['add_contract']; ?>
                                    </td>

                                    <td>
                                        <img src="images/go_up_32.png" onclick="uploadItem('Contract')" alt="<?php print $LANG['upload_contract']; ?>" >
                                        <br>
<?php print $LANG['upload_contract']; ?>
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
