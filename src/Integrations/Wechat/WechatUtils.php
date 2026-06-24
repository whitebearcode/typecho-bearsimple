<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
require_once 'ImgCompress.php';

class WechatUtils {
    
    public static function uploadFile($blogUrl,$dir,$fileName,$openid){
 $bsoptions = bsOptions::getInstance()::get_option( 'bearsimple' );       
     
 // 准备要上传的文件
$file_path = $blogUrl.$dir.$fileName; // 文件路径   
  
// 初始化cURL会话
$ch = curl_init();

// 设置cURL选项
curl_setopt($ch, CURLOPT_URL,Typecho_Widget::widget('Widget_Security')->getIndex('/action/upload?do=wechatupload&openid='.$openid)); // 目标URL
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // 将结果作为字符串返回，而不是直接输出
curl_setopt($ch, CURLOPT_POST, 1); // 启用POST请求
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT , 120);
curl_setopt($ch, CURLOPT_TIMEOUT, 120);
$post_fields = array(
    'file' => new CURLFile($file_path), // 创建CURLFile对象
    'openid' => $openid,
    'cid' => $bsoptions['wechat_choose'],
);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields); // 设置POST字段

// 执行cURL会话并获取结果
$result = curl_exec($ch);

// 关闭cURL会话
curl_close($ch);

$ret = json_decode($result,true);



   return $ret[0];
    }
    
    
    
    public static function uploadPic($blogUrl, $name, $pic,$type,$suffix,$openid){
        $DIRECTORY_SEPARATOR = "/";
        $childDir = $DIRECTORY_SEPARATOR.'usr'.$DIRECTORY_SEPARATOR.'uploads' . $DIRECTORY_SEPARATOR .'wechatServer' .$DIRECTORY_SEPARATOR;
        $dir = __TYPECHO_ROOT_DIR__ . $childDir;
        if (!file_exists($dir)){
            mkdir($dir, 0777, true);
        }
        $fileName = $name. $suffix;
        $file = $dir .$fileName;
        if ($type == "web"){
            $img = self::getDataFromWebUrl($pic);
        }else{
            $img = $pic;
        }
        $fp2 = fopen($file , "a");
        fwrite($fp2, $img);
        fclose($fp2);

        (new Imgcompress($file,1))->compressImg($file);
        
 $bsoptions = bsOptions::getInstance()::get_option( 'bearsimple' );       
     
 // 准备要上传的文件
$file_path = $blogUrl.$childDir.$fileName; // 文件路径   
  
// 初始化cURL会话
$ch = curl_init();

// 设置cURL选项
curl_setopt($ch, CURLOPT_URL,Typecho_Widget::widget('Widget_Security')->getIndex('/action/upload?do=wechatupload&openid='.$openid)); // 目标URL
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // 将结果作为字符串返回，而不是直接输出
curl_setopt($ch, CURLOPT_POST, 1); // 启用POST请求
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT , 120);
curl_setopt($ch, CURLOPT_TIMEOUT, 120);
$post_fields = array(
    'file' => new CURLFile($file_path), // 创建CURLFile对象
    'openid' => $openid,
    'cid' => $bsoptions['wechat_choose'],
);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields); // 设置POST字段

// 执行cURL会话并获取结果
$result = curl_exec($ch);

// 关闭cURL会话
curl_close($ch);

$ret = json_decode($result,true);



   return $ret[0];
    }


    public static  function getDataFromWebUrl($url){
        $file_contents = "";
        if (function_exists('file_get_contents')) {
            $file_contents = @file_get_contents($url);
        }
        if ($file_contents == "") {
            $ch = curl_init();
            $timeout = 30;
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            $file_contents = curl_exec($ch);
            curl_close($ch);
        }
        return $file_contents;
    }
}