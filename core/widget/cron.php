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
    $removeChar = ["https://", "http://"]; 
    Typecho_Widget::widget('Widget_User')->to($user);
    $db = \Typecho\Db::get();
$temoptions = bsOptions::getInstance()::get_option( 'bearsimple' );
   
function checkLinks($url) {
    try {
        $options = Helper::options();
        $headers = [
            'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:33.0) Gecko/20100101 Firefox/33.0'
        ];

        // 使用 cURL 检查 URL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, $headers['User-Agent']);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // 检查域名是否匹配
        $removeChar = ["https://", "http://","/"];
        $url2 = str_replace($removeChar, "", $options->siteUrl);
        $appUrlPreg = "/$url2/i";
        preg_match($appUrlPreg, $response, $match);

        // 返回结果
        if ($statusCode === 200 && $match) {
            return true;
        }
        return false;
    } catch (Exception $e) {
        // 记录日志或处理异常
        echo "检查出现异常: " . $e->getMessage();
        return false;
    }
}
if ($argc > 1 && $argv[1] === Helper::options()->cronKey) {
$links = $db->fetchAll($db->select()->from('table.bscore_friendlinks')->where('status != ?', 'waiting')->where('checkurl != ?', '0')->orWhere('checkurl != ?', '暂无')->orWhere('checkurl != ?', '')->order('id',Typecho\Db::SORT_DESC));
if($links){
$total = count($links);
}
else{
$total = 0;    
}
if($temoptions['friendtab']['checkFailedAction'] == true){
$failedLinks = $db->fetchAll($db->select()->from('table.bscore_friendlinks')->where('status = ?', 'approved')->where('checkurl != ?', '0')->orWhere('checkurl != ?', '暂无')->orWhere('checkurl != ?', '')->order('id',Typecho\Db::SORT_DESC));
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
$successLinks = $db->fetchAll($db->select()->from('table.bscore_friendlinks')->where('status = ?', 'reject')->where('checkurl != ?', '0')->orWhere('checkurl != ?', '暂无')->orWhere('checkurl != ?', '')->order('id',Typecho\Db::SORT_DESC));
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
