<?php session_start(); ?>
<html>
<head>
<?php include_once('head.php'); ?>
</head>

<body style="font-size:12px;margin:0px;padding:2px">

<?php include_once "menu.php"; ?>

<div id="main_table" style="margin-top:0px;padding:0px;">
        <!--  Show Tabs -->
        <div id="tabs" style="width:100%;float:left;margin-top:0px">
            <!--  Show Tabs Heading -->
            <ul>
                <li><a href="#mydashboard"><?php print $LANG['my_dashboard']; ?></a></li>
                <li><a href="#reports"><?php print $LANG['my_reports']; ?></a></li>
                <li><a href="#settings"><?php print $LANG['my_settings']; ?></a></li>
            </ul>
            <!--  End Tabs Heading -->


            <!--  Show Dashboard Module  -->
            <div id="mydashboard" style="padding:0;margin:0;">
                <div>
                    <div class="headerlinks">
                        <a class="openaddwidgetdialog headerlink" href="#">Legg til innstikk</a>&nbsp;<span class="headerlink">|</span>&nbsp;
                        <a class="editlayout headerlink" href="#">Rediger layout</a>
                    </div>
                </div>


                <div id="dashboard" class="dashboard">
                    <!-- this HTML covers all layouts. The 5 different layouts are handled by setting another layout classname -->
                    <div class="layout">
                        <div class="column first column-first"></div>
                        <div class="column second column-second"></div>
                        <div class="column third column-third"></div>
                    </div>
                </div>

            </div>
            <!--  End Dashboard Module  -->

            <!--  Show Reports Module  -->
            <div id="reports">
                <?php include_once("modules/reports/reports_index.php"); ?>
            </div>
            <!--  End Reports Module  -->

            <!--  Show Settings Module  -->
            <div id="settings">
                <?php include_once("modules/admin/my_settings.php"); ?>
            </div>
            <!--  End Settings Module  -->

        </div>
        <!--  End tabs -->
        <br>

    </div>
    <!--  End main_table div -->

<?php include_once('foot.php'); ?>

</body>

</html>