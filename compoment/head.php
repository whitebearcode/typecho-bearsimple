<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit;?>
<?php
$seo_description = '';
$keywords = '';
$seo_description = Helper::options()->description;
  if($this->is('single') && $this->fields->seo_dec !== ''){
            $seo_description = $this->fields->seo_dec;
    } 
if(Bsoptions('keywords_hide') == true){
$keywords = '&keywords=0';    
}
if(empty(Bsoptions('IframeProtect')) || Bsoptions('IframeProtect') !== '1'){
switch(Bsoptions('IframeProtect')){
    case '2':
    header('X-Frame-Options:SAMEORIGIN');
    break;
    case '3':
    header('X-Frame-Options:DENY');  
    break;
}
}
?>
<!DOCTYPE html>
<html lang="zh-CN" data-theme="light"<?php if (Bsoptions('Mournmode') == true): ?> class="gray"<?php endif; ?>>
    <head>
    <meta name="referrer" content="always" />
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
    <?php if(is_https()):?>
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <?php endif; ?>
    <meta name="renderer" content="webkit">
 <?php if (Bsoptions('DNSYJX') == true): ?>
    <meta http-equiv="x-dns-prefetch-control" content="on">
    <?php foreach(Bsoptions('DNSYJX_AR') as $dnsyjx): ?>
    <?php if($dnsyjx['DNSADDRESS_Preconnect'] == true):?>
    <link rel="preconnect" href="<?php echo $dnsyjx['DNSADDRESS'] ?>" <?php if($dnsyjx['DNSADDRESS_Crossorign'] == true):?>crossorign<?php endif; ?>>
    <?php endif; ?>
<link rel="dns-prefetch" href="<?php echo $dnsyjx['DNSADDRESS'] ?>">
    <?php endforeach; ?>
<?php endif; ?>
<?php if (Bsoptions('DNSYJX') == '' || Bsoptions('DNSYJX') == false): ?>
<meta http-equiv="x-dns-prefetch-control" content="off">
<?php endif; ?>
 <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no, viewport-fit=cover" />
 <?php if(!empty(Bsoptions('favicon'))): ?>
 <link rel="shortcut icon" href="<?php echo Bsoptions('favicon') ?>" />
 <?php endif; ?>

 <title><?php getTitle($this); ?></title>
        <meta name="author" content="<?php $this->author(); ?>" />
    <meta name="description" content="<?php if($seo_description !== '') echo $seo_description; else getDescription($this); ?>" />
    <meta property="og:title" content="<?php getTitle($this); ?>" />
    <meta property="og:description" content="<?php if($seo_description !== '') echo $seo_description; else getDescription($this);  ?>" />
    <meta property="og:site_name" content="<?php $this->options->title(); ?>" />
    <meta property="og:type" content="<?php if($this->is('post') || $this->is('page')) echo 'article'; else echo 'website'; ?>" />
    <meta property="og:url" content="<?php $this->permalink(); ?>" />
    <meta property="article:published_time" content="<?php echo date('c', $this->created); ?>" />
    <meta property="article:modified_time" content="<?php echo date('c', $this->modified); ?>" />
    <?php $this->header('commentReply=1&description='.$keywords.'&pingback=0&xmlrpc=0&wlw=0&generator=&template=&atom='); ?>
<script src="//lib.baomitu.com/jquery/latest/jquery.min.js" type="application/javascript"></script>
<link href="<?php AssetsDir();?>assets/css/bearsimple.min.css?v=<?php echo themeVersion(); ?>" rel="stylesheet">
<link href="//lib.baomitu.com/fomantic-ui/2.9.3/semantic.min.css" rel="stylesheet">
<link href="<?php AssetsDir();?>assets/css/modules/global_custom.css?v=<?php echo themeVersion(); ?>" rel="stylesheet">
<link rel="preload" href="//lf26-cdn-tos.bytecdntp.com/cdn/expire-1-M/font-awesome/5.15.4/css/all.min.css?ver=5.15.4" as="style" onload="this.rel='stylesheet'" crossorigin>
<link rel="preload" href="//lf26-cdn-tos.bytecdntp.com/cdn/expire-1-M/font-awesome/5.15.4/css/v4-shims.min.css?ver=5.15.4" as="style" onload="this.rel='stylesheet'" crossorigin>
<link rel="preload" href="https://fonts.googleapis.com/css2?family=Noto+Serif+SC:wght@200;300;400;500;600;700;900&display=swap" as="style" onload="this.rel='stylesheet'" crossorigin>
<link rel="preload" href="//lib.baomitu.com/lxgw-wenkai-screen-webfont/1.7.0/style.min.css" as="style" onload="this.rel='stylesheet'" crossorigin>
<script  src="//lib.baomitu.com/toastr.js/2.1.4/toastr.min.js"></script>
<?php bs_style(); ?>
<?php echo Bsoptions('CustomizationCode'); ?>
<?php if(Bsoptions('Lightbox') == true) :?>
<link href="//lib.baomitu.com/fancyapps-ui/5.0.28/fancybox/fancybox.min.css" rel="stylesheet">
<?php endif;?>
<?php if(Bsoptions('Popup') == true) :?>
<link href="<?php AssetsDir();?>assets/vendors/bs-announcement/bs-announcement.css" rel="stylesheet" type="text/css">
<?php endif; ?>
<?php if(Bsoptions('Slidersss') == true) :?>
<link href="<?php AssetsDir();?>assets/vendors/slider/bearslider.min.css" rel="stylesheet" type="text/css">
<?php endif; ?>
<link href="<?php AssetsDir2();?>assets/vendors/bs-toc/bs-toc.min.css" rel="stylesheet" type="text/css">

  <?php if (Bsoptions('Translate') == "11"): ?>
  <script src="<?php AssetsDir();?>assets/vendors/translate/translate.js"></script>
  <?php endif; ?>
<link href="//lib.baomitu.com/limonte-sweetalert2/11.10.1/sweetalert2.min.css" type="text/css" rel="stylesheet" />
<?php if (Bsoptions('Poster') == true): ?>
<link href="<?php AssetsDir();?>assets/vendors/bs-poster/bearui/assets/bearui.css" rel="stylesheet" />
<link href="<?php AssetsDir();?>assets/vendors/bs-poster/bposter.css" rel='stylesheet' />
<?php endif; ?>
<link rel="stylesheet" href="<?php AssetsDir();?>assets/vendors/bs-audio/audio.css">
<script>
<?php if(Bsoptions('MathJax') == true):?>
    window.Mathjax = "open";
    <?php else:?>
    window.Mathjax = "close";
    <?php endif; ?>
    <?php if(Bsoptions('Cache') == true && (Bsoptions('Cache_choose') == 'memcached' || Bsoptions('Cache_choose') == 'redis') && Bsoptions('enable_gcache') == true):?>
    window.GlobalCache = "on";
    <?php endif; ?>
    window.Defaultfont = "<?php echo Bsoptions('articleFontDefault') ?>";
    window['setting'] = {
        import: "<?php AssetsDir();?>",
    	import2 : "<?php AssetsDir2();?>",
    	siteUrl : "<?php $this->options ->siteUrl(); ?>",
    	<?php if(Bsoptions('Darkmode') == true) :?>
		darkmode: "true",
		darkmodetype: "<?php if(Bsoptions('Darkmode_type') !== '') :?><?php echo implode(',',Bsoptions('Darkmode_type'));?><?php else:?>null<?php endif;?>",
		logo_type:"<?php echo Bsoptions('header_choose') ?>",
		darkmode_logo:"<?php echo Bsoptions('imagelogo_dark') ?>",
		<?php endif; ?>
		<?php if(Bsoptions('Lazyload') == true) :?>
		Lazyload: "true",
		<?php endif; ?>
		<?php if(Bsoptions('Mermaid') == true) :?>
		Mermaid: "true",
		<?php endif; ?>
		<?php if(Bsoptions('Mournmode') == true) :?>
		Mournmode: "true",
		<?php endif; ?>
		<?php if(Bsoptions('ClockModule') == true) :?>
		ClockModule: "true",
		<?php endif; ?>
		<?php if(Bsoptions('Animate') !== "close" && Bsoptions('Animate') !== null): ?>  
		Animate: "<?php echo Bsoptions('Animate') ?>",
		<?php endif; ?>
<?php if(Bsoptions('Read_Process') == true) :?>
		readprocess: "true",
		<?php endif; ?>
		<?php if(Bsoptions('Pjax') == '1') :?>
		pjax:"<?php echo Bsoptions('Pjax'); ?>",
		<?php else:?>
		pjax:"2",
		<?php endif; ?>
		<?php if(Bsoptions('Emoji') == true) :?>
        owo: "true",
	<?php endif; ?>
	    islogin:"<?php echo $this->user->hasLogin(); ?>",
        commentsRequireMail: "<?php echo Helper::options()->commentsRequireMail; ?>",
        commentsRequireURL: "<?php echo Helper::options()->commentsRequireURL; ?>",
	    verify_type:"<?php echo Bsoptions('VerifyChoose'); ?>",
	<?php if(Bsoptions('VerifyChoose') == '2') :?>
        vid: "<?php echo Bsoptions('vid'); ?>",
	<?php endif; ?>
	<?php if(Bsoptions('VerifyChoose') == '2-1') :?>
        dx_appid: "<?php echo Bsoptions('dx_appId'); ?>",
        dx_apiserver: "<?php echo Bsoptions('dx_domain'); ?>",
	<?php endif; ?>
	<?php if(Bsoptions('VerifyChoose') == '2-2') :?>
        turnstile_sitekey: "<?php echo Bsoptions('turnstile_key'); ?>",
        turnstile_theme: "<?php echo Bsoptions('turnstile_theme'); ?>",
	<?php endif; ?>
		<?php if(Bsoptions('VerifyChoose') == '2-3') :?>
        geetest_id: "<?php echo Bsoptions('geeid'); ?>",
	<?php endif; ?>
		search:"<?php if(!empty(Bsoptions('Search')[0]&& is_array(Bsoptions('Search')))){echo count(Bsoptions('Search'));}else{echo 0;}; ?>",
		<?php if(!empty(Bsoptions('Search')[0]) && @in_array('header',Bsoptions('Search'))) :?>
		header_search: "true",
		<?php endif; ?>
		<?php if(!empty(Bsoptions('Search')[0]) && @in_array('phone',Bsoptions('Search'))) :?>
		phone_search: "true",
		<?php endif; ?>
		<?php if(!empty(Bsoptions('Search')[0]) && @in_array('sidebar',Bsoptions('Search'))) :?>
		sidebar_search: "true",
		<?php endif; ?>
<?php if(Bsoptions('Slidersss') == '1' && Bsoptions('SliderIndexs') == '1' || Bsoptions('SliderOthers') == '1') :?>
		slider: "true",
		<?php endif; ?>
		menu_style: "2",
		<?php if(Bsoptions('Like') == true): ?>
		Like: "true",
		Likenum: "<?php echo agreeNum($this->cid)['recording']; ?>",
		getPostLikeFile:"<?php echo getPostLikeFile();?>",
		<?php endif; ?>
		<?php if(Bsoptions('Comment_like') == true): ?>
		CommentLike: "true",
		getCommentLikeFile:"<?php echo getCommentLikeFile();?>",
		<?php endif; ?>
		<?php if(Bsoptions('hcsticky') == '1') :?>
		sticky: "true",
		<?php endif; ?>
		<?php if(Bsoptions('Lightbox') == true) :?>
		imagebox: "true",
		<?php endif; ?>
		<?php if(Bsoptions('Watermark') == true) :?>
		Watermark: "true",
		WatermarkType:"<?php echo Bsoptions('WatermarkType');?>",
		<?php if(Bsoptions('WatermarkType') == '1'||empty(Bsoptions('WatermarkType'))) :?>
        Watermark_textBg:"<?php echo Bsoptions('waterMarkTextBackground');?>",
        Watermark_textColor:"<?php if(empty(Bsoptions('waterMarkTextColor'))) :?>white<?php else:?><?php echo Bsoptions('waterMarkTextColor');?><?php endif; ?>",
        Watermark_text: "<?php if(empty(Bsoptions('waterMarkName'))) :?><?php $this->options->title();?><?php else:?><?php echo Bsoptions('waterMarkName');?><?php endif; ?>",
        Watermark_textWidth: <?php if(empty(Bsoptions('waterMarkKd'))) :?>130<?php else:?><?php echo Bsoptions('waterMarkKd');?><?php endif; ?>,
        Watermark_textSize: <?php if(empty(Bsoptions('waterMarkTextSize'))) :?>12<?php else:?><?php echo Bsoptions('waterMarkTextSize');?><?php endif; ?>,
    <?php endif; ?>
    <?php if(Bsoptions('WatermarkType') == '2') :?>
        Watermark_path:"<?php echo Bsoptions('waterMarkName');?>",
    <?php endif; ?>
        Watermark_gravity: "<?php if(empty(Bsoptions('waterMarkLocation'))) :?>c<?php else:?><?php echo Bsoptions('waterMarkLocation');?><?php endif; ?>",
        Watermark_opacity: <?php if(empty(Bsoptions('waterMarkOpacity'))) :?>1<?php else:?><?php echo Bsoptions('waterMarkOpacity');?><?php endif; ?>,
        Watermark_margin: <?php if(empty(Bsoptions('waterMarkMargin'))) :?>12<?php else:?><?php echo Bsoptions('waterMarkMargin');?><?php endif; ?>,
        waterMarkOutput: "<?php echo Bsoptions('waterMarkOutput');?>",
    <?php if(!empty(Bsoptions('waterMarkOutput')) && Bsoptions('waterMarkOutput') !== 'null') :?>
        Watermark_outputType: "<?php echo Bsoptions('waterMarkOutput');?>",
    <?php endif; ?>
	<?php endif; ?>
	<?php if(Bsoptions('Popup') == true) :?>
	    Popup: "true",
	    PopupTitle: "<?php if(empty(Bsoptions('PopupTitle'))){ echo '公告栏';}else{echo Bsoptions('PopupTitle');}; ?>",
        PopupTitleClose: <?php if(Bsoptions('PopupTitleClose') == 1){ echo 'true';}else{echo 'false';}; ?>,
        PopupClose: <?php if(Bsoptions('PopupClose') == 1){ echo 'true';}else{echo 'false';}; ?>,
        PopupAutoHide: <?php if(Bsoptions('PopupAutoHide') == '0'){ echo 0;}elseif(Bsoptions('PopupAutoHide') == '1'){echo "'".'auto'."'";}else{if(empty(Bsoptions('PopupAutoHideSecond'))){echo 10;}else{echo Bsoptions('PopupAutoHideSecond');}}; ?>,
        PopupAutoClose: <?php if(Bsoptions('PopupAutoClose') == '0'){ echo 0;}elseif(Bsoptions('PopupAutoClose') == '1'){echo "'".'auto'."'";}else{if(empty(Bsoptions('PopupAutoCloseSecond'))){echo 10;}else{echo Bsoptions('PopupAutoCloseSecond');}}; ?>,
        PopupWidth: <?php if(empty(Bsoptions('PopupWidth'))){ echo 300;}elseif(Bsoptions('PopupWidth') == '0'){echo "'".'auto'."'";}else{echo Bsoptions('PopupWidth');}; ?>, 
        PopupHeight: <?php if(Bsoptions('PopupHeight') == null || Bsoptions('PopupHeight') == '0'){ echo "'".'auto'."'";}else{echo Bsoptions('PopupHeight');}; ?>,
        PopupSpeed: <?php if(empty(Bsoptions('PopupSpeed'))){ echo 10;}else{echo Bsoptions('PopupSpeed');}; ?>,
        PopupEffect: '<?php if(empty(Bsoptions('PopupEffect'))){ echo 'fading';}else{echo Bsoptions('PopupEffect');}; ?>',
	<?php endif; ?>
	<?php if(Bsoptions('Top') == true) :?>
	    Top : "true",
	<?php endif; ?>
	<?php if(Bsoptions('infinite_scroll') == true): ?>
	    infinite_scroll:'true',
	<?php else: ?>
	    infinite_scroll:'false',
	<?php endif; ?>
<?php if(Bsoptions('Login_hidden') == true): ?> 
        Login_hidden:'true',
        loginAction:'<?php $this->options->loginAction();?>',
        registerOpen:'<?php $this->options->allowRegister(); ?>',
        registerAction:'<?php $this->options->registerAction(); ?>',
        registerAllow:'<?php echo Bsoptions('UserCenterRegister'); ?>',
        login_other:"<?php if(Bsoptions('Login_Other') !== '') :?><?php echo implode(',',Bsoptions('Login_Other'));?><?php else:?>null<?php endif; ?>",
    <?php endif; ?>
    <?php if(Bsoptions('RewardOpen') == true && Bsoptions('RewardOpenAlipay') == true): ?>
        RewardOpenAlipay:'true',
        RewardOpenAlipayQrcode:'<?php echo Bsoptions('RewardOpenAlipayText') ?>',
    <?php endif; ?>
    <?php if(Bsoptions('RewardOpen') == true && Bsoptions('RewardOpenWechat') == true): ?>
        RewardOpenWechat:'true',
        RewardOpenWechatQrcode:'<?php echo Bsoptions('RewardOpenWechatText') ?>',
    <?php endif; ?>
<?php if(Bsoptions('Authorz') == '1' && !empty(Bsoptions('AuthorAvatarClickText'))) :?>
        AuthorAvatarClickText:'true',
    <?php endif; ?>
    <?php if(!empty(Bsoptions('Wechat_QRCODE'))) :?>
        Wechat_qrcode_status:'true',
        Wechat_qrcode:'<?php echo Bsoptions('Wechat_QRCODE');?>',
    <?php endif; ?>
    <?php if(!empty(Bsoptions('QQ_QRCODE'))) :?>
        QQ_qrcode_status:'true',
        QQ_qrcode:'<?php echo Bsoptions('QQ_QRCODE');?>',
    <?php endif; ?>
    <?php if(Bsoptions('Share') == true): ?>
        Share:'true',
    <?php if(!empty(Bsoptions('Shares')[0]) && @in_array('wechat',Bsoptions('Shares'))) :?>
        Sharewechat:'true',
    <?php endif; ?>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('Translate'))): ?>
        Translate:'<?php echo Bsoptions('Translate');?>',
        TranslateLanguage:'<?php if(Bsoptions('TranslateLanguage') == '1') :?>2<?php else: ?>1<?php endif; ?>',
    <?php endif; ?>
    AIService: '<?php echo Bsoptions('AIService');?>',
    <?php if(Bsoptions('AIService') == true && Bsoptions('AIService_Key') !== ''): ?>
       ai : {
        AIService_Key: '<?php echo Bsoptions('AIService_Key');?>',
        AIService_Name: '<?php if(Bsoptions('AIService_Name') !== '') echo Bsoptions('AIService_Name'); else echo "BearAI";?>',
        AIService_Introduce: '<?php if(Bsoptions('AIService_Introduce') !== '') echo Bsoptions('AIService_Introduce'); else echo "我是文章辅助AI，点击下方的按钮，让我生成本文摘要。";?>',
        AIService_Version: '<?php if(Bsoptions('AIService_Version') !== '') echo Bsoptions('AIService_Version'); else echo "BearAI";?>',
        AIService_Auto: '<?php if(Bsoptions('AIService_Auto') == true) echo 1; else echo 0;?>',
       },
    <?php endif;?>
        tips : {
          articlePwdAfterEnterSuccess_Tip : '<?php echo empty(Bsoptions('globalTips')['articlePwdAfterEnterSuccess_Tip'])? '您已成功验证文章密码，页面将在3秒后刷新~' : Bsoptions('globalTips')['articlePwdAfterEnterSuccess_Tip'];?>',
          articlePwdAfterEnterFail_Tip : '<?php echo empty(Bsoptions('globalTips')['articlePwdAfterEnterFail_Tip'])? '您输入的文章密码有误，请重新输入~' : Bsoptions('globalTips')['articlePwdAfterEnterFail_Tip'];?>',
          articleAgreeSuccess_Tip : '<?php echo empty(Bsoptions('globalTips')['articleAgreeSuccess_Tip'])? 'Yeah~您已成功点赞本文章!' : Bsoptions('globalTips')['articleAgreeSuccess_Tip'];?>',
          articleAgreeFail1_Tip : '<?php echo empty(Bsoptions('globalTips')['articleAgreeFail1_Tip'])? '啊哦，您已经点赞过惹~' : Bsoptions('globalTips')['articleAgreeFail1_Tip'];?>',
          articleAgreeFail2_Tip : '<?php echo empty(Bsoptions('globalTips')['articleAgreeFail2_Tip'])? '网络出现堵塞，请稍后重试~' : Bsoptions('globalTips')['articleAgreeFail2_Tip'];?>',
          commentSuccess_Tip : '<?php echo empty(Bsoptions('globalTips')['commentSuccess_Tip'])? '您已评论成功，将自动刷新~' : Bsoptions('globalTips')['commentSuccess_Tip'];?>',
          commentFail_Tip : '<?php echo empty(Bsoptions('globalTips')['commentFail_Tip'])? '请手动刷新页面后再尝试操作~' : Bsoptions('globalTips')['commentFail_Tip'];?>',
          commentAgreeSuccess_Tip : '<?php echo empty(Bsoptions('globalTips')['commentAgreeSuccess_Tip'])? 'Yeah~您已成功点赞!' : Bsoptions('globalTips')['commentAgreeSuccess_Tip'];?>',
          commentAgreeFail1_Tip : '<?php echo empty(Bsoptions('globalTips')['commentAgreeFail1_Tip'])? '啊哦，您已经点赞过惹~' : Bsoptions('globalTips')['commentAgreeFail1_Tip'];?>',
          commentAgreeFail2_Tip : '<?php echo empty(Bsoptions('globalTips')['commentAgreeFail2_Tip'])? '网络出现堵塞，请稍后重试~' : Bsoptions('globalTips')['commentAgreeFail2_Tip'];?>',
        }
     };
</script>
 </head>
 <body <?php if(Bsoptions('CopyProtect') == true) :?>oncontextmenu='return false' ondragstart='return false' onselectstart ='return false' onselect='document.selection.empty()' oncopy='document.selection.empty()' onbeforecopy='return false'<?php endif; ?>>
     <?php if(Bsoptions('Read_Process') == true) :?>
<div class="read_progress">
    <div class="read_progress_inner"></div>
</div>

<?php endif; ?>

     <div id="pjax">
<?php if(Bsoptions('Pjax') == true) :?>
<?php $this->header('commentReply=1&description=0&keywords=0&generator=0&template=0&pingback=0&xmlrpc=0&wlw=0&rss2=0&rss1=0&antiSpam=0&atom'); ?>
     <?php endif; ?>
     <div class="body_container" id="body_container">
         
         <div id="header">
             <div class="site-name">
<?php if(!empty(Bsoptions('Search')[0]) && @in_array('header',Bsoptions('Search'))) :?>   
        <form name="pcsearch" role="search" method="get" id="searchform1">
 <div class="bearmargin" style="float:right;"><div class="ui search"><div class="ui large icon input pc">
      <input class="prompt" id="pcsearch" type="text" name="s" placeholder="输入关键词进行搜索">
      <i hrefx="?s=" class="search link icon"></i>
</div></div></div>
</form> 
<?php endif; ?>
                 <?php if(Bsoptions('header_choose') == 'image') :?>
    <a id="logo" href="<?php $this->options->siteUrl(); ?>"><img id="sitelogo" width="250" height="70" src="<?php echo Bsoptions('imagelogo') ?>"></a>
        	    <p class="description"></p>
        	    <?php else :?>
        	     <a id="logo" href="<?php $this->options->siteUrl(); ?>"><?php echo Bsoptions('textlogo_text') ?>	     </a>
        	     <?php if(!empty(Bsoptions('textlogo_dec'))) :?>
        	    <p class="description"><?php echo Bsoptions('textlogo_dec'); ?></p>
        	     <?php endif; ?>
        	     
      <?php endif; ?>
        
        	     
        	    </div>
        	    <?php if(!empty(Bsoptions('Search')[0]) && @in_array('phone',Bsoptions('Search'))) :?> 
<form name="phonesearch" role="search" method="get" id="searchformbyphone">
 <div style="text-align:center">
<div class="ui search">
<div class="ui icon input phone">
      <input class="prompt" id="phonesearch" type="text" name="s" placeholder="输入关键词进行搜索">
      <i hrefx="?s=" class="search link icon"></i>
</div>
</div></div>
</form>
<?php endif; ?>

<?php if(Bsoptions('menu_style') == "2" || Bsoptions('menu_style') == "1" || Bsoptions('menu_style') == ""): ?>
<ul class="menu">
    <li><a href="<?php $this->options->siteUrl(); ?>"<?php if($this->is('index')): ?> class="current"<?php endif; ?>>首页</a></li>
      <?php if(Bsoptions('CategoryMenu') == null || Bsoptions('CategoryMenu') == true): ?>
    <li>
      <a  <?php if($this->is('category')): ?> class="current"<?php endif; ?>>分类</a>
      <ul>
          <?php $this->widget('Widget_Metas_Category_List')->to($categorys); ?>
          <?php while($categorys->next()): ?>

<?php if ($categorys->levels === 0): ?>

<?php $children = $categorys->getAllChildren($categorys->mid); ?>

<?php if (empty($children)) { ?>
        <li><a href="<?php $categorys->permalink(); ?>" title="<?php $categorys->name(); ?>" <?php if($this->is('category',$categorys->slug)): ?> class="current"<?php endif; ?>><?php $categorys->name(); ?></a></li>
      <?php }  else { ?>
         <li><a href="<?php $categorys->permalink(); ?>" <?php if($this->is('category',$categorys->slug)): ?> class="current"<?php endif; ?>><?php $categorys->name(); ?></a>

          <ul>
               <?php foreach ($children as $mid) { ?>
           <?php $child = $categorys->getCategory($mid); ?>

                <li><a href="<?php echo $child['permalink'] ?>" title="<?php echo $child['name']; ?>" <?php if($this->is('category',$child['slug'])): ?> class="current"<?php endif; ?>><?php echo $child['name']; ?></a></li>
                <?php } ?>
          </ul>
        </li>
          <?php } ?>
            <?php endif; ?><?php endwhile; ?>
      </ul>
    </li>
    <?php endif; ?>
    
   <?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>
<?php if($pages->have()): ?>
<?php if(Bsoptions('PageMenu') == null || Bsoptions('PageMenu') == "1"): ?>
        <li><a<?php if($this->is('page')): ?> class="current"<?php endif; ?>>页面</a>
          <ul>
                    <?php while($pages->next()): ?>
            <li><a href="<?php $pages->permalink(); ?>" <?php if($this->is('page',$pages->slug)): ?> class="current"<?php endif; ?> title="<?php $pages->name(); ?>"><?php $pages->title(); ?></a></li>
            <?php endwhile; ?>
            </ul>
        </li>
        <?php else : ?>
                    <?php while($pages->next()): ?>
            <li><a href="<?php $pages->permalink(); ?>"<?php if($this->is('page',$pages->slug)): ?> class="current"<?php endif; ?> title="<?php $pages->name(); ?>"><?php $pages->title(); ?></a></li>
         <?php endwhile; ?>
         <?php endif; ?>
<?php endif; ?>

         <?php foreach (getMenu() as $MenuLinks): ?>
        <li><a href="<?php echo $MenuLinks[0]; ?>" title="<?php echo $MenuLinks[1]; ?>"<?php if(Bsoptions('Link_blank') == true):?> target="_blank"<?php endif; ?>><?php echo $MenuLinks[1]; ?> </a></li>
        <?php endforeach; ?>
        
<?php if(Bsoptions('Login_hidden') == true): ?>
<li id="bs-login" style="display:none"><a><?php _e('登录'); ?></a></li>
<li id="bs-islogin" style="display:none"></li>
<li id="bs-islogin2" style="display:none"></li>
<?php endif; ?>
  </ul>
  <?php endif; ?>
  </div>

<div class="sticky" id="sticky">