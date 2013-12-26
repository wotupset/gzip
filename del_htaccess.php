<?php
header('Content-type: text/html; charset=utf-8');
//跟txtsavelog.php放在一起
$time = time();
$tim = $timex.substr(microtime(),2,3);

$u = "http://".$_SERVER["SERVER_NAME"]."".$_SERVER["PHP_SELF"]."";
//echo $u."\n";
$url2=substr($u,0,strrpos($u,"/")+1);
//echo $url2."\n\n";

$output=array();
$reg_filename="/.htaccess$/";
$reg_dirname="/.*/";//"/.*[0-9]{4}.*/"
$matches_unique[1] = array('.');

////////根目錄(1)////////於根目錄理論上只會收錄資料夾名稱
$matches_unique[2] = array();
foreach($matches_unique[1] as $val){
	$tmparr = array();//清空暫存陣列
	$url=''.$val.'/';//要檢查的資料夾
	//echo "檢查".$url."\n";
	$handle=opendir($url); 
	$cc = 0;
	while (($file = readdir($handle))!==false) { //遍歷該資料夾
		//echo $file."\n";
		if($file != "." && $file != "..") { 
			$tmparr[$cc] = $url.$file; 
			//echo $tmparr[$cc]."\n";
			if(is_dir($tmparr[$cc])){//如果是資料夾
				if(preg_match($reg_dirname,$tmparr[$cc])){ //
					if(!in_array($tmparr[$cc], $matches_unique[2])) {
						array_push($matches_unique[2], $tmparr[$cc]); //抽出dir名稱到陣列2
						//echo "根".$tmparr[$cc]."\n";
						//echo "陣列2\n";
					}
					//echo $tmparr[$cc];
				}
				//echo $tmparr[$cc];
			}
			if(is_file($tmparr[$cc])){//如果是檔案
				//echo $tmparr[$cc]."\n";
				if(preg_match($reg_filename,$tmparr[$cc])){ //同目錄底下的網頁
					$tmp=$tmparr[$cc];
					$tmp=str_replace('/./','/',$tmp);
					array_push($output, $tmp);//將網址存進陣列
					//echo "根".$tmparr[$cc]."\n";
					//echo "檔案\n";
				}
			}
		} 
		$cc = $cc + 1;
	} 
	closedir($handle); 
}
////////根目錄(1)////////*
//echo "wwww";
////////根目錄(2)////////向下一層
$matches_unique[3] = array();
foreach($matches_unique[2] as $val){
	$tmparr = array();//清空暫存陣列
	$url=''.$val.'/';//要檢查的資料夾
	//echo "檢查".$url."\n";
	$handle=opendir($url); 
	$cc = 0;
	while (($file = readdir($handle))!==false) { //遍歷該資料夾
		//echo $file."\n";
		if($file != "." && $file != "..") { 
			$tmparr[$cc] = $url.$file; 
			//echo $tmparr[$cc]."\n";
			if(is_dir($tmparr[$cc])){//如果是資料夾
				if(preg_match($reg_dirname,$tmparr[$cc])){ //
					if(!in_array($tmparr[$cc], $matches_unique[3])) {
						array_push($matches_unique[3], $tmparr[$cc]); //抽出dir名稱到陣列3
						//echo "根".$tmparr[$cc]."\n";
						//echo "陣列3\n";
					}
					//echo $tmparr[$cc];
				}
				//echo $tmparr[$cc];
			}
			if(is_file($tmparr[$cc])){//如果是檔案
				//echo $tmparr[$cc]."\n";
				if(preg_match($reg_filename,$tmparr[$cc])){ //同目錄底下的網頁
					$tmp=$tmparr[$cc];
					$tmp=str_replace('/./','/',$tmp);
					array_push($output, $tmp);//將網址存進陣列
					//echo "根".$tmparr[$cc]."\n";
					//echo "檔案\n";
				}
			}
		} 
		$cc = $cc + 1;
	} 
	closedir($handle); 
}
////////根目錄(2)////////*
//echo "wwww";
////////根目錄(3)////////向下兩層
$matches_unique[4] = array();
foreach($matches_unique[3] as $val){
	$tmparr = array();//清空暫存陣列
	$url=''.$val.'/';//要檢查的資料夾
	//echo "檢查".$url."\n";
	$handle=opendir($url); 
	$cc = 0;
	while (($file = readdir($handle))!==false) { //遍歷該資料夾
		//echo $file."\n";
		if($file != "." && $file != "..") { 
			$tmparr[$cc] = $url.$file; 
			//echo $tmparr[$cc]."\n";
			if(is_dir($tmparr[$cc])){//如果是資料夾
				if(preg_match($reg_dirname,$tmparr[$cc])){ //
					if(!in_array($tmparr[$cc], $matches_unique[4])) {
						array_push($matches_unique[4], $tmparr[$cc]); //抽出dir名稱到陣列4
						//echo "根".$tmparr[$cc]."\n";
						//echo "陣列3\n";
					}
					//echo $tmparr[$cc];
				}
				//echo $tmparr[$cc];
			}
			if(is_file($tmparr[$cc])){//如果是檔案
				//echo $tmparr[$cc]."\n";
				if(preg_match($reg_filename,$tmparr[$cc])){ //同目錄底下的網頁
					$tmp=$tmparr[$cc];
					$tmp=str_replace('/./','/',$tmp);
					array_push($output, $tmp);//將網址存進陣列
					//echo "根".$tmparr[$cc]."\n";
					//echo "檔案\n";
				}
			}
		} 
		$cc = $cc + 1;
	} 
	closedir($handle); 
}
////////根目錄(3)////////*
//echo "wwww";
////////根目錄(4)////////向下三層
$matches_unique[5] = array();
foreach($matches_unique[4] as $val){
	$tmparr = array();//清空暫存陣列
	$url=''.$val.'/';//要檢查的資料夾
	//echo "檢查".$url."\n";
	$handle=opendir($url); 
	$cc = 0;
	while (($file = readdir($handle))!==false) { //遍歷該資料夾
		//echo $file."\n";
		if($file != "." && $file != "..") { 
			$tmparr[$cc] = $url.$file; 
			//echo $tmparr[$cc]."\n";
			if(is_dir($tmparr[$cc])){//如果是資料夾
				if(preg_match($reg_dirname,$tmparr[$cc])){ //
					if(!in_array($tmparr[$cc], $matches_unique[5])) {
						array_push($matches_unique[5], $tmparr[$cc]); //抽出dir名稱到陣列5
						//echo "根".$tmparr[$cc]."\n";
						//echo "陣列3\n";
					}
					//echo $tmparr[$cc];
				}
				//echo $tmparr[$cc];
			}
			if(is_file($tmparr[$cc])){//如果是檔案
				//echo $tmparr[$cc]."\n";
				if(preg_match($reg_filename,$tmparr[$cc])){ //同目錄底下的網頁
					$tmp=$tmparr[$cc];
					$tmp=str_replace('/./','/',$tmp);
					array_push($output, $tmp); //將網址存進陣列
					//echo "根".$tmparr[$cc]."\n";
					//echo "檔案\n";
				}
			}
		} 
		$cc = $cc + 1;
	} 
	closedir($handle); 
}
////////根目錄(3)////////*
//echo "wwww";
rsort($output);//新的在前 
ob_start();
//$tmp_s=print_r($output,true);
echo "<pre>\n";
foreach($output as $k => $v){
	echo "$v";
	$chk=unlink($v);
	if($chk){echo "刪除成功\n";}else{echo "失敗\n";}
}
echo "</pre>\n";
$eot= <<<EOT
EOT;
$echo_body=ob_get_contents();//輸出擷取到的echo
ob_end_clean();//清空擷取到的內容
//mb_internal_encoding("UTF-8");
//$htmlbody.=mb_substr($string,0,13,"utf-8");
//$utf8_pack=pack("CCC", 0xef,0xbb,0xbf);//UTF8檔頭
//**************
$htmlhead=<<<EOT
<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>del7z</title>
<style>
body {font-family:'細明體','MingLiU';}
</style>
</head><body>
EOT;
//**************
$htmlend=<<<EOT
</body></html>
EOT;
echo $htmlhead;
echo $echo_body;
echo $htmlend;
?>