<?php
use Typecho\Db;
ob_clean();
header("HTTP/1.1 200 OK");
    header("Access-Control-Allow-Origin: *");
    header('Content-type: application/json');
    date_default_timezone_set('PRC');
ignore_user_abort(true);
set_time_limit(0);
ini_set('memory_limit',-1);
ini_set('mysql.connect_timeout', 900);
ini_set('default_socket_timeout', 900);
session_start();
    $options = Helper::options();
    $removeChar = ["https://", "http://"]; 
    Typecho_Widget::widget('Widget_User')->to($user);
    $db = \Typecho\Db::get();
$id = $this->user->uid;
    if (strpos($_SERVER['HTTP_REFERER'], str_replace($removeChar, "", $options->siteUrl)) !== false  && $user->hasLogin()) {   
       switch($_POST["action"]){ 
           case "openCopyright":
             $db->query($db->update('table.fields')->where('name = ?', 'copyright_cc')->rows(array('str_value' =>$_POST['type'])));
             $db->query($db->update('table.fields')->where('name = ?', 'copyright')->rows(array('str_value' =>"1")));
 $result = array(
    'code' => 1,
    'msg' => '同步成功'
);
break;

case "closeCopyright":
             $db->query($db->update('table.fields')->where('name = ?', 'copyright')->rows(array('str_value' =>"2")));
 $result = array(
    'code' => 1,
    'msg' => '同步成功'
);
break;
case "syncCircleData":
 
    $fcRows = $db->fetchAll($db->select()->from('table.contents')
        ->where('template = ?', 'friendcircle.php')
    );
    foreach($fcRows as $fcr){
       $fcMens = $db->fetchAll($db->select()->from('table.comments')
        ->where('cid = ?', $fcr['cid'])
        ->where('parent = ?', 0)
    ); 
     foreach($fcMens as $fcm){
        $fcData = $db->fetchRow($db->select()->from('table.bscore_friendcircle_data')
        ->where('coid = ?', $fcm['coid']) 
        );
        if(!$fcData){
            $circle_data = array(
                'coid' => $fcm['coid'],
                 'location' => '',
                'private' => false,
                'resources' => '',
            );
    $db->query($db->insert('table.bscore_friendcircle_data')->rows($circle_data));
    
        }
        
     }
    }
     $result = array(
    'code' => 1,
    'msg' => '同步成功'
);
    break;
}

        exit(json_encode($result,JSON_UNESCAPED_UNICODE));

}