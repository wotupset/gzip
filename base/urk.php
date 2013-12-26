<?php 
header('Content-type: text/html; charset=utf-8');
error_reporting(E_ALL & ~E_NOTICE); //所有錯誤中排除NOTICE提示
$phpself=basename($_SERVER["SCRIPT_FILENAME"]);//被執行的文件檔名
$phplink="http://".$_SERVER["SERVER_NAME"].$_SERVER["SCRIPT_NAME"]."";
$host=$_SERVER["SERVER_NAME"]; //主機名稱
date_default_timezone_set("Asia/Taipei");//時區設定 Etc/GMT+8
$time=time();
$mode = $_POST["mode"];
$url_org = $_POST["url_org"];
//$enc_key='123';
$enc_key = urlencode($_POST["enc_key"]);
if(!$enc_key){$enc_key=$time;}
$query_string=$_SERVER['QUERY_STRING'];


$ref_sec=5; //轉址時間
//$htmlhead
$htmlhead=<<<EOT
<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>hellcat</title>
</head><body>\n
EOT;
//$form
$form=<<<EOT
<form id='form1' action='$phpself' method="post" autocomplete="off">
<input type="hidden" name="mode" value="reg">
<input type="text" name="url_org" id="url_org" size="20" placeholder="http" value=""><br/>
<input type="text" name="enc_key" id="enc_key" size="20" placeholder="key" value="$time"><br/>
<input type="submit" value="送出"/>
</form>
EOT;

//$htmlend
$htmlend=<<<EOT
\n</body></html>
EOT;
$echo_body='';
$tmp='';
switch($mode){
	case 'reg':
		if($url_org){
			//$echo_body.="<pre>$url_org</pre>";
			$url_org=trim($url_org);//去頭尾空白
			$url_enc=passport_encrypt($url_org,$enc_key);//加密
			$url_enc='http://'.$_SERVER["SERVER_NAME"].$_SERVER["SCRIPT_NAME"].'?'.$url_enc."!".$enc_key;
			//$echo_body.="<form><input type='text' size='40' value='$url_enc'></form>";
			//$echo_body.="<pre>$url_enc2</pre>"."\n";
$echo_body.=<<<EOT
<input type="text" size="20" value="$url_enc"><br>
$url_org<br>

EOT;
			//$echo_body.="<pre>$enc_key</pre>"."\n";
			//$echo_body.="<pre>$url_enc</pre>"."\n";
			$echo_body.=$form;
			$echo_body.="<a href='./$phpself'>&#10006;BACK</a> ";
		}else{
			$echo_body.="<pre>no url</pre>";
			$echo_body.=$form;
			$echo_body.="<a href='./$phpself'>&#10006;BACK</a> ";
		}
	break;
	default:
		if($query_string){//網址有參考值
			$tmp2_arr=explode("!",$query_string);
			switch($tmp2_arr[0]){
				case 'url':
					session_id($tmp2_arr[1]); //指定sid
					session_start(); //session
					$url_dec=$_SESSION['se'];
//bbcode()
$string = $url_dec; //bbcode目前只使用連結功能
$string = preg_replace("/(^|[^=\]])(http|https)(:\/\/[\!-;\=\?-\~]+)/si", "\\1<a href=\"\\2\\3\" target='_blank'>\\2\\3</a>", $string);
$url_dec = $string;
//bbcode(/)
					$echo_body.="<div>$url_dec</div>\n";
					$echo_body.="<a href='./$phpself'>&#10006;BACK</a>"."<br/>\n";
					//session_destroy();//清空sess
					unset($_SESSION['se']);
				break;
				default:
					$tmp_arr=explode("!",$query_string);
					$query_string=$tmp_arr[0];//加密過的網址
					$enc_key=$tmp_arr[1];//解密key
					$url_dec=passport_decrypt($query_string,$enc_key);//解密
					session_start(); //session
					session_regenerate_id();
					$_SESSION['se']=$url_dec;
					if(!isset($_SESSION['se'])){die('session失敗');}
					$sid = session_id(); 
					$tmp=$phpself."?url!".$sid;
					$echo_body.="<div>wait</div>\n";
					$echo_body.="<a href='./$phpself'>&#10006;BACK</a>"."<br/>\n";
					header("refresh:1; url=$tmp");
					//$echo_body.="<pre>$enc_key</pre>"."\n";
					//$echo_body.="<pre>$query_string</pre>"."\n";
				break;
			}
		}else{//網址沒有參考值
		$echo_body.=$form;
		$echo_body.="<a href='./'>&#10006;ROOT</a>";
		}
	break;
}
echo $htmlhead;
echo $echo_body;
echo $htmlend;

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
/*
$chk_time_key='abc123';
$chk_time_enc=passport_encrypt($time,$chk_time_key);
$chk_time_dec=passport_decrypt($chk_time_enc,$chk_time_key);
echo $time.' '.$chk_time_enc.' '.$chk_time_dec;
*/
?> 
