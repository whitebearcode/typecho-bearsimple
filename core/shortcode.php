<?php
function ShortCode($post,$t,$login){
    $content = $post;
    //回复可见
    if (strpos($content, '[bcool-hide') !== false) {
        $db = Typecho_Db::get();
        $hasComment = $db->fetchAll($db->select()->from('table.comments')->where('cid = ?', $t->cid)->where('mail = ?', $t->remember('mail', true))->limit(1));

        if ($hasComment||$login) {
           $content = preg_replace("/\[bcool-hide\](.*?)\[\/bcool-hide\]/sm",'<div class="ui floating message">$1</div>',$post);
        } else {
            $content = preg_replace("/\[bcool-hide\](.*?)\[\/bcool-hide\]/sm",'<div class="ui floating message"><i class="thumbtack icon"></i>此处内容需要评论回复后方可阅读。</div>',$post);
        }
    }
    
    if (strpos($content, '[bs-hide') !== false) {
        $db = Typecho_Db::get();
        $hasComment = $db->fetchAll($db->select()->from('table.comments')->where('cid = ?', $t->cid)->where('mail = ?', $t->remember('mail', true))->limit(1));

        if ($hasComment||$login) {
           $content = preg_replace("/\[bs-hide\](.*?)\[\/bs-hide\]/sm",'<div class="ui floating message">$1</div>',$post);
        } else {
            $content = preg_replace("/\[bs-hide\](.*?)\[\/bs-hide\]/sm",'<div class="ui floating message"><i class="thumbtack icon"></i>此处内容需要评论回复后方可阅读。</div>',$post);
        }
    }
    //Todolist
    if (strpos($content, '{bcool-todo') !== false) {
        if (strpos($content, '{bcool-todo type=true') !== false) {
        $content = preg_replace('/\{bcool-todo type=true\}(.*?)\{\/bcool-todo\}/sm', '<ul class="checklist-ul"><li>$1</li></ul>', $content);
        }
        if (strpos($content, '{bcool-todo type=false') !== false) {
        $content = preg_replace('/\{bcool-todo type=false\}(.*?)\{\/bcool-todo\}/sm', '<ul class="checklist-ul"><li class="disable-li">$1</li></ul>', $content);
        }
    }
    //手风琴折叠
    if (strpos($content, '{bcool-accordion') !== false) {
        if (strpos($content, '{bcool-accordion type=stand') !== false) {
        $content = preg_replace('/\{bcool-accordion type=stand title=(.*?)\}(.*?)\{\/bcool-accordion\}/sm', '<div class="accordion-item"><div class="accordion-item-title"><span>$1</span></div><div class="accordion-item-content"><p>$2</p></div></div>', $content);
        }
        if (strpos($content, '{bcool-accordion type=line') !== false) {
        $content = preg_replace('/\{bcool-accordion type=line title=(.*?)\}(.*?)\{\/bcool-accordion\}/sm', '<div class="accordion-block with-border"><div class="accordion-item"><div class="accordion-item-title"><span>$1</span></div><div class="accordion-item-content"><p>$2</p></div></div></div>', $content);
        }
    }
    echo $content;
}