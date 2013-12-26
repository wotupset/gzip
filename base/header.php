<?php
header("content-Type: text/html; charset=utf-8"); //語言強制
require './header_c.php';//$time

$tmp=0;
if(isset($_SERVER['HTTP_REFERER'])){ //確認來源網址
	$user_from=$_SERVER['HTTP_REFERER'];
	$tmp=1;
}else{
	$user_from="不明";
}
if(!$tmp){die("無法取得來源網址");}

echo htmlhead();
echo "尋找網址: ".$user_from;
echo "<br/>\n";
echo "<br/>\n";
if(preg_match("/404.html$/",$user_from)){}else{} //找不到來源就中止
//rec($GLOBALS['date_ym']);//
switch($query_string){
	case 'url':
		echo "修補程式: ".$phpself;
		echo "<br/>\n";
		$matches = array();
		$pattern = '%^((?P<protocol>[^:/?#]+):)?(//(?P<host>[^/?#]*))?(?P<path>[^?#]*)(\?(?P<query>[^#]*))?(#(?P<label>.*))?%i';
		$subject = $user_from; //來源網址
		preg_match($pattern,$subject,$matchs);
		//可取用的資料如下
		/*
		echo 'protocol = '  .$matchs['protocol']. '<br />';
		echo 'host = '      .$matchs['host'    ]. '<br />';
		echo 'path = '      .$matchs['path'    ]. '<br />';
		echo 'query = '     .$matchs['query'   ]. '<br />';
		echo 'label = '     .$matchs['label'   ]. '<br />';
		*/
		$new_host=$matchs['host'    ];
		//$new_host="zx2013-12.wotupset.ok8.in";
		if($matchs['query'   ]){$tmp_query="?".$matchs['query'   ];}else{$tmp_query="";}
		if($matchs['label'   ]){$tmp_label="#".$matchs['label'   ];}else{$tmp_label="";}
		$phppath2 = $matchs['path'    ];
		$phppath2 = preg_replace("%^\/(txtsavelog)\/%i", "/tsl/", $phppath2);
		$phppath2 = preg_replace("%^\/_([0-9]{4})\/%i", "/tsl/", $phppath2);
		$phppath2 = preg_replace("%^\/([0-9]{4})\/%i", "/tsl/", $phppath2);
		echo "原始路徑: ".$matchs['path'    ];
		echo "<br/>\n";
		echo "類似的檔案: ".$phppath2;
		echo "<br/>\n";
		$tmp="";
		//$tmp="/zx2013-12";
		$phppath_dir = ".".$tmp.$phppath2; //要檢查的位置
		if(file_exists($phppath_dir)){
			echo "檔案存在";
			echo "<br/>\n";
			$new_url=$matchs['protocol']."://".$new_host."".$phppath2.$tmp_query.$tmp_label;
			echo "<a href='".$new_url."'>前往新的網址</a>";
		}else{
			echo "檔案不存在";
		}
	break;
	default:
		ob_start();
		echo "不能直接使用這個檔案";
		$out2 = ob_get_contents();
		ob_end_clean();
		echo $out2;
	break;
}
echo htmlend();
//********
exit;
//********
function htmlhead(){
$x=<<<EOT
<html><head>
<title>http error</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<META http-equiv="Content-Script-Type" content="text/javascript">
<META http-equiv="Content-Style-Type" content="text/css">
<meta name="Robots" content="noindex,follow">
<STYLE TYPE="text/css"><!--
body { font-family:"細明體",'MingLiU'; }
--></STYLE>
</head>
<body bgcolor="#FFFFEE" text="#800000" link="#0000EE" vlink="#0000EE">
EOT;
$x="\n".$x."\n";
return $x;
}
function htmlend(){
$x=<<<EOT
</body></html>
EOT;
$x="\n".$x."\n";
return $x;
}
?>
