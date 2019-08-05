<?php
session_start();
if (!isset($_SESSION['userID'])) { // check if user is logged in
    header("Location: ../index.php");
}

require_once "../system/db.php";
require_once "../../lang/" . $_SESSION['lang'] . ".php";

$orderStatusID = $_GET['orderStatusID'];


if ($_GET['year'] == "") {
    $year = date('Y');
} else {
    $year = $_GET['year'];
}


if ($_GET['type'] == "") {
    $type = "Line";
} else {
    $type = $_GET['type'];
}

if ($orderStatusID == "") { // show all stages
    $queryO = "SELECT MONTH(orderDate) as Month, sum(unitPrice) as orderValue, orderStatusName FROM " . $orders . ", " . $orderstatus . " WHERE YEAR(orderDate)=" . $year . " and " . $orders . ".orderStatusID=" . $orderstatus . ".orderStatusID 
GROUP BY orderStatusName 
ORDER BY " . $orderstatus . ".orderStatusID";
} else if ($orderStatusID == "0") { // show cash flow
    $queryO = "SELECT MONTH(DATE_ADD(orderDate, INTERVAL creditDays DAY)) as Month, sum(unitPrice) as orderValue FROM " . $orders . " WHERE YEAR(orderDate)=" . $year . " GROUP by Month";
    $statusName = $LANG['cash_flow'];
} else { // show individual order stage
    $queryO = "SELECT MONTH(orderDate) as Month, sum(unitPrice) as orderValue FROM " . $orders . " WHERE YEAR(orderDate)=" . $year . " and orderStatusID=" . $orderStatusID . " GROUP by Month";
    $query = "SELECT orderStatusName FROM " . $orderstatus . " WHERE orderStatusID=" . $orderStatusID;

    try {
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $Row = $stmt->fetch(PDO::FETCH_ASSOC);
        $statusName = $Row['orderStatusName'];
    } catch (PDOException $e) {
        echo "1 - Data was not fetched, because: " . $e->getMessage();
    }
}

    try {
        $ResultO = $pdo->query($queryO);
    } catch (PDOException $e) {
        echo "2 - Data was not fetched, because: " . $e->getMessage();
    }

    foreach ($ResultO as $orderFlow) {

        $valuesO = $valuesO . "," . $orderFlow['orderValue'];

        if ($orderStatusID == "") { // show order stage names
            $x_axisO = $x_axisO . ",'" . substr($orderFlow['orderStatusName'], 0, 11) . "'";
        } else { // show months
            $x_axisO = $x_axisO . ",'" . $LANG['MS'][$orderFlow['Month']] . "'";
        }
    }

    $valuesY = substr($valuesO, 1);
    $valuesX = substr($x_axisO, 1);
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

            <script type="text/javascript" >$(document).ready(function () {
                    var s3 = [<?php print $valuesY; ?>];
                    var ticks3 = [<?php print $valuesX; ?>];
                    var Title = '<?php print $statusName; ?>';

                plot3 = $.jqplot('graphen', [s3], {
                    seriesDefaults: {
                        //renderer:$.jqplot.BarRenderer,
                        pointLabels: {show: true}
                    },
                    axes: {
                        xaxis: {
                            renderer: $.jqplot.CategoryAxisRenderer,
                            ticks: ticks3
                        }
                    },
                    highlighter: {show: false},
                    title: Title,
                });
            });
        </script>
    </head>

    <div id="graphen" style="width:100%;height:200px"></div>


