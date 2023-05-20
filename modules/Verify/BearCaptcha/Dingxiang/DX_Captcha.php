<div style="height:5px"></div><div id="dx_captcha"></div>
<script>
if($('#dx_captcha').length){
$.getScript('https://cdn.dingxiang-inc.com/ctu-group/captcha-ui/index.js',function(){
    var myCaptcha = _dx.Captcha(document.getElementById('dx_captcha'), {
    appId: '<?php echo Bsoptions('dx_appId'); ?>',
    apiServer: 'https://<?php echo Bsoptions('dx_domain'); ?>',
    success: function (token) {
        let tokeninput = $("<input type='text' name='dx_token' style='display:none'/>");
        tokeninput.attr("value",token);
        $("#textarea").append(tokeninput);
      document.getElementById("commentsubmit").removeAttribute("disabled");
    }
    })
});
}
  $(document).on('pjax:complete', function() {  
      if($('#dx_captcha').length){
      $.getScript('https://cdn.dingxiang-inc.com/ctu-group/captcha-ui/index.js',function(){
          var myCaptcha = _dx.Captcha(document.getElementById('dx_captcha'), {
    appId: '<?php echo Bsoptions('dx_appId'); ?>',
    apiServer: 'https://<?php echo Bsoptions('dx_domain'); ?>',
    success: function (token) {
        let tokeninput = $("<input type='text' name='dx_token' style='display:none'/>");
        tokeninput.attr("value",token);
        $("#textarea").append(tokeninput);
      document.getElementById("commentsubmit").removeAttribute("disabled");
    }
})
      })  
      }
    });

     $(window).bind('popstate',function(event) {  
         if($('#dx_captcha').length){
         $.getScript('https://cdn.dingxiang-inc.com/ctu-group/captcha-ui/index.js',function(){
                 var myCaptcha = _dx.Captcha(document.getElementById('dx_captcha'), {
    appId: '<?php echo Bsoptions('dx_appId'); ?>',
    apiServer: 'https://<?php echo Bsoptions('dx_domain'); ?>',
    success: function (token) {
        let tokeninput = $("<input type='text' name='dx_token' style='display:none'/>");
        tokeninput.attr("value",token);
        $("#textarea").append(tokeninput);
      document.getElementById("commentsubmit").removeAttribute("disabled");
    }
})
})
}
    }); 
</script>