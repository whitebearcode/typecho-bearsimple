<?php
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
    $title = Helper::options()->title;
    $title = strFilter($title);
    return $title;
}

function readModeContent($th,$content){
 $author = $th->author->screenName;
$date = date("Y年 m月 d 日",$th->date->timeStamp);
$title = $th->title;
$avatar = imgravatarq($th->author->mail);
            return <<<EOF
<div id="read__mode" style="display:none;">
 <div class="ui grid">
                  <div class="sixteen wide column">
                  <div class="ui text container"  id="read__mode__close__hover">
<div id="read__mode__close">
    <button class="circular ui icon button" id="read__mode__close__btn">
 <i class="x link white icon"></i>
</button>
    </div>
<div id="read__mode__content">
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
  </div>
EOF;
}
function agreeNum($cid) {
    $db = Typecho_Db::get();
    $prefix = $db->getPrefix();
    if (!array_key_exists('agree', $db->fetchRow($db->select()->from('table.contents')))) {
        $db->query('ALTER TABLE `' . $prefix . 'contents` ADD `agree` INT(10) NOT NULL DEFAULT 0;');
    }
    $agree = $db->fetchRow($db->select('table.contents.agree')->from('table.contents')->where('cid = ?', $cid));
    $AgreeRecording = Typecho_Cookie::get('typechoAgreeRecording');
    if (empty($AgreeRecording)) {
        Typecho_Cookie::set('typechoAgreeRecording', json_encode(array(0)));
    }
    return array(
        'agree' => $agree['agree'],
        'recording' => in_array($cid, json_decode(Typecho_Cookie::get('typechoAgreeRecording')))?true:false
    );
}

function agree($cid) {
    $db = Typecho_Db::get();
    $agree = $db->fetchRow($db->select('table.contents.agree')->from('table.contents')->where('cid = ?', $cid));
    $agreeRecording = Typecho_Cookie::get('typechoAgreeRecording');
    if (empty($agreeRecording)) {
        Typecho_Cookie::set('typechoAgreeRecording', json_encode(array($cid)));
    }else {
        $agreeRecording = json_decode($agreeRecording);
        if (in_array($cid, $agreeRecording)) {
            return $agree['agree'];
        }
        array_push($agreeRecording, $cid);
        Typecho_Cookie::set('typechoAgreeRecording', json_encode($agreeRecording));
    }
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
    $AgreeRecording = Typecho_Cookie::get('typechoAgreeRecordingForComment'.$coid);
    if (empty($AgreeRecording)) {
        Typecho_Cookie::set('typechoAgreeRecordingForComment'.$coid, json_encode(array(0)));
    }
    return array(
        'agree' => $agree['agree'],
        'recording' => in_array($coid, json_decode(Typecho_Cookie::get('typechoAgreeRecordingForComment'.$coid)))?true:false
    );
}

function agreeforcomment($coid) {
    $db = Typecho_Db::get();
    $agree = $db->fetchRow($db->select('table.comments.agree')->from('table.comments')->where('coid = ?', $coid));
    $agreeRecording = Typecho_Cookie::get('typechoAgreeRecordingForComment'.$coid);
    if (empty($agreeRecording)) {
        Typecho_Cookie::set('typechoAgreeRecordingForComment'.$coid, json_encode(array($coid)));
    }else {
        $agreeRecording = json_decode($agreeRecording);
        if (in_array($coid, $agreeRecording)) {
            return $agree['agree'];
        }
        array_push($agreeRecording, $coid);
        Typecho_Cookie::set('typechoAgreeRecordingForComment'.$coid, json_encode($agreeRecording));
    }
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
    $options = Helper::options();
    echo '
        
    <style>
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
    if($options->global_transparent == '1'){
     echo 'opacity: .9;
     transition: opacity .5s;';   
    }
    if($options->global_shadow == '1'){
     echo 'box-shadow: 0 0 20px 6px rgba(0,0,0,.12),0 0 20px 6px rgba(0,0,0,.12)';   
    }
    echo '}';
    if ($options->Mournmode == "1"){
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
  if(!empty($options->picradius)){
      echo'
      img{
 border-radius:'.$options->picradius.'px;   
}
      ';
  }
  if($options->Slidersss == '1' && $options->SliderIndexs == '1' || $options->SliderOthers == '1'){
      echo'
      .splide{
      border-radius:10px;
    box-shadow: 0px 0px 20px rgba(0,0,0,0.2);
      }
      .splide__slide img {
  width: 100%;
  height: auto;
  border-radius:10px;
}
      ';
  }
    if($options->Top == '1'){
        echo'
        .goTop >img{
            width: 50px;
            height: 50px;
            cursor: pointer;
        }
        .goTop{
            position: fixed;
            right : 20px;
            bottom : 20px;
        }
        ';
    }
     if(!empty($options->BackGround)){
        echo'
        body{
            background-image: url('.$options->BackGround.')!important;
            background-position: center center;
            background-repeat: no-repeat;
            background-attachment:fixed;
            background-size:100% 100%;
            -webkit-background-size: cover;
            -o-background-size: cover;
        }
        ';
    }
    if(!empty($options->Diyfont)){
        echo'
@font-face {
          font-family: CustomFont;
          src: url('.$options->Diyfont.');
        }
        body ,p, a, h1, h2, h3, h4, h5, h6,textarea,div,span,input,.ui{
          font-family: CustomFont !important;
        }
        ';
    }
    if(!empty($options->Diyfontsize)){
        echo'
 body,.ui,div{
font-size:'.$options->Diyfontsize.'px !important;
}
        ';
    }
    echo '
    .widget{
      word-break:break-all;
  }
.break,.wrappers{
      word-break:break-all;
  }
  li{
	word-wrap: break-all;
  }
.post .post-content pre code{
padding: 0 3em;
overflow-x:auto;
width:100%
}
.post .post-content p{
word-break:break-all;
}
        pre{
            max-height: auto;
            padding: 0;
            margin: 0;
        }
        pre code {
            display:block;
            overflow-x:auto;
            position:relative;
            margin:0;
            padding-left:50px;
            
        }
        pre code {
            position:relative;
            display:block;
            overflow-x:auto;
            margin:4.4px 0.px .4px 1px;
            padding:0;
            max-height:500px;
            padding-left:3.5em
        }
        .line-numbers .line-numbers-rows {
            position: absolute;
            pointer-events: none;
            top: 0;
        }
        
        .post .post-content pre code {
            padding: 0 3em;
        }
        pre.line-numbers{
            padding-left: 0;
            padding-bottom: 0;
        }
        pre[class*="language-"]{
            padding: 0;
        }
        
        .qrcode{
          display: block;
      }
.ui.icon.input.phone{
    display: none;
  }
 .ui.large.icon.input.pc{
    display: inline;
  }
@media (max-width: 767px) {
  .ui.icon.input.phone{
    display: inline;
  }
 .ui.large.icon.input.pc{
    display: none;
  }
}
    ';
 if($options->hcsticky == "1"){
     echo '
     .sidebar {
    position: -webkit-sticky;
    position: sticky;
    top: 0;
}

.sticky:before,
.sticky:after {
    content: "";
    display: table;
}
     ';
 }
if($options->menu_style == "2"){
    echo'
   #header{
border: none;
}

.sm.sm-clean{
border-radius:5px;
background-color:#f1f1f1;
z-index:unset!important;
}
#bearsimple-images{
z-index: 587;
} 
    ';
}
echo '
    </style>';
}

//文章组件输出
function article_module_output($thi){
    $options = Helper::options();
    $agree = $thi->hidden?array('agree' => 0, 'recording' => true):agreeNum($thi->cid);
    if($options->Share||$options->RewardOpen||$options->Like){
    echo '
    <div style="text-align:center">
<div class="ui  buttons">
';if($options->Like == '1'){echo'
  <div class="ui button" tabindex="0" id="agree-btn" data-cid="'.$thi->cid.'">
    <i class="thumbs up red icon"></i>赞 (<b class="agreenum">'.$agree['agree'].'</b>)
  </div>
  ';}
  if($options->Share == '1'){echo'
  <div class="ui top left  dropdown button">
     <i class="share square orange icon"></i>分享
     <div class="menu">';
    if(!empty($options->Shares[0]) && @in_array('qq',$options->Shares)){echo'   
    <div class="item" id="qqshare"><i class="qq blue icon"></i>QQ</div>';
    }if(!empty($options->Shares[0]) && @in_array('qzone',$options->Shares)){echo'  
    <div class="item" id="qzoneshare"><i class="qq yellow icon"></i>QQ空间</div>';
    }if(!empty($options->Shares[0]) && @in_array('wechat',$options->Shares)){echo'
    <div class="item" id="wechatshare"><i class="wechat green icon"></i>微信</div>';
    }if(!empty($options->Shares[0]) && @in_array('weibo',$options->Shares)){echo'
    <div class="item" id="weiboshare"><i class="weibo red icon"></i>微博</div>';
    }if(!empty($options->Shares[0]) && @in_array('facebook',$options->Shares)){echo'
    <div class="item" id="facebookshare"><i class="facebook blue icon"></i>Facebook</div>';
     }if(!empty($options->Shares[0]) && @in_array('twitter',$options->Shares)){echo'
    <div class="item" id="twittershare"><i class="twitter purple icon"></i>Twitter</div>';
     }if(!empty($options->Shares[0]) && @in_array('google',$options->Shares)){echo'
    <div class="item" id="googleshare"><i class="google red icon"></i>Google</div>';
     }if(!empty($options->Shares[0]) && @in_array('linkedin',$options->Shares)){echo'
    <div class="item" id="linkedinshare"><i class="linkedin blue icon"></i>Linkedin</div>';
     }echo'
  </div>
  </div>
  ';}
  if($options->RewardOpen == '1'){
  $linkUrl = 'window.open("'.$options->RewardOpenPaypalText.'","_blank")';
  echo'
  <div class="ui top left dropdown button">
       <i class="gift violet icon"></i>打赏
       <div class="menu">';
    if($options->RewardOpenPaypal == '1'){echo"<div class='item' onclick='$linkUrl'><i class='paypal blue icon'></i>Paypal打赏</div>";}
    if($options->RewardOpenWechat == '1'){echo'<div class="item" id="bs-wechat"><i class="wechat green icon"></i>微信打赏</div>';}
    if($options->RewardOpenAlipay == '1'){echo'<div class="item" id="bs-alipay"><i class="reddit alien blue icon"></i>支付宝打赏</div>';}
    echo'
  </div>
</div>';}
echo'
</div>
</div>
';
}
}
//输出文章标题字数
function articletitlenum(){
    $options = Helper::options();
    if(empty($options->articletitlenum)){
        return '20';
    }
    else{
     return $options->articletitlenum;
    }
    
}

//输出文章描述字数
function articledecnum(){
    $options = Helper::options();
    if(empty($options->articleexcerptnum)){
        return '40';
    }
    else{
     return $options->articleexcerptnum;
    }
    
}

//输出标签云个数
function tagcloudnum(){
    $options = Helper::options();
    if(empty($options->tagcloudnum)){
        return '20';
    }
    else{
     return $options->tagcloudnum;
    }
    
}

// 简介图文获取图片
function thumb($obj) {
    //获取附件首张图片
	$attach = $obj->attachments(1)->attachment;
	//获取文章首张图片
	preg_match_all("/\<img.*?src\=\"(.*?)\"[^>]*>/i", $obj->content, $thumbUrl);
	$img_src = $thumbUrl[1][0];
	// 获取自定义随机图片
	$options = Typecho_Widget::widget('Widget_Options');
	$thumbs = explode("|",$options->Article_forma_pic);
	// 获取文章封面
	$cover = $obj->fields->cover;
	//--------------->
	if($cover){
	    $thumb = $cover;
	}elseif(isset($attach->isImage) && $attach->isImage == 1){
		$thumb = $attach->url;
	}else if($img_src){
		$thumb = $img_src;
	}else if(!empty($options->Article_forma_pic) && count($thumbs)>0){
		$thumb = $thumbs[rand(0,count($thumbs)-1)];
	}
	else{
	    $thumb = 'null';
	}
	return $thumb;
}

// 图底文字获取图片
function thumb2($obj) {
    //获取附件首张图片
	$attach = $obj->attachments(1)->attachment;
	//获取文章首张图片
	preg_match_all("/\<img.*?src\=\"(.*?)\"[^>]*>/i", $obj->content, $thumbUrl);
	$img_src = $thumbUrl[1][0];
	// 获取自定义随机图片
	$options = Typecho_Widget::widget('Widget_Options');
	$thumbs = explode("|",$options->Article_forma_pic2);
	// 获取文章封面
	$cover = $obj->fields->cover;
	//--------------->
	if($cover){
	    $thumb = $cover;
	}elseif(isset($attach->isImage) && $attach->isImage == 1){
		$thumb = $attach->url;
	}else if($img_src){
		$thumb = $img_src;
	}else if(!empty($options->Article_forma_pic2)&&count($thumbs)>0){
		$thumb = $thumbs[rand(0,count($thumbs)-1)];
	}
	else{
	    $thumb = 'null';
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
    $db=Typecho_Db::get (); $rs=$db->fetchRow ($db->select ('table.contents.text')->from ('table.contents')->where ('table.contents.cid=?',$cid)->order ('table.contents.cid',Typecho_Db::SORT_ASC)->limit (1)); $text = preg_replace("/[^\x{4e00}-\x{9fa5}]/u", "", $rs['text']); echo mb_strlen($text,'UTF-8'); }

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

//侧边栏最新回复
function lastComments(){
    $db = Typecho_Db::get();
    $search_Crosspage = $db->fetchAll($db->select('cid')->from('table.contents')
        ->where('status = ?','publish')
        ->where('type = ?', 'page')
        ->where('template = ?','cross.php')
        ->limit(1)
        );
    $result = $db->fetchAll($db->select('text','author','created','cid')->from('table.comments')
        ->where('status = ?','approved')
        ->where('type = ?', 'comment')
        ->where('cid != ?',$search_Crosspage[0]['cid'])
        ->order('created', Typecho_Db::SORT_DESC)
        ->limit(5)
        );
       return $result;
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