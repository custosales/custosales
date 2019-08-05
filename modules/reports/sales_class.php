<?php
/**
 * Description of sales_class 
 * Functions to produce Sales Reports.
 * @author Terje Berg-Hansen
 */
class SalesReport 
{

   
	function userMonthlySales($userID,$period,$year, $format,$Link,$LANG) {   
		
		if($year == "") {		
				$year = date("Y");
				}
		$query = "SELECT sum(unitPrice) as Sales,	
   	avg(unitPrice) as Average,
   	Year(orderDate) as Year,
   	orderDate,
   	".$period."(orderDate) as Period,
   	count(unitPrice) as Number,
   	MAX(unitPrice) as Max,
		MIN(unitPrice) as Min 
   	From Orders WHERE salesRepID = ".$userID."  
		and year(orderDate)=".$year."    	
   	GROUP BY Period ORDER by orderDate";

	$Result = mysql_query($query, $Link) or die(MySql_error());


if($format == "tr") { // print table heading
	
print "<br>";
print "<table id=\"example\" style=\"font-size:13px\">";
print "<tr style=\"text-align:left\"><th colspan=\"5\">".$LANG['sales_per_'.$period]."</th></tr>";
print "<tr style=\"text-align:left\">
<th style=\"width:75px;\">".$LANG[$period]."</th>
<th style=\"width:45px;\">".$LANG['number_of_sales']."</th>
<th style=\"width:75px;\">".$LANG['sum']."</th>
<th style=\"width:75px;\">".$LANG['average_sale']."</th>
<th style=\"width:75px;\">".$LANG['max_sale']."</th>
<th style=\"width:75px;\">".$LANG['min_sale']."</th>
</tr>";
}



	while($Row=MySQL_fetch_array($Result)) {
	
	if($format == "tr") { // print as table row
	if($period=="month") {
	print "<tr><td>".$Row['Year']."-".$LANG['MS'][$Row['Period']]."</td>";
	}

	if($period=="week") {
	print "<tr><td>".$Row['Year']."-".$Row['Period']."</td>";
	}

	if($period=="day") {
	print "<tr><td>".$Row['orderDate']."</td>";
	}
	
	print "<td>".$Row['Number']."</td> 
	<td>".$LANG['currency_symbol']." ".number_format($Row['Sales'], 0, ',', ' ')."</td>
	<td>".$LANG['currency_symbol']." ".number_format($Row['Average'], 0, ',', ' ')."</td>
	<td>".$LANG['currency_symbol']." ".number_format($Row['Max'], 0, ',', ' ')."</td>
	<td>".$LANG['currency_symbol']." ".number_format($Row['Min'], 0, ',', ' ')."</td></tr>";	
	} // end format table row

	if($format == "-") { // print as line with - separation
	print $Row['Year']."-".$LANG['MS'][$Row['Period']]."-".$Row['Sales']."-".$Row['Average']."-".$Row['Max']."-".$Row['Min']."<br>";	
	} // end format line with - separation

	
	} // end while	

	if($format == "tr") { // print table end
	print "</table>";
	} 
	
	} // end function userMonthlySales
 
  
 
} // end class


?>