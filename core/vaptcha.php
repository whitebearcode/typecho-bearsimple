<?php
//行为验证处理->
$options = Helper::options();
if ($options->VerifyChoose == '2'){
// 添加VAPTCHA所需css
        Typecho_Plugin::factory('Widget_Archive')->header = array('VAPTCHA_BearSimple', 'header');
// 添加VAPTCHA所需js
        Typecho_Plugin::factory('Widget_Archive')->footer = array('VAPTCHA_BearSimple', 'footer');
class VAPTCHA_BearSimple
{
     /* 头部插入css */
    public static function header(){
        $VAPTCHA_style = "
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
        ";
        echo $VAPTCHA_style;
    }

    /*  尾部加入js */
    public static function footer(){
        $options = Typecho_Widget::widget('Widget_Options');
      
        $vaptcha_js = "
            <script src=\"https://v.vaptcha.com/v3.js\"></script>
            <script>
                document.getElementById(\"bearsimple_verify\").setAttribute(\"disabled\", true);
                vaptcha({
                    vid: '".$options->vid."', // 验证单元id
                    type: 'click', // 显示类型 点击式
                    container: '.vaptcha-container' // 按钮容器，可为Element 或者 selector
                }).then(function (vaptchaObj) {
                    vaptchaObj.listen('pass', function() {
                        document.getElementById(\"bearsimple_verify\").removeAttribute(\"disabled\");
                    })
                    vaptchaObj.render()
                })
            </script>
        ";
     
        
        echo $vaptcha_js;
    } 
}


}
