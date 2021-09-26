<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
        </div>
</div>
<footer id="footer" role="contentinfo" class="break">
   
 <?php if($this->options->CustomizationFooterCode): ?><?php $this->options->CustomizationFooterCode(); ?><br><?php endif; ?>
    &copy; <?php echo date('Y'); ?> <a href="<?php $this->options->siteUrl(); ?>"><?php $this->options->title(); ?></a>.
    <?php _e('由 <a href="http://www.typecho.org">Typecho</a> 强力驱动 | 主题:<a href="https://github.com/whitebearcode/typecho-bearsimple">ʕ•ᴥ•ʔ BearSimple</a>  '); ?>
    <?php if ($this->options->IcpBa || $this->options->PoliceBa): ?><br><?php endif; ?>
     <?php if ($this->options->PoliceBa): ?><img src="<?php AssetsDir();?>assets/image/police.png">公安备案号:<a href="http://www.beian.gov.cn/portal/registerSystemInfo?recordcode=<?php $this->options->PoliceBa(); ?>"><?php $this->options->PoliceBa(); ?></a><?php endif; ?><?php if ($this->options->IcpBa && $this->options->PoliceBa): ?>  | <?php endif; ?><?php if ($this->options->IcpBa): ?><a href="http://beian.miit.gov.cn/publish/query/indexFirst.action"><?php $this->options->IcpBa(); ?></a><?php endif; ?>
</footer>    
</div>
</div>
</div>
<?php if($this->options->Top == '1') :?>
<div class="goTop" id="js-go_top"><img src="<?php if(!empty($this->options->TopSrc)) :?><?php $this->options->TopSrc(); ?><?php else: ?>
<?php AssetsDir();?>assets/images/icon_top.png<?php endif; ?>" alt="回到顶部"></div>
<?php endif; ?>
<?php if($this->options->Compress == '1') :?><nocompress><?php endif; ?>
<script src="<?php AssetsDir();?>assets/js/layer/layer.js"></script>
<?php if($this->options->Slidersss == '1' && $this->options->SliderIndexs == '1' || $this->options->SliderOthers == '1') :?>
<script src="<?php AssetsDir();?>assets/slider/js/swiper.min.js"></script>

<script type='text/javascript'>
var swiper = new Swiper('#swiper', {
    autoplay: {
          delay: 2500,
          disableOnInteraction: false,
        },
    pagination: {
    el: '.swiper-pagination',
    clickable: true,
    },
    navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
    },
});
</script>
<?php endif; ?>
<script>
//赋予div href特性
    clickToHref();
function clickToHref() {
    var eles = document.querySelectorAll("div[href]");
    eles.forEach(function (item) {
        item.addEventListener("click", function () {
            var href = item.getAttribute("href");
            var target = item.getAttribute("target");
            if (!target) {
                location.href = href;
            }
            else {
                window.open(href, target);
            }
        });
    })
};

//赋予span href特性
    clickToHref2();
function clickToHref2() {
    var eles = document.querySelectorAll("span[href]");
    eles.forEach(function (item) {
        item.addEventListener("click", function () {
            var href = item.getAttribute("href");
            var target = item.getAttribute("target");
            if (!target) {
                location.href = href;
            }
            else {
                window.open(href, target);
            }
        });
    })
};
	</script>


<script src="https://cdn.bootcdn.net/ajax/libs/jquery/1.10.2/jquery.min.js"></script>


    <?php if($this->options->hcsticky == '1') :?>
<script src="<?php AssetsDir();?>assets/js/sticky.min.js"></script>
  <script>
var elements = document.querySelectorAll('.sidebar');
Stickyfill.add(elements);
</script>
<?php endif; ?>
<!-- 灯箱 -->
<?php if($this->options->Lightbox == '1') :?>
<script src="https://cdn.bootcdn.net/ajax/libs/viewerjs/1.10.1/viewer.min.js"></script>

<script>
const gallery = new Viewer(document.getElementById('bearsimple-images'));
</script>
<?php endif; ?>
<?php if($this->options->Watermark == '1') :?>
<!-- 图片水印 -->
<script src='<?php AssetsDir();?>assets/js/bearmark.min.js'></script>
<script type="text/javascript">
$(function() {
  $('.bearmark').watermark({
    <?php if($this->options->WatermarkType == '1'||empty($this->options->WatermarkType)) :?>
    textBg:'<?php $this->options->waterMarkTextBackground();?>',
    textColor:'<?php if(empty($this->options->waterMarkTextColor)) :?>white<?php else:?><?php $this->options->waterMarkTextColor();?><?php endif; ?>',
    text: '<?php if(empty($this->options->waterMarkName)) :?><?php $this->options->title();?><?php else:?><?php $this->options->waterMarkName();?><?php endif; ?>',
    textWidth: <?php if(empty($this->options->waterMarkKd)) :?>130<?php else:?><?php $this->options->waterMarkKd();?><?php endif; ?>,
    textSize: <?php if(empty($this->options->waterMarkTextSize)) :?>12<?php else:?><?php $this->options->waterMarkTextSize();?><?php endif; ?>,
    <?php endif; ?>
    <?php if($this->options->WatermarkType == '2') :?>
    path:'<?php $this->options->waterMarkName();?>',
    <?php endif; ?>
    gravity: '<?php if(empty($this->options->waterMarkLocation)) :?>c<?php else:?><?php $this->options->waterMarkLocation();?><?php endif; ?>',
    opacity: <?php if(empty($this->options->waterMarkOpacity)) :?>1<?php else:?><?php $this->options->waterMarkOpacity();?><?php endif; ?>,
    margin: <?php if(empty($this->options->waterMarkMargin)) :?>12<?php else:?><?php $this->options->waterMarkMargin();?><?php endif; ?>,
    <?php if(!empty($this->options->waterMarkOutput) && $this->options->waterMarkOutput !== 'null') :?>
    outputType: '<?php $this->options->waterMarkOutput();?>'
    <?php endif; ?>
  });
});
	</script>

<!-- //// -->
<?php endif; ?>

<?php if($this->options->Popup == '1') :?>
<script>
function setCookie(cname,cvalue,exdays){
	var d = new Date();
	d.setTime(d.getTime()+(exdays*1000));
	var expires = "expires="+d.toGMTString();
	document.cookie = cname+"="+cvalue+"; "+expires;
}
function getCookie(cname){
	var name = cname + "=";
	var ca = document.cookie.split(';');
	for(var i=0; i<ca.length; i++) {
		var c = ca[i].trim();
		if (c.indexOf(name)==0) { return c.substring(name.length,c.length); }
	}
	return "";
}
function checkCookie(){
	var users=getCookie("bear");
	if (users!=""){
	}
	else {
		layer.open({
  type: 1
  ,title: false
  ,closeBtn: false
  ,area: '300px;'
  ,shadeClose: true
  ,shade: 0.8
  ,anim:4
  ,id: 'layanc'
  ,resize: false
  ,btn: ['查看', '取消']
  ,btnAlign: 'c'
  ,moveType: 1
  ,content: '<div style="padding: 50px; line-height: 22px; background-color: #393D49; color: #fff; font-weight: 300;"><?php $this->options->PopupText() ?></div>'
  ,success: function(layero){
    var btn = layero.find('.layui-layer-btn');
    btn.find('.layui-layer-btn0').attr({
      href: '<?php $this->options->PopupUrl() ?>'
      ,target: '_blank'
    });
  }
});
    		setCookie("bear","popup",86400);
	}
}
checkCookie();
</script>
<?php endif; ?>

<?php if($this->options->Top == '1') :?>

<script type="text/javascript" src="<?php AssetsDir();?>assets/js/Top.js"></script>

<script>
    $('#js-go_top').gotoTop({
        offset : 500,
        speed : 300,
        animationShow : {
            'transform' : 'translate(0,0)',
            'transition': 'transform .5s ease-in-out'
        },
        animationHide : {
            'transform' : 'translate(80px,0)',
            'transition': 'transform .5s ease-in-out'
        }
    });
</script>
<?php endif; ?>

<?php if($this->options->Scroll == '1'): ?>
<?php if($this->is('post') || $this->is('page') && strpos($this->content,'h2') !== false): ?>
<script type="text/javascript" src="<?php AssetsDir();?>assets/scroll/scroll.min.js"></script>
<script type="text/javascript" src="<?php AssetsDir();?>assets/scroll/scrollnav.min.js"></script>
<script type='text/javascript'>

var bearsimplescroll = document.querySelector('#bearsimple-scroll');
        var articlenav = document.querySelector('#article-nav');
        scrollnav.init(bearsimplescroll, {
            insertTarget:articlenav,
        });
</script>
<?php endif; ?>
<?php endif; ?>

<script src="https://cdn.bootcdn.net/ajax/libs/semantic-ui/2.4.1/semantic.min.js"></script>
<script>
     
        $('.ui.dropdown').dropdown({
            on: 'hover'
            });
   
    <?php if($this->options->Authorz == '1') :?>

    $('.special.cards .image').dimmer({
  on: 'hover'
});

<?php endif; ?>   
</script>
 <?php if(!empty($this->options->Wechat_QRCODE)) :?>
 <script>
  //微信二维码遮罩层
 $('.wechat.icon.circular.link').on('click', function(){
    layer.open({
      type: 1,
      area: ['360px', '360px'],
      title: '加我微信',
      shadeClose: true, 
      content: '<center><img src="<?php $this->options->Wechat_QRCODE() ?>"></center>'
    });
  });
  </script>
  <?php endif; ?>
  <?php if(!empty($this->options->QQ_QRCODE)) :?>
  <script>
  //QQ二维码遮罩层
  $('.qq.icon.circular.link').on('click', function(){
    layer.open({
      type: 1,
      area: ['360px', '360px'],
      title: '加我QQ',
      shadeClose: true, 
      content: '<center><img src="<?php $this->options->QQ_QRCODE() ?>"></center>'
    });
  });
   </script>
  <?php endif; ?>
<?php if($this->options->Share == '1'): ?>
<script src="<?php AssetsDir();?>assets/share/jquery.share.min.js"></script>
<script>

$('#share').share();
</script>
<?php endif; ?>
<?php if($this->is('post') || $this->is('page')) :?>
<script>
$(function() {
$("body").on('click', 'span',
function() {
    var thisEle = $("#para").css("font-size");
    var textFontSize = parseFloat(thisEle, 10);
    var unit = thisEle.slice( - 2);
    var cName = $(this).attr("size");
    if (cName == "bigger") {
        if (textFontSize <= 22) {
            textFontSize += 2;
        }
    } else if (cName == "smaller") {
        if (textFontSize >= 12) {
            textFontSize -= 2;
        }
    }
    $("#para").css("font-size", textFontSize + unit);
});
});
</script>
<?php endif; ?>
<?php if($this->options->Translate == '1') :?>
<script src="<?php AssetsDir2();?>modules/tw_cn.js"></script>
<script type="text/javascript">
var defaultEncoding = <?php if($this->options->TranslateLanguage() == '1') :?>2<?php else: ?>1<?php endif; ?>;
var translateDelay = 0;
var cookieDomain = "<?php $this->options ->siteUrl(); ?>";
var msgToTraditionalChinese = "繁体";
var msgToSimplifiedChinese = "简体";
var translateButtonId = "translateLink";
translateInitilization();
</script>
<?php endif; ?>


<?php if($this->options->Pjax == '1') :?>
<script src="https://cdn.bootcdn.net/ajax/libs/jquery.pjax/2.0.1/jquery.pjax.min.js"></script>
<script src="<?php AssetsDir();?>assets/js/nprogress.js"></script>

<script>
function getBaseUrl() {
  var ishttps = 'https:' == document.location.protocol ? true : false;
  var url = window.location.host;
  if (ishttps) {
    url = 'https://' + url;
  } else {
    url = 'http://' + url;
  }
  return url;
}
let url = '"'+getBaseUrl()+'"';

var pjax_id = '#pjax';


$(document).pjax('a[target!=_blank][rel!=group]', pjax_id, {fragment:pjax_id, timeout:10000});
$(document).on('pjax:start',function() { NProgress.start(); });
$(document).on('pjax:end',function() { NProgress.done(); 
});


$(document).on('pjax:complete', function () {

<?php $this->need('modules/MakePost/poster_pjax.php'); ?>

//灯箱//
<?php if($this->options->Lightbox == '1') :?>

$.getScript("https://cdn.bootcdn.net/ajax/libs/viewerjs/1.10.1/viewer.min.js");

const gallery = new Viewer(document.getElementById('bearsimple-images'));
 
<?php endif; ?>   
<?php if($this->options->Watermark == '1') :?>
    // 图片水印//
$.getScript("<?php AssetsDir();?>assets/js/bearmark.min.js");

$(function() {
  $('.bearmark').watermark({
    <?php if($this->options->WatermarkType == '1'||empty($this->options->WatermarkType)) :?>
    textBg:'<?php $this->options->waterMarkTextBackground();?>',
    textColor:'<?php if(empty($this->options->waterMarkTextColor)) :?>white<?php else:?><?php $this->options->waterMarkTextColor();?><?php endif; ?>',
    text: '<?php if(empty($this->options->waterMarkName)) :?><?php $this->options->title();?><?php else:?><?php $this->options->waterMarkName();?><?php endif; ?>',
    textWidth: <?php if(empty($this->options->waterMarkKd)) :?>130<?php else:?><?php $this->options->waterMarkKd();?><?php endif; ?>,
    textSize: <?php if(empty($this->options->waterMarkTextSize)) :?>12<?php else:?><?php $this->options->waterMarkTextSize();?><?php endif; ?>,
    <?php endif; ?>
    <?php if($this->options->WatermarkType == '2') :?>
    path:'<?php $this->options->waterMarkName();?>',
    <?php endif; ?>
    gravity: '<?php if(empty($this->options->waterMarkLocation)) :?>c<?php else:?><?php $this->options->waterMarkLocation();?><?php endif; ?>',
    opacity: <?php if(empty($this->options->waterMarkOpacity)) :?>1<?php else:?><?php $this->options->waterMarkOpacity();?><?php endif; ?>,
    margin: <?php if(empty($this->options->waterMarkMargin)) :?>12<?php else:?><?php $this->options->waterMarkMargin();?><?php endif; ?>,
    <?php if(!empty($this->options->waterMarkOutput)&&$this->options->waterMarkOutput !== 'null') :?>
    outputType: '<?php $this->options->waterMarkOutput();?>'
    <?php endif; ?>
  });
});

<!-- //// -->
<?php endif; ?>   

    <?php if($this->options->hcsticky == '1') :?>
    //粘住
$.getScript("<?php AssetsDir();?>assets/js/sticky.min.js");
var elements = document.querySelectorAll('.sidebar');
Stickyfill.add(elements);
<?php endif; ?>
    $(function() {
        $.getScript("https://cdn.jsdelivr.net/gh/whitebearcode/Translate/element.js?cb=googleTranslateElementInit2", function(){
        })
$("body").on('click', 'span',
function() {
    var thisEle = $("#para").css("font-size");
    var textFontSize = parseFloat(thisEle, 10);
    var unit = thisEle.slice( - 2);
    var cName = $(this).attr("size");
    if (cName == "bigger") {
        if (textFontSize <= 22) {
            textFontSize += 2;
        }
    } else if (cName == "smaller") {
        if (textFontSize >= 12) {
            textFontSize -= 2;
        }
    }
    $("#para").css("font-size", textFontSize + unit);
});
});
<?php if($this->options->Top == '1') :?>
    $('#js-go_top').gotoTop({
        offset : 500,
        speed : 300,
        animationShow : {
            'transform' : 'translate(0,0)',
            'transition': 'transform .5s ease-in-out'
        },
        animationHide : {
            'transform' : 'translate(80px,0)',
            'transition': 'transform .5s ease-in-out'
        }
    });
<?php endif; ?>
    <?php if($this->options->Scroll == '1'): ?>
//目录树 pjax
    
    $.getScript("<?php AssetsDir();?>assets/scroll/scroll.min.js");
$.getScript("<?php AssetsDir();?>assets/scroll/scrollnav.min.js", function() {
       var bearsimplescroll = document.querySelector('#bearsimple-scroll');
        var articlenav = document.querySelector('#article-nav');
        scrollnav.init(bearsimplescroll, {
            insertTarget:articlenav,
        });
});

<?php endif; ?>
        
    <?php if($this->options->Slidersss == '1' && $this->options->SliderIndexs == '1' || $this->options->SliderOthers == '1') :?>
    //幻灯片
    var swiper = new Swiper('#swiper', {
    autoplay: {
          delay: 2500,
          disableOnInteraction: false,
        },
    pagination: {
    el: '.swiper-pagination',
    clickable: true,
    },
    navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
    },
});
<?php endif; ?>
    //下拉导航 pjax
 $.getScript("//cdn.bootcdn.net/ajax/libs/semantic-ui/2.4.1/semantic.min.js", function() {
        $('.ui.dropdown').dropdown({
            on: 'hover'
            });
});
<?php if($this->options->Authorz == '1') :?>
$.getScript("//cdn.bootcdn.net/ajax/libs/semantic-ui/2.4.1/semantic.min.js", function() {
    $('.special.cards .image').dimmer({
  on: 'hover'
});
});
<?php endif; ?>
<?php if($this->options->Codehightlight == '1') :?>
if (typeof Prism !== 'undefined') {
        var pres = document.getElementsByTagName('pre'); for (var i = 0; i < pres.length; i++) { if (pres[i].getElementsByTagName('code').length > 0) pres[i].className  = '<?php if($this->options->showLineNumber == '1') :?>line-numbers<?php endif; ?>language-php';document.getElementsByTagName('code').className  = 'language-php'; }
        Prism.highlightAll(true,null);
    }
<?php endif; ?>

    <?php if($this->options->isNeedMermaid == '1') :?>
     $.getScript("//cdn.jsdelivr.net/npm/mermaid@8/dist/mermaid.min.js", function() {
        (function(){mermaid.initialize({startOnLoad:true})})();
    });
    <?php endif; ?>
    <?php if($this->options->is_available_mathjax == '1') :?>
     $.getScript("//cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.min.js", function() {
    (function(){MathJax={tex:{inlineMath:[['$','$'],['(',')']]}}})();
    });
    <?php endif; ?>

//赋予div href特性
    clickToHref();
function clickToHref() {
    var eles = document.querySelectorAll("div[href]");
    eles.forEach(function (item) {
        item.addEventListener("click", function () {
            var href = item.getAttribute("href");
            var target = item.getAttribute("target");
            if (!target) {
                location.href = href;
            }
            else {
                window.open(href, target);
            }
        });
    })
};
//赋予span href特性
    clickToHref2();
function clickToHref2() {
    var eles = document.querySelectorAll("span[href]");
    eles.forEach(function (item) {
        item.addEventListener("click", function () {
            var href = item.getAttribute("href");
            var target = item.getAttribute("target");
            if (!target) {
                location.href = href;
            }
            else {
                window.open(href, target);
            }
        });
    })
};

<?php if($this->options->Translate == '1') :?>

//切换语言 pjax
var defaultEncoding = <?php if($this->options->TranslateLanguage() == '1') :?>2<?php else: ?>1<?php endif; ?>;
var translateDelay = 0;
var cookieDomain = "<?php $this->options ->siteUrl(); ?>";
var msgToTraditionalChinese = "繁体";
var msgToSimplifiedChinese = "简体";
var translateButtonId = "translateLink";
translateInitilization();
<?php endif; ?>

    <?php if($this->options->Wechat_QRCODE !== null) :?>
  //微信二维码遮罩层
 $('.wechat.icon.circular.link').on('click', function(){
    layer.open({
      type: 1,
      area: ['360px', '360px'],
      title: '加我微信',
      shadeClose: true, 
      content: '<center><img src="<?php $this->options->Wechat_QRCODE() ?>"></center>'
    });
  });
  <?php endif; ?>
  <?php if($this->options->QQ_QRCODE !== null) :?>
  //QQ二维码遮罩层
  $('.qq.icon.circular.link').on('click', function(){
    layer.open({
      type: 1,
      area: ['360px', '360px'],
      title: '加我QQ',
      shadeClose: true, 
      content: '<center><img src="<?php $this->options->QQ_QRCODE() ?>"></center>'
    });
  });
  <?php endif; ?>
  <?php if($this->options->Share == '1'): ?>


$.getScript("<?php AssetsDir();?>assets/share/jquery.share.min.js", function() {
        $('#share').share();
});
 <?php endif;?>
});

if(typeof lazyload === "function") {
  $(document).on('pjax:complete', function () {
 
    jQuery(function() {
      jQuery("div").lazyload({effect: "fadeIn"});
    });
    jQuery(function() {
      jQuery("img").lazyload({effect: "fadeIn"});
    });
    

  });
}else{
  console.log('BearSimple lazyload finished');
}
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