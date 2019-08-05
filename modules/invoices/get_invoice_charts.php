<?php
session_start();
if(!isset($_SESSION['userID'])) { // check if user is logged in
header("Location: ../index.php");
}

require_once "../system/db.php";
require_once "../../lang/".$_SESSION['lang'].".php";

$orderStatusID = $_GET['orderStatusID'];



if($orderStatusID=="0" || $orderStatusID=="") {
$queryO = "SELECT MONTH(DATE_ADD(orderDate, INTERVAL creditDays DAY)) as Month, sum(unitPrice) as orderValue FROM ".$orders." GROUP by Month";
$statusName = $LANG['cash_flow'];
}else {
$queryO = "SELECT MONTH(orderDate) as Month, sum(unitPrice) as orderValue FROM ".$orders." WHERE YEAR(orderDate)=YEAR(NOW()) and orderStatusID=".$orderStatusID." GROUP by Month";
$query = "SELECT orderStatusName FROM ".$orderstatus." WHERE orderStatusID=".$orderStatusID;
if (!$Result= mysql_db_query($DBName, $query, $Link)) {
           	print "No database connection <br>".mysql_error();
        } else {
			$Row=MySQL_fetch_array($Result);
			$statusName = $Row['orderStatusName'];
			}

}


if (!$ResultO= mysql_db_query($DBName, $queryO, $Link)) {
           print "No database connection <br>".mysql_error();
        } 
        
while($orderFlow = mysql_fetch_array($ResultO)) {

$valuesO = $valuesO.",".$orderFlow['orderValue'];
$x_axisO = $x_axisO.",'".$LANG['MS'][$orderFlow['Month']]."'";

		}

$valuesY = substr($valuesO,1);
$valuesX = substr($x_axisO,1);



?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
	
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		
		    <script type="text/javascript" language="javascript" src="../../lib/datatables/media/js/jquery.js"></script>
<link rel="stylesheet" type="text/css" href="../../lib/jquery/jquery.jqplot.css" />		
  <script language="javascript" type="text/javascript" src="../../lib/jquery/jquery.jqplot.js"></script> 
  <script language="javascript" type="text/javascript" src="../../lib/jquery/plugins/jqplot.barRenderer.js"></script>
  <script language="javascript" type="text/javascript" src="../../lib/jquery/plugins/jqplot.pieRenderer.js"></script>
  <script language="javascript" type="text/javascript" src="../../lib/jquery/plugins/jqplot.categoryAxisRenderer.js"></script>
  <script language="javascript" type="text/javascript" src="../../lib/jquery/plugins/jqplot.highlighter.js"></script>
  <script language="javascript" type="text/javascript" src="../../lib/jquery/plugins/jqplot.pointLabels.js"></script>	

<script type="text/javascript" >$(document).ready(function(){
		var s3 = [<?php print $valuesY;?>];
        var ticks3 = [<?php print $valuesX;?>];
        var Title = '<?php print $statusName;?>';

        plot3 = $.jqplot('graphen', [s3], {
            seriesDefaults:{
                //renderer:$.jqplot.BarRenderer,
                pointLabels: { show: true }
            },
            axes: {
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks: ticks3
                }
            },
            highlighter: { show: false },
            title: Title,  
        });
          });
</script>
</head>

<div id="graphen" style="width:400px;height:200px"></div>


