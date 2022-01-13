<?php
/**
 * 
 * 豆瓣数据获取
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
if (empty($_GET['type']))
{
    $result = array('code'=> '-1','message'=>'The pass-through value is wrong.');
echo json_encode($result); 
exit;
} 
$options = Typecho_Widget::widget('Widget_Options');
$doubantype = $_GET['dbtype'];
$type = '';
switch($doubantype){
    case 'book':
switch($_GET['type'])
{
    case '1' : $type = $options->douban_book1;break;
    case '2' : $type = $options->douban_book2;break;
    case '3' : $type = $options->douban_book3;break;
    default:;
}
$result = array(
    'total'=>count(getDoubanId($type)),
    'list' => array()
);

         foreach(getDoubanId($type) as $id){
             $Getdata = douban_getdata($id,'book');
                   	$result['list'][] = array(
	 'url' => $Getdata["url"],
	 'cover' => $Getdata['cover'],
	 'title' => $Getdata['bookname'],
	 'author' => $Getdata['author'],
	);
       
}
break;
    case 'movie':
switch($_GET['type'])
{
    case '1' : $type = $options->douban_movie1;break;
    case '2' : $type = $options->douban_movie2;break;
    case '3' : $type = $options->douban_movie3;break;
    default:;
}
$result = array(
    'total'=>count(getDoubanId($type)),
    'list' => array()
);

         foreach(getDoubanId($type) as $id){
             $Getdata = douban_getdata($id,'movie');
                   	$result['list'][] = array(
	 'url' => $Getdata["url"],
	 'cover' => $Getdata['cover'],
	 'title' => $Getdata['moviename'],
	 'summary' => $Getdata['summary'],
	);
       
}
break;
    case 'music':
switch($_GET['type'])
{
    case '1' : $type = $options->douban_music1;break;
    case '2' : $type = $options->douban_music2;break;
    case '3' : $type = $options->douban_music3;break;
    default:;
}
$result = array(
    'total'=>count(getDoubanId($type)),
    'list' => array()
);

         foreach(getDoubanId($type) as $id){
             $Getdata = douban_getdata($id,'music');
                   	$result['list'][] = array(
	 'url' => $Getdata["url"],
	 'cover' => $Getdata['cover'],
	 'title' => $Getdata['musicname'],
	 'singer' => $Getdata['singer'],
	);
       
}
break;
}
echo json_encode($result); 
}
getData();
?>
