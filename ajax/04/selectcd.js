var xmlHttp

function showCD(str){
	//xmlHttp=GetXmlHttpObject(); //�]�U�����禡GetXmlHttpObject
	xmlHttp=Google_xmlHttp(); //�]�U�����禡Google_xmlHttp
	if(xmlHttp==null){//�s�������䴩�ɪ����~�T��
		alert("Browser does not support HTTP Request");
		return;
	} 
	var url="getcd.php"; 
	url=url+"?q="+str; //�n�D�d�ߪ��r��
	url=url+"&sid="+Math.random(); //�קK�֨��줣���s
	xmlHttp.onreadystatechange=stateChanged; //�]�U�����禡stateChanged
	xmlHttp.open("GET",url,true);//�ϥ�GET��k���B����
	xmlHttp.send(null);//�e�X�n�D
}

function stateChanged(){
	if(xmlHttp.readyState==4 || xmlHttp.readyState=="complete"){ //"complete" = 200
		document.getElementById("txtHint").innerHTML=xmlHttp.responseText; //�^�Ǫ����
	}
}

function GetXmlHttpObject(){
	var xmlHttp=null;
	//�ݭn���ժ��y�y //try...catch �y�k// Firefox, Opera 8.0+, Safari
	try{xmlHttp=new XMLHttpRequest();}//���`���Y�X�{���~�N���ն]�ª�
	//e=err 
	catch(e){
		//��IE
		try{xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");} //�A���ª�(�֨�)...�]���ʴN���U������
		catch(e){xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");}//�A���ª�
	}
	return xmlHttp;
}

function Google_xmlHttp(){ 
	var xmlHttp=null; 
	try{xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");}//�A���ª�(�֨�)
	catch(e){
		try{xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");}//�A���ª�
		catch(oc){xmlHttp=null;}
	}
	//�H�W������δN�]���`��
	if( !xmlHttp && typeof XMLHttpRequest != "undefined" ){xmlHttp=new XMLHttpRequest();}
	return xmlHttp;
}