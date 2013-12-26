<?php 
//*****************
header('Content-type: text/html; charset=utf-8');
error_reporting(E_ALL & ~E_NOTICE); //所有錯誤中排除NOTICE提示
extract($_POST,EXTR_SKIP);
extract($_GET,EXTR_SKIP);
extract($_COOKIE,EXTR_SKIP);
$phpself=basename($_SERVER["SCRIPT_FILENAME"]);//被執行的文件檔名
$GLOBALS['time'] = time()+8*60*60;//UNIX時間時區設定
$GLOBALS['date_ym']=date("ym", $GLOBALS['time']);//年月

$time_start = microtime(true);
$query_string=$_SERVER['QUERY_STRING'];

//*****************
$htmlhead=<<<EOT
<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<META http-equiv="Content-Script-Type" content="text/javascript">
<META http-equiv="Content-Style-Type" content="text/css">
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
	exdate.setDate(exdate.getDate()+expiredays)
	document.cookie=c_name+ "=" +escape(value)+
	((expiredays==null) ? "" : ";expires="+exdate.toGMTString())
}
</script>
</head><body>
cookie=<span id='hashtag'></span><br/>
javascript=<span id='hashtag2'></span><br/>
<a href="./$phpself?2013-11-20_163212_cr.jpg">hashpic</a>
<a href="./hta/">hta</a>
<a href="./index.php">index</a>
<a href="./log.log">log.log</a>
<a href="./log_ct.log">log_ct.log</a>
<br/>
<a href="#aaa">aaa</a>
<a href="#bbb">bbb</a>
<a href="#ccc">ccc</a>
<a href="#hash_a">hash_a</a>
<br/>

EOT;
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
if($cc){}else{die("dir miss");}
if($cc>1){die("dir multi");}
closedir($handle); 

//**************
/*
$dir_mth="./".date("ym", $time)."/";//年月
if(!is_writeable(realpath("./"))){ die("根目錄沒有寫入權限，請修改權限"); }
mkdir($dir_mth, 0777); //建立資料夾 權限0777
chmod($dir_mth, 0777); //權限0777
if(!is_dir(realpath($dir_mth))){die("子資料夾不存在");}
if(!is_writeable(realpath($dir_mth))){die("子資料夾無法寫入");}
if(!is_readable(realpath($dir_mth))){die("子資料夾無法讀取");}
//檢查子資料夾是否存在
if(is_dir($dir_mth)){//子資料夾存在
	if(is_file("inde.php")){//如果根目錄有inde.php檔案
		if(!is_file($dir_mth."index.php")){//如果該月目錄沒有index檔案
			$chk=@copy("inde.php", $dir_mth."index.php");//複製檔案到該月目錄
			if(!$chk){die('複製檔案失敗');}
		}
	}else{//根目錄有index檔案
		die('index檔案遺失');
	}
}else{//子資料夾不存在
	die("子資料夾不存在");
}
*/
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
		$rec_x = rec($GLOBALS['date_ym']); //紀錄來源 //回傳紀錄檔行數
	}
	//**************

	$tmp_size=filesize($file_name);//檔案大小
	$tmp_f_ext=substr($file_name,-3); //副檔名
	foreach($mimetypes as $k => $v){
		if($tmp_f_ext == $k){ //符合的副檔名
			ob_start();
			header("Content-type: $v;");
			//header('Content-type:application/force-download');
			header("Content-Transfer-Encoding: Binary"); //編碼方式
			header("Cache-Control: cache, must-revalidate");
			header('Content-Length:'.$tmp_size);
			//$tmp_fn_out=$tmp.'_'.substr(md5_file($file_name),0,5);//輸出的檔名
			//$tmp="Content-Disposition: attachment; filename=\"build-$tmp_fn_out.$k\"";
			//header($tmp);
			readfile($file_name); //讀取圖片
			ob_flush();
			exit;
		}
	}
}else{
	$htmlbody=''; $tmp='';
	$string="臣亮言：先帝創業未半，而中道崩殂。
	今天下三分，益州疲弊，此誠危急之秋也。
	然侍衛之臣，不懈於內﹔忠志之士，忘身於外者，蓋追先帝之殊遇，欲報之於陛下也。
	誠宜開張聖聽，以光先帝遺德，恢弘志士之氣；
	不宜妄自菲薄，引喻失義，以塞忠諫之路也。";
	//mb_internal_encoding("UTF-8");
	$htmlbody.= mb_substr($string,0,13,"utf-8")."<br/>\n";
	//$tmp_s=$_SERVER['REMOTE_ADDR'];//ip
	//$htmlbody.= "$tmp_s<br/>\n";
	//$tmp_s=gethostbyaddr($_SERVER["REMOTE_ADDR"]);//ip2
	//$htmlbody.= "$tmp_s<br/>\n";
	//$tmp_s=$_SERVER['HTTP_REFERER'];//來自
	//$htmlbody.= "$tmp_s<br/>\n";
	if($query_string){
		$htmlbody.= "找不到檔案<br/>\n";
	}
	$tmp_s=$_COOKIE['hashtag'];
	$htmlbody.= "$tmp_s<br/>\n";
	$rec_x_0=$rec_x[0];
	$rec_x_1=$rec_x[1];
	$rec_x_2=$rec_x[2];
	$rec_x_3=$rec_x[3];
	$tmp_s="$rec_x_0 rows $rec_x_2 times<br/>";
	$htmlbody.= "$tmp_s<a href='../'>../</a>"."<br/>\n";
	//$htmlbody.="<pre>".$rec_x_1."</pre>"; //檔案A的fstat
	//$htmlbody.="<pre>".$rec_x_3."</pre>"; //檔案A的fstat
	$time_end = microtime(true);
	$time_runs = $time_end - $time_start;
	$time_runs ="執行=$time_runs<br/>\n";//php執行時間
	echo $htmlhead;
	echo $time_runs; //php執行時間
	echo $htmlbody;
	echo $htmlend;
}

//**************
//**************
function rec($x){
	$logfile="./index_log_".$x.".log";
	$tmp_f_ct=0;
	//****************
	if(is_file($logfile)){//檔案存在就載入紀錄
		if(!is_writeable(realpath($logfile))){die("檔案無法寫入");}
		if(!is_readable(realpath($logfile))){die("檔案無法讀取");}
		$tmp_f_cnt=file_get_contents($logfile);//載入紀錄
		//$tmp_f_cnt=trim($tmp_f_cnt);
	}else{
		//檔案不存在
		//$tmp=tempnam("./","tmp_");
		//unlink($tmp);
		$tmp_f_cnt="";//給空的紀錄
		if(!is_writeable(realpath('./'))){die("所在目錄無法寫入");} //檢查根目錄權限
		$cp = fopen($logfile, "a+");//建立空的紀錄檔
		fclose($cp);
	}
	//****************
	/*
	if(function_exists('gzinflate') && function_exists('gzdeflate')){//是否支援壓縮
		if($tmp_f_cnt){$tmp_f_cnt=gzinflate(base64_decode($tmp_f_cnt));}
	}
	*/
	//****************
	$tmp_f_cnt_arr=explode("\n",$tmp_f_cnt);
	//$tmp_f_ct=count($tmp_f_cnt_arr);//計算行數
	//$tmp_f_ext=substr($logfile,-3); //副檔名
	
	$input_data='';
	$host = ($HTTP_X_FORWARDED_FOR)?$_SERVER[HTTP_X_FORWARDED_FOR]:$_SERVER[REMOTE_ADDR];
	$hostname = gethostbyaddr($host);
	//$tmp_s=gethostbyname(gethostbyaddr($_SERVER["REMOTE_ADDR"]));
	$user_ip=$host."\t".$hostname;
	if(isset($_SERVER['HTTP_REFERER'])){
		$user_from=$_SERVER['HTTP_REFERER'];
		//$user_from=urlencode($user_from);
	}else{
		$user_from="不明";
	}
	$time=$GLOBALS['time'];
	$date=gmdate("Y-m-d H:i:s",$time);
	//****************
	$input_data.="$date\t$user_ip\t$user_from\n$tmp_f_cnt"; //加入新資料
	$input_data=explode("\n",$input_data);
	array_splice($input_data,300);//移除陣列第15項之後的部份
	$tmp_f_ct=count($tmp_f_cnt_arr);//計算行數
	$input_data=implode("\n",$input_data);
	//****************
	/*
	$len_before=strlen($input_data);//加密前的長度
	if(function_exists('gzinflate') && function_exists('gzdeflate')){//是否支援壓縮
		$input_data=base64_encode(gzdeflate($input_data));//加密
		$input_data=chunk_split($input_data,77,"\n");
	}
	$len_after=strlen($input_data);//加密前的長度
	*/
	//****************
	$cp = fopen($logfile, "a+") or die('die#fopen');// 讀寫模式, 指標於最後, 找不到會嘗試建立檔案
	flock($cp, LOCK_EX);
	//rewind($cp); //從頭讀取
	//$buf=fread($cp,1000000); //讀取至暫存
	ftruncate($cp, 0); //砍資料至0
	fputs($cp, $input_data);
	fclose($cp);//關閉檔案要求
	//**************
	$logfile2="./log_ct.log";
	if(is_file($logfile2)){//檔案存在就載入紀錄
		$tmp_f_cnt=file_get_contents($logfile2);//載入紀錄
	}else{//不存在 = 建立新檔案
		$tmp_f_cnt="";//給空資料
		if(!is_writeable(realpath('./'))){die("所在目錄無法寫入");} //檢查根目錄權限
		$cp = fopen($logfile2, "a+");//建立空的紀錄檔
		fclose($cp);
	}
	$tmp_f_cnt=trim($tmp_f_cnt);//清理尾巴
	$tmp_f_cnt_arr=explode("\n",$tmp_f_cnt);//解析成陣列
	$date=gmdate("ymd",$time);
	if($tmp_f_cnt){//內容有資料
		$arr_0=explode(",",$tmp_f_cnt_arr[0]);//第一行解析成陣列
		$arr_0_0=$arr_0[0]; //時間 天
		$arr_0_1=$arr_0[1]; //瀏覽人數
		if($date==$arr_0_0){//若第一排第一個等於現在的時間
			$cc=$cc+1;//有找到
			$arr_0_1=$arr_0_1 + 1; //瀏覽人數+1
			$arr_0="$arr_0_0,$arr_0_1";
			$tmp_f_cnt_arr[0]=$arr_0;//更新第一行資料
			//array_unshift($tmp_f_cnt_arr,$arr_0);//字串插入到陣列開頭
			$tmp_f_ct2=$arr_0_1; //return用
		}else{//沒有相符的
			$arr_0="$date,1";//新的紀錄 從1開始
			array_unshift($tmp_f_cnt_arr,$arr_0);//字串插入到陣列開頭
			$tmp_f_ct2="1";//return用
		}
	}else{//紀錄檔如果是空的 就自行產生第一筆資料
		$arr_0="$date,1";//新的紀錄 從1開始
		array_unshift($tmp_f_cnt_arr,$arr_0);//字串插入到陣列開頭
		$tmp_f_ct2="1";
	}
	$tmp_f_cnt=implode("\n",$tmp_f_cnt_arr);//擺回去
	$cp = fopen($logfile2, "a+") or die('die#fopen2');// 讀寫模式, 指標於最後, 找不到會嘗試建立檔案
	flock($cp, LOCK_EX);
	ftruncate($cp, 0); //砍資料至0
	fputs($cp, $tmp_f_cnt);
	fclose($cp);//關閉檔案要求
	//**************
	$fstat_arr=print_r(lstat($logfile),true);
	$fstat_arr2=print_r(lstat($logfile2),true);
	$x[0]=$tmp_f_ct;
	$x[1]=$fstat_arr;
	$x[2]=$tmp_f_ct2;
	$x[3]=$fstat_arr2;
	//**************
	return $x;
}
?> 
