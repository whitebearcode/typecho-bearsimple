<?php
use Typecho\Db;
ob_clean();
header("HTTP/1.1 200 OK");
    header("Access-Control-Allow-Origin: *");
    header('Content-type: application/json');
    date_default_timezone_set('PRC');
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
}

        exit(json_encode($result,JSON_UNESCAPED_UNICODE));

}