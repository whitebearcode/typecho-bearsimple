<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

error_reporting(0);
require_once('core/func.php');


function themeVersion()
        {
            return '1.6.2';
        }
        
function theAllViews()
        {
            $db = Typecho_Db::get();
            $prefix = $db->getPrefix();
            $row = $db->fetchAll('SELECT SUM(VIEWS) FROM `' . $prefix . 'contents`');
                echo number_format($row[0]['SUM(VIEWS)']);
        }

/**解析表情**/
$emo = false;
function reEmo($comment){
    global $emo;
    if(!$emo){
        $emo = json_decode(file_get_contents(dirname(__FILE__).'/assets/owo/OwO.json'), true);
        
    }
    $options = Helper::options();
    if($options->Assets == '1' || $options->Assets == null){
        $dir = $options->themeUrl.'/';
    }
    else if($options->Assets == '2'){
        $dir = 'https://cdn.jsdelivr.net/gh/whitebearcode/bearspace@latest/';
    }
    else{
        $dir = $options->Assets_Custom;
    }

    foreach ($emo as $v){
        if($v['type'] == 'image'){
            foreach ($v['container'] as $vv){
                $comment = str_replace($vv['data'], '<img width="50" height="50" src='.$dir.'/assets/owo/'.$vv['icon'] .''.'>', $comment);
            }
        }
    }
    return $comment;
}

function themeConfig($form)
{
    $options = Helper::options();
    $_db = Typecho_Db::get();
    $_prefix = $_db->getPrefix();

?>
    <link rel="stylesheet" href="<?php Helper::options()->themeUrl('assets/manage/bearui.min.css') ?>">
   
    <script src="https://cdn.bootcdn.net/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="<?php Helper::options()->themeUrl('assets/manage/bearui.min.js?t=1.2') ?>"></script>
    	 <script src="<?php Helper::options()->themeUrl('assets/manage/sca.js') ?>"></script>

	 <link href="https://cdn.bootcdn.net/ajax/libs/semantic-ui/2.4.1/semantic.min.css" rel="stylesheet">
	 <link href="https://cdn.bootcdn.net/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"><script src="https://cdn.bootcdn.net/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>


    <div class="bearui_config">
        <div>
            <div class="bearui_config__aside">
                <div class="logo"><div class="ui blue big label">BearSimple V<?php echo themeVersion(); ?></div></div>
                <ul class="tabs">
              
                    <li class="item" data-current="bearui_notice"><i class="assistive listening systems icon"></i> 使用说明</li>
                    <li class="item" data-current="bearui_global"><i class="american sign language interpreting icon"></i> 基础设置</li>
                    <li class="item" data-current="bearui_index"><i class="industry icon"></i> 首页及分类</li>
   
                    <li class="item" data-current="bearui_header"><i class="heading icon"></i> 顶部设置</li>
                    <li class="item" data-current="bearui_footer"><i class="football ball icon"></i> 底部设置</li>
                    <li class="item" data-current="bearui_sliderss"><i class="heading icon"></i> 幻灯片设置</li>
                    <li class="item" data-current="bearui_popup"><i class="location arrow icon"></i> 弹窗设置</li>
                    <li class="item" data-current="bearui_friend"><i class="superscript icon"></i> 友链设置</li>
                    <li class="item" data-current="bearui_diy"><i class="newspaper outline icon"></i> DIY设置</li>
                    <li class="item" data-current="bearui_load"><i class="compress icon"></i> 加载设置</li>
                    <li class="item" data-current="bearui_sec"><i class="braille icon"></i> 行为验证</li>
                    <li class="item" data-current="bearui_cache"><i class="redo alternate icon"></i> 缓存设置</li>
                    <li class="item" data-current="bearui_modules"><i class="arrows alternate
 icon"></i> 模块管理</li>
                    <li class="item" data-current="bearui_reward"><i class="universal access icon"></i> 打赏设置</li>
                    <li class="item" data-current="bearui_comment"><i class="comments outline icon"></i> 评论设置</li>
                    <li class="item" data-current="bearui_article"><i class="glass martini icon"></i> 文章设置</li>
                    <li class="item" data-current="bearui_images"><i class="image outline icon"></i> 图片设置</li>
                    <li class="item" data-current="bearui_poster"><i class="sticky note outline icon"></i> 海报设置</li>
                    <li class="item" data-current="bearui_module"><i class="modx icon"></i> 区块设置</li>
                    <li class="item" data-current="bearui_author"><i class="autoprefixer icon"></i> 博主信息</li>
                    <li class="item" data-current="bearui_other"><i class="bluetooth b icon"></i> 其他设置</li>
                     <li class="item" data-current="bearui_lab"><i class="terminal icon"></i> 实验室</li>
                     <li class="item" data-current="bearui_upgrade"><i class="cloud download icon"></i> 在线升级</li>
                </ul>
                
                
            </div>
        </div>
        <div class="bearui_config__notice">
           
            <div class="ui blue message">
  <div class="header">
    欢迎使用BearSimple主题,以下是使用须知~
  </div>
  <ul class="list">
    <li>本主题设置项请勿添加emoji表情，否则可能导致其他配置项被清空的情况。</li>
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
    V<?php echo themeVersion(); ?>/V<?php 
  
    $Version = file_get_contents('https://upgrade.bear-studio.net/Typecho/Bearsimple/version.php');
    $Versions = json_decode($Version,true);
   
        echo $Versions['version'];
   
    
    ?> 
        </a>
</div>
<?php
if ($Versions['version'] > themeVersion()){
        echo ' <div class="ui red message">
    本主题最新版本为V'.$Versions['version'].'，您的版本为V'.themeVersion().'，请及时完成更新!
 
  </div>';
    }
   
    ?>
  
</center>

     
<?php require_once('core/backup.php'); ?>
     
       </div>

    <?php
    //基础设置
    $title = new Typecho_Widget_Helper_Form_Element_Text('title',null,$options->title, '站点标题', '请填入站点标题,不要太长');
    $title->setAttribute('class', 'bearui_content bearui_global');
    $form->addInput($title);
    $keywords = new Typecho_Widget_Helper_Form_Element_Text('keywords',null,$options->keywords, '站点SEO关键词', '请填入站点SEO关键词,请以半角逗号 "," 分割多个关键字.');
        $keywords->setAttribute('hidden','hidden');
    $keywords->setAttribute('class', 'bearui_content bearui_global');
    $form->addInput($keywords);
    $description = new Typecho_Widget_Helper_Form_Element_Text('description',null,$options->description, '站点SEO描述', '请填入站点SEO描述,不要太长.');
    $description->setAttribute('class', 'bearui_content bearui_global');
    $form->addInput($description);
    $logo = new Typecho_Widget_Helper_Form_Element_Text('logo',null,'', '站点LOGO图片地址', '请填入站点LOGO图片地址，最佳尺寸为250X70，当该项为空时默认显示站点标题作为文字LOGO');
    $logo->setAttribute('class', 'bearui_content bearui_global');
    $form->addInput($logo);
    $favicon = new Typecho_Widget_Helper_Form_Element_Text('favicon',null,'', '站点Favicon', '请填入站点Favicon图标地址');
    $favicon->setAttribute('class', 'bearui_content bearui_global');
    $form->addInput($favicon);
    
    $Gravatar = new Typecho_Widget_Helper_Form_Element_Select('Gravatar', array('1' => 'Gravatar官方源','2' => 'LOLI.TOP*Gravatar镜像源', '3' => 'V2EX*Gravatar镜像源','4' => 'LOLI.NET*Gravatar镜像源','5' => '极客族*Gravatar镜像源','6' => '七牛*Gravatar镜像源','7' => '自定义Gravatar镜像源'), '4', 'Gravatar源选择', '因Gravatar官方在中国大陆地区被Q，导致在中国大陆访问使用Gravatar的站点时头像不显示,这里支持您自主选择合适的源,若为自定义，举例:cdn.v2ex.com/gravatar/<br>本功能适配QQ,当填写的邮箱为QQ邮箱时则显示QQ头像');
    $Gravatar->setAttribute('class', 'bearui_content bearui_global');
    $form->addInput($Gravatar->multiMode());
    //if($options->Gravatar == '7'){
        $GravatarUrl = new Typecho_Widget_Helper_Form_Element_Text('GravatarUrl',null,'', '自定义Gravatar镜像源地址', '请填入自定义Gravatar镜像源地址,格式:cdn.v2ex.com/gravatar/<br>Tips:当您所填写的自定义地址访问时能够显示图片时，像这样 <img width="50" height="50" src="/usr/themes/bearsimple/assets/image/gravatar.jpg"> 时则您所填写的地址是正常的');
    $GravatarUrl->setAttribute('class', 'bearui_content bearui_global');
    $form->addInput($GravatarUrl);
    //}
    
    $Assets = new Typecho_Widget_Helper_Form_Element_Select('Assets', array('1' => '本地储存','2' => '云端储存','3' => '自定义储存'), '1', '样式Assets储存选择', '本主题支持您选择合适的储存方式来储存js、css等文件进而达到网站加速的效果，云端存储由jsdelivr提供服务。');
    $Assets->setAttribute('class', 'bearui_content bearui_global');
    $form->addInput($Assets->multiMode());
    //if($options->Assets == '3'){
     $Assets_Custom = new Typecho_Widget_Helper_Form_Element_Text('Assets_Custom',null,'', '自定义储存源地址', '请填入风格文件储存源地址,例子:https://xxxx.com/，或者https://xxxx.com/xxx/，请务必将整个assets目录都放进去!!!当你填写的是https://xxxx.com/时，风格存储地址应该是https://xxxx.com/assets<br>检测结果:'.GetCheck().'');
    $Assets_Custom->setAttribute('class', 'bearui_content bearui_global');
    $form->addInput($Assets_Custom);   
    //}
    $Animate = new Typecho_Widget_Helper_Form_Element_Select(
        'Animate',
        array(
            'close' => '关闭',
            'bounce' => 'bounce',
            'flash' => 'flash',
            'pulse' => 'pulse',
            'rubberBand' => 'rubberBand',
            'headShake' => 'headShake',
            'swing' => 'swing',
            'tada' => 'tada',
            'wobble' => 'wobble',
            'jello' => 'jello',
            'heartBeat' => 'heartBeat',
            'bounceIn' => 'bounceIn',
            'bounceInDown' => 'bounceInDown',
            'bounceInLeft' => 'bounceInLeft',
            'bounceInRight' => 'bounceInRight',
            'bounceInUp' => 'bounceInUp',
            'bounceOut' => 'bounceOut',
            'bounceOutDown' => 'bounceOutDown',
            'bounceOutLeft' => 'bounceOutLeft',
            'bounceOutRight' => 'bounceOutRight',
            'bounceOutUp' => 'bounceOutUp',
            'fadeIn' => 'fadeIn',
            'fadeInDown' => 'fadeInDown',
            'fadeInDownBig' => 'fadeInDownBig',
            'fadeInLeft' => 'fadeInLeft',
            'fadeInLeftBig' => 'fadeInLeftBig',
            'fadeInRight' => 'fadeInRight',
            'fadeInRightBig' => 'fadeInRightBig',
            'fadeInUp' => 'fadeInUp',
            'fadeInUpBig' => 'fadeInUpBig',
            'fadeOut' => 'fadeOut',
            'fadeOutDown' => 'fadeOutDown',
            'fadeOutDownBig' => 'fadeOutDownBig',
            'fadeOutLeft' => 'fadeOutLeft',
            'fadeOutLeftBig' => 'fadeOutLeftBig',
            'fadeOutRight' => 'fadeOutRight',
            'fadeOutRightBig' => 'fadeOutRightBig',
            'fadeOutUp' => 'fadeOutUp',
            'fadeOutUpBig' => 'fadeOutUpBig',
            'flip' => 'flip',
            'flipInX' => 'flipInX',
            'flipInY' => 'flipInY',
            'flipOutX' => 'flipOutX',
            'flipOutY' => 'flipOutY',
            'rotateIn' => 'rotateIn',
            'rotateInDownLeft' => 'rotateInDownLeft',
            'rotateInDownRight' => 'rotateInDownRight',
            'rotateInUpLeft' => 'rotateInUpLeft',
            'rotateInUpRight' => 'rotateInUpRight',
            'rotateOut' => 'rotateOut',
            'rotateOutDownLeft' => 'rotateOutDownLeft',
            'rotateOutDownRight' => 'rotateOutDownRight',
            'rotateOutUpLeft' => 'rotateOutUpLeft',
            'rotateOutUpRight' => 'rotateOutUpRight',
            'hinge' => 'hinge',
            'jackInTheBox' => 'jackInTheBox',
            'rollIn' => 'rollIn',
            'rollOut' => 'rollOut',
            'zoomIn' => 'zoomIn',
            'zoomInDown' => 'zoomInDown',
            'zoomInLeft' => 'zoomInLeft',
            'zoomInRight' => 'zoomInRight',
            'zoomInUp' => 'zoomInUp',
            'zoomOut' => 'zoomOut',
            'zoomOutDown' => 'zoomOutDown',
            'zoomOutLeft' => 'zoomOutLeft',
            'zoomOutRight' => 'zoomOutRight',
            'zoomOutUp' => 'zoomOutUp',
            'slideInDown' => 'slideInDown',
            'slideInLeft' => 'slideInLeft',
            'slideInRight' => 'slideInRight',
            'slideInUp' => 'slideInUp',
            'slideOutDown' => 'slideOutDown',
            'slideOutLeft' => 'slideOutLeft',
            'slideOutRight' => 'slideOutRight',
            'slideOutUp' => 'slideOutUp',
        ),
        'off',
        '选择一款显示动画',
        '开启后，首页等位置都将显示此动画'
    );
    $Animate->setAttribute('class', 'bearui_content bearui_global');
    $form->addInput($Animate->multiMode());
     //友链设置
      $FriendLinkChoose = new Typecho_Widget_Helper_Form_Element_Select('FriendLinkChoose', array('1' => '开启右侧友情链接',  '2' => '关闭右侧友情链接'), '1', '右侧友情链接栏是否开启', '若选择开启，则站点右侧增加友情链接栏');
    $FriendLinkChoose->setAttribute('class', 'bearui_content bearui_friend');
    $form->addInput($FriendLinkChoose->multiMode());
    
     $FriendLink = new Typecho_Widget_Helper_Form_Element_Textarea('FriendLink',null,'<a href="链接地址" title="友链名称" target="_blank">友链名称</a>', '友链内容', '请填入友链内容,格式:&lt;a href="链接地址" title="友链名称" target="_blank">友链名称&lt;/a>,以&lt;friendlink>或者英文逗号作为分行，一个友链一个分行。');
    $FriendLink->setAttribute('class', 'bearui_content bearui_friend');
    $form->addInput($FriendLink);
  
    //幻灯片设置
    $Slidersss = new Typecho_Widget_Helper_Form_Element_Select('Slidersss', array('1' => '开启',  '2' => '关闭'), '2', '是否开启幻灯片功能', '开启幻灯片后前台将显示幻灯片展示');
    $Slidersss->setAttribute('class', 'bearui_content bearui_sliderss');
    $form->addInput($Slidersss->multiMode());
   
    $SliderIndexs = new Typecho_Widget_Helper_Form_Element_Select('SliderIndexs', array('1' => '开启',  '2' => '关闭'), '2', '首页开启幻灯片', '对象：首页');
    $SliderIndexs->setAttribute('class', 'bearui_content bearui_sliderss');
    $form->addInput($SliderIndexs->multiMode());
    
    $SliderOthers = new Typecho_Widget_Helper_Form_Element_Select('SliderOthers', array('1' => '开启',  '2' => '关闭'), '2', '其他位置开启幻灯片', '对象:分类、标签、搜索、作者文章');
    $SliderOthers->setAttribute('class', 'bearui_content bearui_sliderss');
    $form->addInput($SliderOthers->multiMode());

     $SliderPics = new Typecho_Widget_Helper_Form_Element_Textarea(
          'SliderPics', NULL, "",
          '幻灯片图片', '格式:https://xxx.com/xxx.jpg|https://xxx.com/xxx.jpg，使用|作为分隔');
        $SliderPics->input->setAttribute('rows', '7')->setAttribute('cols', '80');
$SliderPics->setAttribute('class', 'bearui_content bearui_sliderss');
        $form->addInput($SliderPics);   

    
    //首页设置
$Sticky = new Typecho_Widget_Helper_Form_Element_Select('Sticky', array('1' => '开启文章置顶',  '2' => '关闭文章置顶'), '2', '是否开启文章置顶', '目前暂时仅首页有效，若选择开启，则可设置站点置顶文章');
    $Sticky->setAttribute('class', 'bearui_content bearui_index');
    $form->addInput($Sticky->multiMode());


    $sticky_cids = new Typecho_Widget_Helper_Form_Element_Text(
          'sticky_cids', NULL, '',
          '首页置顶文章的 cid', '按照排序输入, 请以半角逗号或空格分隔 cid.');
          $sticky_cids->setAttribute('class', 'bearui_content bearui_index');
        $form->addInput($sticky_cids);
      
      
      
        $sticky_html = new Typecho_Widget_Helper_Form_Element_Textarea(
          'sticky_html', NULL, "<span style='color:red'>[置顶] </span>",
          '置顶标题的 html', '例子:&lt;span style="color:red">[置顶] &lt;/span>');
        $sticky_html->input->setAttribute('rows', '7')->setAttribute('cols', '80');
         $sticky_html->setAttribute('class', 'bearui_content bearui_index');
        $form->addInput($sticky_html);
	
$Article_forma = new Typecho_Widget_Helper_Form_Element_Select('Article_forma', array('1' => '简洁图文',  '2' => '纯文字','3' => '图底文字','4' => '纯文字2'), '2', '选择首页以及分类输出文章的展现样式', '若选择图文或图底文字，则当存在图片时展现图文样式，优先级：文章封面->附件首图->文章首图->自定义随机图片，无图片时不显示;');
    $Article_forma->setAttribute('class', 'bearui_content bearui_index');
    $form->addInput($Article_forma->multiMode());
    
   
        $Article_time3 = new Typecho_Widget_Helper_Form_Element_Select('Article_time3', array('1' => '显示',  '2' => '不显示'), '2', '是否显示文章发布时间', '若选择显示，则前台输出文章时显示文章发布时间');
    $Article_time3->setAttribute('class', 'bearui_content bearui_index');
    $form->addInput($Article_time3->multiMode());
   
    
      $Article_forma_pic = new Typecho_Widget_Helper_Form_Element_Textarea(
          'Article_forma_pic', NULL, "",
          '简洁图文使用-自定义随机图片', '自定义图片链接可固定一张，多张随机使用|分割<br>例如:https://www.xxx.com/xxx.png|https://www.xxx.com/xxxx.png');
        $Article_forma_pic->input->setAttribute('rows', '7')->setAttribute('cols', '80');
$Article_forma_pic->setAttribute('class', 'bearui_content bearui_index');
        $form->addInput($Article_forma_pic);   
        
    $Article_time = new Typecho_Widget_Helper_Form_Element_Select('Article_time', array('1' => '显示',  '2' => '不显示'), '2', '是否显示文章发布时间', '若选择显示，则前台输出文章时显示文章发布时间');
    $Article_time->setAttribute('class', 'bearui_content bearui_index');
    $form->addInput($Article_time->multiMode());
   
   
      $Article_forma_pic2 = new Typecho_Widget_Helper_Form_Element_Textarea(
          'Article_forma_pic2', NULL, "",
          '图底文字使用-自定义随机图片', '自定义图片链接可固定一张，多张随机使用|分割<br>例如:https://www.xxx.com/xxx.png|https://www.xxx.com/xxxx.png');
        $Article_forma_pic2->input->setAttribute('rows', '7')->setAttribute('cols', '80');
$Article_forma_pic2->setAttribute('class', 'bearui_content bearui_index');
        $form->addInput($Article_forma_pic2);  
        
    $Article_time2 = new Typecho_Widget_Helper_Form_Element_Select('Article_time2', array('1' => '显示',  '2' => '不显示'), '2', '是否显示文章发布时间', '若选择显示，则前台输出文章时显示文章发布时间');
    $Article_time2->setAttribute('class', 'bearui_content bearui_index');
    $form->addInput($Article_time2->multiMode());
        
  
	$articletitlenum = new Typecho_Widget_Helper_Form_Element_Text(
          'articletitlenum', NULL, '',
          '首页输出文章的标题字数', '填写数字即可');
$articletitlenum->setAttribute('class', 'bearui_content bearui_index');
        $form->addInput($articletitlenum);
        $articleexcerptnum = new Typecho_Widget_Helper_Form_Element_Text(
          'articleexcerptnum', NULL, '',
          '首页输出文章的摘要字数', '填写数字即可,该项仅应用于自动截取摘要,当文章内存在手动填写摘要时该项无效');
$articleexcerptnum->setAttribute('class', 'bearui_content bearui_index');
        $form->addInput($articleexcerptnum);
	//打赏设置
	$RewardOpen = new Typecho_Widget_Helper_Form_Element_Select('RewardOpen', array('1' => '开启打赏功能',  '2' => '关闭打赏功能'), '2', '是否开启打赏功能', '若选择开启，则文章底部都将出现打赏按钮');
    $RewardOpen->setAttribute('class', 'bearui_content bearui_reward');
    $form->addInput($RewardOpen->multiMode());
    //if($options->RewardOpen == '1'){
        //Paypal
        	$RewardOpenPaypal = new Typecho_Widget_Helper_Form_Element_Select('RewardOpenPaypal', array('1' => '开启Paypal打赏',  '2' => '关闭Paypal打赏'), '2', '是否开启Paypal打赏功能', '若选择开启，则打赏按钮将增加Paypal');
    $RewardOpenPaypal->setAttribute('class', 'bearui_content bearui_reward');
    $form->addInput($RewardOpenPaypal->multiMode());
    
    //if($options->RewardOpen == '1'&&$options->RewardOpenPaypal == '1'){
    $RewardOpenPaypalText = new Typecho_Widget_Helper_Form_Element_Text(
          'RewardOpenPaypalText', NULL, '',
          '您的Paypal打赏链接', '请输入您的Paypal打赏链接');
$RewardOpenPaypalText->setAttribute('class', 'bearui_content bearui_reward');
        $form->addInput($RewardOpenPaypalText);
   // }

          //Alipay
        	$RewardOpenAlipay = new Typecho_Widget_Helper_Form_Element_Select('RewardOpenAlipay', array('1' => '开启支付宝打赏',  '2' => '关闭支付宝打赏'), '2', '是否开启支付宝打赏功能', '若选择开启，则打赏按钮将增加支付宝');
    $RewardOpenAlipay->setAttribute('class', 'bearui_content bearui_reward');
    $form->addInput($RewardOpenAlipay->multiMode());
    
    //if($options->RewardOpen == '1'&&$options->RewardOpenAlipay == '1'){
    $RewardOpenAlipayText = new Typecho_Widget_Helper_Form_Element_Text(
          'RewardOpenAlipayText', NULL, '',
          '您的支付宝打赏图片链接', '请输入您的支付宝打赏图片链接,要求直链');
$RewardOpenAlipayText->setAttribute('class', 'bearui_content bearui_reward');
        $form->addInput($RewardOpenAlipayText);
    //}
    //Wechat
        	$RewardOpenWechat = new Typecho_Widget_Helper_Form_Element_Select('RewardOpenWechat', array('1' => '开启微信打赏',  '2' => '关闭微信打赏'), '2', '是否开启微信打赏功能', '若选择开启，则打赏按钮将增加微信');
    $RewardOpenWechat->setAttribute('class', 'bearui_content bearui_reward');
    $form->addInput($RewardOpenWechat->multiMode());
    
    //if($options->RewardOpen == '1'&&$options->RewardOpenWechat == '1'){
    $RewardOpenWechatText = new Typecho_Widget_Helper_Form_Element_Text(
          'RewardOpenWechatText', NULL, '',
          '您的微信打赏图片链接', '请输入您的微信打赏图片链接,要求直链');
$RewardOpenWechatText->setAttribute('class', 'bearui_content bearui_reward');
        $form->addInput($RewardOpenWechatText);
   // }
    //}  
    //幻灯设置
    $Slider = new Typecho_Widget_Helper_Form_Element_Select('Slider', array('1' => '是',  '2' => '否'), '2', '<i class="linkify icon"></i>是否开启幻灯', '目前暂时仅首页有效，若选择开启，则首页文章列表上面将显示幻灯效果');
    $Slider->setAttribute('class', 'bearui_content bearui_slider');
    $form->addInput($Slider->multiMode());
    //if($options->Slider == '1'){
        $Sliders = new Typecho_Widget_Helper_Form_Element_Textarea(
          'Sliders', NULL, '',
          '幻灯图片', '请输入您要显示的幻灯图片,格式：&lt;img class="swiper-img" src="a.jpg">,&lt;img class="swiper-img" src="b.jpg">，以英文逗号作为分隔');
$Sliders->setAttribute('class', 'bearui_content bearui_slider');
        $form->addInput($Sliders);
    //}
    //行为验证设置
    
$VerifyChoose = new Typecho_Widget_Helper_Form_Element_Select('VerifyChoose', array('1' => '开启普通算数加法验证', '11' => '开启普通算数减法验证', '2' => '开启VAPTCHA 手势验证', '22' => '开启拼图滑块验证','4' => '开启无感验证','3' => '关闭行为验证'), '1', '选择行为验证方式', '若选择关闭,则评论等关键区域将不进行安全验证');
    $VerifyChoose->setAttribute('class', 'bearui_content bearui_sec');
    $form->addInput($VerifyChoose->multiMode());
//22
    $Verify22_Buttontext = new Typecho_Widget_Helper_Form_Element_Text(
          'Verify22_Buttontext', NULL, '人机验证',
          '拼图滑块验证按钮文字', '请输入拼图滑块验证按钮文字，如人机验证');
          $Verify22_Buttontext->setAttribute('class', 'bearui_content bearui_sec');
        $form->addInput($Verify22_Buttontext);
    $Verify22_Paneltitle = new Typecho_Widget_Helper_Form_Element_Text(
          'Verify22_Paneltitle', NULL, '人机验证',
          '拼图滑块验证面板标题', '请输入拼图滑块验证面板标题，如人机验证');
     $Verify22_Paneltitle->setAttribute('class', 'bearui_content bearui_sec');
        $form->addInput($Verify22_Paneltitle);
    $Verify22_Paneldec = new Typecho_Widget_Helper_Form_Element_Text(
          'Verify22_Paneldec', NULL, '滑动滑块，使图片显示角度为正',
          '拼图滑块验证面板操作提示文字', '请输入拼图滑块验证面板操作提示文字，如滑动滑块，使图片显示角度为正');
     $Verify22_Paneldec->setAttribute('class', 'bearui_content bearui_sec');
        $form->addInput($Verify22_Paneldec);
    $Verify22_Panelclose = new Typecho_Widget_Helper_Form_Element_Text(
          'Verify22_Panelclose', NULL, '点我关闭',
          '拼图滑块关闭验证面板文字', '请输入拼图滑块关闭验证面板文字，如点我关闭');
     $Verify22_Panelclose->setAttribute('class', 'bearui_content bearui_sec');
        $form->addInput($Verify22_Panelclose);
     $Verify22_Panelsuccess = new Typecho_Widget_Helper_Form_Element_Text(
          'Verify22_Panelsuccess', NULL, '验证成功，{0}秒后自动关闭',
          '拼图滑块延迟关闭时间显示', '请输入拼图滑块验证成功后延迟关闭时间显示，{0}必须加，如验证成功，{0}秒后自动关闭');
     $Verify22_Panelsuccess->setAttribute('class', 'bearui_content bearui_sec');
        $form->addInput($Verify22_Panelsuccess);
    $Verify22_Panelerror = new Typecho_Widget_Helper_Form_Element_Text(
          'Verify22_Panelerror', NULL, '验证失败，请重试',
          '拼图滑块验证失败时显示', '请输入拼图滑块验证失败时显示，如验证失败，请重试');
     $Verify22_Panelerror->setAttribute('class', 'bearui_content bearui_sec');
        $form->addInput($Verify22_Panelerror);
    $Verify22_Panelimg = new Typecho_Widget_Helper_Form_Element_Textarea(
          'Verify22_Panelimg', NULL, '/usr/themes/bearsimple/assets/verify/BearCaptcha/Captcha/img/t1.png,/usr/themes/bearsimple/assets/verify/BearCaptcha/Captcha/img/t2.png,/usr/themes/bearsimple/assets/verify/BearCaptcha/Captcha/img/t3.png',
          '拼图滑块验证使用的图片', '请输入拼图滑块验证使用的图片直链,使用英文逗号分隔，如xxx.jpg,abc.png');
     $Verify22_Panelimg->setAttribute('class', 'bearui_content bearui_sec');
        $form->addInput($Verify22_Panelimg);
    $Verify22_Paneltime = new Typecho_Widget_Helper_Form_Element_Text(
          'Verify22_Paneltime', NULL, '2',
          '拼图滑块定时关闭时间(秒)', '请输入拼图滑块定时关闭时间，填写数字即可，单位是秒，如2');
     $Verify22_Paneltime->setAttribute('class', 'bearui_content bearui_sec');
        $form->addInput($Verify22_Paneltime);
    $Verify22_PanelslideDifference = new Typecho_Widget_Helper_Form_Element_Text(
          'Verify22_PanelslideDifference', NULL, '5',
          '拼图滑块滑动误差值', '该项若不清楚原理则勿修改,默认值:5');
     $Verify22_PanelslideDifference->setAttribute('class', 'bearui_content bearui_sec');
        $form->addInput($Verify22_PanelslideDifference);
    $Verify22_PaneldefaultDifference = new Typecho_Widget_Helper_Form_Element_Text(
          'Verify22_PaneldefaultDifference', NULL, '50',
          '拼图滑块默认图片角度最小差值', '该项若不清楚原理则勿修改,默认值:50');
     $Verify22_PaneldefaultDifference->setAttribute('class', 'bearui_content bearui_sec');
        $form->addInput($Verify22_PaneldefaultDifference);

 //2
     $vid = new Typecho_Widget_Helper_Form_Element_Text('vid', NULL, '****', _t('VID'), _t("验证单元vid"));
     $vid->setAttribute('class', 'bearui_content bearui_sec');
        $form->addInput($vid);
 
//4
 $protection_level = new Typecho_Widget_Helper_Form_Element_Radio(
            'protection_level',
            array(
                '1' => '轻微',
                '10' => '普通',
                '100' => '中等',
                '1000' => '特别',
            ),
            '1',
            _t('保护力度等级'),
            _t('等级越高，假想敌手所需运算量越多，但对普通用户也会造成影响，适当即可')
        );
        $delay_time = new Typecho_Widget_Helper_Form_Element_Text(
            'delay_time',
            null,
            '3',
            _t('访问页面到提交评论完成最少等待时间（单位为秒，不宜过大）'),
            _t('受限于资源加载情况多变，实现上仅延迟前端验证步骤')
        );
        $banned_action = new Typecho_Widget_Helper_Form_Element_Radio(
            'banned_action',
            array(
                '0' => '进入待审核',
                '1' => '进入垃圾箱',
                '2' => '禁止评论',
            ),
            '1',
            _t('验证失败的留言处理方式'),
            _t('选择验证失败的留言处理方式')
        );
        $spam_ip_action = new Typecho_Widget_Helper_Form_Element_Radio(
            'spam_ip_action',
            array(
                '0' => '进入待审核',
                '1' => '进入垃圾箱',
                '2' => '不处理',
            ),
            '0',
            _t('垃圾评论源 IP 再次评论'),
            _t('选择垃圾评论源 IP 再次评论的处置方式')
        );
        $banned_ip_list = new Typecho_Widget_Helper_Form_Element_Textarea(
            'banned_ip_list',
            NULL,
            '',
            _t('禁止评论 IP 黑名单（每行一个）')
        );
        $alert_message = new Typecho_Widget_Helper_Form_Element_Radio(
            'alert_message',
            array(
                '0' => '关闭',
                '1' => '开启',
            ),
            '0',
            _t('评论进入待审核状态时 alert 提醒读者'),
            _t('在本主题开启某些蜜汁功能情况下可开启本项')
        );
        $protection_level->setAttribute('class', 'bearui_content bearui_sec');
        $delay_time->setAttribute('class', 'bearui_content bearui_sec');
        $banned_action->setAttribute('class', 'bearui_content bearui_sec');
        $spam_ip_action->setAttribute('class', 'bearui_content bearui_sec');
        $banned_ip_list->setAttribute('class', 'bearui_content bearui_sec');
        $alert_message->setAttribute('class', 'bearui_content bearui_sec');
        $form->addInput($protection_level);
        $form->addInput($delay_time);
        $form->addInput($banned_action);
        $form->addInput($spam_ip_action);
        $form->addInput($banned_ip_list);
        $form->addInput($alert_message);

 $CCFirewall = new Typecho_Widget_Helper_Form_Element_Select('CCFirewall', array('1' => '开启简易CC防护', '2' => '关闭简易CC防护'), '3', '<i class="braille icon"></i> 选择是否开启简易CC防护', '若选择开启,可能会存在误拦截!');
    $CCFirewall->setAttribute('class', 'bearui_content bearui_sec');
    $form->addInput($CCFirewall->multiMode());
 //特效设置
    $Pjax = new Typecho_Widget_Helper_Form_Element_Select('Pjax', array('1' => '开启Pjax加载',  '2' => '关闭Pjax加载'), '2', '是否开启Pjax', '若选择开启,则将同步启用LazyLoad和NProgress效果');
    $Pjax->setAttribute('class', 'bearui_content bearui_load');
    $form->addInput($Pjax->multiMode());
    $Compress = new Typecho_Widget_Helper_Form_Element_Select('Compress', array('1' => '开启HTML压缩',  '2' => '关闭HTML压缩'), '2', '是否开启HTML压缩', '开启后同步开启最大限度的GZIP压缩，能够加快网站访问');
    $Compress->setAttribute('class', 'bearui_content bearui_load');
    $form->addInput($Compress->multiMode());
    $Lightbox = new Typecho_Widget_Helper_Form_Element_Select('Lightbox', array('1' => '开启图片灯箱效果',  '2' => '关闭图片灯箱效果'), '1', '是否开启图片灯箱效果', '使用图片灯箱效果听说有BUFF加成~');
    $Lightbox->setAttribute('class', 'bearui_content bearui_load');
    $form->addInput($Lightbox->multiMode());
    
    $CommentTyping = new Typecho_Widget_Helper_Form_Element_Select('CommentTyping', array('1' => '开启打字效果',  '2' => '关闭打字效果'), '1', '是否开启打字效果', '开启后在前台评论区打字就会出现小球浮现效果');
    $CommentTyping->setAttribute('class', 'bearui_content bearui_load');
    $form->addInput($CommentTyping->multiMode());
    
 //区块设置
    $Cate = new Typecho_Widget_Helper_Form_Element_Select('Cate', array('1' => '开启右侧分类区块',  '2' => '关闭右侧分类区块'), '1', '是否开启右侧分类区块', '若选择开启,则网站右侧将出现分类区块,显示当前所有分类。');
    $Cate->setAttribute('class', 'bearui_content bearui_module');
    $form->addInput($Cate->multiMode());
    
    $LastArticle = new Typecho_Widget_Helper_Form_Element_Select('LastArticle', array('1' => '开启右侧最近文章区块',  '2' => '关闭右侧最近文章区块'), '1', '是否开启右侧最近文章区块', '若选择开启,则网站右侧将出现最近文章区块,显示最近发布的文章,可控制显示的文章数目。');
    $LastArticle->setAttribute('class', 'bearui_content bearui_module');
    $form->addInput($LastArticle->multiMode());
    //if($options->LastArticle == '1'){
        $LastArticleNumber = new Typecho_Widget_Helper_Form_Element_Text(
          'LastArticleNumber', NULL, '5',
          '右侧最近文章显示数目', '请输入右侧最近文章显示数目,填数字即可');
$LastArticleNumber->setAttribute('class', 'bearui_content bearui_module');
        $form->addInput($LastArticleNumber);
    //}
    
    $AdControl = new Typecho_Widget_Helper_Form_Element_Select('AdControl', array('1' => '开启广告区块',  '2' => '关闭广告区块'), '2', '是否开启广告区块', '若选择开启,则网站将出现广告位置。');
    $AdControl->setAttribute('class', 'bearui_content bearui_module');
    $form->addInput($AdControl->multiMode());
    //if($options->AdControl == '1'){
    $AdControl1 = new Typecho_Widget_Helper_Form_Element_Select('AdControl1', array('1' => '开启右侧广告1',  '2' => '关闭右侧广告1'), '2', '是否开启右侧广告1', '若选择开启,则网站右侧顶部将出现广告位置。');
    $AdControl1->setAttribute('class', 'bearui_content bearui_module');
    $form->addInput($AdControl1->multiMode());
   // if($options->AdControl1 == '1'){
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
    //}
    $AdControl2 = new Typecho_Widget_Helper_Form_Element_Select('AdControl2', array('1' => '开启右侧广告2',  '2' => '关闭右侧广告2'), '2', '是否开启右侧广告2', '若选择开启,则网站右侧底部将出现广告位置。');
    $AdControl2->setAttribute('class', 'bearui_content bearui_module');
    $form->addInput($AdControl2->multiMode());
    //if($options->AdControl2== '1'){
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
   // }
 $AdControl3 = new Typecho_Widget_Helper_Form_Element_Select('AdControl3', array('1' => '开启首页文章顶部广告',  '2' => '关闭首页文章顶部广告'), '2', '是否开启首页文章顶部广告', '若选择开启,则网站首页文章顶部将出现广告位置。');
    $AdControl3->setAttribute('class', 'bearui_content bearui_module');
    $form->addInput($AdControl3->multiMode());
   // if($options->AdControl3 == '1'){
        $AdControl3Src = new Typecho_Widget_Helper_Form_Element_Text(
          'AdControl3Src', NULL, '',
          '首页文章顶部广告图片链接', '请输入首页文章顶部广告图片链接');
$AdControl3Src->setAttribute('class', 'bearui_content bearui_module');
        $form->addInput($AdControl3Src);
        $AdControl3Url = new Typecho_Widget_Helper_Form_Element_Text(
          'AdControl3Url', NULL, '',
          '首页文章顶部广告图片指向链接', '请输入首页文章顶部广告图片指向链接');
$AdControl3Url->setAttribute('class', 'bearui_content bearui_module');
        $form->addInput($AdControl3Url);
    //}
 $AdControl4 = new Typecho_Widget_Helper_Form_Element_Select('AdControl4', array('1' => '开启分类/搜索/标签/作者文章顶部广告',  '2' => '关闭分类/搜索/标签/作者文章顶部广告'), '2', '是否开启分类/搜索/标签/作者文章顶部广告', '若选择开启,则网站分类/搜索/标签/作者文章顶部将出现广告位置。');
    $AdControl4->setAttribute('class', 'bearui_content bearui_module');
    $form->addInput($AdControl4->multiMode());
    //if($options->AdControl4 == '1'){
        $AdControl4Src = new Typecho_Widget_Helper_Form_Element_Text(
          'AdControl4Src', NULL, '',
          '分类/搜索/标签/作者文章顶部广告图片链接', '请输入分类/搜索/标签/作者文章顶部广告图片链接');
$AdControl4Src->setAttribute('class', 'bearui_content bearui_module');
        $form->addInput($AdControl4Src);
        $AdControl4Url = new Typecho_Widget_Helper_Form_Element_Text(
          'AdControl4Url', NULL, '',
          '分类/搜索/标签/作者文章顶部广告图片指向链接', '请输入分类/搜索/标签/作者文章顶部广告图片指向链接');
$AdControl4Url->setAttribute('class', 'bearui_content bearui_module');
        $form->addInput($AdControl4Url);
   // }
    //}
    
    $Authorz = new Typecho_Widget_Helper_Form_Element_Select('Authorz', array('1' => '开启右侧博主相关区块',  '2' => '关闭右侧博主相关区块'), '2', '是否开启右侧博主相关区块', '若选择开启,则网站右侧将出现博主一栏。');
    $Authorz->setAttribute('class', 'bearui_content bearui_module');
    $form->addInput($Authorz->multiMode());
    
    $Search = new Typecho_Widget_Helper_Form_Element_Select('Search', array('1' => '开启右侧搜索区块',  '2' => '关闭右侧搜索区块'), '1', '是否开启右侧搜索区块', '若选择开启,则网站右侧将出现搜索区块，提供访客进行搜索。');
    $Search->setAttribute('class', 'bearui_content bearui_module');
    $form->addInput($Search->multiMode());
    
    //文章设置
   
$article_style = <<<HTML
<div class="ui large message">
  嗯哼～小贴士来啦<br>
  如果是要在文章中隐藏部分内容，回复才能看到的话呢，使用[bs-hide]隐藏内容[/bs-hide]就行啦，学会了吗～
</div>
HTML;
	$article_s = new Typecho_Widget_Helper_Layout();
	$article_s->html(_t($article_style));
	$article_s->setAttribute('class', 'bearui_content bearui_article');
	$form->addItem($article_s);
    $Share = new Typecho_Widget_Helper_Form_Element_Select('Share', array('1' => '开启第三方分享',  '2' => '关闭第三方分享'), '2', '是否开启文章内第三方分享', '若选择开启,则文章页面都将显示第三方分享按钮，可自定义选择显示哪个。');
    $Share->setAttribute('class', 'bearui_content bearui_article');
    $form->addInput($Share->multiMode());
    
         $Shares = new Typecho_Widget_Helper_Form_Element_Checkbox('Shares', array('qq' => '<i class="qq blue icon"></i>QQ',  'qzone' => '<i class="qq yellow icon"></i>QQ空间','weibo' => '<i class="weibo red icon"></i>微博','facebook' => '<i class="facebook blue icon"></i>Facebook','twitter' => '<i class="twitter purple icon"></i>Twitter','google' => '<i class="google plus g red icon"></i>Google','linkedin' => '<i class="linkedin blue icon"></i>Linkedin','wechat'=> '<i class="wechat green icon"></i>微信'), 'qq', '选择要显示的图标', '若选择开启,则文章页面都将显示第三方分享按钮，可自定义选择显示哪个。');
          $Shares->setAttribute('class', 'bearui_content bearui_article');
    $form->addInput($Shares);
    
   $Scroll = new Typecho_Widget_Helper_Form_Element_Select('Scroll', array('1' => '是',  '2' => '否'), '2', '是否开启文章内目录树', '<a style="color:red">实验性功能,若前台访问出现报错请关闭!</a>若选择开启,则文章页面自动识别h2、h3标签，当存在时自动生成目录树，目前仅支持h2及h3标签!!!');
    $Scroll->setAttribute('class', 'bearui_content bearui_article');
    $form->addInput($Scroll->multiMode());
   
  
    
    
    //顶部设置
    $DNSYJX = new Typecho_Widget_Helper_Form_Element_Select('DNSYJX', array('1' => '开启DNS预解析',  '2' => '禁用DNS预解析'), '2', '是否开启/禁用DNS预解析', '预置三个DNS预解析,对于某些情况而言开启能够提升访问速度,而禁用的话能节省每月100亿的DNS查询');
    $DNSYJX->setAttribute('class', 'bearui_content bearui_header');
    $form->addInput($DNSYJX->multiMode());

    $DNSADDRESS1 = new Typecho_Widget_Helper_Form_Element_Text('DNSADDRESS1', null, '', 'DNS预解析地址1', '请填入DNS预解析地址');
    $DNSADDRESS1->setAttribute('class', 'bearui_content bearui_header');
    $form->addInput($DNSADDRESS1);
    $DNSADDRESS2 = new Typecho_Widget_Helper_Form_Element_Text('DNSADDRESS2', null, '', 'DNS预解析地址2', '请填入DNS预解析地址');
    $DNSADDRESS2->setAttribute('class', 'bearui_content bearui_header');
    $form->addInput($DNSADDRESS2);
    $DNSADDRESS3 = new Typecho_Widget_Helper_Form_Element_Text('DNSADDRESS3', null, '', 'DNS预解析地址3', '请填入DNS预解析地址');
    $DNSADDRESS3->setAttribute('class', 'bearui_content bearui_header');
    $form->addInput($DNSADDRESS3);
  
    
    #----------------------->
    $CustomizationCode = new Typecho_Widget_Helper_Form_Element_Textarea('CustomizationCode', null, '', '顶部自定义代码', '如百度Meta验证代码，均可以放在这里');
    $CustomizationCode->setAttribute('class', 'bearui_content bearui_header');
    $form->addInput($CustomizationCode);
    
$Menu = new Typecho_Widget_Helper_Form_Element_Textarea('Menu', null, '', '自定义导航', '可自由添加前台自定义导航，例子:<br>https://www.baidu.com|百度<br>https://www.qq.com|QQ<br>也就是导航链接|导航名，多个直接换行即可');
    $Menu->setAttribute('class', 'bearui_content bearui_header');
    $form->addInput($Menu);
    //底部设置
    $IcpBa = new Typecho_Widget_Helper_Form_Element_Text('IcpBa', null, '', 'ICP备案号', '请填写您网站的ICP备案号,若无ICP备案请为空');
    $IcpBa->setAttribute('class', 'bearui_content bearui_footer');
    $form->addInput($IcpBa);
    
    $PoliceBa = new Typecho_Widget_Helper_Form_Element_Text('PoliceBa', null, '', '公安备案号', '请填写您网站的公安备案号,若无公安备案请为空');
    $PoliceBa->setAttribute('class', 'bearui_content bearui_footer');
    $form->addInput($PoliceBa);
    
    $CustomizationFooterCode = new Typecho_Widget_Helper_Form_Element_Textarea('CustomizationFooterCode', null, '', '底部自定义代码', '可放置网站统计代码等');
    $CustomizationFooterCode->setAttribute('class', 'bearui_content bearui_footer');
    $form->addInput($CustomizationFooterCode);
    
    //缓存设置
    $Cache = new Typecho_Widget_Helper_Form_Element_Select('Cache', array('1' => '是',  '2' => '否'), '2', '是否开启缓存功能', '开启缓存功能后您需要建立一个目录用来存放缓存文件。');
    $Cache->setAttribute('class', 'bearui_content bearui_cache');
    $form->addInput($Cache->multiMode());
    
    $cache_dir = new Typecho_Widget_Helper_Form_Element_Text(
            'cache_dir',NULL ,'cache',
            _t('设置缓存目录'),
            _t('/开头表示绝对路径,否则表示相对于usr开始的路径。注意,请自行确保目录可写,并且所在分区inode数量足够。<br>例如您填themes/bearsimple/cache/，就代表您要将缓存文件存在bearsimple中的cache目录，则您需要在bearsimple目录中建立cache目录，目录权限755即可。')
        );
        $cache_dir->setAttribute('class', 'bearui_content bearui_cache');
        $form->addInput($cache_dir);

        $cache_timeout = new Typecho_Widget_Helper_Form_Element_Text(
            'cache_timeout',NULL ,'3600',
            _t('设置缓存时间'),
            _t('设置缓存的有效期，单位是秒。如果需要手动情况缓存，请手动删除缓存目录下的所有文件')
        );
        $cache_timeout->setAttribute('class', 'bearui_content bearui_cache');
        $form->addInput($cache_timeout);
        
    //博主信息设置
    $AuthorAvatar = new Typecho_Widget_Helper_Form_Element_Text('AuthorAvatar', null, '', '博主头像图片链接', '请填写博主头像图片链接,若为空则显示默认头像<br>预览:<img width="50px" height="50px" src=' .$options->AuthorAvatar.'>');
    $AuthorAvatar->setAttribute('class', 'bearui_content bearui_author');
    $form->addInput($AuthorAvatar);
    
    $AuthorAvatarClickText = new Typecho_Widget_Helper_Form_Element_Text('AuthorAvatarClickText', null, '', '博主头像图片动作文字', '当鼠标移至头像处时会存在hover覆盖效果,目前预设了按钮，您可以自定义按钮文字及链接');
    $AuthorAvatarClickText->setAttribute('class', 'bearui_content bearui_author');
    $form->addInput($AuthorAvatarClickText);
    
    $AuthorAvatarClickLink = new Typecho_Widget_Helper_Form_Element_Text('AuthorAvatarClickLink', null, '', '博主头像图片动作链接', '当鼠标移至头像处时会存在hover覆盖效果,目前预设了按钮，您可以自定义按钮文字及链接');
    $AuthorAvatarClickLink->setAttribute('class', 'bearui_content bearui_author');
    $form->addInput($AuthorAvatarClickLink);
    
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
    
    $Telegram_URL = new Typecho_Widget_Helper_Form_Element_Text('Telegram_URL', null, '', 'Telegram链接', '请填写Telegram链接,若为空则不显示');
    $Telegram_URL->setAttribute('class', 'bearui_content bearui_author');
    $form->addInput($Telegram_URL);
    
    $FourTotalHidden = new Typecho_Widget_Helper_Form_Element_Select('FourTotalHidden', array('1' => '显示',  '2' => '不显示'), '1', '是否显示四项统计', '若选择开启，则博主信息栏将显示四项统计：文章、评论、分类、页面');
    $FourTotalHidden->setAttribute('class', 'bearui_content bearui_author');
    $form->addInput($FourTotalHidden->multiMode());
    
    //其他设置
    $CopyProtect = new Typecho_Widget_Helper_Form_Element_Select('CopyProtect', array('1' => '是',  '2' => '否'), '2', '是否开启防复制', '若开启防复制，则禁用右键、复制、拖动等');
    $CopyProtect->setAttribute('class', 'bearui_content bearui_other');
    $form->addInput($CopyProtect->multiMode());
    
    
    $Translate = new Typecho_Widget_Helper_Form_Element_Select('Translate', array('1' => '开启简繁体切换','11'=>'开启全球语言切换','2' => '否'), '2', '是否开启语言切换', '若开启,则前台顶部LOGO位置自动增加语言切换按钮，可选择开启简繁体切换或者全球几十种语言切换');
    $Translate->setAttribute('class', 'bearui_content bearui_other');
    $form->addInput($Translate->multiMode());
    
      $TranslateLanguage = new Typecho_Widget_Helper_Form_Element_Select('TranslateLanguage', array('1' => '简体中文',  '2' => '繁体中文'), '1', '选择优先显示语言', '访客访问时优先使用的语言');
    $TranslateLanguage->setAttribute('class', 'bearui_content bearui_other');
    $form->addInput($TranslateLanguage->multiMode());  
    
    $Top = new Typecho_Widget_Helper_Form_Element_Select('Top', array('1' => '是',  '2' => '否'), '1', '是否开启返回顶部', '若开启，则右侧下方将增加一个返回顶部图标，可自定义');
    $Top->setAttribute('class', 'bearui_content bearui_other');
    $form->addInput($Top->multiMode());
    
//if ($options->Top == '1'){
    $TopSrc = new Typecho_Widget_Helper_Form_Element_Text('TopSrc', null, '', '返回顶部图标地址', '请填写返回顶部图标地址,若为空则显示默认图标<br>预览:<img width="50px" height="50px" src=' .$options->TopSrc.'>');
    $TopSrc->setAttribute('class', 'bearui_content bearui_other');
    $form->addInput($TopSrc);
    //}
    $Mournmode = new Typecho_Widget_Helper_Form_Element_Select('Mournmode', array('1' => '是',  '2' => '否'), '2', '是否开启哀悼模式', '若开启哀悼模式，则网站全部显示灰色。');
    $Mournmode->setAttribute('class', 'bearui_content bearui_other');
    $form->addInput($Mournmode->multiMode());
    
    $SiteMap = new Typecho_Widget_Helper_Form_Element_Select(
        'SiteMap',
        array(
            'close' => '关闭',
            '100' => '显示最新 100 条链接',
            '200' => '显示最新 200 条链接',
            '300' => '显示最新 300 条链接',
            '400' => '显示最新 400 条链接',
            '500' => '显示最新 500 条链接',
            '600' => '显示最新 600 条链接',
            '700' => '显示最新 700 条链接',
            '800' => '显示最新 800 条链接',
            '900' => '显示最新 900 条链接',
            '1000' => '显示最新 1000 条链接',
        ),
        'off',
        '是否开启Sitemap功能',
        '开启后博客将生成sitemap<br>
         开启了伪静态后是xxx.com/sitemap.xml<br>
         没开启伪静态是xxx.com/index.php/sitemap.xml
         '
    );
    $SiteMap->setAttribute('class', 'bearui_content bearui_other');
    $form->addInput($SiteMap->multiMode());
    
    
    //弹窗设置
    $Popup = new Typecho_Widget_Helper_Form_Element_Select('Popup', array('1' => '是',  '2' => '否'), '2', '是否开启网站弹窗公告', '若开启弹窗公告，可设置弹窗内容即弹窗链接，弹窗一天仅显示一次!');
    $Popup->setAttribute('class', 'bearui_content bearui_popup');
    $form->addInput($Popup->multiMode());
    //if ($options->Popup == '1'){
    $PopupText = new Typecho_Widget_Helper_Form_Element_Textarea('PopupText', null, '', '弹窗公告内容', '请填写弹窗公告内容');
    $PopupText->setAttribute('class', 'bearui_content bearui_popup');
    $form->addInput($PopupText);
    
    $PopupUrl = new Typecho_Widget_Helper_Form_Element_Text('PopupUrl', null, '', '弹窗公告链接', '请填写弹窗公告链接，即点击确认后跳转的网址');
    $PopupUrl->setAttribute('class', 'bearui_content bearui_popup');
    $form->addInput($PopupUrl);
    
   // }
    //评论设置
   
    $Entermaxlength = new Typecho_Widget_Helper_Form_Element_Select('Entermaxlength', array('1' => '是',  '2' => '否'), '2', '是否开启评论字数限制', '若开启评论字数限制，则访客在评论时到达所限定字数即无法再输入');
    $Entermaxlength->setAttribute('class', 'bearui_content bearui_comment');
    $form->addInput($Entermaxlength->multiMode());
   
        $Entermaxlengths = new Typecho_Widget_Helper_Form_Element_Text('Entermaxlengths', null, '', '评论字数限制', '请填写评论字数限制,填写数字即可，如100');
    $Entermaxlengths->setAttribute('class', 'bearui_content bearui_comment');
    $form->addInput($Entermaxlengths);
    
    $Emoji = new Typecho_Widget_Helper_Form_Element_Select('Emoji', array('1' => '是',  '2' => '否'), '1', '是否开启评论表情', '若开启评论表情，则前台文章评论区将显示表情按钮');
    $Emoji->setAttribute('class', 'bearui_content bearui_comment');
    $form->addInput($Emoji->multiMode());
    
    $CommentCoid = new Typecho_Widget_Helper_Form_Element_Select('CommentCoid', array('1' => '是',  '2' => '否'), '1', '是否开启评论回复加@', '若开启评论回复加@，则前台文章评论区当多层楼时自动从第二层开始加上@');
    $CommentCoid->setAttribute('class', 'bearui_content bearui_comment');
    $form->addInput($CommentCoid->multiMode());
    //模块管理 -->
    $Editor = new Typecho_Widget_Helper_Form_Element_Select('Editor', array('1' => '是',  '2' => '否'), '2', '是否接管Typecho Markdown', '开启后本主题将接管Typecho官方的Markdown解析器，且内置了数学公式等');
    $Editor->setAttribute('class', 'bearui_content bearui_modules');
    $form->addInput($Editor->multiMode());
   
        
    $Codehightlight = new Typecho_Widget_Helper_Form_Element_Select('Codehightlight', array('1' => '是',  '2' => '否'), '2', '是否开启代码高亮', '开启后前台对代码显示高亮<br>格式:<br>```语言<br>这是内容<br>```');
    $Codehightlight->setAttribute('class', 'bearui_content bearui_modules');
    $form->addInput($Codehightlight->multiMode());
//if ($options->Codehightlight == '1'){
    //设置代码风格样式
        $styles = array_map('basename', glob(dirname(__FILE__) . '/modules/codehightlight/static/styles/*.css'));
        $styles = array_combine($styles, $styles);
        $name = new Typecho_Widget_Helper_Form_Element_Select('code_style', $styles, 'GrayMac.css', _t('选择高亮主题风格'),'高亮主题风格文件在/usr/themes/bearsimple/modules/codehightlight/static/style中，您可以自行设计样式放入该目录,即可在本项选择');
        $name->setAttribute('class', 'bearui_content bearui_modules');
        $form->addInput($name->addRule('enum', _t('必须选择主题'), $styles));
        $showLineNumber = new Typecho_Widget_Helper_Form_Element_Checkbox('showLineNumber', array('showLineNumber' => _t('显示行号')), array('showLineNumber'), _t('是否在代码左侧显示行号'));
        $showLineNumber->setAttribute('class', 'bearui_content bearui_modules');
        $form->addInput($showLineNumber);

//}
	//增加：
	//基础设置 - 网站背景
    $BackGround = new Typecho_Widget_Helper_Form_Element_Text('BackGround', null, '', '网站背景', '请填写网站背景图片直链,若为空则不显示<br>根据网站布局设计来说，底色建议使用白底。');
    $BackGround->setAttribute('class', 'bearui_content bearui_global');
    $form->addInput($BackGround);
    
    //实验室 - 内链
    $WebLink = new Typecho_Widget_Helper_Form_Element_Textarea('WebLink',null,'baidu|https://www.baidu.com/', '外链转内链', '<a style="color:red">可能存在玄学问题！！</a><br>外链转内链功能将把您填写在框框内的链接转化为网站的内链，需要填写的格式为：key|网站链接，key不可重复。一个链接一个key，多个请直接换行<br>举个栗子，当您填写的是baidu|https://www.baidu.com/的时候，您可以通过<br>
    未开启伪静态：您的网址/index.php/go/baidu<br>已开启伪静态：您的网址/go/baidu 来访问。');
    $WebLink->setAttribute('class', 'bearui_content bearui_lab');
    $form->addInput($WebLink);

    //模块管理新增编辑器
    $Editors = new Typecho_Widget_Helper_Form_Element_Select('Editors', array('1' => '开启编辑器优化',  '2' => '关闭编辑器优化'), '2', '是否开启编辑器优化', '若选择开启,则编辑文件、页面的时候将替换官方编辑器，更换为更加美观的编辑器。');
    $Editors->setAttribute('class', 'bearui_content bearui_modules');
    $form->addInput($Editors->multiMode());
  
    //模块管理新增音乐歌单
    $music = new Typecho_Widget_Helper_Form_Element_Select('music', array('1' => '开启音乐歌单',  '2' => '关闭音乐歌单'), '2', '是否开启音乐歌单', '若选择开启,则可设置要播放的歌单以及是否自动播放等等');
    $music->setAttribute('class', 'bearui_content bearui_modules');
    $form->addInput($music->multiMode());
    
    $music_bof = new Typecho_Widget_Helper_Form_Element_Select(
        'music_bof', array('0'=> '不自动播放', '1'=> '自动播放'), 0, '播放设置',
            '自动播放顾名思义，就是页面打开后音乐就会自动播放');
            $music_bof->setAttribute('class', 'bearui_content bearui_modules');
        $form->addInput($music_bof);

$music_sxj = new Typecho_Widget_Helper_Form_Element_Select(
        'music_sxj', array('0'=> '隐藏', '1'=> '不隐藏'), 0, '手机端是/否隐藏',
            '');
            $music_sxj->setAttribute('class', 'bearui_content bearui_modules');
        $form->addInput($music_sxj);
        $music_musicList = new Typecho_Widget_Helper_Form_Element_Textarea('music_musicList', NULL, 
'',_t('歌曲列表'), _t('
填写格式<br><b>直链方式：</b><br>填写歌曲链接地址即可，多首歌曲的话请在两首歌曲之间加换行，千万别多加回车换行。<br><b>调用网易云：</b><br>书写网易云歌曲id即可，多首歌曲的话请在两首歌曲id之间加换行，单首歌曲直接写id就行，千万别多加回车换行
<br><b>注意：</b><br>这两种填写方式不能混合输入，要么只用直链方式，要么只用网易云方式
'));
$music_musicList->setAttribute('class', 'bearui_content bearui_modules');
        $form->addInput($music_musicList);
    
    
    //基础设置 - 自定义字体
    $Diyfont = new Typecho_Widget_Helper_Form_Element_Text('Diyfont',null,'', '自定义字体', '您可以自定义网站所显示的字体，请填入字体直链，若为空则表示使用默认字体');
    $Diyfont->setAttribute('class', 'bearui_content bearui_global');
    $form->addInput($Diyfont);
    
    //自定义字体大小
    $Diyfontsize = new Typecho_Widget_Helper_Form_Element_Text('Diyfontsize',null,'', '自定义字体大小', '您可以自定义网站所显示的字体大小,单位为px(像素)，填写数字即可，若为空则表示字体大小默认不变');
    $Diyfontsize->setAttribute('class', 'bearui_content bearui_global');
    $form->addInput($Diyfontsize);
   
//给侧边栏加一个sticky粘住
    $hcsticky = new Typecho_Widget_Helper_Form_Element_Select('hcsticky', array('1' => '是',  '2' => '否'), '2', '是否对侧边栏使用粘住', '仅PC端可见，当页面很长时使用本功能可将侧边栏粘住，随着下滑还仍紧紧跟随你的步伐～');
    $hcsticky->setAttribute('class', 'bearui_content bearui_global');
    $form->addInput($hcsticky->multiMode());
 
 //自定义头像
    $DiyAvatar = new Typecho_Widget_Helper_Form_Element_Textarea('DiyAvatar',null,'', '自定义头像', '您可以自定义前台评论区随机头像，格式为a.png,b.png，保证每个头像图片都为直链可直接访问，多个头像图片使用英文逗号分隔，当本栏为空时当非QQ邮箱的情况下使用Gravatar头像，为QQ邮箱的情况下使用QQ头像。');
    $DiyAvatar->setAttribute('class', 'bearui_content bearui_global');
    $form->addInput($DiyAvatar);
    
    //给首页/分类文章输出的图片和简介加上文章访问地址
    $ALABEL = new Typecho_Widget_Helper_Form_Element_Select('ALABEL', array('1' => '是',  '2' => '否'), '2', '是否给首页/分类文章输出的图片和简介加上文章访问链接', '仅适用于部分样式。');
    $ALABEL->setAttribute('class', 'bearui_content bearui_index');
    $form->addInput($ALABEL->multiMode());
    
  
//顶部设置
  //页面输出方式自定义选择
    $PageMenu = new Typecho_Widget_Helper_Form_Element_Select('PageMenu', array('1' => '集合下拉',  '2' => '横向排列'), '1', '导航栏页面输出选择', '选择集合下拉则将所有自定义页面集合为下拉列表，而横向排列则把所有自定义页面链接直接输出');
    $PageMenu->setAttribute('class', 'bearui_content bearui_header');
    $form->addInput($PageMenu->multiMode());
    
     //图片设置
     //水印设置
    $Watermark = new Typecho_Widget_Helper_Form_Element_Select('Watermark', array('1' => '是',  '2' => '否'), '2', '是否开启文章图片水印功能', '开启后可对本功能进行详细设置，前台输出图片时自动打上水印');
    $Watermark->setAttribute('class', 'bearui_content bearui_images');
    $form->addInput($Watermark->multiMode());
    
    $WatermarkType = new Typecho_Widget_Helper_Form_Element_Select('WatermarkType', array('1' => '文字',  '2' => '图片'), '1', '水印类型', '选择要打上什么样式的水印，若选择图片方式的话在非当前域名下可能存在跨域方面的问题，需自行根据服务器情况设置');
    $WatermarkType->setAttribute('class', 'bearui_content bearui_images');
    $form->addInput($WatermarkType->multiMode());
    
    $waterMarkName = new Typecho_Widget_Helper_Form_Element_Text('waterMarkName', NULL, '', _t('水印文字/图片地址'),'若水印类型选择的是文本，则填写文字，若选择的是图片，则请填写图片直链');
        $waterMarkName->setAttribute('class', 'bearui_content bearui_images');
        $form->addInput($waterMarkName);
    
    $waterMarkKd = new Typecho_Widget_Helper_Form_Element_Text('waterMarkKd', NULL, '130', _t('水印宽度'),'填写水印宽度，单位px，填写数字即可，默认则为130');
        $waterMarkKd->setAttribute('class', 'bearui_content bearui_images');
        $form->addInput($waterMarkKd);
        
    $waterMarkTextSize = new Typecho_Widget_Helper_Form_Element_Text('waterMarkTextSize', NULL, '12', _t('水印文字大小'),'[仅当水印类型为文字的时候本项有效]<br>填写水印文字大小，单位是px，填写数字即可，默认则为12');
        $waterMarkTextSize->setAttribute('class', 'bearui_content bearui_images');
        $form->addInput($waterMarkTextSize);
        
    $waterMarkTextColor = new Typecho_Widget_Helper_Form_Element_Text('waterMarkTextColor', NULL, 'white', _t('水印文字颜色'),'[仅当水印类型为文字的时候本项有效]<br>填写水印文字颜色，可以是HEX或者RGBA 颜色代码，举个最简单的例子，比如填white，则为白色，black则为黑色');
        $waterMarkTextColor->setAttribute('class', 'bearui_content bearui_images');
        $form->addInput($waterMarkTextColor);
        
     $waterMarkTextBackground = new Typecho_Widget_Helper_Form_Element_Text('waterMarkTextBackground', NULL, 'black', _t('水印文字背景颜色'),'[仅当水印类型为文字的时候本项有效]<br>填写水印文字背景颜色，可以是HEX或者RGBA 颜色代码，举个最简单的例子，比如填white，则为白色，black则为黑色');
        $waterMarkTextBackground->setAttribute('class', 'bearui_content bearui_images');
        $form->addInput($waterMarkTextBackground);
        
    $waterMarkLocation = new Typecho_Widget_Helper_Form_Element_Select('waterMarkLocation', array('nw' => '左上角',  'n' => '正上方',  'ne' => '右上角','w' => '正左边','e' => '正右边','sw' => '左下角','s' => '正下方','se' => '右下角','c' => '正中间'),  'c', _t('水印位置'),'选择水印位置');
        $waterMarkLocation->setAttribute('class', 'bearui_content bearui_images');
        $form->addInput($waterMarkLocation);
    
    $waterMarkOpacity = new Typecho_Widget_Helper_Form_Element_Text('waterMarkOpacity', NULL, '0.7', _t('水印透明度'),'填写水印透明度，在0-1之间填写一个数字，默认0.7');
        $waterMarkOpacity->setAttribute('class', 'bearui_content bearui_images');
        $form->addInput($waterMarkOpacity);
     
    $waterMarkMargin = new Typecho_Widget_Helper_Form_Element_Text('waterMarkMargin', NULL, '10', _t('水印到图片边缘的距离'),'填写水印到图片边缘的距离，填写数字即可，默认10');
        $waterMarkMargin->setAttribute('class', 'bearui_content bearui_images');
        $form->addInput($waterMarkMargin);
    
    $waterMarkOutput = new Typecho_Widget_Helper_Form_Element_Select('waterMarkOutput', array('null'=>'使用原图格式','jpeg'=>'jpeg','png'=>'png','webp'=>'webp'), '', _t('打上水印后的图片格式'),'选择打上水印后的图片格式，默认情况下原图啥格式，输出就啥格式');
        $waterMarkOutput->setAttribute('class', 'bearui_content bearui_images');
        $form->addInput($waterMarkOutput);  

   //评论设置
    
$Html = <<<HTML
	<div class="ui piled segment">
		<h2 class="ui icon header aligned center ">
 <i class="ban icon"></i>
  <div class="content">
    评论过滤高级设置
    <div class="sub header">默认强制性过滤全空格评论、包含XSS危险内容评论，其余需过滤内容您可以通过以下项进行设置。</div>
  </div>
</h2>
</div>

HTML;

	$layout = new Typecho_Widget_Helper_Layout();
	$layout->html(_t($Html));
	$layout->setAttribute('class', 'bearui_content bearui_comment');
	$form->addItem($layout);
    
    $BearSpam_IP = new Typecho_Widget_Helper_Form_Element_Textarea('BearSpam_IP',null,'', '过滤IP', '多条IP请用换行符隔开<br />支持用*号匹配IP段，如：192.168.*.*');
    $BearSpam_IP->setAttribute('class', 'bearui_content bearui_comment');
    $form->addInput($BearSpam_IP);
    //
    $BearSpam_EMAIL = new Typecho_Widget_Helper_Form_Element_Textarea('BearSpam_EMAIL',null,'', '过滤邮箱', '多个邮箱请用换行符隔开<br />可以是邮箱的全部，或者邮箱部分关键词');
    $BearSpam_EMAIL->setAttribute('class', 'bearui_content bearui_comment');
    $form->addInput($BearSpam_EMAIL);
    //
    $BearSpam_URL = new Typecho_Widget_Helper_Form_Element_Textarea('BearSpam_URL',null,'', '过滤网址', '多个网址请用换行符隔开<br />可以是网址的全部，或者网址部分关键词。如果网址为空，该项不会起作用。');
    $BearSpam_URL->setAttribute('class', 'bearui_content bearui_comment');
    $form->addInput($BearSpam_URL);
    //
    $BearSpam_ArticleTitle = new Typecho_Widget_Helper_Form_Element_Select('BearSpam_ArticleTitle',array('1' => '是',  '2' => '否'),'', '过滤含有文章标题的评论
', '根据研究表明机器人发表的内容可能含有评论文章的标题');
    $BearSpam_ArticleTitle->setAttribute('class', 'bearui_content bearui_comment');
    $form->addInput($BearSpam_ArticleTitle);
    //
    $BearSpam_NAME = new Typecho_Widget_Helper_Form_Element_Textarea('BearSpam_NAME',null,'', '过滤昵称', '如果评论发布者的昵称含有该关键词，将执行该操作，多个请直接换行');
    $BearSpam_NAME->setAttribute('class', 'bearui_content bearui_comment');
    $form->addInput($BearSpam_NAME);
    //
    $BearSpam_NAMEMIN = new Typecho_Widget_Helper_Form_Element_Text('BearSpam_NAMEMIN',null,'', '昵称允许的最短长度', '如果评论发布者的昵称小于该最短长度将拦截');
    $BearSpam_NAMEMIN->setAttribute('class', 'bearui_content bearui_comment');
    $form->addInput($BearSpam_NAMEMIN);
    //
    $BearSpam_NAMEMAX = new Typecho_Widget_Helper_Form_Element_Text('BearSpam_NAMEMAX',null,'', '昵称允许的最长长度', '如果评论发布者的昵称大于该最长长度将拦截');
    $BearSpam_NAMEMAX->setAttribute('class', 'bearui_content bearui_comment');
    $form->addInput($BearSpam_NAMEMAX);
    //
    $BearSpam_NAMEURL = new Typecho_Widget_Helper_Form_Element_Select('BearSpam_NAMEURL',array('1' => '是',  '2' => '否'),'', '过滤昵称为网址的评论', '根据研究表明机器人发表的评论，昵称很有可能为网址');
    $BearSpam_NAMEURL->setAttribute('class', 'bearui_content bearui_comment');
    $form->addInput($BearSpam_NAMEURL);
    //
    $BearSpam_Chinese = new Typecho_Widget_Helper_Form_Element_Select('BearSpam_Chinese',array('1' => '是',  '2' => '否'),'', '过滤不包含中文的评论', '当评论内容中没有中文时进行拦截');
    $BearSpam_Chinese->setAttribute('class', 'bearui_content bearui_comment');
    $form->addInput($BearSpam_Chinese);
    //
    $BearSpam_MIN = new Typecho_Widget_Helper_Form_Element_Text('BearSpam_MIN',null,'', '评论内容允许的最短长度', '如果评论发布者的评论内容小于该最短长度将拦截');
    $BearSpam_MIN->setAttribute('class', 'bearui_content bearui_comment');
    $form->addInput($BearSpam_MIN);
    //
    $BearSpam_Words = new Typecho_Widget_Helper_Form_Element_Textarea('BearSpam_Words',null,'', '过滤敏感词', '多个词汇请用换行符隔开');
    $BearSpam_Words->setAttribute('class', 'bearui_content bearui_comment');
    $form->addInput($BearSpam_Words);
    
    
    //海报设置
    $Poster = new Typecho_Widget_Helper_Form_Element_Select('Poster', array('1' => '是',  '2' => '否'), '2', '是否开启文章微海报功能', '开启后前台文章页面会显示微海报生成按钮，在每篇文章的编辑页面都会有单独的海报生成开关选择，当本项开启而文章编辑页面选择不开启时则不开启，当文章编辑页面海报生成选择开启而本项不开启时则不开启，需要两项同时开启才算开启状态！');
    $Poster->setAttribute('class', 'bearui_content bearui_poster');
    $form->addInput($Poster->multiMode());
        
    
require_once('core/upgrade.php');




       // DIY模式 -->
    $Diy = new Typecho_Widget_Helper_Form_Element_Select('Diy', array('1' => '开启DIY模式',  '2' => '关闭DIY模式'), '2', '是否开启DIY模式', '开启后将显示DIY模式面板,以下上传密钥也必须填写,否则不显示DIY面板');
    $Diy->setAttribute('class', 'bearui_content bearui_diy');
    $form->addInput($Diy->multiMode());
    $UploadPassword= new Typecho_Widget_Helper_Form_Element_Text('UploadPassword', null, '', '上传密钥', '请填入上传密钥,建议复杂点,在DIY面板在线上传时为保证安全，需要该密钥进行验证。');
    $UploadPassword->setAttribute('class', 'bearui_content bearui_diy');
    $form->addInput($UploadPassword);


    
    $base64encrypt = base64_encode($options->UploadPassword);
    if ($options->Diy == '1'&& !empty($options->UploadPassword)){
        $file = dirname(__FILE__).'/upload/Upload'.$base64encrypt.'.Key';
        if(false!==fopen($file,'w+')){
            file_put_contents($file,$base64encrypt);
        }
        	
	Typecho_Widget::widget('Widget_Themes_Files')->to($files);
   $Html = <<<HTML


	<div class="ui piled segment">
					<input type="hidden" id='token' name="token" value="{$base64encrypt}" placeholder="Key" autocomplete="off" class="layui-input" disabled>
				
			

		<h2 class="ui icon header aligned center ">
  <i class="settings icon"></i>
  <div class="content">
    基础设计
    <div class="sub header">基础设计包括文章输出时的样式等</div>
  </div>
</h2>
</div>

HTML;

    
	$layout = new Typecho_Widget_Helper_Layout();
	$layout->html(_t($Html));
	$layout->setAttribute('class', 'bearui_content bearui_diy');
	$form->addItem($layout);

$Diys = new Typecho_Widget_Helper_Form_Element_Select('textType', array('0' => '无效果',  '1' => '阴影效果',  '2' => '叠放效果',  '3' => '多层叠放效果',  '4' => '不规则叠放效果'), '0', '首页非图底文字样式显示效果', '选择首页非图底文字样式显示效果');
    $Diys->setAttribute('class', 'bearui_content bearui_diy');
    $form->addInput($Diys->multiMode());

$Diys = new Typecho_Widget_Helper_Form_Element_Select('rightType', array('0' => '无效果',  '1' => '阴影效果',  '2' => '叠放效果',  '3' => '多层叠放效果',  '4' => '不规则叠放效果'), '0', '侧边栏样式显示效果', '选择侧边栏样式显示效果');
    $Diys->setAttribute('class', 'bearui_content bearui_diy');
    $form->addInput($Diys->multiMode());

$Diys = new Typecho_Widget_Helper_Form_Element_Select('postType', array('0' => '无效果',  '1' => '阴影效果',  '2' => '叠放效果',  '3' => '多层叠放效果',  '4' => '不规则叠放效果'), '0', '文章页面样式显示效果', '选择文章页面样式显示效果');
    $Diys->setAttribute('class', 'bearui_content bearui_diy');
    $form->addInput($Diys->multiMode());

$Diys = new Typecho_Widget_Helper_Form_Element_Select('commentType', array('0' => '无效果',  '1' => '阴影效果',  '2' => '叠放效果',  '3' => '多层叠放效果',  '4' => '不规则叠放效果'), '0', '评论区页面样式显示效果', '选择评论区页面样式显示效果');
    $Diys->setAttribute('class', 'bearui_content bearui_diy');
    $form->addInput($Diys->multiMode());
    
$Diys = new Typecho_Widget_Helper_Form_Element_Text('articleradius', null, '', '输出文章圆角值', '请输入输出文章样式圆角值<br>输入数字即可，输入输出文章样式圆角值后前台首页及分类输出时将显示圆角，更加美观，本项为空时默认不启用');
    $Diys->setAttribute('class', 'bearui_content bearui_diy');
    $form->addInput($Diys);
    
$Diys = new Typecho_Widget_Helper_Form_Element_Text('rightradius', null, '', '输出侧边栏样式圆角值', '请输入输出侧边栏样式圆角值<br>输入数字即可，当样式不为无效果时，输入输出侧边栏样式圆角值后前台侧边栏输出时将显示圆角，更加美观，本项为空时默认不启用');
    $Diys->setAttribute('class', 'bearui_content bearui_diy');
    $form->addInput($Diys);
    
$Diys = new Typecho_Widget_Helper_Form_Element_Text('postradius', null, '', '输出文章页面圆角值', '请输入输出文章页面样式圆角值<br>输入数字即可，当样式不为无效果时，输入输出文章页面样式圆角值后前台文章页面输出时将显示圆角，更加美观，本项为空时默认不启用');
    $Diys->setAttribute('class', 'bearui_content bearui_diy');
    $form->addInput($Diys);
    
$Diys = new Typecho_Widget_Helper_Form_Element_Text('commentradius', null, '', '输出评论区圆角值', '请输入输出评论区样式圆角值<br>输入数字即可，当样式不为无效果时，输入输出评论区样式圆角值后前台文章页面评论区输出时将显示圆角，更加美观，本项为空时默认不启用');
    $Diys->setAttribute('class', 'bearui_content bearui_diy');
    $form->addInput($Diys);
    
$Diys = new Typecho_Widget_Helper_Form_Element_Text('picradius', null, '', '输出图片圆角值', '请输入输出图片圆角值<br>输入数字即可，输入图片圆角值后前台图片输出时将显示圆角，更加美观，本项为空时默认不启用');
    $Diys->setAttribute('class', 'bearui_content bearui_diy');
    $form->addInput($Diys);
 



$Html = <<<HTML
<link rel="stylesheet" type="text/css" href="https://www.layuicdn.com/layui/css/layui.css" />
	<script src="https://www.layuicdn.com/layui/layui.js"></script>
			<div class="layui-form-item">

	<div class="field">
    <label>图片上传</label>
    </div><br>
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
HTML;

     
	$layout = new Typecho_Widget_Helper_Layout();
	$layout->html(_t($Html));
	$layout->setAttribute('class', 'bearui_content bearui_diy');
	$form->addItem($layout);



}
}
?>
