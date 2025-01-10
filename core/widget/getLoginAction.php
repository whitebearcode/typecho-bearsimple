<?php

header("HTTP/1.1 200 OK");
    header("Access-Control-Allow-Origin: *");
    date_default_timezone_set('PRC');
error_reporting(0);
ob_clean();
$options = Helper::options();
    $temoptions = bsOptions::getInstance()::get_option( 'bearsimple' );
    $removeChar = ["https://", "http://"]; 
    Typecho_Widget::widget('Widget_User')->to($user);
if (strpos($_SERVER['HTTP_REFERER'], str_replace($removeChar, "", $options->siteUrl)) !== false) {     
if($_POST['action'] == 'login'){

echo Helper::options()->loginAction;
return;
}
else if($_POST['action'] == 'protect'){

echo Typecho_Widget::widget('Widget_Security')->getTokenUrl($_POST['permalink']);
return;
}
else if($_POST['action'] == 'cross'){

echo Typecho_Widget::widget('Widget_Security')->index('/action/comments-edit?do=edit&coid=' . $_POST['coid']);
return;
}
else if($_POST['action'] == 'editprofile'){

echo Typecho_Widget::widget('Widget_Security')->getIndex('/action/users-profile');
return;
}
else if($_POST['action'] == 'tougao'){

echo Typecho_Widget::widget('Widget_Security')->index('/action/contents-post-edit');
return;
}
else if($_POST['action'] == 'deleteCircle' && $user->hasLogin() && $user->pass('administrator', true)){

echo Typecho_Widget::widget('Widget_Security')->index('/action/comments-edit?do=delete&coid=' . $_POST['coid']);
return;
}
else if($_POST['action'] == 'register'){

echo Helper::options()->registerAction;
return;
}
else if($_POST['action'] == 'signout'){

echo Helper::options()->logoutUrl;
return;
}
else if($_POST['action'] == 'getmap'){

echo BsCore_Plugin::getIpLocation($_SERVER['REMOTE_ADDR']);
return;
}
else if($_POST['action'] == 'checklogin'){
if($this->user->hasLogin()){
$this->response->throwJson([
            'code'=> 1,
            'name'=> $this->user->screenName,
            'msg' => '已登录',
    ]);
return;
}
else{
$this->response->throwJson([
            'code'=> 0,
            'msg' => '未登录',
    ]);
return;
}
}
}