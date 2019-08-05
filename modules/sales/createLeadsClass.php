<?php
/**
 * Description of getInfoClass 
 * Getting info needed to create leads etc.
 * @author Terje Berg-Hansen
 */
session_start();

class Leads 
{

// Class variables        

var $DBName = null;
var $conn = null;
var $companies = null;
var $callingListTable = null;
var $regNumber = null;
var $userID = null;
var $projectFirstSalesStage = null;
public $saved = null;
public $unsaved = null;

// Class Functions

function createLead ($regNumber) {
				
							
				// Get company data from CallingList
				$query = "SELECT * FROM ".$this->callingListTable." WHERE Orgnr=".$regNumber;
				$Result = mysql_db_query($this -> DBName, $query, $this -> conn);
				$Row = mysql_fetch_array($Result);

				$companyName = $Row['Firmanavn'];

				if($Row['Selskapsform']!="") {				
				$companyType = $Row['Selskapsform'];
				} 				
				
				if($Row['E-post']!="") {				
				$companyEmail = $Row['E-post'];
				} 				
				
				if($Row['Telefon']!="") {				
				$companyPhone = $Row['Telefon'];
				} 				
				
				if($Row['Mobil']!="") {				
				$companyMobilePhone = $Row['Mobil'];
				} 				
				
				if($Row['Kontaktperson']!="") {				
				$companyManager = $Row['Kontaktperson'];
				} 				

				if($Row['B.adresse']!="") {				
				$companyAddress = $Row['B.adresse'];
				} 				

				if($Row['Address']!="") {				
				$companyAddress = $Row['Address'];
				} 				
								
				if($Row['City']!="") {				
				$companyCity = $Row['City'];
				} 				
				
				if($Row['Fylke']!="") {				
				$companyCounty = $Row['Fylke'];
				} 				


				if($Row['B.poststed']!="") {				
				$companyCity = $Row['B.poststed'];
				} 				

				if($Row['Zip']!="") {				
				$companyZipCode = $Row['Zip'];
				} 
				
				if($Row['B.postnr']!="") {				
				$companyZipCode = $Row['B.postnr'];
				} 
			
				if($Row['Bransjekode']!="") {				
				$branchCode = $Row['Bransjekode'];
				} 
				
				if($Row['Bransjekode']!="") {				
				$branchCode = $Row['Bransjekode'];
				} 
				
											
				if($Row['Bransjetekst']!="") {				
				$branchText = $Row['Bransjetekst'];
				} 
			
				if($Row['Bransjer']!="") {				
				$branchText = $Row['Bransjer'];
				} 
			
				
				// store in Database
				$query = "INSERT INTO ".$this -> companies." SET 
				regNumber = '".$this->regNumber."',
				companyName = '".$companyName."',
				companyType = '".$companyType."',
				companyStatus = '".$this->projectFirstSalesStage."',
				companyEmail = '".$companyEmail."',
				companyInternet = '".$companyInternet."',
				companyPhone = '".$companyPhone."',
				companyMobilePhone = '".$companyMobilePhone."',
				companyFax = '".$companyFax."',
				companyAddress = '".$companyAddress."',
				companyZipCode = '".$companyZipCode."',
				companyCity = '".$companyCity."',
				companyCounty = '".$companyCounty."',
				dateRegistered = '".$dateRegistered."',
				dateIncorporated = '".$dateIncorporated."',
				companyManager = '".$companyManager."',
				branchCode = '".$branchCode."',
				branchText = '".$branchText."',
				regDate = NOW(),
				callingListTable = '".$this -> callingListTable."',
				projectID = ".$_SESSION['project'].",
				salesRepID = '".$this -> userID."'
				";

				if (!$Result= mysql_db_query($this -> DBName, $query, $this -> conn)) {
					$unsaved = true;
           		print "Record not saved".mysql_error();
        		} else {
					$saved = true;	
           	}
				
				// Update callinglist, to mark as lead				
				 
				$queryl = "UPDATE ".$this -> callingListTable." SET salesRepID=".$this -> userID." WHERE Orgnr=".$regNumber; 

				if (!$Result= mysql_db_query($this -> DBName, $queryl, $this -> conn)) {
           		print "Callinglist  not updated<br>".mysql_error();
        			} 
				 			 
			
				return $saved; 
				return $unsaved; 
				
				 				
				} // end function leads


} // end class
?>
