<?php
session_start();
if(!isset($_SESSION['userID'])) { // check if user is logged in
header("Location: ../../index.php");
} else {
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 2020 05:00:00 GMT');
header('Content-type: application/json');	
}

require_once "../../../lang/".$_SESSION['lang'].".php";

$title1 = $LANG['sales']." - ".utf8_encode($_SESSION['projectName']);

$title6 = $LANG['order_value_total']." - ".utf8_encode($_SESSION['projectName']);

$title2 = $LANG['orders']." - ".utf8_encode($_SESSION['projectName']);

$title7 = $LANG['call_back']." - ".utf8_encode($_SESSION['projectName']);

if(isset($_SESSION['admin']) || isset($_SESSION['supervisor']) ) {
$title4 = $LANG['sales_per_salesrep']." - ".utf8_encode($_SESSION['projectName']);
$column4 = "third";
$column6 = "second";
$column7 = "second";

} else {
$title4 = $LANG['my_sales']." - ".utf8_encode($_SESSION['projectName']);
$column4 = "second";
$column6 = "first";
$column7 = "second";
}	

?>
{
"result" :
  {
  "layout": "layout5",
  "data" : [
	 {
      "title" : "<?php print $title1;?>",
      "column" : "first",
      "id" : "widget1",
      "url" : "widgets/sales_list_widget.php",
      "editurl" : "widgets/sales_list_widget.php",
      "open" : true
    },   
	{
      "title" : "<?php print $title7;?>",
      "id" : "widget7",
      "column" : "<?php print $column7;?>",
      "url" : "widgets/call_back_widget.php",
      "editurl" : "widgets/call_back_widget.php",
      "open" : true
    },
	{
      "title" : "<?php print $title6;?>",
      "id" : "widget6",
      "column" : "<?php print $column6;?>",
      "url" : "widgets/orders_overview_widget.php",
      "editurl" : "widgets/orders_overview_widget.php",
      "open" : true
    },
    {
      "title" : "<?php print $title4; ?>",
      "id" : "widget4",
      "column" : "<?php print $column4;?>",
      "url" : "widgets/salesrep_widget.php",
      "editurl" : "widgets/salesrep_widget.php",
      "open" : true
    },
   
<?php 
if(isset($_SESSION['admin']) || isset($_SESSION['orderModule'])) {
?>    
    {
      "title" : "Ordreinngang",
      "id" : "widget5",
      "column" : "second",
      "url" : "widgets/cash_flow_widget.php",
      "editurl" : "widgets/cash_flow_widget.php",
      "open" : true
    },
    {
      "title" : "<?php print $title2;?>",
      "id" : "widget2",
      "column" : "first",
      "editurl" : "widgets/order_list_widget.php",
      "open" : true,
      "url" : "widgets/order_list_widget.php"
    },
<?php } ?>
	 {
      "title" : "Salg per måned",
      "id" : "widget3",
      "column" : "third",
      "url" : "widgets/monthly_sales_widget.php",
      "editurl" : "widgets/monthly_sales_widget.php",
      "open" : true
    }
   ]
  }
}
