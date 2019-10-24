<?php session_start(); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>

<head>
    <meta charset="utf-8" />
    <title></title>
    <?php include_once 'head.php'; ?>
</head>

<body style="font-size:12px;">
    <?php
    include_once "menu.php";
    ?>
    <script class="code" type="text/javascript">
        var dataSaved = "<?php print $LANG['data_saved']; ?>"
    </script>


    <div id="main_table">
        <h1 class="ui-widget-header ui-corner-all" style="padding:3px 3px 3px 10px;"><span id="heading"><?php print $LANG['reports']; ?></span></h1>
        <div style="float:left;width:180px;padding:4px">
            <table style="width:180px;font-weight:normal;font-size:1em;margin-right:15px;padding;0px" class="ui-widget-content ui-corner-all">
                <tr>
                    <td colspan="2" class="ui-widget-header ui-corner-all">
                        <h2 style="text-align:center;padding:0;margin:0"><?php print $LANG['content'] ?></h2>
                    </td>
                </tr>
                <tr>
                    <td style="text-align:center;">
                        <a href="#" onclick="JavaScript:showTimeSheet(<?php print $_SESSION['userID']; ?>)" style="text-decoration:none"><img src="images/timesheet.png" style="vertical-align:middle" alt="">
                            <br>
                            <?php print $LANG['my_timesheet']; ?></a>
                    </td>
                    <td style="text-align:center;">
                        <?php
                        // Show Reports Module		
                        if (isset($_SESSION['admin']) || isset($_SESSION['supervisor']) || isset($_SESSION['reportModule'])) {  // Check for user rights
                            ?>
                            &nbsp;
                            <a href="#" onclick="JavaScript:showSalesReport()" style="text-decoration:none"><img src="images/user_list_32.png" style="vertical-align:middle" alt=""> <br> <?php print $LANG['salesreport']; ?></a>
                        <?php
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style="text-align:center;">
                        <a href="#" onclick="JavaScript:document.location = 'value_main.php'" style="text-decoration:none"><img src="images/chart_32.png" style="vertical-align:middle" alt="">
                            <br>
                            <?php print $LANG['value_assessment']; ?></a>
                    </td>
                    <td style="text-align:center;">
                    </td>
                </tr>
            </table>
        </div>
        <div id="reportArea" style="float:left;"></div>
    </div>
    <script type="text/javascript">
        $(function() {
            $("#datepicker").datepicker();
        });
    </script>
</body>

</html>