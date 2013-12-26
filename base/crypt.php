<?php
//**************
extract($_POST,EXTR_SKIP);//接受post
header('Content-type: text/html; charset=utf-8');
$phpself=basename($_SERVER["SCRIPT_FILENAME"]);//被執行的文件檔名
error_reporting(E_ALL & ~E_NOTICE); //所有錯誤中排除NOTICE提示
date_default_timezone_set("Asia/Taipei");//時區設定
//list($time, $msec) = explode('.', microtime(true)); 
list($msec,$time) = explode(' ', microtime()); 
$uid=uniqid();
$uid2=uniqid(chr(rand(65,90)),true);//建立唯一ID
//**************



ob_start(); //打开缓冲区 
//**************
if(CRYPT_STD_DES == 1){
	echo "Standard DES: \t\t".crypt("hello world")."";
}else{
	echo "Standard DES not supported.";
}
echo "<br/>\n";
//**************
if(CRYPT_EXT_DES == 1){
	echo "Extended DES: \t\t".crypt("hello world")."";
}else{
	echo "Extended DES not supported.";
}
echo "<br/>\n";
//**************
if(CRYPT_MD5 == 1){
	echo "MD5: \t\t\t".crypt("hello world")."";
}else{
	echo "MD5 not supported.";
}
echo "<br/>\n";
//**************
if(CRYPT_BLOWFISH == 1){
	echo "Blowfish: \t\t".crypt("hello world");
}else{
	echo "Blowfish DES not supported.";
}
echo "<br/>\n";
//**************
//$uid=uniqid(chr(rand(97,122)).chr(rand(97,122)),true);//建立唯一ID
$host =$_SERVER["SERVER_NAME"];
echo $host ;
echo "<br/>\n";

$tmp=$uid;
echo "uid: \t\t\t$uid->$uid2";
echo "<br/>\n";

$tmp= dechex($time);
echo "dechex_time: \t\t".$time."->".$tmp;
echo "<br/>\n";

//$tmp=dechex($microseconds);
$tmp1=substr($uid, -5); 
$tmp=hexdec($tmp1);
echo "microseconds: \t\t$msec->$tmp->$tmp1";
echo "<br/>\n";

$timestamp = substr(uniqid(), 0, -5); 
$tmp= date('r', hexdec($timestamp));
echo "uid->time: \t\t".$tmp;
echo "<br/>\n";

$str_shuffle=str_shuffle($host);//建立唯一ID
echo "str_shuffle: \t\t".$str_shuffle;
echo "<br/>\n";



$md5=md5($host);
echo "md5: \t\t\t".$md5;
echo "<br/>\n";
$sha1 = sha1($host);
echo "sha1: \t\t\t".$sha1;
echo "<br/>\n";



function xxx($n,$f){
	if(preg_match("/[0-9]+/",$n)){}else{$n=16;}
	if(preg_match("/[a-z]{3}?/",$f)){}else{$f="ooo";}
	$f=(string)$f;
	$tarr=array();
	$a=substr($f,0,1); //echo $a; 第1個數字
	$b=substr($f,1,1); //echo $b; 第2個數字
	$c=substr($f,2,1); //echo $c; 第3個數字
	if($a=="o"){array_push($tarr,"1");} //加入1
	if($b=="o"){array_push($tarr,"2");} //加入2
	if($c=="o"){array_push($tarr,"3");} //加入3
	//echo "<pre>".print_r($tarr,true)."</pre>";
	shuffle($tarr);//打亂陣列
	$ct=count($tarr);//計算元素
	$tmp="";
	for($i=0; $i<$n; $i++){//n=字串長度
		$fork=rand(0,$ct-1);
		$fork=$tarr[$fork];
		//$fork=array_rand($tarr,1); //隨機取1個元素 
		//$fork=$tarr[$fork]; //
		switch($fork){
			case "1":
				$tmp=$tmp.chr(rand(48,57)); //數字
			break;
			case "2":
				$tmp=$tmp.chr(rand(65,90)); //大寫
			break;
			case "3":
				$tmp=$tmp.chr(rand(97,122)); //小寫英文
			break;
			default:
				//沒事
			break;
		}
	}
	return $tmp;
}

$tmp='';//
$tmp.=xxx(8,"xoo");
$tmp.="-";
$tmp.=xxx(4,"oxx");
$tmp.="-";
$tmp.=xxx(4,"xox");
$tmp.="-";
$tmp.=xxx(4,"xxo");
$tmp.="-";
$tmp.=xxx(12,"oxo");
echo "UUID/GUID<br/>\n";
echo $tmp;
echo "<br/>\n";

$tmp='自訂函數 ';//
$tmp.=xxx("aa","bb");
echo $tmp;
echo "<br/>\n";
require './Discuz_AzDGCrypt.php';//載入加密用函式
$htmlbody = ob_get_contents();
ob_end_clean(); 

//**************
$htmlstart=<<<EOT
<html><head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">
<META NAME='ROBOTS' CONTENT='noINDEX, noFOLLOW'>
<title>Tiara</title>
</head><body><pre>
EOT;
$htmlend=<<<EOT
</pre></body></html>\n
EOT;
//**************



echo $htmlstart;
echo $htmlbody;
echo $htmlend;

?>