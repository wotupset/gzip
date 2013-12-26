<?php
header('Content-type: text/html; charset=utf-8');
error_reporting(E_ALL & ~E_NOTICE); //所有錯誤中排除NOTICE提示
extract($_POST,EXTR_SKIP);extract($_GET,EXTR_SKIP);extract($_COOKIE,EXTR_SKIP);
date_default_timezone_set("Asia/Taipei");
$time=time();//UNIX時間時區設定
$query_string=$_SERVER['QUERY_STRING'];
$phpself=basename($_SERVER["SCRIPT_FILENAME"]);//被執行的文件檔名
$phplink="http://".$_SERVER["SERVER_NAME"].$_SERVER["SCRIPT_NAME"]."";
$ThisURL = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; //含參數

if($query_string == "download"){ //網址等於comments.php?download 就下載檔案
	if(1){
		$f_size=(string)filesize($phpself);//檔案大小
		header('Content-type: text/plain'); //application/x-httpd-php
		header("Content-Length:".$f_size);
		header('Content-Transfer-Encoding: Binary'); //
		header('Content-type:application/force-download'); //強制下載
		$tmp="Content-Disposition: attachment; filename=".$phpself;
		header($tmp);
		readfile($phpself);
		exit;//結束
	}
}
$htmlstart=<<<EOT
<html><head>
<title>Tiara</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<META http-equiv="Content-Script-Type" content="text/javascript">
<META http-equiv="Content-Style-Type" content="text/css">
<META NAME='ROBOTS' CONTENT='noINDEX, noFOLLOW'>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
<!-- Optional theme -->
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css">
<!-- Latest compiled and minified JavaScript -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
</head><body>
EOT;
$htmlend=<<<EOT
</body></html>\n
EOT;

$echo_data='';
//$echo_data.=microtime(); //0.66268900 1367899094 (string)
//$echo_data.="\n<br/>\n";
//$echo_data.=microtime(true); //1367899094.6627 (float)
//$echo_data.="\n\n<hr/>\n\n";
//$tim = $time.'.'.substr(microtime(),2,5);
//$echo_data.=$tim;
//$echo_data.="\n\n<hr/>\n\n";
//$now=date("y/m/d H:i:s", $time);
$md5_code=md5(microtime(true));
if($phpself=="index.php"){$post_url="./md5=?".$md5_code;}else{$post_url="./$phpself?md5=".$md5_code;}
$tmp_str='';
if(preg_match('/^md5=/', $query_string)){$tmp_str="新頁=".$md5;}
$tmp=<<<EOT
<form id='form_131224' action='$post_url' method='post'>
<input type="submit" class="btn btn-success" value=" 產生新頁 "/> 
</form>
<div class="alert alert-success">
<b><a href="./$phpself">返回</a></b>
<b><a href="./$phpself?download">下載</a></b>
$tmp_str
</div>
EOT;
$echo_data.=$tmp;
//$echo_data.="\n\n<hr/>\n\n";
//$echo_data.=$ThisURL;
//$echo_data.="\n\n<hr/>\n\n";

////google plus comment
$googleplus_comments=<<<EOT
<div style='border:#000 1px solid;float:left;display:block;width:400px;'>
<script src="https://apis.google.com/js/plusone.js">{lang:'zh-TW'}</script>
<g:comments
    href="$ThisURL"
    width="400"
    first_party_property="BLOGGER"
    view_type="FILTERED_POSTMOD">
</g:comments>
</div>

EOT;
////facebook comment
$facebook_comments=<<<EOT
<div style='border:#000 1px solid;float:left;display:block;width:400px;'>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/zh_TW/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div class="fb-comments" data-href="$ThisURL" data-width="400" data-num-posts="10"></div>
</div>
EOT;
$disqus_comments=<<<EOT
<div id="disqus_thread" style='border:#000 1px solid;display:block;width:800px;'></div>
<script type="text/javascript">
    /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
    var disqus_shortname = 'zh131224'; // required: replace example with your forum shortname

    /* * * DON'T EDIT BELOW THIS LINE * * */
    (function() {
        var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
        dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
    })();
</script>
<noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
<a href="http://disqus.com" class="dsq-brlink">comments powered by <span class="logo-disqus">Disqus</span></a>

EOT;

//$now=mktime(date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"));

	
echo $htmlstart;
echo $echo_data;
echo $disqus_comments;
echo $facebook_comments;
echo $googleplus_comments;
echo '<div style="clear: both;">`&nbsp;</div>';
echo $htmlend;

?>
	
