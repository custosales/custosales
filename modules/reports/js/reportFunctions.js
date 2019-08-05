function showRepSales(repID,year) {
	
	// Show user Graphs	
	document.getElementById('repGraphArea').style.height='1750px';
	document.getElementById('repGraphArea').style.width='550px';
	document.getElementById('repGraphArea').style.visibility='visible';
	document.getElementById('repGraphArea').src="modules/reports/get_salesrep_charts.php?year="+year+"&userID="+repID;				
	
	// Show User Tables	
	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function()  {
  		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
    			document.getElementById("repArea").innerHTML=xmlhttp.responseText;
			} 
    }
  
	xmlhttp.open("GET","modules/reports/rep_monthly_sales.php?userID="+repID+"&year="+year,true);
	xmlhttp.send();		
	
	}