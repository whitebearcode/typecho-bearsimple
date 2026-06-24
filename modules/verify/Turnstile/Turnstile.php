<div style="height:5px"></div>
<script src="https://challenges.cloudflare.com/turnstile/v0/api.js?onload=onloadTurnstileCallback" async defer></script>
            <script id="turnstile-script">
            window.onloadTurnstileCallback=function(){eval(function(p,a,c,k,e,r){e=String;if('0'.replace(0,e)==0){while(c--)r[e(c)]=k[c];k=[function(e){return r[e]||e}];e=function(){return'[1-4]'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\\\b'+e(c)+'\\\\b','g'),k[c]);return p});turnstile.render('#turnstile_captcha',{sitekey:'<?php echo Bsoptions('turnstile_key'); ?>',theme:'<?php echo Bsoptions('turnstile_theme'); ?>',action:'comment',callback:function(token){document.getElementById("commentsubmit").removeAttribute("disabled");},})};
            </script>
            <div id="turnstile_captcha"></div>
