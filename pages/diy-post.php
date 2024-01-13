<script>
    var BsTocPostDate = "<?php $this->date("Y-m-d H:m"); ?>";
    var BsTocPostTitle = "<?php $this->title() ?>";
    var Permalink = "<?php $this->permalink(); ?>";
</script>
<script src="<?php AssetsDir();?>assets/vendors/bs-audio/audio.js"></script>
<?php if(Bsoptions('Readmode') == true): ?> 
              <a id="bs_toc_begin2"></a>   
                <div id="bs_toc_body2">
<?php echo readModeContent($this,reEmoPost(ShortCode($this->content,$this,$this->user->hasLogin(),$this->fields->ArticleType,'readmode'))); ?>
</div>
<?php endif; ?>



<div class="pure-g" id="layout">
      
      <div class="pure-u-1 pure-u-md-<?php if(Bsoptions('site_style') == '1' || Bsoptions('site_style') == ''):?>3<?php endif;?><?php if(Bsoptions('site_style') == '2'):?>4<?php endif;?>-4">
          <div class="content_container">
         <div id="bearsimple-scroll">
             
          <article class="post">
          <div class="ui <?php if(Bsoptions('postType') == "1"): ?>raised<?php endif; ?><?php if(Bsoptions('postType') == "2"): ?>stacked<?php endif; ?><?php if(Bsoptions('postType') == "3"): ?>tall stacked<?php endif; ?><?php if(Bsoptions('postType') == "4"): ?>pilede<?php endif; ?> segment"<?php if(Bsoptions('postradius')): ?> style="border-radius:<?php echo Bsoptions('postradius'); ?>px"<?php endif; ?>>
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
<div class="post-meta"><spans><i class="user icon"></i><a class="post-author" href="<?php $this->author->permalink(); ?>"><?php $this->author(); ?></a></spans><span><i class="time outline icon"></i><time datetime="<?php $this->date('c'); ?>" itemprop="datePublished"><?php $this->date(); ?></time></span><span><i class="folder open outline icon"></i><spans class="category"><?php $this->category(','); ?></spans></span><?php if($this->fields->Hot == '1'): ?>  <span><i class="hotjar icon" data-scid="<?php echo $this->cid; ?>"></i>热度:<hot id="ahot"></hot>°C</span><?php endif; ?><span><spans class="article_change"><i class="font icon"></i><spans class="article_change_m">默认</spans> / <spans class="article_change_k">楷体</spans> / <spans class="article_change_xlwk">霞鹜文楷体</spans></spans></span> <span id="fontsizes"><i class="text height icon"></i></span> <?php if(Bsoptions('Readmode') == true): ?><span id="read"><i class="book reader icon"></i></span><?php endif; ?> <write id="editbtn" style="display:none;">  <span onclick="window.open('<?php $this->options->adminUrl('/write-post.php?cid='.$this->cid); ?>','_self')"><i class="pencil icon"></i></span></write><?php if(Bsoptions('Poster') == true): ?> <span class="bear-btn-bwqr bear-share-poster j-bwqr-poster-btn" data-cid="<?php echo $this->cid;?>" id="poster-btn"><i class="newspaper icon"></i></span><?php endif; ?></div>
<div class="post-content" id="post-content"><div id="para">
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
    <input type="password" class="text" name="protectPassword" id="protectPassword" placeholder="请输入文章密码" autocomplete="off">
    <input type="hidden" name="protectCID" value="<?php $this->cid(); ?>" />
  </div>
  <div class="ui warning message">
    <div class="header">Tips:</div>
    <ul class="list">
      <li><?php echo empty(Bsoptions('globalTips')['articlePwdAfterEnter_Tip'])? '请不要随意多次尝试,否则可能触发本站自我保护机制~' : Bsoptions('globalTips')['articlePwdAfterEnter_Tip'];?></li>
    </ul>
  </div>
  <button class="ui submit button" id="protectajax" type="button">提交</button>
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
<?php if (array_key_exists('TePass', Typecho_Plugin::export()['activated'])){echo TePass_Plugin::getTePass();} ?>
</div>
<?php endif;?></p></div></div>

    <?php if($this->fields->tags == '1'): ?><br>
<?php tags($this);?><?php endif; ?>

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
<?php if (Bsoptions('RewardOpen_tepass') == true && array_key_exists('TePass', Typecho_Plugin::export()['activated'])) :?> 
<?php echo TePass_Plugin::getReward(); ?>
<?php endif; ?>
<?php if(Bsoptions('Poster') == true): ?>
<script src="<?php AssetsDir();?>assets/vendors/bs-poster/bearui/bearui.js"></script>
<script src="<?php AssetsDir();?>assets/vendors/bs-poster/qrious.min.js"></script>
<script>
window.bs_poster_setting="<?php AssetsDir();?>assets/vendors/bs-poster/|<?php getPoster(); ?>";
window.poster_theme=<?php echo Bsoptions('Poster__Skin');?>;
</script>
<?php endif; ?>
<?php if(Bsoptions('more_posts') == true): ?>
<br>
<h3 class="ui header bearmargin">

  <i class="hand point down outline icon"></i>猜您想看
</h3>

  
<div class="bsmorepost-container">
<div class="bmore">
 <div class="bmore_cards">
         
  <ul>
		<?php getRandomPosts(); ?>
		
		 </ul>
</div>
  
  </div>
   </div>	
	<?php endif; ?>	

    
</div></article></div>
 <div class="ui <?php if(Bsoptions('commentType') == "1"): ?>raised<?php endif; ?><?php if(Bsoptions('commentType') == "2"): ?>stacked<?php endif; ?><?php if(Bsoptions('commentType') == "3"): ?>tall stacked<?php endif; ?><?php if(Bsoptions('commentType') == "4"): ?>piled<?php endif; ?> divided items segment" <?php if(Bsoptions('commentradius')): ?>style="border-radius:<?php echo Bsoptions('commentradius'); ?>px"<?php endif; ?>>
    
    
    <?php if(!$this->hidden): ?>
    <?php $this->need('comments.php'); ?>
<?php else:?>
<center>
<h3 class="ui icon header">
  <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="200" height="200" viewBox="0 0 480 480"><defs><linearGradient id="a" x1="0.5" y1="1" x2="0.564" gradientUnits="objectBoundingBox"><stop offset="0" stop-color="#e0e5ef" stop-opacity="0"/><stop offset="1" stop-color="#e0e5ef"/></linearGradient><linearGradient id="b" x1="0.5" x2="0.5" y2="1" gradientUnits="objectBoundingBox"><stop offset="0" stop-color="#d5d5d5"/><stop offset="1" stop-color="#6b6b6b" stop-opacity="0.059"/></linearGradient><linearGradient id="c" x1="0.222" y1="1.105" x2="0.681" y2="0.152" gradientUnits="objectBoundingBox"><stop offset="0" stop-color="#fff" stop-opacity="0"/><stop offset="1" stop-color="#909aa9"/></linearGradient><linearGradient id="d" x1="-0.392" y1="1.144" x2="0.636" y2="0.061" xlink:href="#c"/><linearGradient id="e" x1="0.027" y1="1.117" x2="0.736" y2="0.141" xlink:href="#c"/></defs><g transform="translate(-135 -375)"><ellipse cx="184" cy="184" rx="184" ry="184" transform="translate(191 431)" fill="#f3f3fa"/><path d="M112,259.243V96h64V259.243a187.037,187.037,0,0,1-64,0ZM0,192.931V0H88V253.371A184.268,184.268,0,0,1,0,192.931ZM208,24h96V169.434a184.369,184.369,0,0,1-96,81.193Z" transform="translate(230 536.999)" fill="url(#a)"/><g transform="translate(267.046 592.758) rotate(-25)"><rect width="156" height="200" rx="8" transform="translate(24 0)" fill="#78818e"/><path d="M8,0H144a8,8,0,0,1,8,8V192a8,8,0,0,1-8,8H8a8,8,0,0,1-8-8V8A8,8,0,0,1,8,0Z" transform="translate(24 0)" fill="#a1a7af"/><rect width="136" height="184" rx="4" transform="translate(32 8)" fill="#dae8e6"/><path d="M36,0H164a4.065,4.065,0,0,1,4,4.127c-7,174.567-15.744,174.717-15.744,174.717s-42.41.678-80.745-3.834A527.118,527.118,0,0,1-1.085,160.8S16,150.623,24,132.053s8-49.52,8-49.52V4.127A4.065,4.065,0,0,1,36,0Z" transform="translate(0 8)" fill="url(#b)"/><path d="M36,0H164a4,4,0,0,1,4,4c-7,169.209-11,171-11,171s-47.75-1.25-85-7A628,628,0,0,1,0,152a47.176,47.176,0,0,0,24-24c8-18,8-48,8-48V4A4,4,0,0,1,36,0Z" transform="translate(0 8)" fill="#fff"/><rect width="40" height="40" rx="2" transform="translate(48 40)" fill="#ebedf5"/><rect width="48" height="16" rx="2" transform="translate(104 40)" fill="#ebedf5"/><rect width="48" height="16" rx="2" transform="translate(104 64)" fill="#ebedf5"/><path d="M1,0S27,2,53,2s52-2,52-2l-1,12s-21.25,2-47,2S0,12,0,12Z" transform="translate(47 96)" fill="#ebedf5"/><path d="M2.5,0s14,2.438,40,2.75,63-1.5,63-1.5l-2,14S68,17.5,42.5,17.5,0,13.25,0,13.25Z" transform="translate(45.5 114.75)" fill="#ebedf5"/><path d="M4.5,0A254.823,254.823,0,0,0,40,3.333C60,3.833,108,2,108,2l-3,17s-38.417,2.75-65,2S0,16,0,16Z" transform="translate(40 136)" fill="#ebedf5"/></g><g transform="matrix(0.966, 0.259, -0.259, 0.966, 397.282, 500.051)"><rect width="6" height="32" rx="2" transform="translate(1)" fill="#b5b9be"/><rect width="6" height="32" rx="2" fill="#dddfe6"/></g><circle cx="1.5" cy="1.5" r="1.5" transform="translate(397 513.452)" fill="#909aa9"/><path d="M-3331,1132c188.947,26.75,289.45-16,289.45-16" transform="translate(3555.8 -620.625)" fill="none" stroke="#909aa9" stroke-linecap="round" stroke-width="2"/><g transform="translate(389 497.405)"><rect width="8" height="40" rx="2" transform="translate(1)" fill="#b5b9be"/><rect width="8" height="40" rx="2" fill="#cdd3df"/></g><g transform="matrix(0.839, 0.545, -0.545, 0.839, 437.927, -8.055)"><path d="M1585.106,53.028a7,7,0,0,1-6.618-4.723l-5.209-15.128a7,7,0,1,1,13.237-4.558l5.209,15.128a7,7,0,0,1-6.619,9.281ZM1580,28.462a2.5,2.5,0,1,0,2.5,2.5A2.5,2.5,0,0,0,1580,28.462Z" transform="translate(-1421.502 512.538)" fill="#909aa9"/><g transform="translate(145.469 536.589)"><path d="M21.951,107.445C7.073,105.525.152,97.989,0,87.2S3.6,54.89,6.22,41.423c1.093-6.458,1.453-6.148,0-6.02S0,31.09,1.866,26.884C2.356,23.48,5.5,23,7.535,23.056a4.1,4.1,0,0,1,.717-1.737s5.013-5.761,10.315-8.273a16.5,16.5,0,0,1,8.1-1.366,10.154,10.154,0,0,0,4.121-.409c2.8-1.181,2.558-2.36,4.769-2.8s10.6.936,11.317,10.872c.7,9.679-4.572,14.545-3.687,19.125.421,2.181.861,3.139,2.5,7.188A36.867,36.867,0,0,1,52.564,56.34c3.049,7.235,5.116,12.177,7.875,13.625s6.04,14.584-6.882,12.558l-.065-.011c5.463-1.532,1.439-.386,4.2,0,8.188.64,8.587,17.883,1,18.952-5.937,2.063-14.9,0-14.9,0v-1c-.04,1.317.078,1.422,0,2.1-.371,3.243-4.3,5.521-12.878,5.521A70.728,70.728,0,0,1,21.951,107.445ZM29.876,5.84A2.986,2.986,0,0,1,33.5,2.9S33.189-.785,36.876.153c4.25.875,2.25,8.625,2.25,8.625s-1.483.875-1.567.875C36.683,9.653,29.814,10.278,29.876,5.84Z" transform="translate(0 0)" fill="#909aa9" stroke="rgba(0,0,0,0)" stroke-width="1"/><g transform="translate(2.001 2.09)"><g transform="translate(40.489 44.55)"><path d="M.779,0A31.23,31.23,0,0,1,7.865,10.425c2.772,6.6,5.877,13.459,8.386,14.78S19.945,35.237,8.2,33.389.779,0,.779,0Z" fill="#fff"/><path d="M.293,0A32.341,32.341,0,0,1,7.246,16.851c.847,8.628,2.933,13.332,5.151,13.016a12.659,12.659,0,0,1-5.991-.025C2.891,29.071-1.127.113.293,0Z" transform="translate(1.438 2.659)" fill="url(#c)"/></g><path d="M40.077,87.626a34.415,34.415,0,0,0,14.137,1.09c6.9-.975,8.727-13.747-.647-15.059C46.3,72.636,47.541,61.489,46.2,51.224S39.641,32.376,38.837,28.2s4.251-9.233,3.614-18.062C41.8,1.07,36.15-.344,34.143.061s-3.609,2.392-6.154,3.47S21.7,2.858,16.878,5.149,7.5,12.7,7.5,12.7c-2.009,2.561.4,10.648-.938,14.691S-.132,66.612,0,76.45,6.429,93.165,19.954,94.917s19.419-.606,19.856-4.448c.279-2.443,1.905-11.053-7.8-12.535-4.83-.74-7.363-1.347-7.363-1.347" transform="translate(0 8.494)" fill="#fff"/><path d="M0,1.594S.961.016,1.726,0c1.313-.026,2.7,1.631,2.7,1.631S.043,3.365,0,1.594Z" transform="translate(32.843 8.554)" fill="#757f95"/><path d="M4.9.072C2.845-.464,2.622,2.158,2.622,2.158S-.268,1.844.02,3.9C.377,6.466,5.851,6.344,5.851,6.344S7.4.728,4.9.072Z" transform="translate(29.714 0)" fill="#757f95"/><path d="M6.817.178S.728-1.16.062,3.5,4.243,11,7.718,4.1" transform="translate(1.634 22.772)" fill="#fff"/><path d="M.411,0s-1.45,17.9,1.1,22.385c2.3,4.044,10.662,5.138,16.755,4.63a25.038,25.038,0,0,0,6.013-1.246c6.068-2.157,2.831-6.2,0-8.893S20.54,6.531,15.686,2.375" transform="translate(8.172 57.25)" fill="url(#d)"/><path d="M4.7,0A.6.6,0,0,0,4.18.31v0L4.17.322A4.814,4.814,0,0,1,.943,2.645l-.019,0,0,0a.6.6,0,0,0-.509.5l-.011,0L0,4.226s.341-.014.842-.088L.9,3.831l.11-.584v.865c.188-.031.389-.073.6-.121V3.243l.064.454.037.268A5.609,5.609,0,0,0,4.1,2.828,4.083,4.083,0,0,0,5.251.851C5.291.7,5.305.6,5.305.6A.6.6,0,0,0,4.7,0Z" transform="translate(17.708 16.722)" fill="#757f95"/><path d="M15.643,1.542c-3.6-3.507-6.766.555-6.766.555s-6.2-4.888-8.5.26c-2.873,6.422,11.8,16.794,11.8,16.794S19.326,5.132,15.643,1.542Z" transform="translate(27.658 57.366)" fill="url(#e)"/><path d="M0,0S5.02,15.274,7.571,19.76c3.236,5.688,9.468,8.51,15.533,6.355s2.831-5.527,0-8.223S19.03,6.1,14.175,1.947" transform="translate(8.621 56.615)" fill="#fff"/></g></g></g><g transform="translate(239.735 501.489)"><g transform="matrix(0.755, -0.656, 0.656, 0.755, 6.82, 4.592)"><rect width="6" height="32" rx="2" transform="translate(1)" fill="#b5b9be"/><rect width="6" height="32" rx="2" fill="#dddfe6"/></g><circle cx="1.5" cy="1.5" r="1.5" transform="translate(17.738 12.298) rotate(-56)" fill="#909aa9"/><g transform="translate(0 9.983) rotate(-56)"><rect width="8" height="40" rx="2" transform="translate(1)" fill="#b5b9be"/><rect width="8" height="40" rx="2" fill="#cdd3df"/></g></g><g transform="translate(359.323 650.849) rotate(-47)"><rect width="68.62" height="15.248" transform="translate(4.222 26.682)" fill="#ffcc43"/><rect width="68.616" height="15.248" transform="translate(45.744) rotate(90)" fill="#ffcc43"/></g><path d="M134.011,161.88l-6.667,23.833,8.833,8.667,25.5-5.833,28.738-30.229L164.264,131.88Z" transform="translate(300.156 434.287)" fill="#78818e"/><path d="M135.344,155.3l-6.5,23.845,4.286,4.143,24.214-5.488,25.333-25.583L160.511,129.88Z" transform="translate(302.156 442.287)" fill="#e5e2e2"/><path d="M182.7,150.552l4.6-4.6a6.537,6.537,0,0,0,0-9.192l-13.148-13.148a6.537,6.537,0,0,0-9.192,0l-4.6,4.6Zm-18.983-14.068,10.671,10.671,5.835,5.835-22.74,22.74c-5.4,1.159-6.554-1.479-5.835-5.835-5.475-.759-9.552-3.2-10.511-9.432L156.487,145.6l-1.4-1.4-15.746,15.266c-3.956.32-4.8-2.238-4.2-6.075l22.74-22.74Z" transform="translate(302.156 444.132)" fill="#909aa9"/><path d="M182.7,150.552l4.6-4.6a6.537,6.537,0,0,0,0-9.192l-13.148-13.148a6.537,6.537,0,0,0-9.192,0l-4.6,4.6Z" transform="translate(302.156 444.067)" fill="#78818e"/><path d="M131.844,167.63l-3.332,11.577,4.476,4.476,12.356-2.8Z" transform="translate(302.156 442.287)" fill="#78818e"/><path d="M186.977,155.3l5.475-5.353a7.493,7.493,0,0,0,0-10.706l-15.663-15.314a7.914,7.914,0,0,0-10.95,0l-5.475,5.353Z" transform="translate(299.156 441.701)" fill="#78818e"/><path d="M182.7,150.552l4.6-4.6a6.537,6.537,0,0,0,0-9.192l-13.148-13.148a6.537,6.537,0,0,0-9.192,0l-4.6,4.6Z" transform="translate(301.156 444.995)" fill="#a1a7af"/></g></svg>
  <div class="content">
    评论区已被封印~
  </div>
</h3></center>
</div></div>
<?php endif; ?>

</div>
