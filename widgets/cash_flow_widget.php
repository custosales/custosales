<?php
session_start();
if (!isset($_SESSION['userID'])) { // check if user is logged in
    header("Location: ../index.php"); // if not go to login
}
require_once "../modules/system/db.php";  // get pdo connection settings
require_once "../lang/" . $_SESSION['lang'] . ".php"; // get language array

$queryYear = "SELECT YEAR(orderDate) as year from ".$orders." Group by year ORDER BY year desc";

try {
    $ResultYear = $pdo->query($queryYear);
} catch (PDOException $e) {
    echo "1 - Data was not fetched, because: " . $e->getMessage();
}

?>
<h1><select id="year" style="font-size:12px" onchange="document.getElementById('graphFrame').src='modules/orders/get_order_charts.php?year='+(this.value)+'&orderStatusID='+document.getElementById('orderStatusID').value;">
<?php 
foreach ($ResultYear as $RowYear) {
?>
<option value="<?php print $RowYear['year'];?>"><?php print $RowYear['year'];?></option>
<?php 
}
?>

</select> 
<select id="orderStatusID" style="font-size:13px;" onchange="document.getElementById('graphFrame').src='modules/orders/get_order_charts.php?year='+getElementById('year').value+'&orderStatusID='+(this.value);">
<option value=""><?php print $LANG['orders'];?></option>
<option value="0"><?php print $LANG['cash_flow'];?></option> 
<?php

$selected="";
$querys = "SELECT * FROM ".$orderstatus." ORDER by orderStatusID";

try {
    $Results = $pdo->query($querys);
} catch (PDOException $e) {
    echo "2 - Data was not fetched, because: " . $e->getMessage();
}
        
foreach ($Results as $Rows) {
    
    if($Rows['orderStatusName']==$Row['orderStatus']) { 
$selected="selected";
} else {
$selected="";
}


?>
<option id="<?php print $Rows['orderStatusID'];?>" value="<?php print $Rows['orderStatusID'];?>"  <?php print $selected;?> ><?php print $LANG['show']." ".$Rows['orderStatusName'];?></option>
<?php } ?>

</select>
</h1>
<iframe id="graphFrame" style="border:none;;width:100%;height:220px;"></iframe>

<script>
document.getElementById('graphFrame').src='modules/orders/get_order_charts.php?year='+document.getElementById('year').value+'&orderStatusID='+document.getElementById('orderStatusID').value;
</script>

