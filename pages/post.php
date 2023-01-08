<script>
    var BsTocPostDate = "<?php $this->date("Y-m-d H:m"); ?>";
    var BsTocPostTitle = "<?php $this->title() ?>";
    var Permalink = "<?php $this->permalink(); ?>";
</script>

<?php if(Bsoptions('Readmode') == true): ?> 
 
<?php echo readModeContent($this,reEmoPost(ShortCode($this->content,$this,$this->user->hasLogin(),$this->fields->ArticleType,'readmode'))); ?>
<?php endif; ?>
<div class="pure-g" id="layout">
      <div class="pure-u-1 pure-u-md-3-4">
             <div class="content_container">
<div id="bearsimple-scroll">
          <div class="post">
               <?php if($this->fields->articleplo !== '1'): ?>
              <?php if($this->fields->articleplo == '2' && $this->fields->articleplo !== null): ?>
              <div class="ui top attached label"><h4><?php $this->fields->articleplonr() ?> </h4></div>
              <?php endif; ?>
              <?php if($this->fields->articleplo == '3' && $this->fields->articleplo !== null): ?>
              <div class="ui top left attached label"><h4><?php $this->fields->articleplonr() ?> </h4></div>
              <?php endif; ?>
              <?php if($this->fields->articleplo == '4' && $this->fields->articleplo !== null): ?>
              <div class="ui top right attached label"><h4><?php $this->fields->articleplonr() ?> </h4></div>
              <?php endif; ?>
              <?php endif; ?>

              <h1  class="post-title" style="word-wrap:break-word;overflow:hidden;"><?php $this->title() ?></h1>

<div class="post-meta"><i class="time outline icon"></i><time datetime="<?php $this->date('c'); ?>" itemprop="datePublished"><?php $this->date(); ?></time><span> | </span><i class="folder open outline icon"></i><span class="category"><?php $this->category(','); ?></span><?php if($this->fields->Hot == '1'): ?> | <span><i class="hotjar icon" data-scid="<?php echo $this->cid; ?>"></i>热度:<?php _e(getViewsStr($this));?>°C</span><?php endif; ?> | <button class="ui mini gray icon button" id="fontsizes"><i class="font icon"></i></button><?php if(Bsoptions('Readmode') == true): ?><button class="ui mini gray icon button" id="read"><i class="book icon"></i></button><?php endif; ?><?php if($this->user->group == 'administrator'): ?>|  <button onclick="window.open('<?php $this->options->adminUrl('/write-post.php?cid='.$this->cid); ?>','_self')" class="ui mini gray icon button"><i class="pencil icon"></i></button><?php endif; ?><?php if(Bsoptions('Poster') == true && $this->fields->Poster == '1'): ?>| <button class="ui mini gray icon button" data-event="poster-popover" id="poster-btn">生成微海报</button><?php endif; ?></div>
<a style="float:right" href="#comments"><i class="comment alternate outline icon"></i></a>
<div class="post-content"><div id="para">
<?php if ($this->fields->Overdue && $this->fields->Overdue !== 'close' && floor((time() - ($this->modified)) / 86400) > $this->fields->Overdue) : ?>
<div class="ui warning icon message">
  <i class="exclamation circle loading icon"></i>
  <div class="content">
    <div class="header">
温馨提示：</div>
 <p>
本文最后更新于<?php echo date('Y年m月d日' , $this->modified);?>，已超过<?php echo floor((time()-($this->modified))/86400);?>天没有更新，若内容或图片失效，请留言反馈。
 </p>
 </div>
</div>
<?php endif;?>
<p>
                   
<?php if($this->hidden): ?>
    <bearsimple id="bearsimple-images"></bearsimple>
 <bearsimple id="bearsimple-images-readmode"></bearsimple>
<form action="<?php echo Typecho_Widget::widget('Widget_Security')->getTokenUrl($this->permalink); ?>" method="post" id="form" >
<div class="ui form warning">
  <div class="field">
    <label>本文已设定密码保护，请输入密码访问</label>
    <input type="password" class="text" name="protectPassword" id="protectPassword" placeholder="请输入文章密码">
    <input type="hidden" name="protectCID" value="<?php $this->cid(); ?>" />
  </div>
  <div class="ui warning message">
    <div class="header">Tips:</div>
    <ul class="list">
      <li>请不要随意多次尝试,否则可能触发本站自我保护机制~</li>
    </ul>
  </div>
  <button class="ui blue submit button" id="protectajax" type="button">提交</button>
</div>
</form>
<?php else: ?>
              <a id="bs_toc_begin"></a> 
                <div id="bs_toc_body">

<?php if(Bsoptions('pageContent') == true): ?> 
<?php echo BsCore_Plugin::parseContent($this,$this->user->hasLogin(),$this->remember('mail', true),reEmoPost(ShortCode($this->content,$this,$this->user->hasLogin(),$this->fields->ArticleType))); ?>
<?php else:?>

<?php echo reEmoPost(ShortCode($this->content,$this,$this->user->hasLogin(),$this->fields->ArticleType)); ?>
<?php endif;?>
</div>


            
        	
<?php endif;?>
</p></div></div> </div>

    <?php if($this->fields->tags == '1'): ?><br>
<div class="ui tag label"><font color="gray">标签:</font><?php $this->tags('  ', true, '暂无标签'); ?></div>
 <?php endif;?>
 <?php if($this->fields->copyright == '1'): ?>

<div class="ui icon message">
  <i class="copyright outline icon"></i>
  <div class="content">
    <div class="header" style="word-break:break-all;">
      版权属于：<?php $this->author() ?> 所有，<?php if($this->fields->copyright_cc !== null && $this->fields->copyright_cc !== 'zero') :?>采用《<?php echo copyright_cc($this->fields->copyright_cc);?>》进行许可，<?php endif; ?>转载请注明文章来源。
    </div>
    <p style="word-break:break-all;">本文链接： <a href="<?php $this->permalink() ?>"><?php $this->permalink() ?></a></p>
  </div>
</div>
<?php endif; ?>
<?php if(Bsoptions('history_Today') == true): ?> 
<?php historyToday($this->created)?>
    <?php endif; ?>
<div class="ui divided selection list">
    <div class="item">
    <div class="ui horizontal label">上一篇</div>
    <?php $this->thePrev('%s','没有了'); ?>
 </div>
   <div class="item">
    <div class="ui horizontal label">下一篇</div>
    <?php $this->theNext('%s','没有了'); ?>
  </div>
</div>

<?php article_module_output($this); ?>
<?php if(Bsoptions('Poster') == true && $this->fields->Poster == '1'): ?>
<?php poster_inx($this->cid,$this->content,$this->fields->excerpt,'1'); ?>
<script>

			window.poster_info={
				bgimgurl   : "<?php AssetsDir(); ?>assets/vendors/bs-poster/static/images/xuxian.png",
				post_title : "<?php $this->title(); ?>",
				logo_pure  : "<?php echo Bsoptions('Poster__LogoUrl'); ?>",
				att_img    : "<?php echo thumb3($this); ?>",
				excerpt    : "<?php echo poster_inx($this->cid,$this->content,$this->fields->excerpt,'2'); ?>",
				author     : "<?php $this->author(); ?>",
				cat_name   : "<?php $this->category(',',false); ?>",
				time_y_m   : "<?php $this->date('Y年m月'); ?>",
				time_d     : "<?php $this->date('d日'); ?>",
				site_motto : "<?php echo Bsoptions('Poster__SiteDec'); ?>",
			};
		</script>
<?php endif; ?>
</div>

<?php if(!$this->hidden): ?>
    <?php $this->need('comments.php'); ?>
<?php else:?>
<center><br>
<h2 class="ui icon header">
  <em data-emoji=":face_with_spiral_eyes:" class="medium"></em>
  <div class="content" style="margin-top:5px">
    评论区已被封印~
  </div>
</h2></center>
</div></div>
<?php endif; ?>
