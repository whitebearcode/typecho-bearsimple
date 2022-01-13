<?php
header("HTTP/1.1 200 OK");
    header("Access-Control-Allow-Origin: *");
    header('Access-Control-Allow-Method:POST');
    error_reporting(0);

function downFile(){
    $file=file_get_contents('https://upgrade.bear-studio.net/Typecho/Bearsimple/Bearsimple.zip');
    $filein = str_replace('bearsimple/vendors/Upgrade','',dirname(__FILE__)).'Bearsimple.zip';
    file_put_contents(str_replace('bearsimple/vendors/Upgrade','',dirname(__FILE__)) . 'Bearsimple.zip',$file);  
    if(file_exists($filein)){
        return 'ok';
    }
    else{
        return 'sorry';
    }
}

function Upgrade(){
    Typecho_Widget::widget('Widget_User')->to($user);
    //验证是否登录
$filein3 = str_replace('bearsimple/vendors/Upgrade','',dirname(__FILE__)).'Bearsimple.zip';
if($user->hasLogin()){
   $Versions = json_decode(file_get_contents('https://upgrade.bear-studio.net/Typecho/Bearsimple/version.php'),true);
   if (themeversion() == $Versions['version']){
$data['status']  = 200;
$data['code']  = 2;
$data['message']  = '您目前已是最新版本！';
}
  elseif(themeversion() < $Versions['version']){
      if(file_exists($filein3)){
 unlink($filein3);
 }
 
      if(downFile() == 'ok'){
   if (class_exists('ZipArchive')) {
      $zip=new ZipArchive;
  if($zip->open(str_replace('bearsimple/vendors/Upgrade','',dirname(__FILE__)).'Bearsimple.zip')===TRUE){ 
  $zip->extractTo(str_replace('bearsimple/vendors/Upgrade','',dirname(__FILE__)));
  $zip->close();
 $data['status']  = 200;
 $data['code']  = 1;
 $data['message']  = '已成功升级至最新版本！';
 $filein = str_replace('Upgrade','',dirname(__FILE__)).'CheckTool/Http.Code';
 $filein2 = str_replace('vendors/Upgrade','',dirname(__FILE__)).'modules/Plugin.php';
 
 if(file_exists($filein)){
 unlink($filein);
 }
 if(file_exists($filein2)){
 unlink($filein2);
 }
 if(file_exists($filein3)){
 unlink($filein3);
 }
  }
   }
  else{
      $data['status']  = 200;
 $data['code']  = 2;
 $data['message']  = '升级失败，请检查PHP是否开启ZIP扩展以及网站目录权限是否可读写';
  }
  }
  else{
   $data['status']  = 200;
 $data['code']  = 2;
 $data['message']  = '升级失败，更新包下载失败，请重试';   
  }
  }
  }else{
      $data['status']  = 200;
 $data['code']  = 2;
 $data['message']  = '鉴权失败';
  }
   exit(json_encode($data, JSON_UNESCAPED_UNICODE));
}
Upgrade();
