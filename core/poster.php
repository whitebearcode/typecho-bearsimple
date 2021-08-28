<?php
if($options->Poster == '1'){
Typecho_Plugin::factory('Widget_Archive')->header = array('ArticlePoster', 'header');
        Typecho_Plugin::factory('Widget_Archive')->footer = array('ArticlePoster', 'footer');
class ArticlePoster{
     /* 按钮 */
    public static function button($cid){
    	$options = Helper::options();
    	echo '<!-- ArticlePoster -->';
        echo '<button class="article-poster-button ui mini gray icon button">下载海报</button>';
        echo '<div data-id="'.$cid.'" class="article-poster action action-poster"><div class="poster-popover-mask" data-event="poster-close"></div><div class="poster-popover-box"><a class="poster-download" data-event="poster-download" data-url="">下载海报</a><img class="article-poster-images"/></div></div>';
    }
    
    /* 顶部 */
    public static function header(){
    	echo '<link rel="stylesheet" href="'.Helper::options()->themeUrl.'/modules/MakePost/css/core.css">';
    }
    
    /* 底部 */
    public static function footer(){
       echo '<script src="'.Helper::options()->themeUrl.'/modules/MakePost/js/core.js"></script>';
    }
}
    
}