<?php
include_once "../../lang/".$_SESSION['lang'].".php";
include_once "../system/db.php";

$ii=1;

$query = "SELECT Orgnr, Firmanavn, `B.poststed` from NyeFirmaer LIMIT 18500,4500";

	if (!$Result= mysql_db_query($DBName, $query, $Link)) {
           print "No database connection <br>".mysql_error();
        }


while($Row=mysql_fetch_array($Result)) {

        
	$orgnr = $Row['Orgnr'];
	$name = strtolower(str_replace(" ", "-", $Row['Firmanavn']));
	$by = strtolower($Row['B.Poststed']);

	print($ii." - ".$Row['Firmanavn']."<br>");

	// check if accounts are already in database	
	$query2 = "SELECT accID from Accounts WHERE regNumber=".$orgnr."";

	if (!$Result2= mysql_db_query($DBName, $query2, $Link)) {
           print "No database connection <br>".mysql_error();
        }

    if(mysql_num_rows($Result2)>0) {
		 print "Er alerede i databasen<br>";		
		} else {
   	getAndSave($orgnr,$name,$by,$DBName,$Link); 
    }	
	
	
$ii++;

	
}	
	
	
	function getAndSave ($orgnr,$name,$by,$DBName,$Link) {
	
	
	$handle = fopen("http://www.proff.no/regnskapdetaljerte/".$name."/".$by."/-/".$orgnr."/", "r");

	if ($handle) {
   	 while (!feof($handle)) {
        $buffer = fgets($handle, 4096);
        $doc = $doc.$buffer;
    	}
    fclose($handle);
	} else {
	print "<br>no handle";
	return;
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
    
    
    foreach ($rows as $row) {
        /*** get each column by tag name ***/
        $cols = $row->getElementsByTagName('td');  // get data
        $heads = $row->getElementsByTagName('th');  // get headings
    
        
      	if($i==0) {
      	  
			foreach($heads as $head) {
					if($head->nodeValue!="Graf") {  // don't include this header
						$fieldValue[] = $head->nodeValue;
					}

				}
			}

      if($i>0 && $i!=26 && $i!=27 && $i!=31 && $i!=94 && $i!=105 && $i!=113 && $i!=106  && $i<125) {    
      // include only these rows

			if($i == 124) {	
			$start_str = 1;
			} else {
			$start_str = 0;		
			}			
			
			for ($a = $start_str; $a < $cols->length-1; $a++) {	 	
			
			$value = trim(utf8_decode($cols->item($a)->nodeValue));		 		
					 	
		 	if($value=="?"){ 		
				$value="0";		 	
		 		}
		 		
		 	$value = str_replace("fax", "", $value);	
		 	$value = str_replace("<br>", "", $value);	
			$value = str_replace("&nbsp;", "", $value);	

			$value = preg_replace( '/[\x7f-\xff]/', '', $value );
			$value = preg_replace( "'\s+'", '', $value );
			
			
	 			 	
		 	$accValue[$a][] = $value; 
					
					}  // end listing col 
			
      }
	
		$i++;
    }


// Save Account


for($a = 0;$a<(count($fieldValue)-1);$a++) {
// remove last value
//$accValue[$a] = array_pop($accValue[$a]);

$valueStr = implode("','",$accValue[$a]);
$valueStr = str_replace("<br>", "", $valueStr);
$valueStr = str_replace("	", "", $valueStr);
$valueStr = str_replace(" ", "", $valueStr);


$query2 = "INSERT IGNORE INTO Accounts VALUES ('','".$orgnr."',
'".$fieldValue[$a+1]."',
'".$valueStr."')";


	if (!$Result2= mysql_db_query($DBName, $query2, $Link)) {
           print "No database connection <br>".mysql_error();
           print "<br>".$query2;
        } else {
        	 	//print $fieldValue[$a+1]."  er lagret<br>";
        	}

} // end save


} // end function
?>
