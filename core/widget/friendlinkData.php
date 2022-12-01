<?php
use Typecho\Db;
header("HTTP/1.1 200 OK");
    header("Access-Control-Allow-Origin: *");
    date_default_timezone_set('PRC');
    $options = Helper::options();
    $removeChar = ["https://", "http://", "/"]; 
    Typecho_Widget::widget('Widget_User')->to($user);
    if (strpos($_SERVER['HTTP_REFERER'], str_replace($removeChar, "", $options->siteUrl)) !== false && $user->hasLogin()) {   
        $db = \Typecho\Db::get();
        if($_POST['type'] == 'waiting'){
        $links = $db->fetchAll($db->select()->from('table.bscore_friendlinks')->where('status = ?', 'waiting'));
        }
        if($_POST['type'] == 'approved'){
        $links = $db->fetchAll($db->select()->from('table.bscore_friendlinks')->where('status = ?', 'approved'));
        }
        if($_POST['type'] == 'reject'){
        $links = $db->fetchAll($db->select()->from('table.bscore_friendlinks')->where('status = ?', 'reject'));
        }
        $result = array(
    'list' => array()
);
$result['list'] = $links;
	echo json_encode($result); 
    }