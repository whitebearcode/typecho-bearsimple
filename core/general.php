<?php
function getTitle(\Widget\Archive $var)
    {
        $var->archiveTitle(array(
            'category'  =>  _t('分类「%s」下的文章'),
            'search'    =>  _t('包含关键字「%s」的文章'),
            'tag'       =>  _t('标签「%s」下的文章'),
            'author'    =>  _t('作者「%s」的个人资料')
        ), '', ' - ');
        Helper::options()->title();
    }

function getDescription($var)
    {
          if($var->is('post')){
           echo $var->excerpt(50);
        }
else{
           echo  getTitle($var);
        }
        
    }
    
//获取作者指定字段
function getAuthorInfo($uid,$value){
$db = Typecho_Db::get();
$result = $db->fetchAll($db->select()->from('table.users')
->where('uid = ?',$uid)
);
return $result[0][$value];
}


if (!function_exists('is_https')) {
    function is_https() {
        if(!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') {
            return true;
        } elseif(isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https' ) {
            return true;
        } elseif(!empty($_SERVER['HTTP_FRONT_END_HTTPS']) && strtolower($_SERVER['HTTP_FRONT_END_HTTPS']) !== 'off') {
            return true;
        }
        return false;
    }
}


//修改网址
function editurl($url){
$options = Helper::options();
if (strpos($options->siteUrl, "https://") !== false) {
    echo str_replace('http://','https://',$url);
} else {
    echo $url;
}
}
//通过分类mid获取到分类名字
function getCategoryName($category) {
$db = Typecho_Db::get();
$prefix = $db->getPrefix();
$rs = $db->fetchRow($db->select()->from($prefix.'metas')->where('mid = ?', $category)->limit(1));
return $rs['name'];
}
//输出日期和周几
function monweek(){
    $arr = array("日","一","二","三","四","五","六");
     echo date(' Y年m月d日',time()). " 星期".$arr[date("w")];   
}
// 获取所有分类和分类文章数量
function getPostAndNum(){
    $db = Typecho_Db::get();     
    $a = array();
    $result = $db->fetchAll($db->select()
    ->from('table.metas')
            ->where('table.metas.type = ?', 'category'));
            foreach($result as $post){
                $a[] = array(
                    'value'=>$post['count'],
                    'name'=>$post['name'],
                    );
            }
return json_encode($a);

}

// 获取所有标签和标签文章数量
function getTagAndNum($type){
    $db = Typecho_Db::get();     
    $arr = array();
    $result = $db->fetchAll($db->select()
    ->from('table.metas')
            ->where('table.metas.type = ?', 'tag')
            ->where('table.metas.count != ?', 0)
            );
            if($type == 'name'){
            foreach($result as $tag){
                $arr[] = $tag['name'];
            }
            }
             elseif($type == 'num'){
            foreach($result as $tag){
                $arr[] = $tag['count'];
            }
            }
return json_encode($arr);

}

//获取随机文章
function getArchived(){
    $db = Typecho_Db::get();      
    $result = $db->fetchAll($db->select()
    ->from('table.contents')
            ->where('table.contents.status = ?', 'publish')
            ->where('table.contents.created < ?', Helper::options()->time)
            ->where('table.contents.type = ?', 'post')
            ->order('table.contents.created', Typecho_Db::SORT_DESC));
return $result;
}
//获取随机文章
function getRandomPosts(){
$db = Typecho_Db::get();
$result = $db->fetchAll($db->select()->from('table.contents')
->where('status = ?','publish')
->where('type = ?', 'post')
->where('created < ?', Helper::options()->time)
->order('rand()')
->limit(6)
);

if($result){
   $i = 1;
foreach($result as $val){

$val = Typecho_Widget::widget('Widget_Abstract_Contents')->push($val);
if(!$val['hidden']){
$post_title = htmlspecialchars($val['title']);
$permalink = $val['permalink'];
$date = date('Y年m月d日',$val['created']);
$md = new Markdown();
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
    
echo '
<div class="bsmorepost-item">
			<div class="bsmorepost-item-box">
		
				<div class="bsmorepost-content">
					<div class="bsmorepost-content-wrap">
					
						
						<h3 class="bsmorepost-title"><a class="title-animation-underline" href="'.$permalink.'" title="'.$post_title.'">'.$post_title.'</a></h3>
						<div class="bsmorepost-text">
							<p>'.$targetSummary.'</p>
						</div>
						<div class="bsmorepost-counter">
							0'.$i.'
						</div>
					</div>
				</div>
			</div>
		</div>';
}
$i++;
}

}
}

//获取文章标签
function tags($widget, $split = '', $default = NULL)
{

    if ($widget->tags) {
 
        $result = array();
        $result[] = '<div class="ui labels">';
        foreach ($widget->tags as $tag) {
        $result[] .= '<a class="ui label" href="'.$tag['permalink'].'">#'.$tag['name'].'</a>';
        }
 $result[] .= '</div>';
        echo implode($split,$result);
    } else {
        echo $default;
    }
}


//获取分类ID
function categeid($slug){
   $db = Typecho_Db::get();
   $postnum=$db->fetchRow($db->select()->from ('table.metas')->where ('slug=?',$slug)->where('type=?', 'category'));
   return $postnum['mid']; 
}
//Md5加密
function md5Encode($data){
    return md5("bearsimplev2!@#$%^&*()-=+@#$%$".$data."bearsimplev2!@#$%^&*()-=+@#$%$");
}

function seacharr_by_value($array, $index, $value){
    if(is_array($array) && count($array)>0) {
        foreach(array_keys($array) as $key){
            $temp[$key] = $array[$key][$index];
            if ($temp[$key] == $value){
                $newarray[$key] = $array[$key];
            }
        }
    }
    return $newarray;
}
 function getDiyLinkToArray($data){
    $res = array();
foreach($data as $k=>$v){
    $res[]= array(
        'url' => $v[1],
        'key'=>$v[0]
        );
        
}
return $res;
 }
//获取自定义内链
function getDiyLink($key){
    $options = bsOptions::getInstance()::get_option('bearsimple');
    $data = parseMultilineData(BsOptions('goLinkList'),2);
    $result = seacharr_by_value(getDiyLinkToArray($data),'key',$key);
    $res = array();
foreach($result as $k=>$v){
   foreach ($v as $key=>$value) {
      $res[$key] = $value;
   }
}
    return $res;
}

//分类密码
function CategoryEncrypt($id){
    $options = bsOptions::getInstance()::get_option('bearsimple');
    $data = BsOptions('Cate_Encrypt');
    $result = seacharr_by_value($data,'Cate_Encrypt_Id',$id);
    $res = array();
foreach($result as $k=>$v){
   foreach ($v as $key=>$value) {
      $res[$key] = $value;
   }
}
    return $res;
}


//分类相册
function CategoryAlbum($id){
    $options = bsOptions::getInstance()::get_option('bearsimple');
    $data = BsOptions('Cate_Album');
    $result = seacharr_by_value($data,'Cate_Album_Id',$id);
    $res = array();
foreach($result as $k=>$v){
   foreach ($v as $key=>$value) {
      $res[$key] = $value;
   }
}
    return $res;
}


//统计全站字数
function allOfCharacters() {
    $Characters = Typecho_Cookie::get('site_Characters');
    if(!$Characters){
    $chars = 0;
    $db = Typecho_Db::get();
    $select = $db ->select('text')->from('table.contents');
    $rows = $db->fetchAll($select);
    foreach ($rows as $row) { $chars += mb_strlen(trim($row['text']), 'UTF-8'); }
    $unit = '';
    if($chars >= 10000)     { $chars /= 10000; $unit = 'w'; } 
    else if($chars >= 1000) { $chars /= 1000;  $unit = 'k'; }
    $out = sprintf('%.2lf %s',$chars, $unit);
    Typecho_Cookie::set('site_Characters',$out);
    $Characters = $out;
    }
 
    return $Characters;
}

function historyToday($created)
{
    $date = date('m/d', $created);
    $date_m = date('m月', $created);
    $date_d = date('d日', $created);
    $time = time();
    $db = Typecho_Db::get();
    $prefix = $db->getPrefix();
    $options = bsOptions::getInstance()::get_option( 'bearsimple' );
    if(empty($options['history_Today_Limit'])){
        $limit = 5;
    }
    else{
        $limit = $options['history_Today_Limit'];
    }
    
     $adapter = $db->getAdapterName();
     if ("Pdo_SQLite" === $adapter || "SQLite" === $adapter || "pgsql" === $adapter || "Pdo_Pgsql" === $adapter) {
    $sql = "SELECT * FROM `{$prefix}contents` WHERE strftime('%m-%d',datetime(datetime(created, 'unixepoch'))) = '{$date}' and created <= {$time} and created != {$created} and type = 'post' and status = 'publish' and (password is NULL or password = '') LIMIT ".$limit;
     }
     if ("Pdo_Mysql" === $adapter || "Mysql" === $adapter || "Mysqli" === $adapter) {
          $sql = "SELECT * FROM `{$prefix}contents` WHERE DATE_FORMAT(FROM_UNIXTIME(created), '%m/%d') = '{$date}' and created <= {$time} and created != {$created} and type = 'post' and status = 'publish' and (password is NULL or password = '') LIMIT ".$limit;
     }
    $result = $db->query($sql);
    $historyTodaylist = [];
    if ($result instanceof Traversable) {
            foreach ($result as $item) {
                $item = Typecho_Widget::widget('Widget_Abstract_Contents')->push($item);
                $title = htmlspecialchars($item['title']);
            $permalink = $item['permalink'];
            $date = date('Y年m月d日',$created);
            $historydate = date('Y年m月d日',$item['created']);
                $historyTodaylist[] = array(
                    "title" => $title,
                    "permalink" => $permalink,
                    "date" => $historydate
                );
    }
    }
  if (count($historyTodaylist) > 0){
      echo "<div class='bs-today'>
    <fieldset>
        <legend><h5>那年今日</h5></legend>
        <div class='today-date'><div class='today-m'>{$date_m}</div><div class='today-d'>{$date_d}</div></div><ul>
        ";
        foreach ($historyTodaylist as $item){
            echo "<li><span>{$item['date']}</span><a href='{$item['permalink']}' title='{$item['title']}' target='_blank'>{$item['title']}</a></li>";
        }
        echo "</ul></fieldset></div>";
  }
}




function ishttps()
{
    if (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') {
        return true;
    } elseif (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
        return true;
    } elseif (!empty($_SERVER['HTTP_FRONT_END_HTTPS']) && strtolower($_SERVER['HTTP_FRONT_END_HTTPS']) !== 'off') {
        return true;
    }
    return false;
}


function imgtobase64($img='', $imgHtmlCode=true){
    $imageInfo = getimagesize($img);
    $base64 = "" . chunk_split(base64_encode(file_get_contents($img)));
    return 'data:' . $imageInfo['mime'] . ';base64,' . chunk_split(base64_encode(file_get_contents($img)));
}

function CommentAuthor($obj, $autoLink = NULL, $noFollow = NULL) {
    $options = Helper::options();
    $autoLink = $autoLink ? $autoLink : $options->commentsShowUrl;
    $noFollow = $noFollow ? $noFollow : $options->commentsUrlNofollow;
    if ($obj->url && $autoLink) {
        echo '<a href="'.$obj->url.'"'.($noFollow ? ' rel="external nofollow"' : NULL).(strstr($obj->url, $options->index) == $obj->url ? NULL : ' target="_blank"').'>'.$obj->author.'</a>';
    } else {
        echo $obj->author;
    }
}

function categorynum($id){
$db = Typecho_Db::get();
$num=$db->fetchRow($db->select()->from('table.metas')
        ->where('mid = ?',$id));
return $num['count'];
}

function categoryid($slug){  //获取栏目id
   $db = Typecho_Db::get();
   $postnum=$db->fetchRow($db->select()->from ('table.metas')->where ('slug=?',$slug)->where('type=?', 'category'));
   return  $postnum['mid']; 
}

//截断文字
function cutexpert($string, $length='20', $dot = '…') {
    $_lenth = mb_strlen($string, "utf-8");
    $text_str = preg_replace(array("/<pre><code.*?>/si","/<img.*?>/si"),"",$string);
    $text_lenth = mb_strlen($text_str, "utf-8") - 1;
    if($text_lenth <= $length) {
        return strip_tags(stripcslashes($text_str));
    }
    else{
        $res = mb_substr($text_str, 0, $length, 'UTF-8');
        return strip_tags(stripcslashes($res)).$dot;
    }
}

//截断文本，主要用于侧边栏最新评论，保留img标签
function bearcutword($string, $length='20', $dot = '…') {
    $_lenth = mb_strlen($string, "utf-8");
    $text_str = preg_replace("/<img.*?>/si","",$string);
    $text_lenth = mb_strlen($text_str, "utf-8") - 1;
     
    if($text_lenth <= $length) {
        return stripcslashes($string);
    }
     
    if(strpos($string, '<img') === false){
        $res = mb_substr($string, 0, $length, 'UTF-8');
        return stripcslashes($res).$dot;
    }
 
    $html_start = ceil(strpos($string, '<img') / 3);
    $html_end = ceil(strpos($string, '/>') / 3);
     
    if($length < $html_start) {
        $res = mb_substr($string, 0, $length, 'UTF-8');
        return stripcslashes($res).$dot;
    }
     
    if($length > $html_start) {
         
        $res_html = mb_substr($text_str, 0, $length-1, 'UTF-8');
         
        preg_match('/<img[^>]*\>/',$string,$result_html);
        $before = mb_substr($res_html, 0, $html_start, 'UTF-8');
        $after = mb_substr($res_html, $html_start, mb_strlen($res_html, "utf-8"), 'UTF-8');
        $res = $before.$result_html[0].$after;
        return stripcslashes($res).$dot;
    }
     
}

function strFilter($str){
    $str = str_replace('`', '', $str);
    $str = str_replace('·', '', $str);
    $str = str_replace('~', '', $str);
    $str = str_replace('!', '', $str);
    $str = str_replace('！', '', $str);
    $str = str_replace('@', '', $str);
    $str = str_replace('#', '', $str);
    $str = str_replace('$', '', $str);
    $str = str_replace('￥', '', $str);
    $str = str_replace('%', '', $str);
    $str = str_replace('^', '', $str);
    $str = str_replace('……', '', $str);
    $str = str_replace('&', '', $str);
    $str = str_replace('*', '', $str);
    $str = str_replace('(', '', $str);
    $str = str_replace(')', '', $str);
    $str = str_replace('（', '', $str);
    $str = str_replace('）', '', $str);
    $str = str_replace('-', '', $str);
    $str = str_replace('_', '', $str);
    $str = str_replace('——', '', $str);
    $str = str_replace('+', '', $str);
    $str = str_replace('=', '', $str);
    $str = str_replace('|', '', $str);
    $str = str_replace('\\', '', $str);
    $str = str_replace('[', '', $str);
    $str = str_replace(']', '', $str);
    $str = str_replace('【', '', $str);
    $str = str_replace('】', '', $str);
    $str = str_replace('{', '', $str);
    $str = str_replace('}', '', $str);
    $str = str_replace(';', '', $str);
    $str = str_replace('；', '', $str);
    $str = str_replace(':', '', $str);
    $str = str_replace('：', '', $str);
    $str = str_replace('\'', '', $str);
    $str = str_replace('"', '', $str);
    $str = str_replace('“', '', $str);
    $str = str_replace('”', '', $str);
    $str = str_replace(',', '', $str);
    $str = str_replace('，', '', $str);
    $str = str_replace('<', '', $str);
    $str = str_replace('>', '', $str);
    $str = str_replace('《', '', $str);
    $str = str_replace('》', '', $str);
    $str = str_replace('.', '', $str);
    $str = str_replace('。', '', $str);
    $str = str_replace('/', '', $str);
    $str = str_replace('、', '', $str);
    $str = str_replace('?', '', $str);
    $str = str_replace('？', '', $str);
    return trim($str);
}

function strtitle(){
    $title = bsOptions::getInstance()::get_option( 'bearsimple' )->title;
    $title = strFilter($title);
    return $title;
}

function readModeContent($th,$content){
 $author = $th->author->screenName;
$date = date("Y年 m月 d 日",$th->date->timeStamp);
$title = $th->title;
$avatar = imgravatarq($th->author->mail);
            return <<<EOF
            
<div id="read__mode" style="position: absolute;top: -9999px;left: -9999px;">
<div id="read_modes">
 <div class="ui grid">
                  <div class="sixteen wide column">
                  <div class="ui text container"  id="read__mode__close__hover">

<div id="read__mode__close" style="margin-top:20px">
    <button class="circular ui icon button" id="read__mode__close__btn">
 <i class="x link white icon"></i>
</button>
    </div>
<div id="read__mode__content" style="margin-top:50px">
                     <h1 class="ui header readmode__title">
  <div class="content">
    {$title}
    <div class="sub header">{$date}
    </div>
  </div>
</h1>   
<div class="ui large horizontal divided list" style="margin-top:-5px">
  <div class="item">
    <img class="ui mini circular image" src="{$avatar}">
    <div class="content">
      <div class="ui sub header">{$author}</div>
    </div>
  </div>
  </div>
  <div class="post">
  <div class="post-content">
      <div class="read_content">
  <p>
  
{$content}

  </p></div></div></div>
</div>
    </div>
</div>   
  </div> <div style="margin-top:100px"></div>
  </div></div>
EOF;
}
function agreeNum($cid) {
    $db = Typecho_Db::get();
    $prefix = $db->getPrefix();
    if (!array_key_exists('agree', $db->fetchRow($db->select()->from('table.contents')))) {
        $db->query('ALTER TABLE `' . $prefix . 'contents` ADD `agree` INT(10) NOT NULL DEFAULT 0;');
    }
    $agree = $db->fetchRow($db->select('table.contents.agree')->from('table.contents')->where('cid = ?', $cid));
    
    return array(
        'agree' => $agree['agree'],
        );
}

function agree($cid) {
    $db = Typecho_Db::get();
    $agree = $db->fetchRow($db->select('table.contents.agree')->from('table.contents')->where('cid = ?', $cid));
    
    $db->query($db->update('table.contents')->rows(array('agree' => (int)$agree['agree'] + 1))->where('cid = ?', $cid));
    $agree = $db->fetchRow($db->select('table.contents.agree')->from('table.contents')->where('cid = ?', $cid));
    return $agree['agree'];
}

function agreeNumforcomment($coid) {
    $db = Typecho_Db::get();
    $prefix = $db->getPrefix();
    if (!array_key_exists('agree', $db->fetchRow($db->select()->from('table.comments')))) {
        $db->query('ALTER TABLE `' . $prefix . 'comments` ADD `agree` INT(10) NOT NULL DEFAULT 0;');
    }
    $agree = $db->fetchRow($db->select('table.comments.agree')->from('table.comments')->where('coid = ?', $coid));
    
    return array(
        'agree' => $agree['agree'],
        );
}

function agreeforcomment($coid) {
    $db = Typecho_Db::get();
    $agree = $db->fetchRow($db->select('table.comments.agree')->from('table.comments')->where('coid = ?', $coid));
    
    $db->query($db->update('table.comments')->rows(array('agree' => (int)$agree['agree'] + 1))->where('coid = ?', $coid));
    $agree = $db->fetchRow($db->select('table.comments.agree')->from('table.comments')->where('coid = ?', $coid));
    return $agree['agree'];
}

function theAllViews()
        {
            $db = Typecho_Db::get();
            $prefix = $db->getPrefix();
            $row = $db->fetchAll('SELECT SUM(VIEWS) FROM `' . $prefix . 'contents`');
                echo number_format($row[0]['SUM(VIEWS)']);
        }


//输出样式
function bs_style(){
    $options = bsOptions::getInstance()::get_option( 'bearsimple' );
    echo '
    <style>
    a{color:#000000;}';
    if($options['width_Selection'] == '2'){
      echo '
@media only screen and (min-width: 1500px) {
          .body_container {
	max-width:100%;
}';

if($options['Article_forma'] == "5"){
    echo '
.blog-card{
    max-width:100%;
}
';
}
echo '
}
';
    
    }
  if($options['Popup'] == 1){
     if($options['PopupColor']){ 
      echo '.announcement-wrap{
          background:'.$options['PopupColor'].'!important;
      }';
     }
     if($options['PopupBorderColor']){ 
      echo '.announcement-wrap{
          border:1px solid '.$options['PopupBorderColor'].'!important;
      }';
     }
     if($options['PopupContentColor']){ 
      echo '.announcement-content{color:'.$options['PopupContentColor'].'!important}';
     }
     if($options['PopupTitleColor']){ 
      echo '.announcement-title{color:'.$options['PopupTitleColor'].'!important;}';
     }
     if($options['PopupButtonColor']){ 
      echo '.announcement-button>div{background:center center no-repeat '.$options['PopupButtonColor'].'!important}';
     }
     if($options['PopupZdHoverColor']){ 
      echo '.announcement-button>div.announcement-toggle:hover{background-color:'.$options['PopupZdHoverColor'].'!important}';
     }
     if($options['PopupCloseHoverColor']){ 
      echo '.announcement-button>div.announcement-close:hover{background-color:'.$options['PopupCloseHoverColor'].'!important}';
     }
  }
    echo '
    .swal2-container{
        z-index:1000000;
    }
    .bearmargin{
        margin:auto!important;
    }
    .bearslider-wrapper{
          border-radius:8px;
      }
      .bearslider-wrapper img{
          border-radius:8px;
      }
      .bearslider-caption{
         border-radius:8px; 
      }
.mjx-chtml{
        white-space: normal!important;
    }
    .button > .hidden{
        display:block !important;
    }
  
    .body_container{
     background-color:rgba(255,255,255,0.9);   
     border-radius:5px;
    ';
    if($options['global_transparent'] == '1'){
     echo 'opacity: .9;
     transition: opacity .5s;';   
    }
    if($options['global_shadow'] == '1'){
     echo 'box-shadow: 0 0 20px 6px rgba(0,0,0,.12),0 0 20px 6px rgba(0,0,0,.12)';   
    }
    echo '}';
    if ($options['Mournmode'] == "1"){
        echo '
        .gray {
  filter: grayscale(1);
}
.gray {
  -webkit-filter: grayscale(1);
  filter: grayscale(1);
  filter: progid:DXImageTransform.Microsoft.BasicImage(grayscale=1);
}
        ';
    }
  
    if(Bsoptions('Top') == true){
        echo'
        .goTop >svg{
            width: 50px;
            height: 50px;
            cursor: pointer;
        }
        .goTop >img{
            width: 50px;
            height: 50px;
            cursor: pointer;
        }
        .goTop{
            position: fixed;
            right : 20px;
            ';if(Bsoptions('Darkmode') == true){echo'bottom : 70px;';}else{echo'bottom : 20px;';}
            echo'
            z-index:50;
        }
        ';
    }
    if(Bsoptions('article_textindent') == true){
        echo '
    .post-content p{text-indent: 2em;}.post-content p a{text-indent:0;}
    ';
    }
     if(!empty($options['BackGround'])){
        echo'
        body{
            background-image: url('.$options['BackGround'].')!important;
            background-position: center center;
            background-repeat: no-repeat;
            background-attachment:fixed;
            background-size:100% 100%;
            -webkit-background-size: cover;
            -o-background-size: cover;
        }
        ';
    }
    if(!empty($options['Diyfont'])){
        echo'
@font-face {
          font-family: CustomFont;
          src: url("'.$options['Diyfont'].'");
        }
     *:not(i){
          font-family: CustomFont !important;
        }
        ';
    }
  
    if(!empty($options['Diyfontsize'])){
        echo'
 *{
font-size:'.$options['Diyfontsize'].'px !important;
}
        ';
    }

echo '
    </style>';
}

//黑暗模式
function darkmode(){
    echo '
    <div class="darkmode">
    <img class="sun hide" src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDUxMiA1MTIiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDUxMiA1MTI7IiB4bWw6c3BhY2U9InByZXNlcnZlIiB3aWR0aD0iNTEycHgiIGhlaWdodD0iNTEycHgiPgo8cGF0aCBzdHlsZT0iZmlsbDojRkZBNjAwOyIgZD0iTTUwNy44MzQsMzAxLjYwOGwtNTQuNzY5LTQ4LjMxMmw1Mi44MzItNTAuMzk5YzEuOTQxLTEuODUyLDIuNzQtNC41OTEsMi4wOTktNy4xODkgIGMtMC42NDItMi41OTctMi42MjktNC42NTUtNS4yMTEtNS40MDFsLTcwLjMxNi0yMC4yOTJsMjUuOTg4LTY4LjA1NmMwLjk1NS0yLjUsMC40OTUtNS4zMTYtMS4yMDQtNy4zODkgIGMtMS43LTIuMDcyLTQuMzgzLTMuMDg1LTcuMDM4LTIuNjU3bC03Mi4yNzQsMTEuNjUybC01Ljg3OC03Mi41NjFjLTAuMjE2LTIuNjY2LTEuODQ2LTUuMDE1LTQuMjc1LTYuMTYxICBjLTIuNDI5LTEuMTQ2LTUuMjkxLTAuOTE3LTcuNTA0LDAuNjAxbC02MC4yNjYsNDEuMzQyTDI2My40MDksMy43NDJDMjYyLjA2NCwxLjQyNiwyNTkuNTc5LDAsMjU2Ljg4OSwwICBjLTIuNjksMC01LjE3NCwxLjQyNi02LjUxOSwzLjc0MkwyMDguMzQ3LDc2LjExbC03Mi42OS00MS45NTNjLTIuMzI3LTEuMzQzLTUuMTk3LTEuMzQ5LTcuNTI4LTAuMDE4ICBjLTIuMzMzLDEuMzMxLTMuNzczLDMuNzk5LTMuNzgsNi40NzNsLTAuMTc2LDcyLjc5NWwtNzIuOTY1LTYuMDE0Yy0yLjY3NS0wLjIyLTUuMjc1LDAuOTk3LTYuODA3LDMuMTk0ICBjLTEuNTMzLDIuMTk3LTEuNzcxLDUuMDQxLTAuNjIyLDcuNDU5bDMxLjI0Miw2NS44MzVMNi41MDgsMjA5LjU2MmMtMi41MTYsMC45NDMtNC4zMzUsMy4xNS00Ljc3Myw1Ljc4OSAgYy0wLjQzOCwyLjYzOCwwLjU3NSw1LjMwOCwyLjY1Niw3LjAwM2w1Ni42MTksNDYuMTUybC01MC44MTMsNTIuNDFjLTEuODY2LDEuOTI1LTIuNTU5LDQuNjk0LTEuODE2LDcuMjY0ICBjMC43NDQsMi41NywyLjgxLDQuNTUsNS40MTksNS4xOTRsNzEuMDU1LDE3LjU1MUw2MS41Niw0MTkuOTM2Yy0wLjg1NiwyLjUzNS0wLjI4Niw1LjMzMSwxLjQ5NCw3LjMzNiAgYzEuNzgxLDIuMDA1LDQuNTAyLDIuOTEzLDcuMTM3LDIuMzgybDcxLjc2LTE0LjQ0M2w4LjcyMSw3Mi4yNzhjMC4zMTksMi42NTUsMi4wNDEsNC45MzgsNC41MTMsNS45OSAgYzIuNDc0LDEuMDUyLDUuMzIzLDAuNzEyLDcuNDc1LTAuODkxbDU4LjU5Ni00My42NDdsMzkuMDU1LDU5LjU2NmMxLjM4MiwyLjE3OSwzLjc4OSwzLjQ5Miw2LjM2NywzLjQ5MiAgYzAuMDk4LDAsMC4xOTYtMC4wMDIsMC4yOTUtMC4wMDZjMi42ODctMC4xMDQsNS4xMTUtMS42MjYsNi4zNjgtMy45OTJsMzQuMTA3LTYyLjQwNWw2MS44MzksMzguOTc0ICBjMi4yNzMsMS40MzIsNS4xMzcsMS41NSw3LjUyMiwwLjMxYzIuMzgyLTEuMjQsMy45MTktMy42NSw0LjAzLTYuMzIybDMuMDMxLTcyLjczNGw3Mi42NzQsOC44NGMyLjY2NCwwLjMyNCw1LjMxLTAuNzkxLDYuOTI4LTIuOTI3ICBjMS42MTgtMi4xMzcsMS45NjYtNC45NjksMC45MTQtNy40M2wtMjguNjM2LTY2Ljk5N2w2OS40NjUtMjMuMDAzYzIuNTUyLTAuODQ1LDQuNDU2LTIuOTc5LDQuOTk3LTUuNTk5ICBDNTEwLjc1MiwzMDYuMDksNTA5Ljg0NSwzMDMuMzgzLDUwNy44MzQsMzAxLjYwOHoiLz4KPGVsbGlwc2Ugc3R5bGU9ImZpbGw6I0ZGREIyRDsiIGN4PSIyNTQuMzUiIGN5PSIyNTQuNjkxIiByeD0iMTU1LjA2OSIgcnk9IjE1NC45NDkiLz4KPHBhdGggc3R5bGU9ImZpbGw6I0ZGQ0EwMDsiIGQ9Ik0yNTQuMzU0LDk5Ljc0M2MtMy44ODQsMC03LjczMiwwLjE0Ny0xMS41NDMsMC40MjhjODAuMjUsNS45MDEsMTQzLjUyNSw3Mi44MjUsMTQzLjUyNSwxNTQuNTIxICBjMCw4MS42OTUtNjMuMjc1LDE0OC42MTktMTQzLjUyNSwxNTQuNTIxYzMuODExLDAuMjgsNy42NiwwLjQyOCwxMS41NDMsMC40MjhjODUuNjQxLDAsMTU1LjA2OC02OS4zNzMsMTU1LjA2OC0xNTQuOTQ4ICBDNDA5LjQyMiwxNjkuMTE2LDMzOS45OTUsOTkuNzQzLDI1NC4zNTQsOTkuNzQzeiIvPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K" />
    <img class="moon" src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDQ5OS43MTIgNDk5LjcxMiIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgNDk5LjcxMiA0OTkuNzEyOyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSIgd2lkdGg9IjUxMnB4IiBoZWlnaHQ9IjUxMnB4Ij4KPHBhdGggc3R5bGU9ImZpbGw6I0ZGRDkzQjsiIGQ9Ik0xNDYuODgsMzc1LjUyOGMxMjYuMjcyLDAsMjI4LjYyNC0xMDIuMzY4LDIyOC42MjQtMjI4LjY0YzAtNTUuOTUyLTIwLjE2LTEwNy4xMzYtNTMuNTItMTQ2Ljg4ICBDNDI1LjA1NiwzMy4wOTYsNDk5LjY5NiwxMjkuNjQsNDk5LjY5NiwyNDMuNzA0YzAsMTQxLjM5Mi0xMTQuNjA4LDI1Ni0yNTYsMjU2Yy0xMTQuMDY0LDAtMjEwLjYwOC03NC42NC0yNDMuNjk2LTE3Ny43MTIgIEMzOS43NDQsMzU1LjM2OCw5MC45NDQsMzc1LjUyOCwxNDYuODgsMzc1LjUyOHoiLz4KPHBhdGggc3R5bGU9ImZpbGw6I0Y0QzUzNDsiIGQ9Ik00MDEuOTIsNDIuNzc2YzM0LjI0LDQzLjUwNCw1NC44MTYsOTguMjcyLDU0LjgxNiwxNTcuOTUyYzAsMTQxLjM5Mi0xMTQuNjA4LDI1Ni0yNTYsMjU2ICBjLTU5LjY4LDAtMTE0LjQ0OC0yMC41NzYtMTU3Ljk1Mi01NC44MTZjNDYuODQ4LDU5LjQ3MiwxMTkuMzQ0LDk3Ljc5MiwyMDAuOTI4LDk3Ljc5MmMxNDEuMzkyLDAsMjU2LTExNC42MDgsMjU2LTI1NiAgQzQ5OS43MTIsMTYyLjEyLDQ2MS4zOTIsODkuNjQsNDAxLjkyLDQyLjc3NnoiLz4KPGc+Cgk8cG9seWdvbiBzdHlsZT0iZmlsbDojRkZEODNCOyIgcG9pbnRzPSIxMjguMTI4LDk5Ljk0NCAxNTQuNDk2LDE1My40IDIxMy40NzIsMTYxLjk2IDE3MC44LDIwMy41NiAxODAuODY0LDI2Mi4yOTYgICAgMTI4LjEyOCwyMzQuNTY4IDc1LjM3NiwyNjIuMjk2IDg1LjQ0LDIwMy41NiA0Mi43NjgsMTYxLjk2IDEwMS43NDQsMTUzLjQgICIvPgoJPHBvbHlnb24gc3R5bGU9ImZpbGw6I0ZGRDgzQjsiIHBvaW50cz0iMjc2Ljg2NCw4Mi44NCAyOTAuNTI4LDExMC41NTIgMzIxLjEwNCwxMTQuOTg0IDI5OC45NzYsMTM2LjU1MiAzMDQuMjA4LDE2Ni45ODQgICAgMjc2Ljg2NCwxNTIuNjE2IDI0OS41MiwxNjYuOTg0IDI1NC43NTIsMTM2LjU1MiAyMzIuNjI0LDExNC45ODQgMjYzLjIsMTEwLjU1MiAgIi8+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPGc+CjwvZz4KPC9zdmc+Cg==" />
  </div>
    ';
}
//文章组件输出
function article_module_output($thi){
    $options = bsOptions::getInstance()::get_option( 'bearsimple' );
    $agree = $thi->hidden?array('agree' => 0, 'recording' => true):agreeNum($thi->cid);
    if($options['Share']||$options['RewardOpen']||$options['Like']){
    echo '
    <div style="text-align:center">
<div class="ui  buttons">
';if($options['Like'] == true){echo'
  <div class="ui button" tabindex="0" id="agree-btn" data-cid="'.$thi->cid.'">
    <i class="thumbs up red icon"></i>赞 (<b class="agreenum">'.$agree['agree'].'</b>)
  </div>
  ';}
  if($options['Share'] == true){echo'
  <div class="ui top left  dropdown button">
     <i class="share square orange icon"></i>分享
     <div class="menu">';
    if(!empty($options['Shares'][0]) && @in_array('qq',$options['Shares'])){echo'   
    <div class="item" id="qqshare"><i class="qq blue icon"></i>QQ</div>';
    }if(!empty($options['Shares'][0]) && @in_array('qzone',$options['Shares'])){echo'  
    <div class="item" id="qzoneshare"><i class="qq yellow icon"></i>QQ空间</div>';
    }if(!empty($options['Shares'][0]) && @in_array('wechat',$options['Shares'])){echo'
    <div class="item" id="wechatshare"><i class="wechat green icon"></i>微信</div>';
    }if(!empty($options['Shares'][0]) && @in_array('weibo',$options['Shares'])){echo'
    <div class="item" id="weiboshare"><i class="weibo red icon"></i>微博</div>';
    }if(!empty($options['Shares'][0]) && @in_array('facebook',$options['Shares'])){echo'
    <div class="item" id="facebookshare"><i class="facebook blue icon"></i>Facebook</div>';
     }if(!empty($options['Shares'][0]) && @in_array('twitter',$options['Shares'])){echo'
    <div class="item" id="twittershare"><i class="times purple icon"></i>Twitter</div>';
     }if(!empty($options['Shares'][0]) && @in_array('google',$options['Shares'])){echo'
    <div class="item" id="googleshare"><i class="google red icon"></i>Google</div>';
     }if(!empty($options['Shares'][0]) && @in_array('linkedin',$options['Shares'])){echo'
    <div class="item" id="linkedinshare"><i class="linkedin blue icon"></i>Linkedin</div>';
     }echo'
  </div>
  </div>
  ';}
  if($options['RewardOpen'] == true){

if($options['RewardOpen_tepass'] == true){
echo '<div class="ui top left dropdown button" onclick="isHidden(\'div_reward\')">
       <i class="gift violet icon"></i>打赏</div>';
}
else{
   $linkUrl = 'window.open("'.$options['RewardOpenPaypalText'].'","_blank")';
  echo'
  <div class="ui top left dropdown button">
       <i class="gift violet icon"></i>打赏
       <div class="menu">';
    if($options['RewardOpenPaypal'] ==true){echo"<div class='item' onclick='$linkUrl'><i class='paypal blue icon'></i>Paypal打赏</div>";}
    if($options['RewardOpenWechat'] == true){echo'<div class="item" id="bs-wechat"><i class="wechat green icon"></i>微信打赏</div>';}
    if($options['RewardOpenAlipay'] == true){echo'<div class="item" id="bs-alipay"><i class="reddit alien blue icon"></i>支付宝打赏</div>';}
    echo'
  </div>
</div>';   
}


}
echo'
</div>
</div>
';
}
}

function poster_inx($cid,$content,$excerpt,$type,$excerpt_length=240){
    $options = bsOptions::getInstance()::get_option( 'bearsimple' );
    $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
$is_iphone = (strpos($agent, 'iphone')) ? true : false;   
  $is_ipad = (strpos($agent, 'ipad')) ? true : false;   
  //判断苹果设备访问，经测试苹果设备在某些情况下可能无法下载海报
  if($is_iphone || $is_ipad){
      $download = '长按图片保存海报';
  }
  else{
      $download = '下载海报';
  }
  $post_excerpt = $excerpt;
  if($excerpt == ''){
      $post_content = $content;
      if (strpos($post_content, '[bspost') !== false) {
                    $post_content = preg_replace('/\[bspost (.*?)\]/sm', '', $post_content);
}
if (strpos($post_content, '[bshide') !== false) {
            $pattern = get_shortcode_regex(array('bshide'));
            $post_content = preg_replace("/$pattern/", '', $post_content);
        }
if (strpos($post_content, '[bslogin') !== false) {
            $pattern = get_shortcode_regex(array('bslogin'));
            $post_content = preg_replace("/$pattern/", '', $post_content);
        }
if (strpos($post_content, '[bsprog') !== false) {
            $pattern = get_shortcode_regex(array('bsprog'));
            $post_content = preg_replace("/$pattern/", '', $post_content);
        }
        if (strpos($post_content, '[bsgallery') !== false) {
            $pattern = get_shortcode_regex(array('bsgallery'));
            $post_content = preg_replace("/$pattern/", '', $post_content);
        }
                if (strpos($post_content, '[todo-t') !== false) {
            $pattern = get_shortcode_regex(array('todo-t'));
            $post_content = preg_replace("/$pattern/", '', $post_content);
        }
                if (strpos($post_content, '[todo-f') !== false) {
            $pattern = get_shortcode_regex(array('todo-f'));
            $post_content = preg_replace("/$pattern/", '', $post_content);
        }
          if (strpos($post_content, '[bsgit') !== false) {
            $pattern = get_shortcode_regex(array('bsgit'));
            $post_content = preg_replace("/$pattern/", '', $post_content);
        }
        if (strpos($post_content, '[bseva') !== false) {
            $pattern = get_shortcode_regex(array('bseva'));
            $post_content = preg_replace("/$pattern/", '', $post_content);
        }
        if (strpos($post_content, '[bsaudio') !== false) {
            $pattern = get_shortcode_regex(array('bsaudio'));
            $post_content = preg_replace("/$pattern/", '', $post_content);
        }
        if (strpos($post_content, '[bspost') !== false) {
            $pattern = get_shortcode_regex(array('bspost'));
            $post_content = preg_replace("/$pattern/", '', $post_content);
        }
        if (strpos($post_content, '[bsplayer') !== false) {
            $pattern = get_shortcode_regex(array('bsplayer'));
            $post_content = preg_replace("/$pattern/", '', $post_content);
        }
        if (strpos($post_content, '[bsmp3') !== false) {
            $pattern = get_shortcode_regex(array('bsplayer'));
            $post_content = preg_replace("/$pattern/", '', $post_content);
        }
        if (strpos($post_content, '[bsruby') !== false) {
            $pattern = get_shortcode_regex(array('bsruby'));
            $post_content = preg_replace("/$pattern/", '', $post_content);
        }
        if (strpos($post_content, '[bsmark') !== false) {
            $pattern = get_shortcode_regex(array('bsmark'));
            $post_content = preg_replace("/$pattern/", '', $post_content);
        }
        if (strpos($post_content, '[bsbtn') !== false) {
            $pattern = get_shortcode_regex(array('bsbtn'));
            $post_content = preg_replace("/$pattern/", '', $post_content);
        }
        if (strpos($post_content, '[bsmessage') !== false) {
            $pattern = get_shortcode_regex(array('bsmessage'));
            $post_content = preg_replace("/$pattern/", '', $post_content);
        }
        if (strpos($post_content, '{bs-todo') !== false) {
            $pattern = get_shortcode_regex2(array('bs-todo'));
            $post_content = preg_replace("/$pattern/", '', $post_content);
        }
        if (strpos($post_content, '{bs-accord') !== false) {
            $pattern = get_shortcode_regex2(array('bs-accord'));
            $post_content = preg_replace("/$pattern/", '', $post_content);
        }
        if (strpos($post_content, '{bs-font') !== false) {
            $pattern = get_shortcode_regex2(array('bs-font'));
            $post_content = preg_replace("/$pattern/", '', $post_content);
        }
        if (strpos($post_content, '{bs-iframe') !== false) {
            $pattern = get_shortcode_regex2(array('bs-iframe'));
            $post_content = preg_replace("/$pattern/", '', $post_content);
        }
        if (strpos($post_content, '{bs-card') !== false) {
            $pattern = get_shortcode_regex2(array('bs-card'));
            $post_content = preg_replace("/$pattern/", '', $post_content);
        }
        if (strpos($post_content, '{bs-audio') !== false) {
            $pattern = get_shortcode_regex2(array('bs-audio'));
            $post_content = preg_replace("/$pattern/", '', $post_content);
        }
        if (strpos($post_content, '[bspaper') !== false) {
            $pattern = get_shortcode_regex2(array('bspaper'));
            $post_content = preg_replace("/$pattern/", '', $post_content);
        }
        $post_content = strip_tags( $post_content );

        $post_excerpt = mb_strimwidth($post_content,0,$excerpt_length,'…','utf-8');
  }
  $post_excerpt = strip_tags( $post_excerpt );
    $post_excerpt = trim( preg_replace( "/[\n\r\t ]+/", ' ', $post_excerpt ), ' ' );
    switch($type){
    case '1':
    echo '<div id="post-poster" class="post-poster action action-poster">
			<div class="poster-qrcode" style="display:none;"></div>
			<div class="poster-popover-mask" data-event="poster-close"></div>
			<div class="poster-popover-box">
				<a class="poster-download btn btn-default" download="'.$cid.'.jpg">
					<span>'.$download.'</span>
				</a>
			</div>
		</div>';
	case '2':
		return $post_excerpt;
    }
}
//输出文章标题字数
function articletitlenum(){
    $options = bsOptions::getInstance()::get_option( 'bearsimple' );
    if(empty($options['articletitlenum'])){
        return '20';
    }
    else{
     return $options['articletitlenum'];
    }
    
}

//输出文章描述字数
function articledecnum(){
    $options = bsOptions::getInstance()::get_option( 'bearsimple' );
    if(empty($options['articleexcerptnum'])){
        return '40';
    }
    else{
     return $options['articleexcerptnum'];
    }
    
}

//输出标签云个数
function tagcloudnum(){
    $options = bsOptions::getInstance()::get_option( 'bearsimple' );
    if(empty($options['tagcloudnum'])){
        return '20';
    }
    else{
     return $options['tagcloudnum'];
    }
    
}

// 简洁图文获取图片
function thumb($obj) {
    //获取附件首张图片
	$attach = $obj->attachments(1)->attachment;
	//获取文章首张图片
	preg_match_all("/\<img.*?src\=\"(.*?)\"[^>]*>/i", $obj->content, $thumbUrl);
	$img_src = $thumbUrl[1][0];
	// 获取自定义随机图片
	$options = bsOptions::getInstance()::get_option( 'bearsimple' );
	$thumbs = explode("|",$options['Article_forma_pic']);
	// 获取文章封面
	$cover = $obj->fields->cover;
	//--------------->
	if($options['Article_forma_randapi'] == 1){
	        $rand = '?'.mt_rand(1,1000);
	    }
	if($options['Article_forma_randchoose'] == false || $options['Article_forma_randchoose'] == ''){
	if($cover){
	    $thumb = $cover;
	}elseif(isset($attach->isImage) && $attach->isImage == 1){
		$thumb = $attach->url;
	}else if($img_src){
		$thumb = $img_src;
	}else if(!empty($options['Article_forma_pic']) && count($thumbs)>0){
		$thumb = $thumbs[rand(0,count($thumbs)-1)].$rand;
	}
	else{
	    $thumb = '';
	}
	
	}
	else{
	    
	   if(!empty($options['Article_forma_pic']) && count($thumbs)>0){
		$thumb = $thumbs[rand(0,count($thumbs)-1)].$rand;
	}
	   elseif($cover){
	    $thumb = $cover;
	}elseif(isset($attach->isImage) && $attach->isImage == 1){
		$thumb = $attach->url;
	}else if($img_src){
		$thumb = $img_src;
	}
	else{
	    $thumb = '';
	}
	   
	    
	}
	
	return $thumb;
}

// 图底文字获取图片
function thumb2($obj,$type = 'default') {
    //获取附件首张图片
	$attach = $obj->attachments(1)->attachment;
	//获取文章首张图片
	preg_match_all("/\<img.*?src\=\"(.*?)\"[^>]*>/i", $obj->content, $thumbUrl);
	$img_src = $thumbUrl[1][0];
	// 获取自定义随机图片
	$options = bsOptions::getInstance()::get_option( 'bearsimple' );
	$thumbs = explode("|",$options['Article_forma_pic']);
	// 获取文章封面
	$cover = $obj->fields->cover;
	//--------------->
	if($options['Article_forma_randapi'] == 1){
	        $rand = '?'.mt_rand(1,1000);
	    }
	if($options['Article_forma_randchoose'] == false || $options['Article_forma_randchoose'] == ''){
	if($cover){
	    $thumb = $cover;
	}elseif(isset($attach->isImage) && $attach->isImage == 1){
		$thumb = $attach->url;
	}else if($img_src){
		$thumb = $img_src;
	}else if(!empty($options['Article_forma_pic']) && count($thumbs)>0){
		$thumb = $thumbs[rand(0,count($thumbs)-1)].$rand;
	}
	else if($type == 'album'){
	    $thumb = Helper::options()->themeUrl.'/assets/images/mountain.webp';
	}
	else{
	    $thumb = '';
	}
	
	}
	else{
	    
	   if(!empty($options['Article_forma_pic']) && count($thumbs)>0){
		$thumb = $thumbs[rand(0,count($thumbs)-1)].$rand;
	}
	   elseif($cover){
	    $thumb = $cover;
	}elseif(isset($attach->isImage) && $attach->isImage == 1){
		$thumb = $attach->url;
	}else if($img_src){
		$thumb = $img_src;
	}
	else{
	    $thumb = '';
	}
	   
	    
	}
	return $thumb;
}

function thumb3($obj) {
    //获取附件首张图片
	$attach = $obj->attachments(1)->attachment;
	//获取文章首张图片
	preg_match_all("/\<img.*?src\=\"(.*?)\"[^>]*>/i", $obj->content, $thumbUrl);
	$img_src = $thumbUrl[1][0];
	// 获取自定义随机图片
	$options = bsOptions::getInstance()::get_option( 'bearsimple' );
	$thumbs = explode("|",$options['Article_forma_pic']);
	// 获取文章封面
	$cover = $obj->fields->cover;
	//--------------->
	if($options['Article_forma_randapi'] == 1){
	        $rand = '?'.mt_rand(1,1000);
	    }
	if($options['Article_forma_randchoose'] == false || $options['Article_forma_randchoose'] == ''){
	if($cover){
	    $thumb = $cover;
	}elseif(isset($attach->isImage) && $attach->isImage == 1){
		$thumb = $attach->url;
	}else if($img_src){
		$thumb = $img_src;
	}else if(!empty($options['Article_forma_pic']) && count($thumbs)>0){
		$thumb = $thumbs[rand(0,count($thumbs)-1)].$rand;
	}
	else{
	    $thumb = '';
	}
	
	}
	else{
	    
	   if(!empty($options['Article_forma_pic']) && count($thumbs)>0){
		$thumb = $thumbs[rand(0,count($thumbs)-1)].$rand;
	}
	   elseif($cover){
	    $thumb = $cover;
	}elseif(isset($attach->isImage) && $attach->isImage == 1){
		$thumb = $attach->url;
	}else if($img_src){
		$thumb = $img_src;
	}
	else{
	    $thumb = '';
	}
	   
	    
	}
	return $thumb;
}


/**简单的标签转换**/
function BearSimpleChange($article){
    $article = str_replace('[bs-style=', '<div class="', $article);
    $article = str_replace('[/bs-style]', '</div>', $article);
    $article = str_replace(']', '">', $article);
    return $article;
}

function BearSimpleFriendLinkBr($friendlink){
    $friendlink = str_replace('<friendlink>', '<ul></ul>', $friendlink);
    $friendlink = str_replace(',', '<ul></ul>', $friendlink);
    return $friendlink;
}


/** 获取操作系统信息 */
function getOs($agent)
{
    $os = false;

    if (preg_match('/win/i', $agent)) {
        if (preg_match('/nt 6.0/i', $agent)) {
            $os = 'Windows Vista';
        } else if (preg_match('/nt 6.1/i', $agent)) {
            $os = 'Windows 7';
        } else if (preg_match('/nt 5.1/i', $agent)) {
            $os = 'Windows XP';
        } else if (preg_match('/nt 5/i', $agent)) {
            $os = 'Windows 2000';
        } else {
            $os = 'Windows';
        }
    } else if (preg_match('/android/i', $agent)) {
        $os = 'Android';
    } else if (preg_match('/ubuntu/i', $agent)) {
        $os = 'Ubuntu';
    } else if (preg_match('/linux/i', $agent)) {
        $os = 'Linux';
    } else if (preg_match('/mac/i', $agent)) {
        $os = 'Mac OS X';
    } else if (preg_match('/unix/i', $agent)) {
        $os = 'Unix';
    } else if (preg_match('/symbian/i', $agent)) {
        $os = 'Nokia SymbianOS';
    } else {
        $os = '其它操作系统';
    }

    echo $os;
}

//**字数统计**/
function art_count ($cid){ 
    $db=Typecho_Db::get (); $rs=$db->fetchRow ($db->select ('table.contents.text')->from ('table.contents')->where ('table.contents.cid=?',$cid)->order ('table.contents.cid',Typecho_Db::SORT_ASC)->limit (1)); $text = preg_replace("/[^\x{4e00}-\x{9fa5}]/u", "", $rs['text']); 
    
    echo mb_strlen($text,'UTF-8'); }

// 统计阅读数
function get_post_view($archive){
	$cid    = $archive->cid;
	$db     = Typecho_Db::get();
	$prefix = $db->getPrefix();
	if (!array_key_exists('views', $db->fetchRow($db->select()->from('table.contents')))) {
		$db->query('ALTER TABLE `' . $prefix . 'contents` ADD `views` INT(10) DEFAULT 0;');
		echo 0;
		return;
	}
	$row = $db->fetchRow($db->select('views')->from('table.contents')->where('cid = ?', $cid));
	if ($archive->is('single')) {
        $views = Typecho_Cookie::get('extend_contents_views');
		if(empty($views)){
			$views = array();
		}else{
			$views = explode(',', $views);
		}
        if(!in_array($cid,$views)){
	        $db->query($db->update('table.contents')->rows(array('views' => (int) $row['views'] + 1))->where('cid = ?', $cid));
            array_push($views, $cid);
			$views = implode(',', $views);
			Typecho_Cookie::set('extend_contents_views', $views); //记录查看cookie
		}
	}
	echo $row['views'];
}


// 留言加@
function getPermalinkFromCoid($coid) {
	$db = Typecho_Db::get();
	$row = $db->fetchRow($db->select('author')->from('table.comments')->where('coid = ? AND status = ?', $coid, 'approved'));
	if (empty($row)) return '';
	return '<a href="#comment-'.$coid.'">@'.$row['author'].'</a>';
}

//获取文章标题
function get_article_title($cid){
 $db = Typecho_Db::get();
	$row = $db->fetchRow($db->select('title')->from('table.contents')->where('cid = ?', $cid));
 return $row['title'];
}

//获取文章URL
function get_article_link($cid){    
    $db = Typecho_Db::get();

    $result = $db->fetchAll($db->select()->from('table.contents')
        ->where('status = ?','publish')
        ->where('type = ?', 'post')
        ->where('created <= unix_timestamp(now())', 'post')
        ->where('cid = ?', $cid));
    if($result){
        foreach($result as $val){
            $val = Typecho_Widget::widget('Widget_Abstract_Contents')->push($val);
            $post_title = htmlspecialchars($val['title']);
            $permalink = $val['permalink'];
            return $permalink;
        }
    }
}

//懒加载输出
function lazyload($haveClass = 0,$url = ''){
    $themeurl = Helper::options()->themeUrl;
    $loader_open = bsOptions::getInstance()::get_option('bearsimple')['Lazyload'];
    $loader = bsOptions::getInstance()::get_option('bearsimple')['Lazyload_style'];
    if($loader_open == 1){
         if($haveClass == 1){
        return ' src="data:image/svg+xml;base64,PCEtLUFyZ29uTG9hZGluZy0tPgo8c3ZnIHdpZHRoPSIxIiBoZWlnaHQ9IjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgc3Ryb2tlPSIjZmZmZmZmMDAiPjxnPjwvZz4KPC9zdmc+" data-';
    }
    elseif($haveClass == 'auto' && !empty($url)){
        return ' class="lazy"  data-';
    }
    elseif($haveClass == 'auto' && empty($url)){
        return ' class="lazy" data-';
    }
    elseif($haveClass == 'auto-other' && !empty($url)){
        return ' src="'.$url.'" data-';
    }
    else{
    return ' class="lazyload lazyload-style-'.$loader.'" src="data:image/svg+xml;base64,PCEtLUFyZ29uTG9hZGluZy0tPgo8c3ZnIHdpZHRoPSIxIiBoZWlnaHQ9IjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgc3Ryb2tlPSIjZmZmZmZmMDAiPjxnPjwvZz4KPC9zdmc+" data-';
    }
    }
}
//侧边栏最新回复
function lastComments(){
    $db = Typecho_Db::get();
    $options = Helper::options();
    $search_Crosspage = $db->fetchAll($db->select('cid')->from('table.contents')
        ->where('status = ?','publish')
        ->where('type = ?', 'page')
        ->where('template = ?','cross.php')
        );
        $ids = array_column($search_Crosspage, 'cid'); 
        if($search_Crosspage[0]['cid']){
            $result = $db->select()->from('table.comments');
    $result = $result->where('status = ?','approved')
        ->where('type = ?', 'comment');
        foreach ($ids as $k => $v) {
        $result = $result->where('cid != '.intval($ids[$k]));
        }
        $result = $db->fetchAll($result->order('created', Typecho_Db::SORT_DESC)
        ->limit(5));
        
        }
        else{
            $result = $db->fetchAll($db->select()->from('table.comments')
        ->where('status = ?','approved')
        ->where('type = ?', 'comment')
        ->order('created', Typecho_Db::SORT_DESC)
        ->limit(5)
        );
        }
      echo '
    <ul class="comment-ul">';
    foreach($result as $comment){


$post = $db->fetchAll($db->select()->from('table.contents')
            ->where('status = ?','publish')
            ->where('type = ?', 'post')
            ->where('cid  = ?',$comment['cid'])
            ->order('cid', Typecho_Db::SORT_DESC)        
        );
        if($post){
            $i=1;
            foreach($post as $val){                
                $val = Typecho_Widget::widget('Widget_Abstract_Contents')->push($val);
                $post_title = htmlspecialchars($val['title']);
                $permalink = $val['permalink'];
                $post_url = '<p class="comment-post">评论于：<a href="'.$permalink.'#comment-'.$comment['coid'].'" title="评论于：'.$post_title.'" target="_blank">'.$post_title.'</a></p>';
            }
        }
        
        if(strip_tags(excerpt_content(bearcutword(reEmo($comment['text'],'reply')))) == ''){
            $comment_text = '该内容无法显示';
        }
        else{
            $comment_text = strip_tags(excerpt_content(bearcutword(reEmo($comment['text'],'reply'))));
        }
        echo '<li><div class="comment-info"><a href="'.$comment['url'].'" target="_blank" rel=nofollow>';
        if(Bsoptions('avatar__choose') !== 'closeavatar'){
    echo '<img height="60" width="60" src="'.imgravatarq($comment['mail']).'" decoding="async">';
        }
        echo ' <span class="comment-author">'.$comment['author'].'</span>
                            </a>
                        </div> 
                      ';
      if(!Typecho_Widget::widget('Widget_User')->hasLogin()){
      if(Bsoptions('Comment_private') == true && strpos($comment['text'],'@私密@') !== false ){
      echo '<div class="comment-excerpt"><p>此评论为私密评论</p></div>';
      }
      else{
      echo '<div class="comment-excerpt">
                            <p>'.$comment_text.'</p>
                        </div>
                       ';    
      }
      }
      else{
         echo '<div class="comment-excerpt">
                            <p>'.$comment_text.'</p>
                        </div>
                        ';     
      }
     echo ''.$post_url.'
                    </li>';
    }
    echo '</ul>';
}

//获取动态数目
function crossnum(){
    $db = Typecho_Db::get();
    $crossnum = $db->fetchAll($db->select('commentsNum')->from('table.contents')
        ->where('status = ?','publish')
        ->where('type = ?', 'page')
        ->where('template = ?','cross.php')
        ->limit(1)
        );
       return $crossnum[0]['commentsNum'];
}

//版权声明
function copyright_cc($field){
    if($field == 'one'){
        $output = '<a href="http://creativecommons.org/licenses/by/4.0/">知识共享署名许可协议</a>';
    }
    else if($field == 'two'){
        $output = '<a href="http://creativecommons.org/licenses/by-nc/4.0/">知识署名-非商业性使用许可协议</a>';
    }
    else if($field == 'three'){
        $output = '<a href="http://creativecommons.org/licenses/by-nd/4.0/">知识共享署名-禁止演绎许可协议</a>';
    }
    else if($field == 'four'){
        $output = '<a href="http://creativecommons.org/licenses/by-nc-nd/4.0/">知识共享署名-非商业性使用-禁止演绎许可协议</a>';
    }
    else if($field == 'five'){
        $output = '<a href="http://creativecommons.org/licenses/by-sa/4.0/">知识共享署名-相同方式共享许可协议</a>';
    }
    else if($field == 'six'){
        $output = '<a href="http://creativecommons.org/licenses/by-nc-sa/4.0/">知识共享署名-非商业性使用-相同方式共享许可协议</a>';
    }
    return $output;
}

function msec_to_sec($timestamp,$type='msec'){
    if($type=='msec'){
        return sprintf('%.0f', $timestamp*1000);
    }else{
        return sprintf('%.0f', $timestamp/1000);
    }

}

function time_start() {
	global $timestart;
	$mtime     = explode( ' ', microtime() );
	$timestart = $mtime[1] + $mtime[0];
	return true;
}
time_start();
function loadtime( $display = 0, $precision = 3 ) {
	global $timestart, $timeend;
	$mtime     = explode( ' ', microtime() );
	$timeend   = $mtime[1] + $mtime[0];
	$timetotal = number_format( $timeend - $timestart, $precision );
	$r         = $timetotal < 1 ? $timetotal . " millisecond(s)" : $timetotal . " second(s)";
	if ( $display ) {
		echo $r;
	}
	return 'Processed in '.$r;
}


class Widget_Post_hot extends Widget_Abstract_Contents
{
    public function __construct($request, $response, $params = NULL)
    {
        parent::__construct($request, $response, $params);
        $this->parameter->setDefault(array('pageSize' => $this->options->commentsListSize, 'parentId' => 0, 'ignoreAuthor' => false));
}

    public function execute()
    {
        $ret = array();
        $options = bsOptions::getInstance()::get_option('bearsimple');
    $data = $options['Cate_Encrypt'];
    $arr = $data;
    $col = 'Cate_Encrypt_Id';
        foreach ($arr as $row)
        {
            if (isset($row[$col])) {
                $ret[] = $row[$col];
            }
        }
        $db = \Typecho\Db::get();
        $adapter = $db->getAdapterName();
        if ("Pdo_SQLite" === $adapter || "SQLite" === $adapter || "pgsql" === $adapter || "Pdo_Pgsql" === $adapter) {
            $db_query = 'left';
        }
        if ("Pdo_Mysql" === $adapter || "Mysql" === $adapter) {
            $db_query = 'right';
        }
        $mid = array_unique($ret);
        Typecho_Widget::widget('Widget_User')->to($user);
        if(empty($mid) || ($user->hasLogin())){
$select  = $this->select()->from('table.contents')
          ->where("table.contents.password IS NULL OR table.contents.password = ''")
          ->where('table.contents.status = ?','publish')
          ->where('table.contents.created <= ?', time())
          ->where('table.contents.type = ?', 'post')
          ->limit($this->parameter->pageSize)
          ->order('table.contents.created', Typecho_Db::SORT_DESC);
        }
        else{
$select  = $this->select()->from('table.contents')
->join('table.relationships','table.relationships.cid = table.contents.cid',''.$db_query.'')
->join('table.metas','table.relationships.mid = table.metas.mid',''.$db_query.'')
->where('table.metas.type=?','category')
          ->where("table.contents.password IS NULL OR table.contents.password = ''")
          ->where('table.contents.status = ?','publish')
          ->where('table.contents.created <= ?', time())
          ->where('table.contents.type = ?', 'post')
          ->limit($this->parameter->pageSize)
          ->order('table.contents.created', Typecho_Db::SORT_DESC)
          ->group('table.contents.cid');
         foreach ($mid as  $k=>$v) {
            $select->where('table.relationships.mid != '.intval($mid[$k]));//确保每个值都是数字
        }    
         
        }

     $this->db->fetchAll($select, array($this, 'push'));
    }
}