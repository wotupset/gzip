<?php
$q=$_GET["q"];

$xmlDoc = new DOMDocument();
$xmlDoc->load("cd_catalog.xml"); //Ū��cd_catalog.xml
//���tag��ARTIST���C��
$x=$xmlDoc->getElementsByTagName('ARTIST');

for($i=0; $i<=$x->length-1; $i++){
	//Process only element nodes
	//nodeType �ݩʥi��^�`�I���`�I�����C//1=Node.ELEMENT_NODE
	if($x->item($i)->nodeType==1){
		//nodeValue �p�ʥi���m�Ϊ�^�Y�늻���ȡA���u��ݫ��C
		//childNodes �p�ʥi��^���w�늻���l�늻���늻�C��C
		if($x->item($i)->childNodes->item(0)->nodeValue == $q){ //�ŦX�r��
			//parentNode �p�ʥi��^�Y�늻�����늻�C
			$y=($x->item($i)->parentNode);
		}
	}
}

$cd=($y->childNodes);//�����C��?

for($i=0;$i<$cd->length;$i++){
	//Process only element nodes
	if($cd->item($i)->nodeType==1){//���?
		echo($cd->item($i)->nodeName); //tag�W��
		echo(": ");
		echo($cd->item($i)->childNodes->item(0)->nodeValue); //tag���e
		echo("<br />");
	} 
}
?>