<?php 
header("content-Type: text/html; charset=utf-8"); //語言強制
ob_start;
echo "<pre>";
if(is_file(".htaccess")){
	echo ".htaccess檔案存在\n";
}else{
	echo ".htaccess檔案消失\n";
	die('####程序中斷####');
}
if(!is_writeable(realpath('./'))){die("所在目錄無法寫入");} //檢查根目錄權限
if(is_file("./image.jpg.php")){
	if(is_file("image.jpg")){
		unlink("image.jpg");//刪掉舊的
		echo "刪掉舊的\n";
	}else{}
	$chk=rename("image.jpg.php","image.jpg");
	if($chk){echo "更名成功\n";}else{}
}else{
	echo "找不到原始檔\n";
}
echo "</pre>";
$echo_body=ob_get_contents();//輸出擷取到的echo
ob_end_clean();//清空擷取到的內容
echo $echo_body;
?> 
