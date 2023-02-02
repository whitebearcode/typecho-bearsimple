<div style="height:5px"></div><div data-theme="<?php echo Bsoptions('turnstile_theme'); ?>" data-size="<?php echo Bsoptions('turnstile_style'); ?>" id="turnstile_captcha"></div>
<script>
if($('#turnstile_captcha').length){
$.getScript('https://challenges.cloudflare.com/turnstile/v0/api.js?onload=onloadTurnstileCallback',function(){
   window.onloadTurnstileCallback = function () {
    turnstile.render('#turnstile_captcha', {
        sitekey: '<?php echo Bsoptions('turnstile_key'); ?>',
        callback: function(token) {
            document.getElementById("commentsubmit").removeAttribute("disabled");
        },
    });
};
});
}

  $(document).on('pjax:complete', function() {  
     if($('#turnstile_captcha').length){
$.getScript('https://challenges.cloudflare.com/turnstile/v0/api.js?onload=onloadTurnstileCallback',function(){
   window.onloadTurnstileCallback = function () {
    turnstile.render('#turnstile_captcha', {
        sitekey: '<?php echo Bsoptions('turnstile_key'); ?>',
        callback: function(token) {
            document.getElementById("commentsubmit").removeAttribute("disabled");
        },
    });
};
});
}
    });

     $(window).bind('popstate',function(event) {  
        if($('#turnstile_captcha').length){
$.getScript('https://challenges.cloudflare.com/turnstile/v0/api.js?onload=onloadTurnstileCallback',function(){
   window.onloadTurnstileCallback = function () {
    turnstile.render('#turnstile_captcha', {
        sitekey: '<?php echo Bsoptions('turnstile_key'); ?>',
        callback: function(token) {
            document.getElementById("commentsubmit").removeAttribute("disabled");
        },
    });
};
});
}
    }); 
</script>