<?php
use Typecho\Db;
header("HTTP/1.1 200 OK");
    header("Access-Control-Allow-Origin: *");
    date_default_timezone_set('PRC');
    $options = Helper::options();
    $removeChar = ["https://", "http://", "/"]; 
    Typecho_Widget::widget('Widget_User')->to($user);
    if (strpos($_SERVER['HTTP_REFERER'], str_replace($removeChar, "", $options->siteUrl)) !== false && $user->hasLogin() && $user->pass('administrator', true)) {   
        $db = \Typecho\Db::get();
        $searchQuery = '%' . str_replace(' ', '%', $_GET['q']) . '%';
        $usersearch = $db->fetchAll($db->select()->from('table.users')->where('name LIKE ? ', htmlspecialchars($searchQuery,ENT_QUOTES,'UTF-8')));
        foreach($usersearch as $sear){
       $data[] = array(
                'id'    =>  $sear['uid'],
                'name'  =>  $sear['name']
            );

          
        }
        echo json_encode($data);
       }
   // }