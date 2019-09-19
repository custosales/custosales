<?php 
session_start();
if(!isset($_SESSION['userID'])) { // check if user is logged in
header("Location: ../../index.php");
}

require_once "../system/db.php";
require_once "../../lang/".$_SESSION['lang'].".php";

$ownerID = $_SESSION['userID'];

$limitStart = intval($_GET['limitStart']);
$limitEnd = intval($_GET['limitEnd']);
$tableName = $_GET['tableName'];
$search = $_GET['search'];

if($limitStart=="undefined") { $limitStart=0; }
if($limitEnd=="undefined") { $limitEnd=500; }

if($limitStart <= 0) { $limitStart = 0; }
if($limitEnd < 500) { $limitEnd = 500; }

	
if($search=="yes") {   // Display searched records 


// Get Field Names
$queryF = "SHOW FIELDS FROM `".$tableName."`";

try {
	$ResultF = $pdo->query($queryF);
} catch (PDOException $e) {
	echo "Data was not fetched, because: " . $e->getMessage();
}


$phrase = $_GET['phrase'];
$field = $_GET['field'];

$query = "SELECT * FROM ".$tableName." WHERE `".$field."` like '%".$phrase."%' AND salesRepID=0 LIMIT ".$limitStart.",500";


try {
	$result = $pdo->query($query);
} catch (PDOException $e) {
	echo "Data was not fetched, because: " . $e->getMessage();
}


 } else {  // Display all records



// Get Field Names
$queryFields = "SHOW FIELDS FROM `".$tableName."`";

try {
	$resultFields = $pdo->query($queryFields);
} catch (PDOException $e) {
	echo "Data was not fetched, because: " . $e->getMessage();
}


$queryList = "SELECT * FROM `".$tableName."` WHERE salesRepID=0 LIMIT ".$limitStart.",500";
		
try {
	$resultList = $pdo->query($queryList);
} catch (PDOException $e) {
	echo "Data was not fetched, because: " . $e->getMessage();
}


echo '<input type="button" style="margin-right:3px;" value="<-" onclick="showAllLists(\''.$tableName.'\',\''.($limitStart-500).'\',\''.($limitEnd-500).'\')" >';
echo $limitStart. " - ".$limitEnd;
echo '<input type="button" style="margin-left:3px;" value="->" onclick="showAllLists(\''.$tableName.'\',\''.($limitStart+500).'\',\''.($limitEnd+500).'\')" >';

echo '&nbsp;&nbsp;<input id="but1" style="margin-bottom:3px;" value="'.$LANG['create_lead'].'" type="button" onclick="JavaScript:makeLeads(\''.$tableName.'\')">';

echo '<br>';
echo '<form name="listForm" ID="listForm">';

echo '<span style="width:99%;text-align:left;float:left;left-margin:20px">';		
//echo '<span >';
echo '<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" style="font-size:1em;width:100%;">';
echo '<thead>';
echo '<tr>';
echo '<th style="width:25px"> </th>';


$aa=0;

foreach ($resultFields as $RowF) {

if($RowF[0]=="AccountYear") {
$RowF[0] = $LANG['year'];
}

if($RowF[0]=="Equity") {
$RowF[0] = $LANG['equity'];
}
if($RowF[0]=="Income") {
$RowF[0] = $LANG['income'];
}
if($RowF[0]=="City") {
$RowF[0] = $LANG['city'];
}


if($aa==0) {
echo '<th style="max-width:80px">'.$RowF[0].'</th>';
} else if($RowF[0]=="Zip" || $RowF[0]=="salesRepID" || $RowF[0]=="Address" || $RowF[0]=="Faks" || $RowF[0]=="B.adresse" || $RowF[0]=="B.poststed" || $RowF[0]=="B.postnr" )  {
$fieldet[$aa]= "no"; 
} else {	
echo '<th style="max-width:120px">'.$RowF[0].'</th>';
}

$aa++;
} // end list fields

echo '</tr>';
echo '</thead>';

$i=0;


foreach ($resultList as $Row) {

 
if($Row['salesRepID']!=0) {
	$disabled = "disabled";
	} else {
	$disabled = "";
	}
			
echo '<tr>
<td><input type="checkbox" '.$disabled.' name="makeLead" value="'.$Row[0].'"></td>';

echo '<td style="max-width:80px">'.$Row[0].'</td>';
echo '<td>';

if($Row['salesRepID']==0) {
echo '<a href="javascript:loadInfo(\''.$Row[0].'\')">'.$Row[1];
} else {

$queryS = "SELECT fullName FROM ".$users." WHERE userID=:userID";


try {
	$stmt = $pdo->prepare($queryS);
	$stmt->bindParam(':userID', $Row['salesRepID']);
	$stmt->execute();
	$RowS = $stmt->fetch(PDO::FETCH_ASSOC);
	$salesRep = $RowS['fullName'];	
} catch (PDOException $e) {
	echo "Data was not fetched, because: " . $e->getMessage();
}
echo $Row['Firmanavn'].' ('.$salesRep.')';


} // end else


if($Row['salesRepID']>0) {
echo '</a>';
}

echo '</td>';


for ($a=2;$a<$aa-1;$a++ )  {
if($fieldet[$a]!="no") {	
echo '<td style="max-width:120px">'.$Row[$a].'</td>';
}
}
echo '</tr>';

$i++;

}
    
}    
echo '</table>';
echo '</form>';

echo '</span>';		

