<?php
    header("Access-Control-Allow-Origin: *");
    header('Access-Control-Allow-Method:POST');
    error_reporting(0);

    
    function getCheck()
{
    $Versions = json_decode(file_get_contents('https://upgrade.bear-studio.net/Typecho/Bearsimple/version.php'),true);
    $output = file_get_contents(dirname(__FILE__).'/Version.php');
    if ($output == $Versions['version']){
    return 'yes';
    }
    elseif ($output < $Versions['version']){
        return 'no';
    }
}

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
    //验证传过来的值
$file_path = dirname(__FILE__).'/Upgrade'.$_POST['upgradekey'].'.Key';
$filein3 = str_replace('bearsimple/vendors/Upgrade','',dirname(__FILE__)).'Bearsimple.zip';
if(file_exists($file_path)){
$str = file_get_contents($file_path);
$str = str_replace("\r\n","<br />",$str);
if ( $_POST['upgradekey'] !== $str){
    $data['status']  = 200;
$data['code']  = 2;
$data['message']  = '鉴权失败';
}
else{
   $verify = getCheck();
   if($verify == "yes"){
$data['status']  = 200;
$data['code']  = 2;
$data['message']  = '您目前已是最新版本！';
}
  elseif($verify == "no"){
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
  }}else{
      $data['status']  = 200;
 $data['code']  = 2;
 $data['message']  = '鉴权失败';
  }
   exit(json_encode($data, JSON_UNESCAPED_UNICODE));
}
Upgrade();
