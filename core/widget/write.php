<?php
//BearSimple For Typecho
header("HTTP/1.1 200 OK");
    header("Access-Control-Allow-Origin: *");
    date_default_timezone_set('PRC');
    function get_file_suffix($file_name, $allow_type = array())
{
  $fnarray=$file_name;
    $file_suffix = strtolower(array_pop($fnarray));
  if (empty($allow_type))
  {
    return $file_suffix;
  }
  else
  {
    if (in_array($file_suffix, $allow_type))
    {
      return true;
    }
    else
    {
      return false;
    }
  }
}




    Typecho_Widget::widget('Widget_User')->to($user);
    if ($user->hasLogin()) {
        if ($_GET["url"] == 'post' || $_GET["url"] == 'page')
{
if ($_GET["cid"]) {
     Typecho_Widget::widget('Widget_Contents_Attachment_Related', 'parentId=' . $_GET["cid"])->to($attachment);
    } else {
        Typecho_Widget::widget('Widget_Contents_Attachment_Unattached')->to($attachment);
    }
    $result = array(
    'code' => '1',
    'list' => array()
);

$imgif= array('.jpg','.gif','.png','.jpeg','.svg','.ico');

while ($attachment->next()){
    if (preg_match('/\.(jpg|jepg|png|ico|bmp|gif|tiff|webp)/i', $attachment->attachment->url)) {

$attachtype = 'img';
}else{
$attachtype = 'other';
}
    $result['list'][] = array(
	 'title' => $attachment->title,
	 'cid' => $attachment->cid,
	 'url' => $attachment->attachment->url,
	 'type'=>$attachtype,
	);
}

echo json_encode($result); 
}
}
else{
    $arr['msg'] ='鉴权失败';
    exit(json_encode($arr,JSON_UNESCAPED_UNICODE));
}
