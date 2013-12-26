<?php 
header('Content-type: text/html; charset=utf-8');
date_default_timezone_set("Asia/Taipei");//時區設定
$time = time();//UNIX時間時區設定
$date=gmdate("ymd",$time);
$tmp_f_cnt_arr=array("aaa","bb","ddddddd");
//$a=array("a"=>"Cat","b"=>"Dog");
$arr_2="$date,1";//新的紀錄 從1開始
array_unshift($tmp_f_cnt_arr,$arr_2);//擺回去
echo "<pre>";
print_r($tmp_f_cnt_arr);
echo "</pre>";

?> 
