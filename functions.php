<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

/**防止你们看到报错.jpg**/
error_reporting(0);


/**解析表情**/
$emo = false;
function reEmo($comment){
    global $emo;
    if(!$emo){
        $emo = json_decode(file_get_contents(dirname(__FILE__).'/assets/owo/OwO.json'), true);
        
    }
    foreach ($emo as $v){
        if($v['type'] == 'image'){
            foreach ($v['container'] as $vv){
                $comment = str_replace($vv['data'], '<img width="50" height="50" src="' . $vv['icon'] . '"/>', $comment);
            }
        }
    }
    return $comment;
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


function themeConfig($form)
{
    $options = Helper::options();
    $_db = Typecho_Db::get();
    $_prefix = $_db->getPrefix();
    try {
        if (!array_key_exists('views', $_db->fetchRow($_db->select()->from('table.contents')->page(1, 1)))) {
            $_db->query('ALTER TABLE `' . $_prefix . 'contents` ADD `views` INT DEFAULT 0;');
        }
        if (!array_key_exists('agree', $_db->fetchRow($_db->select()->from('table.contents')->page(1, 1)))) {
            $_db->query('ALTER TABLE `' . $_prefix . 'contents` ADD `agree` INT DEFAULT 0;');
        }
    } catch (Exception $e) {
    }
?>
    <link rel="stylesheet" href="<?php Helper::options()->themeUrl('assets/manage/bearui.min.css') ?>">
    <link href="https://cdn.bootcdn.net/ajax/libs/semantic-ui/2.4.1/semantic.min.css" rel="stylesheet">
    
    <script src="<?php Helper::options()->themeUrl('assets/manage/bearui.min.js') ?>"></script>
    
<link rel="stylesheet" type="text/css" href="/usr/themes/bearsimple/ui/layui/css/layui.css" />
	<script src="/usr/themes/bearsimple/ui/layui/layui.js"></script>
    <div class="bearui_config">
        <div>
            <div class="bearui_config__aside">
                <div class="logo">BearSimple V1.0</div>
                <ul class="tabs">
                    <li class="item" data-current="bearui_notice"><i class="assistive listening systems icon"></i> 使用说明</li>
                    <li class="item" data-current="bearui_global"><i class="american sign language interpreting icon"></i> 基础设置</li>
                    <li class="item" data-current="bearui_index"><i class="industry icon"></i> 首页设置</li>
<li class="item" data-current="bearui_header"><i class="heading icon"></i> 顶部设置</li>
                    <li class="item" data-current="bearui_footer"><i class="football ball icon"></i> 底部设置</li>
                    <li class="item" data-current="bearui_friend"><i class="superscript icon"></i> 友链设置</li>
                    <li class="item" data-current="bearui_diy"><i class="newspaper outline icon"></i> DIY设置[Beta]</li>
                    <li class="item" data-current="bearui_load"><i class="compress icon"></i> 加载设置</li>
                    <li class="item" data-current="bearui_sec"><i class="braille icon"></i> 行为验证</li>
                    <li class="item" data-current="bearui_reward"><i class="universal access icon"></i> 打赏设置</li>
                    <li class="item" data-current="bearui_comment"><i class="comments outline icon"></i> 评论设置</li>
                    <li class="item" data-current="bearui_article"><i class="glass martini icon"></i> 文章设置</li>
                    <li class="item" data-current="bearui_module"><i class="modx icon"></i> 区块设置</li>
                    <li class="item" data-current="bearui_author"><i class="autoprefixer icon"></i> 博主信息</li>
                    <li class="item" data-current="bearui_other"><i class="bluetooth b icon"></i> 其他设置</li>
                </ul>
                
                
            </div>
        </div>
        <div class="bearui_config__notice">
           
            <div class="ui blue message">
  <div class="header">
    欢迎使用BearSimple主题,以下是使用须知~
  </div>
  <ul class="list">
    <li>主题用户交流QQ群:561848356</li>
    <li>主题讨论微社区:<a href="https://support.qq.com/products/314782?">戳这里访问</a></li>
  </ul>
</div>
<div class="ui large message">
  本主题为简约式主题,适合喜欢简约类的博客站长使用<br>
  不懂的问题或本主题存在的问题可加群或在微社区中进行反馈<br>
  最后，祝您使用愉快:)
</div>
             <center>
   
<div class="ui labeled button" tabindex="0">
                     
  <div class="ui black button">
    <i class="github icon"></i> 当前版本/最新版本
  </div>
  <a class="ui basic black left pointing label" href="https://github.com/whitebearcode/typecho-bearsimple">
    V1.0/V<?php GetVersion();?> [Github]
        </a>
</div></center>
<?php $db = Typecho_Db::get();
$sjdq=$db->fetchRow($db->select()->from ('table.options')->where ('name = ?', 'theme:bearsimple'));
$ysj = $sjdq['value'];
if(isset($_POST['type']))
{ 
if($_POST["type"]=="备份模板数据"){
if($db->fetchRow($db->select()->from ('table.options')->where ('name = ?', 'theme:bearsimple'))){
$update = $db->update('table.options')->rows(array('value'=>$ysj))->where('name = ?', 'theme:bearsimple');
$updateRows= $db->query($update);
echo '<div class="ui floating message">备份已更新，请等待自动刷新！如果不自动跳转请点击';
?>    
<a href="<?php Helper::options()->adminUrl('options-theme.php'); ?>">这里</a></div>
<script language="JavaScript">window.setTimeout("location=\'<?php Helper::options()->adminUrl('options-theme.php'); ?>\'", 2500);</script>
<?php
}else{
if($ysj){
     $insert = $db->insert('table.options')
    ->rows(array('name' => 'theme:bearsimple','user' => '0','value' => $ysj));
     $insertId = $db->query($insert);
echo '<div class="ui floating message">备份完成，请等待自动刷新！如果不自动刷新请点击';
?>    
<a href="<?php Helper::options()->adminUrl('options-theme.php'); ?>">这里</a></div>
<script language="JavaScript">window.setTimeout("location=\'<?php Helper::options()->adminUrl('options-theme.php'); ?>\'", 2500);</script>
<?php
}
}
        }
if($_POST["type"]=="还原模板数据"){
if($db->fetchRow($db->select()->from ('table.options')->where ('name = ?', 'theme:bearsimple'))){
$sjdub=$db->fetchRow($db->select()->from ('table.options')->where ('name = ?', 'theme:bearsimple'));
$bsj = $sjdub['value'];
$update = $db->update('table.options')->rows(array('value'=>$bsj))->where('name = ?', 'theme:bearsimple');
$updateRows= $db->query($update);
echo '<div class="ui floating message">检测到模板备份数据，恢复完成，请等待自动刷新！如果不自动刷新请点击';
?>    
<a href="<?php Helper::options()->adminUrl('options-theme.php'); ?>">这里</a></div>
<script language="JavaScript">window.setTimeout("location=\'<?php Helper::options()->adminUrl('options-theme.php'); ?>\'", 2000);</script>
<?php
}else{
echo '<div class="ui floating message">没有模板备份数据，恢复不了哦！</div>';
}
}
if($_POST["type"]=="删除备份数据"){
if($db->fetchRow($db->select()->from ('table.options')->where ('name = ?', 'theme:bearsimple'))){
$delete = $db->delete('table.options')->where ('name = ?', 'theme:bearsimple');
$deletedRows = $db->query($delete);
echo '<div class="ui floating message">删除成功，请等待自动刷新，如果等不到请点击';
?>    
<a href="<?php Helper::options()->adminUrl('options-theme.php'); ?>">这里</a></div>
<script language="JavaScript">window.setTimeout("location=\'<?php Helper::options()->adminUrl('options-theme.php'); ?>\'", 2500);</script>
<?php
}else{
echo '<div class="ui floating message">抱歉,备份不存在~</div>';
}
}
    }
echo '<br><center><form class="protected" action="?bearsimple" method="post">
<input type="submit" name="type" class="ui button" value="备份模板数据" />&nbsp;&nbsp; <input type="submit" name="type" class="ui button" value="还原模板数据" />&nbsp;&nbsp;<input type="submit" name="type" class="ui button" value="删除备份数据" /></form></center>

        </div>';?>
     
       

    <?php
    //基础设置
    $title = new Typecho_Widget_Helper_Form_Element_Text('title',null,$options->title, '站点标题', '请填入站点标题,不要太长');
    $title->setAttribute('class', 'bearui_content bearui_global');
    $form->addInput($title);
    $keywords = new Typecho_Widget_Helper_Form_Element_Text('keywords',null,$options->keywords, '站点SEO关键词', '请填入站点SEO关键词,请以半角逗号 "," 分割多个关键字.');
    $keywords->setAttribute('class', 'bearui_content bearui_global');
    $form->addInput($keywords);
    $description = new Typecho_Widget_Helper_Form_Element_Text('description',null,$options->description, '站点SEO描述', '请填入站点SEO描述,不要太长.');
    $description->setAttribute('class', 'bearui_content bearui_global');
    $form->addInput($description);
    
    $Gravatar = new Typecho_Widget_Helper_Form_Element_Select('Gravatar', array('1' => 'Gravatar官方源',  '3' => 'V2EX*Gravatar镜像源','4' => 'LOLI.NET*Gravatar镜像源','5' => '极客族*Gravatar镜像源','6' => '七牛*Gravatar镜像源','7' => '自定义Gravatar镜像源'), '4', 'Gravatar源选择', '因Gravatar官方在中国大陆地区被Q，导致在中国大陆访问使用Gravatar的站点时头像不显示,这里支持您自主选择合适的源,若为自定义，举例:cdn.v2ex.com/gravatar/<br>本功能适配QQ,当填写的邮箱为QQ邮箱时则显示QQ头像');
    $Gravatar->setAttribute('class', 'bearui_content bearui_global');
    $form->addInput($Gravatar->multiMode());
    if($options->Gravatar == '7'){
        $GravatarUrl = new Typecho_Widget_Helper_Form_Element_Text('GravatarUrl',null,'', '自定义Gravatar镜像源地址', '请填入自定义Gravatar镜像源地址,格式:cdn.v2ex.com/gravatar/<br>Tips:当您所填写的自定义地址访问时能够显示图片时，像这样 <img width="50" height="50" src="/usr/themes/bearsimple/assets/image/gravatar.jpg"> 时则您所填写的地址是正常的');
    $GravatarUrl->setAttribute('class', 'bearui_content bearui_global');
    $form->addInput($GravatarUrl);
    }
     //友链设置
      $FriendLinkChoose = new Typecho_Widget_Helper_Form_Element_Select('FriendLinkChoose', array('1' => '开启右侧友情链接',  '2' => '关闭右侧友情链接'), '1', '<i class="linkify icon"></i>右侧友情链接栏是否开启', '若选择开启，则站点右侧增加友情链接栏');
    $FriendLinkChoose->setAttribute('class', 'bearui_content bearui_friend');
    $form->addInput($FriendLinkChoose->multiMode());
    if($options->FriendLinkChoose == '1'){
     $FriendLink = new Typecho_Widget_Helper_Form_Element_Textarea('FriendLink',null,'<a href="链接地址" title="友链名称" target="_blank">友链名称</a>', '<i class="linkify icon"></i>友链内容', '请填入友链内容,格式:&lt;a href="链接地址" title="友链名称" target="_blank">友链名称&lt;/a>,以&lt;friendlink>作为分行，一个友链一个分行。');
    $FriendLink->setAttribute('class', 'bearui_content bearui_friend');
    $form->addInput($FriendLink);
    }
    //首页设置
$Sticky = new Typecho_Widget_Helper_Form_Element_Select('Sticky', array('1' => '开启文章置顶',  '2' => '关闭文章置顶'), '2', '<i class="linkify icon"></i>是否开启文章置顶', '若选择开启，则可设置站点置顶文章');
    $Sticky->setAttribute('class', 'bearui_content bearui_index');
    $form->addInput($Sticky->multiMode());

 if($options->Sticky == '1'){
    $sticky_cids = new Typecho_Widget_Helper_Form_Element_Text(
          'sticky_cids', NULL, '',
          '置顶文章的 cid', '按照排序输入, 请以半角逗号或空格分隔 cid.');
$sticky_cids->setAttribute('class', 'bearui_content bearui_index');
        $form->addInput($sticky_cids);

        $sticky_html = new Typecho_Widget_Helper_Form_Element_Textarea(
          'sticky_html', NULL, "<span style='color:red'>[置顶] </span>",
          '置顶标题的文字[支持HTML]', '例子:&lt;span style="color:red">[置顶] &lt;/span>');
        $sticky_html->input->setAttribute('rows', '7')->setAttribute('cols', '80');
$sticky_html->setAttribute('class', 'bearui_content bearui_index');
        $form->addInput($sticky_html);
	}
	
	//打赏设置
	$RewardOpen = new Typecho_Widget_Helper_Form_Element_Select('RewardOpen', array('1' => '开启打赏功能',  '2' => '关闭打赏功能'), '2', '<i class="money bill alternate outline icon"></i> 是否开启打赏功能', '若选择开启，则文章底部都将出现打赏按钮');
    $RewardOpen->setAttribute('class', 'bearui_content bearui_reward');
    $form->addInput($RewardOpen->multiMode());
    if($options->RewardOpen == '1'){
        //Paypal
        	$RewardOpenPaypal = new Typecho_Widget_Helper_Form_Element_Select('RewardOpenPaypal', array('1' => '开启Paypal打赏',  '2' => '关闭Paypal打赏'), '2', '<i class="cc paypal icon"></i> 是否开启Paypal打赏功能', '若选择开启，则打赏按钮将增加Paypal');
    $RewardOpenPaypal->setAttribute('class', 'bearui_content bearui_reward');
    $form->addInput($RewardOpenPaypal->multiMode());
    
    if($options->RewardOpen == '1'&&$options->RewardOpenPaypal == '1'){
    $RewardOpenPaypalText = new Typecho_Widget_Helper_Form_Element_Text(
          'RewardOpenPaypalText', NULL, '',
          '您的Paypal打赏链接', '请输入您的Paypal打赏链接');
$RewardOpenPaypalText->setAttribute('class', 'bearui_content bearui_reward');
        $form->addInput($RewardOpenPaypalText);
    }

          //Alipay
        	$RewardOpenAlipay = new Typecho_Widget_Helper_Form_Element_Select('RewardOpenAlipay', array('1' => '开启支付宝打赏',  '2' => '关闭支付宝打赏'), '2', '<i class="reddit alien icon"></i> 是否开启支付宝打赏功能', '若选择开启，则打赏按钮将增加支付宝');
    $RewardOpenAlipay->setAttribute('class', 'bearui_content bearui_reward');
    $form->addInput($RewardOpenAlipay->multiMode());
    
    if($options->RewardOpen == '1'&&$options->RewardOpenAlipay == '1'){
    $RewardOpenAlipayText = new Typecho_Widget_Helper_Form_Element_Text(
          'RewardOpenAlipayText', NULL, '',
          '您的支付宝打赏图片链接', '请输入您的支付宝打赏图片链接,要求直链');
$RewardOpenAlipayText->setAttribute('class', 'bearui_content bearui_reward');
        $form->addInput($RewardOpenAlipayText);
    }
    //Wechat
        	$RewardOpenWechat = new Typecho_Widget_Helper_Form_Element_Select('RewardOpenWechat', array('1' => '开启微信打赏',  '2' => '关闭微信打赏'), '2', '<i class="wechat icon"></i> 是否开启微信打赏功能', '若选择开启，则打赏按钮将增加微信');
    $RewardOpenWechat->setAttribute('class', 'bearui_content bearui_reward');
    $form->addInput($RewardOpenWechat->multiMode());
    
    if($options->RewardOpen == '1'&&$options->RewardOpenWechat == '1'){
    $RewardOpenWechatText = new Typecho_Widget_Helper_Form_Element_Text(
          'RewardOpenWechatText', NULL, '',
          '您的微信打赏图片链接', '请输入您的微信打赏图片链接,要求直链');
$RewardOpenWechatText->setAttribute('class', 'bearui_content bearui_reward');
        $form->addInput($RewardOpenWechatText);
    }
    }  
    
    //行为验证设置
    
$VerifyChoose = new Typecho_Widget_Helper_Form_Element_Select('VerifyChoose', array('1' => '开启普通算数加法验证', '11' => '开启普通算数减法验证', '2' => '开启VAPTCHA 手势验证','3' => '关闭行为验证'), '1', '<i class="braille icon"></i> 选择行为验证方式', '若选择关闭,则评论等关键区域将不进行安全验证');
    $VerifyChoose->setAttribute('class', 'bearui_content bearui_sec');
    $form->addInput($VerifyChoose->multiMode());

 if($options->VerifyChoose == '2'){
     $vid = new Typecho_Widget_Helper_Form_Element_Text('vid', NULL, '****', _t('VID'), _t("验证单元vid"));
     $vid->setAttribute('class', 'bearui_content bearui_sec');
        $form->addInput($vid);
 }
 $CCFirewall = new Typecho_Widget_Helper_Form_Element_Select('CCFirewall', array('1' => '开启简易CC防护', '2' => '关闭简易CC防护'), '3', '<i class="braille icon"></i> 选择是否开启简易CC防护', '若选择开启,可能会存在误拦截!');
    $CCFirewall->setAttribute('class', 'bearui_content bearui_sec');
    $form->addInput($CCFirewall->multiMode());
 //特效设置
    $Pjax = new Typecho_Widget_Helper_Form_Element_Select('Pjax', array('1' => '开启Pjax加载',  '2' => '关闭Pjax加载'), '2', '<i class="compress icon"></i> 是否开启Pjax', '若选择开启,则将同步启用LazyLoad和NProgress效果');
    $Pjax->setAttribute('class', 'bearui_content bearui_load');
    $form->addInput($Pjax->multiMode());
    $Compress = new Typecho_Widget_Helper_Form_Element_Select('Compress', array('1' => '开启HTML压缩',  '2' => '关闭HTML压缩'), '2', '<i class="compress icon"></i> 是否开启HTML压缩', '开启后能够加快网站访问');
    $Compress->setAttribute('class', 'bearui_content bearui_load');
    $form->addInput($Compress->multiMode());
    $Lightbox = new Typecho_Widget_Helper_Form_Element_Select('Lightbox', array('1' => '开启Lightbox灯箱效果',  '2' => '关闭Lightbox灯箱效果'), '1', '<i class="compress icon"></i> 是否开启Lightbox灯箱效果', '使用Lightbox灯箱效果听说有BUFF加成~');
    $Lightbox->setAttribute('class', 'bearui_content bearui_load');
    $form->addInput($Lightbox->multiMode());
    
    $CommentTyping = new Typecho_Widget_Helper_Form_Element_Select('CommentTyping', array('1' => '开启打字效果',  '2' => '关闭打字效果'), '1', '<i class="compress icon"></i> 是否开启打字效果', '开启后在前台评论区打字就会出现小球浮现效果');
    $CommentTyping->setAttribute('class', 'bearui_content bearui_load');
    $form->addInput($CommentTyping->multiMode());
    
 //区块设置
    $Cate = new Typecho_Widget_Helper_Form_Element_Select('Cate', array('1' => '开启右侧分类区块',  '2' => '关闭右侧分类区块'), '1', '<i class="compress icon"></i> 是否开启右侧分类区块', '若选择开启,则网站右侧将出现分类区块,显示当前所有分类。');
    $Cate->setAttribute('class', 'bearui_content bearui_module');
    $form->addInput($Cate->multiMode());
    
    $LastArticle = new Typecho_Widget_Helper_Form_Element_Select('LastArticle', array('1' => '开启右侧最近文章区块',  '2' => '关闭右侧最近文章区块'), '1', '<i class="compress icon"></i> 是否开启右侧最近文章区块', '若选择开启,则网站右侧将出现最近文章区块,显示最近发布的文章,可控制显示的文章数目。');
    $LastArticle->setAttribute('class', 'bearui_content bearui_module');
    $form->addInput($LastArticle->multiMode());
    if($options->LastArticle == '1'){
        $LastArticleNumber = new Typecho_Widget_Helper_Form_Element_Text(
          'LastArticleNumber', NULL, '',
          '右侧最近文章显示数目', '请输入右侧最近文章显示数目,填数字即可');
$LastArticleNumber->setAttribute('class', 'bearui_content bearui_module');
        $form->addInput($LastArticleNumber);
    }
    
    $AdControl = new Typecho_Widget_Helper_Form_Element_Select('AdControl', array('1' => '开启广告区块',  '2' => '关闭广告区块'), '2', '<i class="compress icon"></i> 是否开启广告区块', '若选择开启,则网站将出现广告位置。');
    $AdControl->setAttribute('class', 'bearui_content bearui_module');
    $form->addInput($AdControl->multiMode());
    if($options->AdControl == '1'){
    $AdControl1 = new Typecho_Widget_Helper_Form_Element_Select('AdControl1', array('1' => '开启右侧广告1',  '2' => '关闭右侧广告1'), '2', '<i class="compress icon"></i> 是否开启右侧广告1', '若选择开启,则网站右侧顶部将出现广告位置。');
    $AdControl1->setAttribute('class', 'bearui_content bearui_module');
    $form->addInput($AdControl1->multiMode());
    if($options->AdControl1 == '1'){
        $AdControl1Src = new Typecho_Widget_Helper_Form_Element_Text(
          'AdControl1Src', NULL, '',
          '右侧广告1图片链接', '请输入右侧广告1图片链接');
$AdControl1Src->setAttribute('class', 'bearui_content bearui_module');
        $form->addInput($AdControl1Src);
        $AdControl1Url = new Typecho_Widget_Helper_Form_Element_Text(
          'AdControl1Url', NULL, '',
          '右侧广告1图片指向链接', '请输入右侧广告1图片指向链接');
$AdControl1Url->setAttribute('class', 'bearui_content bearui_module');
        $form->addInput($AdControl1Url);
    }
    $AdControl2 = new Typecho_Widget_Helper_Form_Element_Select('AdControl2', array('1' => '开启右侧广告2',  '2' => '关闭右侧广告2'), '2', '<i class="compress icon"></i> 是否开启右侧广告2', '若选择开启,则网站右侧底部将出现广告位置。');
    $AdControl2->setAttribute('class', 'bearui_content bearui_module');
    $form->addInput($AdControl2->multiMode());
    if($options->AdControl2== '1'){
        $AdControl2Src = new Typecho_Widget_Helper_Form_Element_Text(
          'AdControl2Src', NULL, '',
          '右侧广告1图片链接', '请输入右侧广告1图片链接');
$AdControl2Src->setAttribute('class', 'bearui_content bearui_module');
        $form->addInput($AdControl2Src);
        $AdControl2Url = new Typecho_Widget_Helper_Form_Element_Text(
          'AdControl2Url', NULL, '',
          '右侧广告2图片指向链接', '请输入右侧广告2图片指向链接');
$AdControl2Url->setAttribute('class', 'bearui_content bearui_module');
        $form->addInput($AdControl2Url);
    }

    }
    
    $Authorz = new Typecho_Widget_Helper_Form_Element_Select('Authorz', array('1' => '开启右侧博主相关区块',  '2' => '关闭右侧博主相关区块'), '2', '<i class="compress icon"></i> 是否开启右侧博主相关区块', '若选择开启,则网站右侧将出现博主一栏。');
    $Authorz->setAttribute('class', 'bearui_content bearui_module');
    $form->addInput($Authorz->multiMode());
    
    $Search = new Typecho_Widget_Helper_Form_Element_Select('Search', array('1' => '开启右侧搜索区块',  '2' => '关闭右侧搜索区块'), '1', '<i class="compress icon"></i> 是否开启右侧搜索区块', '若选择开启,则网站右侧将出现搜索区块，提供访客进行搜索。');
    $Search->setAttribute('class', 'bearui_content bearui_module');
    $form->addInput($Search->multiMode());
    
    //文章设置
   
    $Share = new Typecho_Widget_Helper_Form_Element_Select('Share', array('1' => '开启第三方分享',  '2' => '关闭第三方分享'), '2', ' <i class="compress icon"></i> 是否开启文章内第三方分享', '若选择开启,则文章页面都将显示第三方分享按钮，可自定义选择显示哪个。');
    $Share->setAttribute('class', 'bearui_content bearui_article');
    $form->addInput($Share->multiMode());
    if($options->Share == '1'){
         $Shares = new Typecho_Widget_Helper_Form_Element_Checkbox('Shares', array('qq' => '<i class="qq blue icon"></i>QQ',  'qzone' => '<i class="qq yellow icon"></i>QQ空间','weibo' => '<i class="weibo red icon"></i>微博','facebook' => '<i class="facebook blue icon"></i>Facebook','twitter' => '<i class="twitter purple icon"></i>Twitter','google' => '<i class="google plus g red icon"></i>Google','linkedin' => '<i class="linkedin blue icon"></i>Linkedin'), 'qq', '<i class="compress icon"></i> 选择要显示的图标', '若选择开启,则文章页面都将显示第三方分享按钮，可自定义选择显示哪个。');
          $Shares->setAttribute('class', 'bearui_content bearui_article');
    $form->addInput($Shares);
    }
    
    //顶部设置
    $DNSYJX = new Typecho_Widget_Helper_Form_Element_Select('DNSYJX', array('1' => '开启DNS预解析',  '2' => '禁用DNS预解析'), '2', '是否开启/禁用DNS预解析', '预置三个DNS预解析,对于某些情况而言开启能够提升访问速度,而禁用的话能节省每月100亿的DNS查询');
    $DNSYJX->setAttribute('class', 'bearui_content bearui_header');
    $form->addInput($DNSYJX->multiMode());
    if ($options->DNSYJX == '1'){
    $DNSADDRESS1 = new Typecho_Widget_Helper_Form_Element_Text('DNSADDRESS1', null, '', 'DNS预解析地址1', '请填入DNS预解析地址');
    $DNSADDRESS1->setAttribute('class', 'bearui_content bearui_header');
    $form->addInput($DNSADDRESS1);
    $DNSADDRESS2 = new Typecho_Widget_Helper_Form_Element_Text('DNSADDRESS2', null, '', 'DNS预解析地址2', '请填入DNS预解析地址');
    $DNSADDRESS2->setAttribute('class', 'bearui_content bearui_header');
    $form->addInput($DNSADDRESS2);
    $DNSADDRESS3 = new Typecho_Widget_Helper_Form_Element_Text('DNSADDRESS3', null, '', 'DNS预解析地址3', '请填入DNS预解析地址');
    $DNSADDRESS3->setAttribute('class', 'bearui_content bearui_header');
    $form->addInput($DNSADDRESS3);
    }
    #----------------------->
    $CustomizationCode = new Typecho_Widget_Helper_Form_Element_Textarea('CustomizationCode', null, '', '顶部自定义代码', '如百度Meta验证代码，均可以放在这里');
    $CustomizationCode->setAttribute('class', 'bearui_content bearui_header');
    $form->addInput($CustomizationCode);
    
    //底部设置
    $IcpBa = new Typecho_Widget_Helper_Form_Element_Text('IcpBa', null, '', 'ICP备案号', '请填写您网站的ICP备案号,若无ICP备案请为空');
    $IcpBa->setAttribute('class', 'bearui_content bearui_footer');
    $form->addInput($IcpBa);
    
    $PoliceBa = new Typecho_Widget_Helper_Form_Element_Text('PoliceBa', null, '', '公安备案号', '请填写您网站的公安备案号,若无公安备案请为空');
    $PoliceBa->setAttribute('class', 'bearui_content bearui_footer');
    $form->addInput($PoliceBa);
    
    $CustomizationFooterCode = new Typecho_Widget_Helper_Form_Element_Textarea('CustomizationFooterCode', null, '', '底部自定义代码', '可放置网站统计代码等，网站统计推荐使用<a href="https://analytics.bear-studio.net">BearAnalytics</a>,实时统计~');
    $CustomizationFooterCode->setAttribute('class', 'bearui_content bearui_footer');
    $form->addInput($CustomizationFooterCode);
    
    //博主信息设置
    $AuthorAvatar = new Typecho_Widget_Helper_Form_Element_Text('AuthorAvatar', null, '', '博主头像图片链接', '请填写博主头像图片链接,若为空则显示默认头像<br>预览:<img width="50px" height="50px" src=' .$options->AuthorAvatar.'>');
    $AuthorAvatar->setAttribute('class', 'bearui_content bearui_author');
    $form->addInput($AuthorAvatar);
    
    $AuthorName = new Typecho_Widget_Helper_Form_Element_Text('AuthorName', null, '', '博主昵称', '请填写博主昵称,若为空则不显示');
    $AuthorName->setAttribute('class', 'bearui_content bearui_author');
    $form->addInput($AuthorName);
    
    $AuthorQm = new Typecho_Widget_Helper_Form_Element_Text('AuthorQm', null, '', '博主个性简介', '请填写博主个性简介,若为空则不显示');
    $AuthorQm->setAttribute('class', 'bearui_content bearui_author');
    $form->addInput($AuthorQm);
    
    $QQ_QRCODE = new Typecho_Widget_Helper_Form_Element_Text('QQ_QRCODE', null, '', 'QQ二维码图片链接', '请填写QQ二维码图片链接，建议尺寸为300px×300px，若为空则不显示<br>预览:<img width="50px" height="50px" src=' .$options->QQ_QRCODE.'>');
    $QQ_QRCODE->setAttribute('class', 'bearui_content bearui_author');
    $form->addInput($QQ_QRCODE);
    
    $Wechat_QRCODE = new Typecho_Widget_Helper_Form_Element_Text('Wechat_QRCODE', null, '', '微信二维码图片链接', '请填写微信二维码图片链接，建议尺寸为300px×300px，若为空则不显示<br>预览:<img width="50px" height="50px" src=' .$options->Wechat_QRCODE.'>');
    $Wechat_QRCODE->setAttribute('class', 'bearui_content bearui_author');
    $form->addInput($Wechat_QRCODE);
    
    $Github_URL = new Typecho_Widget_Helper_Form_Element_Text('Github_URL', null, '', 'Github链接', '请填写Github链接,若为空则不显示');
    $Github_URL->setAttribute('class', 'bearui_content bearui_author');
    $form->addInput($Github_URL);
    
    $Facebook_URL = new Typecho_Widget_Helper_Form_Element_Text('Facebook_URL', null, '', 'Facebook链接', '请填写Facebook链接,若为空则不显示');
    $Facebook_URL->setAttribute('class', 'bearui_content bearui_author');
    $form->addInput($Facebook_URL);
    
    $Twitter_URL = new Typecho_Widget_Helper_Form_Element_Text('Twitter_URL', null, '', 'Twitter链接', '请填写Twitter链接,若为空则不显示');
    $Twitter_URL->setAttribute('class', 'bearui_content bearui_author');
    $form->addInput($Twitter_URL);
    
    //其他设置
    $CopyProtect = new Typecho_Widget_Helper_Form_Element_Select('CopyProtect', array('1' => '是',  '2' => '否'), '2', '是否开启防复制', '若开启防复制，则禁用右键、复制、拖动等');
    $CopyProtect->setAttribute('class', 'bearui_content bearui_other');
    $form->addInput($CopyProtect->multiMode());
    
    $F12Protect = new Typecho_Widget_Helper_Form_Element_Select('F12Protect', array('1' => '是',  '2' => '否'), '2', '是否开启防F12', '若开启防F12，则不允许访客打开调试模式');
    $F12Protect->setAttribute('class', 'bearui_content bearui_other');
    $form->addInput($F12Protect->multiMode());
    
    $Translate = new Typecho_Widget_Helper_Form_Element_Select('Translate', array('1' => '是',  '2' => '否'), '2', '是否开启简繁体切换', '若开启,则前台顶部LOGO位置自动增加简繁体切换按钮');
    $Translate->setAttribute('class', 'bearui_content bearui_other');
    $form->addInput($Translate->multiMode());
    if ($options->Translate == '1'){
      $TranslateLanguage = new Typecho_Widget_Helper_Form_Element_Select('TranslateLanguage', array('1' => '简体中文',  '2' => '繁体中文'), '1', '选择优先显示语言', '访客访问时优先使用的语言');
    $TranslateLanguage->setAttribute('class', 'bearui_content bearui_other');
    $form->addInput($TranslateLanguage->multiMode());  
    }
    $Top = new Typecho_Widget_Helper_Form_Element_Select('Top', array('1' => '是',  '2' => '否'), '1', '是否开启返回顶部小火箭', '若开启，则右侧下方将增加一个返回顶部小火箭');
    $Top->setAttribute('class', 'bearui_content bearui_other');
    $form->addInput($Top->multiMode());
    
    $Mournmode = new Typecho_Widget_Helper_Form_Element_Select('Mournmode', array('1' => '是',  '2' => '否'), '2', '是否开启哀悼模式', '若开启哀悼模式，则网站全部显示灰色。');
    $Mournmode->setAttribute('class', 'bearui_content bearui_other');
    $form->addInput($Mournmode->multiMode());
    
    //评论设置
    $Entermaxlength = new Typecho_Widget_Helper_Form_Element_Select('Entermaxlength', array('1' => '是',  '2' => '否'), '2', '是否开启评论字数限制', '若开启评论字数限制，则访客在评论时到达所限定字数即无法再输入');
    $Entermaxlength->setAttribute('class', 'bearui_content bearui_comment');
    $form->addInput($Entermaxlength->multiMode());
    if ($options->Entermaxlength == '1'){
        $Entermaxlengths = new Typecho_Widget_Helper_Form_Element_Text('Entermaxlengths', null, '', '评论字数限制', '请填写评论字数限制,填写数字即可，如100');
    $Entermaxlengths->setAttribute('class', 'bearui_content bearui_comment');
    $form->addInput($Entermaxlengths);
    }
       // DIY模式 -->
    $Diy = new Typecho_Widget_Helper_Form_Element_Select('Diy', array('1' => '开启DIY模式',  '2' => '关闭DIY模式'), '2', '是否开启DIY模式', '开启后将显示DIY模式面板,以下上传密钥也必须填写,否则不显示DIY面板');
    $Diy->setAttribute('class', 'bearui_content bearui_diy');
    $form->addInput($Diy->multiMode());
    $UploadPassword= new Typecho_Widget_Helper_Form_Element_Text('UploadPassword', null, '', '上传密钥', '请填入上传密钥,建议复杂点,在DIY面板在线上传时为保证安全，需要该密钥进行验证。');
    $UploadPassword->setAttribute('class', 'bearui_content bearui_diy');
    $form->addInput($UploadPassword);
    $base64encrypt = base64_encode($options->UploadPassword);
    if ($options->Diy == '1'&& !empty($options->UploadPassword)){
        $file = dirname(__FILE__).'/upload/Upload.Key';
        if(false!==fopen($file,'w+')){
            file_put_contents($file,$base64encrypt);
        }
        	
	Typecho_Widget::widget('Widget_Themes_Files')->to($files);
   $Html = <<<HTML

	<fieldset class="layui-elem-field">
		<legend>DIY模式面板</legend>
		<div class="layui-field-box">
				<div class="layui-input-inline">
					<input type="hidden" id='token' name="token" value="{$base64encrypt}" placeholder="Key" autocomplete="off" class="layui-input" disabled>
				
				</div>
				<br><br>
			<div class="layui-form-item">

		<label class="layui-form-label">图片<br>上传</label>
<div class="layui-upload">
  <button type="button" class="layui-btn layui-btn-normal" id="uploadimages">选择多张图片</button> 
  <div class="layui-upload-list">
    <table class="layui-table">
      <thead>
        <tr><th>文件名</th>
        <th>大小</th>
        <th>状态</th>
        <th>操作</th>
      </tr></thead>
      <tbody id="UploadImg"></tbody>
    </table>
  </div>
  <button type="button" class="layui-btn" id="uploadimagesAction">开始上传</button>
</div> 
	<blockquote class="layui-elem-quote layui-quote-nm" style="margin-top: 10px;">
    预览图：
    <div class="layui-upload-list" id="uploadimagespreview"></div>
 </blockquote>

<br><i class="studiovinari icon"></i>Tips:上传的图片可以在/usr/themes/bearsimple/upload/images/中找到～


			</div>
			

		</div>
	</fieldset>

<script>
layui.use(['upload', 'element', 'layer'], function(){
  var value = document.getElementById("token").value;
  var $ = layui.jquery
  ,upload = layui.upload
  ,element = layui.element
  ,layer = layui.layer;

  var UploadListView = $('#UploadImg')

  ,uploadListIns = upload.render({
    elem: '#uploadimages'
    ,url: '/usr/themes/bearsimple/upload/upload_img.php' //改成您自己的上传接口
,before: function(obj){
      //预读本地文件示例，不支持ie8
      obj.preview(function(index, file, result){
        $('#uploadimagespreview').append('<img width="400px" height="67px" src="'+ result +'" alt="'+ file.name +'" class="layui-upload-img">')
      });
    }
    ,multiple: true
    ,auto: false
    ,data: {token: value}
    ,bindAction: '#uploadimagesAction'
    ,choose: function(obj){   
      var files = this.files = obj.pushFile(); //将每次选择的文件追加到文件队列
      //读取本地文件
      obj.preview(function(index, file, result){
        var tr = $(['<tr id="upload-'+ index +'">'
          ,'<td>'+ file.name +'</td>'
          ,'<td>'+ (file.size/1024).toFixed(1) +'kb</td>'
          ,'<td>等待上传</td>'
          ,'<td>'
            ,'<button class="layui-btn layui-btn-xs upload-reload layui-hide">重传</button>'
            ,'<button class="layui-btn layui-btn-xs layui-btn-danger upload-delete">删除</button>'
          ,'</td>'
        ,'</tr>'].join(''));
        
        //单个重传
        tr.find('.upload-reload').on('click', function(){
          obj.upload(index, file);
        });
        
        //删除
        tr.find('.upload-delete').on('click', function(){
          delete files[index]; //删除对应的文件
          tr.remove();
          uploadListIns.config.elem.next()[0].value = ''; //清空 input file 值，以免删除后出现同名文件不可选
        });
        
        UploadListView.append(tr);
      });
    }
    ,done: function(res, index, upload){
       layer.msg('上传成功',{icon: 1});
        var tr = UploadListView.find('tr#upload-'+ index)
        ,tds = tr.children();
        tds.eq(2).html('<span style="color: #5FB878;">上传成功</span>');
        tds.eq(3).html(''); //清空操作
        return delete this.files[index]; //删除文件队列已经上传成功的文件
      
      this.error(index, upload);
    }
    ,error: function(index, upload){
      var tr = UploadListView.find('tr#upload-'+ index)
      ,tds = tr.children();
      tds.eq(2).html('<span style="color: #FF5722;">上传失败</span>');
      tds.eq(3).find('.upload-reload').removeClass('layui-hide'); //显示重传
    }
  });
  
});
</script>
	<script>
		layui.use(["colorpicker","form","transfer"], function(){
			var $ = layui.$;
			var form = layui.form;
			var colorpicker = layui.colorpicker;
			var transfer = layui.transfer;

			colorpicker.render({
				elem: '#headerColor'
				,color: '{$options->headerColor}'
				,done: function(color){
					$('#headerColor-input').focus().val(color).blur();
				}
			});
			colorpicker.render({
				elem: '#headerTextColor'
				,color: '{$options->headerTextColor}'
				,done: function(color){
					$('#headerTextColor-input').focus().val(color).blur();
				}
			});
			colorpicker.render({
				elem: '#footerColor'
				,color: '{$options->footerColor}'
				,done: function(color){
					$('#footerColor-input').focus().val(color).blur();
				}
			});
			colorpicker.render({
				elem: '#footerTextColor'
				,color: '{$options->footerTextColor}'
				,done: function(color){
					$('#footerTextColor-input').focus().val(color).blur();
				}
			});
			colorpicker.render({
				elem: '#backgroundColor'
				,color: '{$options->backgroundColor}'
				,done: function(color){
					$('#backgroundColor-input').focus().val(color).blur();
				}
			});
//同步input值
			$('input').bind('input propertychange blur', function(){
				var name = $(this).attr("name").split('_')[1];
				$("input[name='"+name+"']").val($(this).val());
			});
			$('textarea').bind('input propertychange', function(){
				var name = $(this).attr("name").split('_')[1];
				$("input[name='"+name+"']").val($(this).val());
			});
			form.on('switch()', function(data){
				var that = data.elem;
				var name = $(that).attr("name").split('_')[1];
				var value = data.elem.checked?data.value:'';
				$("input[name='"+name+"']").val(value);
			}); 
			form.on('radio()', function(data){
				var that = data.elem;
				var name = $(that).attr("name").split('_')[1];
				$("input[name='"+name+"']").val(data.value);
			});
		});

	</script>

HTML;
	$layout = new Typecho_Widget_Helper_Layout();
	$layout->html(_t($Html));
	$layout->setAttribute('class', 'bearui_content bearui_diy');
	$form->addInput(new Typecho_Widget_Helper_Form_Element_Hidden('headerColor'));
	$form->addInput(new Typecho_Widget_Helper_Form_Element_Hidden('headerTextColor'));
	$form->addInput(new Typecho_Widget_Helper_Form_Element_Hidden('footerColor'));
	$form->addInput(new Typecho_Widget_Helper_Form_Element_Hidden('footerTextColor'));
	$form->addInput(new Typecho_Widget_Helper_Form_Element_Hidden('backgroundColor'));
	$form->addInput(new Typecho_Widget_Helper_Form_Element_Hidden('backgroundImg'));
	$form->addInput(new Typecho_Widget_Helper_Form_Element_Hidden('FooterbackgroundImg'));
	$form->addItem($layout);
}
}
?>

<?php
/**
 * 文章自定义字段
 */

function themeFields(Typecho_Widget_Helper_Layout $layout)
{
    $excerpt = new Typecho_Widget_Helper_Form_Element_Textarea('excerpt', null, null, '文章摘要', '输入自定义摘要。留空自动从文章截取。');
    $layout->addItem($excerpt);
    $articleplo = new Typecho_Widget_Helper_Form_Element_Select('articleplo', array('1' => '关闭文章提示',  '2' => '在顶部展现文章提示',  '3' => '在左上角展现文章提示',  '4' => '在右上角展现文章提示'), '1', '文章提示展现形式', '开启后阅读本篇文章时会在所选择的位置展现文章提示');
    $layout->addItem($articleplo->multiMode());
    $articleplonr = new Typecho_Widget_Helper_Form_Element_Textarea('articleplonr', null, null, '文章提示内容', '文章提示功能非关闭状态时本栏有效，输入文章提示内容。留空则不显示');
    $layout->addItem($articleplonr);
    
}
function imgravatarq($email)
{
    $options = Helper::options();
    
$b=str_replace('@qq.com','',$email);
    if(stristr($email,'@qq.com')&&is_numeric($b)&&strlen($b)<11&&strlen($b)>4){
        $nk = 'https://s.p.qq.com/pub/get_face?img_type=3&uin='.$b;
        $c = get_headers($nk, true);
        $d = $c['Location'];
        $q = json_encode($d);
        $k = explode("&k=",$q)[1];
        echo 'https://q.qlogo.cn/g?b=qq&k='.$k.'&s=100';
    }else{
            
                $mmail = $email.'@qq.com';
                $email = md5($mmail);
                if($options->Gravatar == '1'){
                echo "//cn.gravatar.com/gravatar/" . $email . "?";
            }
            else if($options->Gravatar == '3'){
                echo "//cdn.v2ex.com/gravatar/" . $email . "?";
            }
            else if($options->Gravatar == '4'){
                echo "//gravatar.loli.net/avatar/" . $email . "?";
            }
            else if($options->Gravatar == '5'){
                echo "//sdn.geekzu.org/avatar/" . $email . "?";
            }
            else if($options->Gravatar == '6'){
                echo "//dn-qiniu-avatar.qbox.me/avatar/" . $email . "?";
            }
            else if($options->Gravatar == '7'){
                echo "//$options->GravatarUrl" . $email . "?";
            }
            }
}



//主题开启后的设定
function themeInit($comment){
    $options = Helper::options();
    if ($options->VerifyChoose == '1'){
$comment = spam_protection_prejia($comment, $post, $result);
}
else if ($options->VerifyChoose == '11'){
$comment = spam_protection_prejian($comment, $post, $result);
}
else{
$comment = spam_protection_prejia($comment, $post, $result);
}
Helper::options()->commentsAntiSpam = false;

}

//回复可见处理
Typecho_Plugin::factory('Widget_Abstract_Contents')->excerptEx = array('BearToolOne','one');
Typecho_Plugin::factory('Widget_Abstract_Contents')->contentEx = array('BearToolOne','one');
class BearToolOne {
    public static function one($con,$obj,$text)
    {
      $text = empty($text)?$con:$text;
      if(!$obj->is('single')){
      $text = preg_replace("/\[bs-hide\](.*?)\[\/bs-hide\]/sm",'',$text);
      }
      
               return $text;
}
}


//加法
function spam_protection_mathjia(){
   
    $num1=rand(1,49);
    $num2=rand(1,49);

    echo "<br>\n";
    echo "<div class=\"ui  labeled input\"> <div class=\"ui label\">
    <code>$num1</code>+<code>$num2</code>=?
  </div><input type=\"text\" name=\"sum\" class=\"text\" value=\"\" size=\"10\" tabindex=\"4\" style=\"width:180px\" placeholder=\"计算结果：\">
</div>\n";
    echo "<input type=\"hidden\" name=\"num1\" value=\"$num1\">\n";
    echo "<input type=\"hidden\" name=\"num2\" value=\"$num2\">";
}

function spam_protection_prejia($comment, $post, $result){
    $sum=$_POST['sum'];

    switch($sum){
        case $_POST['num1'] + $_POST['num2']:
        break;
        case null:
        throw new Typecho_Widget_Exception(_t('
        对不起，请输入验证码。<a href="javascript:history.back(-1)">返回上一页</a>','评论失败'));
        break;
        default:
        throw new Typecho_Widget_Exception(_t('对不起，验证码错误，请<a href="javascript:history.back(-1)">返回</a>重试。','评论失败'));
    }
    return $comment;
}

//减法
function spam_protection_mathjian(){
   
    $num1=rand(1,49);
    $num2=rand(1,49);

    echo "<br>\n";
    echo "<div class=\"ui  labeled input\"> <div class=\"ui label\">
    <code>$num1</code>-<code>$num2</code>=?
  </div><input type=\"text\" name=\"sum\" class=\"text\" value=\"\" size=\"10\" tabindex=\"4\" style=\"width:180px\" placeholder=\"计算结果：\">
</div>\n";
    echo "<input type=\"hidden\" name=\"num1\" value=\"$num1\">\n";
    echo "<input type=\"hidden\" name=\"num2\" value=\"$num2\">";
}

function spam_protection_prejian($comment, $post, $result){
    $sum=$_POST['sum'];

    switch($sum){
        case $_POST['num1'] - $_POST['num2']:
        break;
        case null:
        throw new Typecho_Widget_Exception(_t('
        对不起，请输入验证码。<a href="javascript:history.back(-1)">返回上一页</a>','评论失败'));
        break;
        default:
        throw new Typecho_Widget_Exception(_t('对不起，验证码错误，请<a href="javascript:history.back(-1)">返回</a>重试。','评论失败'));
    }
    return $comment;
}





function compressHtml($html_source) {
    $chunks = preg_split('/(<!--<nocompress>-->.*?<!--<\/nocompress>-->|<nocompress>.*?<\/nocompress>|<pre.*?\/pre>|<textarea.*?\/textarea>|<script.*?\/script>)/msi', $html_source, -1, PREG_SPLIT_DELIM_CAPTURE);
    $compress = '';
    foreach ($chunks as $c) {
        if (strtolower(substr($c, 0, 19)) == '<!--<nocompress>-->') {
            $c = substr($c, 19, strlen($c) - 19 - 20);
            $compress .= $c;
            continue;
        } else if (strtolower(substr($c, 0, 12)) == '<nocompress>') {
            $c = substr($c, 12, strlen($c) - 12 - 13);
            $compress .= $c;
            continue;
        } else if (strtolower(substr($c, 0, 4)) == '<pre' || strtolower(substr($c, 0, 9)) == '<textarea') {
            $compress .= $c;
            continue;
        } else if (strtolower(substr($c, 0, 7)) == '<script' && strpos($c, '//') != false && (strpos($c, "\r") !== false || strpos($c, "\n") !== false)) {
            $tmps = preg_split('/(\r|\n)/ms', $c, -1, PREG_SPLIT_NO_EMPTY);
            $c = '';
            foreach ($tmps as $tmp) {
                if (strpos($tmp, '//') !== false) {
                    if (substr(trim($tmp), 0, 2) == '//') {
                        continue;
                    }
                    $chars = preg_split('//', $tmp, -1, PREG_SPLIT_NO_EMPTY);
                    $is_quot = $is_apos = false;
                    foreach ($chars as $key => $char) {
                        if ($char == '"' && $chars[$key - 1] != '\\' && !$is_apos) {
                            $is_quot = !$is_quot;
                        } else if ($char == '\'' && $chars[$key - 1] != '\\' && !$is_quot) {
                            $is_apos = !$is_apos;
                        } else if ($char == '/' && $chars[$key + 1] == '/' && !$is_quot && !$is_apos) {
                            $tmp = substr($tmp, 0, $key);
                            break;
                        }
                    }
                }
                $c .= $tmp;
            }
        }
        $c = preg_replace('/[\\n\\r\\t]+/', ' ', $c);
        $c = preg_replace('/\\s{2,}/', ' ', $c);
        $c = preg_replace('/>\\s</', '> <', $c);
        $c = preg_replace('/\\/\\*.*?\\*\\//i', '', $c);
        $c = preg_replace('/<!--[^!]*-->/', '', $c);
        $compress .= $c;
    }
    return $compress;
}


function GetVersion()
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'http://version.typecho.bearlab.in/version-bearsimple.php');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_TIMEOUT, 500);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    $data = curl_exec($curl);
    curl_close($curl);
    echo $data;
}

//行为验证处理->
$options = Helper::options();
if ($options->VerifyChoose == '2'){
// 添加VAPTCHA所需css
        Typecho_Plugin::factory('Widget_Archive')->header = array('VAPTCHA_BearSimple', 'header');
// 添加VAPTCHA所需js
        Typecho_Plugin::factory('Widget_Archive')->footer = array('VAPTCHA_BearSimple', 'footer');
class VAPTCHA_BearSimple
{
     /* 头部插入css */
    public static function header(){
        $VAPTCHA_style = "
            <style>
                .vaptcha-container {
                    width: 100%;
                    height: 36px;
                    line-height: 36px;
                    text-align: center;
                }
                .vaptcha-init-main {
                    display: table;
                    width: 100%;
                    height: 100%;
                    background-color: #EEEEEE;
                }
               .vaptcha-init-loading {
                    display: table-cell;
                    vertical-align: middle;
                    text-align: center
                }
               .vaptcha-init-loading>a {
                    display: inline-block;
                    width: 18px;
                    height: 18px;
                    border: none;
                }
               .vaptcha-init-loading>a img {
                    vertical-align: middle
                }
               .vaptcha-init-loading .vaptcha-text {
                    font-family: sans-serif;
                    font-size: 12px;
                    color: #CCCCCC;
                    vertical-align: middle
                }
            </style>
        ";
        echo $VAPTCHA_style;
    }

    /*  尾部加入js */
    public static function footer(){
        $options = Typecho_Widget::widget('Widget_Options');
      
        $vaptcha_js = "
            <script src=\"https://v.vaptcha.com/v3.js\"></script>
            <script>
                document.getElementById(\"bearsimple_verify\").setAttribute(\"disabled\", true);
                vaptcha({
                    vid: '".$options->vid."', // 验证单元id
                    type: 'click', // 显示类型 点击式
                    container: '.vaptcha-container' // 按钮容器，可为Element 或者 selector
                }).then(function (vaptchaObj) {
                    vaptchaObj.listen('pass', function() {
                        document.getElementById(\"bearsimple_verify\").removeAttribute(\"disabled\");
                    })
                    vaptchaObj.render()
                })
            </script>
        ";
     
        
        echo $vaptcha_js;
    } 
}



}