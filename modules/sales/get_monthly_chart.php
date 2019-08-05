<?php
session_start();
if (!isset($_SESSION['userID'])) { // check if user is logged in
    header("Location: ../index.php"); // if not go to login
}
require_once "../system/db.php";  // get pdo connection settings
// require_once "../lang/" . $_SESSION['lang'] . ".php"; // get language array


if (!isset($_GET['year'])) {
    // $year = date('Y');
    $year = '2017';
} else {
    $year = $_GET['year'];
}


if (!isset($_GET['type'])) {
    $type = "Line";
} else {
    $type = $_GET['type'];
}

$valuesM = "";
if (isset($_SESSION['admin'])) {  // check for admin rights and show all monthly sales
    $queryM = "SELECT MONTH(orderDate) as orderMonth, sum(unitPrice) as orderValue FROM " . $orders . " WHERE YEAR(orderDate)=" . $year . " GROUP by orderMonth";
} elseif (isset($_SESSION['supervisor'])) { // check for supervisor rights and show monthly sales for subordinates  
    $queryM = "SELECT MONTH(orderDate) as orderMonth, sum(unitPrice) as orderValue FROM " . $orders . ", " . $users . " 
WHERE YEAR(orderDate)=" . $year . " && salesRepID IN (SELECT userID FROM " . $users . " WHERE supervisorID=" . $_SESSION['userID'] . ") OR salesRepID=" . $_SESSION['userID'] . " GROUP by orderMonth";
} else {  // select users own sales per month
    $queryM = "SELECT MONTH(orderDate) as orderMonth, sum(unitPrice) as orderValue FROM " . $orders . " 
WHERE YEAR(orderDate)=" . $year . " && salesRepID=" . $_SESSION['userID'] . " GROUP by orderMonth";
}

try {
    $ResultM = $pdo->query($queryM);
} catch (PDOException $e) {
    echo "1 - Data was not fetched, because: " . $e->getMessage();
}

foreach ($ResultM as $RowM) {

    if ($type == "Pie") {
        $valuesM = $valuesM . ",['" . $LANG['MS'][$RowM['orderMonth']] . "'," . $RowM['orderValue'] . "]";
    } else {
        $valuesM = $valuesM . "," . $RowM['orderValue'];
    }



    $x_axisM = $x_axisM . ",'" . $LANG['MS'][$RowM['orderMonth']] . "'";
}

$valuesM = substr($valuesM, 1);
$x_axisM = substr($x_axisM, 1);
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

    <script type="text/javascript">
        $(document).ready(function() {

            // Charts	  
            var s1 = [<?php print $valuesM; ?>];
            var ticks = [<?php print $x_axisM; ?>];
            plot1 = $.jqplot('salesGraph', [s1], {

                seriesDefaults: {
                    renderer: $.jqplot.<?php print $type; ?>Renderer,
                    <?php if ($type != "Pie") { ?>
                        pointLabels: {
                            show: true
                        }

                    <?php } else { ?>

                        rendererOptions: {
                            showDataLabels: true
                        }

                    <?php } ?>
                },
                <?php if ($type == "Pie") { ?>

                    legend: {
                        show: true,
                        placement: 'inside',
                        rendererOptions: {
                            numberRows: 6
                        },
                        location: 'e',
                        marginTop: '15px'
                    },
                <?php } else { ?>
                    axes: {
                        xaxis: {
                            renderer: $.jqplot.CategoryAxisRenderer,
                            ticks: ticks
                        }
                    },
                <?php } ?>
                highlighter: {
                    show: false
                }
            });
            $('#salesGraph').bind('jqplotDataClick',
                function(ev, seriesIndex, pointIndex, data) {
                    alert('series: ' + seriesIndex + ', point: ' + pointIndex + ', data: ' + data);
                }
            );
        });
    </script>
</head>

<body style="font-size:12px;">
    <div id="salesGraph" style="height:200px;width:100%"></div>
</body>

</html>