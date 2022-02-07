<?php
require_once('extend/ChinesePinyin.class.php');
function excerpt($content, $limit)
    {
        if($limit == 0) {
            return "";
        } else {
            $content = excerpt_content($content);
            if (trim($content) == "") {
                return "暂时没有可提供的摘要";
            } else {
                return Typecho_Common::subStr(strip_tags($content), 0, $limit, "...");
            }
        }
    }
 
 function excerpt_content($content)
    {
        if (strpos($content, '[bsgallery') !== false) {
            $pattern = get_shortcode_regex(array('bsgallery'));
            $content = preg_replace("/$pattern/", '', $content);
        }
        if (strpos($content, '[bsgit') !== false) {
            $pattern = get_shortcode_regex(array('bsgit'));
            $content = preg_replace("/$pattern/", '', $content);
        }
        if (strpos($text, '[todo-t') !== false) {
            $pattern = get_shortcode_regex(array('todo-t'));
            $text = preg_replace("/$pattern/", '', $text);
        }
        if (strpos($text, '[todo-f') !== false) {
            $pattern = get_shortcode_regex(array('todo-f'));
            $text = preg_replace("/$pattern/", '', $text);
        }
        if (strpos($content, '[bseva') !== false) {
            $pattern = get_shortcode_regex(array('bseva'));
            $content = preg_replace("/$pattern/", '', $content);
        }
        if (strpos($content, '[bsaudio') !== false) {
            $pattern = get_shortcode_regex(array('bsaudio'));
            $content = preg_replace("/$pattern/", '', $content);
        }
        if (strpos($content, '[bspost') !== false) {
            $pattern = get_shortcode_regex(array('bspost'));
            $content = preg_replace("/$pattern/", '', $content);
        }
        if (strpos($content, '[bsruby') !== false) {
            $pattern = get_shortcode_regex(array('bsruby'));
            $content = preg_replace("/$pattern/", '', $content);
        }
        if (strpos($content, '[bsprog') !== false) {
            $pattern = get_shortcode_regex(array('bsprog'));
            $content = preg_replace("/$pattern/", '', $content);
        }
        if (strpos($content, '[bsmark') !== false) {
            $pattern = get_shortcode_regex(array('bsmark'));
            $content = preg_replace("/$pattern/", '', $content);
        }
        if (strpos($content, '[bsbtn') !== false) {
            $pattern = get_shortcode_regex(array('bsbtn'));
            $content = preg_replace("/$pattern/", '', $content);
        }
        if (strpos($content, '[bsmessage') !== false) {
            $pattern = get_shortcode_regex(array('bsmessage'));
            $content = preg_replace("/$pattern/", '', $content);
        }
        if (strpos($content, '{bs-hide') !== false) {
            $pattern = get_shortcode_regex2(array('bs-hide'));
            $content = preg_replace("/$pattern/", '', $content);
        }
        if (strpos($content, '{bs-todo') !== false) {
            $pattern = get_shortcode_regex2(array('bs-todo'));
            $content = preg_replace("/$pattern/", '', $content);
        }
        if (strpos($content, '{bs-accord') !== false) {
            $pattern = get_shortcode_regex2(array('bs-accord'));
            $content = preg_replace("/$pattern/", '', $content);
        }
        if (strpos($content, '{bs-font') !== false) {
            $pattern = get_shortcode_regex2(array('bs-font'));
            $content = preg_replace("/$pattern/", '', $content);
        }
        if (strpos($content, '{bs-iframe') !== false) {
            $pattern = get_shortcode_regex2(array('bs-iframe'));
            $content = preg_replace("/$pattern/", '', $content);
        }
        if (strpos($content, '{bs-card') !== false) {
            $pattern = get_shortcode_regex2(array('bs-card'));
            $content = preg_replace("/$pattern/", '', $content);
        }
        if (strpos($content, '{bs-audio') !== false) {
            $pattern = get_shortcode_regex2(array('bs-audio'));
            $content = preg_replace("/$pattern/", '', $content);
        }

        return $content;
    }
    
function get_shortcode_atts_regex()
    {
        return '/([\w-]+)\s*=\s*"([^"]*)"(?:\s|$)|([\w-]+)\s*=\s*\'([^\']*)\'(?:\s|$)|([\w-]+)\s*=\s*([^\s\'"]+)(?:\s|$)|"([^"]*)"(?:\s|$)|\'([^\']*)\'(?:\s|$)|(\S+)(?:\s|$)/';
    }
    
function shortcode_parse_atts($text)
    {
        $atts = array();
        $pattern = get_shortcode_atts_regex();
        $text = preg_replace("/[\x{00a0}\x{200b}]+/u", ' ', $text);
        if (preg_match_all($pattern, $text, $match, PREG_SET_ORDER)) {
            foreach ($match as $m) {
                if (!empty($m[1])) {
                    $atts[strtolower($m[1])] = stripcslashes($m[2]);
                } elseif (!empty($m[3])) {
                    $atts[strtolower($m[3])] = stripcslashes($m[4]);
                } elseif (!empty($m[5])) {
                    $atts[strtolower($m[5])] = stripcslashes($m[6]);
                } elseif (isset($m[7]) && strlen($m[7])) {
                    $atts[] = stripcslashes($m[7]);
                } elseif (isset($m[8]) && strlen($m[8])) {
                    $atts[] = stripcslashes($m[8]);
                } elseif (isset($m[9])) {
                    $atts[] = stripcslashes($m[9]);
                }
            }
            foreach ($atts as &$value) {
                if (false !== strpos($value, '<')) {
                    if (1 !== preg_match('/^[^<]*+(?:<[^>]*+>[^<]*+)*+$/', $value)) {
                        $value = '';
                    }
                }
            }
        } else {
            $atts = ltrim($text);
        }
        return $atts;
    }
    


function get_shortcode_regex($tagnames = null)
    {
        global $shortcode_tags;
        if (empty($tagnames)) {
            $tagnames = array_keys($shortcode_tags);
        }
        $tagregexp = join('|', array_map('preg_quote', $tagnames));
        return
            '\\['                           
            . '(\\[?)'                        
            . "($tagregexp)"       
            . '(?![\\w-])'                    
            . '('                         
            . '[^\\]\\/]*'               
            . '(?:'
            . '\\/(?!\\])'     
            . '[^\\]\\/]*'          
            . ')*?'
            . ')'
            . '(?:'
            . '(\\/)'                    
            . '\\]'           
            . '|'
            . '\\]'              
            . '(?:'
            . '('       
            . '[^\\[]*+'  
            . '(?:'
            . '\\[(?!\\/\\2\\])'
            . '[^\\[]*+'
            . ')*+'
            . ')'
            . '\\[\\/\\2\\]'    
            . ')?'
            . ')'
            . '(\\]?)'; 
    }

function get_shortcode_regex2($tagnames = null)
    {
        global $shortcode_tags;
        if (empty($tagnames)) {
            $tagnames = array_keys($shortcode_tags);
        }
        $tagregexp = join('|', array_map('preg_quote', $tagnames));
        return
            '\\{'                           
            . '(\\[?)'                        
            . "($tagregexp)"       
            . '(?![\\w-])'                    
            . '('                         
            . '[^\\]\\/]*'               
            . '(?:'
            . '\\/(?!\\])'     
            . '[^\\]\\/]*'          
            . ')*?'
            . ')'
            . '(?:'
            . '(\\/)'                    
            . '\\}'           
            . '|'
            . '\\}'              
            . '(?:'
            . '('       
            . '[^\\[]*+'  
            . '(?:'
            . '\\[(?!\\/\\2\\])'
            . '[^\\[]*+'
            . ')*+'
            . ')'
            . '\\[\\/\\2\\}'    
            . ')?'
            . ')'
            . '(\\]?)'; 
    }
    
//引用文章回调
function quotePostCallback($matches){
        $attr = htmlspecialchars_decode($matches[3]);
        $attrs = shortcode_parse_atts($attr);
        $cid = @$attrs["cid"];
        $url = @$attrs['url'];
        $targetTitle = "";
        $targetUrl = "";
        $targetSummary = "";
        $targetDate = "";
        if (!empty($cid)){
            $db = Typecho_Db::get();
            $prefix = $db->getPrefix();
            $posts = $db->fetchAll($db
                ->select()->from($prefix . 'contents')
                ->orWhere('cid = ?', $cid)
                ->where('type = ? AND status = ? AND password IS NULL', 'post', 'publish'));
            if (count($posts) == 0) {
                $targetTitle = "文章不存在或文章存在密码";
                $targetUrl = '#';
                $targetDate = '';
            }else{
                $result = Typecho_Widget::widget('Widget_Abstract_Contents')->push($posts[0]);
                $targetSummary = excerpt($result['text'], 60);
                $targetTitle = $result['title'];
                $targetUrl = $result['permalink'];
                $targetDate = date('Y-m-d H:m:s',$result['created']);
            }
        }else {
            $targetTitle = "文章不存在";
            $targetUrl = '#';
            $targetDate ='';
        }
        return <<<EOF
<div class="ui fluid link card" hrefs="{$targetUrl}" style="margin:auto">
<div class="content">
<div class="header">{$targetTitle}</div>
<div class="meta">{$targetDate}</div>
<div class="description">
 {$targetSummary}
</div>
</div>
</div>
EOF;
    }

//按钮回调
function parseButtonCallback($matches)
    {
        $matches[3] = preg_replace("/<a href=.*?>(.*?)<\/a>/",'$1',$matches[3]);
        $attr = htmlspecialchars_decode($matches[3]);
        $attrs = shortcode_parse_atts($attr);
        $type = "";
        $color = "primary";
        $icon = "";
        $linkUrl = "";
        if (@$attrs['type'] == "common") {
            $type = "button";
        }
        elseif (@$attrs['type'] == "basic") {
            $type = "basic button";
        }
        elseif (@$attrs['type'] == "animated") {
            $type = "animated fade button";
            $name = explode('|',$matches[5]);
            $name1 = $name[0];
            $name2 = $name[1];
        }
        if (@$attrs['url'] != "") {
            $linkUrl = 'window.open("' . $attrs['url'] . '","_blank")';
        }
        if (@$attrs['color'] != "") {
            $color = $attrs['color'];
        }
        if (@$attrs['icon'] != "") {
            $icon = '<i class="' . $attrs['icon'] .' icon'. '"></i>';
        }
 if (@$attrs['type'] == "animated") {
 return <<<EOF
<button class="ui {$color} {$type}" style="margin-top:5px" onclick='{$linkUrl}' tabindex="0">
  <div class="visible content">{$icon}{$name1}</div>
  <div class="hidden content">
   {$name2}
  </div>
</button>
EOF;
 }
 else{
        return <<<EOF
<button class="ui {$color} {$type}" style="margin-top:5px" onclick='{$linkUrl}'>{$icon}{$matches[5]}</button>
EOF;
}
    }

//信息提示框回调
function parseMessageCallback($matches)
    {
        $matches[3] = preg_replace("/<a href=.*?>(.*?)<\/a>/",'$1',$matches[3]);
        $attr = htmlspecialchars_decode($matches[3]);
        $attrs = shortcode_parse_atts($attr);
        $type = "";
        $color = "";
        $icon = "";
        
        if (@$attrs['type'] == "commonclose" || @$attrs['type'] == 'basicclose') {
            $close = '<i class="close icon"></i>';
        }
        
        if (@$attrs['type'] == "basic" || @$attrs['type'] == "basicclose") {
            $type = 'floating';
        }
        
        if (@$attrs['icon'] != "") {
            $types = 'icon';
            $att = '<div class="content">';
            $atts = '</div>';
        }
        if (@$attrs['title'] != "") {
            $title = '<div class="header">'.$attrs['title'].'</div>';
        }
        
        if (@$attrs['color'] != "") {
            $color = $attrs['color'];
        }
        if (@$attrs['icon'] != "") {
            $icon = '<i class="' . $attrs['icon'] .' icon'. '"></i>';
        }

        return <<<EOF
<div class="ui {$color} {$type} {$types} message">
{$icon}
  {$close}
  {$att}
    {$title}
  <p>
{$matches[5]}
  </p>
</div>
{$atts}
EOF;
    }
    
function parseRubyCallback($matches){
    $Pinyin = new ChinesePinyin();
    $arr = preg_split("//u", $matches[5], -1,PREG_SPLIT_NO_EMPTY);
    $results = '<ruby>';
    foreach($arr as $po){
$results .= $po.'<rp>(</rp><rt>'.$Pinyin->TransformWithTone($po).'</rt><rp>)</rp>';
}
$results .= '</ruby>';
 return $results;
}

function curl_get($url){
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/64.0.3282.186 Safari/537.36');
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
$result = curl_exec($ch);
return $result;
    }
    
//Github仓库回调
function parseGithubCallback($matches)
    {
        $attr = htmlspecialchars_decode($matches[3]);
        $attrs = shortcode_parse_atts($attr);
        $result = json_decode(curl_get('https://api.github.com/repos/'.$attrs['user'].'/'.$matches[5]),true);
        if(@$result['full_name'] == ''){
            $result['full_name'] = '未获取到Github信息';
        }
        if(@$result['pushed_at'] == ''){
        $date = '未获取到Github项目更新日期';    
            }else{
        $date = '更新于'.date('Y-m-d H:m:s',strtotime($result['pushed_at']));
        }
        return <<<EOF
        <div class="ui relaxed divided list" style="margin:auto"><div class="item"><i class="large github middle aligned icon"></i><div class="content"><a class="header" href="{$result['html_url']}" title="{$result['description']}">{$result['full_name']}</a><div class="description">{$date}</div></div></div></div>
EOF;
    }

//进度条回调
function parseProgressCallback($matches)
{
        $attr = htmlspecialchars_decode($matches[3]);
        $attrs = shortcode_parse_atts($attr);
        $progress = '';
        if(@$attrs['number'] !== ''){
            $progress = $attrs['number'];
        }
        if(@$attrs['color'] !== ''){
            $color = 'bg-'.$attrs['color'];
        }
        return <<<EOF
        <div class="bstools" bstitle="{$matches[5]}"></div>
        <div class="progress" style="height: 20px;">
<div class="progress-bar {$color} progress-bar-striped progress-bar-animated" role="progressbar" style="width: {$progress}%;" aria-valuenow="{$progress}" aria-valuemin="0" aria-valuemax="100">{$progress}%</div>
</div>
EOF;
}
//Audio回调
function parseAudioCallback($matches)
{
        $matches[5] = preg_replace("/<a href=.*?>(.*?)<\/a>/",'$1',$matches[5]);
    return <<<EOF
    <audio src="{$matches[5]}" controls="controls">您的浏览器不支持播放此音频</audio>
EOF;

}

//评星回调
function parseEvaluationCallback($matches)
{
        $attr = htmlspecialchars_decode($matches[3]);
        $attrs = shortcode_parse_atts($attr);
        if($matches[5] > 5){
            $matches[5] = '5';
        }
        else{
           $matches[5] =  $matches[5];
        }
    return <<<EOF
    <div class="ui {$attrs['type']} rating" style="pointer-events: none;" data-rating="$matches[5]" data-max-rating="5"></div>
EOF;

}

//相册回调
function parseGalleryCallback($matches)
{
    $matches[5] = preg_replace("/<a href=.*?>(.*?)<\/a>/",'$1',$matches[5]);
    $matches[3] = preg_replace("/<a href=.*?>(.*?)<\/a>/",'$1',$matches[3]);
        $attr = htmlspecialchars_decode($matches[3]);
        $attrs = shortcode_parse_atts($attr);
        if(@$attrs['title'] == ''){
            $attrs['title'] = '新建相册';
        }
        else{
           $attrs['title'] = $attrs['title']; 
        }
        $matches[5] = preg_replace("/\[bsimg title=\"(.*?)\" subtitle=\"(.*?)\"\](.*?)\[\/bsimg\]/sm",'<li class="bsgallery__item"><div class="bsgallery__item__image__wrapper"><img class="bearmark bsgallery__item__image" src="$3" alt="$1"/></div><div class="bsgallery__item__description"><font size="3"  class="bsgallery__item__title bstools" bstitle="$1"></font><font size="2" class="bsgallery__item__subtitle bstools" bstitle="$2"></font></div></li>',$matches[5]);
    return <<<EOF
    <div class="bsgallery__container">
  <div class="bsgallery__wrapper">
    <div class="bsgallery__header">
    <font size="4" class="bsgallery__headline bstools" bstitle="{$attrs['title']}"><i class="images outline icon"></i></font>
      <div class="bsgallery__arrows"><a class="arrow disabled arrow-prev"></a><a class="arrow arrow-next"></a></div>
    </div>
    <bsgalleryul class="bsgallery">
    {$matches[5]}
      </bsgalleryul>
  </div>
  </div>

EOF;

}

//相册回调2
function parseGallery2Callback($matches)
{
    $matches[5] = preg_replace("/<a href=.*?>(.*?)<\/a>/",'$1',$matches[5]);
    $matches[3] = preg_replace("/<a href=.*?>(.*?)<\/a>/",'$1',$matches[3]);
        $attr = htmlspecialchars_decode($matches[3]);
        $attrs = shortcode_parse_atts($attr);
        if(@$attrs['title'] == ''){
            $attrs['title'] = '新建相册';
        }
        else{
           $attrs['title'] = $attrs['title']; 
        }
        $matches[5] = preg_replace("/\[bsimg title=\"(.*?)\" subtitle=\"(.*?)\"\](.*?)\[\/bsimg\]/sm",'<li class="bsgallery__item"><div class="bsgallery__item__image__wrapper"><a href="$3" data-fancybox="'.$attrs['title'].'"><img class="bsgallery__item__image" src="$3" alt="$1"/></a></div><div class="bsgallery__item__description"><font size="1"  class="bsgallery__item__title bstools" bstitle="$1"></font><font size="1" class="bsgallery__item__subtitle bstools" bstitle="$2"></font></div></li>',$matches[5]);
    return <<<EOF
    <div class="bsgallery__container">
  <div class="bsgallery__wrapper">
    <bsgalleryul class="bsgallery">
    {$matches[5]}
      </bsgalleryul>
  </div>
  </div>

EOF;

}

function ParseCross($content){
   if (strpos($content, '[bsimg') !== false) {
        $content = preg_replace('/\[bsimg\](.*?)\[\/bsimg\]/sm', '<a href="$1" data-fancybox="$1"><img src="$1"></a>', $content);
   }
       //标注
   if (strpos($content, '[bsmark') !== false) {
        $content = preg_replace('/\[bsmark\](.*?)\[\/bsmark\]/sm', '<mark class="text-highlight">$1</mark>', $content);
   }
       //拼音
    if (strpos($content, '[bsruby') !== false) {
            $pattern = get_shortcode_regex(array('bsruby'));
            $content = preg_replace_callback("/$pattern/", 'parseRubyCallback', $content);
        }
        //相册
    if (strpos($content, '[bsgallery') !== false) {
            $pattern = get_shortcode_regex(array('bsgallery'));
            $content = preg_replace_callback("/$pattern/", 'parseGallery2Callback', $content);
    }
        if (strpos($content, '[bsimg') == false && strpos($content, '[bsgallery') == false) {
    $pattern = '/\<img.*?src\=\"(.*?)\"[^>]*>/i';
 $replacement = '<a href="$1" data-fancybox="$1"><img src="$1"></a>'; 
    $content = preg_replace($pattern, $replacement, $content);
    }
   return $content;
}

function ShortCode($post,$t,$login,$modetype='noreadmode'){
    $options = Helper::options();
    $content = $post;
    //相册
    if (strpos($content, '[bsgallery') !== false) {
            $pattern = get_shortcode_regex(array('bsgallery'));
            $content = preg_replace_callback("/$pattern/", 'parseGalleryCallback', $content);
    }
    else{
           
    if ($options->Lightbox == '1' || $options->Watermark == '1'){
    $pattern = '/\<img.*?src\=\"(.*?)\"[^>]*>/i';
   
 $replacement = '
<img src="$1" class="bearmark" referrerPolicy="no-referrer"  alt="'.$t->title.'" title="点击放大图片">'; 
    $content = preg_replace($pattern, $replacement, $content);
   

    }
    
    }
    //进度条
    if (strpos($content, '[bsprog') !== false) {
            $pattern = get_shortcode_regex(array('bsprog'));
            $content = preg_replace_callback("/$pattern/", 'parseProgressCallback', $content);
    }
     //Audio
    if (strpos($content, '[bsaudio') !== false) {
            $pattern = get_shortcode_regex(array('bsaudio'));
            $content = preg_replace_callback("/$pattern/", 'parseAudioCallback', $content);
    }
    //评星
    if (strpos($content, '[bseva') !== false) {
            $pattern = get_shortcode_regex(array('bseva'));
            $content = preg_replace_callback("/$pattern/", 'parseEvaluationCallback', $content);
    }
    //Github库
    if (strpos($content, '[bsgit') !== false) {
            $pattern = get_shortcode_regex(array('bsgit'));
            $content = preg_replace_callback("/$pattern/", 'parseGithubCallback', $content);
        }
    //拼音
    if (strpos($content, '[bsruby') !== false) {
            $pattern = get_shortcode_regex(array('bsruby'));
            $content = preg_replace_callback("/$pattern/", 'parseRubyCallback', $content);
        }
        

    //标注
   if (strpos($content, '[bsmark') !== false) {
        $content = preg_replace('/\[bsmark\](.*?)\[\/bsmark\]/sm', '<mark class="text-highlight">$1</mark>', $content);
   }
   
    //解析显示按钮短代码
    if (strpos($content, '[bsbtn') !== false) {
            $pattern = get_shortcode_regex(array('bsbtn'));
            $content = preg_replace_callback("/$pattern/", 'parseButtonCallback', $content);
        }
    
    //解析显示信息提示框短代码
    if (strpos($content, '[bsmessage') !== false) {
            $pattern = get_shortcode_regex(array('bsmessage'));
            $content = preg_replace_callback("/$pattern/", 'parseMessageCallback', $content);
        }
        
    //引用文章
    if (strpos($content, '[bspost') !== false) {
            $pattern = get_shortcode_regex(array('bspost'));
            $content = preg_replace_callback("/$pattern/", 'quotePostCallback', $content);
        }
    
    //登录可见
            if (strpos($content, '[bslogin') !== false) {
                $pattern = get_shortcode_regex(array('bslogin'));
                $content = preg_replace_callback("/$pattern/", function ($matches) use ($login) {
                    if ($matches[1] == '[' && $matches[6] == ']') {
                        return substr($matches[0], 1, -1);
                    }
                    if ($login) {
                         return '<div class="ui floating message">'.$matches[5].'</div>';
                    } else {
                        return '<div class="ui floating message"><i class="thumbtack icon"></i>此处内容需要登录后方可阅读。</div>';
                    }
                }, $content);
            }
    //登录或回复后可见
            if (strpos($content, '[bshide') !== false) {
                $pattern = get_shortcode_regex(array('bshide'));
                $db = Typecho_Db::get();
        $hasComment = $db->fetchAll($db->select()->from('table.comments')->where('cid = ?', $t->cid)->where('status = ?', 'approved')->where('mail = ?', $t->remember('mail', true))->limit(1));
        if(count($hasComment) !== 0){
            $hasComments = count($hasComment);
        }
        else{
            $hasComments = 0;
        }
                $content = preg_replace_callback("/$pattern/", function ($matches) use ($login,$hasComments) {
                    if ($matches[1] == '[' && $matches[6] == ']') {
                        return substr($matches[0], 1, -1);
                    }
                    if ($login || $hasComments !== 0) {
                         return '<div class="ui floating message">'.$matches[5].'</div>';
                    } else {
                        return '<div class="ui floating message"><i class="thumbtack icon"></i>此处内容需要登录或评论回复(审核通过)后方可阅读。</div>';
                    }
                }, $content);
            }
    //回复可见
    if (strpos($content, '{bs-hide') !== false) {
        $db = Typecho_Db::get();
        $hasComment = $db->fetchAll($db->select()->from('table.comments')->where('cid = ?', $t->cid)->where('mail = ?', $t->remember('mail', true))->limit(1));

        if ($hasComment||$login) {
           $content = preg_replace("/\{bs-hide\}(.*?)\{\/bs-hide\}/sm",'<div class="ui floating message">$1</div>',$post);
        } else {
            $content = preg_replace("/\{bs-hide\}(.*?)\{\/bs-hide\}/sm",'<div class="ui floating message"><i class="thumbtack icon"></i>此处内容需要评论回复或登录后方可阅读。</div>',$post);
        }
    }
    //兼容1.6.3版本前的回复可见短代码
    if (strpos($content, '[bs-hide') !== false) {
        $db = Typecho_Db::get();
        $hasComment = $db->fetchAll($db->select()->from('table.comments')->where('cid = ?', $t->cid)->where('mail = ?', $t->remember('mail', true))->limit(1));

        if ($hasComment||$login) {
           $content = preg_replace("/\[bs-hide\](.*?)\[\/bs-hide\]/sm",'<div class="ui floating message">$1</div>',$post);
        } else {
            $content = preg_replace("/\[bs-hide\](.*?)\[\/bs-hide\]/sm",'<div class="ui floating message"><i class="thumbtack icon"></i>此处内容需要评论回复或登录后方可阅读。</div>',$post);
        }
    }
    //Todolist
    if (strpos($content, '{bs-todo') !== false) {
        if (strpos($content, '{bs-todo type=true') !== false) {
        $content = preg_replace('/\{bs-todo type=true\}(.*?)\{\/bs-todo\}/sm', '<div class="ui checked checkbox"><input type="checkbox" checked="" disabled><label>$1</label></div>', $content);
        }
        if (strpos($content, '{bs-todo type=false') !== false) {
        $content = preg_replace('/\{bs-todo type=false\}(.*?)\{\/bs-todo\}/sm', '<div class="ui  checkbox"><input type="checkbox" disabled><label>$1</label></div>', $content);
        }
    }
       //Todolist New
    if (strpos($content, '[todo') !== false) {
        if (strpos($content, '[todo-t') !== false) {
        $content = preg_replace('/\[todo-t\](.*?)\[\/todo-t\]/sm', '<div class="ui checked checkbox"><input type="checkbox" checked="" disabled><label>$1</label></div>', $content);
        }
        if (strpos($content, '[todo-f') !== false) {
        $content = preg_replace('/\[todo-f\](.*?)\[\/todo-f\]/sm', '<div class="ui  checkbox"><input type="checkbox" disabled><label>$1</label></div>', $content);
        }
    }
    
    
    //手风琴
    if (strpos($content, '{bs-accord') !== false) {
        if (strpos($content, '{bs-accord style=line') !== false) {
        $content = preg_replace('/\{bs-accord style=line title=(.*?)\}(.*?)\{\/bs-accord\}/sm', '<div class="ui accordion"><div class="title"><i class="dropdown icon"></i>$1</div><div class="content"><p class="transition hidden">$2</p></div></div>', $content);
        }
        if (strpos($content, '{bs-accord style=common') !== false) {
                $content = preg_replace('/\{bs-accord style=common title=(.*?)\}(.*?)\{\/bs-accord\}/sm', '<div class="ui styled fluid accordion"><div class="title"><i class="dropdown icon"></i>$1</div><div class="content"><p class="transition hidden">$2</p></div></div>', $content);
        }
    }
    
    //Github卡片
    if (strpos($content, '{bs-card') !== false) {
        if (strpos($content, '{bs-card type=github') !== false) {
            $url = preg_replace('/\{bs-card type=github projectname=(.*?) projectdec=(.*?) projecturl=(.*?)\}{\/bs-card\}/sm', '$3', $content);
        $content = preg_replace('/\{bs-card type=github projectname=(.*?) projectdec=(.*?) projecturl=(.*?)\}{\/bs-card\}/sm', '<div class="ui relaxed divided list"><div class="item"><i class="large github middle aligned icon"></i><div class="content"><a class="header" href="https://$3">$1</a><div class="description">$2</div></div></div></div>', $content);
        }
    }
   

   
   //字体颜色
   if (strpos($content, '{bs-font') !== false) {
        $content = preg_replace('/\{bs-font color=(.*?)\}(.*?)\{\/bs-font\}/sm', '<font color=$1>$2</font>', $content);
   }
    //iframe
   if (strpos($content, '{bs-iframe') !== false) {
        $content = preg_replace('/\{bs-iframe\}(.*?)\{\/bs-iframe\}/sm', '<div class="iframe"><iframe class="iframe_video" src="$1" scrolling="no" border="0" frameborder="no" framespacing="0" allowfullscreen="true"></iframe></div>', $content);
        $content = preg_replace('/\<iframe class="iframe_video" src="<a href="(.*?)">(.*?)<\/a>" scrolling="no" border="0" frameborder="no" framespacing="0" allowfullscreen="true"><\/iframe>/sm', '<iframe class="iframe_video" src="$1" scrolling="no" border="0" frameborder="no" framespacing="0" allowfullscreen="true"></iframe>', $content);
   }
   

    
        if(strpos($content,'-[x]')!==false||strpos($content,'-[ ]')!==false){
            $attributes = array("style"=>"list-style: none;");
            $content = str_replace(array('-[x]','-[ ]'), array(
                '<input type="checkbox" checked="true" disabled="true">',
                '<input type="checkbox" disabled="true">',
            ), $content);
        }
        
        //判断是否为外链并判断是否新窗口打开
        $content = preg_replace_callback("/<a href=\"([^\"]*)\">(.*?)<\/a>/", function ($matches){
           $options = Helper::options();
            if (strpos($matches[1],$options->siteUrl) !== false || strpos(substr($matches[1],0,6),"http") === false){
                return '<a href="'.$matches[1].'"><i class="fa fa-link"></i> '.$matches[2].'</a>';
            }else{
                if ($options->Link_blank == '2'){
                return '<a href="'.$matches[1].'" target="_blank"><i class="fa fa-link"></i> '.$matches[2]."</a>";
                }
                else{
                return '<a href="'.$matches[1].'"><i class="fa fa-link"></i> '.$matches[2]."</a>";     
                }
            }
        }, $content);
if($modetype == 'noreadmode'){
    $content = "<div id=\"bearsimple-images\">".$content."</div>";
   }
   else{
       $content = "<div id=\"bearsimple-images-readmode\">".$content."</div>";
   }
    return $content;
}

function parselink($link){
    //判断是否为外链并判断是否新窗口打开
            $options = Helper::options();
            if (strpos($link,$options->siteUrl) !== false || strpos(substr($link,0,6),"http") === false){
                $link =  '';
            }else{
                if ($options->Link_blank == '2'){
                $link =  ' target="_blank"';
                }
                else{
                $link =  '';  
                }
            }
        return $link;
}

function getAcgFile(){
    $getAcgFile = Helper::options()->siteUrl.'/index.php/getacg';
    echo $getAcgFile;
}

function getDoubanFile(){
    $getDoubanFile = Helper::options()->siteUrl.'/index.php/getdouban';
    echo $getDoubanFile;
}

function getAttachFile(){
    $getAttachFile = Helper::options()->siteUrl.'/index.php/write';
    echo $getAttachFile;
}

function getCommentLikeFile(){
    $getCommentLikeFile = Helper::options()->siteUrl.'/index.php/commentlike';
    echo $getCommentLikeFile;
}

function getPostLikeFile(){
    $getPostLikeFile = Helper::options()->siteUrl.'/index.php/postlike';
    echo $getPostLikeFile;
}