<?php
//回复可见处理
Typecho_Plugin::factory('Widget_Abstract_Contents')->excerptEx = array('BearToolOne','one');
Typecho_Plugin::factory('Widget_Abstract_Contents')->contentEx = array('BearToolOne','one');
class BearToolOne {
    public static function one($con,$obj,$text)
    {
      $text = empty($text)?$con:$text;
      if(!$obj->is('single')){
      $text = preg_replace("/\[bs-hide\](.*?)\[\/bs-hide\]/sm",'文章包含隐藏内容，请进入文章内页查看~',$text);
      }
      
               return $text;
}
}
