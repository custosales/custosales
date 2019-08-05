<?php
session_start();
if(!isset($_SESSION['userID'])) { // check if user is logged in
header("Location: ../../index.php");
}

require_once "../system/db.php";
require_once "../../lang/".$_SESSION['lang'].".php";
require('../../lib/fpdf/fpdf.php');

$orderID = $_GET['orderID'];
$outputForm = $_GET['outputForm'];

// Get order data
$query = "SELECT regNumber, ".$orders.".unitPrice as unitPrice, productName, otherTerms, orderDate, salesRepID FROM ".$orders." , ".$products." WHERE ".$orders.".productID = ".$products.".productID and orderID=".$orderID;
if (!$Result= mysql_db_query($DBName, $query, $Link)) {
         print "No database connection <br>".mysql_error();
    } 
if(!$Row=MySQL_fetch_array($Result)) {
      print "No order found <br>".$query;
	}
$productData[]="1";
$productData[]=$Row['regNumber'];
$productData[]=$Row['productName'];
$productData[]=number_format($Row['unitPrice'], 0, ',', ' ')." ".$LANG['currency_symbol'];
$terms = $Row['otherTerms'];

$orderDate=$Row['orderDate']; 
$regNumber=$Row['regNumber'];
$salesRepID = $Row['salesRepID'];

// Get customer data

$queryc = "SELECT * FROM ".$companies." WHERE regNumber=".$regNumber;
if (!$Resultc= mysql_db_query($DBName, $queryc, $Link)) {
         print "No database connection <br>".mysql_error();
    } 
if(!$Rowc=MySQL_fetch_array($Resultc)) {
      print "No company found <br>".$queryc;
	}

$customerData[] = $Rowc['companyName'];
$customerData[] = $Rowc['regNumber'];
$customerData[] = $Rowc['companyAddress'].", ".$Rowc['companyZipCode']." ".$Rowc['companyCity'];
$customerData[] = $Rowc['companyManager'];
$customerData[] = $Rowc['companyPhone'];
$customerData[] = $Rowc['companyFax'];
$customerData[] = $Rowc['companyEmail'];


// Get Sales Rep Data
$querysr = "SELECT fullName, phone, mobilePhone, userEmail FROM ".$users." WHERE userID=".$salesRepID;
if (!$Resultsr= mysql_db_query($DBName, $querysr, $Link)) {
         print "No database connection <br>".mysql_error();
    } 
if(!$Rowsr=MySQL_fetch_array($Resultsr)) {
      print "No user found <br>".$querysr;
	}

$salesRepName = $Rowsr['fullName'];

if($Rowsr['phone']!="") {
$salesRepPhone = $Rowsr['phone'];
} elseif($Rowsr['mobilePhone']!="") {
$salesRepPhone = $Rowsr['mobilePhone'];
} else {
$salesRepPhone = $_SESSION['companyPhone'];
}	

$salesRepEmail = $Rowsr['userEmail'];

class PDF extends FPDF
{

// Text before product table
function HeadingText($company)
{
 global $LANG;
// global $LANG['date'];
 global $orderDate;
	
	$this -> Cell('100',20,'',0,0,'',false);
	 
 	$this->Image('../../images/logo/logo_pdf.png',120,10,73,10);	 
	$this -> Cell('100',20,'',0,0,'',false);
		
	$this->Ln();
	
	$this -> Cell('100',7,$_SESSION['companyName'],0,0,'',false);
	$this->Ln();
   $this -> Cell('100',7,$LANG['org_number']." ".$_SESSION['regNumber'],0,0,'',false);
   $this->Ln();
   $this -> Cell('100',13,'',0,1,'',false);

	$this->SetFont('Arial','B',20);
	$this -> Cell(180,10,'ORDREBEKREFTELSE',0,1,'C',false);
	$this->Ln();
	$this->SetFont('Arial','',12);

	// add the date
	$this -> Cell(180,7,$LANG['date'].": ".substr($orderDate,8,2).".".substr($orderDate,5,2).".".substr($orderDate,0,4),0,0,'R',false);
   

	$this->Ln();
	$this->Ln();
      	 
   $this -> Cell('100',6,'Vi takker for hyggelig telefonsamtale, og bekrefter med dette at det er',0,0,'',false);
   $this->Ln();
      
   $this -> Cell('100',6,utf8_decode('lagt inn bestilling på følgende produkt(er) :'),0,0,'',false);      
      
   $this->Ln();
	$this->Ln();
}


// Colored table
function ProductTable($header, $data)
{
    // Colors, line width and bold font
    $this->SetFillColor(45,103,165);
    $this->SetTextColor(255);
    $this->SetDrawColor(0,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
    // Header
    $w = array(20, 35, 80, 45);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
    $this->Ln();
    // Color and font restoration
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    // Data
    $fill = false;
    for($i=0;$i<count($data);$i++)
        $this->Cell($w[$i],7,$data[$i],1,0,'C',false);
    
    
    $this->Ln();
    $this->Cell($w[0]+$w[1]+$w[2],7,'Total pris eks. mva: ',1,0,'R',true);  
	 $this->Cell($w[3],7,$data[3],1,0,'C',true);
    $this->Ln();
		 		    
    // Closing line
    $this->Cell(array_sum($w),0,'','T');
}


function TermsText() { 
	global $LANG;
	global $terms;
	$this->Ln();
	$this -> Cell('100',4,'',0,1,'',false);
	$this->SetFont('Arial','B',12);	
	$this -> Cell('100',6,$LANG['terms'],0,1,'',false);	
	$this->SetFont('Arial','',12);
	$this -> MultiCell('180',6,$terms);
}



function CustomerTable ($customerData) {
global $LANG;	
	$this->Ln();
	$this -> Cell('100',2,'',0,1,'',false);
	
	$this->SetFont('Arial','',12);
	$this -> Cell('100',7,utf8_decode('Vi har registrert følgende opplysninger om foretaket deres:'),0,1,'',false);

	$this -> Cell('60',6,$LANG['company_name'].":",1,0,'',false);
	$this -> Cell('120',6,$customerData[0],1,1,'',false);
	$this -> Cell('60',6,$LANG['org_number'].":",1,0,'',false);
	$this -> Cell('120',6,$customerData[1],1,1,'',false);
	$this -> Cell('60',6,$LANG['company_address'].":",1,0,'',false);
	$this -> Cell('120',6,$customerData[2],1,1,'',false);
	$this -> Cell('60',6,$LANG['company_manager'].":",1,0,'',false);
	$this -> Cell('120',6,$customerData[3],1,1,'',false);
	$this -> Cell('60',6,$LANG['phone'].":",1,0,'',false);
	$this -> Cell('120',6,$customerData[4],1,1,'',false);
	$this -> Cell('60',6,$LANG['fax'].":",1,0,'',false);
	$this -> Cell('120',6,$customerData[5],1,1,'',false);
	$this -> Cell('60',6,$LANG['email'].":",1,0,'',false);
	$this -> Cell('120',6,$customerData[6],1,1,'',false);
	
}

function ContactText() { 
   global $salesRepName;
   global $salesRepPhone;
   global $salesRepEmail;
   global $LANG;
   
	$this -> Cell('100',8,'',0,1,'',false);
	$this->SetFont('Arial','',12);
	$this -> Cell('180',6,$LANG['our_contact'].": ".$salesRepName.". ".$LANG['phone'].": ".$salesRepPhone,0,1,'',false);
}



function FooterText () {
	global $LANG;
	$this -> Cell('100',1,'',0,1,'',false);
	$this->SetFont('Arial','',12);   
   $this -> Cell('100',6,$LANG['internet'].': '.$_SESSION['companyInternet'],0,1,'',false);
	$this -> Cell('100',6,$LANG['email'].': '.$_SESSION['companyEmail'],0,1,'',false);
	$this -> Cell('100',6,$LANG['phone'].': '.$_SESSION['companyPhone'],0,1,'',false);
	$this -> Cell('100',8,'',0,1,'',false);
	$this->SetFont('Arial','',10);
	$this -> MultiCell('180','5',utf8_decode($_SESSION['companyName'].' er underlagt taushetsplikt vedrørende kundeopplysninger. '.$_SESSION['companyName'].'s medarbeidere er alle underlagt samme taushetsplikt. Taushetsplikten omfatter all informasjon overlevert av kunden i tillegg til resultater og/eller vurderinger hvor kundens egne data inngår som beregningsgrunnlag. Taushetsplikten omfatter alle data uansett hvorvidt disse er gitt muntlig, elektronisk eller skriftlig'));
$this->SetFont('Arial','',14);
	
	}


}

$pdf = new PDF();
// Column headings
$header = array('Ant.', 'Org. Nr.', 'Produktnavn', 'Pris pr. stk');
$pdf->SetFont('Arial','',14);
$pdf->AddPage();
$pdf->HeadingText();
$pdf->ProductTable($header,$productData);
$pdf->TermsText();
$pdf->CustomerTable($customerData);
$pdf->ContactText();
$pdf->FooterText();
$pdf->Output($LANG['order_confirmation']."_".$orderID."_".$regNumber.".pdf",$outputForm);

?>