<?php 
$phpself=basename($_SERVER["SCRIPT_FILENAME"]);//被執行的文件檔名
$phphost=$_SERVER["SERVER_NAME"];
$query_string=$_SERVER['QUERY_STRING'];
date_default_timezone_set("Asia/Taipei");
$GLOBALS['time'] = time();//UNIX時間時區設定
$GLOBALS['date_ym']=date("ym", $GLOBALS['time']);//年月
//rec($GLOBALS['date_ym']);//
switch($query_string){
	case 'png':
		Header("Content-type: image/png");//指定文件類型為PNG
		$moji=gmdate("ymd",filemtime($phpself)+8*60*60);
		//$moji=$moji."".$filesize;
		$moji=sprintf("%06d",$moji);
		$img = imageCreate(90,15);
		$black =imageColorAllocate($img, 0, 255, 0);
		$white = imageColorAllocate($img, 255, 255, 255);
		imageFill($img, 0, 0, $white);
		imagestring($img,5,0,0, $moji, $black);
		imagePng($img);
		imageDestroy($img);
	break;
	default:
	break;
}

function rec($x){
	$logfile="./png_".$x.".log";
	$tmp_f_ct=0;
	//****************
	if(is_file($logfile)){//檔案存在就載入紀錄
		if(!is_writeable(realpath($logfile))){die("檔案無法寫入");}
		if(!is_readable(realpath($logfile))){die("檔案無法讀取");}
		$tmp_f_cnt=file_get_contents($logfile);//載入紀錄
		$tmp_f_cnt=trim($tmp_f_cnt);
	}else{
		//檔案不存在
		//$tmp=tempnam("./","tmp_");
		//unlink($tmp);
		$tmp_f_cnt="";//給空的紀錄
		if(!is_writeable(realpath('./'))){die("所在目錄無法寫入");} //檢查根目錄權限
		$cp = fopen($logfile, "a+");//建立空的紀錄檔
		fclose($cp);
	}

	$tmp_f_cnt_arr=explode("\n",$tmp_f_cnt);
	//$tmp_f_ct=count($tmp_f_cnt_arr);//計算行數
	//$tmp_f_ext=substr($logfile,-3); //副檔名
	

	$host = ($HTTP_X_FORWARDED_FOR)?$_SERVER[HTTP_X_FORWARDED_FOR]:$_SERVER[REMOTE_ADDR];
	$hostname = gethostbyaddr($host);
	//$tmp_s=gethostbyname(gethostbyaddr($_SERVER["REMOTE_ADDR"]));
	$user_ip=$host."<>".$hostname;
	if(isset($_SERVER['HTTP_REFERER'])){
		$user_from=$_SERVER['HTTP_REFERER'];
		//$user_from=urlencode($user_from);
	}else{
		$user_from="不明";
	}
	$date=gmdate("Y-m-d H:i:s",$GLOBALS['time']);
	//****************
	$input_data='';
	$input_data="$date\t$user_ip\t$user_from\n$tmp_f_cnt"; //加入新資料


	$cp = fopen($logfile, "a+") or die('die#fopen');// 讀寫模式, 指標於最後, 找不到會嘗試建立檔案
	flock($cp, LOCK_EX);
	//rewind($cp); //從頭讀取
	//$buf=fread($cp,1000000); //讀取至暫存
	ftruncate($cp, 0); //砍資料至0
	fputs($cp, $input_data);//寫入
	fclose($cp);//關閉檔案要求
	//**************
	$x=1;
	return $x;
}
?> 
