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
                    
          <div class="ui <?php if($this->options->postType == "1"): ?>raised<?php endif; ?><?php if($this->options->postType == "2"): ?>stacked<?php endif; ?><?php if($this->options->postType == "3"): ?>tall stacked<?php endif; ?><?php if($this->options->postType == "4"): ?>piled<?php endif; ?> divided items segment" <?php if($this->options->postradius): ?>style="border-radius:<? $this->options->postradius(); ?>px"<?php endif; ?>>
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
<div class="post-meta"><time datetime="<?php $this->date('c'); ?>" itemprop="datePublished"><?php $this->date(); ?></time><span> | </span><span class="category"><?php $this->category(','); ?></span> | <span class="ui mini gray icon button" size="bigger" >A+</span><span class="ui mini gray icon button" size="smaller" >A-</span></div>



<a style="float:right" href="#comments"><i class="comment alternate outline icon"></i></a>
<div class="post-content"><div id="para">
<!-- index-menu -->

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

<?php

$db = Typecho_Db::get();
$sql = $db->select()->from('table.comments')
    ->where('cid = ?',$this->cid)
    ->where('mail = ?', $this->remember('mail',true))
    ->where('status = ?', 'approved')
    ->limit(1);
$result = $db->fetchAll($sql);
if($this->user->hasLogin() || $result) {
    $content = preg_replace("/\[bs-hide\](.*?)\[\/bs-hide\]/sm",'<div class="ui floating message">$1</div>',$this->content);
     if ($this->options->Lightbox == '1'){
    $pattern = '/\<img.*?src\=\"(.*?)\"[^>]*>/i';
    $replacement = '<a href="$1" class="bearsimple-image-link" data-lightbox="bearsimple-set" data-title="'.$this->title.'"><img class="bearsimple-image" src="$1" alt="'.$this->title.'" title="点击放大图片"></a>';
    $content = preg_replace($pattern, $replacement, $this->content);
    }


    
}

else{
     $content = preg_replace("/\[bs-hide\](.*?)\[\/bs-hide\]/sm",'<div class="ui floating message"><i class="thumbtack icon"></i>此处内容需要评论回复后方可阅读。</div>',$this->content);
        if ($this->options->Lightbox == '1'){
    $pattern = '/\<img.*?src\=\"(.*?)\"[^>]*>/i';
    $replacement = '<a href="$1" class="bearsimple-image-link" data-lightbox="bearsimple-set" data-title="'.$this->title.'"><img class="bearsimple-image" src="$1" alt="'.$this->title.'" title="点击放大图片"></a>';
    $content = preg_replace($pattern, $replacement, $this->content);
    }
   
   
}
    echo $content; 
?>
<?php endif;?></p></div></div></div>

    <br>
<div class="ui tag label"><font color="gray">标签:</font><?php $this->tags('  ', true, 'none'); ?></div>
 
<br>  
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
<link rel="stylesheet" type="text/css" href="/usr/themes/bearsimple/assets/share/share.min.css"/>
 <div style="transform:translateY(100%);-ms-transform:translateY(100%);-webkit-transform:translateY(100%);float:right;" id="share" data-sites="<?php $this->need('modules/share.php'); ?>"></div><br>
<br><br>

<?php if($this->options->RewardOpen == '1'): ?>
 <div id="donate"><link rel="stylesheet" type="text/css" href="/usr/themes/bearsimple/assets/css/donate.css"><script type="text/javascript" src="/usr/themes/bearsimple/assets/javascript/donate.js" successtext="复制成功!"></script><div id="DonateText">打赏一下</div><ul class="list pos-f" id="donateBox"><?php if($this->options->RewardOpenPaypal == '1'): ?><li id="PayPal"><a href="<?php $this->options->RewardOpenPaypalText() ?>" target="_blank"></a></li><?php endif;?><?php if($this->options->RewardOpenAlipay == '1'): ?><li id="AliPay" qr="<?php $this->options->RewardOpenAlipayText() ?>"></li><?php endif;?><?php if($this->options->RewardOpenWechat == '1'): ?><li id="WeChat" qr="<?php $this->options->RewardOpenWechatText() ?>"></li><?php endif;?></ul><div class="pos-f left-100" id="QRBox"><div id="MainBox"></div>
</div>
</div><?php endif;?>
</div></div>
 <div class="ui <?php if($this->options->commentType == "1"): ?>raised<?php endif; ?><?php if($this->options->commentType == "2"): ?>stacked<?php endif; ?><?php if($this->options->commentType == "3"): ?>tall stacked<?php endif; ?><?php if($this->options->commentType == "4"): ?>piled<?php endif; ?> divided items segment" <?php if($this->options->commentradius): ?>style="border-radius:<? $this->options->commentradius(); ?>px"<?php endif; ?>>
    <?php $this->need('comments.php'); ?>
</div>

