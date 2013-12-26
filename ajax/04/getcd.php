<?php
$q=$_GET["q"];

$xmlDoc = new DOMDocument();
$xmlDoc->load("cd_catalog.xml"); //Åª¨úcd_catalog.xml
//§ì¨útag¦³ARTISTªº¦Cªí
$x=$xmlDoc->getElementsByTagName('ARTIST');

for($i=0; $i<=$x->length-1; $i++){
	//Process only element nodes
	//nodeType ÄÝ©Ê¥iªð¦^¸`ÂIªº¸`ÂIÃþ«¬¡C//1=Node.ELEMENT_NODE
	if($x->item($i)->nodeType==1){
		//nodeValue Œp©Ê¥i„¦¸m©Îªð¦^¬Y…ëŠ»ªº­È¡A®ÚÕu¨ä‹Ý«¬¡C
		//childNodes Œp©Ê¥iªð¦^«ü©w…ëŠ»ªº¤l…ëŠ»ªº…ëŠ»¦Cªí¡C
		if($x->item($i)->childNodes->item(0)->nodeValue == $q){ //²Å¦X¦r¦ê
			//parentNode Œp©Ê¥iªð¦^¬Y…ëŠ»ªº¤÷…ëŠ»¡C
			$y=($x->item($i)->parentNode);
		}
	}
}

$cd=($y->childNodes);//¥þ³¡¦Cªí?

for($i=0;$i<$cd->length;$i++){
	//Process only element nodes
	if($cd->item($i)->nodeType==1){//¤ñ¹ï?
		echo($cd->item($i)->nodeName); //tag¦WºÙ
		echo(": ");
		echo($cd->item($i)->childNodes->item(0)->nodeValue); //tag¤º®e
		echo("<br />");
	} 
}
?>