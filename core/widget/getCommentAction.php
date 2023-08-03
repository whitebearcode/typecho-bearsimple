<?php
use Typecho\Db;
use Typecho\Common;
use Widget\Options;
header("HTTP/1.1 200 OK");
header("Access-Control-Allow-Origin: *");
date_default_timezone_set('PRC');
error_reporting(0);
$options = Helper::options();
    $temoptions = bsOptions::getInstance()::get_option( 'bearsimple' );
    $removeChar = ["https://", "http://", "/"]; 
    
    if (strpos($_SERVER['HTTP_REFERER'], str_replace($removeChar, "", $options->siteUrl)) !== false) {   
if($_POST['action'] == 'getCommentToken'){
$str = mt_rand(100001,999999); 
     $key = Helper::options()->siteUrl; 
     $securityToken = \BsCore\Plugin::authToken($str,'ENCODE',$key,0);
     \BsCore\Plugin::getSecurity('set','__typecho_security_token',$securityToken);
$this->response->throwJson([
            'code'=> 1,
            'msg' => '获取成功',
            'token'=>$securityToken
    ]);
return;
}
}