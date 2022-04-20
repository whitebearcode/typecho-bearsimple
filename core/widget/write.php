<?php
//BearSimple For Typecho
    header("Access-Control-Allow-Origin: *");
    date_default_timezone_set('PRC');
    function get_file_suffix($file_name, $allow_type = array())
{
  $fnarray=explode('.', $file_name);
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
    \Widget\User::alloc()->to($user);
    if ($user->hasLogin()) {
if ($_GET["url"] == 'post' || $_GET["url"] == 'page')
{
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
    if (get_file_suffix($attachment->attachment->url,$allow)){
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