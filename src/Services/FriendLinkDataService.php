<?php
use Typecho\Db;
header("HTTP/1.1 200 OK");
    header("Access-Control-Allow-Origin: *");
    date_default_timezone_set('PRC');
    $options = Helper::options();
    $removeChar = ["https://", "http://"]; 
    Typecho_Widget::widget('Widget_User')->to($user);
    if (strpos($_SERVER['HTTP_REFERER'], str_replace($removeChar, "", $options->siteUrl)) !== false  && $user->hasLogin() && $user->pass('administrator', true)) {   
        $db = \Typecho\Db::get();
        
        //待审核
        if($_POST['type'] == 'waiting'){
            if(empty($_POST['page'])){
    $i = 1;
}
else{
    $i = $_POST['page']; 
}
$total = count($db->fetchAll($db->select()->from('table.bscore_friendlinks')->where('status = ?', 'waiting')->order('id',Typecho\Db::SORT_DESC)));

        $links = $db->fetchAll($db->select()->from('table.bscore_friendlinks')->where('status = ?', 'waiting')->order('id',Typecho\Db::SORT_DESC)->page($i,6));
        $max = ceil($total / 6);
        $result = array(
            'total' => $total,
    'max' => $max,
    'list' => array()
);
    
$result['list'] = $links;
        }
        
        //通过
        if($_POST['type'] == 'approved'){
                         if(empty($_POST['page'])){
    $i = 1;
}
else{
    $i = $_POST['page']; 
}
$total = count($db->fetchAll($db->select()->from('table.bscore_friendlinks')->where('status = ?', 'approved')->order('id',Typecho\Db::SORT_DESC)));
        $links = $db->fetchAll($db->select()->from('table.bscore_friendlinks')->where('status = ?', 'approved')->order('id',Typecho\Db::SORT_DESC)->page($i,6));
             $max = ceil($total / 6);
        $result = array(
            'total' => $total,
    'max' => $max,
    'list' => array()
);

$result['list'] = $links;
        }
        
        
        //拒绝
        if($_POST['type'] == 'reject'){
            if(empty($_POST['page'])){
    $i = 1;
}
else{
    $i = $_POST['page']; 
}
$total = count($db->fetchAll($db->select()->from('table.bscore_friendlinks')->where('status = ?', 'reject')->order('id',Typecho\Db::SORT_DESC)));
        $links = $db->fetchAll($db->select()->from('table.bscore_friendlinks')->where('status = ?', 'reject')->order('id',Typecho\Db::SORT_DESC)->page($i,6));
        $max = ceil($total / 6);
              $result = array(
            'total' => $total,
    'max' => $max,
    'list' => array()
);
$result['list'] = $links;
        }
        
        
        //搜索
        if($_POST['type'] == 'search'){
            if(empty($_POST['page'])){
    $i = 1;
}
else{
    $i = $_POST['page']; 
}
if($_POST['searchval']){
             $searchQuery = '%' . str_replace(' ', '%', $_POST['searchval']) . '%';
       $total = count($db->fetchAll($db->select()->from('table.bscore_friendlinks')->where('friendname LIKE ? ', $searchQuery)->order('id',Typecho\Db::SORT_DESC)));
       $links = $db->fetchAll($db->select()->from('table.bscore_friendlinks')->where('friendname LIKE ? ', $searchQuery)->order('id',Typecho\Db::SORT_DESC)->page($i,6));
       $max = ceil($total / 6);
}
else{
    $total = 0;
    $max = ceil($total / 6);
    $links = array();
}
       $result = array(
           'total' => $total,
    'max' => $max,
    'list' => array()
);
$result['list'] = $links;
        }
        
	echo json_encode($result); 
    }