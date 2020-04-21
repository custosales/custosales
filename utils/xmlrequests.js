export const makeAnXMLRequest = (url, type = 'GET', displayElement) => {
	const xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = () => {
	 if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
		 if (displayElement) {
			 document.getElementById(displayElement).innerHTML = xmlhttp.responseText;
		 }
		 return xmlhttp.responseText;
	 } 
	}
	xmlhttp.open(type, url, true);
	xmlhttp.send();
}

export const XMLGetRequest = (url, displayElement) => {
	const xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = () => {
	 if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
		 if (displayElement) {
			 document.getElementById(displayElement).innerHTML = xmlhttp.responseText;
		 }
		 return xmlhttp.responseText;
	 } 
	}
	xmlhttp.open('GET', url, true);
	xmlhttp.send();
}

export const XMLGETRequestWithSuccessAction = (url, actionBlock = null) => {
	const xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = () => {
	 if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
		 if (actionBlock) {
             actionBlock
		 }
		 return xmlhttp.responseText;
	 } 
	}
	xmlhttp.open('GET', url, true);
	xmlhttp.send();
}