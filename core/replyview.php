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
          if (strpos($text, '[bspost') !== false) {
                    $text = preg_replace('/\[bspost (.*?)\]/sm', '', $text);
}

if (strpos($text, '[bsprog') !== false) {
            $pattern = self::get_shortcode_regex(array('bsprog'));
            $text = preg_replace("/$pattern/", '', $text);
        }
        if (strpos($text, '[bsgallery') !== false) {
            $pattern = self::get_shortcode_regex(array('bsgallery'));
            $text = preg_replace("/$pattern/", '', $text);
        }
          if (strpos($text, '[bsgit') !== false) {
            $pattern = self::get_shortcode_regex(array('bsgit'));
            $text = preg_replace("/$pattern/", '', $text);
        }
        if (strpos($text, '[bseva') !== false) {
            $pattern = self::get_shortcode_regex(array('bseva'));
            $text = preg_replace("/$pattern/", '', $text);
        }
        if (strpos($text, '[bsaudio') !== false) {
            $pattern = self::get_shortcode_regex(array('bsaudio'));
            $text = preg_replace("/$pattern/", '', $text);
        }
        if (strpos($text, '[bspost') !== false) {
            $pattern = self::get_shortcode_regex(array('bspost'));
            $text = preg_replace("/$pattern/", '', $text);
        }
        if (strpos($text, '[bsruby') !== false) {
            $pattern = self::get_shortcode_regex(array('bsruby'));
            $text = preg_replace("/$pattern/", '', $text);
        }
        if (strpos($text, '[bsmark') !== false) {
            $pattern = self::get_shortcode_regex(array('bsmark'));
            $text = preg_replace("/$pattern/", '', $text);
        }
        if (strpos($text, '[bsbtn') !== false) {
            $pattern = self::get_shortcode_regex(array('bsbtn'));
            $text = preg_replace("/$pattern/", '', $text);
        }
        if (strpos($text, '[bsmessage') !== false) {
            $pattern = self::get_shortcode_regex(array('bsmessage'));
            $text = preg_replace("/$pattern/", '', $text);
        }
        if (strpos($text, '{bs-todo') !== false) {
            $pattern = self::get_shortcode_regex2(array('bs-todo'));
            $text = preg_replace("/$pattern/", '', $text);
        }
        if (strpos($text, '{bs-accord') !== false) {
            $pattern = self::get_shortcode_regex2(array('bs-accord'));
            $text = preg_replace("/$pattern/", '', $text);
        }
        if (strpos($text, '{bs-font') !== false) {
            $pattern = self::get_shortcode_regex2(array('bs-font'));
            $text = preg_replace("/$pattern/", '', $text);
        }
        if (strpos($text, '{bs-iframe') !== false) {
            $pattern = self::get_shortcode_regex2(array('bs-iframe'));
            $text = preg_replace("/$pattern/", '', $text);
        }
        if (strpos($text, '{bs-card') !== false) {
            $pattern = self::get_shortcode_regex2(array('bs-card'));
            $text = preg_replace("/$pattern/", '', $text);
        }
        if (strpos($text, '{bs-audio') !== false) {
            $pattern = self::get_shortcode_regex2(array('bs-audio'));
            $text = preg_replace("/$pattern/", '', $text);
        }

      }

               return $text;
}
}
