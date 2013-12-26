<?php 
//*****************
error_reporting(E_ALL & ~E_NOTICE); //所有錯誤中排除NOTICE提示
extract($_POST,EXTR_SKIP);
extract($_GET,EXTR_SKIP);
extract($_COOKIE,EXTR_SKIP);
$phpself=basename($_SERVER["SCRIPT_FILENAME"]);//被執行的文件檔名
$query_string=$_SERVER['QUERY_STRING'];
$query_string="2013111921164321f66.GIF";//指定檔案
$imagename = array(
	"_131128ee_0001.jpg",
	"_131128ee_0002.jpg",
	"_131128ee_0003.jpg",
	"_131128ee_0004.jpg",
	"_131128ee_0005.jpg"
); 
$tmp_=count($imagename)-1;
$tmp_=rand(0,$tmp_);
$query_string=$imagename[$tmp_];
//允許的副檔名
$mimetypes = array(
'jpg' => 'image/jpeg',
'png' => 'image/png', 
'gif' => 'image/gif', 
'pdf' => 'application/pdf'
); 
//**************
//檢查x資料夾在不在
if(0){
	$handle=opendir(realpath("./../")); $dir_in=""; 
	$cc=0; $tmp='';
	while(($file = readdir($handle))!==false) { 
		$tmp=$tmp."\n".$file;
		if(is_file($file)){$tmp=$tmp."[F]";}
		if(is_dir($file)){$tmp=$tmp."[D]";}
		if(file_exists($file)){$tmp=$tmp."[3]";}
	} 
	echo $tmp;
	if($cc){}else{die("dir miss");}
	if($cc>1){die("dir multi");}
	closedir($handle); 
}
//**************
//**************
$file_name="./../xA/".$query_string;//要呼叫的檔案
if(is_file($file_name) && 0){ //檔案存在
	$file_ext=substr($file_name,-3); //副檔名
	$cc=0;
	foreach($mimetypes as $k => $v){//檢查副檔名
		if( strtoupper($k) == strtoupper($file_ext) ){
		//if(strtolower($file_ext) == $k){ 
			$file_type=$v;
			$cc=$cc+1;
		}
	}
	$file_size=filesize($file_name);//檔案大小
	if($cc){//允許的副檔名
		header("Content-type:".$file_type);
		header("Content-Transfer-Encoding: Binary"); //編碼方式
		header("Cache-Control: cache, must-revalidate");
		header('Content-Length:'.$file_size);
		readfile($file_name); //讀取圖片
		exit;
		ob_start();
		ob_flush();
	}else{
		die('die');
	}
}

//**************

?> 
