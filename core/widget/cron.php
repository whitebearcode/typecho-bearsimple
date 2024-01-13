<?php
require_once str_replace("/usr/themes/bearsimple/core","",dirname(__DIR__)).'/config.inc.php';
error_reporting(0);
use \Utils\Helper;
if(!class_exists('CSF')){
    require_once Helper::options()->pluginDir('BsCore').'/bsoptions-framework.php';
}

if (!class_exists('bsOptions')){
    require_once \Utils\Helper::options()->pluginDir('BsCore').'/bsOptions.php';
}
use Typecho\Db;
ob_clean();
header("HTTP/1.1 200 OK");
    header("Access-Control-Allow-Origin: *");
    date_default_timezone_set('PRC');
ignore_user_abort(true);
set_time_limit(0);
ini_set('memory_limit',-1);
ini_set('mysql.connect_timeout', 900);
ini_set('default_socket_timeout', 900);
session_start();
    $removeChar = ["https://", "http://", "/"]; 
    Typecho_Widget::widget('Widget_User')->to($user);
    $db = \Typecho\Db::get();
$temoptions = bsOptions::getInstance()::get_option( 'bearsimple' );
   
function checkLinks($url){
    $options = Helper::options();
   $ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$removeChar = ["https://", "http://", "/"]; 
$url2 = str_replace($removeChar, "", $options->siteUrl);
$appUrlPreg= "/$url2/i";
$headers = get_headers($url); 
preg_match($appUrlPreg,$response,$match);
if($headers[0] == 'HTTP/1.1 200 OK' && $match){
    return true;
}
 return false;
}
if ($argc > 1 && $argv[1] === Helper::options()->cronKey) {
$links = $db->fetchAll($db->select()->from('table.bscore_friendlinks')->where('status != ?', 'waiting')->where('checkurl != ?', '0')->order('id',Typecho\Db::SORT_DESC));
if($links){
$total = count($links);
}
else{
$total = 0;    
}
if($temoptions['friendtab']['checkFailedAction'] == true){
$failedLinks = $db->fetchAll($db->select()->from('table.bscore_friendlinks')->where('status = ?', 'approved')->where('checkurl != ?', '0')->order('id',Typecho\Db::SORT_DESC));
$failedNumber = 0;
if($failedLinks){
    foreach($failedLinks as $f){
        
       if(checkLinks($f['checkurl']) == false){
         $db->query($db->update('table.bscore_friendlinks')->rows(array('status' => 'reject','rejectreason'=> !$temoptions['friendtab']['checkFailedActionText']? '友链检查未通过自动移动至失效友链列表' : $temoptions['friendtab']['checkFailedActionText']))
                        ->where('id = ?', $f['id']));  
                        $failedNumber++;
       }
    }
    
}

}
if($temoptions['friendtab']['checkSuccessAction'] == true){
$successLinks = $db->fetchAll($db->select()->from('table.bscore_friendlinks')->where('status = ?', 'reject')->where('checkurl != ?', '0')->order('id',Typecho\Db::SORT_DESC));
$successNumber = 0;
if($successLinks){
    foreach($successLinks as $s){
        
       if(checkLinks($s['checkurl']) == true){
         $db->query($db->update('table.bscore_friendlinks')->rows(array('status' => 'approved'))
                        ->where('id = ?', $s['id']));  
                        $successNumber++;
       }
       
    }
}
}
        $cron = array(
                'type' => 'checkLinks',
                'checktotal' => $total,
                'checksuccess' => $successNumber,
                'checkfailed' => $failedNumber,
                'checktime' => time(),
            );
            $db->query($db->insert('table.bscore_cron_data')->rows($cron));
            exit("Cron任务执行成功:)\n");
}
        else{
          exit("Cron error:(\n");  
        }