var sendXmlHttp = getXmlHttpRequestObject();
var getXmlHttp = getXmlHttpRequestObject();
var prevID = 0;
var autoRefreshTime;

//Gets the browser XmlHttpRequest Object
function getXmlHttpRequestObject() {

	if (window.XMLHttpRequest)
		return new XMLHttpRequest();
	else if(window.ActiveXObject)
		return new ActiveXObject("Microsoft.XMLHTTP");
	else
		document.getElementById('p_status').innerHTML='Status: Cound not create XmlHttpRequest Object.';
		
}

function startChat() {

	document.getElementById("message").focus();
	fetchChat();
}


function fetchChat() {

	if( getXmlHttp.readyState == 4 || getXmlHttp.readyState == 0 ) {
		getXmlHttp.open( "GET", '/cgi-bin/pybackend?chat=1&prev=' + prevID, true );
		getXmlHttp.onreadystatechange = handleReceive; 
		getXmlHttp.send();
	}	
}	

function handleReceive() {

	if( getXmlHttp.readyState == 4 && getXmlHttp.status==200 ) {
		var chatDiv		= document.getElementById( 'chatbox' );
		var jsonDoc 	= eval( "(" + getXmlHttp.responseText + ")" );
		for( i=0;i < jsonDoc.root.message.length; i++ ) {
			chatDiv.innerHTML += '(' + '<font class="chatTime">' 
							  + jsonDoc.root.message[i].time + '</font>' + ')';
			chatDiv.innerHTML += '&nbsp;';
			chatDiv.innerHTML += jsonDoc.root.message[i].user + ':&nbsp;';
			chatDiv.innerHTML += jsonDoc.root.message[i].text + '<br />';
			chatDiv.scrollTop = chatDiv.scrollHeight;
			prevID = jsonDoc.root.message[i].id;
		}
		autoRefreshTime = setTimeout('fetchChat();',1000); //Refresh in 2 secs
	}
}


function sendMessage() {

	if(document.getElementById('message').value == '') {
		alert("Message empty");
		return;
	}
	if (sendXmlHttp.readyState == 4 || sendXmlHttp.readyState == 0) {
		sendXmlHttp.open("POST", '/cgi-bin/pybackend?chat=1&prev=' + prevID, true);
		sendXmlHttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		sendXmlHttp.onreadystatechange = handleSend; 
		var param = 'message=' + document.getElementById('message').value;
		param += '&userid=11';
		sendXmlHttp.send(param);
		document.getElementById('message').value = '';
	}							
}

function handleSend() {

	clearInterval(autoRefreshTime);
	fetchChat();
}


function resetChat() {

	if (sendXmlHttp.readyState == 4 || sendXmlHttp.readyState == 0) {
		sendXmlHttp.open("POST", '/cgi-bin/pybackend?chat=1', true);
		sendXmlHttp.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		sendXmlHttp.onreadystatechange = handleReset; 
		var param = 'action=reset';
		sendXmlHttp.send(param);
		document.getElementById('message').value = '';
	}							
}

function handleReset() {

	document.getElementById('chatbox').innerHTML = '';
	fetchChat();
}	


function clearForms() {

	var i;
	for (i = 0; (i < document.forms.length); i++) {
		document.forms[i].reset();
	}
}

function submitOnEnter() {

	sendMessage();
	return false;
}

