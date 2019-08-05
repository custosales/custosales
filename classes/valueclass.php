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


      
function computeCompanyValue ($factor=5, $driftsinntekt, $varekost, $lonn, $avskrivninger, $andreDriftskostnader, $years=3) {  
  
	$EBIT = ($driftsinntekt - ($varekost+$lonn+$avskrivninger+$andreDriftskostnader))*$years;
    
	
    $EBITDA = $EBIT + $avskrivninger;
    
    $AvgEBITDA = $EBITDA/$years;
    
    $CashFlow = $AvgEBITDA*$factor;
    
    $companyValue = $EBITDA+$CashFlow;
    
    return $EBIT;
    return $EBITDA;
    return $companyValue;
        
  }
    
}
?>