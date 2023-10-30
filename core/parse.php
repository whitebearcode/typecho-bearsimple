<?php
require_once('extend/ChinesePinyin.class.php');
$playerID = 0;
function excerpt_content($content)
    {
        if (strpos($content, '[bsgallery') !== false) {
            $pattern = get_shortcode_regex(array('bsgallery'));
            $content = preg_replace("/$pattern/", '', $content);
        }
        if (strpos($content, '[bstimes') !== false) {
            $pattern = get_shortcode_regex(array('bstimes'));
            $content = preg_replace("/$pattern/", '', $content);
        }
        if (strpos($content, '[bsgit') !== false) {
            $pattern = get_shortcode_regex(array('bsgit'));
            $content = preg_replace("/$pattern/", '', $content);
        }
        if (strpos($content, '[bscopy') !== false) {
            $pattern = get_shortcode_regex(array('bscopy'));
            $content = preg_replace("/$pattern/", '', $content);
        }
        if (strpos($content, '[bsmusic') !== false) {
            $pattern = get_shortcode_regex(array('bsmusic'));
            $content = preg_replace("/$pattern/", '', $content);
        }
        if (strpos($content, '[todo-t') !== false) {
            $pattern = get_shortcode_regex(array('todo-t'));
            $content = preg_replace("/$pattern/", '', $content);
        }
        if (strpos($content, '[todo-f') !== false) {
            $pattern = get_shortcode_regex(array('todo-f'));
            $content = preg_replace("/$pattern/", '', $content);
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
        if (strpos($content, '[bsdate') !== false) {
            $pattern = get_shortcode_regex(array('bsdate'));
            $content = preg_replace("/$pattern/", '', $content);
        }
          if (strpos($content, '[bspaper') !== false) {
            $pattern = get_shortcode_regex(array('bspaper'));
            $content = preg_replace("/$pattern/", '', $content);
        }
        if (strpos($content, '[bsmessage') !== false) {
            $pattern = get_shortcode_regex(array('bsmessage'));
            $content = preg_replace("/$pattern/", '', $content);
        }
        if (strpos($content, '[bsplayer') !== false) {
            $pattern = get_shortcode_regex(array('bsplayer'));
            $content = preg_replace("/$pattern/", '', $content);
        }
        if (strpos($content, '[bsmp3') !== false) {
            $pattern = get_shortcode_regex(array('bsmp3'));
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
        if (strpos($content, '[bstag') !== false || strpos($content, '[tag') !== false) {
            $pattern = get_shortcode_regex(array('bstag','tag'));
            $content = preg_replace("/$pattern/", '', $content);
        }
        if (strpos($content, '{bs-iframe') !== false) {
            $pattern = get_shortcode_regex2(array('bs-iframe'));
            $content = preg_replace("/$pattern/", '', $content);
        }
        if (strpos($content, '[bsfra') !== false) {
            $pattern = get_shortcode_regex(array('bsfra'));
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
if (strpos($content, '[bstabs') !== false) {
            $pattern = get_shortcode_regex(array('bstabs'));
            $content = preg_replace("/$pattern/", '', $content);
        }
        if (strpos($content, '[bsopc') !== false) {
            $pattern = get_shortcode_regex(array('bsopc'));
            $content = preg_replace("/$pattern/", '', $content);
        }
        if (strpos($content, '[bstip') !== false) {
            $pattern = get_shortcode_regex(array('bstip'));
            $content = preg_replace("/$pattern/", '', $content);
        }
        return $content;
    }
function parseNumber($str){
    return preg_replace("/[^0-9]/", "", $str);
}
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
//60S
function quotebspaperCallback($matches){
    if($matches[3]){
    $attr = htmlspecialchars_decode($matches[3]);
    $attrs = shortcode_parse_atts($attr);
    }
    $date=strtotime(date("Y-m-d",time()));
    $arr = array("7","1","2","3","4","5","6");
    $week = $arr[date("w")];
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'https://www.zhihu.com/api/v4/columns/c_1261258401923026944/items');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_TIMEOUT, 500);
    curl_setopt($curl, CURLOPT_POST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    $data = curl_exec($curl);
    curl_close($curl);
$data = json_decode($data);
$content = $data->data[0]->content;
$content = strip_tags($content,'<p>');
if($attrs['image'] == 'true'){
$img = '<img '.lazyload().'src="'.Helper::options()->themeUrl.'/assets/images/60s/'.$week.'.webp'.'">';
}

   return <<<EOF
  {$img}
  {$content}
EOF;
}

function getCustomFields($cid, $key){
    $db = Typecho_Db::get();
    $rows = $db->fetchAll($db->select('table.fields.str_value')->from('table.fields')
        ->where('table.fields.cid = ?', $cid)
        ->where('table.fields.name = ?', $key)
    );
    foreach ($rows as $row) {
        $value = $row['str_value'];
        if (!empty($value)) {
            $values[] = $value;
        }
    }
    return $values;
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
        $expert = getCustomFields($cid, 'excerpt');
        if (!empty($cid)){
            $db = Typecho_Db::get();
            $prefix = $db->getPrefix();
            $posts = $db->fetchAll($db
                ->select()->from('table.contents')
                ->orWhere('table.contents.cid = ?', $cid)
                ->where('table.contents.type = ? AND table.contents.status = ? AND table.contents.password IS NULL', 'post', 'publish'));
            if (count($posts) == 0) {
                $targetTitle = "文章不存在或文章存在密码";
                $targetUrl = '#';
                $targetDate = '';
            }else{
                $result = Typecho_Widget::widget('Widget_Abstract_Contents')->push($posts[0]);
                 $targetSummary = preg_replace(['/#+/', '/-+/', '/\n(>|\\>)/', '/^>{1}/'], '', excerpt($result['text'], 60));
                $targetTitle = $result['title'];
                $targetUrl = $result['permalink'];
                $targetDate = date('Y-m-d H:m:s',$result['created']);
                if($expert){
                    $targetSummary = $expert[0];
                }
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

function parseTabsCallback($matches)
    {
        if ($matches[1] == '[' && $matches[6] == ']') {
            return substr($matches[0], 1, -1);
        }

        $content = $matches[5];

        $pattern = get_shortcode_regex(array('bstab'));
        preg_match_all("/$pattern/", $content, $matches);
        $tabs = "";
        $tabContents = "";
        for ($i = 0; $i < count($matches[3]); $i++) {
            $item = $matches[3][$i];
            $text = $matches[5][$i];
            $id = "bstabs-" . md5(uniqid()) . rand(0, 100) . $i;
            $attr = htmlspecialchars_decode($item);
            $attrs = shortcode_parse_atts($attr);
            $name = @$attrs['name'];
            $active = @$attrs['active'];
           

            if ($active == "true") {
                $active = "active";
                $in = "in";
            } else {
                $active = "";
            }
            
            $tabs .= "<a class='item $active' data-tab='$id'>$name</a>";
            $tabContents .= "<div class='ui tab $active' data-tab='$id'>
            $text</div>";
        }


        return <<<EOF
        <div class="ui segment">
<div class="ui pointing secondary menu wrapped">
       $tabs
    </div>
   
        $tabContents
        </div>
EOF;
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
        if (@$attrs['color'] == "primary") {
            $color = 'blue';
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
  <div>
{$matches[5]}
  </div>
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
        $gh_result_cookie_name = '__gh_result_cookie_'.$attrs['user'].'_'.$matches[5];
        $gh_result_cookie = Typecho_Cookie::get($gh_result_cookie_name);
        if(!$gh_result_cookie){
            $result = json_decode(curl_get('https://api.github.com/repos/'.$attrs['user'].'/'.$matches[5]),true);
            $result['pushed_at'] = date('Y-m-d H:m:s',strtotime($result['pushed_at']));
            $result_arr = array($result['full_name'],$attrs['user'],$matches[5],$result['pushed_at'],$result['stargazers_count'],$result['forks_count'],$result['html_url'],$result['description'],
            );
        Typecho_Cookie::set($gh_result_cookie_name, implode(",",$result_arr));
        }
       else{
        $result = explode(",",$gh_result_cookie);
        $result['full_name'] = $result[0];
        $result['pushed_at'] = $result[3];
        $result['stargazers_count'] = $result[4];
        $result['description'] = $result[7];
        $result['html_url'] = $result[6];
}
        if(@$result['full_name'] == ''){
            $result['full_name'] = '未获取到Github信息';
        }
        if($result['pushed_at'] == ''){
        $result['pushed_at'] = '未获取到Github项目更新日期';    
            }
        else{
        $result['pushed_at'] = '更新于'.$result['pushed_at'];
        }
        if($result['stargazers_count']){
        $star = '<i class="star yellow icon"></i>'.$result['stargazers_count'];
        }
        $fork = '<i class="fork green icon"></i>'.$result['forks_count'];
        return <<<EOF
        <div class="ui relaxed divided list" style="margin:auto"><div class="item"><i class="big github middle aligned icon"></i><div class="content"><a class="header" href="{$result['html_url']}" title="{$result['description']}">{$result['full_name']}</a><div class="description">{$star} {$result['pushed_at']}</div></div></div></div>
EOF;
    }

//点击复制内容回调
function parseCopyCallback($matches)
    {
        $matches[3] = preg_replace("/<a href=.*?>(.*?)<\/a>/",'$1',$matches[3]);
        $attr = htmlspecialchars_decode($matches[3]);
        $attrs = shortcode_parse_atts($matches[3]);
       $content = $attrs['text'];
        return <<<EOF
        <span class="bscopy" data-clipboard-text="{$content}">{$matches[5]}</span>
EOF;
    }

//Tag回调
function parseTagCallback($matches)
    {
        $attr = htmlspecialchars_decode($matches[3]);
        $attrs = shortcode_parse_atts($attr);
        $db = Typecho_Db::get();
   $tag=$db->fetchRow($db->select()->from ('table.metas')->where('type=?', 'tag')->where ('name=?',$matches[5]));
        $url = Helper::options()->siteUrl.'index.php/tag/';
        if($tag){
        return <<<EOF
        <a href="{$url}{$tag['slug']}">{$matches[5]}</a>
EOF;
}
else{
    return <<<EOF
        {$matches[5]}
EOF;
}
    }
    
//Bsfra回调
function parseBsfraCallback($matches)
    {
        $attr = htmlspecialchars_decode($matches[3]);
        $attrs = shortcode_parse_atts($attr);
        if(@$attrs['image'] == ''){
            $image = Helper::options()->themeUrl.'/assets/images/placeholder.png';
        }
        else{
            $image = $attrs['image'];
        }
        if(@$attrs['url'] == ''){
            $url = Helper::options()->siteUrl;
        }
        else{
            $url = $attrs['url'];
        }
        return <<<EOF
        <div class="ui embed" data-url="{$url}" data-placeholder="{$image}" data-icon="right circle arrow"></div>
EOF;
    }
 
//Bsplayer回调
function parsePlayerCallback($matches)
    {
        $matches[3] = preg_replace("/<a href=.*?>(.*?)<\/a>/",'$1',$matches[3]);
        $attr = htmlspecialchars_decode($matches[3]);
        $attrs = shortcode_parse_atts($attr);

        $config = [
            'live' => false,
            'autoplay' => false,
            'theme' => '#FADFA3',
            'loop' => 'true',
            'screenshot' => false,
            'hotkey' => true,
            'preload' => 'metadata',
            'lang' => 'zh-cn',
            'logo' => null,
            'volume' => 0.7,
            'mutex' => true,
            'video' => [
                'url' => isset($attrs['url']) ? $attrs['url'] : null,
                'pic' => isset($attrs['image']) ? $attrs['image'] : Helper::options()->themeUrl.'/assets/images/placeholder.png',
                'type' => 'auto',
                'thumbnails' => null,
            ],
        ];
        $json = json_encode($config,JSON_UNESCAPED_SLASHES);
        return <<<EOF
        <div class="dplayer" data-config='{$json}'></div>
EOF;
    }

//Bsmp3回调
function parseMp3Callback($matches)
    {
        $playerID = 0;
        $matches[3] = preg_replace("/<a href=.*?>(.*?)<\/a>/",'$1',$matches[3]);
        $attr = htmlspecialchars_decode($matches[3]);
        $attrs = shortcode_parse_atts($attr);
        $id = getUniqueId();
        $playerCode =  '<div id="player'.$id.'" class="aplayer"></div>';
        $config = [
            'id' => $id,
            "autoplay"=>false,
            "theme"=>"#e6d0b2",
            "mutex"=>true,
            "preload"=>false,
            "url"=>isset($attrs['url']) ? $attrs['url'] : null,
            "artist"=>isset($attrs['singer']) ? $attrs['singer'] : '佚名',
            "title"=>isset($attrs['name']) ? $attrs['name'] : '未知歌曲',
            "showlrc"=>0,
            "cover"=>isset($attrs['image']) ? $attrs['image'] : null,
            'music' => [
                "url"=>isset($attrs['url']) ? $attrs['url'] : null,
                "title"=>isset($attrs['name']) ? $attrs['name'] : '未知歌曲',
                "showlrc"=>"false",
                "author"=>isset($attrs['singer']) ? $attrs['singer'] : '佚名',
                "pic"=>isset($attrs['image']) ? $attrs['image'] : null,
                "lrc"=>"[00:00.00]\u627e\u4e0d\u5230\u6b4c\u8bcd\n[99:00.00] "
            ],
        ];
        $js = json_encode($config,JSON_UNESCAPED_SLASHES);
        
        $playerCode .= <<<EOF
<script>APlayerOptions.push({$js});</script>
EOF;

        return $playerCode;
    }
    
    
//日期倒计时回调
function parseDateProgressCallback($matches)
{
        $attr = htmlspecialchars_decode($matches[3]);
        $attrs = shortcode_parse_atts($attr);
       
        if(@$attrs['color'] == ''){
            $color = 'blue';
        }
        else{
           $color = $attrs['color'];
        }
        if(@$attrs['end'] == ''){
            $end = '2099-01-03 21:23:23';
        }
        else{
            $end = $attrs['end'];
        }
        return <<<EOF
        <h2 class="progressdate-title">{$matches[5]}</h2>
<time class="progressdate-number" date-time="{$end}" style="--accent: {$color}"></time>
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
            $color = 'bsprogress-bar-'.$attrs['color'];
        }
        
        return <<<EOF
        <div class="bstools" bstitle="{$matches[5]}"></div>
       <div class="bsprogress bsprogress-striped active">
      <div role="bsprogressbar" style="width: {$progress}%;" class="bsprogress-bar {$color}"><span>{$progress}%</span></div>
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


//文字显隐回调
function parseOpcCallback($matches)
{
    $matches[5] = preg_replace("/<a href=.*?>(.*?)<\/a>/",'$1',$matches[5]);
    return <<<EOF
    <span class="bhide">{$matches[5]}</span>
EOF;

}

//文字提示回调
function parseTipCallback($matches)
{
    $attr = htmlspecialchars_decode($matches[3]);
    $attrs = shortcode_parse_atts($attr);
    $text = $attrs['text'];
    $matches[5] = preg_replace("/<a href=.*?>(.*?)<\/a>/",'$1',$matches[5]);
    return <<<EOF
    <btip data-tippy-content="{$text}
    ">{$matches[5]}</btip>
EOF;

}


//音乐歌单回调
function parseMusicCallback($matches)
{
    return <<<EOF
    <div class="BAudio" id="b{$matches[5]}"></div>
    <script>
    fetch("https://api.injahow.cn/meting/?server=netease&type=playlist&id={$matches[5]}").then(async response => {
      const audio = await response.json();
      new BAudio({
        element: document.querySelector("#b{$matches[5]}"),
        audio: audio
      })
    });
    </script>
EOF;

}

//音乐歌单回调
function parseMusicRdCallback($matches)
{
    return <<<EOF
    <div class="BAudio" id="brd{$matches[5]}"></div>
    <script>
    fetch("https://api.injahow.cn/meting/?server=netease&type=playlist&id={$matches[5]}").then(async response => {
      const audio = await response.json();
      new BAudio({
        element: document.querySelector("#brd{$matches[5]}"),
        audio: audio
      })
    });
    </script>
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
//时间计划
function parseTimePlanCallback($matches){
    $matches[5] = preg_replace("/<a href=.*?>(.*?)<\/a>/",'$1',$matches[5]);
    $matches[3] = preg_replace("/<a href=.*?>(.*?)<\/a>/",'$1',$matches[3]);
    $attr = htmlspecialchars_decode($matches[3]);
        $attrs = shortcode_parse_atts($attr);
        if(empty($attrs['title'])){
            $attrs['title'] = '我的时间计划表';
        }
        else{
           $attrs['title'] = '<i class="time violet icon"></i>'.$attrs['title']; 
        }
        $matches[5] = preg_replace("/\[bstime time=\"(.*?)\"\](.*?)\[\/bstime\]/sm",'<li class="bs-plan-li"><div class="bs-plan-time">$1</div><p class="bs-plan-p">$2</p></li>',$matches[5]);
        $matches[5] = preg_replace("/\<br>/sm",'',$matches[5]);
        $matches[5] = str_replace("<br />",'',$matches[5]);
    return <<<EOF
  <h1 class="bs-plan-h1">{$attrs['title']}</h1>
    <ul class="bs-plan-sessions bs-plan-ul">
      {$matches[5]}
    </ul>

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
        $matches[5] = preg_replace("/\[bsimg title=\"(.*?)\"\](.*?)\[\/bsimg\]/sm",'<div class="slider__item"><img class="slider__image lazyload lazyload-style-'.$options['Lazyload_style'].'" '.lazyload(1).'src="$2" alt="$1"><div class="slider__info"><font class="slider-raw">$1</font></div></div>',$matches[5]);
        $matches[5] = preg_replace("/\<br>/sm",'',$matches[5]);
    return <<<EOF
        <h1 class="bsn-title">{$attrs['title']}</h1>

<div class="slider" x-data="{start: true, end: false}">

  <div class="slider__content" x-ref="slider" x-on:scroll.debounce="\$refs.slider.scrollLeft == 0 ? start = true : start = false; Math.abs((\$refs.slider.scrollWidth - \$refs.slider.offsetWidth) - \$refs.slider.scrollLeft) < 5 ? end = true : end = false;">
    {$matches[5]}
  </div>
  <div class="slider__nav">
    <button class="slider__nav__button" x-on:click="\$refs.slider.scrollBy({left: \$refs.slider.offsetWidth * -1, behavior: 'smooth'});" x-bind:class="start ? '' : 'slider__nav__button--active'">后退</button>
    <button class="slider__nav__button" x-on:click="\$refs.slider.scrollBy({left: \$refs.slider.offsetWidth, behavior: 'smooth'});" x-bind:class="end ? '' : 'slider__nav__button--active'">前进</button>
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
        $matches[5] = preg_replace("/\[bsimg title=\"(.*?)\"\](.*?)\[\/bsimg\]/sm",'<div href="$2" class="slider__item" data-fancybox="gallery" data-caption="$1"><img class="slider__image lazyload lazyload-style-'.$options['Lazyload_style'].'" '.lazyload(1).'src="$2" alt="$1"><div class="slider__info"></div></div>',$matches[5]);
$matches[5] = preg_replace("/\<br>/sm",'',$matches[5]);
    return <<<EOF
    <h1 class="bsn-title">{$attrs['title']}</h1>

<div class="slider" x-data="{start: true, end: false}">

  <div class="slider__content" x-ref="slider" x-on:scroll.debounce="\$refs.slider.scrollLeft == 0 ? start = true : start = false; Math.abs((\$refs.slider.scrollWidth - \$refs.slider.offsetWidth) - \$refs.slider.scrollLeft) < 5 ? end = true : end = false;">
    {$matches[5]}
  </div>
  <div class="slider__nav">
    <button class="slider__nav__button" x-on:click="\$refs.slider.scrollBy({left: \$refs.slider.offsetWidth * -1, behavior: 'smooth'});" x-bind:class="start ? '' : 'slider__nav__button--active'">后退</button>
    <button class="slider__nav__button" x-on:click="\$refs.slider.scrollBy({left: \$refs.slider.offsetWidth, behavior: 'smooth'});" x-bind:class="end ? '' : 'slider__nav__button--active'">前进</button>
  </div>
</div>

EOF;

}

//关于我历程解析标题
function parseTimelineCallbackTitle($matches)
{
   return <<<EOF
   {$matches[5]}
EOF;
}
//关于我历程解析内容
function parseTimelineCallbackDesc($matches)
{
   return <<<EOF
            {$matches[5]}
EOF;
}
//关于我历程解析
function parseTimelineCallback($matches)
{
    $matches[5] = preg_replace("/<a href=.*?>(.*?)<\/a>/",'$1',$matches[5]);
    $matches[3] = preg_replace("/<a href=.*?>(.*?)<\/a>/",'$1',$matches[3]);
        $attr = htmlspecialchars_decode($matches[3]);
        $attrs = shortcode_parse_atts($attr);
        if(@$attrs['year'] == ''){
            $attrs['year'] = '2023';
        }
        else{
           $attrs['year'] = $attrs['year']; 
        }
        if (strpos($matches[5], '[title') !== false) {
            $pattern = get_shortcode_regex(array('title'));
            $matches1 = preg_replace_callback("/$pattern/", 'parseTimelineCallbackTitle', $matches[5]);
            $pattern = get_shortcode_regex(array('desc'));
            $matches1 = preg_replace("/$pattern/", '', $matches1);
    } 
    if (strpos($matches[5], '[desc') !== false) {
            $pattern = get_shortcode_regex(array('desc'));
            $matches2 = preg_replace_callback("/$pattern/", 'parseTimelineCallbackDesc', $matches[5]);
            $pattern = get_shortcode_regex(array('title'));
            $matches2 = preg_replace("/$pattern/", '', $matches2);
    } 
    return <<<EOF
    <div class="timeline-item" date-is='{$attrs['year']}'>
		<h3>{$matches1}</h3>
		<p>
			{$matches2}
		</p>
	</div>

EOF;

}

function ParseAboutMe(){
    $options = bsOptions::getInstance()::get_option( 'bearsimple' );
    $content = $options['aboutme_lc'];
   if (strpos($content, '[timeline') !== false) {
            $pattern = get_shortcode_regex(array('timeline'));
            $content = preg_replace_callback("/$pattern/", 'parseTimelineCallback', $content);
    } 
    return $content;
}
function ParseCross($content){
    $content = preg_replace('/\<div class="comment-excerpta break"\>(.*?)\<\/div\>/sm', '$1', $content);
    $content = preg_replace('/\<div class="comment-excerptb break"\>(.*?)\<\/div\>/sm', '$1', $content);
   if (strpos($content, '[bsimg') !== false) {
        $content = preg_replace('/\[bsimg\](.*?)\[\/bsimg\]/sm', '<a href="$1" data-fancybox="single"><img '.lazyload().'src="$1"></a>', $content);
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
//时间计划表
    if (strpos($content, '[bstimes') !== false) {
            $pattern = get_shortcode_regex(array('bstimes'));
            $content = preg_replace_callback("/$pattern/", 'parseTimePlanCallback', $content);
    }
   return $content;
}

function ShortCodePage($post,$title,$remember,$cid,$login,$articletype,$modetype='noreadmode'){
    $options = bsOptions::getInstance()::get_option( 'bearsimple' );
    $requireModeration = Helper::options()->commentsRequireModeration;
    $content = $post;
    $alt = '';
    if($options['article_imgalt'] == '1'){
        $alt = '<div class="imgalt">$2</div>';
    }
    if($articletype == 'common_Mode' || empty($articletype)){
    //相册
    if (strpos($content, '[bsgallery') !== false) {
            $pattern = get_shortcode_regex(array('bsgallery'));
            $content = preg_replace_callback("/$pattern/", 'parseGalleryCallback', $content);
    }
    else{
           
    if ($options['Lightbox'] == '1' || $options['Watermark'] == '1'){
    $pattern = '/\<img.*?src\=\"(.*?)\"[^>]*>/i';
   
 $replacement = '
<img class="bearmark lazyload lazyload-style-'.$options['Lazyload_style'].'" '.lazyload(1).'src="$1"   alt="'.$title.'" title="点击放大图片">'.$alt; 
    $content = preg_replace($pattern, $replacement, $content);
   

    }
    
        
    }

    
    //进度条
    if (strpos($content, '[bsprog') !== false) {
            $pattern = get_shortcode_regex(array('bsprog'));
            $content = preg_replace_callback("/$pattern/", 'parseProgressCallback', $content);
    }
    //日期倒计时进度条
    if (strpos($content, '[bsdate') !== false) {
            $pattern = get_shortcode_regex(array('bsdate'));
            $content = preg_replace_callback("/$pattern/", 'parseDateProgressCallback', $content);
    }
     //Audio
    if (strpos($content, '[bsaudio') !== false) {
            $pattern = get_shortcode_regex(array('bsaudio'));
            $content = preg_replace_callback("/$pattern/", 'parseAudioCallback', $content);
    }
    //tag
    if (strpos($content, '[bstag') !== false || strpos($content, '[tag') !== false) {
            $pattern = get_shortcode_regex(array('bstag','tag'));
            $content = preg_replace_callback("/$pattern/", 'parseTagCallback', $content);
    }
     //音乐歌单
    if (strpos($content, '[bsmusic') !== false) {
        if($modetype == 'noreadmode'){
            $pattern = get_shortcode_regex(array('bsmusic'));
            $content = preg_replace_callback("/$pattern/", 'parseMusicCallback', $content);
        }
        else{
            $pattern = get_shortcode_regex(array('bsmusic'));
            $content = preg_replace_callback("/$pattern/", 'parseMusicRdCallback', $content);
        }
    }
    //opc
    
    if (strpos($content, '[bsopc') !== false) {
            $pattern = get_shortcode_regex(array('bsopc'));
            $content = preg_replace_callback("/$pattern/", 'parseOpcCallback', $content);
    }
    //tabs
    
    if (strpos($content, '[bstabs') !== false) {
            $pattern = get_shortcode_regex(array('bstabs'));
            $content = preg_replace_callback("/$pattern/", 'parseTabsCallback', $content);
    }
    //评星
    if (strpos($content, '[bseva') !== false) {
            $pattern = get_shortcode_regex(array('bseva'));
            $content = preg_replace_callback("/$pattern/", 'parseEvaluationCallback', $content);
    }
    //文字提示
    if (strpos($content, '[bstip') !== false) {
            $pattern = get_shortcode_regex(array('bstip'));
            $content = preg_replace_callback("/$pattern/", 'parseTipCallback', $content);
    }
    //Bframe
    if (strpos($content, '[bsfra') !== false) {
            $pattern = get_shortcode_regex(array('bsfra'));
            $content = preg_replace_callback("/$pattern/", 'parseBsfraCallback', $content);
    }
    //Bplayer
    if (strpos($content, '[bsplayer') !== false) {
            $pattern = get_shortcode_regex(array('bsplayer'));
            $content = preg_replace_callback("/$pattern/", 'parsePlayerCallback', $content);
    }
     //Bmp3
    if (strpos($content, '[bsplayer') !== false) {
            $pattern = get_shortcode_regex(array('bsmp3'));
            $content = preg_replace_callback("/$pattern/", 'parseMp3Callback', $content);
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
   //TOC
   if ($options['Scroll'] == true){
         $pattern = "/^<h1>(.*?)<\/h1>$/";
 $replacement = '<h1 id="$1">$1</h1>'; 
 $pattern = "/^<h2>(.*?)<\/h2>$/";
 $replacement = '<h2 id="$1">$1</h2>'; 
 $pattern = "/^<h3>(.*?)<\/h3>$/";
 $replacement = '<h3 id="$1">$1</h3>'; 
 $pattern = "/^<h4>(.*?)<\/h4>$/";
 $replacement = '<h4 id="$1">$1</h4>';
 $pattern = "/^<h5>(.*?)<\/h5>$/";
 $replacement = '<h5 id="$1">$1</h5>';
 $pattern = "/^<h6>(.*?)<\/h6>$/";
 $replacement = '<h6 id="$1">$1</h6>';
    $content = preg_replace($pattern, $replacement, $content);
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
     //点击复制内容
    if (strpos($content, '[bscopy') !== false) {
            $pattern = get_shortcode_regex(array('bscopy'));
            $content = preg_replace_callback("/$pattern/", 'parseCopyCallback', $content);
        }
    //60s
    if (strpos($content, '[bspaper') !== false) {
            $pattern = get_shortcode_regex(array('bspaper'));
            $content = preg_replace_callback("/$pattern/", 'quotebspaperCallback', $content);
        }
        
    //登录可见
            if (strpos($content, '[bslogin') !== false) {
                $pattern = get_shortcode_regex(array('bslogin'));
                
                $content = preg_replace_callback("/$pattern/", function ($matches) use ($login,$options) {
                    if ($matches[1] == '[' && $matches[6] == ']') {
                        return substr($matches[0], 1, -1);
                    }
                    if ($login) {
                         return '<div class="ui floating message">'.$matches[5].'</div>';
                    } else {
                        $r = empty($options['globalTips']['articleHideAfterLogin_Tip'])? '<div class="ui floating message"><i class="thumbtack icon"></i>此处内容需要登录后方可阅读。</div>' : '<div class="ui floating message"><i class="thumbtack icon"></i>'.$options['globalTips']['articleHideAfterLogin_Tip'].'</div>';
                      return $r;
                    }
                }, $content);
            }
    //登录或回复后可见
            if (strpos($content, '[bshide') !== false) {
                $pattern = get_shortcode_regex(array('bshide'));
                $db = Typecho_Db::get();
        $hasComment = $db->fetchAll($db->select()->from('table.comments')->where('cid = ?', $cid)->where('status = ?', 'approved')->where('mail = ?', $remember)->limit(1));
        if(count($hasComment) !== 0){
            $hasComments = count($hasComment);
        }
        else{
            $hasComments = 0;
        }
                $content = preg_replace_callback("/$pattern/", function ($matches) use ($login,$hasComments,$options,$requireModeration) {
                    if ($matches[1] == '[' && $matches[6] == ']') {
                        return substr($matches[0], 1, -1);
                    }
                    if ($login || $hasComments !== 0) {
                         return '<div class="ui floating message">'.$matches[5].'</div>';
                    } 
                    if(!$options['globalTips']['articleHideAfterComment_Tip'] && $requireModeration == true){
                    return '<div class="ui floating message"><i class="thumbtack icon"></i>此处内容需要登录或评论(审核通过)后方可阅读。</div>';    
                    }
                    if(!$options['globalTips']['articleHideAfterComment_Tip'] && $requireModeration == false){
                    return '<div class="ui floating message"><i class="thumbtack icon"></i>此处内容需要登录或评论后方可阅读。</div>';    
                    }
                    if(!empty($options['globalTips']['articleHideAfterComment_Tip'])){ 
                        return '<div class="ui floating message"><i class="thumbtack icon"></i>'.$options['globalTips']['articleHideAfterComment_Tip'].'</div>';
                    }
                }, $content);
            }
    //回复可见
    if (strpos($content, '{bs-hide') !== false) {
        $db = Typecho_Db::get();
        $hasComment = $db->fetchAll($db->select()->from('table.comments')->where('cid = ?', $cid)->where('mail = ?', $remember)->limit(1));

        if ($hasComment||$login) {
           $content = preg_replace("/\{bs-hide\}(.*?)\{\/bs-hide\}/sm",'<div class="ui floating message">$1</div>',$post);
        } else {
            $content = preg_replace("/\{bs-hide\}(.*?)\{\/bs-hide\}/sm",'<div class="ui floating message"><i class="thumbtack icon"></i>此处内容需要登录或评论后方可阅读。</div>',$post);
        }
    }
    //兼容1.6.3版本前的回复可见短代码
    if (strpos($content, '[bs-hide') !== false) {
        $db = Typecho_Db::get();
        $hasComment = $db->fetchAll($db->select()->from('table.comments')->where('cid = ?', $cid)->where('mail = ?', $remember)->limit(1));

        if ($hasComment||$login) {
           $content = preg_replace("/\[bs-hide\](.*?)\[\/bs-hide\]/sm",'<div class="ui floating message">$1</div>',$post);
        } else {
            $content = preg_replace("/\[bs-hide\](.*?)\[\/bs-hide\]/sm",'<div class="ui floating message"><i class="thumbtack icon"></i>此处内容需要登录或评论后方可阅读。</div>',$post);
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
        $content = preg_replace('/\{bs-iframe\}(.*?)\{\/bs-iframe\}/sm', '<div class="iframe"><iframe class="iframe_video" src="$1" scrolling="yes" border="0" frameborder="no" framespacing="0" allowfullscreen="true"></iframe></div>', $content);
        $content = preg_replace('/\<iframe class="iframe_video" src="<a href="(.*?)">(.*?)<\/a>" scrolling="yes" border="0" frameborder="no" framespacing="0" allowfullscreen="true"><\/iframe>/sm', '<iframe class="iframe_video" src="$1" scrolling="yes" border="0" frameborder="no" framespacing="0" allowfullscreen="true"></iframe>', $content);
   }
   

    if(strpos($content,'- [x]')!==false||strpos($content,'- [ ]')!==false){
            $attributes = array("style"=>"list-style: none;");
            $content = str_replace(array('- [x]','- [ ]'), array(
                '<input type="checkbox" checked="true" disabled="true">',
                '<input type="checkbox" disabled="true">',
            ), $content);
        }
    if(strpos($content,'-[x]')!==false||strpos($content,'-[ ]')!==false){
            $attributes = array("style"=>"list-style: none;");
            $content = str_replace(array('-[x]','-[ ]'), array(
                '<input type="checkbox" checked="true" disabled="true">',
                '<input type="checkbox" disabled="true">',
            ), $content);
        }
        if(strpos($content,'[x]')!==false||strpos($content,'[ ]')!==false){
            $attributes = array("style"=>"list-style: none;");
            $content = str_replace(array('[x]','[ ]'), array(
                '<input type="checkbox" checked="true" disabled="true">',
                '<input type="checkbox" disabled="true">',
            ), $content);
        }
        
        //判断是否为外链并判断是否新窗口打开
        $content = preg_replace_callback("/<a href=\"(.*?)\">(.*?)<\/a>/is", function ($matches){
           $options = bsOptions::getInstance()::get_option( 'bearsimple' );
           $optionss = Helper::options();
            if (strpos($matches[1],$optionss->siteUrl) !== false || strpos(substr($matches[1],0,6),"http") === false){
                return '<a class="link-hover" style="text-decoration:none" href="'.$matches[1].'"><span><i class="external alternate icon"></i>'.$matches[2].'</span></a>';
            }else{
                if ($options['Link_blank']== '2'){
                return '<a class="link-hover" style="text-decoration:none"  href="'.$matches[1].'" target="_blank"><span><i class="external alternate icon"></i>'.$matches[2]."</span></a>";
                }
                else{
                return '<a class="link-hover" style="text-decoration:none" href="'.$matches[1].'"><span><i class="external alternate icon"></i>'.$matches[2]."</span></a>";     
                }
            }
        }, $content);
        
    }
    else{
        if ($options['Lightbox'] == '1' || $options['Watermark'] == '1'){
        $pattern = '/<\s*img[\s\S]+?(?:src=[\'"]([\S\s]*?)[\'"]\s*|alt=[\'"]([\S\s]*?)[\'"]\s*|[a-z]+=[\'"][\S\s]*?[\'"]\s*)+[\s\S]*?>/i';
   
 $replacement = '
  <a class="card">
    <div class="image">
      <img class="bearmark lazyload lazyload-style-'.$options['Lazyload_style'].'" '.lazyload(1).'src="$1"   alt="$2" title="点击放大图片">
    </div>
  </a>'; 
    $content = preg_replace($pattern, $replacement, $content);
   

    }
    else{
    $pattern = '/<\s*img[\s\S]+?(?:src=[\'"]([\S\s]*?)[\'"]\s*|alt=[\'"]([\S\s]*?)[\'"]\s*|[a-z]+=[\'"][\S\s]*?[\'"]\s*)+[\s\S]*?>/i';
   
 $replacement = '
  <a class="card">
    <div class="image">
      <img '.lazyload().'src="$1"  alt="$2" title="点击放大图片">
    </div>
  </a>'; 
    $content = preg_replace($pattern, $replacement, $content);
    }
    
    }

   
   if($articletype == 'pic_Mode'){
    $content = "<div class=\"ui four doubling cards\">".preg_replace("/<p.*?>|<\/p>|<br.*?>/is","", $content)."</div>";
   }
   if($modetype == 'noreadmode'){
       
    $content = "<div id=\"bearsimple-images\">".$content."</div>";
   }
   else{

       $content = "<div id=\"bearsimple-images-readmode\">".$content."</div>";
   }
   //添加目录树识别
   if(preg_match('/<h([1-6])(.*?)>(.*?)<\/h\1>/i',$content)){
       $content = "<div class=\"bmenutree\"></div>".$content;
   }
    return $content;
}

function ShortCode($post,$t,$login,$articletype,$modetype='noreadmode'){
    $options = bsOptions::getInstance()::get_option( 'bearsimple' );
     $requireModeration = Helper::options()->commentsRequireModeration;
    $content = $post;
    $alt = '';
    if($options['article_imgalt'] == '1'){
        $alt = '<div class="imgalt">$2</div>';
    }
     if($modetype == 'noreadmode'){
            $mark = 'bearmark';
        }
        else{
           $mark = 'bearmarkread';
        }
    if($articletype == 'common_Mode' || empty($articletype)){
   
    //相册
    if (strpos($content, '[bsgallery') !== false) {
            $pattern = get_shortcode_regex(array('bsgallery'));
            $content = preg_replace_callback("/$pattern/", 'parseGalleryCallback', $content);
    }
    else{
           
    if ($options['Lightbox'] == '1' || $options['Watermark'] == '1'){
    $pattern = '/<\s*img[\s\S]+?(?:src=[\'"]([\S\s]*?)[\'"]\s*|alt=[\'"]([\S\s]*?)[\'"]\s*|[a-z]+=[\'"][\S\s]*?[\'"]\s*)+[\s\S]*?>/i';
   
 $replacement = '
<img class="pure-img '.$mark.' lazyload lazyload-style-'.$options['Lazyload_style'].'" '.lazyload(1).'src="$1"  alt="$2" title="点击放大图片">'.$alt; 
    $content = preg_replace($pattern, $replacement, $content);
   

    }
    else{
        $pattern = '/<\s*img[\s\S]+?(?:src=[\'"]([\S\s]*?)[\'"]\s*|alt=[\'"]([\S\s]*?)[\'"]\s*|[a-z]+=[\'"][\S\s]*?[\'"]\s*)+[\s\S]*?>/i';
   
 $replacement = '
<img class="pure-img lazyload lazyload-style-'.$options['Lazyload_style'].'" '.lazyload(1).'src="$1"   alt="$2" title="$2">'.$alt; 
    $content = preg_replace($pattern, $replacement, $content);
    }
        
    }
    
        //TOC 正则H标签替换，有点懒直接这样写快一点
   if ($options['Scroll'] == true){
   $pattern = "/^<h1>(.*?)<\/h1>$/";
 $replacement = '<h1 id="$1">$1</h1>'; 
 $pattern = "/^<h2>(.*?)<\/h2>$/";
 $replacement = '<h2 id="$1">$1</h2>'; 
 $pattern = "/^<h3>(.*?)<\/h3>$/";
 $replacement = '<h3 id="$1">$1</h3>'; 
 $pattern = "/^<h4>(.*?)<\/h4>$/";
 $replacement = '<h4 id="$1">$1</h4>';
 $pattern = "/^<h5>(.*?)<\/h5>$/";
 $replacement = '<h5 id="$1">$1</h5>';
 $pattern = "/^<h6>(.*?)<\/h6>$/";
 $replacement = '<h6 id="$1">$1</h6>';
    $content = preg_replace($pattern, $replacement, $content);
   }
   //时间计划表
    if (strpos($content, '[bstimes') !== false) {
            $pattern = get_shortcode_regex(array('bstimes'));
            $content = preg_replace_callback("/$pattern/", 'parseTimePlanCallback', $content);
    }
   
    //进度条
    if (strpos($content, '[bsprog') !== false) {
            $pattern = get_shortcode_regex(array('bsprog'));
            $content = preg_replace_callback("/$pattern/", 'parseProgressCallback', $content);
    }
    //日期倒计时进度条
    if (strpos($content, '[bsdate') !== false) {
            $pattern = get_shortcode_regex(array('bsdate'));
            $content = preg_replace_callback("/$pattern/", 'parseDateProgressCallback', $content);
    }
     //Audio
    if (strpos($content, '[bsaudio') !== false) {
            $pattern = get_shortcode_regex(array('bsaudio'));
            $content = preg_replace_callback("/$pattern/", 'parseAudioCallback', $content);
    }
    //tag
    if (strpos($content, '[bstag') !== false || strpos($content, '[tag') !== false) {
            $pattern = get_shortcode_regex(array('bstag','tag'));
            $content = preg_replace_callback("/$pattern/", 'parseTagCallback', $content);
    }

    //音乐歌单
    if (strpos($content, '[bsmusic') !== false) {
        if($modetype == 'noreadmode'){
            $pattern = get_shortcode_regex(array('bsmusic'));
            $content = preg_replace_callback("/$pattern/", 'parseMusicCallback', $content);
        }
        else{
            $pattern = get_shortcode_regex(array('bsmusic'));
            $content = preg_replace_callback("/$pattern/", 'parseMusicRdCallback', $content);
        }
    }
    //opc
    
    if (strpos($content, '[bsopc') !== false) {
            $pattern = get_shortcode_regex(array('bsopc'));
            $content = preg_replace_callback("/$pattern/", 'parseOpcCallback', $content);
    }
    //文字提示
    if (strpos($content, '[bstip') !== false) {
            $pattern = get_shortcode_regex(array('bstip'));
            $content = preg_replace_callback("/$pattern/", 'parseTipCallback', $content);
    }
    //tabs
    
    if (strpos($content, '[bstabs') !== false) {
            $pattern = get_shortcode_regex(array('bstabs'));
            $content = preg_replace_callback("/$pattern/", 'parseTabsCallback', $content);
    }
    //评星
    if (strpos($content, '[bseva') !== false) {
            $pattern = get_shortcode_regex(array('bseva'));
            $content = preg_replace_callback("/$pattern/", 'parseEvaluationCallback', $content);
    }
    //Bframe
    if (strpos($content, '[bsfra') !== false) {
            $pattern = get_shortcode_regex(array('bsfra'));
            $content = preg_replace_callback("/$pattern/", 'parseBsfraCallback', $content);
    }
    //Bplayer
    if (strpos($content, '[bsplayer') !== false) {
            $pattern = get_shortcode_regex(array('bsplayer'));
            $content = preg_replace_callback("/$pattern/", 'parsePlayerCallback', $content);
    }
    //Bmp3
    if (strpos($content, '[bsmp3') !== false) {
            $pattern = get_shortcode_regex(array('bsmp3'));
            $content = preg_replace_callback("/$pattern/", 'parseMp3Callback', $content);
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
        //60s
    if (strpos($content, '[bspaper') !== false) {
            $pattern = get_shortcode_regex(array('bspaper'));
            $content = preg_replace_callback("/$pattern/", 'quotebspaperCallback', $content);
        }

    //标注
   if (strpos($content, '[bsmark') !== false) {
        $content = preg_replace('/\[bsmark\](.*?)\[\/bsmark\]/sm', '<mark class="text-highlight">$1</mark>', $content);
   }
   
   //点击复制内容
    if (strpos($content, '[bscopy') !== false) {
            $pattern = get_shortcode_regex(array('bscopy'));
            $content = preg_replace_callback("/$pattern/", 'parseCopyCallback', $content);
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
                $content = preg_replace_callback("/$pattern/", function ($matches) use ($login,$options) {
                    if ($matches[1] == '[' && $matches[6] == ']') {
                        return substr($matches[0], 1, -1);
                    }
                    if ($login) {
                         return '<div class="ui floating message">'.$matches[5].'</div>';
                    } else {
                        $r = empty($options['globalTips']['articleHideAfterLogin_Tip'])? '<div class="ui floating message"><i class="thumbtack icon"></i>此处内容需要登录后方可阅读。</div>' : '<div class="ui floating message"><i class="thumbtack icon"></i>'.$options['globalTips']['articleHideAfterLogin_Tip'].'</div>';
                      return $r;
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
                $content = preg_replace_callback("/$pattern/", function ($matches) use ($login,$hasComments,$options,$requireModeration) {
                    if ($matches[1] == '[' && $matches[6] == ']') {
                        return substr($matches[0], 1, -1);
                    }
                    if ($login || $hasComments !== 0) {
                         return '<div class="ui floating message">'.$matches[5].'</div>';
                    } 
                    if(!$options['globalTips']['articleHideAfterComment_Tip'] && $requireModeration == true){
                    return '<div class="ui floating message"><i class="thumbtack icon"></i>此处内容需要登录或评论(审核通过)后方可阅读。</div>';    
                    }
                    if(!$options['globalTips']['articleHideAfterComment_Tip'] && $requireModeration == false){
                    return '<div class="ui floating message"><i class="thumbtack icon"></i>此处内容需要登录或评论后方可阅读。</div>';    
                    }
                    if(!empty($options['globalTips']['articleHideAfterComment_Tip'])){ 
                        return '<div class="ui floating message"><i class="thumbtack icon"></i>'.$options['globalTips']['articleHideAfterComment_Tip'].'</div>';
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
            $content = preg_replace("/\{bs-hide\}(.*?)\{\/bs-hide\}/sm",'<div class="ui floating message"><i class="thumbtack icon"></i>此处内容需要登录或评论后方可阅读。</div>',$post);
        }
    }
    //兼容1.6.3版本前的回复可见短代码
    if (strpos($content, '[bs-hide') !== false) {
        $db = Typecho_Db::get();
        $hasComment = $db->fetchAll($db->select()->from('table.comments')->where('cid = ?', $t->cid)->where('mail = ?', $t->remember('mail', true))->limit(1));

        if ($hasComment||$login) {
           $content = preg_replace("/\[bs-hide\](.*?)\[\/bs-hide\]/sm",'<div class="ui floating message">$1</div>',$post);
        } else {
            $content = preg_replace("/\[bs-hide\](.*?)\[\/bs-hide\]/sm",'<div class="ui floating message"><i class="thumbtack icon"></i>此处内容需要登录或评论后方可阅读。</div>',$post);
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
        $content = preg_replace('/\{bs-iframe\}(.*?)\{\/bs-iframe\}/sm', '<div class="iframe"><iframe class="iframe_video" src="$1" scrolling="yes" border="0" frameborder="no" framespacing="0" allowfullscreen="true"></iframe></div>', $content);
        $content = preg_replace('/\<iframe class="iframe_video" src="<a href="(.*?)">(.*?)<\/a>" scrolling="yes" border="0" frameborder="no" framespacing="0" allowfullscreen="true"><\/iframe>/sm', '<iframe class="iframe_video" src="$1" scrolling="yes" border="0" frameborder="no" framespacing="0" allowfullscreen="true"></iframe>', $content);
   }
   

    if(strpos($content,'- [x]')!==false||strpos($content,'- [ ]')!==false){
            $attributes = array("style"=>"list-style: none;");
            $content = str_replace(array('- [x]','- [ ]'), array(
                '<input type="checkbox" checked="true" disabled="true">',
                '<input type="checkbox" disabled="true">',
            ), $content);
        }
    if(strpos($content,'-[x]')!==false||strpos($content,'-[ ]')!==false){
            $attributes = array("style"=>"list-style: none;");
            $content = str_replace(array('-[x]','-[ ]'), array(
                '<input type="checkbox" checked="true" disabled="true">',
                '<input type="checkbox" disabled="true">',
            ), $content);
        }
        if(strpos($content,'[x]')!==false||strpos($content,'[ ]')!==false){
            $attributes = array("style"=>"list-style: none;");
            $content = str_replace(array('[x]','[ ]'), array(
                '<input type="checkbox" checked="true" disabled="true">',
                '<input type="checkbox" disabled="true">',
            ), $content);
        }
        
        //判断是否为外链并判断是否新窗口打开
        $content = preg_replace_callback("/<a href=\"(.*?)\">(.*?)<\/a>/is", function ($matches){
           $options = bsOptions::getInstance()::get_option( 'bearsimple' );
           $optionss = Helper::options();
            if (strpos($matches[1],$optionss->siteUrl) !== false || strpos(substr($matches[1],0,6),"http") === false){
                return '<a class="link-hover" style="text-decoration:none" href="'.$matches[1].'"><span><i class="external alternate icon"></i>'.$matches[2].'</span></a>';
            }else{
                if ($options['Link_blank']== '2'){
                return '<a class="link-hover" style="text-decoration:none"  href="'.$matches[1].'" target="_blank"><span><i class="external alternate icon"></i>'.$matches[2]."</span></a>";
                }
                else{
                return '<a class="link-hover" style="text-decoration:none" href="'.$matches[1].'"><span><i class="external alternate icon"></i>'.$matches[2]."</span></a>";     
                }
            }
        }, $content);
        
    }
    else{
        
        if ($options['Lightbox'] == '1' || $options['Watermark'] == '1'){
    $pattern = '/<\s*img[\s\S]+?(?:src=[\'"]([\S\s]*?)[\'"]\s*|alt=[\'"]([\S\s]*?)[\'"]\s*|[a-z]+=[\'"][\S\s]*?[\'"]\s*)+[\s\S]*?>/i';
   if($modetype == 'noreadmode'){
            $mark = 'bearmark';
        }
        else{
           $mark = 'bearmarkread';
        }
 $replacement = '
  <a class="card">
    <div class="image">
      <img '.lazyload(1).'src="$1" class="'.$mark.' lazyload lazyload-style-'.$options['Lazyload_style'].'"   alt="$2" title="点击放大图片">
    </div>
  </a>'; 
    $content = preg_replace($pattern, $replacement, $content);
   

    }
    else{
        $pattern = '/<\s*img[\s\S]+?(?:src=[\'"]([\S\s]*?)[\'"]\s*|alt=[\'"]([\S\s]*?)[\'"]\s*|[a-z]+=[\'"][\S\s]*?[\'"]\s*)+[\s\S]*?>/i';
   
 $replacement = '
  <a class="card">
    <div class="image">
      <img '.lazyload().'src="$1"   alt="$2" title="点击放大图片">
    </div>
  </a>'; 
    $content = preg_replace($pattern, $replacement, $content);
    }
    
    }

   
   if($articletype == 'pic_Mode'){
    $content = "<div class=\"ui four doubling cards\">".preg_replace("/<p.*?>|<\/p>|<br.*?>/is","", $content)."</div>";
   }
   if($modetype == 'noreadmode'){

    $content = "<div id=\"bearsimple-images\">".$content."</div>";
   }
   else{
       
       $content = "<div id=\"bearsimple-images-readmode\">".$content."</div>";
   }
   //添加目录树识别
   if(preg_match('/<h([1-6])(.*?)>(.*?)<\/h\1>/i',$content)){
       $content = "<div class=\"bmenutree\"></div>".$content;
   }
    return $content;
}

function parselink($link){
    //判断是否为外链并判断是否新窗口打开
            $options = bsOptions::getInstance()::get_option( 'bearsimple' );
            $optionss = Helper::options();
            if (strpos($link,$optionss->siteUrl) !== false || strpos(substr($link,0,6),"http") === false){
                $link =  '';
            }else{
                if ($options['Link_blank'] == '2'){
                $link =  ' target="_blank"';
                }
                else{
                $link =  '';  
                }
            }
        return $link;
}
function getUniqueId()
    {
        global $playerID;
        $playerID++;
        return $playerID;
    } 
    
function getAcgFile(){
    $getAcgFile = Helper::options()->siteUrl.'index.php/getacg';
    echo $getAcgFile;
}

function getGhFile(){
    $getGhFile =Helper::options()->siteUrl.'index.php/getgithub';
    echo $getGhFile;
}

function getCrossFile(){
    $getGhFile =Helper::options()->siteUrl.'index.php/searchcross';
    echo $getGhFile;
}

function getDoubanFile(){
    $getDoubanFile = Helper::options()->siteUrl.'index.php/getdouban';
    echo $getDoubanFile;
}

function getAttachFile(){
    $getAttachFile = Helper::options()->siteUrl.'index.php/write';
    echo $getAttachFile;
}

function getCommentLikeFile(){
    $getCommentLikeFile = Helper::options()->siteUrl.'index.php/commentlike';
    echo $getCommentLikeFile;
}

function getPostLikeFile(){
    $getPostLikeFile = Helper::options()->siteUrl.'index.php/postlike';
    echo $getPostLikeFile;
}
function getFriendFile(){
    $getFriendFile = Helper::options()->siteUrl.'index.php/friendajax';
    echo $getFriendFile;
}
function getEncrypt(){
    $getEncrypt = Helper::options()->siteUrl.'index.php/getencrypt';
    echo $getEncrypt;
}
function getPoster(){
    $getPoster = Helper::options()->siteUrl.'index.php/getPosterInfo';
    echo $getPoster;
}
function getIsLogin(){
    $getIsLogin = Helper::options()->siteUrl.'index.php/getIsLogin';
    echo $getIsLogin;
}
function getSign(){
    $getSign = Helper::options()->siteUrl.'index.php/bgetSign';
    echo $getSign;
}
function getUserAction(){
    $getUserAction = Helper::options()->siteUrl.'index.php/bUserAction';
    echo $getUserAction;
}
function getCommentAction(){
    $getCommentAction = Helper::options()->siteUrl.'index.php/getCommentAction';
    echo $getCommentAction;
}
function getMemosAction(){
    $getMemosAction = Helper::options()->siteUrl.'index.php/getMemosAction';
    echo $getMemosAction;
}