<?php
header('Content-type: text/html; charset=utf-8');
$phpself=basename($_SERVER["SCRIPT_FILENAME"]);//被執行的文件檔名
$phphost=$_SERVER["SERVER_NAME"];
$query_string=$_SERVER['QUERY_STRING'];
$q_str=explode("!",$query_string);
$q_str_0=$q_str[0];
$q_str_1=$q_str[1];


//****************
$httphead = <<<EOT
<html><head>
<title>$phphost</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<META http-equiv="Content-Script-Type" content="text/javascript">
<META http-equiv="Content-Style-Type" content="text/css">
<meta name="Robots" contect="noindex,follow">
<STYLE TYPE="text/css"><!--
body { font-family:"細明體",'MingLiU'; }
A:hover  {color:#000080;background-color:#fafad2;text-decoration:none;}
--></STYLE>
</head>
<body bgcolor="#FFFFEE" text="#800000" link="#0000EE" vlink="#0000EE">
EOT;
//****************
$httpend = <<<EOT

</body></html>
EOT;
//****************
$httpbody="";
//****************
$cell = <<<EOT
mirror.s601.xrea.com
wotupset.intl.uk.to
gif87a.freeoda.com
#test-131221
nyan.0zed.com
tw130511.0zed.com
#test-131217 dns測試
lucida.twbbs.org
dummy.oo3.co
#test-131210
dummy.whostii.com
dummy.me.pn
#test-131209
wotupset.er-webs.com
dummy.0fees.net
#etc
wotupset.hostami.me
dummy.helloweb.org
#http://members.000webhost.com/ maillaa@miau.p.ht
mascot.comze.com
mascot.net84.net
yeena.hostei.com
#http://members.000webhost.com/ wot.u@g.c
alicemadder.comoj.com
#freewebhostingarea.com
kingyo.coolpage.biz
klf4.noads.biz
wotupset.6te.net
wotupset.eu5.org
wotupset.ueuo.com
#fx-preview
hahauccu.medianewsonline.com
meow.mygamesonline.org
snowmiku.getenjoyment.net
wotupset.atwebpages.com
wotupset.co.nf
#http://cpanel.foreverhost.us/
kaga.ugi.cc
taiwan101.foreverhost.us
meow.odca.net
#http://cpanel.hostinger.my/
backoff.url.ph
catbug.esy.es
firefly.zz.mu
kdao.besaba.com
kdao.meximas.com
klf4.bl.ee
klf4.96.lt
miau.hol.es
miau.w.pw
#http://cpanel.neq3.com/ 
taiwan101.neq3.com
kingfisher.uco.im
#u-series
estinto.aiyzx.com
estinto.liqu.in
taiwan101.x50x.net
tw130511.redroyal.in
wotupset.loomhost.com
#zymic.com
wotupset.99k.org
taiwan101.zxq.net
#http://cpanel.gongzuo.in/
tw130511.gongzuo.in
myucel.44c.pw
#http://cpanel.ok8.in/
miau.22c.pw
wotupset.ok8.in
#http://cpanel.qiuzhi.in
main9.66c.pw
#http://cpanel.ziyou.in/
hot-nyan.cu.cc

EOT;
//****************
ob_start();
if(function_exists("hash_file")){$hash_file=hash_file("crc32","./index.php");}else{$hash_file="x";}
echo $hash_file."<br/>\n";
if(function_exists("md5_file")){$md5_file=md5_file("./index.php");}else{$md5_file="x";}
echo $md5_file."<br/>\n";
if(function_exists("filesize")){$filesize=filesize("./index.php");}else{$filesize="x";}
echo $filesize."<br/>\n";
$out1 = ob_get_contents();
ob_end_clean(); 
if($md5_file=="aaa91d8777f34f438c6192beae092545"){$cr_chk1="0";$cr_chk2="225";}else{$cr_chk1="255";$cr_chk2="0";}//檢查index.php大小
//****************
switch($q_str_0){//switch
	case 'png':
Header("Content-type: image/png");//指定文件類型為PNG
$moji=gmdate("ymd",filemtime($phpself)+8*60*60);
//$moji=$moji."".$filesize;
$moji=sprintf("%06d",$moji);
$img = imageCreate(90,15);
$black =imageColorAllocate($img, $cr_chk1, 0, $cr_chk2);
$white = imageColorAllocate($img, 255, 255, 255);
imageFill($img, 0, 0, $white);
imagestring($img,5,0,0, $moji, $black);
imagePng($img);
imageDestroy($img);
	break;
	case 'a':
header("content-Type: text/html; charset=utf-8"); //指定文件類型為UTF8
$cell = preg_replace("/\r\n/","\r",$cell);
$cell = preg_replace("/\r/","\n",$cell);
$cellarr=explode("\n",$cell);

foreach($cellarr as $key => $value){
	if(strlen($cellarr[$key])==0){
		unset($cellarr[$key]);//空的陣列捨去
		//$cellarr[$i]=$cellarr[$i]."+";
	}else{//非零
		if(preg_match('/^\#/', $cellarr[$key] )){ //開頭是井字號 視為註解
			$httpbody.="<span style='color:#00ff00;'>".$cellarr[$key]."</span><br/>\n";
		}else{
			$httpbody.="<img src='http://".$cellarr[$key]."/host.php?png' width='90' height='15'/>";
			if(!$q_str_1){$q_str_1="a";}
			switch($q_str_1){
				case 'a':
					$tmp_h1="<h1>sfmdc</h1>";
					$httpbody.="<a href='http://".$cellarr[$key]."/sfmdc/'/>".$cellarr[$key]."</a>\n";
				break;
				case 'b':
					$tmp_h1="<h1>dbchat</h1>";
					$httpbody.="<a href='http://".$cellarr[$key]."/dbc/'/>".$cellarr[$key]."</a>\n";
				break;
				case 'c':
					$tmp_h1="<h1>txtsavelog</h1>";
					$httpbody.="<a href='http://".$cellarr[$key]."/tsl/txtsavelog.php'/>".$cellarr[$key]."</a>\n";
				break;
				default:
				break;
			}
			$httpbody.="<br/>\n";
		}
	}
}
$tmp_link="";
$tmp_link.="".
"<a href='".$phpself."?a!a'>sfmdc</a>　".
"<a href='".$phpself."?a!b'>dbc__</a>　".
"<a href='".$phpself."?a!c'>tsl__</a>　".
"<br/>";
$httpbody=$tmp_h1.$tmp_link.$httpbody."<br/>\n";
echo $httphead."\n" ;
echo $httpbody."\n" ;
echo $httpend."\n" ;
	break;
	default:
$httpbody="?a<br/>\n$out1";
echo $httphead."\n" ;
echo $httpbody."\n" ;
echo $httpend."\n" ;
	break;
}//switch/
?>