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
    if (strpos($_SERVER['HTTP_REFERER'], str_replace($removeChar, "", $options->siteUrl)) !== false && $user->hasLogin() && $user->pass('administrator', true)) {   
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
        
        if($_POST['type'] == 'delete'){
        $db->query($db->delete('table.bscore_friendlinks')->where('id = ?', $_POST['linkid']));
        }
        if($_POST['type'] == 'edit'){
        $db->query($db->update('table.bscore_friendlinks')->rows(array('friendname' => $_POST['friendname'],'friendurl' => $_POST['friendurl'],'friendpic' => $_POST['friendpic'],'frienddec' => $_POST['frienddec'],'contactmail' => $_POST['contactmail']))
                        ->where('id = ?', $_POST['id']));
        }
        if($_POST['type'] == 'add'){
            if(empty($_POST['contactmail'])){
        $_POST['contactmail'] = '无';
    }
    $link = array(
                'friendname' => $_POST['friendname'],
                'friendurl' => $_POST['friendurl'],
                'friendpic' => $_POST['friendpic'],
                'frienddec' => $_POST['frienddec'],
                'contactmail' => $_POST['contactmail'],
                'status' => $_POST['addtype']
            );
            $db->query($db->insert('table.bscore_friendlinks')->rows($link));
        }
        $links = $db->fetchAll($db->select()->from('table.bscore_friendlinks')->where('status = ?', 'waiting')->order('id',Typecho\Db::SORT_DESC));
        $result = array(
    'list' => array()
);
$result['list'] = $links;
	echo json_encode($result); 
	
        
    }