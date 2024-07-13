<?php
use Typecho\Db;
ob_clean();
header("HTTP/1.1 200 OK");
    header("Access-Control-Allow-Origin: *");
    header('Content-type: application/json');
    date_default_timezone_set('PRC');
    $options = Helper::options();
    $removeChar = ["https://", "http://"]; 
    Typecho_Widget::widget('Widget_User')->to($user);
    $db = \Typecho\Db::get();
$id = $this->user->uid;
$opts = array(
  'http'=>array(
   'method' => 'GET',
          'header' => 'Content-type: application/json',
          'timeout' => 60 * 10,
       'Connection'=>"close"
  )
);
$context = stream_context_create($opts);
    if (strpos($_SERVER['HTTP_REFERER'], str_replace($removeChar, "", $options->siteUrl)) !== false) {   
        if(Bsoptions('Emoji_HideDefault') == false || Bsoptions('Emoji_HideDefault') == ''){
        $res = json_decode(file_get_contents($options->themeUrl."/assets/vendors/bs-emoji/bs-emoji.json", false, $context),true);
        $result = $res;
        }
        if(Bsoptions('Emoji_Diy') == true && Bsoptions('Emoji_DiyUrl') !== ''){
        $res2 = json_decode(file_get_contents(Bsoptions('Emoji_DiyUrl'), false, $context),true);
        if(Bsoptions('Emoji_HideDefault') == false || Bsoptions('Emoji_HideDefault') == ''){
        $result = array_merge($res,$res2);
        }
        else{
        $result = $res2;    
        }
        }
       

        exit(json_encode($result,JSON_UNESCAPED_UNICODE));

}