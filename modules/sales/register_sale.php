<?php
session_start();
if (!isset($_SESSION['userID'])) { // check if user is logged in
    header("Location: ../../index.php");
}

require_once "../system/db.php";
include_once "../../lang/" . $_SESSION['lang'] . ".php";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link href="../../css/styles.css" type="text/css" rel="stylesheet">
        <link rel="stylesheet" href="../../lib/jquery/development-bundle/themes/<?php print $_SESSION['style'] ?>/jquery.ui.all.css">
        <link rel="stylesheet" href="../../lib/jquery/css/demos.css">

        <script src="../../lib/jquery/development-bundle/jquery-1.4.2.js"></script>
        <script src="../../lib/jquery/development-bundle/ui/jquery.ui.core.js"></script>
        <script src="../../lib/jquery/development-bundle/ui/jquery.ui.widget.js"></script>
        <script src="../../lib/jquery/development-bundle/ui/jquery.ui.datepicker.js"></script>
        <script src="../../lib/jquery/development-bundle/ui/i18n/jquery.ui.datepicker-no.js"></script>

    </head> 

    <body style="margin:0px">
        <?php
        if (!isset($_SESSION['project']) || $_SESSION['project'] == 0) {
            ?>
            <div class="ui-state-error ui-corner-all" style="font-size:1.5em;padding: 0 .7em;"> 
                <p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span> 
                    <strong><?php print $LANG['alert']; ?> </strong> <?php print $LANG['select_project_first'] . "!"; ?></p>
            </div>

            <?php
            exit();
        }

        $regNumber = trim($_GET['regnumber']);


        if ($_GET['orderID'] != "") {
            $orderID = $_GET['orderID'];
        } else if ($_POST['orderID'] != "") {
            $orderID = $_POST['orderID'];
        }

        $formAction = "Insert";

        if ($orderID != "") { // GET Order Data
            $formAction = "Update";

            $query = "SELECT * FROM " . $orders . " WHERE orderID=:orderID";

            try {
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(':orderID', $orderID);
                $stmt->execute();
                $Row = $stmt->fetch(PDO::FETCH_ASSOC);
                $unitPrice = $Row['unitPrice'];
                $creditDays = $Row['creditDays'];
                $productID = $Row['productID'];
                $comments = $Row['orderComments'];
                $customerContact = $Row['customerContact'];
                $otherTerms = $Row['otherTerms'];
                $orderDate = $Row['orderDate'];
                $regNumber = $Row['regNumber'];
            } catch (PDOException $e) {
                echo "2 - Data was not fetched, because: " . $e->getMessage();
            }
        } // end get order data


        if ($orderDate == "") {
            $orderDate = date("Y-m-d");
        }

        if ($creditDays == "") {
            $creditDays = $_SESSION['creditDays'];
        }

        if ($customerContact == "") {
            // Get company manager from company table		
            $queryc = "SELECT companyManager FROM " . $companies . " WHERE regNumber=" . $regNumber;

            try {
                $stmt = $pdo->prepare($queryc);
                $stmt->execute();
                $Rowc = $stmt->fetch();
                $customerContact = $Rowc['companyManager'];
            } catch (PDOException $e) {
                echo "3 - Data was not fetched, because: " . $e->getMessage();
            }

        }
        ?>


        <script type="text/javascript" >
            var price = new Array();
            var productDescription = new Array();
            var standardTerms = new Array();
            var countBased = new Array();
        </script>


    <table class="ui-widget-content ui-corner-all" style="height:230px;font-size:12px;padding:10px;float:left;margin-right:5px;">
        
        <form id="registerForm" method="post" action="../orders/save_order.php?formAction=<?php print $formAction; ?>">

            <input type="hidden" name="regNumber" value="<?php print $regNumber; ?>">

            <input type="hidden" name="orderID" value="<?php print $orderID; ?>">
                <tr>
                    <td width="150"><?php print $LANG['product']; ?>:</td>
                    <td>
                        <select style="width:250px;" id="product" name="productID" onchange="setPrice(this.options[this.selectedIndex].value)">

<?php
$selected = "";


$querys = "SELECT * FROM " . $products . " WHERE productProjectID=" . $_SESSION['project'] . " ORDER by productName";

try {
    $result = $pdo->query($querys);
} catch (PDOException $e) {
    echo "Data was not fetched, because: " . $e->getMessage();
}

foreach ($result as $Rows) {
    ?>
                                <script type="text/javascript" >
                                <?php if ($Rows['countBased']) { ?>
                                        countBased[<?php print $Rows['productID']; ?>] = true;
    <?php } ?>

                                    price[<?php print $Rows['productID']; ?>] = "<?php print $Rows['unitPrice']; ?>";
                                    productDescription[<?php print $Rows['productID']; ?>] = "<?php print preg_replace("/\n/", "<br>", $Rows['productDescription']); ?>";
                                    standardTerms[<?php print $Rows['productID']; ?>] = "<?php print preg_replace("/\n/", "<br>", $Rows['standardTerms']); ?>";
                                </script>
    <?php
    if ($orderID != "") {

        if ($Rows['productID'] == $productID) {
            $selected = "selected";
        } else {
            $selected = "";
        }
    }
    ?>

                                <option id="<?php print $Rows['productID']; ?>" value="<?php print $Rows['productID']; ?>"  <?php print $selected; ?> ><?php print $Rows['productName']; ?></option>

    <?php
} // end list products
?>
                        </select>
                        &nbsp;
                    </td>
                    <td>
<?php print $LANG['order_date']; ?>: &nbsp;
                    </td>
                    <td valign="top">
                        <input type="text" style="width:150px;" id="orderDate" name="orderDate" value="<?php print $orderDate; ?>" >
                    </td>
                </tr>

                <tr>
                    <td id="priceLabel">
<?php print $LANG['negotiated_price']; ?></td>
                    <td id="priceInput">
                        <input type="text" style="width:220px;" id="unitPrice" name="unitPrice" class="editField" value="<?php print $unitPrice; ?>"> <?php print $_SESSION['currency']; ?>
                    </td>
                    <td style="text-align:right;">
<?php print $LANG['notes']; ?>: &nbsp;
                    </td>
                    <td valign="top" rowspan="3">
                        <textarea style="width:250px;height:98px" id="comments" name="comments" class="editField">
<?php print $comments; ?>
                        </textarea>

                    </td>
                </tr>

                <tr>
                    <td id="daysLabel"><?php print $LANG['credit_days']; ?>:</td>
                    <td id="daysInput">
                        <input type="text" style="width:250px;" id="creditDays" name="creditDays" class="editField" value="<?php print $creditDays; ?>">
                    </td>
                </tr>

                <tr>
                    <td valign="top"><?php print $LANG['other_terms']; ?>:</td>
                    <td>
                        <textarea style="width:250px;height:70px" id="otherTerms" name="otherTerms" class="editField">
<?php print $otherTerms; ?>
                        </textarea>
                    </td>
                </tr>

                <tr>
                    <td><?php print $LANG['contact_person']; ?>:</td>
                    <td><input type="text" style="width:250px;" id="customerContact" name="customerContact" class="editField" value="<?php print $customerContact; ?>"></td>
                    <td></td>
                    <td valign="top">
                        <img  id="companyregisterSalesButton" src="../../images/save_22.png" title="<?php print $LANG['save']; ?>" style="float:left;border:none" onmouseover="document.body.style.cursor = 'pointer';" onmouseout="document.body.style.cursor = 'default';" onclick="saveOrder()" border="0" alt="" >
<?php
if ($orderID != "") {
    ?>
                            &nbsp;
                            <input type="button" onclick="parent.document.getElementById('graphs').style.height = '600px';parent.document.getElementById('list').innerHTML = '';document.location = '../orders/order_confirmation.php?orderID=<?php print $orderID; ?>';" value="<?php print $LANG['send_order_confirmation']; ?>">
    <?php
}
?>

                    </td>
            </form>
        </tr>

    </table>

    <table class="ui-widget-content ui-corner-all" style="width:400px;font-size:12px;padding:10px;height:230px;vertical-align:top;margin-left:5px;">
        <tr>
            <td class="ui-widget-header ui-corner-all" style="text-align:center;height:15px;">
<?php print $LANG['description']; ?>
            </td>
        </tr>
        <tr>
            <td valign="top" id="description"> 
<?php
if ($orderID != "") {
    print "<br>" . $LANG['order_registered'];

    print "<p><b>" . $LANG['order_number'] . ":</b> " . $orderID . "<br>";
}
?>
            </td>
        </tr>
    </table>

    <script type="text/javascript" >

        function setPrice(priceID) {

            if (countBased[priceID]) {
                document.getElementById("unitPrice").value = price[priceID];
                document.getElementById("priceLabel").style.visibility = 'hidden';
                document.getElementById("priceInput").style.visibility = 'hidden';
                document.getElementById("daysLabel").style.visibility = 'hidden';
                document.getElementById("daysInput").style.visibility = 'hidden';

            } else {
                document.getElementById("priceLabel").style.visibility = 'visible';
                document.getElementById("priceInput").style.visibility = 'visible';
                document.getElementById("unitPrice").value = price[priceID];
                document.getElementById("daysLabel").style.visibility = 'visisble';
                document.getElementById("daysInput").style.visibility = 'visible';

                document.getElementById("description").innerHTML = productDescription[priceID];
                document.getElementById("otherTerms").innerHTML = standardTerms[priceID];
            }

        }



<?php
if ($orderID == "") {
    print "setPrice(document.getElementById(\"product\").options[document.getElementById(\"product\").selectedIndex].value);";
} else if ($formAction == "Insert") {
    print "setPrice(" . $_GET['productID'] . ");";
}
?>

        function saveOrder() {
            document.getElementById("registerForm").submit();
        }

    </script>


    <script>
        $(function () {
            $.datepicker.setDefaults($.datepicker.regional[ "no" ]);
            $("#orderDate").datepicker($.datepicker.regional[ "no" ]);
        });
    </script>


</body>
</html>

