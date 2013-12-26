<?php 
//*****************
header('Content-type: text/html; charset=utf-8');
error_reporting(E_ALL & ~E_NOTICE); //所有錯誤中排除NOTICE提示
extract($_POST,EXTR_SKIP);
extract($_GET,EXTR_SKIP);
extract($_COOKIE,EXTR_SKIP);
$phpself=basename($_SERVER["SCRIPT_FILENAME"]);//被執行的文件檔名
$time = time() +8*60*60;//UNIX時間時區設定

$time_start = microtime(true);
$query_string=$_SERVER['QUERY_STRING'];
require './db_acpw.php';//$time
//$GLOBALS['time']=$time;
//$query_string=$GLOBALS['query_string'];
//*****************
$htmlhead=<<<EOT
<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<META http-equiv="Content-Script-Type" content="text/javascript">
<META http-equiv="Content-Style-Type" content="text/css">
<meta name="Robots" contect="noindex,follow">
<title>hashpic</title>
<style>
body {font-family:'細明體','MingLiU';}
</style>
<script type="text/javascript">
if(window.location.hash){}else{window.location.hash = '#3|t=700|2013-11-20_163212_cr.jpg';}
var old_hash=window.location.hash;
function OnHashChange(){
	setCookie('hashtag',window.location.hash,2);
	document.getElementById("hashtag").innerHTML=getCookie('hashtag');
	var tmp=old_hash;
	old_hash=window.location.hash;
	tmp=tmp+"->"+old_hash;
	document.getElementById("hashtag2").innerHTML=tmp;
}
window.onhashchange = OnHashChange;
window.onload = function(){
	document.getElementById("hashtag2").innerHTML=window.location.hash;
}
//
function getCookie(c_name){
	if(document.cookie.length>0){
		c_start=document.cookie.indexOf(c_name + "="); //找cookie
		if(c_start!=-1){ //有找到
			c_start=c_start + c_name.length+1 
			c_end=document.cookie.indexOf(";",c_start);
			if(c_end==-1){c_end=document.cookie.length;}
			return unescape(document.cookie.substring(c_start,c_end))
		} 
	}
	return ""
}
function setCookie(c_name,value,expiredays){
	var exdate=new Date()
	var tmp='';
	exdate.setDate(exdate.getDate()+expiredays)
	if(expiredays==null){tmp="";}else{tmp=";expires="+exdate.toGMTString();}
	document.cookie=c_name+ "=" +escape(value)+tmp;
}
</script>
</head><body>
cookie=<span id='hashtag'></span><br/>
javascript=<span id='hashtag2'></span><br/>
<a href="./$phpself?1385194501404_cr.jpg">hashpic</a>
<a href="./$phpself?2013111921164321f66.GIF">hashpic</a>
<a href="./hta/">hta</a>
<a href="./index.php">index</a>
<br/>
<a href="#aaa">aaa</a>
<a href="#bbb">bbb</a>
<a href="#ccc">ccc</a>
<a href="#hash_a">hash_a</a>
<br/>

EOT;
//<a href="./hta/">hta</a>
//<a href="./inde.php">index</a>
//**************
$htmlend=<<<EOT
</body></html>
EOT;
//**************
//檢查x資料夾在不在
$handle=opendir("./"); $dir_in=""; 
$cc=0;
while(($file = readdir($handle))!==false) { 
	if(is_dir($file)){//只針對資料夾
		if($file=="."||$file == ".."){
			//什麼事都不做
		}else{
			if(preg_match('/^x.+$/', $file)){
				$dir_in=$file;$cc=$cc+1;
			}else{} //檢驗$query_string格式
		}
	}
} 
closedir($handle); 
if($cc){}else{die("dir miss");}
if($cc>1){die("dir multi");}
//**************
$cc=0; $tmp_str=""; $tmp_arr=array();
$tmp_str_jpg='';
$tmp_str_png='';
$tmp_str_gif='';
$url="./".$dir_in."/";
if(is_dir($url)){$tmp_str="dir ok<br/>";}else{die('Xdir');}
$handle=opendir($url); //檢查放圖片的資料夾
while( ($file = readdir($handle)) !==false) { 
	$cc=$cc+1;
	$tmp_arr[$cc][0] = $file; 
	$tmp_arr[$cc][1] = $url.$file; 
	if(is_file($tmp_arr[$cc][1])){//只針對檔案
		if(preg_match('/\.jpg$/i', $tmp_arr[$cc][0])){ //i = 不分大小寫
			$tmp_str_jpg.="<a href='./".$phpself."?".$tmp_arr[$cc][0]."'><img src='".$tmp_arr[$cc][1]."'/></a> ";
		}else{} //檢驗$query_string格式
		if(preg_match('/\.png$/i', $tmp_arr[$cc][0])){
			$tmp_str_png.="<a href='./".$phpself."?".$tmp_arr[$cc][0]."'><img src='".$tmp_arr[$cc][1]."'/></a> ";
		}else{} //檢驗$query_string格式
		if(preg_match('/\.gif$/i', $tmp_arr[$cc][0])){
			$tmp_str_gif.="<a href='./".$phpself."?".$tmp_arr[$cc][0]."'><img src='".$tmp_arr[$cc][1]."'/></a> ";
		}else{} //檢驗$query_string格式
	}
} 
closedir($handle); 
$tmp_str_jpg.='<hr/>';
$tmp_str_png.='<hr/>';
$tmp_str_gif.='<hr/>';
$tmp_str=$tmp_str.$tmp_str_jpg.$tmp_str_png.$tmp_str_gif;
//**************

//允許的副檔名
$mimetypes = array(
'jpg' => 'image/jpeg',
'png' => 'image/png', 
'gif' => 'image/gif', 
'pdf' => 'application/pdf'
); 

$file_name="./".$dir_in."/".$query_string;//要呼叫的檔案
if($query_string && is_file($file_name)){//有query_string + 檔案存在
	//**************
	if(0){
		$rec_x = rec($mysql_host,$mysql_user,$mysql_pass,$mysql_dbnm); //紀錄來源 //回傳紀錄檔行數
		$rec_x_0=$rec_x[0]; //輸入的字串
		$rec_x_1=$rec_x[1]; //計數器
		$rec_x = print_r($rec_x,true);
		$rec_x ="<pre>$rec_x</pre>";
	}
	//**************
	$file_ext=substr($file_name,-3); //副檔名
	$cc=0;
	foreach($mimetypes as $k => $v){//檢查副檔名
		if(preg_match("/^".$file_ext."$/i", $k)){
		//if(strtolower($file_ext) == $k){ 
			$file_type=$v;
			$cc=$cc+1;
		}
	}
	$file_size=filesize($file_name);//檔案大小
	if($cc){//允許的副檔名
		ob_start();
		header("Content-type:".$file_type);
		//header('Content-type:application/force-download');
		header("Content-Transfer-Encoding: Binary"); //編碼方式
		header("Cache-Control: cache, must-revalidate");
		header('Content-Length:'.$file_size);
		//$tmp_fn_out=$tmp.'_'.substr(md5_file($file_name),0,5);//輸出的檔名
		//$tmp="Content-Disposition: attachment; filename=\"build-$tmp_fn_out.$k\"";
		//header($tmp);
		readfile($file_name); //讀取圖片
		ob_flush();
		exit;
	}
}else{//沒有query_string 或 檔案不存在都會跳到這邊
	$htmlbody='';
	if($query_string){$htmlbody.= "找不到檔案<br/>\n";}//如果有query還跳到這邊 表示檔案不存在
	$string="臣亮言：先帝創業未半，而中道崩殂。
	今天下三分，益州疲弊，此誠危急之秋也。
	然侍衛之臣，不懈於內﹔忠志之士，忘身於外者，蓋追先帝之殊遇，欲報之於陛下也。
	誠宜開張聖聽，以光先帝遺德，恢弘志士之氣；
	不宜妄自菲薄，引喻失義，以塞忠諫之路也。";
	//mb_internal_encoding("UTF-8");
	$htmlbody.= mb_substr($string,0,13,"utf-8")."<br/>\n";
	$tmp_s=$_COOKIE['hashtag']; //讀取cookie
	$htmlbody.= "$tmp_s<br/>\n";
	$htmlbody.= "<a href='../'>../</a>"."<br/>\n";
	$time_end = microtime(true);
	$time_runs = $time_end - $time_start;
	$htmlbody.="執行=$time_runs<br/>\n";//php執行時間
	$htmlbody.=$mysql_user."@".$mysql_host."(".$mysql_dbnm.")<br/>\n";
	$htmlbody.="$rec_x<br/>\n";
	$htmlbody.="".$tmp_str."<br/>\n";
	echo $htmlhead;
	echo $htmlbody;
	echo $htmlend;
}

//**********
function newtable($t){//資料表格式
	$sql = "CREATE TABLE IF NOT EXISTS `$t`
	(
	`date` varchar(255),
	`user_ip` varchar(255) ,
	`user_ip2` varchar(255) ,
	`user_from` varchar(255),
	`arg1` varchar(255),
	`arg2` varchar(255),
	`arg3` varchar(255),
	`auto_time` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	`auto_id` INT NOT NULL AUTO_INCREMENT,
	PRIMARY KEY ( auto_id )
	)ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci";
	return $sql;
}
//**********
function rec($a,$b,$c,$d){
	$time=$GLOBALS['time'];
	$mysql_host=$a;
	$mysql_user=$b;
	$mysql_pass=$c;
	$mysql_dbnm=$d;
	
	//**********連結資料庫
	$con = mysql_connect($mysql_host, $mysql_user, $mysql_pass);//連結資料庫
	if(mysql_error()){die(mysql_error());}else{}//有錯誤就停止
	mysql_query("SET time_zone='+8:00';",$con);
	mysql_query("SET CHARACTER_SET_database='utf8'",$con);
	mysql_query("SET NAMES 'utf8'"); 
	// ^^加在mysql_select_db之前
	$tmp=mysql_select_db($mysql_dbnm, $con);//選擇資料庫
	if(mysql_error()){die(mysql_error());}else{}//讀取失敗則停止
	
	$title=gmdate("ymd",$time);
	//$tmp=mysql_query("DROP TABLE IF EXISTS `$title`",$con);
	//if(mysql_error()){die(mysql_error());}//有錯誤就停止
	//**********連結資料庫
	$sql="SHOW TABLE STATUS";
	$result = mysql_query($sql); //mysql_list_tables($dbname)
	if(mysql_error()){die(mysql_error());}//有錯誤就停止 //mysql_error()
	$cc=1;
	while ($row = mysql_fetch_row($result)) {
		if($row[0]==$title){$cc=0;};//有找到叫index的table
	}
	//isset($row[0]);
	if($cc){//建立預設的表格
		$sql=newtable($title); // 自訂函式
		$result=mysql_query($sql,$con);
		if(mysql_error()){die(mysql_error());}//有錯誤就停止
	}
	//**********連結資料庫
	$date=gmdate("Y-m-d H:i:s",$time);
	$user_ip = ($HTTP_X_FORWARDED_FOR)?$_SERVER[HTTP_X_FORWARDED_FOR]:$_SERVER[REMOTE_ADDR];
	$user_ip2 = gethostbyaddr($user_ip);
	if(isset($_SERVER['HTTP_REFERER'])){
		$user_from=$_SERVER['HTTP_REFERER'];
	}else{
		$user_from="不明";
	}
	$sql="INSERT INTO `$title` ( date, user_ip, user_ip2, user_from)
	VALUES ('$date','$user_ip','$user_ip2','$user_from')";
	$result=mysql_query($sql,$con);
	if(mysql_error()){die(mysql_error());}//有錯誤就停止
	//**********連結資料庫
	$sql = "SELECT * FROM `$title` ORDER BY `auto_time` DESC";//取得資料庫總筆數
	$result = mysql_query($sql,$con);
	if(mysql_error()){die(mysql_error());}//有錯誤就停止
	////檢查page範圍
	$max = mysql_num_rows($result);//取得資料庫總筆數
	$x[0] = "$date,$user_ip,$user_ip2,$user_from";
	$x[1] = "$max";
	$x[2] = "$title";
	return $x;
}
?> 
