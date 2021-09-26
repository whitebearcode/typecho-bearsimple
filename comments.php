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
    
  <div class="comment" style="margin-left:-35px">
    <a class="ui big circular image avatar" style="margin-top:10px;">
        <img class="avatar" src="<?php imgravatarq($comments->mail); ?>" alt="" width="60" height="60">
            </a>
            <div class="content">
      <a class="author" style="margin-right:10px;">
            <a><?php $comments->author(); ?></a>
             <?php 
        if ($comments->authorId == $comments->ownerId) {
             echo '<div class="ui mini blue label">
  <i class="icon chess queen"></i>作者
</div>';
             }else if ($comments->authorId !== $comments->ownerId){
                  echo '<div class="ui mini label">
  <i class="user icon"></i>读者
</div>';
             }
        
        ?>

      <div class="metadata">
            <span class="date"><a href="<?php $comments->permalink(); ?>"><?php $comments->date('Y-m-d H:i'); ?></a></span>
            </div>
           <div class="text">
              
    <div class="ui left pointing basic label" style="margin-top:5px">
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
    <div class="comments" style="margin-left:-17px;margin-top:3px">

        <?php $comments->threadedComments($options); ?>
    </div>
<?php } ?>
</div>
<?php } ?>

<div id="comments" class="comment">
    <?php $this->comments()->to($comments); ?>
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
    			<input type="email" name="mail" id="mail" class="text" value="<?php $this->remember('mail'); ?>" required />
    
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
                <button type="submit" class="ui primary button"><i class="icon edit"></i> <?php _e('提交评论'); ?></button>
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
                <button type="submit" class="ui primary button"><i class="icon edit"></i> <?php _e('提交评论'); ?></button>
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
                <button id="bearsimple_verify" type="submit" class="ui primary button"><i class="icon edit"></i> <?php _e('提交评论'); ?></button>
            </p>
            <?php endif ; ?>
            <?php if($this->options->VerifyChoose == '22') :?>
             <br>
             
             <a class="ui button" onclick="Verify();"><i class="user secret icon"></i><?php if(empty($this->options->Verify22_Buttontext)){echo '人机验证';}else{
			echo $this->options->Verify22_Buttontext();}
			  ?></a>
	<div id="QVerify" style="visibility: hidden"></div>
    		<p>
                <button id="bearsimple_verify2" type="submit" class="ui primary button"><i class="icon edit"></i> <?php _e('提交评论'); ?></button>
            </p>
            <?php $this->need('modules/Verify/BearCaptcha/Captcha/Captcha.php'); ?>
            <?php endif ; ?>
           
            <?php if($this->options->VerifyChoose == '3') :?>
            <p>
                <button type="submit" class="ui primary button"><i class="icon edit"></i> <?php _e('提交评论'); ?></button>
            </p>
            <?php endif ; ?>
    	</form>
</div></div>
<?php if($this->options->Emoji == '1') :?>
<?php if($this->allow('comment')) : ?>
<script src="<?php AssetsDir();?>assets/owo/OwO.min.js"></script>
<?php endif ; ?><?php endif ; ?>

<h3 class="ui header"><?php $this->commentsNum(_t('<span style="display: flex;align-items: center;justify-content: center;"><svg t="1630041108715" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="6279" width="64" height="64"><path d="M209.813333 170.133333c110.08-102.4 274.133333-138.88 418.773334-101.12C821.333333 116.693333 971.093333 302.08 970.026667 501.76c7.146667 149.866667-69.013333 298.453333-190.933334 384.533333-79.893333 57.386667-178.773333 88.213333-277.333333 83.84-171.946667 0.64-335.68-109.866667-405.866667-265.813333-80.64-170.24-41.706667-389.44 96.64-518.293333 0.746667 6.08 2.453333 18.24 3.2 24.32-23.573333 35.306667-51.52 68.053333-70.613333 106.346666-61.546667 120.533333-61.866667 270.4-0.853333 391.146667 54.933333 109.653333 158.08 194.24 276.906666 225.066667 177.92 50.24 382.826667-29.546667 477.973334-188.266667a462.293333 462.293333 0 0 0 42.24-86.72c43.52-120.106667 29.973333-259.2-36.906667-368.106667-49.493333-77.653333-118.933333-147.733333-207.466667-178.346666-109.226667-44.693333-236.586667-42.773333-343.573333 7.466666-18.026667 10.773333-48.32 12.266667-52.8 36.906667-23.466667 5.226667-47.146667 9.6-70.826667 14.293333z" fill="#EEA850" p-id="6280"></path><path d="M333.44 118.933333c106.986667-50.24 234.346667-52.16 343.573333-7.466666 88.533333 30.613333 157.973333 100.693333 207.466667 178.346666 66.88 108.906667 80.426667 248 36.906667 368.106667-41.066667-10.666667-80.426667 9.386667-121.173334 10.666667-24.426667 1.706667-48.96 0.32-73.173333 4.266666-37.866667 15.68-47.68 82.56-95.786667 76.053334 8.213333-7.573333 16.32-15.253333 24.533334-22.826667 30.4-27.733333 52.8-73.706667 33.173333-113.813333-10.88-21.653333-42.133333-17.066667-56.853333-1.92-56.96 51.2-136.853333 65.92-211.2 63.146666 54.4-31.04 122.453333-20.906667 174.506666-58.026666-100.8-36.373333-159.36-133.866667-209.813333-222.08-53.76-31.466667-121.92-15.36-181.866667-22.293334-0.853333-3.626667-2.666667-10.88-3.626666-14.506666 67.2 0 134.613333 2.986667 201.706666-2.453334-2.986667-4.693333-8.96-14.186667-11.946666-18.88-42.773333-4.16-85.866667-0.106667-128.746667-2.026666 26.24-19.093333 58.453333-24 89.813333-27.2 4.48-39.04 4.586667-78.4 0.64-117.546667-7.253333-2.346667-14.4-4.693333-21.546666-7.253333-1.386667-27.306667-25.92-36.373333-49.386667-25.386667 4.48-24.64 34.773333-26.133333 52.8-36.906667m301.973333 46.72c36.16 14.506667 75.946667 17.92 112.213334 32.96 15.253333-9.92 20.906667-37.333333-2.24-41.6-30.826667-10.773333-62.613333-18.56-94.506667-25.6-18.986667-5.973333-35.306667 24-15.466667 34.24m-68.586666 168.426667c-16.96-3.946667-15.466667 24.426667-1.493334 22.4 61.546667 0.426667 123.2 1.28 184.64-0.32 1.706667-3.413333 5.013333-10.453333 6.613334-13.973333l-4.693334-7.04c-61.546667-3.093333-123.413333-0.853333-185.066666-1.066667z" fill="#FDED78" p-id="6281"></path><path d="M635.413333 165.653333c-19.84-10.24-3.52-40.213333 15.466667-34.24 31.893333 7.04 63.68 14.826667 94.506667 25.6 23.146667 4.266667 17.493333 31.68 2.24 41.6-36.266667-15.04-76.053333-18.453333-112.213334-32.96z" fill="#A1380A" p-id="6282"></path><path d="M280.64 155.84c23.466667-10.986667 48-1.92 49.386667 25.386667-41.6 15.893333-85.76 22.826667-129.6 29.44l-4.693334-0.32c-0.746667-6.08-2.453333-18.24-3.2-24.32l-0.96-5.973334c4.586667-2.453333 13.653333-7.466667 18.24-9.92 23.68-4.693333 47.36-9.066667 70.826667-14.293333z" fill="#A03507" p-id="6283"></path><path d="M200.426667 210.666667c43.84-6.613333 88-13.546667 129.6-29.44 7.146667 2.56 14.293333 4.906667 21.546666 7.253333 3.946667 39.146667 3.84 78.506667-0.64 117.546667-31.36 3.2-63.573333 8.106667-89.813333 27.2-21.973333 0.32-43.84 0.64-65.813333 1.386666 0.746667-3.306667 2.133333-10.026667 2.773333-13.44 14.4-8.64 32.106667-12.906667 43.84-25.173333 9.066667-20.053333 9.28-42.56 12.053333-64.106667-17.92-7.04-35.52-14.613333-53.546666-21.226666z" fill="#FEDC76" p-id="6284"></path><path d="M195.733333 210.346667l4.693334 0.32c18.026667 6.613333 35.626667 14.186667 53.546666 21.226666-2.773333 21.546667-2.986667 44.053333-12.053333 64.106667-11.733333 12.266667-29.44 16.533333-43.84 25.173333-0.64 3.413333-2.026667 10.133333-2.773333 13.44 1.173333 5.546667 3.626667 16.533333 4.8 21.973334 0.96 3.626667 2.773333 10.88 3.626666 14.506666 17.28 97.28 37.76 198.72 104 276.16-24.106667 34.88 12.053333 69.12 36.906667 91.093334 6.72 4.48 13.546667 8.746667 20.586667 12.8 25.066667 13.44 51.946667 23.253333 79.68 29.76-0.96 4.906667-2.986667 14.72-3.946667 19.626666 39.253333 4.16 79.253333 4.906667 117.76-5.226666 62.72-16.533333 128.96-6.506667 191.68-23.466667 42.773333-10.346667 82.986667-40.96 128.746667-27.2-95.146667 158.72-300.053333 238.506667-477.973334 188.266667-118.826667-30.826667-221.973333-115.413333-276.906666-225.066667-61.013333-120.746667-60.693333-270.613333 0.853333-391.146667 19.093333-38.293333 47.04-71.04 70.613333-106.346666z" fill="#FFCA73" p-id="6285"></path><path d="M195.306667 334.613333c21.973333-0.746667 43.84-1.066667 65.813333-1.386666 42.88 1.92 85.973333-2.133333 128.746667 2.026666 2.986667 4.693333 8.96 14.186667 11.946666 18.88-67.093333 5.44-134.506667 2.453333-201.706666 2.453334-1.173333-5.44-3.626667-16.426667-4.8-21.973334zM566.826667 334.08c61.653333 0.213333 123.52-2.026667 185.066666 1.066667l4.693334 7.04c-1.6 3.52-4.906667 10.56-6.613334 13.973333-61.44 1.6-123.093333 0.746667-184.64 0.32-13.973333 2.026667-15.466667-26.346667 1.493334-22.4z" fill="#000007" p-id="6286"></path><path d="M203.733333 371.093333c59.946667 6.933333 128.106667-9.173333 181.866667 22.293334 50.453333 88.213333 109.013333 185.706667 209.813333 222.08-52.053333 37.12-120.106667 26.986667-174.506666 58.026666-38.4-5.653333-74.88-20.053333-113.173334-26.24-66.24-77.44-86.72-178.88-104-276.16zM800.213333 668.586667c40.746667-1.28 80.106667-21.333333 121.173334-10.666667a462.293333 462.293333 0 0 1-42.24 86.72c-45.76-13.76-85.973333 16.853333-128.746667 27.2-62.72 16.96-128.96 6.933333-191.68 23.466667-38.506667 10.133333-78.506667 9.386667-117.76 5.226666 0.96-4.906667 2.986667-14.72 3.946667-19.626666 64 12.48 128.853333-3.52 186.346666-32 48.106667 6.506667 57.92-60.373333 95.786667-76.053334 24.213333-3.946667 48.746667-2.56 73.173333-4.266666z" fill="#FEDA75" p-id="6287"></path><path d="M632.106667 610.346667c14.72-15.146667 45.973333-19.733333 56.853333 1.92 19.626667 40.106667-2.773333 86.08-33.173333 113.813333-4.48-1.92-13.333333-5.866667-17.813334-7.893333-81.066667-38.506667-180.16-35.733333-261.76-0.32-10.773333 6.4-21.12 13.546667-31.573333 20.48-24.853333-21.973333-61.013333-56.213333-36.906667-91.093334 38.293333 6.186667 74.773333 20.586667 113.173334 26.24 74.346667 2.773333 154.24-11.946667 211.2-63.146666z" fill="#7D180F" p-id="6288"></path><path d="M376.213333 717.866667c81.6-35.413333 180.693333-38.186667 261.76 0.32-31.573333 5.546667-63.466667 2.88-95.146666 0.64-55.466667-4.266667-111.146667 6.613333-166.613334-0.96z" fill="#E96E5E" p-id="6289"></path><path d="M344.64 738.346667c10.453333-6.933333 20.8-14.08 31.573333-20.48 55.466667 7.573333 111.146667-3.306667 166.613334 0.96 31.68 2.24 63.573333 4.906667 95.146666-0.64 4.48 2.026667 13.333333 5.973333 17.813334 7.893333-8.213333 7.573333-16.32 15.253333-24.533334 22.826667-22.293333-17.066667-51.52-0.96-76.586666-1.493334-63.04 10.986667-127.146667-12.586667-189.44 3.733334-7.04-4.053333-13.866667-8.32-20.586667-12.8z" fill="#E66142" p-id="6290"></path><path d="M554.666667 747.413333c25.066667 0.533333 54.293333-15.573333 76.586666 1.493334-57.493333 28.48-122.346667 44.48-186.346666 32-27.733333-6.506667-54.613333-16.32-79.68-29.76 62.293333-16.32 126.4 7.253333 189.44-3.733334z" fill="#DF4B18" p-id="6291"></path></svg>暂无评论，要不来一发？</span>'), _t('<svg t="1630049532386" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="15382" width="32" height="32"><path d="M873.78786 63.83998H150.21214c-70.873164 0-128.432091 57.820893-128.432091 128.791272v513.459235c0 70.970378 57.558927 128.690988 128.432091 128.791271h131.335211l39.341007 94.560656c5.605671 13.351076 16.617469 23.690562 30.431079 28.207435a48.729841 48.729841 0 0 0 15.516392 2.509147c8.908904 0 17.818831-2.408863 25.526373-7.127327l196.50242-118.150934h284.923238c70.873164 0 128.432091-57.820893 128.432091-128.791272V192.631252c0-71.070662-57.659211-128.791272-128.432091-128.791272zM276.401144 512c-35.244712 0-63.815421-28.571732-63.815421-63.815421 0-35.244712 28.570709-63.815421 63.815421-63.815421s63.815421 28.571732 63.815421 63.815421-28.570709 63.815421-63.815421 63.815421z m235.598856 0c-35.244712 0-63.815421-28.571732-63.815421-63.815421 0-35.244712 28.570709-63.815421 63.815421-63.815421s63.815421 28.571732 63.815421 63.815421-28.570709 63.815421-63.815421 63.815421z m235.598856 0c-35.244712 0-63.815421-28.571732-63.815421-63.815421 0-35.244712 28.570709-63.815421 63.815421-63.815421s63.815421 28.571732 63.815421 63.815421-28.570709 63.815421-63.815421 63.815421z" fill="#5F6379" p-id="15383"></path></svg>已有 %d 条评论')); ?></h3>

    <?php else: ?>
    <h3><?php _e('<div class="ui big label">评论已关闭</div>'); ?></h3></div>

<h3 class="ui header"><?php $this->commentsNum(_t(''), _t('<svg t="1630049532386" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="15382" width="32" height="32"><path d="M873.78786 63.83998H150.21214c-70.873164 0-128.432091 57.820893-128.432091 128.791272v513.459235c0 70.970378 57.558927 128.690988 128.432091 128.791271h131.335211l39.341007 94.560656c5.605671 13.351076 16.617469 23.690562 30.431079 28.207435a48.729841 48.729841 0 0 0 15.516392 2.509147c8.908904 0 17.818831-2.408863 25.526373-7.127327l196.50242-118.150934h284.923238c70.873164 0 128.432091-57.820893 128.432091-128.791272V192.631252c0-71.070662-57.659211-128.791272-128.432091-128.791272zM276.401144 512c-35.244712 0-63.815421-28.571732-63.815421-63.815421 0-35.244712 28.570709-63.815421 63.815421-63.815421s63.815421 28.571732 63.815421 63.815421-28.570709 63.815421-63.815421 63.815421z m235.598856 0c-35.244712 0-63.815421-28.571732-63.815421-63.815421 0-35.244712 28.570709-63.815421 63.815421-63.815421s63.815421 28.571732 63.815421 63.815421-28.570709 63.815421-63.815421 63.815421z m235.598856 0c-35.244712 0-63.815421-28.571732-63.815421-63.815421 0-35.244712 28.570709-63.815421 63.815421-63.815421s63.815421 28.571732 63.815421 63.815421-28.570709 63.815421-63.815421 63.815421z" fill="#5F6379" p-id="15383"></path></svg>已有 %d 条评论')); ?></h3>
    <?php endif; ?>
    
    	
    
    <?php $comments->listComments(); ?>

    <?php
      ob_start(); 
      $comments->pageNav('&laquo;','&raquo;', 1, '');
      $content = ob_get_contents();
      ob_end_clean();
      $content = preg_replace("/<ol class=\"(.*?)\">/sm", '<nav class="page-navigator">', $content);
      $content = preg_replace("/<li><span>(.*?)<\/span><\/li>/sm", '<span class="page-number">...</span>', $content);
      $content = preg_replace("/<li class=\"current\"><a href=\"(.*?)\">(.*?)<\/a><\/li>/sm", '<a class="page-number current" href="$1">$2</a>', $content);
      $content = preg_replace("/<li><a href=\"(.*?)\">(.*?)<\/a><\/li>/sm", '<a class="page-number" href="$1">$2</a>', $content);
       $content = preg_replace("/<li [class=\"prev\"]+><a href=\"(.*?)\">(.*?)<\/a><\/li>/sm", '<a class="extend prev" href="$1">上一页</a>', $content);
      $content = preg_replace("/<li [class=\"next\"]+><a href=\"(.*?)\">(.*?)<\/a><\/li>/sm", '<a class="extend next" href="$1">下一页</a>', $content);
      //适配旧版本
      $content = preg_replace("/<li class=\"current\"><a href=\"(.*?)\" >(.*?)<\/a><\/li>/sm", '<a class="page-number current" href="$1">$2</a>', $content);
      $content = preg_replace("/<li><a href=\"(.*?)\" >(.*?)<\/a><\/li>/sm", '<a class="page-number" href="$1">$2</a>', $content);
       $content = preg_replace("/<li [class=\"prev\"]+><a href=\"(.*?)\" >(.*?)<\/a><\/li>/sm", '<a class="extend prev" href="$1">上一页</a>', $content);
      $content = preg_replace("/<li [class=\"next\"]+><a href=\"(.*?)\" >(.*?)<\/a><\/li>/sm", '<a class="extend next" href="$1">下一页</a>', $content);
      ///--->
      $content = preg_replace("/<\/ol>/sm", '</nav>', $content);
      echo $content;
     ?>
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