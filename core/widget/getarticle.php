<?php
header("HTTP/1.1 200 OK");
    header("Access-Control-Allow-Origin: *");
    date_default_timezone_set('PRC');

$db = Typecho_Db::get();
$select = $db->select()->from('table.contents');
$keywords = $_GET['keyword'];
$removeChar = ["https://", "http://"]; 
$options = Helper::options();

if(Bsoptions('Search_Way') == '2'){

function splitWords($text) {
    // 匹配中文字符
    $chinesePattern = '/[\x{4e00}-\x{9fa5}]/u';
    // 匹配英文单词
    $englishPattern = '/\b[a-zA-Z]+\b/';
    // 提取中文字符
    preg_match_all($chinesePattern, $text, $chineseMatches);
    $chineseWords = $chineseMatches[0];
    // 提取英文单词
    preg_match_all($englishPattern, $text, $englishMatches);
    $englishWords = $englishMatches[0];
    // 合并结果
    $result = array_merge($chineseWords, $englishWords);
    return $result;
}



    if (stripos($_SERVER['HTTP_REFERER'], str_replace($removeChar, "", $options->siteUrl)) !== false) {
        
$words = splitWords($keywords);
$searchQuery = '';
foreach ($words as $word) {
    $searchQuery .= "table.contents.title LIKE '%{$word}%' OR table.contents.text LIKE '%{$word}%' OR ";
}
$searchQuery = rtrim($searchQuery, ' OR ');

            if ($this->user->hasLogin()) {
                $select->where("table.contents.password IS NULL
                 OR table.contents.password = '' OR table.contents.authorId = ?", $this->user->uid);
            } else {
                $select->where("table.contents.password IS NULL OR table.contents.password = ''");
            }

            $op = $this->db->getAdapter()->getDriver() == 'pgsql' ? 'ILIKE' : 'LIKE';
$result = array(
    'items' => array()
);
$md = new Markdown();
            $r = $db->fetchAll($select->where("({$searchQuery})")
                ->where('table.contents.type = ?', 'post')->where('status = ?','publish')->limit(50));
                if($r){
foreach($r as $val){
$val = Typecho_Widget::widget('Widget_Abstract_Contents')->push($val);
$targetSummary = excerpt($md::convert($val['text']), 10);

$expert = getCustomFields($val['cid'], 'excerpt');
                if($expert){
                    $targetSummary = $expert[0];
                }
$targetSummary = trim( strip_tags($targetSummary));
		$targetSummary = preg_replace('/\\s+/',' ',$targetSummary);
			if(!$targetSummary){
			    $targetSummary = '本篇文章暂无摘要~';
			}
if(strpos($targetSummary, '{bs-hide') !== false || strpos($targetSummary, '[bs-hide') !== false || strpos($targetSummary, '[bshide') !== false || strpos($targetSummary, '[bslogin') !== false){
      $targetSummary = '文章包含隐藏内容，请进入文章内页查看~';
      }

$result['items'][] = array(
	 'url' => $val['permalink'],
	 'article' => $val['title'],
	 'description' => $targetSummary,
	);
	
}
}
else{
   $result['items'][] = array(
	 'url' => "",
	 'article' => "实时搜索数据为空~~~",
	 'description' => "博主暂时没有发布相关内容哦",
	);
}
}
else{
   $result['items'][] = array(
	 'url' => "",
	 'article' => "实时搜索数据为空~~~",
	 'description' => "博主暂时没有发布相关内容哦",
	);
}


        echo json_encode($result);         
                
}



else{
    
    
    
    
     if (stripos($_SERVER['HTTP_REFERER'], str_replace($removeChar, "", $options->siteUrl)) !== false) {
        
        
$searchQuery = '%' . str_replace(' ', '%', $keywords) . '%';
            if ($this->user->hasLogin()) {
                $select->where("table.contents.password IS NULL
                 OR table.contents.password = '' OR table.contents.authorId = ?", $this->user->uid);
            } else {
                $select->where("table.contents.password IS NULL OR table.contents.password = ''");
            }

            $op = $this->db->getAdapter()->getDriver() == 'pgsql' ? 'ILIKE' : 'LIKE';
$result = array(
    'items' => array()
);
$md = new Markdown();
            $r = $db->fetchAll($select->where("table.contents.title {$op} ? OR table.contents.text {$op} ?", $searchQuery, $searchQuery)
                ->where('table.contents.type = ?', 'post')->where('status = ?','publish')->limit(50));
                if($r){
foreach($r as $val){
$val = Typecho_Widget::widget('Widget_Abstract_Contents')->push($val);
$targetSummary = excerpt($md::convert($val['text']), 10);
$expert = getCustomFields($val['cid'], 'excerpt');
                if($expert){
                    $targetSummary = $expert[0];
                }
$targetSummary = trim( strip_tags($targetSummary));
		$targetSummary = preg_replace('/\\s+/',' ',$targetSummary);
			if(!$targetSummary){
			    $targetSummary = '本篇文章暂无摘要~';
			}
if(strpos($targetSummary, '{bs-hide') !== false || strpos($targetSummary, '[bs-hide') !== false || strpos($targetSummary, '[bshide') !== false || strpos($targetSummary, '[bslogin') !== false){
      $targetSummary = '文章包含隐藏内容，请进入文章内页查看~';
      }
      
      
$result['items'][] = array(
	 'url' => $val['permalink'],
	 'article' => $val['title'],
	 'description' => $targetSummary,
	);
	
}
$result['items'][] = array(
	 'url' => "?s=".$_GET['keyword'],
	 'article' => "实时搜索找不到您想要的内容?",
	 'description' => "戳这里查看更多结果",
	);
}
else{
    $result['items'][] = array(
	 'url' => "?s=".$_GET['keyword'],
	 'article' => "实时搜索数据为空~~~",
	 'description' => "可以戳这里手动搜索该关键词",
	);
}
}
else{
    $result['items'][] = array(
	 'url' => "?s=".$_GET['keyword'],
	 'article' => "实时搜索数据获取失败~~~",
	 'description' => "可以戳这里手动搜索该关键词",
	);
}


        echo json_encode($result);         
        
        
        
        
}
?>
