<?php
header("HTTP/1.1 200 OK");
header("Access-Control-Allow-Origin: *");
date_default_timezone_set('PRC');

$db = Typecho_Db::get();
$options = Helper::options();
$result = ['items' => []];

$keywords = isset($_GET['keyword']) ? trim(strip_tags($_GET['keyword'])) : '';
$searchWay = Bsoptions('Search_Way') ?? '1'; 

$isInternal = false;
if (!empty($_SERVER['HTTP_REFERER']) && !empty($options->siteUrl)) {
    $siteDomain = parse_url($options->siteUrl, PHP_URL_HOST);
    $refDomain = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
    $isInternal = ($siteDomain && $refDomain && 
                  strtolower($siteDomain) === strtolower($refDomain));
}

function buildLikeParam($value) {
    return '%' . str_replace(['%', '_'], ['\%', '\_'], $value) . '%';
}

function getPostUrlByCid($cid) {
    $post = Typecho_Widget::widget('Widget_Archive@post_'.$cid, 'type=post', 'cid='.$cid);
    return $post->permalink;
}

// 智能分词处理
function tokenizeKeywords($text) {
    $tokens = [];

    $langMix = (preg_match('/[\x{4e00}-\x{9fa5}]/u', $text) && preg_match('/[a-zA-Z]/', $text));
    $minLen = $langMix ? 2 : 3; 

    // 提取中文字符
    if (preg_match_all('/[\x{4e00}-\x{9fa5}]/u', $text, $matches)) {
        $tokens = array_merge($tokens, $matches[0]);
    }

    if (preg_match_all("/\b\w{{$minLen},}\b/u", $text, $matches)) {
        $tokens = array_merge($tokens, $matches[0]);
    }
    
    // 提取数字
    if (preg_match_all('/\b\d+\b/', $text, $matches)) {
        $tokens = array_merge($tokens, $matches[0]);
    }

    if (empty($tokens)) {
        $tokens[] = $text;
    }

    return array_unique($tokens);
}

function generateSummary($content, $cid = 0) {
    if ($cid > 0) {
        $excerpts = getCustomFields($cid, 'excerpt');
        if (!empty($excerpts[0])) {
            return trim($excerpts[0]);
        }
    }

    $hidePatterns = [
        '/\{bs-hide[^\}]*\}/is',
        '/\[bs-hide[^\]]*\]/is',
        '/<blockhide[^>]*>.*?<\/blockhide>/is',
        '/\[bslogin[^\]]*\]/is'
    ];
    
    $cleanContent = preg_replace($hidePatterns, '', $content);

    if (class_exists('Markdown')) {
        $md = new Markdown();
        $cleanContent = $md::convert($cleanContent);
    }

    $plainText = trim(strip_tags($cleanContent));
    $plainText = preg_replace('/\s+/', ' ', $plainText);
    
    if (empty($plainText)) {
        return '本篇文章暂无摘要~';
    }

    $maxLen = (preg_match('/[\x{4e00}-\x{9fa5}]/u', $plainText)) ? 100 : 150;
    return Typecho_Common::subStr($plainText, 0, $maxLen, '...');
}

try {
    if (empty($keywords)) {
        throw new Exception('请输入搜索关键词');
    }

    if (!$isInternal) {
        throw new Exception('请求来源不安全，拒绝服务');
    }

    $select = $db->select()->from('table.contents')
     ->where('type = ?', 'post')
     ->where('status = ?', 'publish')
     ->limit(50);
    if ($this->user->hasLogin()) {
        $select->where('(password IS NULL OR password = \'\' OR authorId = ?)', 
                     intval($this->user->uid));
    } else {
        $select->where('(password IS NULL OR password = \'\')');
    }

    if ($searchWay == '1') {
        $likeParam = buildLikeParam($keywords);
        $select->where('(title LIKE ? OR text LIKE ?)', $likeParam, $likeParam);
    } 
    else {
        $tokens = tokenizeKeywords($keywords);
        
        $conditions = [];
        $params = [];
        
        foreach ($tokens as $token) {
            $likeToken = buildLikeParam($token);
            $conditions[] = '(title LIKE ? OR text LIKE ?)';
            $params[] = $likeToken;
            $params[] = $likeToken;
        }
        
        $select->where('(' . implode(' OR ', $conditions) . ')', ...$params);
    }

    $posts = $db->fetchAll($select);
   
    if (!empty($posts)) {
        foreach ($posts as $post) {
     
 $permalink = getPostUrlByCid($post['cid']);
            $summary = generateSummary($post['text'], $post['cid']);
            
            $result['items'][] = [
                'url' => $permalink,
                'article' => htmlspecialchars($post['title']),
                'description' => htmlspecialchars($summary)
            ];
        }
        
        if (count($posts) >= 20) {
            $result['items'][] = [
                'url' => $options->index . "?s=" . urlencode($keywords),
                'article' => "查看更多结果",
                'description' => "点击查看完整搜索结果"
            ];
        }
    } else {
        $result['items'][] = [
            'url' => $options->index . "?s=" . urlencode($keywords),
            'article' => "未找到相关内容",
            'description' => "尝试站内完整搜索"
        ];
    }

} catch (Exception $e) {
    $result['items'][] = [
        'url' => $options->index . "?s=" . urlencode($keywords),
        'article' => "搜索处理出错",
        'description' => $e->getMessage()
    ];
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);