<?php
include_once "../../lang/".$_SESSION['lang'].".php";
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<script type="text/javascript" src="../OpenChart/js/swfobject.js"></script>

<title><?php print $LANG['graphs_overview']; ?></title>
</head>
<body>



<?php 
$orgn = $_GET['regnumber'];
$name = str_replace(" ", "+", $_GET['name']);

//$orgn = "992515678";
//$name = "Axenna+Enterprise+Ltd";


$handle = fopen("http://www.1881.no/Regnskap/".$name."_".$orgn."/?query=".$orgn."&searchtype=company&qt=1&regnskapvisning=full", "r");
if ($handle) {
    while (!feof($handle)) {
        $buffer = fgets($handle, 4096);
        $doc = $doc.$buffer;
    }
    fclose($handle);
print $doc;
}


$dom = new domDocument;

    /*** load the html into the object ***/
    $dom->loadHTML($doc);

    /*** discard white space ***/
    $dom->preserveWhiteSpace = false;

    /*** the table by its tag name ***/
    $tables = $dom->getElementsByTagName('table');

    /*** get all rows from the table ***/
    $rows = $tables->item(0)->getElementsByTagName('tr');
    

    /*** loop over the table rows ***/
    $i = 0;
    
    foreach ($rows as $row)
    {  // start rows
       
        /*** get each column by tag name ***/
        $cols = $row->getElementsByTagName('td');  // get data
        $heads = $row->getElementsByTagName('th');  // get headings
    
    

      if($i==0) {
      	  
$h=0;
foreach($heads as $head) {
if($head->nodeValue!="Resultatregnskap" && $head->nodeValue!="Graf") {  // don't include this header
$year = $head->nodeValue;
$x_axis = $x_axis.",".$year;
}
$h++;
}

$x_axis = substr($x_axis,1);

//print $x_axis;

}    
    
 
      if( $i==3 || $i==27 || $i==72) {    // include only these rows

			$values = ""; // reset values
			$title = trim(utf8_decode($heads->item(0)->nodeValue)); // head
						
			for ($a = 0; $a < $cols->length-1; $a++) {   // start data
			
				$value = trim(utf8_decode($cols->item($a)->nodeValue));
				$value = urlencode($value);
				$value = str_replace("%A0","", $value);
				$value = str_replace("%","", $value);
							
				$value = intval($value);	 	
		 	if($value=="?"){ 
				$value="0";		 	
		 		}
		   
		   
		   $values = $values.",".$value;
						
			}  // end data
			$values = substr($values,1);
			//print $values;
			
?>		   
<script type="text/javascript">
 
swfobject.embedSWF(
"../open-flash-chart.swf", "<?php print $i;?>",
"270", "160", "9.0.0", "expressInstall.swf",
{"data-file":"../charts/<?php print urlencode("chart2.php?title=".$title."&values=".$values."&x_axis=".$x_axis); ?>"} );

</script>


<div id="<?php print $i; ?>" style="height:320px;width:200px"></div>


<?php 
		
      }
	
		$i++;
    }  // end rows



 ?>


</body>
</html>