<?php
//载入qrcode类库
include "./phpqrcode.php";

//取得GET参数
$url       = isset($_GET["url"]) ? $_GET["url"] : ''; //二维码内容
$errorLevel = isset($_GET["e"]) ? $_GET["e"] : 'L'; //容错级别 默认L
$PointSize  = isset($_GET["p"]) ? $_GET["p"] : '5'; //二维码尺寸 默认5
$margin     = isset($_GET["m"]) ? $_GET["m"] : '2'; //二维码白边框尺寸 默认2
//去掉下方注释，可以检测二维码内容是否包含某字段 ，防止盗链。
/*
$isok 		= strstr($text, "luckymoke.cn"); //要检测的内容根据自己需求改
if(!$isok){
	echo "403 Forbidden";
	exit; //停止继续执行
}
*/
//二维码生成函数
function getqrcode($value,$errorCorrectionLevel,$matrixPointSize,$margin) {
    QRcode::png($value, false, $errorCorrectionLevel, $matrixPointSize, $margin);
}
getqrcode($url, $errorLevel, $PointSize, $margin);
?>