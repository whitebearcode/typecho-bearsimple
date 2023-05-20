<?php

class BearsimpleUserAgent
{
   
    public static function render($agent,$ctype = 'time')
    {
    $options = bsOptions::getInstance()::get_option( 'bearsimple' );
    global $imgurl;
    $imgurl = AssetsDir_Backend().'assets/images/UserAgent/';
         
    require_once dirname(__FILE__).'/get_os.php';
    $ua_os = get_os($agent);
    $ua_os_img = self::img("/os/", $ua_os['code'], $ua_os['title'],$ctype);
    require_once dirname(__FILE__).'/get_browser.php';
    $ua_browser = get_browser_name($agent);
    $ua_browser_img = self::img("/browser/", $ua_browser['code'], $ua_browser['title'],$ctype);

    $ua =  "&nbsp;" . $ua_os_img . "&nbsp;" . $ua_browser_img;
   
        echo $ua;
    }
 public static function img($code, $type, $title,$ctype)
    {
        global $imgurl;
        if(empty($code)){
            $code = 'android';
        }
        if($code == 'U'){
            $code = 'chrome';
        }
       if($ctype == 'comment'){
        $img = "<img style='vertical-align: middle;' src='" . $imgurl.$code.$type .  ".svg' height='15' width='15' />";
}
else{
    $img = "<img style='vertical-align: middle;' src='" . $imgurl.$code.$type .  ".svg'  alt='" . $title . "' height='15' width='15' />";
}
        return $img;
    }
    
}