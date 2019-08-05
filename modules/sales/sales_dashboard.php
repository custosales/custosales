<?php			

if(isset($_SESSION['admin']))  {  // Check for admin rights
$queryle = "SELECT count(ID) from ".$companies." WHERE companyStatus='lead'";
$queryo = "SELECT count(ID) from ".$companies." WHERE companyStatus='opportunity'";
$queryc = "SELECT count(ID) from ".$companies." WHERE companyStatus='customer'";
$querylo = "SELECT count(ID) from ".$companies." WHERE companyStatus='lost'";
$sales_title = $LANG['sales_per_salesrep'];

} else if(isset($_SESSION['supervisor']))  {  // Check for Supervisor rights and select sales from subordinates and self

$queryle = "SELECT count(ID) as leads from ".$companies." WHERE companyStatus='lead' and salesRepID like (SELECT userID FROM ".$users." WHERE supervisorID=".$_SESSION['userID'].") or salesRepID=".$_SESSION['userID']; 
$queryo = "SELECT count(ID) as opportunities from ".$companies." WHERE companyStatus='opportunity' and salesRepID in (SELECT userID FROM ".$users." WHERE supervisorID=".$_SESSION['userID'].") or salesRepID=".$_SESSION['userID'];
$queryc = "SELECT count(ID) as customers from ".$companies." WHERE companyStatus='customer' and ".$companies.".salesRepID in (SELECT userID FROM ".$users." WHERE supervisorID=".$_SESSION['userID'].") or salesRepID=".$_SESSION['userID'];
$querylo = "SELECT count(ID) as lost from ".$companies." WHERE companyStatus='lost' and salesRepID in (SELECT userID FROM ".$users." WHERE supervisorID=".$_SESSION['userID'].") or salesRepID=".$_SESSION['userID'];
$sales_title = $LANG['sales_per_salesrep'];

} else if(isset($_SESSION['salesModule']))  {  
$queryle = "SELECT count(ID) as leads from ".$companies." WHERE companyStatus='lead' and salesRepID=:userID";
$queryo = "SELECT count(ID) as opportunities from ".$companies." WHERE companyStatus='opportunity' and salesRepID=".$_SESSION['userID'];
$queryc = "SELECT count(ID) as customers from ".$companies." WHERE companyStatus='customer' and salesRepID=".$_SESSION['userID'];
$querylo = "SELECT count(ID) as lost from ".$companies." WHERE companyStatus='lost' and salesRepID=".$_SESSION['userID'];
$sales_title = $LANG['my_sales'];
}

try {
    $stmt = $pdo->prepare($queryle);
    $stmt->bindParam(':userID', $_SESSION['userID']);
    $stmt->execute();
    $Row= $stmt->fetch(PDO::FETCH_ASSOC);
    $leads = Row['leads']; 
} catch (PDOException $e) {
    echo "Data was not fetched, because: ".$e->getMessage();
}





$opportunities = mysql_num_rows($queryo); 
$customers = mysql_num_rows($queryc); 
$lost = mysql_num_rows($querylo); 

?>
<table summary="" style="border:0px;cell-spacing:0px">
<tr>
<td valign="top" width="180">
<h1><?php print $LANG['sales_system'];?></h1>
				
	<a href="show_customer.php?status=lead"><img src="images/folder_green_32.png" style="border:0px;vertical-align:middle;" alt="" /></a> <a href="show_customer.php?status=lead"><?php print $LANG['leads'];?></a>
	<span style="color:#777777">(<?php print $leads;?>)</span>
	<br>
   <a href="show_customer.php?status=opportunity"><img src="images/folder_red_32.png" style="border:0px;vertical-align:middle;" alt="" /></a> <a href="show_customer.php?status=opportunity"><?php print $LANG['opportunities'];?></a>
	<span style="color:#777777">(<?php print $opportunities;?>)</span>	
	<br>         
   <a href="show_customer.php?status=customer"><img src="images/folder_yellow_32.png" style="border:0px;vertical-align:middle;" alt="" /></a> <a href="show_customer.php?status=customer"><?php print $LANG['sales'];?></a>
	<span style="color:#777777">(<?php print $customers;?>)</span>	
	<br>			
	<a href="show_customer.php?status=lost"><img src="images/folder_brown_32.png" style="border:0px;vertical-align:middle;" alt="" /></a> <a href="show_customer.php?status=lost"><?php print $LANG['lost'];?></a>
	<span style="color:#777777">(<?php print $lost;?>)</span>	
	<br><br>        
   <a href="show_callinglists.php"><img src="images/folder_blue_32.png" style="border:0px;vertical-align:middle;" alt="" /></a> <a href="show_callinglists.php"><?php print $LANG['calling_lists'];?></a>
</td>
<td width="20">&nbsp;</td>
<td valign="top">

<?php
$queryYear = "SELECT YEAR(orderDate) as year from ".$orders." Group by year ORDER BY year desc";

try {
    $resultYear = $pdo->query($queryYear);
} catch (PDOException $e) {
    echo "Data was not fetched, because: ".$e->getMessage();
}
?>

<h1><?php print $sales_title;?> <select id="year" style="font-size:12px" onchange="document.getElementById('repGraphArea').src='modules/sales/get_salesreps_chart.php?year='+(this.value)+'&type='+document.getElementById('graphType').value;">
<?php 
foreach($resultYear as $RowYear {
?>
<option value="<?php print $RowYear['year'];?>"><?php print $RowYear['year'];?></option>
<?php 
}
?>

</select> 

<select id="graphType" style="font-size:12px" onchange="document.getElementById('repGraphArea').src='modules/sales/get_salesreps_chart.php?type='+(this.value)+'&year='+document.getElementById('year').value;">
<option value="Bar"><?php print $LANG['bar_graph'];?></option>
<option value="Line"><?php print $LANG['line_graph'];?></option>
<option value="Pie"><?php print $LANG['pie_graph'];?></option>
</select>

</h1>

<iframe id="repGraphArea" style="height:220px;width:420px;border:none;margin:0;padding:0" src="modules/sales/get_salesreps_chart.php"></iframe>


</td>
<td width="20">&nbsp;</td>
<td valign="top">

<h1><?php print $LANG['sales_per_month'];?> 
<?php
$queryYear = "SELECT YEAR(orderDate) as year from ".$orders." Group by year ORDER BY year desc";
try {
    $resultYear = $pdo->query($queryYear);
} catch (PDOException $e) {
    echo "Data was not fetched, because: ".$e->getMessage();
}
?>
<select id="year2" style="font-size:12px" onchange="document.getElementById('monthlyGraphArea').src='modules/sales/get_monthly_chart.php?year='+(this.value)+'&type='+document.getElementById('graphType2').value;">
<?php 
foreach($resultYear as $RowYear {
?>
<option value="<?php print $RowYear['year'];?>"><?php print $RowYear['year'];?></option>
<?php 
}
?>

</select> 


<select id="graphType2" style="font-size:12px" onchange="document.getElementById('monthlyGraphArea').src='modules/sales/get_monthly_chart.php?type='+(this.value)+'&year='+document.getElementById('year2').value;">
<option value="Bar"><?php print $LANG['bar_graph'];?></option>
<option value="Line"><?php print $LANG['line_graph'];?></option>
<option value="Pie"><?php print $LANG['pie_graph'];?></option>
</select>
 



</h1>

<iframe id="monthlyGraphArea" style="height:220px;width:420px;border:none;margin:0;padding:0" src="modules/sales/get_monthly_chart.php"></iframe>

</td>
</tr>		                        
</table>                       
