<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
        </div>
</div>
<footer id="footer" role="contentinfo" class="break">
 <?php if($this->options->CustomizationFooterCode): ?><?php $this->options->CustomizationFooterCode(); ?><br><?php endif; ?>
    &copy; <?php echo date('Y'); ?> <a href="<?php $this->options->siteUrl(); ?>"><?php $this->options->title(); ?></a>.<br>
    <?php _e('由 <a href="http://www.typecho.org">Typecho</a> 强力驱动 | 主题:<a href="https://github.com/whitebearcode/typecho-bearsimple">ʕ•ᴥ•ʔ BearSimple</a>  '); ?>
    <?php if ($this->options->IcpBa || $this->options->PoliceBa): ?><br><?php endif; ?>
     <?php if ($this->options->PoliceBa): ?><img src="<?php AssetsDir();?>assets/image/police.png">公安备案号:<a href="http://www.beian.gov.cn/portal/registerSystemInfo?recordcode=<?php $this->options->PoliceBa(); ?>"><?php $this->options->PoliceBa(); ?></a><?php endif; ?><?php if ($this->options->IcpBa && $this->options->PoliceBa): ?>  | <?php endif; ?><?php if ($this->options->IcpBa): ?><a href="https://beian.miit.gov.cn/"><?php $this->options->IcpBa(); ?></a><?php endif; ?>
</footer>    
</div>
</div>
</div>
</div>

<?php if($this->options->Top == '1') :?>
<div class="goTop" id="js-go_top"><img src="<?php if(!empty($this->options->TopSrc)) :?><?php $this->options->TopSrc(); ?><?php else: ?>
<?php AssetsDir();?>assets/images/icon_top.png<?php endif; ?>" alt="回到顶部"></div>
<?php endif; ?>
<?php if($this->options->RewardOpen == '1' && $this->options->RewardOpenAlipay == '1'): ?> 
<div class="ui mini modal alipay">
  <i class="close icon"></i>
  <div class="header">
    支付宝打赏
  </div><center>
  <div class="content" style="margin-top:30px">
      <img width="200" height="200" src="<?php $this->options->RewardOpenAlipayText() ?>">
  </div>
  <div style="margin-top:30px"></div>
</center>
</div>
<?php endif; ?>
<div class="ui mini modal wechatshare">
  <i class="close icon"></i>
  <div class="header">
    微信分享二维码
  </div><center>
  <div class="content" style="margin-top:30px">
      <div id="qrcode"></div>
      <br><b>微信里点“发现”，扫一下<br>二维码便可将本文分享至朋友圈。</b>
  </div>
  <div style="margin-top:30px"></div>
  
</center>
</div>

<?php if($this->options->RewardOpen == '1' && $this->options->RewardOpenWechat == '1'): ?> 
<div class="ui mini modal wechat">
  <i class="close icon"></i>
  <div class="header">
    微信打赏
  </div><center>
  <div class="content" style="margin-top:30px">
      <img width="200" height="200" src="<?php $this->options->RewardOpenWechatText() ?>">
  </div>
  <div style="margin-top:30px"></div>
</center>
</div>
<?php endif; ?>
<?php if($this->options->Compress == '1') :?><nocompress><?php endif; ?>
<script src="https://lib.baomitu.com/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript" src="<?php AssetsDir();?>assets/js/layer/layer.js"></script>
<!-- 引入BearSimple全局配置JS -->
<script type="text/javascript" src="<?php AssetsDir();?>assets/js/bearsimple.min.js?v=<?php  echo themeVersion(); ?>"></script>
<!-- BearSimple全局配置选项 -->
<script>
    	$('#nopjax').BsOptions({
    	'import' : "<?php AssetsDir();?>",
    	'import2' : "<?php AssetsDir2();?>",
    	'siteUrl' : "<?php $this->options ->siteUrl(); ?>",
<?php if($this->options->Read_Process == '1') :?>
		'readprocess': "true",
		<?php endif; ?>
		'pjax':"<?php $this->options->Pjax(); ?>",
		'search':"<?php echo count($this->options->Search); ?>",
		<?php if(in_array('header',$this->options->Search)) :?>
		'header_search': "true",
		<?php endif; ?>
		<?php if(in_array('phone',$this->options->Search)) :?>
		'phone_search': "true",
		<?php endif; ?>
		<?php if(in_array('sidebar',$this->options->Search)) :?>
		'sidebar_search': "true",
		<?php endif; ?>
<?php if($this->options->Slidersss == '1' && $this->options->SliderIndexs == '1' || $this->options->SliderOthers == '1') :?>
		'slider': "true",
		<?php endif; ?>
		<?php if($this->options->menu_style == "2"): ?>
		'menu_style': "2",
		<?php endif; ?>
		<?php if($this->options->Like == "1"): ?>
		'Like': "true",
		'Likenum': "<?php echo agreeNum($this->cid)['recording']; ?>",
		<?php endif; ?>
		<?php if($this->options->hcsticky == '1') :?>
		'sticky': "true",
		<?php endif; ?>
		<?php if($this->options->Lightbox == '1') :?>
		'imagebox': "true",
		<?php endif; ?>
		<?php if($this->options->Watermark == '1') :?>
		'Watermark': "true",
		'WatermarkType':"<?php $this->options->WatermarkType();?>",
		<?php if($this->options->WatermarkType == '1'||empty($this->options->WatermarkType)) :?>
    'Watermark_textBg':'<?php $this->options->waterMarkTextBackground();?>',
    'Watermark_textColor':'<?php if(empty($this->options->waterMarkTextColor)) :?>white<?php else:?><?php $this->options->waterMarkTextColor();?><?php endif; ?>',
    'Watermark_text': '<?php if(empty($this->options->waterMarkName)) :?><?php $this->options->title();?><?php else:?><?php $this->options->waterMarkName();?><?php endif; ?>',
    'Watermark_textWidth': <?php if(empty($this->options->waterMarkKd)) :?>130<?php else:?><?php $this->options->waterMarkKd();?><?php endif; ?>,
    'Watermark_textSize': <?php if(empty($this->options->waterMarkTextSize)) :?>12<?php else:?><?php $this->options->waterMarkTextSize();?><?php endif; ?>,
    <?php endif; ?>
    <?php if($this->options->WatermarkType == '2') :?>
    'Watermark_path':'<?php $this->options->waterMarkName();?>',
    <?php endif; ?>
    'Watermark_gravity': '<?php if(empty($this->options->waterMarkLocation)) :?>c<?php else:?><?php $this->options->waterMarkLocation();?><?php endif; ?>',
    'Watermark_opacity': <?php if(empty($this->options->waterMarkOpacity)) :?>1<?php else:?><?php $this->options->waterMarkOpacity();?><?php endif; ?>,
    'Watermark_margin': <?php if(empty($this->options->waterMarkMargin)) :?>12<?php else:?><?php $this->options->waterMarkMargin();?><?php endif; ?>,
    'waterMarkOutput': "<?php $this->options->waterMarkOutput();?>",
    <?php if(!empty($this->options->waterMarkOutput) && $this->options->waterMarkOutput !== 'null') :?>
    'Watermark_outputType': '<?php $this->options->waterMarkOutput();?>'
    <?php endif; ?>
	<?php endif; ?>
	<?php if($this->options->Popup == '1') :?>
	'Popup': "true",
	'PopupText':"<?php $this->options->PopupText() ?>",
	'PopupUrl':"<?php $this->options->PopupUrl() ?>",
	<?php endif; ?>
	<?php if($this->options->Top == '1') :?>
	'Top' : "true",
	<?php endif; ?>
	<?php if($this->options->Scroll == '1'): ?>
<?php if($this->is('post') || $this->is('page') && strpos($this->content,'h2') !== false): ?>
    'scroll': 'true',
    <?php endif; ?>
<?php endif; ?>
<?php if($this->options->Login_hidden == "2"): ?> 
    'Login_hidden':'true',
    <?php endif; ?>
    <?php if($this->options->RewardOpen == '1' && $this->options->RewardOpenAlipay == '1'): ?>
    'RewardOpenAlipay':'true',
    <?php endif; ?>
    <?php if($this->options->RewardOpen == '1' && $this->options->RewardOpenAlipay == '1'): ?>
    'RewardOpenWechat':'true',
    <?php endif; ?>
<?php if($this->options->Authorz == '1' && !empty($this->options->AuthorAvatarClickText)) :?>
    'AuthorAvatarClickText':'true',
    <?php endif; ?>
    <?php if(!empty($this->options->Wechat_QRCODE)) :?>
    'Wechat_qrcode_status':'true',
    'Wechat_qrcode':'<?php $this->options->Wechat_QRCODE();?>',
    <?php endif; ?>
    <?php if(!empty($this->options->QQ_QRCODE)) :?>
    'QQ_qrcode_status':'true',
    'QQ_qrcode':'<?php $this->options->QQ_QRCODE();?>',
    <?php endif; ?>
    <?php if($this->options->Share == '1'): ?>
    'Share':'true',
    <?php if(in_array('wechat',$this->options->Shares)) :?>
    'Sharewechat':'true',
    <?php endif; ?>
    <?php endif; ?>
    <?php if(!empty($this->options->Translate)): ?>
    'Translate':'<?php $this->options->Translate();?>',
    'TranslateLanguage':'<?php if($this->options->TranslateLanguage == '1') :?>2<?php else: ?>1<?php endif; ?>',
    <?php endif; ?>
	});
</script>
<?php if($this->options->Pjax == '1') :?>
<!-- 引入BearSimple Pjax全局配置 -->
<script src="https://deliver.application.pub/gh/defunkt/jquery-pjax/jquery.pjax.js"></script>
<script src="<?php AssetsDir();?>assets/js/nprogress.js"></script>
<script type="text/javascript" src="<?php AssetsDir();?>assets/js/bearsimple-pjax.min.js?v=<?php echo themeVersion(); ?>"></script>
<script>
    $('#pjax').BsPjaxOptions({
    'import' : "<?php AssetsDir();?>",
    'import2' : "<?php AssetsDir2();?>",
    'search':"<?php echo count($this->options->Search); ?>",  
    <?php if($this->options->Emoji == '1') :?>
    'owo': "true",
	<?php endif; ?>
	<?php if($this->options->Like == "1"): ?>
	'Like': "true",
	'Likenum': "<?php echo agreeNum($this->cid)['recording']; ?>",
	<?php endif; ?>
    <?php if($this->options->Read_Process == '1') :?>
    'readprocess': "true",
	<?php endif; ?>
	<?php if(in_array('header',$this->options->Search)) :?>
	'header_search': "true",
	<?php endif; ?>
	<?php if(in_array('phone',$this->options->Search)) :?>
	'phone_search': "true",
	<?php endif; ?>
	<?php if(in_array('sidebar',$this->options->Search)) :?>
	'sidebar_search': "true",
	<?php endif; ?>
	<?php if($this->options->menu_style == "2"): ?>
	'menu_style' : '2',
	<?php endif; ?>
	<?php if($this->options->RewardOpen == '1' && $this->options->Reward_style == '1'): ?>
	'Reward_style':'1',
	<?php endif; ?>
	<?php if($this->options->Login_hidden == "2"): ?> 
	'Login_hidden':'2',
	'loginAction':"<?php $this->options->loginAction(); ?>",
	<?php endif; ?>
	<?php if($this->options->RewardOpen == '1' && $this->options->RewardOpenAlipay == '1'): ?> 
    'RewardOpenAlipay':'true',
    <?php endif; ?>
    <?php if($this->options->RewardOpen == '1' && $this->options->RewardOpenAlipay == '1'): ?> 
    'RewardOpenWechat':'true',
    <?php endif; ?>
    <?php if($this->options->Authorz == '1' && !empty($this->options->AuthorAvatarClickText)) :?>
    'AuthorAvatarClickText':'true',
     <?php endif; ?>
    <?php if($this->options->hcsticky == '1') :?>
	'sticky': "true",
	<?php endif; ?>
	<?php if($this->options->Lightbox == '1') :?>
	'imagebox': "true",
	<?php endif; ?>
	<?php if($this->options->Watermark == '1') :?>
	'Watermark': "true",
	'WatermarkType':"<?php $this->options->WatermarkType();?>",
	<?php if($this->options->WatermarkType == '1'||empty($this->options->WatermarkType)) :?>
    'Watermark_textBg':'<?php $this->options->waterMarkTextBackground();?>',
    'Watermark_textColor':'<?php if(empty($this->options->waterMarkTextColor)) :?>white<?php else:?><?php $this->options->waterMarkTextColor();?><?php endif; ?>',
    'Watermark_text': '<?php if(empty($this->options->waterMarkName)) :?><?php $this->options->title();?><?php else:?><?php $this->options->waterMarkName();?><?php endif; ?>',
    'Watermark_textWidth': <?php if(empty($this->options->waterMarkKd)) :?>130<?php else:?><?php $this->options->waterMarkKd();?><?php endif; ?>,
    'Watermark_textSize': <?php if(empty($this->options->waterMarkTextSize)) :?>12<?php else:?><?php $this->options->waterMarkTextSize();?><?php endif; ?>,
    <?php endif; ?>
    <?php if($this->options->WatermarkType == '2') :?>
    'Watermark_path':'<?php $this->options->waterMarkName();?>',
    <?php endif; ?>
    'Watermark_gravity': '<?php if(empty($this->options->waterMarkLocation)) :?>c<?php else:?><?php $this->options->waterMarkLocation();?><?php endif; ?>',
    'Watermark_opacity': <?php if(empty($this->options->waterMarkOpacity)) :?>1<?php else:?><?php $this->options->waterMarkOpacity();?><?php endif; ?>,
    'Watermark_margin': <?php if(empty($this->options->waterMarkMargin)) :?>12<?php else:?><?php $this->options->waterMarkMargin();?><?php endif; ?>,
    'waterMarkOutput': "<?php $this->options->waterMarkOutput();?>",
    <?php if(!empty($this->options->waterMarkOutput) && $this->options->waterMarkOutput !== 'null') :?>
    'Watermark_outputType': '<?php $this->options->waterMarkOutput();?>'
    <?php endif; ?>
		<?php endif; ?>
	<?php if($this->options->Top == '1') :?>
	'Top' : "true",
	<?php endif; ?>
	<?php if($this->options->Scroll == '1'): ?>
	'Scroll': 'true',
	<?php endif; ?>
	<?php if($this->options->Slidersss == '1' && $this->options->SliderIndexs == '1' || $this->options->SliderOthers == '1') :?>
	'slider': "true",
	<?php endif; ?>
	<?php if($this->options->Codehightlight == '1') :?>
	'Codehightlight':'true',
	    <?php if($this->options->showLineNumber == '1') :?>
	'showLineNumber':'1',   
	 <?php endif; ?>
	 <?php endif; ?>
	 <?php if(!empty($this->options->Wechat_QRCODE)) :?>
    'Wechat_qrcode_status':'true',
    'Wechat_qrcode':'<?php $this->options->Wechat_QRCODE();?>',
    <?php endif; ?>
    <?php if(!empty($this->options->QQ_QRCODE)) :?>
    'QQ_qrcode_status':'true',
    'QQ_qrcode':'<?php $this->options->QQ_QRCODE();?>',
    <?php endif; ?>
    <?php if($this->options->Share == '1'): ?>
    'Share':'true',
    <?php if(in_array('wechat',$this->options->Shares)) :?>
    'Sharewechat':'true',
    <?php endif; ?>
    <?php endif; ?>
    <?php if(!empty($this->options->Translate)): ?>
    'Translate':'<?php $this->options->Translate();?>',
    'TranslateLanguage':'<?php if($this->options->TranslateLanguage == '1') :?>2<?php else: ?>1<?php endif; ?>',
    <?php endif; ?>
    	});
$(document).on('pjax:complete', function () {
<?php $this->need('modules/MakePost/poster_pjax.php'); ?>
<?php if($this->options->Codehightlight == '1') :?>
if (typeof Prism !== 'undefined') {
        var pres = document.getElementsByTagName('pre'); for (var i = 0; i < pres.length; i++) { if (pres[i].getElementsByTagName('code').length > 0) pres[i].className  = '<?php if($this->options->showLineNumber == '1') :?>line-numbers <?php endif; ?>language-php';document.getElementsByTagName('code').className  = 'language-php'; }
        Prism.highlightAll(true,null);
    }
<?php endif; ?>
});
</script>
<?php endif; ?>
<?php if($this->options->CommentTyping == '1') :?>
<script type="text/javascript" src="<?php AssetsDir();?>assets/js/commentTyping.js"></script>
<?php endif; ?>
<?php $this->footer(); ?>
<?php if($this->options->Codehightlight == '1') :?>
<script>
if (typeof Prism !== 'undefined') {
        var pres = document.getElementsByTagName('pre'); for (var i = 0; i < pres.length; i++) { if (pres[i].getElementsByTagName('code').length > 0) pres[i].className  = '<?php if($this->options->showLineNumber == '1') :?>line-numbers <?php endif; ?>language-php';document.getElementsByTagName('code').className  = 'language-php'; }
        Prism.highlightAll(true,null);
    }
    </script>
<?php endif; ?>
<?php if($this->options->Compress == '1') :?></nocompress>
<?php endif; ?>
</body>
</html>
<?php if($this->options->Compress == '1') :?>
<?php $html_source = ob_get_contents();
ob_clean();
print ob_gzip(compressHtml($html_source),9);
ob_end_flush(); ?>
<?php endif; ?>