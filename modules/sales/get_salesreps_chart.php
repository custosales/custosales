<?php
session_start();
if (!isset($_SESSION['userID'])) { // check if user is logged in
    header("Location: ../index.php");
}

include_once "../system/db.php";

if ($_GET['year'] == "") {
    $year = date('Y');
} else {
    $year = $_GET['year'];
}

if ($_GET['type'] == "") {
    $type = "Bar";
} else {
    $type = $_GET['type'];
}

$projectID = $_SESSION['project'];

$valuesS = "";

// check for admin rights and select all sales 
if (isset($_SESSION['admin'])) {
$querys = "SELECT salesRepID, fullName, sum(unitPrice) as orderValue 
FROM " . $orders . " o INNER JOIN ".$users." u ON o.salesRepID = u.userId  
WHERE YEAR(orderDate)=" . $year . " 
GROUP by salesRepID 
ORDER BY orderValue desc";

// check for supervisor rights and select sales from subordinates 

} else if (isset($_SESSION['supervisor'])) {

$querys = "SELECT salesRepID, fullName, sum(unitPrice) as orderValue 
FROM " . $orders . " o INNER JOIN ".$users." u ON o.salesRepID = u.userId  
WHERE YEAR(orderDate)=" . $year . " && salesRepID IN (SELECT userID FROM " . $users . " WHERE supervisorID=" . $_SESSION['userID'] . ") 
OR salesRepID=" . $_SESSION['userID'] . " 
GROUP by salesRepID 
ORDER BY orderValue desc";

// select users own sales 

} else {

$querys = "SELECT salesRepID, fullName, sum(o.unitPrice) as orderValue, countBased, productName   
FROM " . $orders . "  o INNER JOIN " . $products . " p ON o.productID = p.productID
INNER JOIN ".$users." u ON o.salesRepID = u.userId    
WHERE YEAR(orderDate)=" . $year . " && salesRepID=" . $_SESSION['userID'] . " 
GROUP by productName 
ORDER BY orderValue desc";
}

try {
    $Results = $pdo->query($querys);
} catch (PDOException $e) {
    echo "Sales Data was not fetched, because: " . $e->getMessage();
}

foreach ($Results as $Rows) {

// Get user's Full Name

    $queryName = "SELECT fullName FROM " . $users . " WHERE userID=:userID";

    try {
        $stmt = $pdo->prepare($queryName);
        $stmt->bindParam(':userID', $Rows['salesRepID']);
        $stmt->execute();
        $Rowname = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Name Data was not fetched, because: " . $e->getMessage();
    }

// Get y-axis values for different chart types 
    if ($type == "Pie") {

        if (isset($_SESSION['admin']) || isset($_SESSION['supervisor'])) {
            // Show salesreps' names for admin or supervisors
            $valuesS = $valuesS . ",['" . substr($Rowname['fullName'], 0, strpos($Rowname['fullName'], " ")) . "'," . $Rows['orderValue'] . "]";
        } else {
            //Show product Names for own sale
            $valuesS = $valuesS . ",['" . $Rows['productName'] . "'," . $Rows['orderValue'] . "]";
        }
    
// Get y-axis values for all other charts 
    } else {
        $valuesS = $valuesS . "," . $Rows['orderValue'];
    }

// Get x-axis values 
    if (isset($_SESSION['admin']) || isset($_SESSION['supervisor'])) {
// Show salesreps' names for admin or supervisors
        $x_axisS = $x_axisS . ",'" . substr($Rowname['fullName'], 0, strpos($Rowname['fullName'], " ")) . "'";
    } else {
//Show product Names for own sale
        $x_axisS = $x_axisS . ",'" . $Rows['productName'] . "'";
    }
    $repID = $repID . "," . $Rows['salesRepID'];
}


$valuesS = substr($valuesS, 1);

$x_axisS = substr($x_axisS, 1);
$repID = substr($repID, 1);
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



            // Charts	  
            var s1 = [<?php print $valuesS; ?>];
            var ticks = [<?php print $x_axisS; ?>];
            var repID = [<?php print $repID; ?>];
            plot1 = $.jqplot('salesGraph', [s1], {

            seriesDefaults:{
            renderer:$.jqplot.<?php print $type; ?>Renderer,
<?php if ($type != "Pie") { ?>
                pointLabels: { show: true }

<?php } else { ?>

                rendererOptions: {
                showDataLabels: true
                }

<?php } ?>
            },
<?php if ($type == "Pie") { ?>

                legend:{
                show:true,
                        placement: 'inside',
                        rendererOptions: {
                        numberRows: 30
                        },
                        location:'e',
                        marginTop: '5px'
                },
<?php } else { ?>
                axes: {
                xaxis: {
                renderer: $.jqplot.CategoryAxisRenderer,
                        ticks: ticks
                }
                },
<?php } ?>
            highlighter: { show: false }
            });
            $('#salesGraph').bind('jqplotDataClick',
                    function (ev, seriesIndex, pointIndex) {
                    document.location = '../reports/get_salesrep_charts.php?userID=' + repID[pointIndex];
                    }
            );
            });
        </script>
    </head>
    <body style="font-size:12px;">
        <div id="salesGraph" style="height:200px;width:100%"></div>
    </body>
</html>