<?php 
session_start();
if(!isset($_SESSION['userID'])) { // check if user is logged in
header("Location: ../index.php");
}

require_once "../system/db.php";
require_once "../../lang/".$_SESSION['lang'].".php";

$orderStatusID = $_GET['orderStatusID'];
$redirect = $orderStatusID;


if($orderStatusID == "all" ) {
	
if(isset($_SESSION['admin']) || isset($_SESSION['supervisor'])) {   // check for admin or supervisor rights	
$query = "SELECT orderID, regNumber, orderStatusID, productID, orderDate, customerContact, unitPrice, creditDays, ".$orders.".salesRepID, ".$users.".fullName FROM ".$orders.", ".$users." WHERE ".$orders.".salesRepID=".$users.".userID" ; 
	} else {
$query = "SELECT orderID, regNumber, orderStatusID, productID, orderDate, customerContact, unitPrice, creditDays, ".$orders.".salesRepID, ".$users.".fullName FROM ".$orders.", ".$users." WHERE  userID=".$_SESSION['userID']." and ".$orders.".salesRepID=".$users.".userID" ; 
}


} else { 

if(isset($_SESSION['admin']) || isset($_SESSION['supervisor'])) {   // check for admin or supervisor rights
$query = "SELECT orderID, regNumber, orderStatusID, productID, orderDate, customerContact, unitPrice, creditDays, ".$orders.".salesRepID, ".$users.".fullName FROM ".$orders.", ".$users." WHERE orderStatusID='".$orderStatusID."' and ".$orders.".salesRepID=".$users.".userID" ; 
	} else {
$query = "SELECT orderID, regNumber, orderStatusID, productID, orderDate, customerContact, unitPrice, creditDays, ".$orders.".salesRepID, ".$users.".fullName FROM ".$orders.", ".$users." WHERE orderStatusID='".$orderStatusID."' and userID=".$_SESSION['userID']." and ".$orders.".salesRepID=".$users.".userID" ; 
}

}
if (!$Result= mysql_db_query($DBName, $query, $Link)) {
           print "No database connection <br>".mysql_error();
        } 

echo '<span style="width:95%;text-align:left;float:left;left-margin:20px">';		
echo '<table cellpadding="0" cellspacing="0" border="0" class="display" style="font-size:1em;" id="example">';
echo '<thead>';
echo '<tr><th>#</th>
<th>'.$LANG['order_id'].'</th> 
<th>'.$LANG['company_name'].'</th>
<th>'.$LANG['product'].'</th>
<th>'.$LANG['order_date'].'</th>
<th>'.$LANG['due'].'</th>
<th>'.$LANG['price'].'</th>
<th>'.$LANG['sales_rep'].'</th>
<th></th></tr>';
echo '</thead>';
echo '<tbody>';

$i=1;
while($Row=MySQL_fetch_array($Result)) {


echo '<tr><td>'.$i.'</td>';
echo '<td>'.$Row['orderID'].'</td><td>';

$queryc = "SELECT companyName from ".$companies." WHERE regNumber=".$Row['regNumber'];
if (!$Resultc= mysql_db_query($DBName, $queryc, $Link)) {
           print "Something bad happened.. <br>".mysql_error();
        } else { 
        $Rowc=MySQL_fetch_array($Resultc); 
			}

if($Row['salesRepID']==$_SESSION['userID'] || isset($_SESSION['admin']) || isset($_SESSION['supervisor'])) {
echo '<a href="javascript:getOrder(\''.$Row['orderID'].'\')">';
}

if($Rowc['companyName']=="") {
$companyName = " --- ";	
	} else {
$companyName =	$Rowc['companyName'];
}

echo $companyName;

if($Row['salesRepID']==$_SESSION['userID'] || isset($_SESSION['admin']) || isset($_SESSION['supervisor'])) {
echo '</a>';
}

echo '</td>';


echo '<td>';

$queryp = "SELECT productName from ".$products." WHERE productID=".$Row['productID'];
if (!$Resultp= mysql_db_query($DBName, $queryp, $Link)) {
           print "No database connection <br>".mysql_error();
        } else { 
        $Rowp=MySQL_fetch_array($Resultp); 
			}


echo $Rowp['productName'];

echo '</td><td>'.$Row['orderDate'].'</td><td>';


$duedate = strtotime ( '+'.$Row['creditDays'].' days' , strtotime ( $Row['orderDate'] ) ) ;
$duedate = date ( 'Y-m-j' , $duedate );
if($duedate<date()) {
	$duecolor = "red";
	} else {
		$duecolor = "black";
		}

echo '<span style="color:'.$duecolor.'">'.$duedate.'</span>';

echo '</td><td>'.$s_currency_symbol." ".number_format($Row['unitPrice'], 0, ',', ' ').'</td>
<td>'.substr($Row['fullName'],0, strpos($Row['fullName']," ")).'</td>';

echo '<td>';


if($Row['salesRepID']==$_SESSION['userID'] || isset($_SESSION['admin']) || isset($_SESSION['supervisor'])) {   // check for admin or supervisor rights
echo '<a href="javascript:deleteOrder(\''.$Rowc['companyName'].'\', \''.$Row['orderStatusID'].'\', \''.$Row['orderID'].'\')"><img src="images/cancel_16.png" border="0" title="'.$s_delete.'"></a>';
}
echo '</td>';



'</tr>';
$i++;
    	}
echo '</body>';
echo '</table>';
echo '</span>';		
