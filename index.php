<?php
header('Content-type: text/html; charset=utf-8');
//mb_internal_encoding("UTF-8");
require './config.php';//$time
$text=celltext;

//$time = time();//UNIX時間時區設定
$text=$celltext;
function reg($phpself,$logfile,$text){
	$text=trim($text);
	$time=$GLOBALS['time'];
	$name=substr(crypt(md5($_SERVER["REMOTE_ADDR"].'ㄎㄎ'.gmdate("ymd", $time)),'id'),-8);
	$text = preg_replace("/http\:\/\//", "Ettpp//", $text);//
	$text = preg_replace("/Ettpp\/\//", "http://", $text);//有些免空會擋過多的http字串
	$maxlen=strlen($text);//計算字數
	$maxlen_limit=1500;
		//if($maxlen>$maxlen_limit){die("字數".$maxlen.">".$maxlen_limit."");}
		//$text=substr($text,0,2);//移除規定字數之後的部份
	$tmp=array();
	$tmp=explode("\n",$text);
		$maxline=count($tmp);//計算行數
		$maxline_limit=15;
		//if($maxline>$maxline_limit){die("行數".$maxline.">".$maxline_limit."");}
		//array_splice($tmp,15);//移除陣列第15項之後的部份
	$text=implode("\n",$tmp);
	$text=chra_fix($text);//[自訂函數]轉換成安全字元
	//
	//$logfile="sfmd_chat.log";//req
	$ymdhis=date('y/m/d H:i:s',$time);
	
	$cp = fopen($logfile, "a+") or die('failed');// 讀寫模式, 指標於最後, 找不到會嘗試建立檔案
	rewind($cp); //從頭讀取
	$buf=fread($cp,1000000); //讀取至暫存
	ftruncate($cp, 0); //砍資料至0
	$buf=$ymdhis.",".$name.",".$text.",".$time."\n".$buf;
	$cellarr=array();
	$cellarr=explode("\n",$buf);
	foreach($cellarr as $key => $value) {
		$cellarr2=explode(",",$cellarr[$key]);
		if($cellarr2[1]==""){unset($cellarr[$key]);}//空白行去除
	}
	array_splice($cellarr,1000);//移除陣列第1000項之後的部份
	$buf=implode("\n",$cellarr);
	fputs($cp, $buf);
	fclose($cp);
	$t_url="./?".$time;//網址
	header("refresh:2; url=$t_url");
	$tmp="行數".$maxline."字數".$maxlen."";
	die("<html><head></head><body>成功發文 <a href='$t_url'>$t_url</a>$tmp</body></html>");
}
function view($phpself,$logfile,$p2){
	$time=$GLOBALS['time'];
	
	$cp = fopen($logfile, "a+") or die('log讀取錯誤');// 讀寫模式, 指標於最後, 找不到會嘗試建立檔案
	rewind($cp); //從頭讀取
	$buf=fread($cp,1000000); //讀取至暫存
	fclose($cp);//關閉檔案要求
	
	$cellarr=array();
	$cellarr=explode("\n",$buf);
	$page_echo='';$tmp_arr=array();
	$page_echo.="<dl>\n";
	$maxline=count($cellarr);//計算有多少資料
	$showline=10;//一頁顯示幾筆
	$allpage=ceil($maxline/$showline)+1;
	if($p2==''){$p2=1;}//排除不符合的p2值
	if($p2>$allpage||$p2<0||preg_match("/[^0-9]/",$p2)){$p2=1;}//排除不符合的p2值
	$page_start=($p2-1)*$showline;//起始資料
	$page_end=($p2)*$showline;//尾端資料
	for($i=0;$i<$maxline;$i++){//利用迴圈列所有資料
		if($i>=$page_start && $i<$page_end){
			$tmp_arr=explode(",",$cellarr[$i]);
			//$page_echo.="$i/$p2";
			$page_echo.="<dt>[".$tmp_arr[0]."] ".$tmp_arr[1]." ".$tmp_arr[3]."</dt>\n"."<dd><pre>".$tmp_arr[2]."</pre></dd>\n";
		}
	}
	$page_echo.="</dl>\n";
	$page_echo2='';
	$page_echo2.='<hr>';
	$page_echo2.=$maxline."筆".$showline."見";
	for($i=1;$i<$allpage;$i++){//利用迴圈列所有頁數
		if($i==$p2){
			$page_echo2.="<span style='border-radius: 22px; border:1px solid red;background-color:#0ff;'>[<a href='$phpself?p2=$i'>$i</a>]</span>";
		}else{
			$page_echo2.="[<a href='$phpself?p2=$i'>$i</a>]";
		}
		//
	}
	$page_echo2.='<hr>';
	$page_echo=$page_echo2.$page_echo.$page_echo2;
	return $page_echo;
}
function viewtab($phpself,$logfile){//分頁顯示
	$time=$GLOBALS['time'];
	$query_string=$GLOBALS['query_string'];
	
	if(preg_match('/^[0-9]{10}$/', $query_string)){}else{die("?why");} //檢驗$query_string格式
	//$date_ym=date("ym", $time);//年月
	//$logfile="z".$date_ym.".log";//log檔案
	$cp = fopen($logfile, "a+") or die('log讀取錯誤');// 讀寫模式, 指標於最後, 找不到會嘗試建立檔案
	rewind($cp); //從頭讀取
	$buf=fread($cp,1000000); //讀取至暫存
	fclose($cp);//關閉檔案要求
	
	$cellarr=array();
	$cellarr=explode("\n",$buf);//以斷行分割資料群
	$page_echo='';$tmp_arr=array();
	$maxline=count($cellarr);//計算有多少資料
	$chk=0;//flag
	for($i=0;$i<$maxline;$i++){//利用迴圈列所有資料
		$tmp_arr=explode(",",$cellarr[$i]);//以逗號分割資料群
		if($tmp_arr[3]==$query_string){
			//$page_echo.="<dt>[".$tmp_arr[0]."] ".$tmp_arr[1]." ".$tmp_arr[3]."</dt>\n"."<dd><pre>".$tmp_arr[2]."</pre></dd>\n";
			$page_echo.="\n<pre>\n".$tmp_arr[2]."\n</pre>\n";
			$chk=1;
		}
	}
	if(!$chk){$page_echo="?where";}
	$tmp2="<a href='./'>BACK</a>";
	$tmp3="<hr/>";
	$page_echo=$tmp2.$tmp3.$page_echo.$tmp3.$tmp2;
	return $page_echo;
}

	
switch($mode){
	case 'reg':
		if($na!='3'){die('xna');}
		if(!$chk){die('!chk');}
		if($text==""){die("無內文");}
		reg($phpself,$logfile,$text);//FFF
	break;
	default:
		$tab=0; //config.php
		//檢查是否等於數字
		if(preg_match('/^[0-9]{10}$/', $query_string)){$tab=1;}else{$tab=0;}
		//判斷是否使用分頁
		if($tab){ //$query_string=數字
			echo htmlstart_parameter(0,$ver);
			//echo $form;//分頁模式不顯示表單
			//echo $tab;
			echo viewtab($phpself,$logfile);//FFF
			echo $htmlend;
		}else{ //$query_string=文字
			if($query_string=="what"){//等於what
				echo htmlstart_parameter(1,$ver);
				//echo $tab;
				echo $form;
				echo view($phpself,$logfile,$p2);//FFF
				echo $htmlend;
			}else{//其他
				while(true){
					if(is_file("$logfile")){//檔案存在
						if(!is_readable(realpath($logfile))){die("log無法讀取");}
						if(!is_writeable(realpath($logfile))){die("log無法寫入");}
						break;
					}else{//檔案不存在
						$cp = fopen($logfile, "a+") or die('log無法建立(資料夾寫入權限?)');// 讀寫模式, 指標於最後, 找不到會嘗試建立檔案
						fclose($cp);//關閉檔案要求
					}
				}
				echo htmlstart_parameter(1,$ver);
				echo $form;//顯示表格
				echo "?what";
				echo $htmlend;
			}
		}
	break;
}

/*
		//bbcode()
		$string = $tmp_arr[2]; //bbcode目前只使用連結功能
		$string = preg_replace("/(^|[^=\]])(http|https)(:\/\/[\!-;\=\?-\~]+)/si", "\\1<a href=\"\\2\\3\" target=_blank>\\2\\3</a>", $string);
		$string = preg_replace("/\n/si", "<br/>", $string);
		$tmp_arr[2] = $string;
		//bbcode(/)
*/
?>
	
