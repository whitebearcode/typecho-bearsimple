<?php

class BearsimpleUserAgent
{
    public static function render($agent,$ctype = 'time')
    {
        $options = Typecho_Widget::widget('Widget_Options');
        global $url_img;
        $url_img = "//deliver.application.pub/gh/whitebearcode/UserAgent/img";

        require_once dirname(__FILE__).'/useragent-os.php';
        $os = detect_os($agent);
        $os_img = self::img($os['code'],"/os/",$os['title'],$ctype);
        $os_title = $os['title'];

        require_once dirname(__FILE__).'/useragent-webbrowser.php';
        $wb = detect_webbrowser($agent);
        $wb_img = self::img($wb['code'],"/net/",$wb['title'],$ctype);
        $wb_title = $wb['title'];

                $ua = $os_img."&nbsp;".$wb_img;

        echo $ua;
    }

    public static function img($code, $type, $title,$ctype)
    {
        global $url_img;
        if($code == ''){
            $code = 'android';
        }
        elseif($code == 'U'){
            $code = 'chrome';
        }
       if($ctype == 'comment'){
        $img = "<img style='vertical-align: middle;' src='" . $url_img  . $type . $code . ".png' title='" . $title . "' alt='" . $title . "' height='14' width='14' />";
}
else{
    $img = "<img src='" . $url_img  . $type . $code . ".png' title='" . $title . "' alt='" . $title . "' height='18' width='18' />";
}
        return $img;
    }
}