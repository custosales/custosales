<?php
/**
 * Description of getInfoClass 
 * Getting info needed to create leads etc.
 * @author Terje Berg-Hansen
 */
session_start();

class getInfo 
{

// Class variables        

var $DBName = null;
var $conn = null;
var $companies = null;
var $callinglists = null;
var $userID = null;
public $saved = null;
public $unsaved = null;

// Class Functions

function getContactData ($regNumber) {


$handle = fopen("http://w2.brreg.no/enhet/sok/detalj.jsp?orgnr=".$regNumber, "r");
if ($handle) {
    while (!feof($handle)) {
        $buffer = fgets($handle, 4096);
        $doc = $doc.$buffer;
    }
    fclose($handle);
}

$startpos = strpos($doc,'<table border="0" width="100%">');
$endpos = strpos($doc, '<td class="liste" colspan="3">', $startpos);
$length = $endpos - $startpos;
$infotable1 = substr($doc, $startpos, $length);
$infotable = str_replace("<br>", ", ", $infotable1);


//echo $infotable; 

$dom = new domDocument;

    /*** load the html into the object ***/
    $dom->loadHTML($infotable);

    /*** discard white space ***/
    $dom->preserveWhiteSpace = false;

    /*** the table by its tag name ***/
    $tables = $dom->getElementsByTagName('table');

    /*** get all rows from the table ***/
    $rows = $tables->item(0)->getElementsByTagName('tr');

	 /*** Loop over table data ***/
       $i = 0;
    foreach ($rows as $row)    {
        /*** get each column by tag name ***/
        $cols = $row->getElementsByTagName('td');
   
        /*** echo the values ***/
        
      if($i<17) {  // get values for storing in database
       
       	  if($i==1) {
			 		$companyName = trim(utf8_decode($cols->item(1)->nodeValue));		 		
				}
       	  if($i==2) {
			 		$companyType = trim(utf8_decode($cols->item(1)->nodeValue));		 		
				}
	        if($i==3) {
			 		$companyAddress = trim(utf8_decode($cols->item(1)->nodeValue));		 		
				}
       	  if($i==4) {
			 		$companyCity = trim(utf8_decode($cols->item(1)->nodeValue));		 		
				}
       	  if($i==5) {
			 		$companyPostAddress = trim(utf8_decode($cols->item(1)->nodeValue));		 		
				}
       	  if($i==6) {
			 		$companyEmail = trim(utf8_decode($cols->item(1)->nodeValue));		 		
				}
       	  if($i==7) {
			 		$companyInternet = trim(utf8_decode($cols->item(1)->nodeValue));		 		
				}
       	  if($i==8) {
			 		$companyPhone = str_replace(" ", "", trim(utf8_decode($cols->item(1)->nodeValue)));		 		
				}
	    	  if($i==9) {
			 		$companyMobilePhone = str_replace(" ", "", trim(utf8_decode($cols->item(1)->nodeValue)));		 		
				}
    	  	  if($i==10) {
			 		$companyFax = str_replace(" ", "", trim(utf8_decode($cols->item(1)->nodeValue)));		 		
				}

				if($i==11) {
			 		$dateRegistered = trim(utf8_decode($cols->item(1)->nodeValue));		 		
				}
				if($i==12) {
			 		$dateIncorporated = trim(utf8_decode($cols->item(1)->nodeValue));		 		
				}
				if($i==13) {
					$companyManager = trim(utf8_decode($cols->item(1)->nodeValue));		 		
				}
				if($i==14) {
					$value_full = trim($cols->item(1)->nodeValue);
      			$pos = strpos($value_full, " ");
      			$branchCode1 = substr($value_full, 0, $pos);
				   $branchCode1 = utf8_decode($branchCode1); 						
					$branchCode = substr($branchCode1, 0, strlen($branchCode1)-2);		
						
						if(substr($branchCode, 0, 1)=="0") {
						$branchCode = substr($branchCode, 1);
						}
				}

														
				} // end if less than 17
				
				$i++;
				} // end rows


				// store in Database
				$query = "INSERT INTO ".$this -> companies." SET 
				regNumber = '".$regNumber."',
				companyName = '".$companyName."',
				companyType = '".$companyType."',
				companyStatus = 'lead',
				companyEmail = '".$companyEmail."',
				companyInternet = '".$companyInternet."',
				companyPhone = '".$companyPhone."',
				companyMobilePhone = '".$companyMobilePhone."',
				companyFax = '".$companyFax."',
				companyAddress = '".$companyAddress."',
				companyPostAddress = '".$companyPostAddress."',
				companyCity = '".$companyCity."',
				dateRegistered = '".$dateRegistered."',
				dateIncorporated = '".$dateIncorporated."',
				companyManager = '".$companyManager."',
				branchCode = '".$branchCode."',
				sectorCode = '".$sectorCode."',
				regDate = NOW(),
				salesRepID = '".$this -> userID."'
				";

				if (!$Result= mysql_db_query($this -> DBName, $query, $this -> conn)) {
					$unsaved = true;
           		//print "Record not saved".mysql_error();
        		} else {
					$saved = true;	
           	}
				
				// Update callinglist, to mark as lead				
				 
				$queryl = "UPDATE ".$this -> callinglists." SET salesRepID=".$this -> userID." WHERE Orgnr=".$regNumber; 

				if (!$Result= mysql_db_query($this -> DBName, $queryl, $this -> conn)) {
           		print "Callinglist  not updated<br>".mysql_error();
        			} 
				 			 
			
				return $saved; 
				return $unsaved; 
				 				
				} // end function getContactData


} // end class
?>
