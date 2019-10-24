<?php 
// sales per salesrep
//require_once "sales_class.php";

//$userID = $_GET['userID'];

require_once "../../lang/".$_SESSION['lang'].".php";

$query = "SELECT userID, fullName from ".$users."";

try {
	$Result = $pdo->query($query);
} catch (PDOException $e) {
	echo "Data was not fetched, because: " . $e->getMessage();
}


$queryYear = "SELECT YEAR(orderDate) as year from ".$orders." Group by year ORDER BY year desc";


try {
	$ResultYear = $pdo->query($queryYear);
} catch (PDOException $e) {
	echo "Data was not fetched, because: " . $e->getMessage();
}


?>

<h1 class="ui-widget-header ui-corner-all" style="margin-top:5px;width:980px;padding: 2px 2px 2px 15px;font-size:14px"><?php print $LANG['sales_per_salesrep']; ?> 

&nbsp;

<select id="year" style="font-size:12px" onchange="if(document.getElementById('seluser').value!='') { showRepSales(document.getElementById('seluser').value,this.value) }">
<?php 

foreach ($ResultYear as $RowYear) {
?>
<option value="<?php print $RowYear['year'];?>"><?php print $RowYear['year'];?></option>
<?php 
}
?>

</select>

&nbsp; 
<select id="seluser" style="font-size:12px" onchange="if(this.value!='') { showRepSales(this.value,document.getElementById('year').value) }" >
<option value=""><?php print $LANG['sales_rep']; ?></option>
<?php 
foreach ($Result as $Row) {
?>
<option value="<?php print $Row['userID'];?>"><?php print $Row['fullName'];?></option>
<?php 
}
?>

</select>
</h1>

<div id="repArea" style="float:left"></div>
<iframe id="repGraphArea" style="visibility:hidden;height:0px;border:1px"></iframe>

