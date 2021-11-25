<?php
//BearSimple For Typecho
    header("Access-Control-Allow-Origin: *");
    date_default_timezone_set('PRC');
    \Widget\User::alloc()->to($user);
    if ($user->hasLogin()) {
//验证Referer
if (strpos( $_SERVER['HTTP_REFERER'],'write-post.php') == false && strpos( $_SERVER['HTTP_REFERER'],'write-page.php') == false)
{
$arr['msg'] ='鉴权失败';
    exit(json_encode($arr,JSON_UNESCAPED_UNICODE));
}
if ($_GET["cid"]) {
        \Widget\Contents\Attachment\Related::alloc(['parentId' => $_GET["cid"]])->to($attachment);
    } else {
        \Widget\Contents\Attachment\Unattached::alloc()->to($attachment);
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