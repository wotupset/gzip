<?php
$q=$_GET["q"];

$xmlDoc = new DOMDocument();
$xmlDoc->load("cd_catalog.xml"); //讀取cd_catalog.xml
//抓取tag有ARTIST的列表
$x=$xmlDoc->getElementsByTagName('ARTIST');

for($i=0; $i<=$x->length-1; $i++){
	//Process only element nodes
	//nodeType 屬性可返回節點的節點類型。//1=Node.ELEMENT_NODE
	if($x->item($i)->nodeType==1){
		//nodeValue �p性可�次m或返回某���貌滬�，根据其�搦活C
		//childNodes �p性可返回指定���貌漱l���貌����誚C表。
		if($x->item($i)->childNodes->item(0)->nodeValue == $q){ //符合字串
			//parentNode �p性可返回某���貌漱����說C
			$y=($x->item($i)->parentNode);
		}
	}
}

$cd=($y->childNodes);//全部列表?

for($i=0;$i<$cd->length;$i++){
	//Process only element nodes
	if($cd->item($i)->nodeType==1){//比對?
		echo($cd->item($i)->nodeName); //tag名稱
		echo(": ");
		echo($cd->item($i)->childNodes->item(0)->nodeValue); //tag內容
		echo("<br />");
	} 
}
?>