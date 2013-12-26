<?php 
header("content-Type: text/html; charset=utf-8"); //語言強制
$query_string=$_SERVER['QUERY_STRING'];
$phpself=basename($_SERVER["SCRIPT_FILENAME"]);//被執行的文件檔名
$GLOBALS['phpself'] = $phpself;
extract($_POST,EXTR_SKIP);extract($_GET,EXTR_SKIP);extract($_COOKIE,EXTR_SKIP);
date_default_timezone_set("Asia/Taipei");
$time=time();$GLOBALS['time'] = $time;define("_def_TIME", $time);//UNIX時間時區設定
error_reporting(E_ALL & ~E_NOTICE); //所有錯誤中排除NOTICE提示

//**********
$htmlhead = <<<EOT
<html><head>
<title>$phphost</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<META http-equiv="Content-Script-Type" content="text/javascript">
<META http-equiv="Content-Style-Type" content="text/css">
<META NAME='ROBOTS' CONTENT='noINDEX, noFOLLOW'>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<STYLE TYPE="text/css"><!--
body { 
font-family:"細明體",'MingLiU'; 
background-color:#FFFFEE;
color:#800000;
}
A,A:active,A:link,A:visited {color:#0000EE;}
A:hover  {color:#000080;background-color:#fafad2;}
tr:hover {color:#000080;background-color:#fafad2;}
--></STYLE>
</head>
<body>
EOT;

$htmlend = <<<EOT
<script>
$(document).ready(function () {
	$( "#a_btn" ).click(function() {
		var tmp=date_now();
		document.getElementById("a_text").value = tmp;
	});
	$( "#b_btn" ).click(function() {
		//var tmp = new Date().getTime();
		var tmp=date_now();
		document.getElementById("b_text").value = tmp;
	});
	$( "#c_btn_a" ).click(function() {
		document.getElementById("c_text").value = "W";
	});
	$( "#c_btn_b" ).click(function() {
		document.getElementById("c_text").value = "L";
	});
});
function date_now(){
	var d = new Date()
	var yy=d.getFullYear().toString();
	var mm=d.getMonth()+1; mm=mm.toString();mm=padleftzero(mm,2);
	var dd=d.getDate().toString();dd=padleftzero(dd,2);
	var hh=d.getHours().toString();hh=padleftzero(hh,2);
	var ii=d.getMinutes().toString();ii=padleftzero(ii,2);
	var ss=d.getSeconds().toString();ss=padleftzero(ss,2);
	var tmp= yy +"/"+ mm +"/"+ dd +" "+ hh +":"+ii +":"+ ss;
	return tmp;
}
function padleftzero(a,b){
	if(a.length >= b){
		return a;
	}else{
		return padleftzero("0"+a,b);
	}
}
</script>
</body></html>
EOT;

$htmlbody = <<<EOT
<form id='form2' action='$phpself' method='post' autocomplete="off">
	<input type="hidden" name="mode" value="reg">
	<div>
	<input type="button" id="a_btn" value="上一場結束時間"/>
	<input type="text" id="a_text" name="a_text" maxlength="32" size="16" value="上一場結束時間"/>
	</div>
	<div>
	<input type="button" id="b_btn" value="這場開始時間"/>
	<input type="text" id="b_text" name="b_text" maxlength="32" size="16" value="這場開始時間"/>
	</div>
	<div>
	<input type="button" id="c_btn_a" value="勝=W=win"/>
	<input type="button" id="c_btn_b" value="負=L=lose"/>
	<input type="text" id="c_text" name="c_text" maxlength="32" size="16" value=""/>
	</div>
	<input type="submit" value="送出"/>  
</form>
<form id='form3' action='$phpself' method='post' autocomplete="off">
	<input type="hidden" name="mode" value="del_all">
	<input type="text" id="x_pw" name="x_pw" maxlength="32" size="16" value="??"/>
	<input type="submit" value="清空"/>  
</form>
<a href="./">home</a>
<a href="./$phpself">back</a>

EOT;

switch($mode){
	case 'reg':
		$htmldata='';
		$x=rec($a_text,$b_text,$c_text);
		$htmldata="<pre>".$x."</pre>";
	break;
	case 'del_all':
		if($x_pw!="qqq"){die("密碼?");}
		$htmldata='';
		$x=clear();
		$htmldata="<pre>".$x."</pre>";
	break;
	default:
	break;
}

function clear(){
	$phpself=$GLOBALS['phpself'];
	$logfile="./".$phpself."_.log";
	if(!is_writeable(realpath('./'))){die("所在目錄無法寫入");} //檢查根目錄權限
	if(is_file($logfile)){//檔案存在就載入紀錄
		if(!is_writeable(realpath($logfile))){die("檔案無法寫入");}
		if(!is_readable(realpath($logfile))){die("檔案無法讀取");}
		$tmp_f_cnt=file_get_contents($logfile);//載入紀錄
		$tmp_f_cnt=trim($tmp_f_cnt);
	}else{//檔案不存在
		$tmp_f_cnt="";//給空的紀錄
	}
	if(unlink($logfile)){$x='刪除成功';}else{$x='刪除失敗';}
	return $x;
}
function rec($a,$b,$c){
	$phpself=$GLOBALS['phpself'];
	$logfile="./".$phpself."_.log";
	$tmp_f_ct=0;
	//****************
	if(is_file($logfile)){//檔案存在就載入紀錄
		if(!is_writeable(realpath($logfile))){die("檔案無法寫入");}
		if(!is_readable(realpath($logfile))){die("檔案無法讀取");}
		$tmp_f_cnt=file_get_contents($logfile);//載入紀錄
		$tmp_f_cnt=trim($tmp_f_cnt);
	}else{//檔案不存在
		$tmp_f_cnt="";//給空的紀錄
		if(!is_writeable(realpath('./'))){die("所在目錄無法寫入");} //檢查根目錄權限
		$cp = fopen($logfile, "a+");//建立空的紀錄檔
		fclose($cp);
	}
	$date=gmdate("Y-m-d H:i:s",$GLOBALS['time']);
	//****************
	$input_data='';
	$input_data="$a\t$b\t$c\n$tmp_f_cnt"; //加入新資料
	$cp = fopen($logfile, "a+") or die('die#fopen');// 讀寫模式, 指標於最後, 找不到會嘗試建立檔案
	flock($cp, LOCK_EX);//鎖定
	//rewind($cp); //從頭讀取
	//$buf=fread($cp,1000000); //讀取至暫存
	ftruncate($cp, 0); //砍資料至0
	fputs($cp, $input_data);//寫入
	fclose($cp);//關閉檔案要求
	//**************
	$x=$input_data;
	return $x;
}

echo $htmlhead."\n" ;
echo $htmlbody."\n" ;

echo $htmldata."\n" ;

echo $htmlend."\n" ;
?> 
