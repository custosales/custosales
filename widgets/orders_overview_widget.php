<?php
session_start();
if (!isset($_SESSION['userID'])) { // check if user is logged in
    header("Location: ../index.php"); // if not go to login
}
require_once "../modules/system/db.php";
require_once "../lang/" . $_SESSION['lang'] . ".php";
?>
<table class="ui-widget-content ui-corner-all main_table" style="width:100%" >
<tr>
<td><img src="images/spreadsheet_file_22.png" alt="" ></td>
<td><?php print $LANG['total'];?></td>
</tr>
<tr>
<td style="width:50%"><?php print $LANG['order_value_total'];?>:</td>
<td>
<?php
$query_symbol = "SELECT currencySymbol FROM " . $currencies . " where defaultCurrency = 1";

try {
    $stmt = $pdo->prepare($query_symbol);
    $stmt->execute();
    $ResultSymbol = $stmt->fetch(PDO::FETCH_ASSOC);
    $currencySymbol = $ResultSymbol['currencySymbol'];
} catch (PDOException $e) {
    echo "1 -CurrencySumbol was not fetched, because: " . $e->getMessage();
}

$query = "SELECT sum(unitPrice) as orderValue FROM " . $orders;

try {
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $RowOrders = $stmt->fetch(PDO::FETCH_ASSOC);
    $orderValue = $RowOrders['orderValue'];
} catch (PDOException $e) {
    echo "3 - Data was not fetched, because: " . $e->getMessage();
}

print $currencySymbol . " " . number_format($orderValue, 0, ',', ' ');
?>
</td>
</tr>

<tr>
<td><?php print $LANG['order_value_paid'];?>:</td>
<td>
<?php
$query_paid = "SELECT sum(unitPrice) as orderValue FROM " . $orders . " WHERE orderStatusID = '7'";

try {
    $stmt = $pdo->prepare($query_paid);
    $stmt->execute();
    $Row_paid = $stmt->fetch(PDO::FETCH_ASSOC);
    $orderValue = $Row_paid['orderValue'];
} catch (PDOException $e) {
    echo "3 - Data was not fetched, because: " . $e->getMessage();
}

print $currencySymbol . " " . number_format($orderValue, 0, ',', ' ');
?>
</td>
</tr>

<tr>
<td><?php print $LANG['order_value_outstanding'];?>:</td>
<td>
<?php
$query_out = "SELECT sum(unitPrice) as orderValue FROM " . $orders . " WHERE orderStatusID != '7'";

try {
    $stmt = $pdo->prepare($query_out);
    $stmt->execute();
    $RowOrders_out = $stmt->fetch(PDO::FETCH_ASSOC);
    $orderValue_out = $RowOrders_out['orderValue'];
} catch (PDOException $e) {
    echo "3 - Data was not fetched, because: " . $e->getMessage();
}

print $currencySymbol . " " . number_format($orderValue_out, 0, ',', ' ');
?>
</td>
</tr>

</table>

<br>
<table class="ui-widget-content ui-corner-all main_table" style="width:100%">
<tr>
<?php
$query_today = "SELECT sum(unitPrice) as orderValue FROM " . $orders . " WHERE orderDate=DATE(NOW())";

try {
    $stmt = $pdo->prepare($query_today);
    $stmt->execute();
    $Result_today = $stmt->fetch(PDO::FETCH_ASSOC);
    $orderValue_today = $Result_today['orderValue'];
} catch (PDOException $e) {
    echo "3 - Data was not fetched, because: " . $e->getMessage();
}

if ($orderValue_today > 0 && $orderValue_today < 10000) {
    $iconfile = "emotes_22/face-cool.png";
} else if ($orderValue_today > 10000) {
    $iconfile = "emotes_22/face-smile-big.png";
} else {
    $iconfile = "spreadsheet_file_22.png";
}
?>
<td style="width:50%"><img src="images/<?php print $iconfile;?>" alt="" ></td>
<td><?php print $LANG['order_value_total'];?></td>
</tr>
<tr>
<td><?php print $LANG['today'];?>:</td>
<td>
<?php
print $currencySymbol . " " . number_format($orderValue_today, 0, ',', ' ');
?>
</td>
</tr>

<tr>
<td><?php print $LANG['this_week'];?>:</td>
<td>
<?php
$query_week = "SELECT sum(unitPrice) as orderValue FROM " . $orders . " WHERE WEEK(orderDate)=WEEK(NOW()) && YEAR(orderDate)=YEAR(NOW())";
try {
    $stmt = $pdo->prepare($query_week);
    $stmt->execute();
    $Result_week = $stmt->fetch(PDO::FETCH_ASSOC);
    $orderValue_week = $Result_week['orderValue'];
} catch (PDOException $e) {
    echo "3 - Data was not fetched, because: " . $e->getMessage();
}

print $currencySymbol . " " . number_format($orderValue_week, 0, ',', ' ');
?>
</td>
</tr>

<tr>
<td><?php print $LANG['this_month'];?>:</td>
<td>
<?php
$query_month = "SELECT sum(unitPrice) as orderValue FROM " . $orders . " WHERE MONTH(orderDate)=MONTH(NOW()) && YEAR(orderDate)=YEAR(NOW()) ";
try {
    $stmt = $pdo->prepare($query_month);
    $stmt->execute();
    $Result_month = $stmt->fetch(PDO::FETCH_ASSOC);
    $orderValue_month = $Result_month['orderValue'];
} catch (PDOException $e) {
    echo "3 - Data was not fetched, because: " . $e->getMessage();
}

print $currencySymbol . " " . number_format($orderValue_month, 0, ',', ' ');
?>
</td>
</tr>

<tr>
<td><?php print $LANG['this_year'];?>:</td>
<td>
<?php
$query_year = "SELECT sum(unitPrice) as orderValue FROM " . $orders . " WHERE YEAR(orderDate)=YEAR(NOW())";
try {
    $stmt = $pdo->prepare($query_year);
    $stmt->execute();
    $Result_year = $stmt->fetch(PDO::FETCH_ASSOC);
    $orderValue_year = $Result_year['orderValue'];
} catch (PDOException $e) {
    echo "3 - Data was not fetched, because: " . $e->getMessage();
}

print $currencySymbol . " " . number_format($orderValue_year, 0, ',', ' ');
?>
</td>
</tr>

</table>
