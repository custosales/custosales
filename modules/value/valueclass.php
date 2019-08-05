<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of formclass 
 *
 * @author Terje Berg-Hansen
 */
class valueComputation {


      
function computeCompanyValue ($factor, $driftsinntekt, $varekost, $lonn, $avskrivninger, $andreDriftskostnader, $years) {  
  
	$EBIT = ($driftsinntekt - ($varekost+$lonn+$avskrivninger+$andreDriftskostnader))*$years;
    
	
    $EBITDA = $EBIT + $avskrivninger;
    
    $AvgEBITDA = $EBITDA/$years;
    
    $CashFlow = $AvgEBITDA*$factor;
    
    $companyValue = $EBITDA+$CashFlow;
    
    print "<br>";
    print "EBIT = ".$EBIT."<br>";
    print "EBITDA = ".$EBITDA."<br>";
    
    print "FirmaVerdi = ".($companyValue*1000)." kr.";
        
  }
    
}
?>