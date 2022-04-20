<style>
                .vaptcha-container {
                    width: 100%;
                    height: 36px;
                    line-height: 36px;
                    text-align: center;
                }
                .vaptcha-init-main {
                    display: table;
                    width: 100%;
                    height: 100%;
                    background-color: #EEEEEE;
                }
               .vaptcha-init-loading {
                    display: table-cell;
                    vertical-align: middle;
                    text-align: center
                }
               .vaptcha-init-loading>a {
                    display: inline-block;
                    width: 18px;
                    height: 18px;
                    border: none;
                }
               .vaptcha-init-loading>a img {
                    vertical-align: middle
                }
               .vaptcha-init-loading .vaptcha-text {
                    font-family: sans-serif;
                    font-size: 12px;
                    color: #CCCCCC;
                    vertical-align: middle
                }
            </style>
            <script>
                $.getScript('https://v-cn.vaptcha.com/v3.js',function(){
                vaptcha({
                    vid: '<?php echo $this->options->vid; ?>', // 验证单元id
                    type: 'click', // 显示类型 点击式
                    container: '.vaptcha-container' // 按钮容器，可为Element 或者 selector
                }).then(function (vaptchaObj) {
                    vaptchaObj.listen('pass', function() {
                        document.getElementById("bearsimple_verify").removeAttribute("disabled");
                    })
                    vaptchaObj.render()
                   
                })
                });
     $(document).on('pjax:complete', function() {  
                $.getScript('https://v-cn.vaptcha.com/v3.js',function(){
                vaptcha({
                    vid: '<?php echo $this->options->vid; ?>', // 验证单元id
                    type: 'click', // 显示类型 点击式
                    container: '.vaptcha-container' // 按钮容器，可为Element 或者 selector
                }).then(function (vaptchaObj) {
                    vaptchaObj.listen('pass', function() {
                        document.getElementById("bearsimple_verify").removeAttribute("disabled");
                    })
                    vaptchaObj.render()
                   
                })
                })
    }) 
     $(document).on("ready pjax:end", function() {
                $.getScript('https://v-cn.vaptcha.com/v3.js',function(){
                vaptcha({
                    vid: '<?php echo $this->options->vid; ?>', // 验证单元id
                    type: 'click', // 显示类型 点击式
                    container: '.vaptcha-container' // 按钮容器，可为Element 或者 selector
                }).then(function (vaptchaObj) {
                    vaptchaObj.listen('pass', function() {
                        document.getElementById("bearsimple_verify").removeAttribute("disabled");
                    })
                    vaptchaObj.render()
                   
                })
                })
    }) 
     $(window).bind('popstate',function(event) {  
                $.getScript('https://v-cn.vaptcha.com/v3.js',function(){
                vaptcha({
                    vid: '<?php echo $this->options->vid; ?>', // 验证单元id
                    type: 'click', // 显示类型 点击式
                    container: '.vaptcha-container' // 按钮容器，可为Element 或者 selector
                }).then(function (vaptchaObj) {
                    vaptchaObj.listen('pass', function() {
                        document.getElementById("bearsimple_verify").removeAttribute("disabled");
                    })
                    vaptchaObj.render()
                   
                })
                })
    }) 
            </script>