<?php
session_start();
if (!isset($_SESSION['userID'])) {
    header("Location: ../../index.php");
}
require_once("../system/db.php");
require_once("../../lang/" . $_SESSION['lang'] . ".php");

$query = "SELECT * from " . $productcategories . " order by productCategoryName";
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
</style>
<table style="width:900px;margin-top:4px">
    <tr><td style="vertical-align:top">
            <table style="width:400px;margin-right:5px;;font-size:13px">
                <tr><th colspan="5"><h1 style="width:100%" class="ui-widget-header ui-corner-all"><?php print $LANG['product_categories']; ?></h1></th></tr>

                <?php
                foreach ($result as $Row) {
                    ?>
                    <tr >
                        <td># <?php print $i; ?></td>
                        <td><a href="#" onclick="editItem('ProductCategories', 'edit', '<?php print $Row['productCategoryID']; ?>')" ><?php print htmlspecialchars($Row['productCategoryName']); ?></a></td>
                        <td width="20"><img src="images/edit_16.png" title="<?php print $LANG['edit_link']; ?>" onclick="editItem('ProductCategories', 'edit', '<?php print $Row['productCategoryID']; ?>')" alt="" > </td>
                        <td width="20"><img src="images/cancel_16.png" title="<?php print $LANG['delete_link']; ?>" onclick="deleteItem('ProductCategories', '<?php print $Row['productCategoryID']; ?>', '<?php print $LANG['confirm_delete'] . ": " . $Row['productCategoryName'] . "?"; ?>', '<?php print $LANG['delete_product_category']; ?>')" alt="" > </td>
                    </tr>

                    <?php
                    $i++;
                }
                ?>
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
                                        <img src="images/product_categories_32.png" onclick="editItem('ProductCategories', 'add', '')" alt="<?php print $LANG['add_product_category']; ?>" >
                                        <br>
                                        <?php print $LANG['add_product_category']; ?>
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
