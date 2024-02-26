<?php
    /**
    * 留言
    *
    * @package custom
    */
?>
<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('compoment/head.php');?>

<div class="pure-g" id="layout">
            <div class="pure-u-1 pure-u-md-<?php if(Bsoptions('site_style') == '1' || Bsoptions('site_style') == ''):?>3<?php endif;?><?php if(Bsoptions('site_style') == '2'):?>4<?php endif;?>-4">
                <div class="content_container">
               <?php if(Bsoptions('Diy') == true): ?><div class="ui <?php if(Bsoptions('postType') == "1"): ?>raised<?php endif; ?><?php if(Bsoptions('postType') == "2"): ?>stacked<?php endif; ?><?php if(Bsoptions('postType') == "3"): ?>tall stacked<?php endif; ?><?php if(Bsoptions('postType') == "4"): ?>piled<?php endif; ?> segment" <?php if(Bsoptions('postradius')): ?>style="border-radius:<?php echo Bsoptions('postradius'); ?>px"<?php endif; ?>><?php endif; ?>
                    <h2><i class="envelope outline icon"></i> <?php $this->title() ?></h2>
                    <?php
$parameter= array(
   'parentId'      => $this->hidden ? 0 : $this->cid,
   'parentContent' => $this->row,
   'respondId'     => $this->respondId,
   'commentPage'   => $this->request->filter('int')->commentPage,
   'allowComment'  => $this->allow('comment')
);
$this->widget('BearSimple_Widget_Comments_Archive',$parameter)->to($comments);
?>

<?php echo reEmoPost(ShortCode($this->content,$this,$this->user->hasLogin(),$this->fields->ArticleType)); ?>
<div id="comments-con">
  <div id="comments">
 
<?php if ($this->allow('comment') && Bsoptions('CommentClose') == true): ?>



       
        <div id="<?php $this->respondId(); ?>" class="respond">
            
                <?php $comments->cancelReply(); ?>
            

            <h3 id="response"><?php _e('我要评论'); ?><?php if(Bsoptions('Comment_tips') == true || Bsoptions('Comment_tips') == ''):?><span class="bstooltip bstooltip--right bstooltips--right" data-bstooltip="<?php if(Bsoptions('Comment_tips_text') == ''):?>本博客使用Cookie技术保留您的个人信息以方便您能够在下一次快速评论，继续评论表示您已同意该条款<?php else:?><?php echo Bsoptions('Comment_tips_text'); ?><?php endif; ?>"><i class="question circle outline icon"></i></span><?php endif; ?></h3>
            <form method="post" action="<?php editurl($this->commentUrl) ?>" id="commentform" role="form"  class="ui form">
<div id="forminput">
                <!-- 已登录 -->
                <?php if(Bsoptions('Comment_islogin') == true || Bsoptions('Comment_islogin') == ''):?>
                <div id="loginshowlabel" style="display:none">
                <div class="ui image label">
  <img src="<?php echo imgravatarq($this->user->mail); ?>">
  <name id="authorname"></name>
</div>
                   </div>
                    <?php endif; ?>
                <!-- 未登录 -->
  <div class="<?php if(Helper::options()->commentsRequireURL == true || Bsoptions('Comment_showmail') == true):?>three<?php else: ?>two<?php endif; ?> fields">
    <div class="field">
      <label class="required">您的昵称</label>
      <div class="ui icon input">
      <input type="text" name="author" id="author" placeholder="填写您的昵称" required>
      <i id="randname"  class="circular dice link icon"></i>
</div>
    </div>
    <?php if(Helper::options()->commentsRequireMail == true || Bsoptions('Comment_showmail') == false):?>
    <div class="field">
      <label <?php if(Helper::options()->commentsRequireMail == true):?>class="required"<?php endif; ?>>您的邮箱</label>
      <input type="email" name="mail" id="mail"   placeholder="填写您的电邮地址" <?php if(Helper::options()->commentsRequireMail == true):?>required<?php endif; ?>>
    </div>
    <?php endif; ?>
    <?php if(Helper::options()->commentsRequireMail == false && Bsoptions('Comment_showmail') == true):?>
    <div class="field" style="display:none;">
      <label class="required">您的邮箱</label>
      <input type="email" name="mail" id="mail"  placeholder="填写您的电邮地址" disabled="">
    </div>
    <?php endif; ?>
    <?php if(Helper::options()->commentsRequireURL == true || Bsoptions('Comment_showurl') == false):?>
    <div class="field">
      <label <?php if(Helper::options()->commentsRequireURL == true):?>class="required"<?php endif; ?>>您的博客网址</label>
      <input type="text" name="url" id="url" placeholder="填写您的博客网站网址" <?php if(Helper::options()->commentsRequireURL == true):?>required<?php endif; ?>>
    </div>
    <?php endif; ?>
    <?php if(Helper::options()->commentsRequireURL == false && Bsoptions('Comment_showurl') == true):?>
    <div class="field" style="display:none;">
      <label <?php if(Helper::options()->commentsRequireURL == true):?>class="required"<?php endif; ?>>您的博客网址</label>
      <input type="text" name="url" id="url" placeholder="填写您的博客网站网址" <?php if(Helper::options()->commentsRequireURL == true):?>required<?php endif; ?>>
    </div>
    <?php endif; ?>
  </div>
   <!-- end -->
   
  <div class="field">
      <label class="required">评论内容</label>
      
      <?php if(Bsoptions('Comment_private') == true):?>
      <div class="ui slider checkbox" style="margin:5px 0 7px 0">
  <input type="checkbox" name="privatecomment" id="privatecomment">
  <label>私密评论</label>

</div>
<?php endif; ?>
      <textarea name="text" id="textarea" <?php if(Bsoptions('Emoji') == true) :?>class="emotion"<?php endif; ?> placeholder="<?php if(Bsoptions('Comment_placeholder') == '') :?>嘿~ 大神，别默默的看了，快来点评一下吧<?php else:?><?php echo Bsoptions('Comment_placeholder'); ?><?php endif; ?>"><?php $this->remember('text'); ?></textarea>
    </div>
    <?php if(Bsoptions('Emoji') == true) :?>
    <div class="circular ui icon button" id="face">
  <i class="smile beam outline icon"></i>
 </div>
 <div class="ignore emoemo" style="margin-top:-7px;margin-bottom:6px" translate="no"></div>
 <?php endif; ?>
 <?php if(Bsoptions('CommentNotify__Open') == true) :?>
 <div class="ui checkbox" style="margin:-7px 0 5px 0">
  <input type="checkbox" name="accept">
  <label>不接收来自本博客的回复邮件</label>
</div>
<?php endif; ?>
<?php switch(Bsoptions('VerifyChoose')) :?>
<?php case '1' :?>
             <?php \BsCore\Plugin::spam_protection_mathjia();?>
             </div>
             <button type="button" id="commentsubmit" class="ui button" style="float:left;">
  提交留言
</button>
             <?php break; ?>
             <?php case '11' :?>
             <?php \BsCore\Plugin::spam_protection_mathjian();?>
             </div>
             <button  type="button" id="commentsubmit" class="ui button" style="float:left;">
  提交留言
</button>
             <?php break; ?>
              <?php case '22-2' :?>
             <?php \BsCore\Plugin::spam_protection_question();?>
             </div>
             <button  type="button" id="commentsubmit" class="ui button" style="float:left;">
  提交留言
</button>
             <?php break; ?>
             <?php case '2' :?>
             </div>
             
             <?php $this->need('modules/Verify/BearCaptcha/Vaptcha/Vaptcha.php'); ?>
<button type="button" id="commentsubmit" class="ui button" style="float:left;margin-top:5px" disabled="">
  提交留言
</button>
             <?php break; ?>
             <?php case '2-1' :?>
             </div>
             <?php $this->need('modules/Verify/BearCaptcha/Dingxiang/DX_Captcha.php'); ?>
<button type="button" id="commentsubmit" class="ui button" style="float:left;margin-top:5px" disabled="">
  提交留言
</button>
             <?php break; ?>
             <?php case '2-2' :?>
             </div>
             <?php $this->need('modules/Verify/BearCaptcha/Turnstile/Turnstile.php'); ?>
<button type="button" id="commentsubmit" class="ui button" style="float:left;margin-top:5px" disabled="">
  提交留言
</button>
             <?php break; ?>
              <?php case '2-3' :?>
             </div>
             <?php $this->need('modules/Verify/BearCaptcha/Geetest/Geetest.php'); ?>
<button type="button" id="commentsubmit" class="ui button" style="float:left;margin-top:5px" disabled="">
  提交留言
</button>
             <?php break; ?>
             <?php case '22' :?>
             </div>
             <p>
             <span class="ui button" id="bsverify" onclick="verify();" style="float:left;" disabled><i class="cloudversify icon"></i><?php if(empty(Bsoptions('Verify22_Buttontext'))){echo '人机验证';}else{
			echo Bsoptions('Verify22_Buttontext');}
			  ?></span>
	<button type="button" id="commentsubmit" class="ui button" style="float:left;" disabled="">
  提交留言
</button>
</p>
<?php $this->need('modules/Verify/BearCaptcha/Captcha/Captcha.php'); ?>
             <?php break; ?>
     <?php case '3' || '' :?>
     </div><p>
             <button type="button" id="commentsubmit" class="ui button" style="float:left;">
  提交留言
</button>
</p>
             <?php break; ?>
 <?php endswitch; ?>
            </form>
            <div style="height:30px"></div>
        </div>



    <?php else: ?>
   <center>
<h3 class="ui icon header">
<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="200" height="200" viewBox="0 0 480 480"><defs><linearGradient id="a" x1="0.5" y1="1" x2="0.564" gradientUnits="objectBoundingBox"><stop offset="0" stop-color="#e0e5ef" stop-opacity="0"/><stop offset="1" stop-color="#e0e5ef"/></linearGradient><linearGradient id="b" x1="0.5" x2="0.5" y2="1" gradientUnits="objectBoundingBox"><stop offset="0" stop-color="#d5d5d5"/><stop offset="1" stop-color="#6b6b6b" stop-opacity="0.059"/></linearGradient><linearGradient id="c" x1="0.222" y1="1.105" x2="0.681" y2="0.152" gradientUnits="objectBoundingBox"><stop offset="0" stop-color="#fff" stop-opacity="0"/><stop offset="1" stop-color="#909aa9"/></linearGradient><linearGradient id="d" x1="-0.392" y1="1.144" x2="0.636" y2="0.061" xlink:href="#c"/><linearGradient id="e" x1="0.027" y1="1.117" x2="0.736" y2="0.141" xlink:href="#c"/></defs><g transform="translate(-135 -375)"><ellipse cx="184" cy="184" rx="184" ry="184" transform="translate(191 431)" fill="#f3f3fa"/><path d="M112,259.243V96h64V259.243a187.037,187.037,0,0,1-64,0ZM0,192.931V0H88V253.371A184.268,184.268,0,0,1,0,192.931ZM208,24h96V169.434a184.369,184.369,0,0,1-96,81.193Z" transform="translate(230 536.999)" fill="url(#a)"/><g transform="translate(267.046 592.758) rotate(-25)"><rect width="156" height="200" rx="8" transform="translate(24 0)" fill="#78818e"/><path d="M8,0H144a8,8,0,0,1,8,8V192a8,8,0,0,1-8,8H8a8,8,0,0,1-8-8V8A8,8,0,0,1,8,0Z" transform="translate(24 0)" fill="#a1a7af"/><rect width="136" height="184" rx="4" transform="translate(32 8)" fill="#dae8e6"/><path d="M36,0H164a4.065,4.065,0,0,1,4,4.127c-7,174.567-15.744,174.717-15.744,174.717s-42.41.678-80.745-3.834A527.118,527.118,0,0,1-1.085,160.8S16,150.623,24,132.053s8-49.52,8-49.52V4.127A4.065,4.065,0,0,1,36,0Z" transform="translate(0 8)" fill="url(#b)"/><path d="M36,0H164a4,4,0,0,1,4,4c-7,169.209-11,171-11,171s-47.75-1.25-85-7A628,628,0,0,1,0,152a47.176,47.176,0,0,0,24-24c8-18,8-48,8-48V4A4,4,0,0,1,36,0Z" transform="translate(0 8)" fill="#fff"/><rect width="40" height="40" rx="2" transform="translate(48 40)" fill="#ebedf5"/><rect width="48" height="16" rx="2" transform="translate(104 40)" fill="#ebedf5"/><rect width="48" height="16" rx="2" transform="translate(104 64)" fill="#ebedf5"/><path d="M1,0S27,2,53,2s52-2,52-2l-1,12s-21.25,2-47,2S0,12,0,12Z" transform="translate(47 96)" fill="#ebedf5"/><path d="M2.5,0s14,2.438,40,2.75,63-1.5,63-1.5l-2,14S68,17.5,42.5,17.5,0,13.25,0,13.25Z" transform="translate(45.5 114.75)" fill="#ebedf5"/><path d="M4.5,0A254.823,254.823,0,0,0,40,3.333C60,3.833,108,2,108,2l-3,17s-38.417,2.75-65,2S0,16,0,16Z" transform="translate(40 136)" fill="#ebedf5"/></g><g transform="matrix(0.966, 0.259, -0.259, 0.966, 397.282, 500.051)"><rect width="6" height="32" rx="2" transform="translate(1)" fill="#b5b9be"/><rect width="6" height="32" rx="2" fill="#dddfe6"/></g><circle cx="1.5" cy="1.5" r="1.5" transform="translate(397 513.452)" fill="#909aa9"/><path d="M-3331,1132c188.947,26.75,289.45-16,289.45-16" transform="translate(3555.8 -620.625)" fill="none" stroke="#909aa9" stroke-linecap="round" stroke-width="2"/><g transform="translate(389 497.405)"><rect width="8" height="40" rx="2" transform="translate(1)" fill="#b5b9be"/><rect width="8" height="40" rx="2" fill="#cdd3df"/></g><g transform="matrix(0.839, 0.545, -0.545, 0.839, 437.927, -8.055)"><path d="M1585.106,53.028a7,7,0,0,1-6.618-4.723l-5.209-15.128a7,7,0,1,1,13.237-4.558l5.209,15.128a7,7,0,0,1-6.619,9.281ZM1580,28.462a2.5,2.5,0,1,0,2.5,2.5A2.5,2.5,0,0,0,1580,28.462Z" transform="translate(-1421.502 512.538)" fill="#909aa9"/><g transform="translate(145.469 536.589)"><path d="M21.951,107.445C7.073,105.525.152,97.989,0,87.2S3.6,54.89,6.22,41.423c1.093-6.458,1.453-6.148,0-6.02S0,31.09,1.866,26.884C2.356,23.48,5.5,23,7.535,23.056a4.1,4.1,0,0,1,.717-1.737s5.013-5.761,10.315-8.273a16.5,16.5,0,0,1,8.1-1.366,10.154,10.154,0,0,0,4.121-.409c2.8-1.181,2.558-2.36,4.769-2.8s10.6.936,11.317,10.872c.7,9.679-4.572,14.545-3.687,19.125.421,2.181.861,3.139,2.5,7.188A36.867,36.867,0,0,1,52.564,56.34c3.049,7.235,5.116,12.177,7.875,13.625s6.04,14.584-6.882,12.558l-.065-.011c5.463-1.532,1.439-.386,4.2,0,8.188.64,8.587,17.883,1,18.952-5.937,2.063-14.9,0-14.9,0v-1c-.04,1.317.078,1.422,0,2.1-.371,3.243-4.3,5.521-12.878,5.521A70.728,70.728,0,0,1,21.951,107.445ZM29.876,5.84A2.986,2.986,0,0,1,33.5,2.9S33.189-.785,36.876.153c4.25.875,2.25,8.625,2.25,8.625s-1.483.875-1.567.875C36.683,9.653,29.814,10.278,29.876,5.84Z" transform="translate(0 0)" fill="#909aa9" stroke="rgba(0,0,0,0)" stroke-width="1"/><g transform="translate(2.001 2.09)"><g transform="translate(40.489 44.55)"><path d="M.779,0A31.23,31.23,0,0,1,7.865,10.425c2.772,6.6,5.877,13.459,8.386,14.78S19.945,35.237,8.2,33.389.779,0,.779,0Z" fill="#fff"/><path d="M.293,0A32.341,32.341,0,0,1,7.246,16.851c.847,8.628,2.933,13.332,5.151,13.016a12.659,12.659,0,0,1-5.991-.025C2.891,29.071-1.127.113.293,0Z" transform="translate(1.438 2.659)" fill="url(#c)"/></g><path d="M40.077,87.626a34.415,34.415,0,0,0,14.137,1.09c6.9-.975,8.727-13.747-.647-15.059C46.3,72.636,47.541,61.489,46.2,51.224S39.641,32.376,38.837,28.2s4.251-9.233,3.614-18.062C41.8,1.07,36.15-.344,34.143.061s-3.609,2.392-6.154,3.47S21.7,2.858,16.878,5.149,7.5,12.7,7.5,12.7c-2.009,2.561.4,10.648-.938,14.691S-.132,66.612,0,76.45,6.429,93.165,19.954,94.917s19.419-.606,19.856-4.448c.279-2.443,1.905-11.053-7.8-12.535-4.83-.74-7.363-1.347-7.363-1.347" transform="translate(0 8.494)" fill="#fff"/><path d="M0,1.594S.961.016,1.726,0c1.313-.026,2.7,1.631,2.7,1.631S.043,3.365,0,1.594Z" transform="translate(32.843 8.554)" fill="#757f95"/><path d="M4.9.072C2.845-.464,2.622,2.158,2.622,2.158S-.268,1.844.02,3.9C.377,6.466,5.851,6.344,5.851,6.344S7.4.728,4.9.072Z" transform="translate(29.714 0)" fill="#757f95"/><path d="M6.817.178S.728-1.16.062,3.5,4.243,11,7.718,4.1" transform="translate(1.634 22.772)" fill="#fff"/><path d="M.411,0s-1.45,17.9,1.1,22.385c2.3,4.044,10.662,5.138,16.755,4.63a25.038,25.038,0,0,0,6.013-1.246c6.068-2.157,2.831-6.2,0-8.893S20.54,6.531,15.686,2.375" transform="translate(8.172 57.25)" fill="url(#d)"/><path d="M4.7,0A.6.6,0,0,0,4.18.31v0L4.17.322A4.814,4.814,0,0,1,.943,2.645l-.019,0,0,0a.6.6,0,0,0-.509.5l-.011,0L0,4.226s.341-.014.842-.088L.9,3.831l.11-.584v.865c.188-.031.389-.073.6-.121V3.243l.064.454.037.268A5.609,5.609,0,0,0,4.1,2.828,4.083,4.083,0,0,0,5.251.851C5.291.7,5.305.6,5.305.6A.6.6,0,0,0,4.7,0Z" transform="translate(17.708 16.722)" fill="#757f95"/><path d="M15.643,1.542c-3.6-3.507-6.766.555-6.766.555s-6.2-4.888-8.5.26c-2.873,6.422,11.8,16.794,11.8,16.794S19.326,5.132,15.643,1.542Z" transform="translate(27.658 57.366)" fill="url(#e)"/><path d="M0,0S5.02,15.274,7.571,19.76c3.236,5.688,9.468,8.51,15.533,6.355s2.831-5.527,0-8.223S19.03,6.1,14.175,1.947" transform="translate(8.621 56.615)" fill="#fff"/></g></g></g><g transform="translate(239.735 501.489)"><g transform="matrix(0.755, -0.656, 0.656, 0.755, 6.82, 4.592)"><rect width="6" height="32" rx="2" transform="translate(1)" fill="#b5b9be"/><rect width="6" height="32" rx="2" fill="#dddfe6"/></g><circle cx="1.5" cy="1.5" r="1.5" transform="translate(17.738 12.298) rotate(-56)" fill="#909aa9"/><g transform="translate(0 9.983) rotate(-56)"><rect width="8" height="40" rx="2" transform="translate(1)" fill="#b5b9be"/><rect width="8" height="40" rx="2" fill="#cdd3df"/></g></g><g transform="translate(359.323 650.849) rotate(-47)"><rect width="68.62" height="15.248" transform="translate(4.222 26.682)" fill="#ffcc43"/><rect width="68.616" height="15.248" transform="translate(45.744) rotate(90)" fill="#ffcc43"/></g><path d="M134.011,161.88l-6.667,23.833,8.833,8.667,25.5-5.833,28.738-30.229L164.264,131.88Z" transform="translate(300.156 434.287)" fill="#78818e"/><path d="M135.344,155.3l-6.5,23.845,4.286,4.143,24.214-5.488,25.333-25.583L160.511,129.88Z" transform="translate(302.156 442.287)" fill="#e5e2e2"/><path d="M182.7,150.552l4.6-4.6a6.537,6.537,0,0,0,0-9.192l-13.148-13.148a6.537,6.537,0,0,0-9.192,0l-4.6,4.6Zm-18.983-14.068,10.671,10.671,5.835,5.835-22.74,22.74c-5.4,1.159-6.554-1.479-5.835-5.835-5.475-.759-9.552-3.2-10.511-9.432L156.487,145.6l-1.4-1.4-15.746,15.266c-3.956.32-4.8-2.238-4.2-6.075l22.74-22.74Z" transform="translate(302.156 444.132)" fill="#909aa9"/><path d="M182.7,150.552l4.6-4.6a6.537,6.537,0,0,0,0-9.192l-13.148-13.148a6.537,6.537,0,0,0-9.192,0l-4.6,4.6Z" transform="translate(302.156 444.067)" fill="#78818e"/><path d="M131.844,167.63l-3.332,11.577,4.476,4.476,12.356-2.8Z" transform="translate(302.156 442.287)" fill="#78818e"/><path d="M186.977,155.3l5.475-5.353a7.493,7.493,0,0,0,0-10.706l-15.663-15.314a7.914,7.914,0,0,0-10.95,0l-5.475,5.353Z" transform="translate(299.156 441.701)" fill="#78818e"/><path d="M182.7,150.552l4.6-4.6a6.537,6.537,0,0,0,0-9.192l-13.148-13.148a6.537,6.537,0,0,0-9.192,0l-4.6,4.6Z" transform="translate(301.156 444.995)" fill="#a1a7af"/></g></svg>
  <div class="content">
    啊哦，评论功能已关闭～
  </div>
</h3>
    </center>
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
       $content = preg_replace("/<li [class=\"prev\"]+><a href=\"(.*?)\">(.*?)<\/a><\/li>/sm", '<a class="extend prev" href="$1"><i class="arrow left icon"></i>上一页</a>', $content);
      $content = preg_replace("/<li [class=\"next\"]+><a href=\"(.*?)\">(.*?)<\/a><\/li>/sm", '<a class="extend next" href="$1"><i class="arrow right icon"></i>下一页</a>', $content);
      //适配旧版本
      $content = preg_replace("/<li class=\"current\"><a href=\"(.*?)\" >(.*?)<\/a><\/li>/sm", '<a class="page-number current" href="$1">$2</a>', $content);
      $content = preg_replace("/<li><a href=\"(.*?)\" >(.*?)<\/a><\/li>/sm", '<a class="page-number" href="$1">$2</a>', $content);
      $content = preg_replace("/<li [class=\"prev\"]+><a href=\"(.*?)\">(.*?)<\/a><\/li>/sm", '<a class="extend prev" href="$1"><i class="arrow left icon"></i>上一页</a>', $content);
      $content = preg_replace("/<li [class=\"next\"]+><a href=\"(.*?)\">(.*?)<\/a><\/li>/sm", '<a class="extend next" href="$1"><i class="arrow right icon"></i>下一页</a>', $content);
      ///--->
      $content = preg_replace("/<\/ol>/sm", '</nav>', $content);
      }
      if(empty(Bsoptions('pagination_style ')) || Bsoptions('pagination_style') == '1'){
      $content = preg_replace("/<ol class=\"(.*?)\">/sm", '<div class="ui labels" style="margin-top:30px"><div style="text-align:center">', $content);
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
</div></div></div></div>
<?php if(Bsoptions('Diy') == true): ?></div><?php endif; ?>
<script>
function getCookie(name){
    const strcookie = document.cookie;
    const arrcookie = strcookie.split("; ");
    for (let i = 0; i < arrcookie.length; i++) {
        const arr = arrcookie[i].split("=");
        if (arr[0] === name){
            return arr[1];
        }
    }
    return "";
}
function getCommentInfo(){
    let nick = document.getElementById('author');
    let mail = document.getElementById('mail');
    let url = document.getElementById('url');
    let nick_value = decodeURIComponent(getCookie('<?php echo Typecho_Cookie::getPrefix()?>__typecho_remember_author'));
    let mail_value = decodeURIComponent(getCookie('<?php echo Typecho_Cookie::getPrefix()?>__typecho_remember_mail'));
    let url_value = decodeURIComponent(getCookie('<?php echo Typecho_Cookie::getPrefix()?>__typecho_remember_url'));
    if (nick && nick_value!== 'null') nick.value = nick_value;
    if (mail && mail_value!== 'null') mail.value = mail_value;
    if (url && url_value!== 'null') url.value = url_value;
    $.post('<?php getIsLogin(); ?>',{action:'find'},function (res) {
        res = JSON.parse(res);
        switch(res.code){
            case 0 :
        $('#loginshowlabel').hide();
    $('#nologinshow').show();
    break;
    case 1 :
        $('#loginshowlabel').show();
    $('#nologinshow').hide();
    $('#authorname').html(res.name);
    break;
        }
    });
     $.post('<?php getCommentAction(); ?>',{action:'getCommentToken'},function (res) {
         res = JSON.parse(res);
         if(res.code == 1){
        var tokenInput=$("<input type=\"hidden\" name=\"SecurityToken\"  id=\"SecurityToken\">");
tokenInput.attr("value", res.token);
$("#commentform").append(tokenInput);
         }
    })
}
getCommentInfo();
</script>
<?php $this->need('compoment/sidebar.php'); ?>
<?php $this->need('compoment/foot.php'); ?>