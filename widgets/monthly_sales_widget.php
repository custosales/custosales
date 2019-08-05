<?php
session_start();
if (!isset($_SESSION['userID'])) { // check if user is logged in
    header("Location: ../index.php"); // if not go to login
}
require_once "../modules/system/db.php";  // get pdo connection settings
require_once "../lang/" . $_SESSION['lang'] . ".php"; // get language array

$queryYear = "SELECT YEAR(orderDate) as year from " . $orders . " Group by year ORDER BY year desc";

try {
    $ResultYear = $pdo->query($queryYear);
} catch (PDOException $e) {
    echo "1 - Data was not fetched, because: " . $e->getMessage();
}

?>
<h1><select id="year2" style="font-size:12px" onchange="document.getElementById('monthlyGraphArea').src='modules/sales/get_monthly_chart.php?year='+(this.value)+'&type='+document.getElementById('graphType2').value;"></h1>
<?php
foreach ($ResultYear as $RowYear) {
    ?>
    <option value="<?php print $RowYear['year']; ?>"><?php print $RowYear['year']; ?></option>
<?php
}
?>

</select>


<select id="graphType2" style="font-size:12px" onchange="document.getElementById('monthlyGraphArea').src='modules/sales/get_monthly_chart.php?type='+(this.value)+'&year='+document.getElementById('year2').value;">
    <option value="Bar"><?php print $LANG['bar_graph']; ?></option>
    <option value="Line" selected><?php print $LANG['line_graph']; ?></option>
    <option value="Pie"><?php print $LANG['pie_graph']; ?></option>
</select>

</h1>

<iframe id="monthlyGraphArea" style="height:220px;width:100%;border:none;margin:0;padding:0" src=""></iframe>

<script>
document.getElementById('monthlyGraphArea').src='modules/sales/get_monthly_chart.php?type='+(document.getElementById('graphType2').value)+'&year='+document.getElementById('year2').value;
</script>
