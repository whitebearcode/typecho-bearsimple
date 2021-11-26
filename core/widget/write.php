<?php
//BearSimple For Typecho
header("HTTP/1.1 200 OK");
    header("Access-Control-Allow-Origin: *");
    date_default_timezone_set('PRC');
    Typecho_Widget::widget('Widget_User')->to($user);
    if ($user->hasLogin()) {
if ($_GET["cid"]) {
     Typecho_Widget::widget('Widget_Contents_Attachment_Related', 'parentId=' . $_GET["cid"])->to($attachment);
    } else {
        Typecho_Widget::widget('Widget_Contents_Attachment_Unattached')->to($attachment);
    }
    $result = array(
    'code' => '1',
    'list' => array()
);
while ($attachment->next()){
    $result['list'][] = array(
	 'title' => $attachment->title,
	 'cid' => $attachment->cid,
	 'url' => $attachment->attachment->url,
	);
}
echo json_encode($result); 
}
else{
    $arr['msg'] ='鉴权失败';
    exit(json_encode($arr,JSON_UNESCAPED_UNICODE));
}