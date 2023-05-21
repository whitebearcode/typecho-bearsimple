<?php
header("HTTP/1.1 200 OK");
    header("Access-Control-Allow-Origin: *");
    date_default_timezone_set('PRC');
error_reporting(0);
if($_POST['action'] == 'find'){
if($this->user->hasLogin()){
$this->response->throwJson([
            'code'=> 1,
            'name'=> $this->user->screenName,
            'group'=>$this->user->group,
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
