<?php
Typecho_Plugin::factory('Widget_Feedback')->comment = array('BearsimpleSpam', 'filter');
class BearsimpleSpam{
public static function xsscheck($text)
{
    $xsscheck = false;
    $list = array(
        '/onabort/is',
        '/onblur/is',
        '/onchange/is',
        '/onclick/is',
        '/ondblclick/is',
        '/onerror/is',
        '/onfocus/is',
        '/onkeydown/is',
        '/onkeypress/is',
        '/onkeyup/is',
        '/onload/is',
        '/onmousedown/is',
        '/onmousemove/is',
        '/onmouseout/is',
        '/onmouseover/is',
        '/onmouseup/is',
        '/onreset/is',
        '/onresize/is',
        '/onselect/is',
        '/onsubmit/is',
        '/onunload/is',
        '/eval/is',
        '/ascript:/is',
        '/style=/is',
        '/width=/is',
        '/width:/is',
        '/height=/is',
        '/height:/is',
        '/src=/is',
    );
    if (strip_tags($text)) {
        for ($i = 0; $i < count($list); $i++) {
            if (preg_match($list[$i], $text) > 0) {
                $xsscheck = true;
                break;
            }
        }
    } else {
        $xsscheck = true;
    };
    return $xsscheck;
}

/**
    * PHP获取字符串中英文混合长度 
    */
    public static function strLength($str){        
        preg_match_all('/./us', $str, $match);
        return count($match[0]);  // 输出9
    }
        

    /**
     * 检查$str中是否含有$words_str中的词汇
     * 
     */
	public static function check_in($words_str, $str)
	{
		$words = explode("\n", $words_str);
		if (empty($words)) {
			return false;
		}
		foreach ($words as $word) {
            if (false !== strpos($str, trim($word))) {
                return true;
            }
		}
		return false;
	}

    /**
     * 检查$ip中是否在$words_ip的IP段中
     * 
     */
	public static function check_ip($words_ip, $ip)
	{
		$words = explode("\n", $words_ip);
		if (empty($words)) {
			return false;
		}
		foreach ($words as $word) {
			$word = trim($word);
			if (false !== strpos($word, '*')) {
				$word = "/^".str_replace('*', '\d{1,3}', $word)."$/";
				if (preg_match($word, $ip)) {
					return true;
				}
			} else {
				if (false !== strpos($ip, $word)) {
					return true;
				}
			}
		}
		return false;
	}
	
 public static function filter($comment,$post){
 $options = Typecho_Widget::widget('Widget_Options');
         if (strlen(trim(preg_replace('/\xc2\xa0/',' ',$comment['text']))) == 0) {
			Typecho_Cookie::set('__typecho_remember_text', $comment['text']);
			throw new Typecho_Widget_Exception("抱歉，系统检测到您的评论内容只有空格，请返回修改后再试。");
            }
            
        if(BearsimpleSpam::xsscheck($comment['text'])) {
			Typecho_Cookie::set('__typecho_remember_text', $comment['text']);
			throw new Typecho_Widget_Exception("抱歉，系统检测到您的评论包含危险内容，请返回修改后再试。");
        }
        
        if (!empty($options->BearSpam_IP)) {
			if (BearsimpleSpam::check_ip($options->BearSpam_IP, $comment['ip'])) {
			throw new Typecho_Widget_Exception("抱歉，系统检测到您的IP处于屏蔽范围内，已拦截本条评论。");
			  Typecho_Cookie::set('__typecho_remember_text', $comment['text']);
			}

            
        }
		if (!empty($options->BearSpam_EMAIL)) {
			if (BearsimpleSpam::check_in($options->BearSpam_EMAIL, $comment['mail'])) {
				throw new Typecho_Widget_Exception("抱歉，系统检测到您的邮箱处于屏蔽范围内，已拦截本条评论。");
				  Typecho_Cookie::set('__typecho_remember_text', $comment['text']);
			}
		}
		
			if (!empty($options->BearSpam_NAME)) {
			if (BearsimpleSpam::check_in($options->BearSpam_NAME, $comment['author'])) {
				throw new Typecho_Widget_Exception("抱歉，系统检测到您的昵称存在敏感禁止词汇，已拦截本条评论。");
				  Typecho_Cookie::set('__typecho_remember_text', $comment['text']);
			}
		}
		
		if (!empty($options->BearSpam_URL)) {
			if (BearsimpleSpam::check_in($options->BearSpam_URL, $comment['url'])) {
			    			throw new Typecho_Widget_Exception("抱歉，系统检测到您的网址处于屏蔽范围内，已拦截本条评论。");
			Typecho_Cookie::set('__typecho_remember_text', $comment['text']);
			}
			}
			
			if (!empty($options->BearSpam_ArticleTitle)&& $options->BearSpam_ArticleTitle == "1") {
			$db = Typecho_Db::get();
            // 获取评论所在文章
            $pot = $db->fetchRow($db->select('title')->from('table.contents')->where('cid = ?', $comment['cid']));        
            if(strstr($comment['text'], $pot['title'])){
                		throw new Typecho_Widget_Exception("抱歉，系统检测到您的评论内容疑似存在灌水内容，已自动拦截。");
Typecho_Cookie::set('__typecho_remember_text', $comment['text']);
			}
			}
			
			if (!empty($options->BearSpam_NAMEMIN)) {    
            if(BearsimpleSpam::strLength($comment['author']) < $options->BearSpam_NAMEMIN){

			throw new Typecho_Widget_Exception("抱歉，系统检测到您的评论昵称过短，已自动拦截。");
			Typecho_Cookie::set('__typecho_remember_text', $comment['text']);
			}
			}
			
			if (!empty($options->BearSpam_NAMEMAX)) {    
            if (BearsimpleSpam::strLength($comment['author']) > $options->BearSpam_NAMEMAX) {
                throw new Typecho_Widget_Exception("抱歉，系统检测到您的评论昵称过长，已自动拦截。");
			Typecho_Cookie::set('__typecho_remember_text', $comment['text']);
			}}
			
			if (!empty($options->BearSpam_NAMEURL)&& $options->BearSpam_NAMEURL == "1") {    
            if (preg_match(" /^((https?|ftp|news):\/\/)?([a-z]([a-z0-9\-]*[\.。])+([a-z]{2}|aero|arpa|biz|com|coop|edu|gov|info|int|jobs|mil|museum|name|nato|net|org|pro|travel)|(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5]))(\/[a-z0-9_\-\.~]+)*(\/([a-z0-9_\-\.]*)(\?[a-z0-9+_\-\.%=&]*)?)?(#[a-z][a-z0-9_]*)?$/ ", $comment['author']) > 0) {
			                throw new Typecho_Widget_Exception("抱歉，系统检测到您的评论昵称异常，已自动拦截。");
			Typecho_Cookie::set('__typecho_remember_text', $comment['text']);
			}}
			
			if (!empty($options->BearSpam_Chinese)&& $options->BearSpam_Chinese == "1") {    
            if (preg_match("/[\x{4e00}-\x{9fa5}]/u", $comment['text']) == 0) {
			throw new Typecho_Widget_Exception("抱歉，系统检测到您的评论内容不包含中文，已自动拦截。");
			Typecho_Cookie::set('__typecho_remember_text', $comment['text']);
			}}
			
			if (!empty($options->BearSpam_MIN)) {    
            if(BearsimpleSpam::strLength($comment['text']) < $options->BearSpam_MIN){         
				throw new Typecho_Widget_Exception("抱歉，系统检测到您的评论内容字数过少，已自动拦截。");
			Typecho_Cookie::set('__typecho_remember_text', $comment['text']);
			}}
			
			if (!empty($options->BearSpam_Words)) {    
            if (BearsimpleSpam::check_in($options->BearSpam_Words, $comment['text'])) { 
	throw new Typecho_Widget_Exception("抱歉，系统检测到您的评论内容包含敏感禁止词汇，已自动拦截。");
			Typecho_Cookie::set('__typecho_remember_text', $comment['text']);
			}
					    
			}
            Typecho_Cookie::delete('__typecho_remember_text');
        return $comment;
 }
 
}