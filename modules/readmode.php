<script>

//阅读模式
$(document).ready(function(){
        var is_mobi = navigator.userAgent.toLowerCase().match(/(ipod|ipad|iphone|android|coolpad|mmp|smartphone|midp|wap|xoom|symbian|j2me|blackberry|wince)/i) != null;

   $("#read").click(function(event){
       <?php if($this->hidden): ?>
       $('body')
							.toast({
							    title:'抱歉~',
							    class: 'warning',
							    message: '本文存在密码，验证文章密码后方可进入阅读模式', 
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
       $("#read__mode").fadeIn("1500");
       $(".bs_body2").fadeIn("1500");
       $("body").addClass("readmode_body");
        $("#body_container").addClass("readmode_container");
        $("#body_container").css("background-color", "#F8F1E1");
        if (is_mobi) {
        }
        else{
        $("#body_container").css("margin-top", "2em");    
        }
        $("#article-nav").hide();  
        $("html, body").animate({
      scrollTop: $("#read__mode").offset().top 
    }, {duration: 500,easing: "swing"});
        history.pushState($.pjax.state,'',"<?php echo $this->permalink; ?>"+'#readmode');
        
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
        $("html, body").animate({
      scrollTop: $("#header").offset().top 
        }, {duration: 500,easing: "swing"});
        }
    });
    <?php if(!$this->hidden && $this->is('post') && Bsoptions('Readmode_Auto') == true): ?>
    $(document).ready(function(){
    $("#read").click();
    });
    <?php endif; ?>
    </script>