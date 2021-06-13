<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

  <link rel="stylesheet" href="<?php $this->options->themeUrl('/assets/owo/OwO.min.css'); ?>">
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
   <?php echo reEmo($comments->content); ?>
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

    <?php $comments->pageNav('&laquo; 前一页', '后一页 &raquo;'); ?>
    
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
  <img src="https://gravatar.loli.net/avatar//d41d8cd98f00b204e9800998ecf8427e?s=65&r=G&d=">
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
                
                <?php if($this->options->Entermaxlength == '1') :?>
                <div class="ui label" style="float:right">
  字数
  <div id="num" class="detail">0</div>/<?php $this->options->Entermaxlengths();?>
</div><?php endif ; ?>
<div class="OwO"></div>
                <textarea rows="8" cols="50" <?php if($this->options->Entermaxlength == '1') :?>maxlength="<?php $this->options->Entermaxlengths();?>"<?php endif ; ?> onkeyup="wordStatic(this);" name="text" id="textarea" placeholder="嘿~ 大神，别默默的看了，快来点评一下吧" class="textarea OwO-textarea" required ><?php $this->remember('text'); ?></textarea>
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
             <?php if($this->options->VerifyChoose == '2') :?>
             <br>
             <div class="vaptcha-container" style="width: 300px;height: 36px;">
    <div class="vaptcha-init-main">
        <div class="vaptcha-init-loading">
            <a href="/" target="_blank">
                <img src="https://cdn.vaptcha.com/vaptcha-loading.gif" />
            </a>
            <span class="vaptcha-text">Loading...</span>
        </div>
    </div>
</div>
    		<p>
                <button id="bearsimple_verify" type="submit" class="ui primary button"><?php _e('提交评论'); ?></button>
            </p>
            <?php endif ; ?>
            <?php if($this->options->VerifyChoose == '3') :?>
            <p>
                <button type="submit" class="ui primary button"><?php _e('提交评论'); ?></button>
            </p>
            <?php endif ; ?>
    	</form>
</div></div>
<script src="<?php $this->options->themeUrl('/assets/owo/OwO.min.js'); ?>"></script>

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