<?php
session_start();
if(!isset($_SESSION['userID'])) { // check if user is logged in
header("Location: ../index.php");
}

include_once "../system/db.php";

if($_GET['year']=="") {
	$year = date('Y');
	} else {
	$year = $_GET['year'];
	}

if($_GET['type']=="") {
	$type = "bar";
	} else {
	$type = $_GET['type'];
	}


$valuesS ="";
if(isset($_SESSION['admin'])) {  // check for admin rights and select all sales 
$querys = "SELECT salesRepID, sum(unitPrice) as orderValue FROM ".$orders." WHERE YEAR(orderDate)=".$year." GROUP by salesRepID ORDER BY orderValue desc";


} elseif(isset($_SESSION['supervisor']) ) {  // check for supervisor rights and select sales from subordinates 
$querys = "SELECT salesRepID, sum(unitPrice) as orderValue FROM ".$orders." WHERE YEAR(orderDate)=".$year." && salesRepID IN (SELECT userID FROM ".$users." WHERE supervisorID=".$_SESSION['userID'].") OR salesRepID=".$_SESSION['userID']." GROUP by salesRepID ORDER BY orderValue desc";


} else {  // select users own sales 
$querys = "SELECT salesRepID, sum(unitPrice) as orderValue FROM ".$orders." WHERE YEAR(orderDate)=".$year." && salesRepID=".$_SESSION['userID']." GROUP by salesRepID ORDER BY orderValue desc";

}

try {
    $result = $pdo->query($querys);
} catch (PDOException $e) {
    echo "Data was not fetched, because: ".$e->getMessage();
}

foreach($result as $Rows) {

$queryName = "SELECT fullName FROM ".$users." WHERE userID=:userID";

try {
    $stmt = $pdo->prepare($queryName);
    $stmt->bindParam(':userID', $Rows['salesRepID']);
    $stmt->execute();
    $Rowname = $stmt->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Data was not fetched, because: ".$e->getMessage();
}

$valuesS = $valuesS.",".$Rows['orderValue'];
$x_axisS = $x_axisS.",'".substr($Rowname['fullName'],0, strpos($Rowname['fullName']," "))."'";
		}

$valuesS = substr($valuesS,1);
$x_axisS = substr($x_axisS,1);



$valuesM ="";
if(isset($_SESSION['admin']) ) {  // check for admin rights and show all monthly sales
$queryM = "SELECT MONTH(orderDate) as orderMonth, sum(unitPrice) as orderValue FROM ".$orders." WHERE YEAR(orderDate)=".$year." GROUP by orderMonth";

} elseif(isset($_SESSION['supervisor'])) { // check for supervisor rights and show monthly sales for subordinates  
$queryM = "SELECT MONTH(orderDate) as orderMonth, sum(unitPrice) as orderValue FROM ".$orders.", ".$users." 
WHERE YEAR(orderDate)=".$year." && salesRepID IN (SELECT userID FROM ".$users." WHERE supervisorID=".$_SESSION['userID'].") OR salesRepID=".$_SESSION['userID']." GROUP by orderMonth";

} else {  // select users own sales per month
$queryM = "SELECT MONTH(orderDate) as orderMonth, sum(unitPrice) as orderValue FROM ".$orders." 
WHERE YEAR(orderDate)=".$year." && salesRepID=".$_SESSION['userID']." GROUP by orderMonth";
}

try {
    $resultM = $pdo->query($queryM);
} catch (PDOException $e) {
    echo "Data was not fetched, because: ".$e->getMessage();
}

foreach($rsultM as $rowM) {

$valuesM = $valuesM.",".$RowM['orderValue'];
$x_axisM = $x_axisM.",'".$LANG['MS'][$RowM['orderMonth']]."'";
		}

$valuesM = substr($valuesM,1);
$x_axisM = substr($x_axisM,1);

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

<script type="text/javascript" >

function createCharts() {
	// Charts	  
        var s1 = [<?php print $valuesS;?>];
        var ticks = [<?php print $x_axisS;?>];
        
        plot1 = $.jqplot('salesGraph', [s1], {
            seriesDefaults:{
                renderer:$.jqplot.BarRenderer,
                pointLabels: { show: true }
            },
            axes: {
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks: ticks
                }
            },
            highlighter: { show: false }
        });
    
        $('#salesGraph').bind('jqplotDataClick', 
            function (ev, seriesIndex, pointIndex, data) {
                $('#info1').html('series: '+seriesIndex+', point: '+pointIndex+', data: '+data);
            }
        );

        var s2 = [<?php print $valuesM;?>];
        var ticks2 = [<?php print $x_axisM;?>];


        plot2 = $.jqplot('monthlySales', [s2], {
            seriesDefaults:{
                renderer:$.jqplot.BarRenderer,
                pointLabels: { show: true }
            },
            axes: {
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks: ticks2
                }
            },
            highlighter: { show: false }
        });
    
        $('#monthlySales').bind('jqplotDataClick', 
            function (ev, seriesIndex, pointIndex, data) {
                $('#info1').html('series: '+seriesIndex+', point: '+pointIndex+', data: '+data);
            }
        );
        
        
		  var s3 = [<?php print $values;?>];
        var ticks3 = [<?php print $x_axis;?>];


        plot3 = $.jqplot('cashFlow', [s3], {
            seriesDefaults:{
                renderer:$.jqplot.BarRenderer,
                pointLabels: { show: true }
            },
            axes: {
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks: ticks3
                }
            },
            highlighter: { show: false }
        });
    
        $('#cashFlow').bind('jqplotDataClick', 
            function (ev, seriesIndex, pointIndex, data) {
                $('#info1').html('series: '+seriesIndex+', point: '+pointIndex+', data: '+data);
            }
        );              
        
        

          }

createCharts();

</script>


