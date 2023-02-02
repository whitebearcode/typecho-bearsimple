<?php
use Typecho\Db;
use Typecho\Common;
use Widget\Options;
header("HTTP/1.1 200 OK");
    header("Access-Control-Allow-Origin: *");
    date_default_timezone_set('PRC');
    $options = Helper::options();
    $temoptions = bsOptions::getInstance()::get_option( 'bearsimple' );
    $removeChar = ["https://", "http://", "/"]; 
    
    if (strpos($_SERVER['HTTP_REFERER'], str_replace($removeChar, "", $options->siteUrl)) !== false) {   
if (isset($_GET['data'])) {
    $friend_data = explode("&",$_GET['data']);
    if(empty($friend_data[4])){
        $friend_data[4] = '无';
    }
    $db= \Typecho\Db::get();
    
        $link = array(
                'friendname' => urldecode($friend_data[0]),
                'friendurl' => urldecode($friend_data[1]),
                'friendpic' => urldecode($friend_data[2]),
                'frienddec' => urldecode($friend_data[3]),
                'contactmail' => urldecode($friend_data[4]),
                'status' => 'waiting'
            );
            $db->query($db->insert('table.bscore_friendlinks')->rows($link));
            if($temoptions['FriendLinkSubmitSendMail'] == true && $temoptions['Smtp_open'] == true){
             file_get_contents(Common::url('/action/' . BsCore_Plugin::$action, Options::alloc()->index).'?do=linkMail&type=notifyaccept');   
            }
    $result = array(
    'code' => 1,
    'msg' => 'success',
);
      exit(urldecode(json_encode($result)));
}
    }
    else{
        $result = array(
    'code' => 2,
    'message' => 'error'
);
      exit(urldecode(son_encode($result)));  
}