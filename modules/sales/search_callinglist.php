<?php 
session_start();
if(!isset($_SESSION['userID'])) { // check if user is logged in
header("Location: ../../index.php");
}

require_once "../system/db.php";
require_once "../../lang/".$_SESSION['lang'].".php";

$ownerID = $_SESSION['userID'];

$callinglists = $_GET['tableName'];

$phrase = $_GET['phrase'];
$field = $_GET['field'];

$limitStart = intval($_GET['limitStart']);
$limitEnd = intval($_GET['limitEnd']);

if($limitStart=="undefined") { $limitStart=0; }
if($limitEnd=="undefined") { $limitEnd=500; }

if($limitStart <= 0) { $limitStart = 0; }
if($limitEnd < 500) { $limitEnd = 500; }


$query = "SELECT * FROM ".$callinglists." WHERE ".$field." like '%".$phrase."%' LIMIT ".$limitStart.",500";
if (!$Result= mysql_db_query($DBName, $query, $Link)) {
           print "No database connection <br>".mysql_error();
        } 
        
echo '<span style="width:95%;text-align:left;float:left;left-margin:20px">';		


echo '<input type="button" style="margin-right:3px;" value="<-" onclick="searchCallingList(\''.($limitStart-500).'\',\''.($limitEnd-500).'\')" >';
echo $limitStart. " - ".$limitEnd;
echo '<input type="button" style="margin-left:3px;" value="->" onclick="searchCallingList(\''.($limitStart+500).'\',\''.($limitEnd+500).'\')" >';

echo '&nbsp;&nbsp;<input id="but1" style="margin-bottom:3px;" value="'.$LANG['create_lead'].'" type="button" onclick="JavaScript:makeLeads()">';

echo '<br>';
echo '<form name="listForm" ID="listForm">';
echo '<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" style="font-size:1em;">';
echo '<thead>';
echo '<tr>
<th style="width:25px"> </th>
<th style="width:250px">'.$LANG['company_name'].'</th>
<th>'.$LANG['org_number'].'</th>
<th>'.$LANG['company_type'].'</th>
<th>'.$LANG['contact_city'].'</th>
<th>'.$LANG['county'].'</th>
<th>'.$LANG['business_branch'].'</th>
<th>'.$LANG['year'].'</th>
<th>'.$LANG['income'].'</th>
<th>'.$LANG['equity'].'</th></tr>';
echo '</thead>';


while($Row=MySQL_fetch_array($Result)) {

echo '<tr>
<td><input type="checkbox" '.$disabled.' name="makeLead" value="'.$Row['Orgnr'].'"></td>';

echo '<td>';

if($Row['salesRepID']==0) {
echo '<a href="javascript:loadInfo(\''.$Row['Orgnr'].'\')">'.$Row['Firmanavn'];
} else {

$queryS = "SELECT fullName FROM ".$users." WHERE userID=".$Row['salesRepID'];
if (!$ResultS= mysql_db_query($DBName, $queryS, $Link)) {
	print "No user name".mysql_error();
	} else {
	$RowS = MySQL_fetch_array($ResultS);
	$salesRep = $RowS['fullName'];	
		}

echo $Row['Firmanavn'].' ('.$salesRep.')';

}

if($Row['salesRepID']>0) {
echo '</a>';
}

echo '</td>';

echo '<td>'.$Row['Orgnr'].'</td><td>'.$Row['Selskapsform'].'</td>
<td>'.$Row['City'].'</td><td>'.substr($Row['Fylke'],0,strpos($Row['Fylke'], " ")).'</td><td>'.$Row['Bransjer'].'</td>
<td>'.$Row['AccountYear'].'</td><td>'.$Row['Income'].'</td><td>'.$Row['Equity'].'</td></tr>';

    	}
    
    
echo '</table>';
echo '</form>';
echo '</span>';		

