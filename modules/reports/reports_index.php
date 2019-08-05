 	
<a href="#" onclick="JavaScript:showTimeSheet(<?php print $_SESSION['userID'];?>)" style="text-decoration:none"><img src="images/timesheet.png" style="vertical-align:middle" alt="" >  <?php print $LANG['my_timesheet'];?></a>

<?php // Show Reports Module		
if(isset($_SESSION['admin']) || isset($_SESSION['supervisor']) || isset($_SESSION['reportModule'])  )  {  // Check for user rights
?>
&nbsp;
<a href="#" onclick="JavaScript:showSalesReport()" style="text-decoration:none"><img src="images/user_list_32.png" style="vertical-align:middle" alt="" >  <?php print $LANG['salesreport'];?></a>

<?php } ?>

<div id="reportArea"></div>
