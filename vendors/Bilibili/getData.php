<?php
/**
 * 
 * B站数据获取
 * Template:Bearsimple
 * Date:2022/01/11
 * 
**/
header("HTTP/1.1 200 OK");
    header("Access-Control-Allow-Origin: *");
    date_default_timezone_set('PRC');
error_reporting(0);
function getData(){
    //验证传值
if ($_GET['type'] !== 'acg')
{
    $result = array('code'=> '-1','message'=>'The pass-through value is wrong.');
echo json_encode($result); 
exit;
} 
//验证传值
if (is_numeric($_GET['page']) == false)
{
$result = array('code'=> '-1','message'=>'The pass-through value is wrong.');
echo json_encode($result); 
exit;
} 
$options = Typecho_Widget::widget('Widget_Options');
$str = $options->bilibili_accountid;
    $status = json_decode(file_get_contents('https://api.bilibili.com/x/space/bangumi/follow/list?vmid='.$str.'&type=1&follow_status=0&pn=1&ps=6'),true);
$max = ceil($status['data']['total'] / 6);
$total = $status['data']['total'];
$result = array(
    'total' => $total,
    'max' => $max,
    'list' => array()
);
if(empty($_GET['page'])){
    $i = 1;
}
else{
    $i = $_GET['page']; 
}
                $info = json_decode(file_get_contents('https://api.bilibili.com/x/space/bangumi/follow/list?vmid='.$str.'&type=1&follow_status=0&pn='.$i.'&ps=6'),true);
                foreach ($info['data']['list'] as $data) {
                    if($data["subtitle"] == 'null'){
                       $data["subtitle"] = '番名就是最好的简介';
                    }
                    if($data["subtitle"] == ''){
                       $data["subtitle"] = '番名就是最好的简介';
                    }
                   	$result['list'][] = array(
	 'url' => $data["url"],
	 'cover' => $data["cover"],
	 'title' => $data["title"],
	 'subtitle_14' => $data["subtitle"],
'is_finish' => $data["is_finish"]
	);
       
}
echo json_encode($result); 
}
getData();
?>
