<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; 
$parameter= array(
   'parentId'      => $this->hidden ? 0 : $this->cid,
   'parentContent' => $this->row,
   'respondId'     => $this->respondId,
   'commentPage'   => $this->request->filter('int')->commentPage,
   'allowComment'  => $this->allow('comment')
);
$this->widget('BearSimple_Widget_Comments_Archive',$parameter)->to($comments);
?>
<?php if(Bsoptions('Emoji') == true) :?>
<link href="<?php AssetsDir();?>assets/vendors/bs-emoji/bs-emoji.css" rel="stylesheet" type="text/css">
<?php endif; ?>
<h3 class="ui header">

  <i class="comment alternate outline icon"></i>评论区(<?php $this->commentsNum(_t('暂无评论'), _t('1条评论'), _t('%d条评论')); ?>)
</h3>
  <div id="comments">
 
<?php if ($this->allow('comment') && Bsoptions('CommentClose') == true): ?>
        <div id="<?php $this->respondId(); ?>" class="respond">
            
                <?php $comments->cancelReply(); ?>
            

            <h3 id="response"><?php _e('我要评论'); ?></h3>
            <form method="post" action="<?php $this->commentUrl() ?>" id="commentform" role="form"  class="ui form">
                <div id="forminput">
                <?php if ($this->user->hasLogin()): ?><p>
                <div class="ui image label">
  <img src="<?php echo imgravatarq($this->user->mail); ?>">
  <a href="<?php $this->options->profileUrl(); ?>" target="_blank"><?php $this->user->screenName(); ?>
  </a>
  <a class="detail" href="<?php $this->options->logoutUrl(); ?>" target="_blank">退出登录</a>
</div>
                    </p>
                <?php else: ?>
                
  <div class="<?php if(Helper::options()->commentsRequireURL == true || Bsoptions('Comment_showmail') == true):?>three<?php else: ?>two<?php endif; ?> fields">
    <div class="field">
      <label class="required">您的昵称</label>
      <div class="ui icon input">
      <input type="text" name="author" id="author" value="<?php $this->remember('author'); ?>" placeholder="填写您的昵称" required>
      <i id="randname"  class="circular dice link icon"></i>
</div>
    </div>
    <?php if(Helper::options()->commentsRequireMail == true || Bsoptions('Comment_showmail') == true):?>
    <div class="field">
      <label <?php if(Helper::options()->commentsRequireMail == true):?>class="required"<?php endif; ?>>您的邮箱</label>
      <input type="email" name="mail" id="mail"  value="<?php $this->remember('mail'); ?>" placeholder="填写您的电邮地址" <?php if(Helper::options()->commentsRequireMail == true):?>required<?php endif; ?>>
    </div>
    <?php else:?>
    <div class="field" style="display:none;">
      <label class="required">您的邮箱</label>
      <input type="email" name="mail" id="mail"  value="<?php $this->remember('mail'); ?>" placeholder="填写您的电邮地址" disabled="">
    </div>
    <?php endif; ?>
    <div class="field">
      <label <?php if(Helper::options()->commentsRequireURL == true):?>class="required"<?php endif; ?>>您的博客网址</label>
      <input type="text" name="url" id="url" placeholder="填写您的博客网站网址" value="https://" <?php if(Helper::options()->commentsRequireURL == true):?>required<?php endif; ?>>
    </div>
    
  </div>
   <?php endif; ?>
   
  <div class="field">
      <label class="required">评论内容</label>
      <?php if(Bsoptions('Comment_private') == true):?>
      <div class="ui slider checkbox" style="margin:5px 0 7px 0">
  <input type="checkbox" name="privatecomment" id="privatecomment">
  <label>私密评论</label>
</div>
<?php endif; ?>
      <textarea name="text" id="textarea" <?php if(Bsoptions('Emoji') == true) :?>class="emotion"<?php endif; ?> placeholder="嘿~ 大神，别默默的看了，快来点评一下吧"><?php $this->remember('text'); ?></textarea>
    </div>
    <?php if(Bsoptions('Emoji') == true) :?>
    <div class="circular ui icon button" id="face">
  <i class="smile beam outline icon"></i>
 </div>
 <div id="emoemo" style="margin-top:-7px;margin-bottom:6px" translate="no"></div>
 <?php endif; ?>
 
<?php switch(Bsoptions('VerifyChoose')) :?>
<?php case '1' :?>
             <?php spam_protection_mathjia();?>
             </div>
             <button type="button" id="commentsubmit" class="ui button" style="float:left;">
  提交评论
</button>
             <?php break; ?>
             <?php case '11' :?>
             <?php spam_protection_mathjian();?>
             </div>
             <button  type="button" id="commentsubmit" class="ui button" style="float:left;">
  提交评论
</button>
             <?php break; ?>
             
             <?php case '2' :?>
             </div>
             
             <?php $this->need('modules/Verify/BearCaptcha/Vaptcha/Vaptcha.php'); ?>
<button type="button" id="commentsubmit" class="ui button" style="float:left;margin-top:5px" disabled="">
  提交评论
</button>
             <?php break; ?>
             <?php case '2-1' :?>
             </div>
             <?php $this->need('modules/Verify/BearCaptcha/Dingxiang/DX_Captcha.php'); ?>
<button type="button" id="commentsubmit" class="ui button" style="float:left;margin-top:5px" disabled="">
  提交评论
</button>
             <?php break; ?>
             <?php case '22' :?>
             </div>
             <span class="ui button" id="bsverify" onclick="verify();" style="float:left;" disabled><i class="cloudversify icon"></i><?php if(empty(Bsoptions('Verify22_Buttontext'))){echo '人机验证';}else{
			echo Bsoptions('Verify22_Buttontext');}
			  ?></span>
	<button type="button" id="commentsubmit" class="ui button" style="float:left;" disabled="">
  提交评论
</button>
<?php $this->need('modules/Verify/BearCaptcha/Captcha/Captcha.php'); ?>
             <?php break; ?>
     <?php case '3' || '' :?>
     </div>
             <button type="button" id="commentsubmit" class="ui button" style="float:left;">
  提交评论
</button>
             <?php break; ?>
 <?php endswitch; ?>
 
            </form>
            <div style="height:30px"></div>
        </div>



    <?php else: ?>
    <center><br>
<h2 class="ui icon header">
  <em data-emoji=":anguished:" class="medium"></em>
  <div class="content" style="margin-top:5px">
    啊哦，评论功能已关闭～
  </div>
</h2></center>
    <?php endif; ?>
    
          <div id="bscommen"> 
     <?php if ($comments->have()): ?>    
    <br>
    
     <?php
      ob_start();
   $comments->listComments();
   $comments_content = ob_get_contents();
      ob_end_clean();
   $comments_content = preg_replace("/<ol class=\"comment-list\">/sm", '', $comments_content);
   $comments_content = preg_replace("/<\/ol>/sm", '', $comments_content);
   echo $comments_content;
   ?>


    <?php

      ob_start(); 

      $comments->pageNav('&laquo;','&raquo;', 1, '');
      $content = ob_get_contents();
      ob_end_clean();
      if(Bsoptions('pagination_style')== '2'){
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
      }
      if(empty(Bsoptions('pagination_style ')) || Bsoptions('pagination_style') == '1'){
      $content = preg_replace("/<ol class=\"(.*?)\">/sm", '<div class="ui circular labels" style="margin-top:30px"><div style="text-align:center">', $content);
      $content = preg_replace("/<li><span>(.*?)<\/span><\/li>/sm", '<a class="ui large label">...</a>', $content);
      $content = preg_replace("/<li class=\"current\"><a href=\"(.*?)\">(.*?)<\/a><\/li>/sm", '<a class="ui black large label" href="$1">$2</a>', $content);
      $content = preg_replace("/<li><a href=\"(.*?)\">(.*?)<\/a><\/li>/sm", '<a class="ui large label" href="$1">$2</a>', $content);
       $content = preg_replace("/<li [class=\"prev\"]+><a href=\"(.*?)\">(.*?)<\/a><\/li>/sm", '<a class="ui large label" href="$1">上一页</a>', $content);
      $content = preg_replace("/<li [class=\"next\"]+><a href=\"(.*?)\">(.*?)<\/a><\/li>/sm", '<a class="ui large label" style="margin-top:5px" href="$1">下一页</a>', $content);
      //旧版本兼容
      $content = preg_replace("/<li class=\"current\"><a href=\"(.*?)\" >(.*?)<\/a><\/li>/sm", '<a class="ui black large label" href="$1">$2</a>', $content);
      $content = preg_replace("/<li><a href=\"(.*?)\" >(.*?)<\/a><\/li>/sm", '<a class="ui large label" href="$1">$2</a>', $content);
       $content = preg_replace("/<li [class=\"prev\"]+><a href=\"(.*?)\" >(.*?)<\/a><\/li>/sm", '<a class="ui large label" href="$1">上一页</a>', $content);
      $content = preg_replace("/<li [class=\"next\"]+><a href=\"(.*?)\" >(.*?)<\/a><\/li>/sm", '<a class="ui large label" style="margin-top:5px" href="$1">下一页</a>', $content);
      
      $content = preg_replace("/<\/ol>/sm", '</div></div>', $content);
      }
      echo $content;
     ?>

    <?php endif; ?>
    </div>
    
</div>
</div></div>
