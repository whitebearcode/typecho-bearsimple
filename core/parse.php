<?php

function ShortCode($post,$t,$login){
    $options = Helper::options();
    $content = $post;
    //回复可见
    if (strpos($content, '{bs-hide') !== false) {
        $db = Typecho_Db::get();
        $hasComment = $db->fetchAll($db->select()->from('table.comments')->where('cid = ?', $t->cid)->where('mail = ?', $t->remember('mail', true))->limit(1));

        if ($hasComment||$login) {
           $content = preg_replace("/\{bs-hide\}(.*?)\{\/bs-hide\}/sm",'<div class="ui floating message">$1</div>',$post);
        } else {
            $content = preg_replace("/\{bs-hide\}(.*?)\{\/bs-hide\}/sm",'<div class="ui floating message"><i class="thumbtack icon"></i>此处内容需要评论回复或登录后方可阅读。</div>',$post);
        }
    }
    //兼容1.6.3版本前的回复可见短代码
    if (strpos($content, '[bs-hide') !== false) {
        $db = Typecho_Db::get();
        $hasComment = $db->fetchAll($db->select()->from('table.comments')->where('cid = ?', $t->cid)->where('mail = ?', $t->remember('mail', true))->limit(1));

        if ($hasComment||$login) {
           $content = preg_replace("/\[bs-hide\](.*?)\[\/bs-hide\]/sm",'<div class="ui floating message">$1</div>',$post);
        } else {
            $content = preg_replace("/\[bs-hide\](.*?)\[\/bs-hide\]/sm",'<div class="ui floating message"><i class="thumbtack icon"></i>此处内容需要评论回复或登录后方可阅读。</div>',$post);
        }
    }
    //Todolist
    if (strpos($content, '{bs-todo') !== false) {
        if (strpos($content, '{bs-todo type=true') !== false) {
        $content = preg_replace('/\{bs-todo type=true\}(.*?)\{\/bs-todo\}/sm', '<div class="ui checked checkbox"><input type="checkbox" checked="" disabled><label>$1</label></div>', $content);
        }
        if (strpos($content, '{bs-todo type=false') !== false) {
        $content = preg_replace('/\{bs-todo type=false\}(.*?)\{\/bs-todo\}/sm', '<div class="ui  checkbox"><input type="checkbox" disabled><label>$1</label></div>', $content);
        }
    }
    
    //手风琴
    if (strpos($content, '{bs-accord') !== false) {
        if (strpos($content, '{bs-accord style=line') !== false) {
        $content = preg_replace('/\{bs-accord style=line title=(.*?)\}(.*?)\{\/bs-accord\}/sm', '<div class="ui accordion"><div class="title"><i class="dropdown icon"></i>$1</div><div class="content"><p class="transition hidden">$2</p></div></div>', $content);
        }
        if (strpos($content, '{bs-accord style=common') !== false) {
                $content = preg_replace('/\{bs-accord style=common title=(.*?)\}(.*?)\{\/bs-accord\}/sm', '<div class="ui styled fluid accordion"><div class="title"><i class="dropdown icon"></i>$1</div><div class="content"><p class="transition hidden">$2</p></div></div>', $content);
        }
    }
    
    //Github卡片
    if (strpos($content, '{bs-card') !== false) {
        if (strpos($content, '{bs-card type=github') !== false) {
            $url = preg_replace('/\{bs-card type=github projectname=(.*?) projectdec=(.*?) projecturl=(.*?)\}{\/bs-card\}/sm', '$3', $content);
        $content = preg_replace('/\{bs-card type=github projectname=(.*?) projectdec=(.*?) projecturl=(.*?)\}{\/bs-card\}/sm', '<div class="ui relaxed divided list"><div class="item"><i class="large github middle aligned icon"></i><div class="content"><a class="header" href="https://$3">$1</a><div class="description">$2</div></div></div></div>', $content);
        }
    }
    
   //字体颜色
   if (strpos($content, '{bs-font') !== false) {
        $content = preg_replace('/\{bs-font color=(.*?)\}(.*?)\{\/bs-font\}/sm', '<font color=$1>$2</font>', $content);
   }
    //iframe
   if (strpos($content, '{bs-iframe') !== false) {
        $content = preg_replace('/\{bs-iframe\}(.*?)\{\/bs-iframe\}/sm', '<div class="iframe"><iframe class="iframe_video" src="$1" scrolling="no" border="0" frameborder="no" framespacing="0" allowfullscreen="true"></iframe></div>', $content);
        $content = preg_replace('/\<iframe class="iframe_video" src="<a href="(.*?)">(.*?)<\/a>" scrolling="no" border="0" frameborder="no" framespacing="0" allowfullscreen="true"><\/iframe>/sm', '<iframe class="iframe_video" src="$1" scrolling="no" border="0" frameborder="no" framespacing="0" allowfullscreen="true"></iframe>', $content);
   }
   
    //Audio
   if (strpos($content, '{bs-audio') !== false) {
        $content = preg_replace('/\{bs-audio\}(.*?)\{\/bs-audio\}/sm', '<audio src="$1" controls="controls">您的浏览器不支持播放此音频</audio>', $content);
        $content = preg_replace('/\<audio src="<a href="(.*?)">(.*?)<\/a>" controls="controls">(.*?)<\/audio>/sm', '<audio src="$1" controls="controls">$3<\/audio>', $content);
   }
   
    if ($options->Lightbox == '1' || $options->Watermark == '1'){
    $pattern = '/\<img.*?src\=\"(.*?)\"[^>]*>/i';
    $replacement = '
<img src="$1" class="bearmark" referrerPolicy="no-referrer"  alt="'.$t->title.'" title="点击放大图片">';
    $content = preg_replace($pattern, $replacement, "<div id=\"bearsimple-images\">".$content."</div>");
    }

    echo $content;
}

function getAcgFile(){
    $getAcgFile = Helper::options()->siteUrl.'/index.php/getacg';
    echo $getAcgFile;
}

function getAttachFile(){
    $getAttachFile = Helper::options()->siteUrl.'/index.php/write';
    echo $getAttachFile;
}