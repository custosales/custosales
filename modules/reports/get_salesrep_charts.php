<?php
session_start();
if(!isset($_SESSION['userID'])) { // check if user is logged in
header("Location: ../index.php");
}

require_once "../system/db.php";
require_once "../../lang/".$_SESSION['lang'].".php";

if($_GET['year']!="") {
$year = $_GET['year'];
} else {
$year = date("Y");
}


$userID = $_GET['userID'];

// select users own sales per month
$queryM = "SELECT MONTH(orderDate) as orderMonth, sum(unitPrice) as orderValue, fullName FROM ".$orders.",".$users." WHERE ".$users.".userID=".$userID." AND salesRepID=".$userID." and year(orderDate)=".$year." GROUP by orderMonth";


try {
    $ResultM = $pdo->query($queryM);
} catch (PDOException $e) {
    echo "User Sales Data was not fetched, because: " . $e->getMessage() . $resultQuery;
}

       
foreach($ResultM as $RowM) {


    $valuesM = $valuesM.",".$RowM['orderValue'];
$x_axisM = $x_axisM.",'".$LANG['MS'][$RowM['orderMonth']]."'";
$fullName = $RowM['fullName'];
}

$valuesM = substr($valuesM,1);
$x_axisM = substr($x_axisM,1);

// select users own sales per week
$queryW = "SELECT Week(orderDate) as orderWeek, sum(unitPrice) as orderValue, fullName FROM ".$orders.",".$users." WHERE ".$users.".userID=".$userID." AND salesRepID=".$userID." and year(orderDate)=".$year." GROUP by orderWeek";


if (!$ResultW= mysql_query($queryW, $Link)) {
           print "No database connection <br>".mysql_error();
        } 
        
while($RowW = mysql_fetch_array($ResultW)) {
$valuesW = $valuesW.",".$RowW['orderValue'];
$x_axisW = $x_axisW.",'".$RowW['orderWeek']."'";
$fullName = $RowW['fullName'];
}

$valuesW = substr($valuesW,1);
$x_axisW = substr($x_axisW,1);

// select users own sales per month
$queryD = "SELECT day(orderDate) as orderDay, orderDate, sum(unitPrice) as orderValue, fullName FROM ".$orders.",".$users." WHERE ".$users.".userID=".$userID." AND salesRepID=".$userID." and year(orderDate)=".$year." GROUP by orderDate";


if (!$ResultD= mysql_query($queryD, $Link)) {
           print "No database connection <br>".mysql_error();
        } 
        
while($RowD = mysql_fetch_array($ResultD)) {
$valuesD = $valuesD.",".$RowD['orderValue'];
$x_axisD = $x_axisD.",'".substr($RowD['orderDate'],8,2)."-".substr($RowD['orderDate'],5,2)."'";
$fullName = $RowD['fullName'];
}

$valuesD = substr($valuesD,1);
$x_axisD = substr($x_axisD,1);


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
		
		// Monthly sales chart	
		var s1 = [<?php print $valuesM;?>];
        var ticks1 = [<?php print $x_axisM;?>];
        var Title = '<?php print $LANG['sales_per_month']." - ".$fullName;?>';

        plot1 = $.jqplot('monthlyGraph', [s1], {
            seriesDefaults:{
                pointLabels: { show: true }
            },
            axes: {
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks: ticks1
                }
            },
            highlighter: { show: false },
            title: Title,  
        });

		// Weekly sales chart	
		var s2 = [<?php print $valuesW;?>];
        var ticks2 = [<?php print $x_axisW;?>];
        var Title = '<?php print $LANG['sales_per_week']." - ".$fullName;?>';

        plot2 = $.jqplot('weeklyGraph', [s2], {
            seriesDefaults:{
                pointLabels: { show: true }
            },
            axes: {
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks: ticks2
                }
            },
            highlighter: { show: false },
            title: Title,  
        });

		// Daily sales chart	
		var s3 = [<?php print $valuesD;?>];
        var ticks3 = [<?php print $x_axisD;?>];
        var Title = '<?php print $LANG['sales_per_day']." - ".$fullName;?>';

        plot3 = $.jqplot('dailyGraph', [s3], {
            seriesDefaults:{
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
<body style="font-size:12px">
<div id="monthlyGraph" style="width:100%;height:210px;margin-bottom:4px;"></div>
<div id="weeklyGraph" style="width:100%;height:210px;margin-bottom:4px;"></div>
<div id="dailyGraph" style="width:100%;height:210px"></div>

</body>
</html>
