<?php
use Typecho\Db;
use Typecho\Common;
use Widget\Options;
header("HTTP/1.1 200 OK");
    header("Access-Control-Allow-Origin: *");
    date_default_timezone_set('PRC');
    $options = Helper::options();
    $removeChar = ["https://", "http://", "/"]; 
    $temoptions = bsOptions::getInstance()::get_option( 'bearsimple' );
    Typecho_Widget::widget('Widget_User')->to($user);
    if (strpos($_SERVER['HTTP_REFERER'], str_replace($removeChar, "", $options->siteUrl)) !== false && $user->hasLogin()) {   
        $db = \Typecho\Db::get();
        if($_POST['type'] == 'approved'){
        $db->query($db->update('table.bscore_friendlinks')->rows(array('status' => 'approved'))
                        ->where('id = ?', $_POST['linkid']));
        if($temoptions['FriendLinkAcceptSendMail'] == true && $temoptions['Smtp_open'] == true && $_POST['linkmail'] !== '无'){
            //审核通过发送邮件
            file_get_contents(Common::url('/action/' . BsCore_Plugin::$action, Options::alloc()->index).'?do=linkMail&type=notifysuccess&mail='.$_POST['linkmail']);   
        }
                
        }
        if($_POST['type'] == 'reject'){
        $db->query($db->update('table.bscore_friendlinks')->rows(array('status' => 'reject'))
                        ->where('id = ?', $_POST['linkid']));
        if($temoptions['FriendLinkAcceptSendMail'] == true && $temoptions['Smtp_open'] == true && $_POST['linkmail'] !== '无'){
         //审核不通过发送邮件   
         file_get_contents(Common::url('/action/' . BsCore_Plugin::$action, Options::alloc()->index).'?do=linkMail&type=notifyfail&mail='.$_POST['linkmail']); 
        }
        }
        $links = $db->fetchAll($db->select()->from('table.bscore_friendlinks')->where('status = ?', 'waiting'));
        $result = array(
    'list' => array()
);
$result['list'] = $links;
	echo json_encode($result); 
    }