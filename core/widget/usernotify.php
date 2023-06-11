<?php
header("HTTP/1.1 200 OK");
    header("Access-Control-Allow-Origin: *");
    date_default_timezone_set('PRC');
    $options = Helper::options();
    $removeChar = ["https://", "http://", "/"]; 
    $temoptions = bsOptions::getInstance()::get_option( 'bearsimple' );
    Typecho_Widget::widget('Widget_User')->to($user);
    if (strpos($_SERVER['HTTP_REFERER'], str_replace($removeChar, "", $options->siteUrl)) !== false && $user->hasLogin() && $user->pass('administrator', true)) {   
        $db = \Typecho\Db::get();
        if($_POST['type'] == 'notify'){
           $user = explode(',',$_POST['searchUser']);
            foreach($user as $arr){
       $notify = array(
                'notifyuid' => $arr,
                'notifytime' => date('Y年m月d日',time()),
                'notifytitle' => htmlspecialchars($_POST['notifytitle'],ENT_QUOTES,'UTF-8'),
                'notifytext' => htmlspecialchars($_POST['notifytext'],ENT_QUOTES,'UTF-8'),
            );
            $db->query($db->insert('table.bscore_notify_data')->rows($notify)); 
            }
            
            echo 1;
        }
       
   }
   else{
       echo 0;
   }