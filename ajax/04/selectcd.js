var xmlHttp

function showCD(str){
	//xmlHttp=GetXmlHttpObject(); //跑下面的函式GetXmlHttpObject
	xmlHttp=Google_xmlHttp(); //跑下面的函式Google_xmlHttp
	if(xmlHttp==null){//瀏覽器不支援時的錯誤訊息
		alert("Browser does not support HTTP Request");
		return;
	} 
	var url="getcd.php"; 
	url=url+"?q="+str; //要求查詢的字串
	url=url+"&sid="+Math.random(); //避免快取抓不到更新
	xmlHttp.onreadystatechange=stateChanged; //跑下面的函式stateChanged
	xmlHttp.open("GET",url,true);//使用GET方法異步抓資料
	xmlHttp.send(null);//送出要求
}

function stateChanged(){
	if(xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){ //"complete" = 200
		document.getElementById("txtHint").innerHTML=xmlHttp.responseText; //回傳的資料
	}
}

function GetXmlHttpObject(){
	var xmlHttp=null;
	//需要測試的語句 //try...catch 語法// Firefox, Opera 8.0+, Safari
	try{xmlHttp=new XMLHttpRequest();}//正常版若出現錯誤就嘗試跑舊版
	//e=err 
	catch(e){
		//給IE
		try{xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");} //適應舊版(少見)...跑不動就換下面那個
		catch(e){xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");}//適應舊版
	}
	return xmlHttp;
}

function Google_xmlHttp(){ 
	var xmlHttp=null; 
	try{xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");}//適應舊版(少見)
	catch(e){
		try{xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");}//適應舊版
		catch(oc){xmlHttp=null;}
	}
	//以上都不能用就跑正常版
	if( !xmlHttp && typeof XMLHttpRequest != "undefined" ){xmlHttp=new XMLHttpRequest();}
	return xmlHttp;
}