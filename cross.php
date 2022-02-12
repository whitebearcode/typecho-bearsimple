<?php
    /**
    * 时光机[微语]
    *
    * @package custom
    */
?>
<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>
 <bearsimple id="bearsimple-images-readmode"></bearsimple>
<bearsimple id="bearsimple-images"></bearsimple>
<?php if($this->options->Animate == "close" || $this->options->Animate == null): ?>
 <div class="pure-g" id="layout">
    <?php else: ?>
  <div class="pure-g animate__animated animate__<?php $this->options->Animate() ?>" id="layout">
        <?php endif; ?>
            <div class="pure-u-1 pure-u-md-3-4">
                <div class="content_container">
               <?php if($this->options->Diy == "1"): ?><div class="ui <?php if($this->options->postType == "1"): ?>raised<?php endif; ?><?php if($this->options->postType == "2"): ?>stacked<?php endif; ?><?php if($this->options->postType == "3"): ?>tall stacked<?php endif; ?><?php if($this->options->postType == "4"): ?>piled<?php endif; ?> divided items segment" <?php if($this->options->postradius): ?>style="border-radius:<? $this->options->postradius(); ?>px"<?php endif; ?>><?php endif; ?>
                    <h2><i class="hourglass half icon"></i> <?php $this->title() ?></h2><br>
                    <?php Typecho_Widget::widget('Widget_Stat')->to($stat); ?>

<div class="ui three statistics">
  <div class="statistic" style="margin-left:auto;margin-right:auto">
    <div class="value">
      <?php if($stat->publishedPostsNum > '999'){echo '999+';}else{echo $stat->publishedPostsNum();} ?>
    </div>
    <div class="label">
      篇文章
    </div>
  </div>
  <div class="statistic" style="margin-left:auto;margin-right:auto">
    <div class="value">
     <?php if($stat->publishedCommentsNum - $this->commentsNum> '999'){echo '999+';}else{echo $stat->publishedCommentsNum - $this->commentsNum;} ?>
    </div>
    <div class="label">
      条评论
    </div>
  </div>
  <div class="statistic" style="margin-left:auto;margin-right:auto">
    <div class="value">
      <?php if($this->commentsNum > '999'){echo '999+';}else{echo $this->commentsNum;} ?>
    </div>
    <div class="label">
      条动态
    </div>
  </div>
 
</div>

<center><button class="ui primary icon button" style="margin-top:20px"><i class="level down alternate icon"></i>我的动态</button><?php if($this->user->hasLogin()):?><button id="say" class="ui icon button" style="margin-top:20px"><i class="location arrow icon"></i>我要发动态</button><?php endif; ?></center>

<?php $this->need('cross-says.php'); ?>

</div></div>

<?php if($this->options->Diy == "1"): ?></div><?php endif; ?>
<?php if($this->is('page')):?>
<script>
    jQuery(document).ready(function($){
 $('#say').on('click', function () {   
     $('#comments').fadeIn();
 });
	var $timeline_block = $('.bs-timeline-block');

	$timeline_block.each(function(){
		if($(this).offset().top > $(window).scrollTop()+$(window).height()*0.75) {
			$(this).find('.bs-timeline-img, .bs-timeline-content').addClass('is-hidden');
		}
	});

	$(window).on('scroll', function(){
		$timeline_block.each(function(){
			if( $(this).offset().top <= $(window).scrollTop()+$(window).height()*0.75 && $(this).find('.bs-timeline-img').hasClass('is-hidden') ) {
				$(this).find('.bs-timeline-img, .bs-timeline-content').removeClass('is-hidden').addClass('bounce-in');
			}
		});
	});
});
</script>
<?php endif; ?>
<?php $this->need('sidebar.php'); ?>

<?php $this->need('footer.php'); ?>