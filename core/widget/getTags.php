<?php
header("HTTP/1.1 200 OK");
    header("Access-Control-Allow-Origin: *");
    date_default_timezone_set('PRC');
error_reporting(0);
ob_clean();
function tags_api() {
    $page = max(1, isset($_GET['page']) ? intval($_GET['page']) : 1);
    $perPage = 50;
    $db = Typecho_Db::get();
    $tags = $db->fetchAll($db->select()
        ->from('table.metas')
        ->where('type = ?', 'tag')
        ->page($page, $perPage)
        ->order('mid', Typecho_Db::SORT_DESC));

    $query = $db->fetchAll($db->select()
        ->from('table.metas')
        ->where('type = ?', 'tag')
        ->order('mid', Typecho_Db::SORT_DESC));
    $total = count($query);

    $arr = array();
foreach($tags as $value){
    $val = \Typecho\Widget::widget('Widget\Base\Metas')->push($value);
$arr[] = $val;
}

    header('Content-Type: application/json');
    echo json_encode([
        'tags' => $arr,
        'total' => $total,
        'currentPage' => $page
    ]);
    exit;
}

    tags_api();
?>