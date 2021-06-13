<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
        </div>
    </div>
</div>


<footer id="footer" role="contentinfo">
   
 <?php $this->options->CustomizationFooterCode(); ?><br>
    &copy; <?php echo date('Y'); ?> <a href="<?php $this->options->siteUrl(); ?>"><?php $this->options->title(); ?></a>.
    <?php _e('由 <a href="http://www.typecho.org">Typecho</a> 强力驱动'); ?>.  <br>
     <?php if ($this->options->PoliceBa): ?><img src="/usr/themes/bearsimple/assets/image/police.png">公安备案号:<a href="http://www.beian.gov.cn/portal/registerSystemInfo?recordcode=<?php $this->options->PoliceBa(); ?>"><?php $this->options->PoliceBa(); ?></a><?php endif; ?><?php if ($this->options->IcpBa && $this->options->PoliceBa): ?>  | <?php endif; ?><?php if ($this->options->IcpBa): ?><a href="http://beian.miit.gov.cn/publish/query/indexFirst.action"><?php $this->options->IcpBa(); ?></a><?php endif; ?>
</footer>
<?php if($this->options->Top == '1') :?>
<div style="display:none;" id="rocket-to-top">

	<div style="opacity:0;display:block;" class="level-2"></div>

	<div class="level-3"></div>

</div>

<?php endif; ?>


<?php if($this->options->Compress == '1') :?><nocompress><?php endif; ?>
<?php if($this->options->Lightbox == '1') :?>
<script src="/usr/themes/bearsimple/assets/js/lightbox-plus-jquery.min.js"></script>
<?php endif; ?>

<script src="/usr/themes/bearsimple/assets/js/layer/layer.js"></script>
    <script>
		$(function(){
        $('.ui.dropdown').dropdown({
            on: 'hover'
            });
    });
    $(function(){
    $('.special.cards .image').dimmer({
  on: 'hover'
});
});
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
}
	</script>



<script src="/usr/themes/bearsimple/assets/js/jquery.min.js"></script>

<script src="https://cdn.bootcdn.net/ajax/libs/semantic-ui/2.4.1/semantic.min.js"></script>

<script src="/usr/themes/bearsimple/assets/share/js/jquery.share.min.js"></script>



<script>

 <?php if(!empty($this->options->Wechat_QRCODE)) :?>
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
  <?php if(!empty($this->options->QQ_QRCODE)) :?>
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
</script>

<script>
$('#share').share();

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

<?php if($this->options->Translate == '1') :?>
<script src="/usr/themes/bearsimple/modules/tw_cn.js"></script>
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
<script src="/usr/themes/bearsimple/assets/js/jquery.pjax.min.js"></script>
<script src="/usr/themes/bearsimple/assets/js/nprogress.js"></script>


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
$(document).pjax('a[target!=_blank][rel!=group]', pjax_id, {fragment:pjax_id, timeout:6000});
$(document).on('pjax:start',function() { NProgress.start(); });
$(document).on('pjax:end',function() { NProgress.done(); 
$(document).pjax('li', '#pjax-container')

//i

});

    
$(document).on('pjax:complete', function () {
    <?php if($this->options->Codehightlight == '1') :?>
if (typeof Prism !== 'undefined') {
        //为了方便将默认语言设为php
        var pres = document.getElementsByTagName('pre'); for (var i = 0; i < pres.length; i++) { if (pres[i].getElementsByTagName('code').length > 0) pres[i].className  = 'line-numbers language-php';document.getElementsByTagName('code').className  = 'language-php'; }
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
//下拉导航 pjax
$(function(){
        $('.ui.dropdown').dropdown({
            on: 'hover'
            });
        
    });
    $(function(){
    $('.special.cards .image').dimmer({
  on: 'hover'
});
});
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
}

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
if(document.getElementById("comments")) {
    $.getScript('/usr/themes/bearsimple/assets/owo/OwO.min.js');
}
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
$('#share').share();

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
</div>
<?php endif; ?>

<?php if($this->options->Compress == '1') :?>
<?php $html_source = ob_get_contents(); ob_clean(); print compressHtml($html_source); ob_end_flush(); ?><?php endif; ?>

<?php if($this->options->CommentTyping == '1') :?>
<script type="text/javascript" src="/usr/themes/bearsimple/assets/js/commentTyping.js"></script>
<?php endif; ?>

<?php $this->footer(); ?>

<?php if($this->options->Compress == '1') :?></nocompress><?php endif; ?>
</body>
</html>
