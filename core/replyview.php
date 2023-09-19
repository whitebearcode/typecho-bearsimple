<?php
//回复可见处理
Typecho_Plugin::factory('Widget_Abstract_Contents')->excerptEx = array('BearToolOne','one');
Typecho_Plugin::factory('Widget_Abstract_Contents')->contentEx = array('BearToolOne','one');
class BearToolOne {
    public static function get_shortcode_regex($tagnames = null)
    {
        global $shortcode_tags;
        if (empty($tagnames)) {
            $tagnames = array_keys($shortcode_tags);
        }
        $tagregexp = join('|', array_map('preg_quote', $tagnames));
        return
            '\\['                           
            . '(\\[?)'                        
            . "($tagregexp)"       
            . '(?![\\w-])'                    
            . '('                         
            . '[^\\]\\/]*'               
            . '(?:'
            . '\\/(?!\\])'     
            . '[^\\]\\/]*'          
            . ')*?'
            . ')'
            . '(?:'
            . '(\\/)'                    
            . '\\]'           
            . '|'
            . '\\]'              
            . '(?:'
            . '('       
            . '[^\\[]*+'  
            . '(?:'
            . '\\[(?!\\/\\2\\])'
            . '[^\\[]*+'
            . ')*+'
            . ')'
            . '\\[\\/\\2\\]'    
            . ')?'
            . ')'
            . '(\\]?)'; 
    }

public static function get_shortcode_regex2($tagnames = null)
    {
        global $shortcode_tags;
        if (empty($tagnames)) {
            $tagnames = array_keys($shortcode_tags);
        }
        $tagregexp = join('|', array_map('preg_quote', $tagnames));
        return
            '\\{'                           
            . '(\\[?)'                        
            . "($tagregexp)"       
            . '(?![\\w-])'                    
            . '('                         
            . '[^\\]\\/]*'               
            . '(?:'
            . '\\/(?!\\])'     
            . '[^\\]\\/]*'          
            . ')*?'
            . ')'
            . '(?:'
            . '(\\/)'                    
            . '\\}'           
            . '|'
            . '\\}'              
            . '(?:'
            . '('       
            . '[^\\[]*+'  
            . '(?:'
            . '\\[(?!\\/\\2\\])'
            . '[^\\[]*+'
            . ')*+'
            . ')'
            . '\\[\\/\\2\\}'    
            . ')?'
            . ')'
            . '(\\]?)'; 
    }
public static function excerpt_text($content)
    {
        if (strpos($content, '[bsgallery') !== false) {
            $pattern = self::get_shortcode_regex(array('bsgallery'));
            $content = preg_replace("/$pattern/", '', $content);
        }
        if (strpos($content, '[bstimes') !== false) {
            $pattern = self::get_shortcode_regex(array('bstimes'));
            $content = preg_replace("/$pattern/", '', $content);
        }
        if (strpos($content, '[bsgit') !== false) {
            $pattern = self::get_shortcode_regex(array('bsgit'));
            $content = preg_replace("/$pattern/", '', $content);
        }
        if (strpos($content, '[bscopy') !== false) {
            $pattern = self::get_shortcode_regex(array('bscopy'));
            $content = preg_replace("/$pattern/", '', $content);
        }
        if (strpos($content, '[bsmusic') !== false) {
            $pattern = self::get_shortcode_regex(array('bsmusic'));
            $content = preg_replace("/$pattern/", '', $content);
        }
        if (strpos($content, '[todo-t') !== false) {
            $pattern = self::get_shortcode_regex(array('todo-t'));
            $content = preg_replace("/$pattern/", '', $content);
        }
        if (strpos($content, '[todo-f') !== false) {
            $pattern = self::get_shortcode_regex(array('todo-f'));
            $content = preg_replace("/$pattern/", '', $content);
        }
        if (strpos($content, '[bstabs') !== false) {
            $pattern = self::get_shortcode_regex(array('bstabs'));
            $content = preg_replace("/$pattern/", '', $content);
        }
        if (strpos($content, '[bseva') !== false) {
            $pattern = self::get_shortcode_regex(array('bseva'));
            $content = preg_replace("/$pattern/", '', $content);
        }
        if (strpos($content, '[bsaudio') !== false) {
            $pattern = self::get_shortcode_regex(array('bsaudio'));
            $content = preg_replace("/$pattern/", '', $content);
        }
        if (strpos($content, '[bspost') !== false) {
            $pattern = self::get_shortcode_regex(array('bspost'));
            $content = preg_replace("/$pattern/", '', $content);
        }
        if (strpos($content, '[bsplayer') !== false) {
            $pattern = self::get_shortcode_regex(array('bsplayer'));
            $content = preg_replace("/$pattern/", '', $content);
        }
        if (strpos($content, '[bsmp3') !== false) {
            $pattern = self::get_shortcode_regex(array('bsmp3'));
            $content = preg_replace("/$pattern/", '', $content);
        }
        if (strpos($content, '[bsruby') !== false) {
            $pattern = self::get_shortcode_regex(array('bsruby'));
            $content = preg_replace("/$pattern/", '', $content);
        }
        if (strpos($content, '[bsprog') !== false) {
            $pattern = self::get_shortcode_regex(array('bsprog'));
            $content = preg_replace("/$pattern/", '', $content);
        }
          if (strpos($content, '[bsdate') !== false) {
            $pattern = self::get_shortcode_regex(array('bsdate'));
            $content = preg_replace("/$pattern/", '', $content);
        }
          if (strpos($content, '[bspaper') !== false) {
            $pattern = self::get_shortcode_regex(array('bspaper'));
            $content = preg_replace("/$pattern/", '', $content);
        }
        if (strpos($content, '[bsmark') !== false) {
            $pattern = self::get_shortcode_regex(array('bsmark'));
            $content = preg_replace("/$pattern/", '', $content);
        }
        if (strpos($content, '[bsmermaid') !== false) {
            $pattern = self::get_shortcode_regex(array('bsmermaid'));
            $content = preg_replace("/$pattern/", '', $content);
        }
        if (strpos($content, '[bsbtn') !== false) {
            $pattern = self::get_shortcode_regex(array('bsbtn'));
            $content = preg_replace("/$pattern/", '', $content);
        }
        if (strpos($content, '[bsmessage') !== false) {
            $pattern = self::get_shortcode_regex(array('bsmessage'));
            $content = preg_replace("/$pattern/", '', $content);
        }
        if (strpos($content, '{bs-hide') !== false) {
            $pattern = self::get_shortcode_regex2(array('bs-hide'));
            $content = preg_replace("/$pattern/", '', $content);
        }
        if (strpos($content, '{bs-todo') !== false) {
            $pattern = self::get_shortcode_regex2(array('bs-todo'));
            $content = preg_replace("/$pattern/", '', $content);
        }
        if (strpos($content, '{bs-accord') !== false) {
            $pattern = self::get_shortcode_regex2(array('bs-accord'));
            $content = preg_replace("/$pattern/", '', $content);
        }
        if (strpos($content, '{bs-font') !== false) {
            $pattern = self::get_shortcode_regex2(array('bs-font'));
            $content = preg_replace("/$pattern/", '', $content);
        }
        if (strpos($content, '{bs-iframe') !== false) {
            $pattern = self::get_shortcode_regex2(array('bs-iframe'));
            $content = preg_replace("/$pattern/", '', $content);
        }
        if (strpos($content, '[bsfra') !== false) {
            $pattern = self::get_shortcode_regex2(array('bsfra'));
            $content = preg_replace("/$pattern/", '', $content);
        }
        if (strpos($content, '{bs-card') !== false) {
            $pattern = self::get_shortcode_regex2(array('bs-card'));
            $content = preg_replace("/$pattern/", '', $content);
        }
        if (strpos($content, '{bs-audio') !== false) {
            $pattern = self::get_shortcode_regex2(array('bs-audio'));
            $content = preg_replace("/$pattern/", '', $content);
        }
if (strpos($content, '[bstag') !== false || strpos($content, '[tag') !== false) {
            $pattern = self::get_shortcode_regex(array('bstag','tag'));
            $content = preg_replace("/$pattern/", '', $content);
        }
        if (strpos($content, '[bsopc') !== false) {
            $pattern = self::get_shortcode_regex(array('bsopc'));
            $content = preg_replace("/$pattern/", '', $content);
        }
        return $content;
    }
    public static function one($con,$obj,$text)
    {
      $text = empty($text)?$con:$text;
      if(!$obj->is('single') && strpos($text, '{bs-hide') !== false){
      $text = '文章包含隐藏内容，请进入文章内页查看~';
      }
      if(!$obj->is('single') && strpos($text, '[bs-hide') !== false){
      $text = '文章包含隐藏内容，请进入文章内页查看~';
      }
      if(!$obj->is('single') && strpos($text, '[bshide') !== false){
      $text = '文章包含隐藏内容，请进入文章内页查看~';
      }
      if(!$obj->is('single') && strpos($text, '[bslogin') !== false){
      $text = '文章包含隐藏内容，请进入文章内页查看~';
      }
      if(!$obj->is('single')){
       $text = self::excerpt_text($text);
      }

               return $text;
}
}
