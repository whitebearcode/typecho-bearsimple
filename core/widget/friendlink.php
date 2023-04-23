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
if (isset($_POST['data'])) {
    if(empty($_POST['data']['contactMail'])){
        $_POST['data']['contactMail'] = '无';
    }
    $db= \Typecho\Db::get();
    
        $link = array(
                'friendname' => htmlspecialchars($_POST['data']['friendName'],ENT_QUOTES,'UTF-8'),
                'friendurl' => htmlspecialchars($_POST['data']['friendUrl'],ENT_QUOTES,'UTF-8'),
                'friendpic' => htmlspecialchars($_POST['data']['friendPic'],ENT_QUOTES,'UTF-8'),
                'frienddec' => htmlspecialchars($_POST['data']['friendDec'],ENT_QUOTES,'UTF-8'),
                'contactmail' => htmlspecialchars($_POST['data']['contactMail'],ENT_QUOTES,'UTF-8'),
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