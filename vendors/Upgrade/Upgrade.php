<?php
function get_http_type()
{
    $http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
    return $http_type;
}


    
function GetCheck()
{
    $Versions = json_decode(file_get_contents('http://version.typecho.bearlab.in/version-bearsimple.php'),true);
    $output = json_decode(file_get_contents(dirname(__FILE__).'/Version.php'),true);
    if ($output['version'] == $Versions['version']){
    return 'yes';
    }
    elseif ($output['version'] < $Versions['version']){
        return 'no';
    }
}

function downFile($url,$path){
    $arr=parse_url($url);
    $fileName=basename($arr['path']);
    $file=file_get_contents($url);
    file_put_contents($path.$fileName,$file);
}

function Upgrade(){
error_reporting(0);
$verify = GetCheck();
if($verify == "yes"){
$data['status']  = 200;
$data['code']  = 2;
$data['message']  = '您目前已是最新版本！';
 echo json_encode($data, JSON_UNESCAPED_UNICODE);
}
else{
downFile("https://www.coder-bear.com/downloads/upgrade/bearsimple/Bearsimple.zip",str_replace('bearsimple/vendors/Upgrade','',dirname(__FILE__)));
$zip=new ZipArchive;
  if($zip->open(str_replace('bearsimple/vendors/Upgrade','',dirname(__FILE__)).'Bearsimple.zip')===TRUE){ 
  $zip->extractTo(str_replace('bearsimple/vendors/Upgrade','',dirname(__FILE__)));
  $zip->close();
} 

 $data['status']  = 200;
 $data['code']  = 1;
 $data['message']  = '已成功升级至最新版本！';
 echo json_encode($data, JSON_UNESCAPED_UNICODE);
}
}
//验证Referer
if (strpos( $_SERVER['HTTP_REFERER'],'options-theme.php') == false)
{
echo '<html>
<head><title>403 Forbidden</title></head>
<body>
<center><h1>403 Forbidden</h1></center>
<hr><center>BearSimple</center>
</body>
</html>';
exit;
}
//验证传过来的值
$file_path = dirname(__FILE__).'/Upgrade.Key';
if(file_exists($file_path)){
$str = file_get_contents($file_path);
$str = str_replace("\r\n","<br />",$str);
if ( $_POST['upgradekey'] !== $str){
echo '<html>
<head><title>403 Forbidden</title></head>
<body>
<center><h1>403 Forbidden</h1></center>
<hr><center>BearSimple</center>
</body>
</html>';
exit;
}
}
Upgrade();
