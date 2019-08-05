<?php 
session_start();
if(!isset($_SESSION['userID'])) { // check if user is logged in
header("Location: ../../index.php");
}

require_once "../system/db.php";
require_once "../../lang/".$_SESSION['lang'].".php";
$listID = $_GET['listID'];

$query = "SELECT * FROM ".$callinglistcompanies." as items JOIN ".$callinglists." as lists WHERE lists.listID = ".$listID." and items.listID=".$listID." order by items.companyName";
if (!$Result= mysql_db_query($DBName, $query, $Link)) {
           print "No database connection <br>".mysql_error();
        } 

echo '<span id="container">';		
echo '<span class="full_width">';
echo '<table cellpadding="0" cellspacing="0" border="0" class="display" id="example">';
echo '<thead>';
echo '<tr><th style="width:250px">'.$s_company_name.'</th><th>'.substr($s_org_number,0,3).'.</th><th>'.$s_place.'</th><th>'.$s_business_branch.'</th><th>'.$s_created.'</th><th style="width:150px">'.$s_comments.'</th></tr>';
echo '</thead>';


while($Row=MySQL_fetch_array($Result)) {

echo '<tr><td><a href="javascript:getInfo(\''.$Row['regNumber'].'\')">'.$Row['companyName'].'</a></td><td>'.$Row['regNumber'].'</td><td>'.$Row['place'].'</td><td>'.$Row['branch'].'</td><td>'.$Row['dateCreated'].'</td><td>'.$Row['Comments'].'</td></tr>';

    	}

echo '</table>';
echo '</span>';		
echo '</span>';

?>

