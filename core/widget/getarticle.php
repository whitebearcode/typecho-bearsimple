<?php
header("HTTP/1.1 200 OK");
    header("Access-Control-Allow-Origin: *");
    date_default_timezone_set('PRC');
error_reporting(0);

            Typecho_Widget::widget('Widget_Contents_Post_Recent', 'pageSize=10000000000000000000000000')->to($archives); 
    $options = Helper::options();
            $result = array(
    'items' => array()
);

    $removeChar = ["https://", "http://", "/"]; 
    if (stripos($_SERVER['HTTP_REFERER'], str_replace($removeChar, "", $options->siteUrl)) !== false) {   
               while($archives->next()):   
     
                 if (stripos($archives->title, $_GET['keyword']) !== false) {   
       	$result['items'][] = array(
	 'url' => $archives->permalink,
	 'article' => $archives->title,
	 'description' => excerpt_content(strip_tags(mb_strcut($archives->excerpt,0,60))),
	);
             
              
       }       
    endwhile;   
  
$result['items'][] = array(
	 'url' => "?s=".$_GET['keyword'],
	 'article' => "实时搜索找不到您想要的内容?",
	 'description' => "戳这里查看更多结果",
	);
    }
    else{
        $result['items'][] = array(
	 'url' => "?s=".$_GET['keyword'],
	 'article' => "实时搜索数据获取失败~~~",
	 'description' => "可以戳这里手动搜索该关键词",
	);
    }
    echo json_encode($result);
?>
