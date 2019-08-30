<?php
echo '123';exit;
ignore_user_abort();//關掉瀏覽器，PHP腳本也可以繼續執行.
set_time_limit(0);// 通過set_time_limit(0)可以讓程式無限制的執行下去
$interval=60;// 每隔 1 min 運行

do{
	
header("Content-Type: text/html; charset=utf-8");
echo '<script>alert("hello");</script>';
sleep($interval);// 等待5分鐘
}while(true);