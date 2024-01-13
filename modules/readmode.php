<script>
$(document).ready(function(){
        var is_mobi = navigator.userAgent.toLowerCase().match(/(ipod|ipad|iphone|android|coolpad|mmp|smartphone|midp|wap|xoom|symbian|j2me|blackberry|wince)/i) != null;

   $("#read").click(function(event){
       <?php if($this->hidden): ?>
       $('body')
							.toast({
							    title:'抱歉~',
							    class: 'warning',
							    message: '<?php echo empty(Bsoptions('globalTips')['articlePwdAfterEnterReadMode_Tip'])? '本文存在密码，验证文章密码后方可进入阅读模式' : Bsoptions('globalTips')['articlePwdAfterEnterReadMode_Tip'];?>', 
							    showIcon: 'flushed outline',
							    showProgress: 'top',
							});
       return false;
       <?php endif; ?>
       $("#header").hide();
       $("#footer").hide();
       $("#sidebar").hide();
       $("#comments__module").hide();
       $(".content_container").hide();
       $('#read__mode').css({ position:"absolute" , top:+9999, left:+9999});
       $('#read__mode').css("position","static");
       $('#read__mode').show();
       $("#read__mode").fadeIn("1500");
       $(".bs_body2").fadeIn("1500");
       $("body").addClass("readmode_body");
        $("#body_container").addClass("readmode_container");
        $("#body_container").css("background-color", "#e0d8c8");
        //if (!is_mobi) {
        $("#body_container").css("margin-top", "2em");    
        //}
        $("#article-nav").hide();  
        <?php if(Bsoptions('Pjax') == true) :?>
        history.pushState($.pjax.state,'',"<?php echo $this->permalink; ?>"+'#readmode');
        <?php else:?>
        history.pushState(location.href,'',"<?php echo $this->permalink; ?>"+'#readmode');
        <?php endif;?>
   });
    $("#read__mode__close__btn").click(function(event){
         $("#header").fadeIn();
       $("#footer").fadeIn();
       $("#sidebar").fadeIn();
       $("#comments__module").fadeIn();
       $(".content_container").fadeIn();
    $("#read__mode").hide();
    $("#article-nav").fadeIn();
     $("body").removeClass("readmode_body");
        $("#body_container").removeClass("readmode_container");
        $("#body_container").removeAttr("style","");
    $("html, body").animate({
      scrollTop: $("#header").offset().top 
    }, {duration: 500,easing: "swing"});
    <?php if(Bsoptions('Pjax') == true) :?>
        history.pushState($.pjax.state,'',"<?php echo $this->permalink; ?>");
        <?php else:?>
        history.pushState(location.href,'',"<?php echo $this->permalink; ?>");
        <?php endif;?>
    });
});
    $(window).bind('popstate',function(event) {
        var link = "<?php echo $this->permalink; ?>";
        if(location.href == link){
    $("#header").fadeIn();
       $("#footer").fadeIn();
       $("#sidebar").fadeIn();
       $("#comments__module").fadeIn();
       $(".content_container").fadeIn();
    $("#read__mode").hide();
    $("#article-nav").fadeIn();
     $("body").removeClass("readmode_body");
        $("#body_container").removeClass("readmode_container");
        $("#body_container").removeAttr("style","");
        }
    });
    <?php if(!$this->hidden && $this->is('post') && Bsoptions('Readmode_Auto') == true): ?>
    $(document).ready(function(){
    $("#read").click();
    });
    <?php endif; ?>
    </script>