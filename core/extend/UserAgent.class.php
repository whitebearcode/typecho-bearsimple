<?php

class BearsimpleUserAgent
{
   
    public static function render($agent,$ctype = 'time')
    {
    $options = bsOptions::getInstance()::get_option( 'bearsimple' );
    global $imgurl;
    global $agents;
    $agents = $agent;
    $imgurl = Helper::options()->themeUrl.'/assets/images/UserAgent';
         
    require_once dirname(__FILE__).'/get_os.php';
    $ua_os = get_os($agent);
    $ua_os_img = self::img("/os/", $ua_os['code'], $ua_os['title'],$ctype);
    require_once dirname(__FILE__).'/get_browser.php';
    $ua_browser = get_browser_name($agent);
    $ua_browser_img = self::img("/browser/", $ua_browser['code'], $ua_browser['title'],$ctype);
if($agents == 'weixin'){
    $ua =  $ua_os_img;
}
else{
    $ua =  "&nbsp;" . $ua_os_img . "&nbsp;" . $ua_browser_img;
}
        echo $ua;
    }
 public static function img($code, $type, $title,$ctype)
    {
        global $imgurl;
        global $agents;
        if(empty($code)){
            $code = 'android';
        }
        if($code == 'U'){
            $code = 'chrome';
        }
       if($ctype == 'comment'){
           if($agents == 'weixin'){
          $img = '<i class="weixin green icon"></i>';     
           }
           else{
        $img = "<img style='vertical-align: middle;' src='" . $imgurl.$code.$type .  ".svg' height='15' width='15' />";
           }
}
else{
    if($agents == 'weixin'){
        $img = '<i class="weixin green icon"></i> <small>发自微信公众号</small>';      
           }
           else{
    $img = "<img style='vertical-align: middle;' src='" . $imgurl.$code.$type .  ".svg'  alt='" . $title . "' height='15' width='15' />";
           }
}
        return $img;
    }
    
}