<?php
session_start();
if(!isset($_SESSION['userID'])) { // check if user is logged in
header("Location: ../../index.php");
}

include_once "../../lang/".$_SESSION['lang'].".php";
include_once "../system/db.php";
$customer ="";
$place = utf8_decode($_GET['place']);
$branch1 = utf8_decode($_GET['SN2007']);
$branch = str_replace(" ", "+", $branch1);
$button_value = $LANG['save_calling_list'];
$userID = $_SESSION['userID'];
?>


<?php

$handle = fopen("http://www.1881.no/Regnskapstall/?ValgtBransje=&Sted=Bergen&Selskapsform=AS&Aar=2009&Sortering=15&DriftinnFra=10000&DriftinnTil=&ResultatFra=&ResultatTil=&UtbytteFra=&UtbytteTil=&EgenkapitalFra=&EgenkapitalTil=&GjeldFra=&GjeldTil=&FraAar=&TilAar=&AnsatteFra=&AnsatteTil=&EiendelerFra=&EiendelerTil=&KapitalFra=&KapitalTil=");
if ($handle) {
    while (!feof($handle)) {
        $buffer = fgets($handle, 4096);
        $doc = $doc.$buffer;
    }
    fclose($handle);
}


$dom = new domDocument;
    /*** load the html into the object ***/
    $dom->loadHTML($doc);
    /*** discard white space ***/
    $dom->preserveWhiteSpace = false;
    /*** the table by its tag name ***/
    $spans = $dom->getElementsByTagName('span');
	 $h3s = $dom->getElementsByTagName('h3');
 
echo '<form name="regform" method="POST" action="modules/sales/save_callinglist.php">';
echo '<table style="width:600px;font-size:0.9em;background-color:#dedede;border:solid 1px #777777;border-radius: 15px: _moz border-radius:15px;">';
echo '<input type="hidden" ID="place" name="place" value="'.$place.'">';
echo '<input type="hidden" ID="branch" name="branch" value="'.$branch1.'">';
echo '<input type="hidden" name="ownerID" value="'.$userID.'">';
echo '<tr><td colspan="3" align="left">'.$LANG['list_name'].' <input type="text" style="width:350px" ID="listName" name="listName" value="'.$place.' - '.utf8_decode($_GET['SN2007']).'"> &nbsp; <input id="but1" style="'.$button_style.'" type="submit" value="'.$button_value.'" '.$button_status.'></td></tr>';
echo '<tr><td colspan="3" align="left">'.$s_comments.': <textarea ID="comments" name="comments" style="width:450px;height:30px;vertical-align:top"></textarea></td></tr>';

    /*** loop over the table rows ***/
    $i = 0;  // iterations count
    $a = 1;  // row count
foreach ($spans as $span) {  // print number of hits 
   
$hitspos = strpos(trim(utf8_decode($span->nodeValue)),"treff");   
        	
if($hitspos) {  // how many hits for this location	
$hits = substr(trim(utf8_decode($span->nodeValue)),1, $hitspos-1);
$hitspos2 = strpos($hits,"Forvalt");
$hits = substr($hits, $hitspos2+9 );
print "<tr><td colspan=3 bgcolor=\"#EFEFEF\">Bedrifter i ".$place.": ".$hits."</td></tr>";
   }  // end how many hits for this location	

}

foreach ($h3s as $row) {  // print first 25 hits 

print $row->nodeValue;

$orgpos = strpos($row->nodeValue, "Org");
$companyname = trim(substr(utf8_decode($row->nodeValue),0, $orgpos));
$regnumber = trim(substr(utf8_decode($row->nodeValue), $orgpos+7,12));
$regnumber = substr($regnumber,0,3).substr($regnumber,4,3).substr($regnumber,8,3);

    if($i>0) {  //don't print top
    if(!strstr($row->nodeValue, "INAKTIVT")) {  // don't print inaktive companies
    		  echo '<input type="hidden" name="regNumber['.$a.']" value="'.$regnumber.'">';	 
			  echo '<input type="hidden" name="companyName['.$a.']" value="'.$companyname.'">';
			  echo '<tr>';
       	  echo '<td style="width:35px;">'.$a.': </td>';
			 echo '<td style="width:40px;"><a href="modules/sales/get_info.php?regnumber='.$regnumber.'" target=_blank>See</a></td>';
       	  echo '<td style="width:550px;">'.trim(utf8_decode($row->nodeValue)).'</td>';
			  echo '</tr>';
			  $a++;
		   }  // end don't print inactive companies    		
    		} // end don't print top
	$i++;
}  // end print first 25 hits 



echo '</table>';
echo '</form>';
 ?>
