<?php
session_start();
if(!isset($_SESSION['userID'])) { // check if user is logged in
header("Location: ../index.php"); // if not go to login
}
require_once "../modules/system/db.php"; 
require_once "../lang/".$_SESSION['lang'].".php";
?>
<table class="ui-widget-content ui-corner-all main_table" style="width:100%" >
<tr>
<td><img src="images/spreadsheet_file_22.png" alt="" ></td>
<td><?php print $LANG['total'];?></td>
</tr>
<tr>
<td><?php print $LANG['order_value_total'];?>:</td>
<td>
<?php
$queryn = "SELECT sum(unitPrice) as orderValue FROM ".$orders;

try {
        $stmt = $pdo->prepare($queryn);
        $stmt->execute();
        $Resultn = $stmt->fetch(PDO::FETCH_ASSOC);
        $orderValue = $RowOrders['orderValue'];
    } catch (PDOException $e) {
        echo "3 - Data was not fetched, because: " . $e->getMessage();
    }

print $s_currency_symbol." ".number_format($orderValue[0], 0, ',', ' '); 
?>
</td>
</tr>

<tr>
<td><?php print $LANG['order_value_paid'];?>:</td>
<td>
<?php
$queryn = "SELECT sum(unitPrice) as orderValue FROM ".$orders." WHERE orderStatusID = '7'";

try {
        $stmt = $pdo->prepare($queryn);
        $stmt->execute();
        $Resultn = $stmt->fetch(PDO::FETCH_ASSOC);
        $orderValue = $RowOrders['orderValue'];
    } catch (PDOException $e) {
        echo "3 - Data was not fetched, because: " . $e->getMessage();
    }


print $s_currency_symbol." ".number_format($orderValue[0], 0, ',', ' '); 
?>
</td>
</tr>

<tr>
<td><?php print $LANG['order_value_outstanding'];?>:</td>
<td>
<?php
$queryn = "SELECT sum(unitPrice) as orderValue FROM ".$orders." WHERE orderStatusID != '7'";

try {
        $stmt = $pdo->prepare($queryn);
        $stmt->execute();
        $Resultn = $stmt->fetch(PDO::FETCH_ASSOC);
        $orderValue = $RowOrders['orderValue'];
    } catch (PDOException $e) {
        echo "3 - Data was not fetched, because: " . $e->getMessage();
    }


print $s_currency_symbol." ".number_format($orderValue[0], 0, ',', ' '); 
?>
</td>
</tr>

</table>	

<br>
<table class="ui-widget-content ui-corner-all main_table" style="width:100%">
<tr>
<?php
$queryn = "SELECT sum(unitPrice) as orderValue FROM ".$orders." WHERE orderDate=DATE(NOW())";


try {
        $stmt = $pdo->prepare($queryn);
        $stmt->execute();
        $Resultn = $stmt->fetch(PDO::FETCH_ASSOC);
        $orderValue = $RowOrders['orderValue'];
    } catch (PDOException $e) {
        echo "3 - Data was not fetched, because: " . $e->getMessage();
    }



if($orderValue[0] > 0 && $orderValue[0] < 10000) {
	$iconfile="emotes_22/face-cool.png";
	} else if($orderValue[0] > 10000) {
	$iconfile="emotes_22/face-smile-big.png";
	} else {
	$iconfile="spreadsheet_file_22.png";
	}
?>
<td><img src="images/<?php print $iconfile;?>" alt="" ></td>
<td><?php print $LANG['order_value_total'];?></td>
</tr>
<tr>
<td><?php print $LANG['today'];?>:</td>
<td>
<?php
print $s_currency_symbol." ".number_format($orderValue[0], 0, ',', ' '); 
?>
</td>
</tr>

<tr>
<td><?php print $LANG['this_week'];?>:</td>
<td>
<?php
$queryn = "SELECT sum(unitPrice) as orderValue FROM ".$orders." WHERE WEEK(orderDate)=WEEK(NOW()) && YEAR(orderDate)=YEAR(NOW())";
try {
        $stmt = $pdo->prepare($queryn);
        $stmt->execute();
        $Resultn = $stmt->fetch(PDO::FETCH_ASSOC);
        $orderValue = $RowOrders['orderValue'];
    } catch (PDOException $e) {
        echo "3 - Data was not fetched, because: " . $e->getMessage();
    }

print $s_currency_symbol." ".number_format($orderValue[0], 0, ',', ' '); 
?>
</td>
</tr>

<tr>
<td><?php print $LANG['this_month'];?>:</td>
<td>
<?php
$queryn = "SELECT sum(unitPrice) as orderValue FROM ".$orders." WHERE MONTH(orderDate)=MONTH(NOW()) && YEAR(orderDate)=YEAR(NOW()) ";
try {
        $stmt = $pdo->prepare($queryn);
        $stmt->execute();
        $Resultn = $stmt->fetch(PDO::FETCH_ASSOC);
        $orderValue = $RowOrders['orderValue'];
    } catch (PDOException $e) {
        echo "3 - Data was not fetched, because: " . $e->getMessage();
    }

print $s_currency_symbol." ".number_format($orderValue[0], 0, ',', ' '); 
?>
</td>
</tr>

<tr>
<td><?php print $LANG['this_year'];?>:</td>
<td>
<?php
$queryn = "SELECT sum(unitPrice) as orderValue FROM ".$orders." WHERE YEAR(orderDate)=YEAR(NOW())";
try {
        $stmt = $pdo->prepare($queryn);
        $stmt->execute();
        $Resultn = $stmt->fetch(PDO::FETCH_ASSOC);
        $orderValue = $RowOrders['orderValue'];
    } catch (PDOException $e) {
        echo "3 - Data was not fetched, because: " . $e->getMessage();
    }

print $s_currency_symbol." ".number_format($orderValue[0], 0, ',', ' '); 
?>
</td>
</tr>

</table>	
