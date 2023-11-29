<style>
                .VAPTCHA-init-main {
            display: table;
            width: 100%;
            height: 100%;
            background-color: #eeeeee;
            
        }

        .VAPTCHA-init-loading {
            display: table-cell;
            vertical-align: middle;
            text-align: center;
          
        }

        .VAPTCHA-init-loading>a {
            display: inline-block;
            width: 18px;
            height: 18px;
            border: none;
            
        }

        .VAPTCHA-init-loading .VAPTCHA-text {
            font-family: sans-serif;
            font-size: 12px;
            color: #cccccc;
            vertical-align: middle;
            
        }
            </style><div style="height:5px"></div>
            <div id="VAPTCHAContainers" style="width: 300px;height: 36px;">
        <div class="VAPTCHA-init-main">
            <div class="VAPTCHA-init-loading">
                <a href="/" target="_blank">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="48px"
                        height="60px" viewBox="0 0 24 30"
                        style="enable-background: new 0 0 50 50; width: 14px; height: 14px; vertical-align: middle"
                        xml:space="preserve">
                        <rect x="0" y="9.22656" width="4" height="12.5469" fill="#CCCCCC">
                            <animate attributeName="height" attributeType="XML" values="5;21;5" begin="0s" dur="0.6s"
                                repeatCount="indefinite"></animate>
                            <animate attributeName="y" attributeType="XML" values="13; 5; 13" begin="0s" dur="0.6s"
                                repeatCount="indefinite"></animate>
                        </rect>
                        <rect x="10" y="5.22656" width="4" height="20.5469" fill="#CCCCCC">
                            <animate attributeName="height" attributeType="XML" values="5;21;5" begin="0.15s" dur="0.6s"
                                repeatCount="indefinite"></animate>
                            <animate attributeName="y" attributeType="XML" values="13; 5; 13" begin="0.15s" dur="0.6s"
                                repeatCount="indefinite"></animate>
                        </rect>
                        <rect x="20" y="8.77344" width="4" height="13.4531" fill="#CCCCCC">
                            <animate attributeName="height" attributeType="XML" values="5;21;5" begin="0.3s" dur="0.6s"
                                repeatCount="indefinite"></animate>
                            <animate attributeName="y" attributeType="XML" values="13; 5; 13" begin="0.3s" dur="0.6s"
                                repeatCount="indefinite"></animate>
                        </rect>
                    </svg>
                </a>
                <span class="VAPTCHA-text">Vaptcha 初始化中...</span>
            </div>
        </div>
    </div>
            <script>
            if($('#VAPTCHAContainers').length){
                $.getScript('//v-cn.vaptcha.com/v3.js',function(){
                vaptcha({
            vid: '<?php echo Bsoptions('vid'); ?>',
            mode: 'click',
            scene: 1,
            container: '#VAPTCHAContainers',
            area: 'auto',
        }).then(function (VAPTCHAObj) {
            obj = VAPTCHAObj;
            VAPTCHAObj.render();
            VAPTCHAObj.renderTokenInput('#friendform');
            VAPTCHAObj.listen('pass', function () {
                $('#friendbtn').css("pointer-events","auto");


            })
      
        })
                });
            };
    
        $(document).on('pjax:complete', function() {  
         if($('#VAPTCHAContainers').length){
         $.getScript('https://v-cn.vaptcha.com/v3.js',function(){
                vaptcha({
            vid: '<?php echo Bsoptions('vid'); ?>',
            mode: 'click',
            scene: 1,
            container: '#VAPTCHAContainers',
            area: 'auto',
        }).then(function (VAPTCHAObj) {
             obj = VAPTCHAObj;
VAPTCHAObj.renderTokenInput('#friendform');
            VAPTCHAObj.render();

            VAPTCHAObj.listen('pass', function () {
                $('#friendbtn').css("pointer-events","auto");
            })
        })
         })
         
         }
         
    });

     $(window).bind('popstate',function(event) {  
                $.getScript('https://v-cn.vaptcha.com/v3.js',function(){
                vaptcha({
            vid: '<?php echo Bsoptions('vid'); ?>',
            mode: 'click',
            scene: 1,
            container: '#VAPTCHAContainers',
            area: 'auto',
        }).then(function (VAPTCHAObj) {
            obj = VAPTCHAObj;
            VAPTCHAObj.renderTokenInput('#friendform');
            VAPTCHAObj.render();
            VAPTCHAObj.listen('pass', function () {
                $('#friendbtn').css("pointer-events","auto");
            })
        })
                })
    }); 
            </script>