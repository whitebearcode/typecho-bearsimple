<?php
//代码高亮->
if ($options->Codehightlight == '1'){
    Typecho_Plugin::factory('Widget_Archive')->header = array('Prism_Plugin', 'headlink');
        Typecho_Plugin::factory('Widget_Archive')->footer = array('Prism_Plugin', 'footlink');
class Prism_Plugin{
     /**
     *为header添加css文件
     *@return void
     */
    public static function headlink($cssUrl) {
        
        $options = Helper::options();
    
        $dir = $options->themeUrl.'/';
   
    
        $style = Helper::options()->code_style;
        if(empty($style)){
            $style = 'coy.css';
        }
        else{
       $style = Helper::options()->code_style;
        }
        $cssUrl = $dir.'modules/codehightlight/static/styles/' . $style;
        echo '<link rel="stylesheet" type="text/css" href="' . $cssUrl . '" />';
    }

    /**
     * 底部脚本
     *
     * @access public
     * @param unknown $footlink
     * @return unknown
     */
    public static function footlink($links) {
      $options = Helper::options();
        $dir = $options->themeUrl.'/';
  
    
         $jsUrl = $dir.'modules/codehightlight/static/prism.js';
        $jsUrl_clipboard = $dir.'modules/codehightlight/static/clipboard.min.js';
        $showLineNumber = Helper::options()->showLineNumber;
        if ($showLineNumber) {
            echo <<<HTML
<script type="text/javascript">
	(function(){
		var pres = document.querySelectorAll('pre');
		var lineNumberClassName = 'line-numbers';
		pres.forEach(function (item, index) {
			item.className = item.className == '' ? lineNumberClassName : item.className + ' ' + lineNumberClassName;
		});
	})();
</script>

HTML;
        }
        echo <<<HTML
<script type="text/javascript" src="{$jsUrl_clipboard}"></script>
<script type="text/javascript" src="{$jsUrl}"></script>

HTML;
    }
}
}
