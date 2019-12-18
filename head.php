<?php
ini_set('session.gc_maxlifetime', 360 * 60);
setlocale(LC_ALL, 'nb_NO.utf8');

if (!isset($_SESSION['userID'])) { // check if user is logged in
    header("Location:login.php");
}

if ($_GET['project'] == "all") {
    session_unregister('project');
}

if (isset($_COOKIE['style'])) {
    $_SESSION['style'] = $_COOKIE['style'];
} else if (!isset($_SESSION['style'])) {
    $_SESSION['style'] = "smoothness";
}

if ($_GET['style'] != "") {
    $_SESSION['style'] = $_GET['style'];
    setcookie('style', $_GET['style']);
}

if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = "nb_NO";
}

// include language file
include_once "lang/" . $_SESSION['lang'] . ".php";

// include database connection
include_once "modules/system/db.php";

// Get number of user projects
$queryUserProjects = "Select count(projectID) as noUserProjects from " . $user_role . " as ur inner join ". $role_project ." as rp
ON ur.roleID = rp.roleID WHERE userID=:userID and ur.to_date = '9999-01-01' and rp.to_date = '9999-01-01' ";

try {
    $stmt = $pdo->prepare($queryUserProjects);
    $stmt->bindParam(':userID', $_SESSION['userID']);
    $stmt->execute();
    $RowPN = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Number of user projects was not fetched, because: " . $e->getMessage();
}

// Set session['noUserPojects'] as number of user projects
$_SESSION['noUserProjects'] = $RowPN['noUserProjects'];


if ($_GET['project'] != "" && $_GET['project'] != "all") {
    $_SESSION['project'] = $_GET['project'];

    $queryPN = "SELECT projectName, projectFirstSalesStage, projectFirstOrderStage from " . $projects . " WHERE projectID=:project";

    try {
        $stmt = $pdo->prepare($queryPN);
        $stmt->bindParam(':project', $_GET['project']);
        $stmt->execute();
        $RowPN = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Project Data was not fetched, because: " . $e->getMessage();
    }

    $_SESSION['projectName'] = $RowPN['projectName'];
    $_SESSION['projectFirstSalesStage'] = $RowPN['projectFirstSalesStage'];
    $_SESSION['projectFirstOrderStage'] = $RowPN['projectFirstOrderStage'];
}

if ($_GET['project'] == "all" || $_SESSION['project'] == "") {
    $_SESSION['projectName'] = $LANG['all_projects'];
}

?>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php print "CustoSales - " . $_SESSION['companyName']; ?></title>
<meta charset="UTF-8">

<script type="text/javascript" language="javascript" src="lib/datatables/media/js/jquery.js"></script>
<script type="text/javascript" language="javascript" src="lib/datatables/media/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="lib/jquery/js/jquery-ui-1.8.5.custom.min.js"></script>

<script src="lib/jquery/development-bundle/ui/jquery.ui.core.js"></script>
<script src="lib/jquery/development-bundle/ui/jquery.ui.widget.js"></script>
<script src="lib/jquery/development-bundle/ui/jquery.ui.datepicker.js"></script>
<script src="lib/jquery/development-bundle/ui/i18n/jquery.ui.datepicker-<?php print strtolower(substr($_SESSION['lang'], 3, 2)); ?>.js"></script>
<script src="lib/jquery/jquery.alerts.js"></script>

<script language="javascript" type="text/javascript" src="lib/jquery/jquery.jqplot.js"></script>
<script language="javascript" type="text/javascript" src="lib/jquery/plugins/jqplot.barRenderer.js"></script>
<script language="javascript" type="text/javascript" src="lib/jquery/plugins/jqplot.pieRenderer.js"></script>
<script language="javascript" type="text/javascript" src="lib/jquery/plugins/jqplot.categoryAxisRenderer.js"></script>
<script language="javascript" type="text/javascript" src="lib/jquery/plugins/jqplot.highlighter.js"></script>
<script language="javascript" type="text/javascript" src="lib/jquery/plugins/jqplot.pointLabels.js"></script>

<script language="javascript" type="text/javascript" src="modules/system/js/indexFunctions.js"></script>
<script language="javascript" type="text/javascript" src="modules/orders/js/orderFunctions.js"></script>
<script language="javascript" type="text/javascript" src="modules/reports/js/reportFunctions.js"></script>
<script language="javascript" type="text/javascript" src="modules/invoices/js/invoiceFunctions.js"></script>


<link rel="stylesheet" href="lib/jquery/development-bundle/themes/<?php print $_SESSION['style'] ?>/jquery.ui.all.css">
<link rel="stylesheet" href="lib/jquery/jquery.alerts.css">
<link rel="shortcut icon" href="images/stevia.ico" type="image/x-icon" />

<style type="text/css" title="currentStyle">
    @import "css/page_styles.css";
    @import "css/table_styles.css";
    @import "css/table_jui.css";
</style>

<link href="css/menu_styles.css" type="text/css" rel="stylesheet">


<script type="text/javascript">
    var lang = "<?php print strtolower(substr($_SESSION['lang'], 3, 2)); ?>"; // to be used in indexFunctions.js
    // Table Language variables
    var lLengthMenu = "<?php print $LANG['LengthMenu']; ?>";
    var lZeroRecords = "<?php print $LANG['ZeroRecords']; ?>";
    var lInfo = "<?php print $LANG['Info']; ?>";
    var lInfoEmpty = "<?php print $LANG['InfoEmpty']; ?>";
    var lInfoFiltered = "<?php print $LANG['InfoFiltered']; ?>";
    var lSearch = "<?php print $LANG['search']; ?>";
    var lFirst = "<?php print $LANG['First']; ?>";
    var lPrevious = "<?php print $LANG['Previous']; ?>";
    var lNext = "<?php print $LANG['Next']; ?>";
    var lLast = "<?php print $LANG['Last']; ?>";
</script>

<script type="text/javascript" src="lib/dashboard/js/lib/jquery.dashboard.min.js"></script>

<script type="text/javascript">
    // This is the code for definining the dashboard
    $(document).ready(function() {

        // Tabs
        $('#tabs').tabs();


        // load the templates
        $('body').append('<div id="templates"></div>');
        $("#templates").hide();
        $("#templates").load("lib/dashboard/templates.html", initDashboard);



        function initDashboard() {

            // to make it possible to add widgets more than once, we create clientside unique id's
            // this is for demo purposes: normally this would be an id generated serverside
            var startId = <?php print $_SESSION['userID']; ?>;

            var dashboard = $('#dashboard').dashboard({
                // layout class is used to make it possible to switch layouts
                layoutClass: 'layout',
                // feed for the widgets which are on the dashboard when opened
                json_data: {
                    url: "lib/dashboard/jsonfeed/startupwidgets.php"
                },

                // stateChangeUrl : "lib/dashboard/savemydashoard.php",

                // json feed; the widgets which you can add to your dashboard
                addWidgetSettings: {
                    widgetDirectoryUrl: "lib/dashboard/jsonfeed/widgetcategories.json"
                },

                // Definition of the layout
                // When using the layoutClass, it is possible to change layout using only another class. In this case
                // you don't need the html property in the layout

                layouts: [{
                        title: "Layout1",
                        id: "layout1",
                        image: "lib/dashboard/layouts/layout1.png",
                        html: '<div class="layout layout-a"><div class="column first column-first"></div></div>',
                        classname: 'layout-a'
                    },
                    {
                        title: "Layout2",
                        id: "layout2",
                        image: "lib/dashboard/layouts/layout2.png",
                        html: '<div class="layout layout-aa"><div class="column first column-first"></div><div class="column second column-second"></div></div>',
                        classname: 'layout-aa'
                    },
                    {
                        title: "Layout3",
                        id: "layout3",
                        image: "lib/dashboard/layouts/layout3.png",
                        html: '<div class="layout layout-ba"><div class="column first column-first"></div><div class="column second column-second"></div></div>',
                        classname: 'layout-ba'
                    },
                    {
                        title: "Layout4",
                        id: "layout4",
                        image: "lib/dashboard/layouts/layout4.png",
                        html: '<div class="layout layout-ab"><div class="column first column-first"></div><div class="column second column-second"></div></div>',
                        classname: 'layout-ab'
                    },
                    {
                        title: "Layout5",
                        id: "layout5",
                        image: "lib/dashboard/layouts/layout5.png",
                        html: '<div class="layout layout-aaa"><div class="column first column-first"></div><div class="column second column-second"></div><div class="column third column-third"></div></div>',
                        classname: 'layout-aaa'
                    }
                ]

            }); // end dashboard call

            // binding for a widgets is added to the dashboard
            dashboard.element.live('dashboardAddWidget', function(e, obj) {
                var widget = obj.widget;

                dashboard.addWidget({
                    "id": startId++,
                    "title": widget.title,
                    "url": widget.url,
                    "metadata": widget.metadata
                }, dashboard.element.find('.column:first'));
            });

            // the init builds the dashboard. This makes it possible to first unbind events before the dashboars is built.
            dashboard.init();
        }
    });
</script>



<link rel="stylesheet" type="text/css" href="lib/dashboard/themes/default/dashboardui.css" />


<link rel="stylesheet" type="text/css" href="lib/jquery/jquery.jqplot.css" />
<script class="code" type="text/javascript">
    var addProduct = "<?php print $LANG['addProduct']; ?>"
    var editProduct = "<?php print $LANG['editProduct']; ?>"

    var addUser = "<?php print $LANG['add_user']; ?>"
    var editUser = "<?php print $LANG['edit_user']; ?>"

    var addRole = "<?php print $LANG['add_role']; ?>"
    var editRole = "<?php print $LANG['edit_role']; ?>"

    var addCurrencie = "<?php print $LANG['add_currency']; ?>"
    var editCurrencie = "<?php print $LANG['edit_currency']; ?>"

    var addContract = "<?php print $LANG['add_contract']; ?>"
    var editContract = "<?php print $LANG['edit_contract']; ?>"

    var addOrderStatu = "<?php print $LANG['add_order_status']; ?>"
    var editOrderStatu = "<?php print $LANG['edit_order_status']; ?>"

    var addWorkplace = "<?php print $LANG['add_workplace']; ?>"
    var editWorkplace = "<?php print $LANG['edit_workplace']; ?>"

    var addDepartment = "<?php print $LANG['add_department']; ?>"
    var editDepartment = "<?php print $LANG['edit_department']; ?>"

    var addCallingList = "<?php print $LANG['add_calling_list']; ?>"
    var editCallingList = "<?php print $LANG['edit_calling_list']; ?>"

    var dataSaved = "<?php print $LANG['data_saved']; ?>"
</script>
