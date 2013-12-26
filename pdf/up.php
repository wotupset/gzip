<?php
header('Content-type: text/html; charset=utf-8');
$phpself=basename($_SERVER["SCRIPT_FILENAME"]);//被執行的文件檔名
error_reporting(E_ALL & ~E_NOTICE); //所有錯誤中排除NOTICE提示
extract($_POST,EXTR_SKIP);
extract($_GET,EXTR_SKIP);
extract($_COOKIE,EXTR_SKIP);
date_default_timezone_set("Asia/Taipei");//時區設定
$time=time()+8*60*60;//UNIX時間時區設定
$uid2=uniqid(chr(rand(97,122)),true);//建立唯一ID
session_start(); //session
setcookie("cookie_pw", $xi,$time+7*24*3600); //存入原始的密碼 7天過期
$cookie_pw=$_COOKIE["cookie_pw"];
$password="qqq";

$htmlhead=<<<EOT
<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>kingfisher</title>
</head><body>
$cookie_pw<br/>

EOT;
$htmlend=<<<EOT
\n</body></html>\n
EOT;
$htmlbody='';
$tmp='';
$tmp.=ini_get('upload_max_filesize');
//ini_set('upload_max_filesize', '10M');
//$tmp=$tmp."->".ini_get('upload_max_filesize');
$form=<<<EOT
<form action="$phpself" method="post" enctype="multipart/form-data">
<input type="hidden" name="mode" value="reg">
<input type="hidden" name="uid" value="$uid2">
<input type="hidden" name="max_file_size" value="102400000">
<input type="file" name="myfile">
<input type="submit" value="上傳">$tmp
<br/>
<input type="text" id="xi" name="xi" maxlength="20" size="10" value="$cookie_pw" placeholder="find"/>
</form>
EOT;
$htmlbody.=$form;
$htmlbody.='a='.$_SESSION['uid'].' b='.$uid.'<br/>';
if(!is_writeable(realpath("./"))){ die("根目錄沒有寫入權限，請修改權限"); }
switch($mode){
	case 'reg':
		//
		if($_POST['xi']!=$password){die("die");}
		if($uid==$_SESSION['uid']){die("<a href='$phpself'>$phpself</a>");}
		$_SESSION['uid']=$uid;
		//
		$dir_mth="./_".gmdate("ym",$time)."/"; //存放該月檔案
		@mkdir($dir_mth, 0777); //建立資料夾 權限0777
		@chmod($dir_mth, 0777); //權限0777
		if(!is_dir(realpath($dir_mth))){die("月份資料夾不存在");}
		if(!is_writeable(realpath($dir_mth))){die("月份資料夾無法寫入");}
		if(!is_readable(realpath($dir_mth))){die("月份資料夾無法讀取");}

		if(!is_dir($dir_mth)){//子資料夾不存在
			//
		}else{//子資料夾存在.
			if(!is_file("index.php")){//如果根目錄沒有index檔案
				die('index檔案遺失');
			}else{//根目錄有index檔案
				if(!is_file($dir_mth."index.php")){//如果該月目錄沒有index檔案
					$chk=@copy("index.php", $dir_mth."index.php");//複製檔案到該月目錄
					if(!$chk){die('複製檔案失敗');}
				}
			}
		}

		$uploaddir = "".$dir_mth."";
		$time_x="".gmdate("d_His_",$time).""; //檔案前輟
		$tmp=$_FILES['myfile']['name'];//檔案名
		$len = strlen($tmp);
		$cc=0;
		for($i = 0; $i < $len; $i++){
			$char = substr($tmp, $i, 1); //函数返回字符串的一部分
			if(ord($char) > 127){//非字母
				$arr[$cc]= substr($tmp, $i, 3); //前3字元 函数返回字符串的一部分
				$arr[$cc]="_";
				$i=$i+2;
			}else{
				$arr[$cc]= substr($tmp, $i, 1); //前1字元 函数返回字符串的一部分
			}
			$cc=$cc+1;
			echo $arr[$cc];
		}
		$tmp=implode("",$arr);
		
		$uploadfile = $uploaddir.$time_x.$tmp; //上傳的位置與檔名
		$tmp=0;
		if(preg_match("/.php$/i", $uploadfile)){$uploadfile=$uploadfile.".txt";$tmp=1;}//副檔名若為php
		if(preg_match("/.htm$/i", $uploadfile)){$uploadfile=$uploadfile.".txt";}//副檔名若為htm

		$htmlbody.="<pre>";
		//if (move_uploaded_file($_FILES['myfile']['tmp_name'], iconv("utf-8", "big5", $uploadfile))) {
		$file_size=$_FILES['myfile']['size'];
		$file_size=floor($file_size/1024);
		if (move_uploaded_file($_FILES['myfile']['tmp_name'], $uploadfile)) {
		    $htmlbody.= "Upload OK ($file_size K)\n";
		} else {
		    $htmlbody.= "Upload failed \n";
		}
		if($tmp == 1){chmod($uploadfile,0644);}
		$htmlbody.=print_r($_FILES,true);
		$htmlbody.= "<a href='$uploadfile'>$uploadfile</a>";
		$htmlbody.= "</pre>";
	break;
	default:
	break;
}
$htmlbody.="<a href='./'>ROOT</a> <a href='./$phpself'>BACK</a>";
echo $htmlhead;
echo $htmlbody;
echo $htmlend;



////
function strcvr($str){
	$len = strlen($str);
	for($i = 0; $i < $len; $i++){
		$char = $str{0};
		if(ord($char) > 127){
			$i++;
			if($i < $len){
				//$arr[] = substr($str, 0, 3);//取0~3字元的字串到陣列
				$arr[] = "_";//取0~3字元的字串到陣列
				$str = substr($str, 3); //取3字元之後的字串
			}
		}else{
			$arr[] = $char;
			$str = substr($str, 1);
		}
	}
	$str=join($arr); //array_reverse?
	return $str;
}
////

function passport_encrypt($txt, $key) {
	srand((double)microtime() * 1000000);
	$encrypt_key = md5(rand(0, 32000));
	$ctr = 0;
	$tmp = '';
	for($i = 0; $i < strlen($txt); $i++) {
		$ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
		$tmp .= $encrypt_key[$ctr].($txt[$i] ^ $encrypt_key[$ctr++]);
	}
	return base64_encode(passport_key($tmp, $key));
}
function passport_decrypt($txt, $key) {
	$txt = passport_key(base64_decode($txt), $key);
	$tmp = '';
	for ($i = 0; $i < strlen($txt); $i++) {
		$tmp .= $txt[$i] ^ $txt[++$i];
	}
	return $tmp;
}
function passport_key($txt, $encrypt_key) {
	$encrypt_key = md5($encrypt_key);
	$ctr = 0;
	$tmp = '';
	for($i = 0; $i < strlen($txt); $i++) {
		$ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
		$tmp .= $txt[$i] ^ $encrypt_key[$ctr++];
	}
	return $tmp;
}
function passport_encode($array) {
	$arrayenc = array();
	foreach($array as $key => $val) {
		$arrayenc[] = $key.'='.urlencode($val);
	}
	return implode('&', $arrayenc);
}
////

?>