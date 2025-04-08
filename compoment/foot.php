<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
        </div>
        
<?php if(Bsoptions('Popup') == true) :?>
<script src="<?php AssetsDir();?>assets/vendors/bs-announcement/bs-announcement.min.js?v=1" type="text/javascript"></script>
<div id="announcement-root" 
     data-announcements='<?= 
         htmlspecialchars(json_encode(Bsoptions('Popup_Value')), ENT_QUOTES, 'UTF-8') 
     ?>'
     data-settings='<?= 
         json_encode([
             'storageKey' => Bsoptions('PopupKey') ?: 'announcement',
             'popupTitle' => Bsoptions('PopupTitle') ?: '最新公告'
         ]) 
     ?>'>
</div>
<?php endif; ?>

</div>
<?php if(Bsoptions('RewardOpen') == true):?>
<?php
$payment_config = [
    'alipay' => [
        'enabled' => !empty(Bsoptions('RewardOpenAlipay')),
        'label' => '支付宝',
        'type' => 'qrcode',
        'src' => Bsoptions('RewardOpenAlipayText')
    ],
    'wechat' => [
        'enabled' => !empty(Bsoptions('RewardOpenWechat')),
        'label' => '微信',
        'type' => 'qrcode',
        'src' => Bsoptions('RewardOpenWechatText')
    ],
    'qq' => [
        'enabled' => !empty(Bsoptions('RewardOpenQQ')),
        'label' => 'QQ',
        'type' => 'qrcode',
        'src' => Bsoptions('RewardOpenQQText')
    ],
    'afdian' => [
        'enabled' => !empty(Bsoptions('RewardOpenAfdian')),
        'label' => '爱发电',
        'type' => 'link',
        'href' => Bsoptions('RewardOpenAfdianText')
    ],
    'paypal' => [
        'enabled' => !empty(Bsoptions('RewardOpenPaypal')),
        'label' => 'PayPal',
        'type' => 'link',
        'href' => Bsoptions('RewardOpenPaypalText')
    ]
];

$active_methods = array_filter($payment_config, function($item) {
    return $item['enabled'] === true;
});

$first_key = null;
if (!empty($active_methods)) {
    $first_key = array_key_first($active_methods);
}
?>
<div class="donate-modal__mask">
  <div class="donate-modal__container">
    <div class="donate-modal__header">
      <h3>支持作者</h3>
      <span class="donate-modal__close">&times;</span>
    </div>
    
    <?php if (!empty($active_methods)) : ?>
    <div class="donate-modal__nav">
      <?php foreach ($active_methods as $key => $method) : ?>
        <div class="donate-tab <?= $key === $first_key ? 'active' : '' ?>" 
             data-target="<?= $key ?>">
          <?= htmlspecialchars($method['label']) ?>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="donate-content">
      <?php foreach ($active_methods as $key => $method) : ?>
        <div class="donate-pane <?= $key === $first_key ? 'active' : '' ?>" id="<?= $key ?>">
          <?php if($method['type'] === 'qrcode') : ?>
            <img src="<?= htmlspecialchars($method['src']) ?>" 
                 alt="<?= htmlspecialchars($method['label']) ?>二维码" style="max-width:200px;max-height:200px;">
          <?php elseif($method['type'] === 'link') : ?>
            <a href="<?= htmlspecialchars($method['href']) ?>" 
               target="_blank" 
               rel="noopener noreferrer"
               class="donate-paypal-link">
              前往<?= htmlspecialchars($method['label']) ?>
            </a>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>
    <?php else : ?>
    <div class="donate-empty">
      当前暂无可用支付方式
    </div>
    <?php endif; ?>
  </div>
</div>
<?php endif; ?>

<?php if(Bsoptions('Top') == true) :?>
  <button id="back-to-top" class="fixed-button">
    <i class="<?php if(empty(Bsoptions('TopSrc'))){echo 'fas fa-chevron-up';}else{echo Bsoptions('TopSrc');}; ?>"></i>
  </button>
<?php endif;?>
<?php if(Bsoptions('Control_Panel') == true) :?>
  <!-- 设置按钮 -->
  <button id="foot-settings-button" class="fixed-button">
    <i class="fas fa-cogs"></i>
  </button>

<!-- 设置面板 -->
<div id="foot-settings-panel" class="foot-settings-panel ignore">
  <div class="foot-panel-header">
    <h3>设置</h3>
    <button id="foot-close-panel" class="foot-close-button">
      <i class="fas fa-times"></i>
    </button>
  </div>
  <div class="foot-panel-content">
    <!-- 黑暗模式切换 -->
    <div class="foot-setting-item">
      <div class="foot-setting-label">
        <i class="fas fa-moon"></i>
        <span>黑暗模式</span>
      </div>
      <div class="bstheme-control-dark">
        <div class="switch-check">
          <input type="checkbox" id="darkmode" value="true" name="darkmode">
          <label class="label" for="darkmode">
            <span class="slider-check"></span>
          </label>
        </div>
      </div>
    </div>
 <?php if (Bsoptions('Translate') == "1"): ?>
    <!-- 简繁体切换 -->
    <div class="foot-setting-item">
      <div class="foot-setting-label">
        <i class="fas fa-language"></i>
        <span>简繁体切换</span>
      </div>
      <div class="language-buttons">
        <button id="translateLink" class="language-btn active" onclick="translatePage(); return false;">简体</button>
      </div>
    </div>
    <?php endif; ?>
 <?php if (Bsoptions('Translate') == "11"): ?><?php $this->need('modules/translate.php'); ?>
 <?php endif; ?>

   
  </div>
</div>
<?php endif;?>

  <script>
$(document).ready(function () {
  const backToTopButton = $('#back-to-top');

  backToTopButton.on('click', function () {
    $('html, body').animate({ scrollTop: 0 }, 'smooth');
  });

  $(window).on('scroll', function () {
    if ($(window).scrollTop() > 100) {
      backToTopButton.css('display', 'flex');
    } else {
      backToTopButton.css('display', 'none');
    }
  });

  const settingsButton = $('#foot-settings-button');
  const settingsPanel = $('#foot-settings-panel');
  const closePanelButton = $('#foot-close-panel');

  settingsButton.on('click', function () {
    settingsPanel.css('display', 'block');
  });

  closePanelButton.on('click', function () {
    settingsPanel.css('display', 'none');
  });

      $(window).on('click', function (event) {
        if (
          !$(event.target).closest('#foot-settings-button').length &&
          !settingsPanel.has(event.target).length
        ) {
          settingsPanel.css('display', 'none');
        }
      });
});

  </script>





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
    <?php _e('Powered by <a href="http://www.typecho.org" target="_blank">Typecho</a> & <a href="https://github.com/whitebearcode/typecho-bearsimple" target="_blank"> BearSimple</a>  '); ?>
    <?php if (Bsoptions('IcpBa') || Bsoptions('PoliceBa')): ?><br><?php endif; ?>
     <?php if (Bsoptions('PoliceBa')): ?><img style="vertical-align: middle;" src="<?php AssetsDir();?>assets/images/beian.png"> <a href="http://www.beian.gov.cn/portal/registerSystemInfo?recordcode=<?php echo parseNumber(Bsoptions('PoliceBa')); ?>" target="_blank"><?php echo Bsoptions('PoliceBa'); ?></a><?php endif; ?><?php if (Bsoptions('IcpBa') && Bsoptions('PoliceBa')): ?>  |  <?php endif; ?><?php if (Bsoptions('IcpBa')): ?><img style="vertical-align: middle;" src="<?php AssetsDir();?>assets/images/icp.png"> <a href="https://beian.miit.gov.cn/" target="_blank"><?php echo Bsoptions('IcpBa'); ?></a><?php endif; ?>
     <?php if(Bsoptions('load_Time') == '1'): ?><br><?php echo loadtime();?><?php endif; ?>
     <?php if(Bsoptions('blogsclub_shuttle') == true): ?>
     <br><a href="https://www.blogsclub.org/go"> <img src="<?php AssetsDir();?>assets/images/blogsclub-shuttle.svg" loading="lazy"></a>
     <?php endif;?>
</footer>    

</div>

</div>
</div>

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


<script>
function checkAuth() {
    $.ajax({
        type: "POST",
        url: "<?php getIsLogin(); ?>",
        data: { action: 'find' },
        dataType: "json",
        success: function(res) {
            $('.need-login').toggle(res.code === 1);
            <?php if(Bsoptions('Login_hidden') == true): ?>
            if(res.code === 1) {
                if(res.group === 'administrator' || res.group === 'editor') {
                    $('#bs-islogin').html(
                        `<a href="${res.url}" class="sm-nav-link" pjax="no">
                            <?php _e('进入管理中心'); ?>
                        </a>`
                    ).fadeIn();
                }
                <?php if(Bsoptions('UserCenterOpen')): ?>
                    $('#bs-islogin2').html(
                        `<a href="<?= $this->options->siteUrl() ?>usercenter" 
                           class="sm-nav-link" 
                           pjax="no">
                            <?php _e('进入用户中心'); ?>
                        </a>`
                    ).fadeIn();
                <?php endif; ?>
                
                $('#bs-login').hide();
            } else {
                $('#bs-islogin, #bs-islogin2').hide();
                $('#bs-login').fadeIn();
            }
            <?php endif;?>
        },
        error: function() {
            toastr.warning('状态检测失败');
        }
    });
}

$(document).on('pjax:complete', checkAuth);

$(function() {
    checkAuth();
    const interval = 300000;
    let timer = setInterval(checkAuth, interval);
    $(window).blur(() => clearInterval(timer));
    $(window).focus(() => {
        checkAuth();
        timer = setInterval(checkAuth, interval);
    });
});

window.article_element = '<?php switch(Bsoptions('Article_forma')){
    case '1':
    default:
        echo '.pic-article-card';
    break;
       case '2':
         echo   '.simple-article-item';
           break;
                       
}?>
';
</script>

<?php if((Bsoptions('menu_style') !== "3") && Bsoptions('menu_tem') == "2" || Bsoptions('menu_tem') == ""):?>
<script src="<?php AssetsDir();?>assets/vendors/menu/menu.min.js"></script>
<script>
    const bearnavbar = new SmartMenus(document.querySelector('#bearnavbar'), {
  dropdownsShowTrigger: 'mouseover',
  dropdownsHideTrigger: 'mouseout',
  dropdownsHideTimeout: '200'
});
<?php if(Bsoptions('menu_NewtemSticky') == true):?>
window.addEventListener('scroll', function() {
  var navbar = document.getElementById('bearnavbar');
  var scroll = window.scrollY;
  if (scroll > 0) {
    navbar.classList.add('fixed-top');
  } else {
    navbar.classList.remove('fixed-top');
  }
});
<?php endif; ?>
</script>
<?php endif; ?>

<?php if(Bsoptions('Scroll') == true): ?>
<!--目录树TOC-->
<script src="<?php AssetsDir();?>assets/vendors/bs-toc/bs-toc.min.js" type="text/javascript"></script>
<?php if(Bsoptions('Readmode') == true): ?> 
<script src="<?php AssetsDir();?>assets/vendors/bs-toc/bs-toc2.min.js" type="text/javascript"></script>
<?php endif; ?>
<script>
  window.tocManager.displayDisableTocTips = false;
 window.tocManager.generateToc();  
 <?php if(Bsoptions('Readmode') == true): ?> 
 window.tocManagerRead.displayDisableTocTips2 = true;
 window.tocManagerRead.generateToc2();  
 	<?php endif; ?>
</script>
<!-- end -->
	<?php endif; ?>
	<?php if(Bsoptions('Lightbox') == true) :?>
<script src="<?php AssetsDir();?>assets/vendors/fancybox/fancybox.umd.min.js"></script>
<?php endif; ?>

<?php if(Bsoptions('MathJax') == true):?>
<script src="<?php AssetsDir();?>assets/vendors/mathjax-v3/tex-chtml.js" defer></script>
<script>
MathJax = {
  tex: {
    inlineMath: [['$', '$'], ['\$', '\$']]
  },
  options: {
    enableFontLoading: true,
    enableMenu: false,
    skipHtmlTags: ['script', 'noscript', 'style', 'textarea', 'pre'],
    ignoreHtmlClass: 'tex2jax_ignore'
  },
  startup: {
    pageReady: () => MathJax.startup.defaultPageReady()
  }
}; 
</script>
<?php endif; ?>
<?php if (Bsoptions('Mermaid') == true): ?>
<style id="mermaid-loading-style">
.mermaid-loading {
    position: relative;
    min-height: 100px;
    background: #f8f9fa;
    border-radius: 4px;
    margin: 1rem 0;
}
.mermaid-loading::before {
    content: "🔄 图表加载中...";
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: 6c757d;
    font-size: 0.9em;
}
@keyframes ripplePulse {
    0% {
        transform: translate(-50%, -50%) scale(0.8);
        opacity: 0.6;
    }
    50% {
        transform: translate(-50%, -50%) scale(1.2);
        opacity: 1;
    }
    100% {
        transform: translate(-50%, -50%) scale(0.8);
        opacity: 0.6;
    }
}
</style>

<script>
(function() {
    var mermaidAsset = '<?php AssetsDir(); ?>assets/vendors/mermaid/mermaid.min.js';
    var isLoaded = false;
    var styleAdded = false;
    function addLoadingState() {
        if (!styleAdded) {
            document.getElementById('mermaid-loading-style').disabled = false;
            styleAdded = true;
        }
        document.querySelectorAll('.mermaid').forEach(el => {
            if (!el.classList.contains('processing')) {
                el.classList.add('mermaid-loading', 'processing');
            }
        });
    }

    function removeLoadingState() {
        document.querySelectorAll('.mermaid.processing').forEach(el => {
            el.classList.remove('mermaid-loading', 'processing');
            el.removeAttribute('aria-live');
            el.removeAttribute('aria-label');
        });
    }
    function initMermaid() {
        try {
            mermaid.init(undefined, document.querySelectorAll('.mermaid'));
            document.dispatchEvent(new CustomEvent('mermaidRendered'));
        } catch(e) {
            console.error('Mermaid initialization failed:', e);
            document.querySelectorAll('.mermaid.processing').forEach(el => {
                el.innerHTML = '<div class="mermaid-error">图表渲染失败，请刷新页面</div>';
            });
        }
    }

    function loadMermaid() {
        if (isLoaded) {
            initMermaid();
            return;
        }
        addLoadingState();
        
        var script = document.createElement('script');
        script.src = mermaidAsset;
        script.onload = function() {
            mermaid.initialize({ 
                startOnLoad: false,
                securityLevel: 'loose'
            });
            initMermaid();
            removeLoadingState();
            isLoaded = true;
        };
        script.onerror = function() {
            removeLoadingState();
            document.querySelectorAll('.mermaid').forEach(el => {
                el.innerHTML = '<div class="mermaid-error">图表库加载失败，请检查网络</div>';
            });
        };
        document.head.appendChild(script);
    }

    function checkMermaid() {
        if (document.querySelector('.mermaid')) {
            loadMermaid();
        } else {
            document.getElementById('mermaid-loading-style').disabled = true;
        }
    }
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', checkMermaid);
    } else {
        setTimeout(checkMermaid, 100);
    }
    <?php if (Bsoptions('Pjax') == true) : ?>
    $(document)
        .on('pjax:send', function() {
            removeLoadingState();
        })
        .on('pjax:complete', function() {
            setTimeout(() => {
                checkMermaid();
                document.addEventListener('mermaidRendered', () => {
                    window.scrollBy(0, 1); 
                });
            }, 200);
        });
    <?php endif; ?>
})();
</script>
<?php endif; ?>

<!-- 引入Pjax -->
<?php if(Bsoptions('Pjax') == true) :?>
<script src="<?php AssetsDir();?>assets/js/jquery.pjax.js"></script>
<?php endif;?>
<script src="<?php AssetsDir();?>assets/js/qrcode.min.js"></script>
<!-- 引入全局控制 -->
<script type="text/javascript" src="<?php AssetsDir();?>assets/vendors/fomantic-ui/semantic.min.js?v=3" defer></script>
<script src="<?php AssetsDir();?>assets/js/funlazy.min.js"></script>
<script type="text/javascript" src="<?php AssetsDir();?>assets/js/app.bundle.min.js?v=<?php echo themeVersion(); ?>" defer></script>
 <?php if(Bsoptions('AIService') == true && Bsoptions('AIService_Key') !== ''): ?> 
<script src="<?php AssetsDir();?>assets/vendors/aiTool/ai.min.js" defer></script>
<?php endif;?>
<script type="module" src="<?php AssetsDir();?>assets/js/emaction.js?v=1" defer></script>
<?php if(Bsoptions('Pjax') == true) :?>
<script>
$(document).on('pjax:complete', function () {
    <?php if(Bsoptions('AIService') == true && Bsoptions('AIService_Key') !== '' && (Bsoptions('AIService_Blacklist') == '' || Bsoptions('AIService_Blacklist_Page') == '')): ?> 
if ($('#post-content').length) {
    tianliGPT(!0);
}
<?php endif;?>
    <?php if((Bsoptions('menu_style') !== "3") && Bsoptions('menu_tem') == "2" || Bsoptions('menu_tem') == ""):?>
    const bearnavbar = new SmartMenus(document.querySelector('#bearnavbar'), {
  dropdownsShowTrigger: 'mouseover',
  dropdownsHideTrigger: 'mouseout',
  dropdownsHideTimeout: '200'
});
<?php if(Bsoptions('AIService') == true && Bsoptions('AIService_Key') !== '' && (Bsoptions('AIService_Blacklist') == '' || Bsoptions('AIService_Blacklist_Page') == '')): ?> 
if ($('#post-content').length) {
$(document).on('pjax:success', function () {
    tianliGPTIsRunning=!1;
});
}
window.history.onpushstate=function(t){tianliGPT(!0)};
<?php endif;?>
    <?php endif;?>
if (document.getElementById('echarts_pie')) EchartsInit();
<?php if(Bsoptions('CustomizationFooterJsPjaxCode')): ?><?php echo Bsoptions('CustomizationFooterJsPjaxCode'); ?><?php endif; ?>
    <?php if(Bsoptions('Scroll') == true): ?>
window.tocManager.displayDisableTocTips = false;
            window.tocManager.generateToc();
             <?php if(Bsoptions('Readmode') == true): ?> 
            window.tocManagerRead.displayDisableTocTips2 = true;
 window.tocManagerRead.generateToc2(); 
  <?php endif; ?>
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
<!-- 微信二维码弹窗 -->
<div id="wechat-popup" class="popup-overlay">
  <div class="popup-card">
    <span class="popup-close">&times;</span>
    <img src="<?php echo Bsoptions('Wechat_QRCODE') ?>" alt="微信二维码" class="popup-qr">
    <p>微信扫码联系我</p>
  </div>
</div>

<!-- QQ二维码弹窗 -->
<div id="qq-popup" class="popup-overlay">
  <div class="popup-card">
    <span class="popup-close">&times;</span>
    <img src="<?php echo Bsoptions('QQ_QRCODE') ?>" alt="QQ二维码" class="popup-qr">
    <p>QQ扫码联系我</p>
  </div>
</div>
</html>
<?php if(Bsoptions('Compress') == true) :?>
<?php $html_source = ob_get_contents();
ob_clean();
print compressHtml($html_source);
ob_end_flush(); ?>
<?php endif; ?>