// email signup functions

function focusInput(input, defval) {
	if (input.value == defval) {
		input.value = "";
		input.style.color = "black";
	}
}
function blurInput(input, defval) {
	if (input.value.length == 0) {
		input.value = defval;
		input.style.color = "gray";
	}
}
function doSignUp() {
	var name = document.getElementById("signUpName").value;
	var email = document.getElementById("signUpEmail").value;
	if (email.length == 0 || email == "Email" || !email.match(/^[\w-]+@[\w-]+\.[\w]+/)) {
		alert("Please specify a valid email");
		return;
	}
	ajaxText("signup.php?name=" + escape(name) + "&email=" + escape(email), processSignUp);
}
function processSignUp(text) {
	document.getElementById("signup").innerHTML = text;
}

//Ajax functions
var xmlHttp;
var ajaxClientListener;

function getXmlHttpObject(handler) { 
	var objXmlHttp=null

	if (navigator.userAgent.indexOf("Opera")>=0) {
		alert("Opera is not a supported browser - please use IE or a Mozilla derived browser (eg Firefox)") 
		return; 
	}
	if (navigator.userAgent.indexOf("MSIE")>=0) { 
		var strName="Msxml2.XMLHTTP"
		if (navigator.appVersion.indexOf("MSIE 5.5")>=0) {
			strName="Microsoft.XMLHTTP"
		} 
		try { 
			objXmlHttp=new ActiveXObject(strName)
			objXmlHttp.onreadystatechange=handler 
			return objXmlHttp
		} catch(e) { 
			alert("Error. Scripting for ActiveX might be disabled") 
			return;
		} 
	} 
	if (navigator.userAgent.indexOf("Mozilla")>=0) {
		objXmlHttp=new XMLHttpRequest()
		objXmlHttp.onload=handler
		objXmlHttp.onerror=handler 
		return objXmlHttp
	}
}

function callAJAX(url, listener) {
	xmlHttp=getXmlHttpObject(listener)
	xmlHttp.open("GET", url + (getRandParam(url) + Math.random()) , true)
	xmlHttp.send(null)
}

function ajaxText(url, listener) {
	ajaxClientListener = listener;
	xmlHttp=getXmlHttpObject(internalTextAJAXListener)
	xmlHttp.open("GET", url + (getRandParam(url) + Math.random()) , true)
	xmlHttp.send(null)
}
function postAjaxText(url, listener, contentType, content) {
	ajaxClientListener = listener;
	xmlHttp=getXmlHttpObject(internalTextAJAXListener)
	xmlHttp.open("POST", url + getRandParam(url) + Math.random(), true)
	xmlHttp.setRequestHeader("Content-Type", contentType);
	xmlHttp.send(content);
}
function internalTextAJAXListener() {
	if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {
		var text = xmlHttp.responseText;
		ajaxClientListener(text);
	}
}
function ajaxXML(url, listener) {
	ajaxClientListener = listener;
	xmlHttp=getXmlHttpObject(internalXMLAJAXListener)
	xmlHttp.open("GET", url + (getRandParam(url) + Math.random()) , true)
	xmlHttp.send(null)
}
function postFormAjaxXML(url, listener, content) {
	postAjaxXML(url, listener, "application/x-www-form-urlencoded", content);
}
function postAjaxXML(url, listener, contentType, content) {
	ajaxClientListener = listener;
	xmlHttp=getXmlHttpObject(internalXMLAJAXListener)
	xmlHttp.open("POST", url + getRandParam(url) + Math.random(), true)
	xmlHttp.setRequestHeader("Content-Type", contentType);
	xmlHttp.send(content);
}
function internalXMLAJAXListener() {
	if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {
		var xml = xmlHttp.responseXML;
		ajaxClientListener(xml);
	}
}
function getRandParam(url) {
	var randParam = "&r=";
	if (url.indexOf("?") == -1) {
		randParam = "?r=";
	}
	return randParam;
}

//Following are more robust functions:

var ajaxHandler = new Array();
var listener = new Array();

function getAjaxHandler ()
{
	try
	{
		// Firefox, Opera 8.0+, Safari
		handler=new XMLHttpRequest();
		}
	catch (e)
	{
		// Internet Explorer
		try
		{
			handler=new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch (e)
		{
			try
			{
				handler=new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch (e)
			{
				alert("Your browser does not support AJAX!");
			}
		}
	}

	var handle = ajaxHandler.length;
	ajaxHandler[handle] = handler;
	return handle;
}

function ajax2XML (url, callback)
{
	var handle = getAjaxHandler();

	if (handle >= 0)
	{
		var handler = ajaxHandler[handle];
		handler.open("GET", url, true);
		handler.onreadystatechange = function()
		{
			var response= ajaxHandler[handle];
			if (response.readyState == 4 || response.readyState == "complete") {
				var xml = response.responseXML;
				callback(xml);
				ajaxHandler[handle] = null;
			}
		}
	
		handler.send(null);
	}
}
function loadXMLDoc(fname)
{
	var xmlDoc;
	// code for IE
	if (window.ActiveXObject)
	{
		xmlDoc=new ActiveXObject("Microsoft.XMLDOM");
	}
	// code for Mozilla, Firefox, Opera, etc.
	else if (document.implementation && document.implementation.createDocument)
	{
		xmlDoc=document.implementation.createDocument("","",null);
	} else {
		alert('Your browser cannot handle this script');
	}
	xmlDoc.async=false;
	xmlDoc.load(fname);
	return(xmlDoc);
}
function ajaxJSON(url, listener) {
	ajaxClientListener = listener;
	xmlHttp=getXmlHttpObject(internalJSONAJAXListener)
	xmlHttp.open("GET", url + (getRandParam(url) + Math.random()) , true)
	xmlHttp.send(null)
}
function internalJSONAJAXListener() {
	if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {
		//alert(xmlHttp.responseText);
		var obj = eval("(" + xmlHttp.responseText + ")");
		ajaxClientListener(obj);
	}
}
function asInnerHTML(text, obj) {
	//Find scripts
	var splited = text.split(/<\/?script.*?>/);
	var newText = "";
	var newScript = "";
	for (var i=0; i<splited.length; i++) {
		//alert((i % 2 == 0 ? "Text" : "Script") + ":" + splited[i]);
		if (i % 2 == 0) {
			newText += splited[i];
		} else {
			//It's a script...
			var script = splited[i];
			if (script.indexOf("<!--") > -1) {
				script = script.substring(script.indexOf("<!--") + 4);
				if (script.indexOf("//-->") > -1) {
					script = script.substring(0, script.indexOf("//-->"));
				}
			}
			newScript += "\n" + script;
		}
	}
	obj.innerHTML = newText;
	
	//Sort out functions
	var split = newScript.split(/function\s.*?\(/);

	var newTxt = "";
	
	var where = 0;
	for (var i=0; i<split.length; i++) {
		newTxt += split[i];
		//alert(split[i]);
		where += split[i].length;
	
		if (i<split.length-1) {
			var index = newScript.indexOf("(", where);
			var functionName = newScript.substring(where, index);
			where += functionName.length;
			//newTxt += 'alert(")))' + functionName.substring("function ".length) + '");';
			newTxt += functionName.substring("function ".length) + " = function(";
		}
	}
	
	//alert(newTxt);
	eval(newTxt);
}
function noop() {}