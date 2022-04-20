<?php if($this->options->Scroll == '1'): ?>
<?php if(strpos($this->content,'h2') !== false): ?>
<div class="bs-scrollnav-v" id="article-nav" style="background-color: rgba(255,255,255,.9);border: 1px solid #ebebeb;"><bsnav class="bs-close ax-iconfont ax-icon-arrow-right"></bsnav></div>
<?php endif; ?>
<?php endif; ?>
<?php if($this->options->Readmode == "1"): ?> 

<?php echo readModeContent($this,ShortCode($this->content,$this,$this->user->hasLogin(),'readmode')); ?>

<?php endif; ?>
<?php if($this->options->Animate == "close" || $this->options->Animate == null): ?> 
 <div class="pure-g" id="layout">
    <?php else: ?>
  <div class="pure-g animate__animated animate__<?php $this->options->Animate() ?>" id="layout">
        <?php endif; ?>
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
              <h1 class="post-title" style="word-wrap:break-word;overflow:hidden;"><?php $this->title() ?></h1>
<div class="post-meta"><time datetime="<?php $this->date('c'); ?>" itemprop="datePublished"><?php $this->date(); ?></time><?php if($this->fields->Hot == '1'): ?> | <span><i class="hotjar icon"></i>热度:<?php _e(getViewsStr($this));?>°C</span><?php endif; ?> | <button class="ui mini gray icon button" id="fontsizes"><i class="font icon"></i></button><?php if($this->options->Readmode == "1"): ?><button class="ui mini gray icon button" id="read"><i class="book icon"></i></button><?php endif; ?><?php if($this->user->group == 'administrator'): ?>|  <button onclick="window.open('<?php $this->options->adminUrl('/write-page.php?cid='.$this->cid); ?>','_self')" class="ui mini gray icon button"><i class="pencil icon"></i></button><?php endif; ?><?php if($this->options->Poster == '1' && $this->fields->Poster == '1'): ?>| <button href="#" onclick="show_bearstudio_poster_ykzn();return false;" class="ui mini gray icon button">生成微海报</button><?php endif; ?></div>
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
<?php endif; ?>
<p>
<?php if($this->hidden||$this->titleshow): ?>
    <bearsimple id="bearsimple-images"></bearsimple>
 <bearsimple id="bearsimple-images-readmode"></bearsimple>
<form action="<?php echo Typecho_Widget::widget('Widget_Security')->getTokenUrl($this->permalink); ?>" method="post" id="form">
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
  <button class="ui blue submit button" type="submit">提交</button>
</div>
</form>
<?php else: ?>
<?php echo ShortCode($this->content,$this,$this->user->hasLogin()); ?>
<?php endif;?></p></div></div> </div>
    
    
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

<?php article_module_output($this); ?>
</div>
    <?php $this->need('comments.php'); ?>
<?php if($this->options->Poster == '1' && $this->fields->Poster == '1'): ?>
<?php $this->need('modules/MakePost/poster.php'); ?>
<?php endif; ?>