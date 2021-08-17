<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php if($this->options->Emoji == '1') :?>
  <link rel="stylesheet" href="<?php AssetsDir();?>assets/owo/OwO.min.css">
  <?php endif; ?>
       <h3 class="ui dividing header" id="comments"><i class="comments outline icon"></i>评论区</h3>
<?php function threadedComments($comments, $options) {
    $commentClass = '';
    if ($comments->authorId) {
        if ($comments->authorId == $comments->ownerId) {
            $commentClass .= ' comment-by-author';
        } else {
            $commentClass .= ' comment-by-user';
        }
    }
 
    $commentLevelClass = $comments->levels > 0 ? ' comment-child' : ' comment-parent';
?>
   
 <div class="ui comments">
<div id="li-<?php $comments->theId(); ?>" class="comment-body<?php 
if ($comments->levels > 0) {
    echo ' comment-child';
    $comments->levelsAlt(' comment-level-odd', ' comment-level-even');
} else {
    echo ' comment-parent';
}
$comments->alt(' comment-odd', ' comment-even');
echo $commentClass;
?>">

    <div id="<?php $comments->theId(); ?>">
    
  <div class="comment">
    <a class="avatar">
        <img class="avatar" src="<?php imgravatarq($comments->mail); ?>s=100" alt="" width="60" height="60">
            </a>
            <div class="content">
      <a class="author">
            <?php $comments->author(); ?>
             <?php 
        if ($comments->authorId == $comments->ownerId) {
             echo '<a class="ui blue label">
  <i class="icon chess queen"></i>作者
</a>';
             }else if ($comments->authorId !== $comments->ownerId){
                  echo '<div class="ui label">
  <i class="user icon"></i>读者
</div>';
             }
        
        ?>
        </a>
      <div class="metadata">
            <span class="date"><a href="<?php $comments->permalink(); ?>"><?php $comments->date('Y-m-d H:i'); ?></a></span>
            </div>
           <div class="text">
               
    <div class="ui pointing basic label">
   <?php if(Helper::options()->CommentCoid == '1') :?><b><?php echo getPermalinkFromCoid($comments->parent); ?></b><?php endif; ?><?php echo reEmo($comments->content); ?>
   </div>
</div>

    <div class="actions">
    
         <a class="reply">
   
           <?php $comments->reply(); ?> </a>

        </div>
       
      </div>
    </div>

<?php if ($comments->children) { ?>
    <div class="comments">
        <?php $comments->threadedComments($options); ?>
    </div>
<?php } ?>
</div>
<?php } ?>



<div id="comments" class="comment">
    <?php $this->comments()->to($comments); ?>
    <?php if ($comments->have()): ?>
	<h3 class="ui header"><?php $this->commentsNum(_t('暂无评论'), _t('仅有一条评论'), _t('已有 %d 条评论')); ?></h3>
    
    <?php $comments->listComments(); ?>

<?php
class Typecho_Widget_Helper_PageNavigator_Box extends Typecho_Widget_Helper_PageNavigator
{
   
    public function render($prevWord = 'PREV', $nextWord = 'NEXT', $splitPage = 3, $splitWord = '...', array $template = array())
    { 
        if ($this->_total < 1) {
            return;
        }
        $default = array(
            'aClass'  =>  '',
            'itemTag'       =>  'li',
            'textTag'       =>  'span',
            'textClass'       =>  '',
            'currentClass'  =>  'current',
            'prevClass'     =>  'prev',
            'nextClass'     =>  'next'
        );
        $template = array_merge($default, $template);
        extract($template);
        // 定义item
        $itemBegin = empty($itemTag) ? '' : ('<' . $itemTag . '>');
        $itemCurrentBegin = empty($itemTag) ? '' : ('<' . $itemTag 
            . (empty($currentClass) ? '' : ' class="' . $currentClass . '"') . '>');
        $itemPrevBegin = empty($itemTag) ? '' : ('<' . $itemTag 
            . (empty($prevClass) ? '' : ' class="' . $prevClass . '"') . '>');
        $itemNextBegin = empty($itemTag) ? '' : ('<' . $itemTag 
            . (empty($nextClass) ? '' : ' class="' . $nextClass . '"') . '>');
        $itemEnd = empty($itemTag) ? '' : ('</' . $itemTag . '>');
        $textBegin = empty($textTag) ? '' : ('<' . $textTag 
            . (empty($textClass) ? '' : ' class="' . $textClass . '"') . '>');
        $textEnd = empty($textTag) ? '' : ('</' . $textTag . '>');

        $linkBegin = '<a href="%s" '. (empty($aClass) ? '' : ' class="' . $aClass . '"') . '>';
        $linkCurrentBegin = empty($itemTag) ? ('<a href="%s"'
            . (empty($currentClass) ? '' : ' class="' . $currentClass . '"') . '>')
            : $linkBegin;
        $linkPrevBegin = empty($itemTag) ? ('<a href="%s"'
            . (empty($prevClass) ? '' : ' class="' . $prevClass . '"') . '>')
            : $linkBegin;
        $linkNextBegin = empty($itemTag) ? ('<a href="%s"'
            . (empty($nextClass) ? '' : ' class="' . $nextClass . '"') . '>')
            : $linkBegin;
        $linkEnd = '</a>';
        $from = max(1, $this->_currentPage - $splitPage);
        $to = min($this->_totalPage, $this->_currentPage + $splitPage);
        //输出上一页
        if ($this->_currentPage > 1) {
            echo $itemPrevBegin . sprintf($linkPrevBegin,
                str_replace($this->_pageHolder, $this->_currentPage - 1, $this->_pageTemplate) . $this->_anchor)
                . $prevWord . $linkEnd . $itemEnd;
        }
        //输出第一页
        if ($from > 1) {
            echo $itemBegin . sprintf($linkBegin, str_replace($this->_pageHolder, 1, $this->_pageTemplate) . $this->_anchor)
                . '1' . $linkEnd . $itemEnd;
            if ($from > 2) {
                //输出省略号
                echo $itemBegin . $textBegin . $splitWord . $textEnd . $itemEnd;
            }
        }
        //输出中间页
        for ($i = $from; $i <= $to; $i ++) {
            $current = ($i == $this->_currentPage);
            
            echo ($current ? $itemCurrentBegin : $itemBegin) . sprintf(($current ? $linkCurrentBegin : $linkBegin),
                str_replace($this->_pageHolder, $i, $this->_pageTemplate) . $this->_anchor)
                . $i . $linkEnd . $itemEnd;
        }
        //输出最后页
        if ($to < $this->_totalPage) {
            if ($to < $this->_totalPage - 1) {
                echo $itemBegin . $textBegin . $splitWord . $textEnd . $itemEnd;
            }
            
            echo $itemBegin . sprintf($linkBegin, str_replace($this->_pageHolder, $this->_totalPage, $this->_pageTemplate) . $this->_anchor)
                . $this->_totalPage . $linkEnd . $itemEnd;
        }
        //输出下一页
        if ($this->_currentPage < $this->_totalPage) {
            echo $itemNextBegin . sprintf($linkNextBegin,
                str_replace($this->_pageHolder, $this->_currentPage + 1, $this->_pageTemplate) . $this->_anchor)
                . $nextWord . $linkEnd . $itemEnd;
        }
    }
}
?>
<?php $comments->pageNav('上一页', '下一页', 2, '...', array('wrapTag' => 'nav', 'wrapClass' => 'page-navigator', 'itemTag' => '','aClass' => 'page-number','textClass' => 'page-number', 'currentClass' => 'page-number current', 'prevClass' => 'extend prev', 'nextClass' => 'extend next',)); ?>

    
    <?php endif; ?>

    <?php if($this->allow('comment')): ?>
    <div id="<?php $this->respondId(); ?>" class="respond">
     
        <div class="cancel-comment-reply">
            
            <?php $comments->cancelReply('<br><div class="ui label">
  <i class="reply icon"></i>取消回复
</div>'); ?>
        </div>

    	<h3 id="response"><?php _e('评论一下~'); ?></h3>
    	<form method="post" action="<?php $this->commentUrl() ?>" id="comment-form" role="form" class="ui form">
            <?php if($this->user->hasLogin()): ?>
      

            
    		<br>
    		    <a class="ui image label"  href="<?php $this->options->profileUrl(); ?>">
  <img src="<?php imgravatarq($this->user->mail); ?>?s=65&r=G&d=">
  当前身份:<?php $this->user->screenName(); ?>
</a>
    		  <a href="<?php $this->options->logoutUrl(); ?>" title="Logout"><i class="icon sign-out"></i></a><br>
            <?php else: ?>
<br>
                <label for="author" class="required"><?php _e('称呼'); ?></label>
    			<input type="text" name="author" id="author" class="text" value="<?php $this->remember('author'); ?>" required />
    	  		<br>
                <label for="mail"<?php if ($this->options->commentsRequireMail): ?> class="required"<?php endif; ?>><?php _e('邮箱'); ?></label>
    			<input type="email" name="mail" id="mail" class="text" value="<?php $this->remember('mail'); ?>"<?php if ($this->options->commentsRequireMail): ?> required<?php endif; ?> />
    
    		<br>
                <label for="url"<?php if ($this->options->commentsRequireURL): ?> class="required"<?php endif; ?>><?php _e('网站'); ?></label>
    			<input type="url" name="url" id="url" class="text" placeholder="<?php _e('https://'); ?>" value="<?php $this->remember('url'); ?>"<?php if ($this->options->commentsRequireURL): ?> required<?php endif; ?> />
    		<br>
            <?php endif; ?>
    		<br>
                <label for="textarea" class="required"><?php _e('内容'); ?></label>
                
                <?php if($this->options->Entermaxlength == '1'&& !empty($this->options->Entermaxlengths)) :?>
                <div class="ui label" style="float:right">
  字数
  <div id="num" class="detail">0</div>/<?php $this->options->Entermaxlengths();?>
</div><?php endif ; ?>
<?php if($this->options->Emoji == '1') :?>
<div class="OwO"></div>
<?php endif ; ?>
                <textarea rows="8" cols="50" <?php if($this->options->Entermaxlength == '1'&& !empty($this->options->Entermaxlengths)) :?>maxlength="<?php $this->options->Entermaxlengths();?>"<?php endif ; ?> onkeyup="wordStatic(this);" name="text" id="textarea" placeholder="嘿~ 大神，别默默的看了，快来点评一下吧" class="textarea <?php if($this->options->Emoji == '1') :?>OwO-textarea<?php endif ; ?>" required ><?php $this->remember('text'); ?></textarea>
            <br>
            <?php if($this->options->VerifyChoose == '1') :?>
             <?php spam_protection_mathjia();?>
             	<p>
                <button type="submit" class="ui primary button"><?php _e('提交评论'); ?></button>
            </p>
             <?php endif ; ?>
             <?php if($this->options->VerifyChoose == '11') :?>
             <?php spam_protection_mathjian();?>
             	<p>
                <button type="submit" class="ui primary button"><?php _e('提交评论'); ?></button>
            </p>
             <?php endif ; ?>
<?php if($this->options->VerifyChoose == '4') :?>
                 <?php SimpleCommentCaptcha_Plugin::outputSimpleCommentCaptchaField(); ?>
             	<p>
                <button type="submit" class="ui primary button"><?php _e('提交评论'); ?></button>
            </p>
             <?php endif ; ?>
             <?php if($this->options->VerifyChoose == '2') :?>
             <br>
             <div class="vaptcha-container" style="width: 260px;height: 36px;">
    <div class="vaptcha-init-main">
        <div class="vaptcha-init-loading">
            <a href="/" target="_blank">
                <img src="https://r.vaptcha.net/public/img/vaptcha-loading.gif" />
            </a>
            <span class="vaptcha-text">Loading...</span>
        </div>
    </div>
</div>
    		<p>
                <button id="bearsimple_verify" type="submit" class="ui primary button"><?php _e('提交评论'); ?></button>
            </p>
            <?php endif ; ?>
            <?php if($this->options->VerifyChoose == '22') :?>
             <br>
             
             <a class="ui button" onclick="Verify();"><i class="user secret icon"></i><?php if(empty($this->options->Verify22_Buttontext)){echo '人机验证';}else{
			echo $this->options->Verify22_Buttontext();}
			  ?></a>
	<div id="QVerify" style="visibility: hidden"></div>
    		<p>
                <button id="bearsimple_verify2" type="submit" class="ui primary button"><?php _e('提交评论'); ?></button>
            </p>
            <?php $this->need('modules/Verify/BearCaptcha/Captcha/Captcha.php'); ?>
            <?php endif ; ?>
           
            <?php if($this->options->VerifyChoose == '3') :?>
            <p>
                <button type="submit" class="ui primary button"><?php _e('提交评论'); ?></button>
            </p>
            <?php endif ; ?>
    	</form>
</div></div>
<?php if($this->options->Emoji == '1') :?>
<?php if($this->allow('comment')) : ?>
<script src="<?php AssetsDir();?>assets/owo/OwO.min.js"></script>
<?php endif ; ?><?php endif ; ?>
    <?php else: ?>
    <h3><?php _e('评论已关闭'); ?></h3></div>
    <?php endif; ?>
</div></div>

<script>
function wordStatic(input) {
        var content = document.getElementById('num');
        if (content && input) {
            var value = input.value;
            value = value.replace(/\n|\r/gi,"");
            content .innerText = value.length;
        }
    }
</script>