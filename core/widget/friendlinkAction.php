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
         $links = $db->fetchAll($db->select()->from('table.bscore_friendlinks')->where('status = ?', 'waiting')->order('id',Typecho\Db::SORT_DESC));
        $result = array(
    'list' => array()
);
$result['list'] = $links;       
        }
        if($_POST['type'] == 'reject'){
        $db->query($db->update('table.bscore_friendlinks')->rows(array('status' => 'reject'))
                        ->where('id = ?', $_POST['linkid']));
        if($temoptions['FriendLinkAcceptSendMail'] == true && $temoptions['Smtp_open'] == true && $_POST['linkmail'] !== '无'){
         //审核不通过发送邮件   
         file_get_contents(Common::url('/action/' . BsCore_Plugin::$action, Options::alloc()->index).'?do=linkMail&type=notifyfail&mail='.$_POST['linkmail']); 
        }
        $links = $db->fetchAll($db->select()->from('table.bscore_friendlinks')->where('status = ?', 'waiting')->order('id',Typecho\Db::SORT_DESC));
        $result = array(
    'list' => array()
);
$result['list'] = $links;
        }
        
        if($_POST['type'] == 'delete'){
        $db->query($db->delete('table.bscore_friendlinks')->where('id = ?', $_POST['linkid']));
        }
        if($_POST['type'] == 'edit'){
        $db->query($db->update('table.bscore_friendlinks')->rows(array(
                'friendname' => htmlspecialchars($_POST['friendname'],ENT_QUOTES,'UTF-8'),
                'friendurl' => htmlspecialchars($_POST['friendurl'],ENT_QUOTES,'UTF-8'),
                'friendpic' => htmlspecialchars($_POST['friendpic'],ENT_QUOTES,'UTF-8'),
                'frienddec' => htmlspecialchars($_POST['frienddec'],ENT_QUOTES,'UTF-8'),
                'contactmail' => htmlspecialchars($_POST['contactmail'],ENT_QUOTES,'UTF-8'),
                'checkurl' => htmlspecialchars($_POST['checkurl'],ENT_QUOTES,'UTF-8'),
                'rejectreason' => htmlspecialchars($_POST['rejectreason'],ENT_QUOTES,'UTF-8')))
                        ->where('id = ?', $_POST['id']));
                        $links = $db->fetchAll($db->select()->from('table.bscore_friendlinks')->where('status = ?', 'waiting')->order('id',Typecho\Db::SORT_DESC));
        $result = array(
    'list' => array()
);
$result['list'] = $links;
        }
        if($_POST['type'] == 'add'){
            if(empty($_POST['contactmail'])){
        $_POST['contactmail'] = '无';
    }
    $link = array(
                'friendname' => htmlspecialchars($_POST['friendname'],ENT_QUOTES,'UTF-8'),
                'friendurl' => htmlspecialchars($_POST['friendurl'],ENT_QUOTES,'UTF-8'),
                'friendpic' => htmlspecialchars($_POST['friendpic'],ENT_QUOTES,'UTF-8'),
                'frienddec' => htmlspecialchars($_POST['frienddec'],ENT_QUOTES,'UTF-8'),
                'contactmail' => htmlspecialchars($_POST['contactmail'],ENT_QUOTES,'UTF-8'),
                'checkurl' => htmlspecialchars($_POST['checkurl'],ENT_QUOTES,'UTF-8'),
                'status' => htmlspecialchars($_POST['addtype'],ENT_QUOTES,'UTF-8')
            );
            $db->query($db->insert('table.bscore_friendlinks')->rows($link));
            $links = $db->fetchAll($db->select()->from('table.bscore_friendlinks')->where('status = ?', 'waiting')->order('id',Typecho\Db::SORT_DESC));
        $result = array(
    'list' => array()
);
$result['list'] = $links;
        }
      if($_POST['type'] == 'check'){
         $url = $_POST['checkurl'];
$check = file_get_contents($url);
$removeChar = ["https://", "http://", "/"]; 
$url2 = str_replace($removeChar, "", $options->siteUrl);
$appUrlPreg= "/$url2/i";
$headers = get_headers($url); 
preg_match($appUrlPreg,$check,$match);
if (filter_var($url, FILTER_VALIDATE_URL)){
if($headers[0] == 'HTTP/1.1 200 OK'){
 if($match){
     $result = array(
    'code' => 1,
    'data'=>array(
     'friendname'=> $_POST['friendname'],
     'friendid'=> $_POST['id'],
     'friendname'=> $_POST['friendname'],
    ),
    'message' => '友链正常',
);
 }
 else{
         $result = array(
    'code' => 1,
    'data'=>array(
     'friendname'=> $_POST['friendname'],
     'friendid'=> $_POST['id'],
     'friendname'=> $_POST['friendname'],
    ),
    'message' => '对方未进行反链',
);
 }
}
else{
     $result = array(
    'code' => 1,
    'data'=>array(
     'friendname'=> $_POST['friendname'],
     'friendid'=> $_POST['id'],
     'friendname'=> $_POST['friendname'],
    ),
    'message' => '对方站点访问异常',
);
}
}
else{
     $result = array(
    'code' => 1,
    'data'=>array(
     'friendid'=> $_POST['id'],
     'friendmail'=> $_POST['mail'],
    ),
    'message' => '该站点的友链放置页面网址识别错误，请重新修改',
);
}


      }
	echo json_encode($result); 
	
        
    }