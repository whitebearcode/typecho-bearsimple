<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

        </div>
</div>

<footer id="footer" role="contentinfo" class="break">
 <?php if(Bsoptions('CustomizationFooterCode')): ?><?php echo Bsoptions('CustomizationFooterCode'); ?><br><?php endif; ?>
    &copy; <?php echo date('Y'); ?> <a href="<?php $this->options->siteUrl(); ?>"><?php $this->options->title(); ?></a>.<br>
    <?php _e('Powered by <a href="http://www.typecho.org">Typecho</a> | Template by<a href="https://github.com/whitebearcode/typecho-bearsimple"> BearSimple</a>  '); ?>
    <?php if (Bsoptions('IcpBa') || Bsoptions('PoliceBa')): ?><br><?php endif; ?>
     <?php if (Bsoptions('PoliceBa')): ?><img style="vertical-align: middle;" src="<?php AssetsDir();?>assets/image/police.png"><a href="http://www.beian.gov.cn/portal/registerSystemInfo?recordcode=<?php echo parseNumber(Bsoptions('PoliceBa')); ?>"><?php echo Bsoptions('PoliceBa'); ?></a><?php endif; ?><?php if (Bsoptions('IcpBa') && Bsoptions('PoliceBa')): ?>  | <?php endif; ?><?php if (Bsoptions('IcpBa')): ?><a href="https://beian.miit.gov.cn/"><?php echo Bsoptions('IcpBa'); ?></a><?php endif; ?>
     <?php if(Bsoptions('load_Time') == '1'): ?><br><?php echo loadtime();?><?php endif; ?>
</footer>    

</div>

</div>
</div>

</div>

      

<!-- Popup Loading -->
<?php if(Bsoptions('Popup') == true) :?>
<ul id="announcement" style="visibility:hidden;">

<?php foreach(announmentget() as $announment){ ?>
    <li>
        <?php echo $announment; ?>
    </li>
<?php } ?>
</ul>
<?php endif; ?>
<!-- end -->

<!-- Pjax Loading -->
<?php if(Bsoptions('Pjax') == true) :?>
<div class="bs-pjax bs-pjax-mask"></div>
<div class="bs-pjax bs-pjax-anim">
    <div>
        <span class="bs-pjax-1"></span>
        <span class="bs-pjax-2"></span>
        <span class="bs-pjax-3"></span>
        <span class="bs-pjax-4"></span>
        <span class="bs-pjax-5"></span>
        <span class="bs-pjax-6"></span>
        <span class="bs-pjax-7"></span>
    </div>
</div>
<?php endif; ?>
<!-- end -->
<!-- Bstheme Panel Loading -->

<div class="bscorner-btn-group">
<?php if(Bsoptions('Darkmode') == true) :?>
    <div id="bs-theme-control" title="设置" class="bscorner-btn">
        <i class="settings icon" aria-hidden="true"></i>
    </div>
    <?php endif; ?>
    <?php if(Bsoptions('Top') == true) :?>
    <div id="bs-scroll-to-top" title="返回顶部" class="bscorner-btn" style="display:none">
        <i class="<?php if(empty(Bsoptions('TopSrc'))){echo 'fa fa-chevron-up';}else{echo Bsoptions('TopSrc');}; ?>" aria-hidden="true"></i>
    </div>
    <?php endif; ?>
</div>

<?php if(Bsoptions('Darkmode') == true) :?>
<div class="bstheme-control-panel" style="display:none">
<h4 class="ui center aligned icon header">
  <i class="settings icon"></i>
  <div class="content">
    设置中心
  </div>
</h4>
       
    <div class="bstheme-control-dark">

 <div class="Toggle_x">
  <div class="Toggle">
      
    <input type="checkbox" id="darkmode" class="Toggle-checkbox">
    <label for="darkmode" class="Toggle-label">
       深色模式
    </label>
  </div>
   </div>


 
</div>
<?php endif; ?>
<!-- end -->
<!-- ServiceWorker Loading -->
<?php if(!empty(Bsoptions('ServiceWorker')) && ishttps() == true): ?>
        <script>
            var serviceWorkerUri = '/<?php echo Bsoptions('ServiceWorker'); ?>';
            if ('serviceWorker' in navigator) {  
                navigator.serviceWorker.register(serviceWorkerUri).then(function() {
                    if (navigator.serviceWorker.controller) {
                        console.log('Service worker 已经成功运行。');
                    } else {
                    console.log('Service worker 当前存在缓存需要更新。');
                    }
                }).catch(function(error) {
                    console.log('错误: ' + error);
                });
            } else {
                console.log('Service worker 无法支持当前浏览器.');
            }
        </script>
        <?php else: ?>
        <script>
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.getRegistrations().then(function(registrations) {
            for(let registration of registrations) {
                registration.unregister()
            }}).catch(function(err) {
                console.log('Service worker 注册失败: ', err);
            });
        }
        </script>
        <?php endif; ?>
<!-- end -->


<script>
window.article_element = '<?php switch(Bsoptions('Article_forma')){
    case '3':
        echo '.wrappers';
    break;
       case '2':
         echo   '.ui.segment.diymode';
           break;
           case '1':
              echo  '.bs-simplestyle-container';
               break;
               case '5':
                 echo   '.blog-card';
                   break;
                   case '4':
                     echo   '.ui.vertical.segment';
                       break;
                       default: echo '.ui.segment.diymode';
                       
}?>
';
</script>
	<?php if(Bsoptions('Mermaid') == false) :?>
<script src="//cdn.staticfile.org/mermaid/9.2.2/mermaid.min.js" type="text/javascript"></script>
<script>
mermaid.initialize({startOnLoad:true});
</script>
	<?php endif; ?>
<?php if(Bsoptions('Scroll') == true): ?>
<!--目录树TOC-->
<script src="<?php AssetsDir();?>assets/vendors/bs-toc/bs-toc.min.js" type="text/javascript"></script>
<script>
  window.tocManager.displayDisableTocTips = false;
 window.tocManager.generateToc();  
</script>
<!-- end -->
	<?php endif; ?>
	<?php if(Bsoptions('Poster') == true): ?>
	<script src="<?php AssetsDir();?>assets/vendors/bs-poster/static/js/poster.js" type="text/javascript"></script>
	<script src="<?php AssetsDir();?>assets/vendors/bs-poster/static/js/jquery.qrcode.min.js" type="text/javascript"></script>
<?php endif; ?>
<script src="<?php AssetsDir();?>assets/js/pangu.min.js"></script>
<!-- 引入BearSimple全局配置JS -->
<script type="text/javascript" src="<?php AssetsDir();?>assets/js/bearsimple.min.js?v=<?php echo themeVersion(); ?>"></script>
 <script type="text/javascript" src="<?php AssetsDir();?>assets/js/filter.min.js?v=<?php echo themeVersion(); ?>"></script>         
<!-- BearSimple全局配置选项 -->
<script>

    	$('#nopjax').BsOptions({
    	'import' : "<?php AssetsDir();?>",
    	'import2' : "<?php AssetsDir2();?>",
    	'siteUrl' : "<?php $this->options ->siteUrl(); ?>",
    	<?php if(Bsoptions('Darkmode') == true) :?>
		'darkmode': "true",
		<?php endif; ?>
		<?php if(Bsoptions('Mermaid') == true) :?>
		'Mermaid': "true",
		<?php endif; ?>
		<?php if(Bsoptions('Mournmode') == true) :?>
		'Mournmode': "true",
		<?php endif; ?>
		<?php if(Bsoptions('ClockModule') == true) :?>
		'ClockModule': "true",
		<?php endif; ?>
		<?php if(Bsoptions('Animate') !== "close" && Bsoptions('Animate') !== null): ?>  
		'Animate': "<?php echo Bsoptions('Animate') ?>",
		<?php endif; ?>
<?php if(Bsoptions('Read_Process') == true) :?>
		'readprocess': "true",
		<?php endif; ?>
		<?php if(Bsoptions('Pjax') == '1') :?>
		'pjax':"<?php echo Bsoptions('Pjax'); ?>",
		<?php else:?>
		'pjax':"2",
		<?php endif; ?>
		<?php if(Bsoptions('Emoji') == true) :?>
        'owo': "true",
	<?php endif; ?>
	'islogin':"<?php echo $this->user->hasLogin(); ?>",
        'commentsRequireMail': "<?php echo Helper::options()->commentsRequireMail; ?>",
        'commentsRequireURL': "<?php echo Helper::options()->commentsRequireURL; ?>",
	    'verify_type':"<?php echo Bsoptions('VerifyChoose'); ?>",
	<?php if(Bsoptions('VerifyChoose') == '2') :?>
        'vid': "<?php echo Bsoptions('vid'); ?>",
	<?php endif; ?>
	<?php if(Bsoptions('VerifyChoose') == '2-1') :?>
        'dx_appid': "<?php echo Bsoptions('dx_appId'); ?>",
        'dx_apiserver': "<?php echo Bsoptions('dx_domain'); ?>",
	<?php endif; ?>
		'search':"<?php if(!empty(Bsoptions('Search')[0]&& is_array(Bsoptions('Search')))){echo count(Bsoptions('Search'));}else{echo 0;}; ?>",
		<?php if(!empty(Bsoptions('Search')[0]) && @in_array('header',Bsoptions('Search'))) :?>
		'header_search': "true",
		<?php endif; ?>
		<?php if(!empty(Bsoptions('Search')[0]) && @in_array('phone',Bsoptions('Search'))) :?>
		'phone_search': "true",
		<?php endif; ?>
		<?php if(!empty(Bsoptions('Search')[0]) && @in_array('sidebar',Bsoptions('Search'))) :?>
		'sidebar_search': "true",
		<?php endif; ?>
<?php if(Bsoptions('Slidersss') == '1' && Bsoptions('SliderIndexs') == '1' || Bsoptions('SliderOthers') == '1') :?>
		'slider': "true",
		<?php endif; ?>
		<?php if(Bsoptions('menu_style') == "2"): ?>
		'menu_style': "2",
		<?php endif; ?>
		<?php if(Bsoptions('Like') == true): ?>
		'Like': "true",
		'Likenum': "<?php echo agreeNum($this->cid)['recording']; ?>",
		'getPostLikeFile':"<?php echo getPostLikeFile();?>",
		<?php endif; ?>
		<?php if(Bsoptions('Comment_like') == true): ?>
		'CommentLike': "true",
		'getCommentLikeFile':"<?php echo getCommentLikeFile();?>",
		<?php endif; ?>
		<?php if(Bsoptions('hcsticky') == '1') :?>
		'sticky': "true",
		<?php endif; ?>
		<?php if(Bsoptions('Lightbox') == true) :?>
		'imagebox': "true",
		<?php endif; ?>
		<?php if(Bsoptions('Watermark') == true) :?>
		'Watermark': "true",
		'WatermarkType':"<?php echo Bsoptions('WatermarkType');?>",
		<?php if(Bsoptions('WatermarkType') == '1'||empty(Bsoptions('WatermarkType'))) :?>
    'Watermark_textBg':'<?php echo Bsoptions('waterMarkTextBackground');?>',
    'Watermark_textColor':'<?php if(empty(Bsoptions('waterMarkTextColor'))) :?>white<?php else:?><?php echo Bsoptions('waterMarkTextColor');?><?php endif; ?>',
    'Watermark_text': '<?php if(empty(Bsoptions('waterMarkName'))) :?><?php $this->options->title();?><?php else:?><?php echo Bsoptions('waterMarkName');?><?php endif; ?>',
    'Watermark_textWidth': <?php if(empty(Bsoptions('waterMarkKd'))) :?>130<?php else:?><?php echo Bsoptions('waterMarkKd');?><?php endif; ?>,
    'Watermark_textSize': <?php if(empty(Bsoptions('waterMarkTextSize'))) :?>12<?php else:?><?php echo Bsoptions('waterMarkTextSize');?><?php endif; ?>,
    <?php endif; ?>
    <?php if(Bsoptions('WatermarkType') == '2') :?>
    'Watermark_path':'<?php echo Bsoptions('waterMarkName');?>',
    <?php endif; ?>
    'Watermark_gravity': '<?php if(empty(Bsoptions('waterMarkLocation'))) :?>c<?php else:?><?php echo Bsoptions('waterMarkLocation');?><?php endif; ?>',
    'Watermark_opacity': <?php if(empty(Bsoptions('waterMarkOpacity'))) :?>1<?php else:?><?php echo Bsoptions('waterMarkOpacity');?><?php endif; ?>,
    'Watermark_margin': <?php if(empty(Bsoptions('waterMarkMargin'))) :?>12<?php else:?><?php echo Bsoptions('waterMarkMargin');?><?php endif; ?>,
    'waterMarkOutput': "<?php echo Bsoptions('waterMarkOutput');?>",
    <?php if(!empty(Bsoptions('waterMarkOutput')) && Bsoptions('waterMarkOutput') !== 'null') :?>
    'Watermark_outputType': '<?php echo Bsoptions('waterMarkOutput');?>',
    <?php endif; ?>
	<?php endif; ?>
	<?php if(Bsoptions('Popup') == true) :?>
	'Popup': "true",
	'PopupTitle': "<?php if(empty(Bsoptions('PopupTitle'))){ echo '公告栏';}else{echo Bsoptions('PopupTitle');}; ?>",
    'PopupTitleClose': <?php if(Bsoptions('PopupTitleClose') == 1){ echo 'true';}else{echo 'false';}; ?>,
    'PopupClose': <?php if(Bsoptions('PopupClose') == 1){ echo 'true';}else{echo 'false';}; ?>,
    'PopupAutoHide': <?php if(Bsoptions('PopupAutoHide') == '0'){ echo 0;}elseif(Bsoptions('PopupAutoHide') == '1'){echo "'".'auto'."'";}else{if(empty(Bsoptions('PopupAutoHideSecond'))){echo 10;}else{echo Bsoptions('PopupAutoHideSecond');}}; ?>,
    'PopupAutoClose': <?php if(Bsoptions('PopupAutoClose') == '0'){ echo 0;}elseif(Bsoptions('PopupAutoClose') == '1'){echo "'".'auto'."'";}else{if(empty(Bsoptions('PopupAutoCloseSecond'))){echo 10;}else{echo Bsoptions('PopupAutoCloseSecond');}}; ?>,
    'PopupWidth': <?php if(empty(Bsoptions('PopupWidth'))){ echo 300;}elseif(Bsoptions('PopupWidth') == '0'){echo "'".'auto'."'";}else{echo Bsoptions('PopupWidth');}; ?>, 
    'PopupHeight': <?php if(Bsoptions('PopupHeight') == null || Bsoptions('PopupHeight') == '0'){ echo "'".'auto'."'";}else{echo Bsoptions('PopupHeight');}; ?>,
    'PopupSpeed': <?php if(empty(Bsoptions('PopupSpeed'))){ echo 10;}else{echo Bsoptions('PopupSpeed');}; ?>,
    'PopupEffect': '<?php if(empty(Bsoptions('PopupEffect'))){ echo 'fading';}else{echo Bsoptions('PopupEffect');}; ?>',
	<?php endif; ?>
	<?php if(Bsoptions('Top') == true) :?>
	'Top' : "true",
	<?php endif; ?>
	<?php if(Bsoptions('infinite_scroll') == true): ?>
	'infinite_scroll':'true',
	<?php else: ?>
	'infinite_scroll':'false',
	<?php endif; ?>
<?php if(Bsoptions('Login_hidden') == true): ?> 
    'Login_hidden':'true',
    'loginAction':'<?php $this->options->loginAction();?>',
    <?php endif; ?>
    <?php if(Bsoptions('RewardOpen') == true && Bsoptions('RewardOpenAlipay') == true): ?>
    'RewardOpenAlipay':'true',
    'RewardOpenAlipayQrcode':'<?php echo Bsoptions('RewardOpenAlipayText') ?>',
    <?php endif; ?>
    <?php if(Bsoptions('RewardOpen') == true && Bsoptions('RewardOpenWechat') == true): ?>
    'RewardOpenWechat':'true',
    'RewardOpenWechatQrcode':'<?php echo Bsoptions('RewardOpenWechatText') ?>',
    <?php endif; ?>
<?php if(Bsoptions('Authorz') == '1' && !empty(Bsoptions('AuthorAvatarClickText'))) :?>
    'AuthorAvatarClickText':'true',
    <?php endif; ?>
    <?php if(!empty(Bsoptions('Wechat_QRCODE'))) :?>
    'Wechat_qrcode_status':'true',
    'Wechat_qrcode':'<?php echo Bsoptions('Wechat_QRCODE');?>',
    <?php endif; ?>
    <?php if(!empty(Bsoptions('QQ_QRCODE'))) :?>
    'QQ_qrcode_status':'true',
    'QQ_qrcode':'<?php echo Bsoptions('QQ_QRCODE');?>',
    <?php endif; ?>
    <?php if(Bsoptions('Share') == true): ?>
    'Share':'true',
    <?php if(!empty(Bsoptions('Shares')[0]) && @in_array('wechat',Bsoptions('Shares'))) :?>
    'Sharewechat':'true',
    <?php endif; ?>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('Translate'))): ?>
    'Translate':'<?php echo Bsoptions('Translate');?>',
    'TranslateLanguage':'<?php if(Bsoptions('TranslateLanguage') == '1') :?>2<?php else: ?>1<?php endif; ?>',
    <?php endif; ?>
	});
</script>




<?php if(Bsoptions('Pjax') == true) :?>
<!-- 引入BearSimple Pjax全局配置 -->
<script src="//cdn.staticfile.org/jquery.pjax/2.0.1/jquery.pjax.min.js"></script>
<script type="text/javascript" src="<?php AssetsDir();?>assets/js/bearsimple-pjax.min.js?v=<?php echo themeVersion(); ?>"></script>
<script>
    $('#pjax').BsPjaxOptions({
    'import' : "<?php AssetsDir();?>",
    'import2' : "<?php AssetsDir2();?>",
    'siteUrl' : "<?php $this->options ->siteUrl(); ?>",
    'search':"<?php if(!empty(Bsoptions('Search')[0])){echo count(Bsoptions('Search'));}else{echo 0;}; ?>",  
    <?php if(Bsoptions('Emoji') == true) :?>
    'owo': "true",
	<?php endif; ?>
	<?php if(Bsoptions('Mermaid') == true) :?>
	'Mermaid': "true",
	<?php endif; ?>
	<?php if(Bsoptions('Mournmode') == true) :?>
	'Mournmode': "true",
	<?php endif; ?>
	<?php if(Bsoptions('ClockModule') == true) :?>
		'ClockModule': "true",
		<?php endif; ?>
	<?php if(Bsoptions('Animate') !== "close" && Bsoptions('Animate') !== null): ?>  
		'Animate': "<?php echo Bsoptions('Animate') ?>",
		<?php endif; ?>
	<?php if(Bsoptions('Darkmode') == true) :?>
	'darkmode': "true",
	<?php endif; ?>
	<?php if(Bsoptions('Like') == true): ?>
	'Like': "true",
	'Likenum': "<?php echo agreeNum($this->cid)['recording']; ?>",
	'getPostLikeFile':"<?php echo getPostLikeFile();?>",
	<?php endif; ?>
	'islogin':"<?php echo $this->user->hasLogin(); ?>",
	'commentsRequireMail': "<?php echo Helper::options()->commentsRequireMail; ?>",
    'commentsRequireURL': "<?php echo Helper::options()->commentsRequireURL; ?>",
	<?php if(Bsoptions('Comment_like') == true): ?>
	'CommentLike': "true",
	'getCommentLikeFile':"<?php echo getCommentLikeFile();?>",
	<?php endif; ?>
    <?php if(Bsoptions('Read_Process') == true) :?>
    'readprocess': "true",
	<?php endif; ?>
	<?php if(!empty(Bsoptions('Search')[0]) && @in_array('header',Bsoptions('Search'))) :?>
	'header_search': "true",
	<?php endif; ?>
	<?php if(!empty(Bsoptions('Search')[0]) && @in_array('phone',Bsoptions('Search'))) :?>
	'phone_search': "true",
	<?php endif; ?>
	<?php if(!empty(Bsoptions('Search')[0]) && @in_array('sidebar',Bsoptions('Search'))) :?>
	'sidebar_search': "true",
	<?php endif; ?>
	<?php if(Bsoptions('menu_style') == "2"): ?>
	'menu_style' : '2',
	<?php endif; ?>
	<?php if(Bsoptions('infinite_scroll') == true): ?>
	'infinite_scroll':'true',
	<?php else: ?>
	'infinite_scroll':'false',
	<?php endif; ?>
	<?php if(Bsoptions('RewardOpen') == true && Bsoptions('Reward_style') == '1'): ?>
	'Reward_style':'1',
	<?php endif; ?>
	<?php if(Bsoptions('Login_hidden') == true): ?> 
	'Login_hidden':'2',
	'loginAction':"<?php $this->options->loginAction(); ?>",
	<?php endif; ?>
	<?php if(Bsoptions('RewardOpen') == true && Bsoptions('RewardOpenAlipay') == true): ?> 
    'RewardOpenAlipay':'true',
    'RewardOpenAlipayQrcode':'<?php echo Bsoptions('RewardOpenAlipayText') ?>',
    <?php endif; ?>
    <?php if(Bsoptions('RewardOpen') == true && Bsoptions('RewardOpenWechat') == true): ?> 
    'RewardOpenWechat':'true',
    'RewardOpenWechatQrcode':'<?php echo Bsoptions('RewardOpenWechatText') ?>',
    <?php endif; ?>
    <?php if(Bsoptions('Authorz') == true && !empty(Bsoptions('AuthorAvatarClickText'))) :?>
    'AuthorAvatarClickText':'true',
     <?php endif; ?>
    <?php if(Bsoptions('hcsticky') == '1') :?>
	'sticky': "true",
	<?php endif; ?>
	<?php if(Bsoptions('Lightbox') == true) :?>
	'imagebox': "true",
	<?php endif; ?>
	<?php if(Bsoptions('Watermark') == true) :?>
	'Watermark': "true",
	'WatermarkType':"<?php echo Bsoptions('WatermarkType');?>",
	<?php if(Bsoptions('WatermarkType') == '1'||empty(Bsoptions('WatermarkType'))) :?>
    'Watermark_textBg':'<?php echo Bsoptions('waterMarkTextBackground');?>',
    'Watermark_textColor':'<?php if(empty(Bsoptions('waterMarkTextColor'))) :?>white<?php else:?><?php echo Bsoptions('waterMarkTextColor');?><?php endif; ?>',
    'Watermark_text': '<?php if(empty(Bsoptions('waterMarkName'))) :?><?php $this->options->title();?><?php else:?><?php echo Bsoptions('waterMarkName');?><?php endif; ?>',
    'Watermark_textWidth': <?php if(empty(Bsoptions('waterMarkKd'))) :?>130<?php else:?><?php echo Bsoptions('waterMarkKd');?><?php endif; ?>,
    'Watermark_textSize': <?php if(empty(Bsoptions('waterMarkTextSize'))) :?>12<?php else:?><?php echo Bsoptions('waterMarkTextSize');?><?php endif; ?>,
    <?php endif; ?>
    <?php if(Bsoptions('WatermarkType') == '2') :?>
    'Watermark_path':'<?php echo Bsoptions('waterMarkName');?>',
    <?php endif; ?>
    'Watermark_gravity': '<?php if(empty(Bsoptions('waterMarkLocation'))) :?>c<?php else:?><?php echo Bsoptions('waterMarkLocation');?><?php endif; ?>',
    'Watermark_opacity': <?php if(empty(Bsoptions('waterMarkOpacity'))) :?>1<?php else:?><?php echo Bsoptions('waterMarkOpacity');?><?php endif; ?>,
    'Watermark_margin': <?php if(empty(Bsoptions('waterMarkMargin'))) :?>12<?php else:?><?php echo Bsoptions('waterMarkMargin') ?><?php endif; ?>,
    'waterMarkOutput': "<?php echo Bsoptions('waterMarkOutput');?>",
    <?php if(!empty(Bsoptions('waterMarkOutput')) && Bsoptions('waterMarkOutput') !== 'null') :?>
    'Watermark_outputType': '<?php echo Bsoptions('waterMarkOutput');?>',
    <?php endif; ?>
		<?php endif; ?>
	<?php if(Bsoptions('Top') == true) :?>
	'Top' : "true",
	<?php endif; ?>
<?php if(Bsoptions('Popup') == true) :?>
	'Popup': "true",
	'PopupTitle': "<?php if(empty(Bsoptions('PopupTitle'))){ echo '公告栏';}else{echo Bsoptions('PopupTitle');}; ?>",
    'PopupTitleClose': <?php if(Bsoptions('PopupTitleClose') == 1){ echo 'true';}else{echo 'false';}; ?>,
    'PopupClose': <?php if(Bsoptions('PopupClose') == 1){ echo 'true';}else{echo 'false';}; ?>,
    'PopupAutoHide': <?php if(Bsoptions('PopupAutoHide') == '0'){ echo 0;}elseif(Bsoptions('PopupAutoHide') == '1'){echo "'".'auto'."'";}else{if(empty(Bsoptions('PopupAutoHideSecond'))){echo 10;}else{echo Bsoptions('PopupAutoHideSecond');}}; ?>,
    'PopupAutoClose': <?php if(Bsoptions('PopupAutoClose') == '0'){ echo 0;}elseif(Bsoptions('PopupAutoClose') == '1'){echo "'".'auto'."'";}else{if(empty(Bsoptions('PopupAutoCloseSecond'))){echo 10;}else{echo Bsoptions('PopupAutoCloseSecond');}}; ?>,
    'PopupWidth': <?php if(empty(Bsoptions('PopupWidth'))){ echo 300;}elseif(Bsoptions('PopupWidth') == '0'){echo "'".'auto'."'";}else{echo Bsoptions('PopupWidth');}; ?>, 
    'PopupHeight': <?php if(Bsoptions('PopupHeight') == null || Bsoptions('PopupHeight') == '0'){ echo "'".'auto'."'";}else{echo Bsoptions('PopupHeight');}; ?>,
    'PopupSpeed': <?php if(empty(Bsoptions('PopupSpeed'))){ echo 10;}else{echo Bsoptions('PopupSpeed');}; ?>,
    'PopupEffect': '<?php if(empty(Bsoptions('PopupEffect'))){ echo 'fading';}else{echo Bsoptions('PopupEffect');}; ?>',
	<?php endif; ?>
	<?php if(Bsoptions('Slidersss') == true && Bsoptions('SliderIndexs') == true || Bsoptions('SliderOthers') == true) :?>
	'slider': "true",
	<?php endif; ?>
	<?php if(Bsoptions('Codehightlight') == true) :?>
	'Codehightlight':'true',
	    <?php if(Bsoptions('showLineNumber') == true) :?>
	'showLineNumber':'1',   
	 <?php endif; ?>
	 <?php endif; ?>
	 <?php if(!empty(Bsoptions('Wechat_QRCODE'))) :?>
    'Wechat_qrcode_status':'true',
    'Wechat_qrcode':'<?php Bsoptions('Wechat_QRCODE');?>',
    <?php endif; ?>
    <?php if(!empty(Bsoptions('QQ_QRCODE'))) :?>
    'QQ_qrcode_status':'true',
    'QQ_qrcode':'<?php echo Bsoptions('QQ_QRCODE');?>',
    <?php endif; ?>
    <?php if(Bsoptions('Share') == true): ?>
    'Share':'true',
    <?php if(!empty(Bsoptions('Shares')[0]) && @in_array('wechat',Bsoptions('Shares'))) :?>
    'Sharewechat':'true',
    <?php endif; ?>
    <?php endif; ?>
    <?php if(!empty(Bsoptions('Translate'))): ?>
    'Translate':'<?php echo Bsoptions('Translate');?>',
    'TranslateLanguage':'<?php if(Bsoptions('TranslateLanguage') == '1') :?>2<?php else: ?>1<?php endif; ?>',
    <?php endif; ?>
    	});


$(document).on('pjax:complete', function () {
    
<?php if(Bsoptions('CustomizationFooterJsPjaxCode')): ?><?php echo Bsoptions('CustomizationFooterJsPjaxCode'); ?><?php endif; ?>
    <?php if(Bsoptions('Scroll') == true): ?>
window.tocManager.displayDisableTocTips = false;
            window.tocManager.generateToc();
            <?php endif; ?>
<?php if(Bsoptions('Codehightlight') == true) :?>
if (typeof Prism !== 'undefined') {
        var pres = document.getElementsByTagName('pre'); for (var i = 0; i < pres.length; i++) { if (pres[i].getElementsByTagName('code').length > 0) pres[i].className  = '<?php if(Bsoptions('showLineNumber') == 1) :?>line-numbers <?php endif; ?>language-';document.getElementsByTagName('code').className  = 'language-'; }
        Prism.highlightAll(true,null);
    };
<?php endif; ?>
});
</script>
<?php endif; ?>
<?php if(Bsoptions('CommentTyping') == true) :?>
<script type="text/javascript" src="<?php AssetsDir();?>assets/js/commentTyping.js"></script>
<?php endif; ?>
<?php $this->footer(); ?>
<?php if(Bsoptions('Codehightlight') == true) :?>
<script>
if (typeof Prism !== 'undefined') {
        var pres = document.getElementsByTagName('pre'); for (var i = 0; i < pres.length; i++) { if (pres[i].getElementsByTagName('code').length > 0) pres[i].className  = '<?php if(Bsoptions('showLineNumber') == 1) :?>line-numbers <?php endif; ?>language-';document.getElementsByTagName('code').className  = 'language-'; }
        Prism.highlightAll(true,null);
    };
    </script>
<?php endif; ?>
<?php if(Bsoptions('CustomizationFooterJsCode')): ?><?php echo Bsoptions('CustomizationFooterJsCode'); ?><?php endif; ?>

</body>
</html>
<?php if(Bsoptions('Compress') == true) :?>
<?php $html_source = ob_get_contents();
ob_clean();
print compressHtml($html_source);
ob_end_flush(); ?>
<?php endif; ?>