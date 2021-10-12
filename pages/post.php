<?php if($this->options->Scroll == '1'): ?>
<?php if(strpos($this->content,'h2') !== false): ?>
<div class="ax-scrollnav-v" id="article-nav" style="background-color: rgba(255,255,255,.9);border: 1px solid #ebebeb;"><a href="##" class="ax-close ax-iconfont ax-icon-arrow-right"></a></div>
<?php endif; ?>
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
<div class="post-meta"><time datetime="<?php $this->date('c'); ?>" itemprop="datePublished"><?php $this->date(); ?></time><span> | </span><span class="category"><?php $this->category(','); ?></span><?php if($this->fields->Hot == '1'): ?> | </span><span><i class="hotjar icon"></i>热度:<?php _e(getViewsStr($this));?>°C</span><?php endif; ?> | <span class="ui mini gray icon button" size="bigger" >A+</span><span class="ui mini gray icon button" size="smaller" >A-</span><?php if($this->user->group == 'administrator'): ?>|  <a href="<?php $this->options->adminUrl('/write-post.php?cid='.$this->cid); ?>" class="ui mini gray icon button"><i class="pencil icon"></i></a><?php endif; ?><?php if($this->options->Poster == '1' && $this->fields->Poster == '1'): ?>| <a href="#" onclick="show_bearstudio_poster_ykzn();return false;" class="ui mini gray icon button">生成微海报</a><?php endif; ?> </div>
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
    <br>
    <?php if($this->fields->tags == '1'): ?>
<div class="ui tag label"><font color="gray">标签:</font><?php $this->tags('  ', true, '暂无标签'); ?></div>
 <?php endif;?>
 <?php if($this->fields->copyright == '1'): ?>
<br>  <br>
<div class="ui icon message">
  <i class="copyright outline icon"></i>
  <div class="content">
    <div class="header" style="word-break:break-word;">
      版权属于：<?php echo $this->author() ?> 所有，转载请注明文章来源。
    </div>
    <p style="word-break:break-word;">本文链接： <?php echo $this->permalink() ?></p>
  </div>
</div>
<?php endif; ?>
<br>
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
<?php if($this->options->Share == '1'): ?>
<link rel="stylesheet" type="text/css" href="/usr/themes/bearsimple/assets/share/share.min.css"/>
 <div style="transform:translateY(100%);-ms-transform:translateY(100%);-webkit-transform:translateY(100%);text-align:center;" id="share" data-sites="<?php $this->need('modules/share.php'); ?>"></div>
<br>
<br>
<br>
 <?php endif;?>
<?php if($this->options->RewardOpen == '1'): ?><br><br>
 <div id="donate"><link rel="stylesheet" type="text/css" href="/usr/themes/bearsimple/assets/css/donate.css"><script type="text/javascript" src="/usr/themes/bearsimple/assets/javascript/donate.js" successtext="复制成功!"></script><div id="DonateText">打赏一下</div><ul class="list pos-f" id="donateBox"><?php if($this->options->RewardOpenPaypal == '1'): ?><li id="PayPal"><a href="<?php $this->options->RewardOpenPaypalText() ?>" target="_blank"></a></li><?php endif;?><?php if($this->options->RewardOpenAlipay == '1'): ?><li id="AliPay" qr="<?php $this->options->RewardOpenAlipayText() ?>"></li><?php endif;?><?php if($this->options->RewardOpenWechat == '1'): ?><li id="WeChat" qr="<?php $this->options->RewardOpenWechatText() ?>"></li><?php endif;?></ul><div class="pos-f left-100" id="QRBox"><div id="MainBox"></div>
</div>
</div><?php endif;?>
</div>
    <?php $this->need('comments.php'); ?>
<?php if($this->options->Poster == '1' && $this->fields->Poster == '1'): ?>
<?php $this->need('modules/MakePost/poster.php'); ?>
<?php endif; ?>