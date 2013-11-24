<?php
//
extract($_POST,EXTR_SKIP);
extract($_GET,EXTR_SKIP);
extract($_COOKIE,EXTR_SKIP);
error_reporting(E_ALL & ~E_NOTICE); //所有錯誤中排除NOTICE提示

//
$phpself=basename($_SERVER["SCRIPT_FILENAME"]);//被執行的文件檔名
$urlselflink= "http://".$_SERVER["SERVER_NAME"].$_SERVER["SCRIPT_NAME"]."";
$ver="131125sfmdc1509"; //版本?
date_default_timezone_set("Asia/Taipei");//時區設定
$GLOBALS['time'] = time();//UNIX時間時區設定
$tim = $time.substr(microtime(),2,3);
$uid = uniqid(chr(rand(97,122)).chr(rand(97,122)),true);//建立唯一ID
$md5 = md5($uid);

$date_ym=date("ym", $time);//年月
$logfile="z".$date_ym.".log";//log檔案

//setcookie("b0", 'fuck',$time+3600);//cookie設定
$query_string=$_SERVER['QUERY_STRING'];
if(preg_match('/^[0-9]{10}$/', $query_string)){//全數字組成
	$date_time=date("y/m/d H:i:s", $query_string);
}else{//不符合
	$date_time="";
}
//

//表單
$form=<<<EOT
<form action="./$phpself" method="post" id='form1' onsubmit="return check2();">
<input type="hidden" name="mode" value="reg">
內文<textarea name="celltext" id="celltext" cols="48" rows="4" wrap=soft></textarea>
<br/>
<span style="display:none;">
<input type="checkbox" id="chk" name="chk">
<input type="text" name="na" id="na" size="8" value="??">
</span>
<input type="submit" id='send' name="send" value="送出"/>
<h2>$ver</h2>
<a href='../'>../</a>
</form>
<script language="Javascript">
document.getElementById("na").value="3";
document.getElementById("chk").checked=true;
function check(){document.getElementById("send").value="稍後";}
function check2(){
	document.getElementById("send").disabled=true;
	document.getElementById("send").style.backgroundColor="#ff0000";
	var tmp="";
	var regStr = 'http://';
	var re = new RegExp(regStr,'gi');
	tmp = document.getElementById("celltext").value;
	//alert(regStr);
	tmp = tmp.replace(re,"Ettpp//");//有些免空會擋過多的http字串
	document.getElementById("celltext").value =tmp;
}
</script>
EOT;

//html檔尾
$htmlend=<<<EOT
\n<br/>
</body></html>
EOT;

//html檔頭
function htmlstart_parameter($go,$ver){
	$box='';
	$box=md5($ver);
	$box=substr($box,-6);//substr($box,1,6)
	$ver_color="#".$box;//版本號的顏色
	if($go){//是否阻擋搜尋機器人快取 1=yes 0=no
$tmp=<<<EOT
\n<META NAME="ROBOTS" CONTENT="noINDEX, FOLLOW">
EOT;
	}else{$tmp="";}
//html檔頭
$host=$_SERVER["SERVER_NAME"];//所在網域
$date_time=$GLOBALS['date_time'];
$htmlstart=<<<EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="zh-tw">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="Content-Language" content="zh-tw">
<meta name="keywords" content=""/>
<meta name="description" content="$date_time"/>
<META http-equiv="Content-Script-Type" content="text/javascript">
<META http-equiv="Content-Style-Type" content="text/css">$tmp
<STYLE TYPE="text/css"><!--
body,pre { font-family:'細明體','MingLiU';}
h1 {font-size:small;display:inline;}
h2 {color:$ver_color;font-size:small;display:inline;}
A:hover  {color:#000080;background-color:#fafad2;text-decoration:none;}
blockquote {display:block; padding: 0px; margin:0; float:left; margin-left: 30px; BORDER-LEFT:#f00 10px solid; }
--></STYLE>
<title>firefly</title>
</head>
<body>
EOT;
//<a href="./dbchato/">dbchato</a>
	return $htmlstart;
}

////[自訂函數]轉換成安全字元
function chra_fix($tmp_xx){
	//$tmp_xx=trim($tmp_xx);
	//$w=addslashes($tmp_xx);//跳脫字元
	if(get_magic_quotes_gpc()) {$tmp_xx=stripcslashes($tmp_xx);}//去掉伺服器自動加的反斜線
	$tmp_xx=htmlspecialchars($tmp_xx);//HTML特殊字元
	//　&->&amp;　"->&quot;　'->&#039;　<->&lt;　>->&gt;
	$tmp_xx=str_replace("\r\n", "\r", $tmp_xx);  //改行文字の統一。 
	$tmp_xx=str_replace("\r", "\n",$tmp_xx);//Enter符->換行符
	$tmp_xx=preg_replace("/\n/","<br/>",$tmp_xx);//換行符 改成<br/>
	//$tmp_xx=str_replace("　", " ",$tmp_xx);//全形空格
	$tmp_xx=str_replace(",", "&#44;",$tmp_xx);//全形空格
	//$tmp_xx=str_replace("\t", " ",$tmp_xx);//水平製表符
	//$text=preg_replace("/\v/"," ",$text);//垂直製表符
	//$text=preg_replace("/\f/"," ",$text);//換頁符
	//$text=preg_replace("/\s/","",$text);//換頁符
	$tmp_xx=str_replace('\"', '&#34;', $tmp_xx);//雙引號 換成 HTML Characters
	$tmp_xx=str_replace('\'', '&#39;', $tmp_xx);//單引號 換成 HTML Characters
	$tmp_xx=str_replace('$', '&#36;', $tmp_xx);//錢字號 換成 HTML Characters
	$tmp_xx=str_replace('*', '&#42;', $tmp_xx);//米字號 換成 HTML Characters
	$tmp_xx=str_replace('^', '&#94;', $tmp_xx);//插入符 換成 HTML Characters
	$tmp_xx=str_replace('\\', '&#92;', $tmp_xx);//backslash 換成 HTML Characters 
	//$tmp_xx=str_replace('/', '&#47;', $tmp_xx);//backslash 換成 HTML Characters 
	$tmp_xx=str_replace('+', '&#43;', $tmp_xx);//加號 換成 HTML Characters 
	$tmp_xx=str_replace('?', '&#63;', $tmp_xx);//問號 換成 HTML Characters 
	//$tmp_xx=str_replace("=", "&#61;", $tmp_xx); //等於 換成 HTML Characters
	//$tmp_xx=str_replace("\\", "&#92;", $tmp_xx);
	return $tmp_xx;
}
////**[自訂函數]轉換成安全字元


function about_time($go,$time){
	$tmp=$time-$go;
	//$go=$tmp;
	switch($tmp){
		case ($tmp>365*86400):
			$tmp=intval($tmp/2592000);
			$go=$tmp.'年前';
		break;
		case ($tmp>30*86400):
			$tmp=intval($tmp/2592000);
			$go=$tmp.'個月前';
		break;
		case ($tmp>7*86400):
			$tmp=intval($tmp/604800);
			$go=$tmp.'週前';
		break;
		case ($tmp>86400):
			$tmp=intval($tmp/86400);
			$go=$tmp.'天前';
		break;
		case ($tmp>3600):
			$tmp=intval($tmp/3600);
			$go=$tmp.'小時前';
		break;
		case ($tmp>60):
			$tmp=intval($tmp/60);
			$go=$tmp.'分前';
		break;
		case ($tmp>10):
			$tmp=intval($tmp/10);
			$tmp=$tmp*10;
			$go=$tmp.'秒前';
		break;
		case ($tmp<0):
			$go=$tmp.'error';
		break;
		default:
			$go='幾秒前';
		break;
	}
	return $go;
}


?>
