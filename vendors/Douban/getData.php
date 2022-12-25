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
$options = bsOptions::getInstance()::get_option( 'bearsimple' );
$doubantype = $_GET['dbtype'];
$type = '';
switch($doubantype){
    case 'book':
        $rating_status = $options['douban_rating'];
switch($_GET['type'])
{
    case '1' : $type = $options['douban_book1'];$max = ceil(count(getDoubanId($type)) / 6);break;
    case '2' : $type = $options['douban_book2'];$max = ceil(count(getDoubanId($type)) / 6);break;
    case '3' : $type = $options['douban_book3'];$max = ceil(count(getDoubanId($type)) / 6);break;
    default:;
}
$result = array(
    'total'=>count(getDoubanId($type)),
    'max' => $max,
    'rating_status' => $rating_status,
    'list' => array()
);
$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = !empty($_GET['limit']) ? (int)$_GET['limit'] : 6;
$page < 1 && $page = 1;
$limit < 6 && $limit = 6;
$result['list'] = page_fetch('book', getDoubanId($type), $page, $limit,$_GET['type']);
break;
    case 'movie':
        $rating_status = $options['douban_movie_rating'];
switch($_GET['type'])
{
    case '1' : $type = $options['douban_movie1']; $max = ceil(count(getDoubanId($type)) / 6);break;
    case '2' : $type = $options['douban_movie2']; $max = ceil(count(getDoubanId($type)) / 6);break;
    case '3' : $type = $options['douban_movie3']; $max = ceil(count(getDoubanId($type)) / 6);break;
    default:;
}
$result = array(
    'total'=>count(getDoubanId($type)),
    'max' => $max,
    'rating_status' => $rating_status,
    'list' => array()
);
$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = !empty($_GET['limit']) ? (int)$_GET['limit'] : 6;
$page < 1 && $page = 1;
$limit < 6 && $limit = 6;
$result['list'] = page_fetch('movie', getDoubanId($type), $page, $limit,$_GET['type']);
break;
    case 'music':
        $rating_status = $options['douban_music_rating'];
switch($_GET['type'])
{
    case '1' : $type = $options['douban_music1'];$max = ceil(count(getDoubanId($type)) / 6);break;
    case '2' : $type = $options['douban_music2'];$max = ceil(count(getDoubanId($type)) / 6);break;
    case '3' : $type = $options['douban_music3'];$max = ceil(count(getDoubanId($type)) / 6);break;
    default:;
}
$result = array(
    'total'=>count(getDoubanId($type)),
    'max' => $max,
    'rating_status' => $rating_status,
    'list' => array()
);
$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = !empty($_GET['limit']) ? (int)$_GET['limit'] : 6;
$page < 1 && $page = 1;
$limit < 6 && $limit = 6;
$result['list'] = page_fetch('music', getDoubanId($type), $page, $limit,$_GET['type']);
break;
}

echo json_encode($result); 
}
getData();
?>
