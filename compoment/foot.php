<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
        </div>
</div>
<footer id="footer" role="contentinfo" class="break">
    
    <?php if(Bsoptions('FriendLinkChoose') == true && Bsoptions('FriendLinkFoot') == true) :?>
<?php if((Bsoptions('FriendLink_place') == '1') || (Bsoptions('FriendLink_place') == '2' && $this->is('index'))) :?>
    <?php if(!empty(Bsoptions('FriendLink'))) :?>
    
    <div class="ui small horizontal divided list">
    友情链接：
    <?php foreach (getFriendLink() as $FriendLinks): ?>
  <div class="item">
    <div class="content">
      <div><a href="<?php echo $FriendLinks[2]; ?>" title="<?php echo $FriendLinks[1]; ?>"<?php echo parselink($FriendLinks[2]); ?>><?php echo $FriendLinks[0]; ?></a></div>
    </div>
  </div>
 <?php endforeach;?>
</div>
<br>
<?php endif;?>
<?php endif;?><?php endif;?>

 <?php if(Bsoptions('CustomizationFooterCode')): ?><?php echo Bsoptions('CustomizationFooterCode'); ?><br><?php endif; ?>
    &copy; <?php echo date('Y'); ?> <a href="<?php $this->options->siteUrl(); ?>"><?php $this->options->title(); ?></a><?php if(Bsoptions('allOfCharacters') == true): ?> （<i class="pencil alternate icon"></i>本站总字数:<?php echo allOfCharacters(); ?>字）<?php endif; ?>

<br>
    <?php _e('Powered by <a href="http://www.typecho.org">Typecho</a> & <a href="https://github.com/whitebearcode/typecho-bearsimple"> BearSimple</a>  '); ?>
    <?php if (Bsoptions('IcpBa') || Bsoptions('PoliceBa')): ?><br><?php endif; ?>
     <?php if (Bsoptions('PoliceBa')): ?><img style="vertical-align: middle;" src="<?php AssetsDir();?>assets/image/police.png"><a href="http://www.beian.gov.cn/portal/registerSystemInfo?recordcode=<?php echo parseNumber(Bsoptions('PoliceBa')); ?>"><?php echo Bsoptions('PoliceBa'); ?></a><?php endif; ?><?php if (Bsoptions('IcpBa') && Bsoptions('PoliceBa')): ?>  | <?php endif; ?><?php if (Bsoptions('IcpBa')): ?><a href="https://beian.miit.gov.cn/"><?php echo Bsoptions('IcpBa'); ?></a><?php endif; ?>
     <?php if(Bsoptions('load_Time') == '1'): ?><br><?php echo loadtime();?><?php endif; ?>
</footer>    

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
<?php if(Bsoptions('Control_Panel') == true) :?>
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

<?php if(Bsoptions('Control_Panel') == true) :?>
<div class="bstheme-control-panel" style="display:none">
<h4 class="ui center aligned icon header">
  <i class="settings icon"></i>
  <div class="content">
    设置中心
  </div>
</h4>
       <?php if (Bsoptions('Translate') == "11"): ?><p><?php $this->need('modules/translate.php'); ?></p><?php endif; ?>
       <?php if (Bsoptions('Translate') == "1"): ?><p><a id="translateLink" class="ui mini button">切换为繁體</a></p><?php endif; ?>


<?php if(Bsoptions('Darkmode') == true) :?>
 <div class="bstheme-control-dark">
<div class="switch-check has-label">
				<input type="checkbox" id="darkmode" value="true" name="darkmode">
				<label class="label" for="darkmode">
					<span class="slider-check"></span>
				</label>
			</div>
 
</div>
<?php endif; ?>
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
<?php if(Bsoptions('Login_hidden') == true): ?>
function isLogin(){
    $.ajax({
                        type: "POST",
                        async:true,
                        url: "<?php getIsLogin(); ?>",
                        data: {
                            "action": 'find',
                        },
                        dateType: "json",
                        success: function(json) {
                            res = JSON.parse(json);
        switch(res.code){
            case 0:
        $('#bs-islogin').fadeOut();
    $('#bs-login').fadeIn();
    break;
    case 1:
       switch(res.group){ 
           case 'administrator' || 'editor':
       $('#bs-islogin').html('<a href="'+res.url+'" pjax="no"><?php _e('进入管理中心'); ?></a>').fadeIn();
       <?php if(Bsoptions('UserCenterOpen') == true):?>
       
       $('#bs-islogin2').html('<a href="<?php $this->options->siteUrl(); ?><?php if($this->options->rewrite == 0 || $this->options->rewrite == ''):?>index.php/<?php endif;?>usercenter" pjax="no"><?php _e('进入用户中心'); ?></a>').fadeIn();
       <?php endif; ?>
    $('#bs-login').fadeOut();
    break;
    default:
    <?php if(Bsoptions('UserCenterOpen') == true):?>
       $('#bs-islogin2').html('<a href="<?php $this->options->siteUrl(); ?><?php if($this->options->rewrite == 0 || $this->options->rewrite == ''):?>index.php/<?php endif;?>usercenter" pjax="no"><?php _e('进入用户中心'); ?></a>').fadeIn();
     <?php endif; ?>
    $('#bs-login').fadeOut();
    break;
       }
        }
        
                        },
                        
                        error: function() {
                            toastr.warning("状态获取失败");
                        }
                    });
         
}
isLogin();
<?php endif; ?>
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
                       case '6':
                     echo   '.post-item';
                       break;
                       default: echo '.ui.segment.diymode';
                       
}?>
';
</script>



<?php if(Bsoptions('Scroll') == true): ?>
<!--目录树TOC-->
<script src="<?php AssetsDir();?>assets/vendors/bs-toc/bs-toc.min.js" type="text/javascript"></script>
<script>
  window.tocManager.displayDisableTocTips = false;
 window.tocManager.generateToc();  
</script>
<!-- end -->
	<?php endif; ?>
	<?php if(Bsoptions('Lightbox') == true) :?>
<script src="//lib.baomitu.com/fancyapps-ui/5.0.29/fancybox/fancybox.umd.min.js"></script>
<?php endif; ?>
	<?php if(Bsoptions('MathJax') == true):?>
<script src="//lib.baomitu.com/mathjax/2.7.9/MathJax.js?config=TeX-AMS-MML_HTMLorMML" defer></script>	
<?php endif; ?>
<?php if(Bsoptions('Mermaid') == true):?>
<script type="module">
    import mermaid from '//lib.baomitu.com/mermaid/10.6.1/mermaid.esm.min.mjs';
    mermaid.initialize({startOnLoad:true});
    <?php if(Bsoptions('Pjax') == true) :?>
    $(document).on('pjax:complete', function () {
    mermaid.init();    
    });
    <?php endif; ?>
</script>
<?php endif; ?>

<!-- 引入Pjax -->
<?php if(Bsoptions('Pjax') == true) :?>
<script src="<?php AssetsDir();?>assets/js/jquery.pjax.js"></script>
<?php endif;?>
<!-- 引入全局控制 -->
<script type="text/javascript" src="//lib.baomitu.com/fomantic-ui/2.9.3/semantic.min.js" defer></script>
<script type="text/javascript" src="<?php AssetsDir();?>assets/js/app.bundle.min.js?v=<?php echo themeVersion(); ?>" defer></script>

<?php if(Bsoptions('Pjax') == true) :?>
<script>
$(document).on('pjax:complete', function () {
if (document.getElementById('echarts_pie')) EchartsInit();
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
<script src="<?php AssetsDir();?>assets/js/instantPage.js" type="module"></script>
</body>
</html>
<?php if(Bsoptions('Compress') == true) :?>
<?php $html_source = ob_get_contents();
ob_clean();
print compressHtml($html_source);
ob_end_flush(); ?>
<?php endif; ?>