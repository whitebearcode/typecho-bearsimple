<bearsimple id="bearsimple-images"></bearsimple>
<bearsimple id="bearsimple-images-readmode"></bearsimple>
<?php if(Bsoptions('AdControl') == true) :?>
<?php if(Bsoptions('AdControl4') == true && !empty(Bsoptions('AdControl4Src'))) :?>
<?php billboard(Bsoptions('AdControl4Src'),'other'); ?>
  <?php endif; ?><?php endif; ?>
<div class="pure-g" id="layout">
            <div class="pure-u-1 pure-u-md-<?php if(Bsoptions('site_style') == '1' || Bsoptions('site_style') == ''):?>3<?php endif;?><?php if(Bsoptions('site_style') == '2'):?>4<?php endif;?>-4">
                <div class="content_container">
                    <center>
                    <h3 class="ui header">
  <i class="edit outline icon"></i>
  <div class="content">
    <?php $this->archiveTitle(array(
            'category'  =>  _t('分类「%s」下的文章'),
            'search'    =>  _t('包含关键字「%s」的文章'),
            'tag'       =>  _t('标签「%s」下的文章'),
            'author'    =>  _t('「%s」发布的文章')
        ), '', ''); ?>
       <?php if($this->is('category')): ?>
       
<div class="sub header"><?php echo $this->getDescription();?></div><?php endif; ?>
  </div>
</h2></center><br>

  
<?php if(Bsoptions('Slidersss') == true && Bsoptions('SliderOthers') == true) :?>
  <div class="bearslider" style="display:none">
      <?php foreach (Bsoptions('slider__content') as $sliderpic) { ?>
  <div hrefs="<?php echo $sliderpic['slider__url'];?>"><img <?php echo lazyload('auto',$sliderpic['slider__pic']);?>src="<?php echo $sliderpic['slider__pic'];?>" title="<?php echo $sliderpic['slider__title'];?>"></div>
  <?php } ?>
</div>

<?php endif; ?>


           <?php if ($this->have()): ?>
            <?php if(Bsoptions('Article_forma')== "6"): ?>	
   
    
    <div class="post-wrapper">
<div class="post-list">
<?php while($this->next()): ?>
    <div class="post-item" hrefs="<?php $this->permalink() ?>" <?php if(Bsoptions('article_blank')== true): ?>target="_blank"<?php endif; ?>>
        <div class="post-itemx">
        <bheader class="post-item-header">
           <p class="post-item-meta">
             <?php if(Bsoptions('show_cate') == true && !empty($this->category)): ?><span class="post-item-category"><?php $this->category('<bsvi style=\'display:none\'>',false); ?></bsvi></span><?php endif; ?>
             <?php if(Bsoptions('Article_time') == true): ?><span class="post-item-category"><?php $this->date(); ?></span> <?php endif; ?>
            </p>
            <h2 class="post-item-title"><?php $this->sticky(); ?><?php echo cutexpert($this->title,articletitlenum()) ?></h2>
            
        </bheader>

        <div class="post-item-description">
            <?php if(Bsoptions('Article_expert') == true): ?>
<p>
 
<?php if($this->fields->excerpt !== null): ?>
			<?php echo cutexpert($this->excerpt,articledecnum());?>
		<?php endif; ?>
			<?php if($this->fields->excerpt !== null): ?>
			<?php $this->fields->excerpt(); ?>
			<?php endif; ?>

</p>
<?php endif; ?>
        </div>

    </div>
</div>
    <?php endwhile; ?>

</div>
</div>

<?php endif; ?>

<?php if(Bsoptions('Article_forma') == "4"): ?>		
   <?php while($this->next()): ?>

<div class="ui vertical segment">
 <h2 class="post-title"><?php $this->sticky() ?><a href="<?php $this->permalink() ?>" class="header" style="margin-top:5px" <?php if(Bsoptions('article_blank')== true): ?>target="_blank"<?php endif; ?>><?php echo cutexpert($this->title,articletitlenum()) ?></a> 	<?php if(Bsoptions('Article_time') == true): ?><div class="ui gray horizontal label"><?php $this->date(); ?></div><?php endif; ?></h2>


<?php if(Bsoptions('Article_expert') == true): ?>
<p>
 
<?php if($this->fields->excerpt !== null): ?>
			<?php echo cutexpert($this->excerpt,articledecnum());?>
		<?php endif; ?>
			<?php if($this->fields->excerpt !== null): ?>
			<?php $this->fields->excerpt(); ?>
			<?php endif; ?>

</p>
<?php endif; ?>
      
  
</div>

 	<?php endwhile; ?>
 	<?php endif; ?>
 	<?php if(Bsoptions('Article_forma') == "5"): ?>	
 	   <?php while($this->next()): ?>
  <div class="blog-card">
    <div class="meta">
<div class="photo<?php if(Bsoptions('Lazyload') == true): ?> lazyload bs-blur<?php endif; ?>" data-bg="<?php echo thumb($this); ?>" style="background-image: url(<?php if(thumb($this) !== ""): ?><?php echo thumb($this); ?><?php else:?><?php AssetsDir();?>assets/images/newstyle_default.jpg<?php endif; ?>)"></div>
    </div>
    <div class="description">
      <h1><?php $this->sticky(); ?><a href="<?php $this->permalink(); ?>" <?php if(Bsoptions('article_blank')== true): ?>target="_blank"<?php endif; ?>><?php echo cutexpert($this->title,articletitlenum()) ?></a></h1>
      <?php if(Bsoptions('Article_time') == true): ?>
      <h2><?php $this->date(); ?></h2>
      <?php endif; ?>
      <?php if(Bsoptions('Article_expert') == true): ?>
      <?php if($this->fields->excerpt == null): ?>
      <p><?php echo cutexpert($this->excerpt,articledecnum());?></p>
      	<?php endif; ?>
			<?php if($this->fields->excerpt !== null): ?>
			<p><?php $this->fields->excerpt(); ?></p>
			<?php endif; ?><?php else:?><p></p><?php endif; ?>
      <p class="read-more">
        <a href="<?php $this->permalink() ?>" class="ui button" <?php if(Bsoptions('article_blank')== true): ?>target="_blank"<?php endif; ?>>阅读全文<i class="angle double right icon"></i></a>
      </p>
    </div>
  </div>
   <?php endwhile; ?>
   <?php endif; ?>
<?php if(Bsoptions('Article_forma') == '1'): ?>	
<?php while($this->next()): ?>
  <div class="bs-simplestyle-container">
  <div class="bs-simplestyle-column">
   
    <div class="bs-simplestyle-post-module">
      <div class="bs-simplestyle-thumbnail">
          <?php if(thumb2($this) !== ""): ?>
<img <?php echo lazyload('auto',thumb2($this)); ?>src="<?php echo thumb2($this); ?>"><?php else: ?><img <?php echo lazyload('auto',thumb2($this)); ?>src="<?php AssetsDir();?>assets/images/cover.png"><?php endif; ?></div>
      <div class="bs-simplestyle-post-content">
        <?php if(Bsoptions('show_cate') == true && !empty($this->category)): ?><div class="bs-simplestyle-category"><?php $this->category('<bsvi style=\'display:none\'>',false); ?></bsvi></div><?php endif; ?>
        <h1 class="bs-simplestyle-title"><?php $this->sticky() ?><a href="<?php $this->permalink() ?>" <?php if(Bsoptions('article_blank')== true): ?>target="_blank"<?php endif; ?>><?php echo cutexpert($this->title,articletitlenum()) ?></a></h1>
        <?php if(Bsoptions('Article_expert') == true): ?><p class="bs-simplestyle-description"><?php if($this->fields->excerpt == null): ?><?php echo cutexpert($this->excerpt,articledecnum());?><?php else: ?><?php $this->fields->excerpt(); ?><?php endif; ?></p><?php endif; ?>
        <?php if(Bsoptions('Article_time') == true || Bsoptions('show_comment') == true): ?>
        <div class="bs-simplestyle-post-meta"><?php if(Bsoptions('Article_time') == true): ?><span class="bs-simplestyle-timestamp"><i class="time icon"></i> <time datetime="<?php $this->date('c'); ?>" itemprop="datePublished"><?php $this->date(); ?></time></span><?php endif; ?><?php if(Bsoptions('show_comment') == true): ?><span class="bs-simplestyle-comments"><i class="comment icon"></i> <?php $this->commentsNum('暂无评论', '1 条评论', '%d 条评论'); ?></span><?php endif; ?></div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
<?php endwhile; ?>

 	<?php endif; ?>
 	
   
<?php if(Bsoptions('Article_forma') == "2" || Bsoptions('Article_forma') == null): ?>
	<?php while($this->next()): ?>
<div class="ui segment diymode" style="border-radius:10px">
        <div class="post">
			<h1 class="post-title"><?php $this->sticky() ?><a itemprop="url" href="<?php $this->permalink() ?>" <?php if(Bsoptions('article_blank')== true): ?>target="_blank"<?php endif; ?>><?php echo cutexpert($this->title,articletitlenum()) ?></a></h1>
	
				<?php if(Bsoptions('Article_time') == true || Bsoptions('show_comment') == true || Bsoptions('show_cate') == true): ?>
<div class="post-meta">
			<?php if(Bsoptions('Article_time') == true): ?><i class="time outline icon"></i><time datetime="<?php $this->date('c'); ?>" itemprop="datePublished"><?php $this->date(); ?></time><?php endif; ?><?php if(Bsoptions('show_cate') == true):?> | <i class="folder outline icon"></i><?php $this->category(','); ?><?php endif; ?><?php if(Bsoptions('show_comment') == true):?> | <i class="comment outline icon"></i><a itemprop="discussionUrl" href="<?php $this->permalink() ?>#comments"><?php $this->commentsNum('0', '1', '%d'); ?></a><?php endif; ?>
			</div>
			<?php endif; ?>
			
			<?php if(Bsoptions('Article_expert') == true): ?>
			<div class="post-content">
				    <?php if($this->fields->excerpt == null): ?>
	
			<?php echo cutexpert($this->excerpt,articledecnum());?>
			
		<?php endif; ?>
			<?php if($this->fields->excerpt !== null): ?>
		<!--给文章简介加上内页链接 -->
				   
			<?php $this->fields->excerpt(); ?>
			<?php endif; ?>
			</div><?php endif; ?><br><p class="readmore" style="float:right;"><a href="<?php $this->permalink() ?>" <?php if(Bsoptions('article_blank')== true): ?>target="_blank"<?php endif; ?>><i class="angle double right icon"></i>阅读全文</a></p></div></div>


			
	<?php endwhile; ?>
<?php endif; ?>
<?php if(Bsoptions('Article_forma') == "3"): ?>
  <?php while($this->next()): ?>
                   <div class="wrappers" hrefs="<?php $this->permalink() ?>" <?php if(Bsoptions('article_blank')== true): ?>target="_blank"<?php endif; ?>>
		  <div class="cols">
					<div class="col">
						<div class="container">
						    <?php if(thumb2($this) !== ""): ?>
<div class="front <?php if(Bsoptions('Lazyload') == true): ?> lazyload bs-blur<?php endif; ?>" data-bg="<?php echo thumb2($this); ?>" style="background-image: url(<?php echo thumb2($this); ?>)">

							    <?php else: ?>

							    <div class="front <?php if(Bsoptions('Lazyload') == true): ?> lazyload bs-blur<?php endif; ?>" data-bg="<?php echo thumb2($this); ?>" style="background-image: url(<?php AssetsDir();?>assets/images/cover.png)">
							        <?php endif; ?>
							
								<div class="inner">
								   
									<p><?php $this->sticky() ?><a style="color:white"><?php echo cutexpert($this->title,articletitlenum()) ?></a></p>
	 <?php if(Bsoptions('Article_expert') == true): ?>
		              <span><?php if($this->fields->excerpt == null): ?>
			<?php echo cutexpert($this->excerpt,articledecnum());?>
		<?php endif; ?>
			<?php if($this->fields->excerpt !== null): ?>
			<?php $this->fields->excerpt(); ?>
			<?php endif; ?> </span>	
			<?php endif; ?>
			<?php if(Bsoptions('Article_time') == true): ?><div class="post-meta" style="padding-top:30px">
  <div class="ui mini inverted statistic">
    <div class="value">
      <?php $this->date(); ?>
    </div>
    <div class="label">
     发表时间
    </div>
  </div>
			</div>
			<?php endif; ?>
								</div>
								
							</div>
					
						</div>
					</div>
				</div>
		 </div>
		<?php endwhile; ?>
<?php endif; ?>
<?php else :?>
<article class="post">
        <center><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="200" height="200" viewBox="0 0 480 480"><defs><linearGradient id="a" x1="1.128" y1="0.988" x2="0.364" y2="1" gradientUnits="objectBoundingBox"><stop offset="0" stop-color="#e0e5ef" stop-opacity="0"/><stop offset="1" stop-color="#e0e5ef"/></linearGradient><linearGradient id="c" x1="1" y1="0.5" x2="0.112" y2="1.125" gradientUnits="objectBoundingBox"><stop offset="0" stop-color="#fff" stop-opacity="0"/><stop offset="1" stop-color="#747f95"/></linearGradient></defs><g transform="translate(-135 -375)"><circle cx="184" cy="184" r="184" transform="translate(191 443)" fill="#f3f3fa"/><path d="M2925,350h0c-8.837,0-16-32.235-16-72s7.163-72,16-72c.038,0,11.813.471,18.75-7.529s9-14.486,9-24.469c0-34.257,14.681-58.6,28.25-63.313,3.909-.688,10,.818,16-4.354s8-9.372,8-16.333c0-37.555,12.536-68,28-68s28,30.445,28,68c0,6.961-.667,10.328,5.333,15.5s14.76,4.5,18.667,5.187c13.569,4.714,24,33.055,24,67.312a101.212,101.212,0,0,0,2.333,20s4.485,11.842,11,5.5,9.13-14.885,10.25-22.871C3135.767,157.923,3142.61,142,3149,142c6.519,0,12.127,16.566,14.645,40.566.741,7.066,2.2,11.743,6.521,17.6A14.3,14.3,0,0,0,3180.92,206H3181c6.488,0,12.073,16.409,14.617,40.308.5,4.725.982,7.6,5.3,11.527S3212.884,262,3212.884,262l.116,0c2.16,0,4.255,1.8,6.228,5.344a58.6,58.6,0,0,1,5.086,14.573C3227.336,294.758,3229,311.835,3229,330c0,6.817-.237,13.546-.7,20H2925Zm303.3,0h0Z" transform="translate(-2718 397)" fill="url(#a)"/><path d="M117,208H.7c-.466-6.453-.7-13.181-.7-20,0-18.163,1.664-35.24,4.686-48.083a58.6,58.6,0,0,1,5.086-14.573C11.745,121.8,13.84,120,16,120l.116,0s7.651-.242,11.967-4.166,4.8-6.8,5.3-11.527C35.927,80.408,41.513,64,48,64a16.6,16.6,0,0,0,3.3-1.014A6.153,6.153,0,0,0,53.365,61.5c6.515-6.342,9.13-14.884,10.25-22.871C66.8,15.924,73.642,0,80.032,0,86.55,0,92.158,16.566,94.676,40.567c.742,7.065,2.2,11.742,6.521,17.6A14.3,14.3,0,0,0,111.951,64h.081c6.487,0,12.073,16.409,14.617,40.307.5,4.725.983,7.6,5.3,11.527S143.915,120,143.915,120l.116,0c2.16,0,4.255,1.8,6.228,5.344a58.6,58.6,0,0,1,5.086,14.573c3.022,12.844,4.686,29.921,4.686,48.083,0,6.818-.237,13.546-.7,20H117Zm42.328,0h0ZM.7,208h0Z" transform="translate(350.969 539)" fill="url(#a)"/><path d="M2989,62c-10.838-4.087-16.3,0-32,0-26.51,0-48-8.954-48-20s21.49-20,48-20h256a16,16,0,1,1,0,32s-15.5,0-27.5,3S3165,68.714,3165,68.714,3127.392,110,3081,110c-38.041,0-70.176-13.246-80.647-31.653C2998.219,74.6,2999.838,66.087,2989,62Z" transform="translate(-2702 701)" fill="#d1d6e2"/><path d="M-2493,98s-56.355,45.651-64,16,74.25-17.75-16,72" transform="translate(3044 409)" fill="none" stroke="#909aa9" stroke-linecap="round" stroke-width="2" stroke-dasharray="10"/><path d="M4,2.2C7.15-.75,16,0,16,0s-1.5,4-2.6,8-.232,5.942-1.8,8C7.6,21.25,0,21,0,21s.75-3.4,2-8S.85,5.15,4,2.2Z" transform="translate(447 603.085)" fill="#909aa9"/><ellipse cx="10" cy="4" rx="10" ry="4" transform="translate(294 787)" fill="url(#c)"/><path d="M8.44,24s8.115-6,6.94-10S11.51,9.625,9.775,6.125A11.222,11.222,0,0,1,8.44,0S1.767,2.625,1.5,9.375C1.38,12.419,4.436,14.344,6.171,18A32.451,32.451,0,0,1,8.44,24Z" transform="translate(287 794.497) rotate(-90)" fill="#909aa9"/><path d="M0,0,57,4.5,136,0l31.5,12,17,10-37,8.5-24.5-5-58,5L4,23Z" transform="translate(191 699)" fill="#fff"/><path d="M-1.4,1.2,60,9l58.75-5.25L143,9l36-9V24.5L144.4,29l-16.2-7.25L95.6,23l-5.1,1.5L67.2,21.75,5,23.25S2.8,16.713,1.2,11.2-1.4,1.2-1.4,1.2Z" transform="translate(196 720)" fill="#eceff5"/><path d="M0,9.833l18-9.5,2.667,4v8.2L13,18,8.167,12.532,0,13.671Z" transform="translate(377 777)" fill="#eceff5"/><path d="M4,3.167,18,0V10l-5,3.167-4.833-4L0,10Z" transform="translate(377 777)" fill="#fff"/><path d="M-.211,18.893,16,12l.246,14.107-2.084,4.646L0,31Z" transform="matrix(1, 0.017, -0.017, 1, 400.376, 734.864)" fill="#eceff5"/><path d="M9.75,12H16l-3.75,7H0Z" transform="translate(400 735)" fill="#fff"/><g transform="translate(447 690)"><path d="M97,0,63.923,4.5,24.316,0,8.523,12,0,22l18.55,8.5,12.283-5,29.079,5,23.488-5,6.467-12.126Z" transform="translate(-1 12)" fill="#fff"/><path d="M81.149.607l-28.1,3.945L26.17,1.9l-11.1,2.655L-2.651-1.333V12.391l17.083,2.276L21.846,11l14.917.632,2.334.759L49.759,11l28.991,1.391s-1.4-1.778,0-4.724A43.992,43.992,0,0,0,81.149.607Z" transform="translate(1.651 35.333)" fill="#eceff5"/></g></g></svg></center>
                <center><h2>这里暂时没有文章～</h2></center>
            </article>
            
<?php endif; ?>
<?php if(Bsoptions('infinite_scroll') == false || empty(Bsoptions('infinite_scroll'))): ?>
<?php
      ob_start(); 
      $this->pageNav('&laquo;','&raquo;', 1, '');
      $content = ob_get_contents();
      ob_end_clean();
      if(Bsoptions('pagination_style') == '2'){
      $content = preg_replace("/<ol class=\"(.*?)\">/sm", '<nav class="page-navigator">', $content);
      $content = preg_replace("/<li><span>(.*?)<\/span><\/li>/sm", '<span class="page-number">...</span>', $content);
      $content = preg_replace("/<li class=\"current\"><a href=\"(.*?)\">(.*?)<\/a><\/li>/sm", '<a class="page-number current" href="$1">$2</a>', $content);
      $content = preg_replace("/<li><a href=\"(.*?)\">(.*?)<\/a><\/li>/sm", '<a class="page-number" href="$1">$2</a>', $content);
       $content = preg_replace("/<li [class=\"prev\"]+><a href=\"(.*?)\">(.*?)<\/a><\/li>/sm", '<a class="extend prev" href="$1"><i class="arrow left icon"></i>上一页</a>', $content);
      $content = preg_replace("/<li [class=\"next\"]+><a href=\"(.*?)\">(.*?)<\/a><\/li>/sm", '<a class="extend next" href="$1"><i class="arrow right icon"></i>下一页</a>', $content);
      $content = preg_replace("/<\/ol>/sm", '</nav>', $content);
      }
      if(empty(Bsoptions('pagination_style')) || Bsoptions('pagination_style') == '1'){
      $content = preg_replace("/<ol class=\"(.*?)\">/sm", '<div class="ui circular labels" style="margin-top:30px"><div style="text-align:center">', $content);
      $content = preg_replace("/<li><span>(.*?)<\/span><\/li>/sm", '<a class="ui large label">...</a>', $content);
      $content = preg_replace("/<li class=\"current\"><a href=\"(.*?)\">(.*?)<\/a><\/li>/sm", '<a class="ui black large label" href="$1">$2</a>', $content);
      $content = preg_replace("/<li><a href=\"(.*?)\">(.*?)<\/a><\/li>/sm", '<a class="ui large label" href="$1">$2</a>', $content);
       $content = preg_replace("/<li [class=\"prev\"]+><a href=\"(.*?)\">(.*?)<\/a><\/li>/sm", '<a class="ui large label" href="$1">上一页</a>', $content);
      $content = preg_replace("/<li [class=\"next\"]+><a href=\"(.*?)\">(.*?)<\/a><\/li>/sm", '<a class="ui large label" style="margin-top:5px" href="$1">下一页</a>', $content);
      $content = preg_replace("/<\/ol>/sm", '</div></div>', $content);
      }
      echo $content;
     ?>
    
     <?php endif; ?>

  </div>
     <?php if ($this->have()): ?>
<?php if(Bsoptions('infinite_scroll') == true): ?>
<div class="pagination" style="display:none;">
                   
                    <?php $this->pageLink('下一页','next'); ?>
               </div>
            
<div class="page-load-status" style="display:none;">
<div class="ui active centered inline loader infinite-scroll-request" style="margin-top:20px"></div>

 <h2 class="ui icon header infinite-scroll-last">
  <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="200" height="200" viewBox="0 0 480 480"><defs><linearGradient id="a" x1="1.128" y1="0.988" x2="0.364" y2="1" gradientUnits="objectBoundingBox"><stop offset="0" stop-color="#e0e5ef" stop-opacity="0"/><stop offset="1" stop-color="#e0e5ef"/></linearGradient><linearGradient id="c" x1="1" y1="0.5" x2="0.112" y2="1.125" gradientUnits="objectBoundingBox"><stop offset="0" stop-color="#fff" stop-opacity="0"/><stop offset="1" stop-color="#747f95"/></linearGradient><linearGradient id="d" x1="-0.392" y1="1.114" x2="0.5" y2="0.396" gradientUnits="objectBoundingBox"><stop offset="0" stop-color="#fff" stop-opacity="0"/><stop offset="1" stop-color="#ebedf5"/></linearGradient><linearGradient id="e" x1="-0.906" y1="1.646" x2="0.636" y2="0.061" xlink:href="#d"/><linearGradient id="f" x1="-0.109" y1="1.931" x2="0.736" y2="0.141" xlink:href="#d"/></defs><g transform="translate(-135 -375)"><circle cx="184" cy="184" r="184" transform="translate(191 443)" fill="#f3f3fa"/><path d="M2925,350h0c-8.837,0-16-32.235-16-72s7.163-72,16-72c.038,0,11.813.471,18.75-7.529s9-14.486,9-24.469c0-34.257,14.681-58.6,28.25-63.313,3.909-.688,10,.818,16-4.354s8-9.372,8-16.333c0-37.555,12.536-68,28-68s28,30.445,28,68c0,6.961-.667,10.328,5.333,15.5s14.76,4.5,18.667,5.187c13.569,4.714,24,33.055,24,67.312a101.212,101.212,0,0,0,2.333,20s4.485,11.842,11,5.5,9.13-14.885,10.25-22.871C3135.767,157.923,3142.61,142,3149,142c6.519,0,12.127,16.566,14.645,40.566.741,7.066,2.2,11.743,6.521,17.6A14.3,14.3,0,0,0,3180.92,206H3181c6.488,0,12.073,16.409,14.617,40.308.5,4.725.982,7.6,5.3,11.527S3212.884,262,3212.884,262l.116,0c2.16,0,4.255,1.8,6.228,5.344a58.6,58.6,0,0,1,5.086,14.573C3227.336,294.758,3229,311.835,3229,330c0,6.817-.237,13.546-.7,20H2925Zm303.3,0h0Z" transform="translate(-2718 397)" fill="url(#a)"/><path d="M117,208H.7c-.466-6.453-.7-13.181-.7-20,0-18.163,1.664-35.24,4.686-48.083a58.6,58.6,0,0,1,5.086-14.573C11.745,121.8,13.84,120,16,120l.116,0s7.651-.242,11.967-4.166,4.8-6.8,5.3-11.527C35.927,80.408,41.513,64,48,64a16.6,16.6,0,0,0,3.3-1.014A6.153,6.153,0,0,0,53.365,61.5c6.515-6.342,9.13-14.884,10.25-22.871C66.8,15.924,73.642,0,80.032,0,86.55,0,92.158,16.566,94.676,40.567c.742,7.065,2.2,11.742,6.521,17.6A14.3,14.3,0,0,0,111.951,64h.081c6.487,0,12.073,16.409,14.617,40.307.5,4.725.983,7.6,5.3,11.527S143.915,120,143.915,120l.116,0c2.16,0,4.255,1.8,6.228,5.344a58.6,58.6,0,0,1,5.086,14.573c3.022,12.844,4.686,29.921,4.686,48.083,0,6.818-.237,13.546-.7,20H117Zm42.328,0h0ZM.7,208h0Z" transform="translate(350.969 539)" fill="url(#a)"/><path d="M2989,62c-10.838-4.087-16.3,0-32,0-26.51,0-48-8.954-48-20s21.49-20,48-20h256a16,16,0,1,1,0,32s-15.5,0-27.5,3S3165,68.714,3165,68.714,3127.392,110,3081,110c-38.041,0-70.176-13.246-80.647-31.653C2998.219,74.6,2999.838,66.087,2989,62Z" transform="translate(-2702 701)" fill="#d1d6e2"/><path d="M-2493,98s-56.355,45.651-64,16,74.25-17.75-16,72" transform="translate(3044 409)" fill="none" stroke="#909aa9" stroke-linecap="round" stroke-width="2" stroke-dasharray="10"/><path d="M4,2.2C7.15-.75,16,0,16,0s-1.5,4-2.6,8-.232,5.942-1.8,8C7.6,21.25,0,21,0,21s.75-3.4,2-8S.85,5.15,4,2.2Z" transform="translate(447 603.085)" fill="#909aa9"/><ellipse cx="10" cy="4" rx="10" ry="4" transform="translate(294 787)" fill="url(#c)"/><path d="M8.44,24s8.115-6,6.94-10S11.51,9.625,9.775,6.125A11.222,11.222,0,0,1,8.44,0S1.767,2.625,1.5,9.375C1.38,12.419,4.436,14.344,6.171,18A32.451,32.451,0,0,1,8.44,24Z" transform="translate(287 794.497) rotate(-90)" fill="#909aa9"/><path d="M0,0,57,4.5,136,0l31.5,12,17,10-37,8.5-24.5-5-58,5L4,23Z" transform="translate(191 699)" fill="#fff"/><path d="M-1.4,1.2,60,9l58.75-5.25L143,9l36-9V24.5L144.4,29l-16.2-7.25L95.6,23l-5.1,1.5L67.2,21.75,5,23.25S2.8,16.713,1.2,11.2-1.4,1.2-1.4,1.2Z" transform="translate(196 720)" fill="#eceff5"/><ellipse cx="43" cy="9.5" rx="43" ry="9.5" transform="translate(253 701)" fill="#ebedf5"/><g transform="translate(63 354)"><g transform="translate(258.49 305.55)"><path d="M525.021,66.584a31.23,31.23,0,0,1,7.085,10.425c2.772,6.6,5.877,13.459,8.386,14.78s3.695,10.033-8.053,8.185S525.021,66.584,525.021,66.584Z" transform="translate(-524.241 -66.584)" fill="#fff"/><path d="M525.494,68.3a32.341,32.341,0,0,1,6.953,16.851c.847,8.628,2.933,13.332,5.151,13.016a12.659,12.659,0,0,1-5.991-.025C528.092,97.37,524.074,68.412,525.494,68.3Z" transform="translate(-523.763 -65.64)" fill="url(#d)"/></g><path d="M537.949,131.675a34.415,34.415,0,0,0,14.137,1.09c6.9-.975,8.727-13.747-.647-15.059-7.267-1.02-6.026-12.167-7.366-22.433s-6.56-18.848-7.364-23.026,4.251-9.233,3.614-18.062c-.652-9.065-6.3-10.479-8.307-10.074s-3.609,2.392-6.154,3.47-6.292-.673-11.112,1.619-9.377,7.547-9.377,7.547c-2.009,2.561.4,10.648-.938,14.691s-6.694,39.223-6.56,49.062,6.426,16.715,19.952,18.467,19.419-.606,19.856-4.448c.279-2.443,1.905-11.053-7.8-12.535-4.83-.74-7.363-1.347-7.363-1.347" transform="translate(-279.872 225.445)" fill="#fff"/><path d="M519.206,44.961s.961-1.578,1.726-1.594c1.313-.026,2.7,1.631,2.7,1.631S519.249,46.731,519.206,44.961Z" transform="translate(-268.363 226.187)" fill="#757f95"/><path d="M522.077,37.922c-2.054-.536-2.278,2.085-2.278,2.085s-2.89-.313-2.6,1.743c.357,2.566,5.831,2.443,5.831,2.443S524.583,38.578,522.077,37.922Z" transform="translate(-269.464 223.151)" fill="#757f95"/><path d="M505.743,52.715s-6.088-1.338-6.755,3.318,4.181,7.509,7.656.6" transform="translate(-279.292 231.235)" fill="#fff"/><path d="M503.084,74.624s-1.45,17.9,1.1,22.385c2.3,4.044,10.662,5.138,16.755,4.63a25.038,25.038,0,0,0,6.013-1.246c6.068-2.157,2.831-6.2,0-8.893s-3.738-10.346-8.593-14.5" transform="translate(-276.501 243.626)" fill="url(#e)"/><path d="M514.078,48.635a.6.6,0,0,0-.522.31v0l-.009.014a4.814,4.814,0,0,1-3.228,2.322l-.019,0,0,0a.6.6,0,0,0-.509.5l-.011,0-.406,1.078s.341-.014.842-.088l.057-.307.11-.584v.865c.188-.031.389-.073.6-.121v-.747l.064.454.037.268a5.609,5.609,0,0,0,2.386-1.138,4.083,4.083,0,0,0,1.152-1.977c.04-.155.054-.248.054-.248A.6.6,0,0,0,514.078,48.635Z" transform="translate(-273.668 229.087)" fill="#757f95"/><path d="M531.516,76.393c-3.6-3.507-6.766.555-6.766.555s-6.2-4.888-8.5.26C513.373,83.63,528.051,94,528.051,94S535.2,79.982,531.516,76.393Z" transform="translate(-270.216 243.516)" fill="url(#f)"/><path d="M504.118,75.051s5.02,15.274,7.571,19.76c3.236,5.688,9.468,8.51,15.533,6.355s2.831-5.527,0-8.223S523.148,81.155,518.293,77" transform="translate(-277.496 242.564)" fill="#fff"/></g><path d="M0,9.833l18-9.5,2.667,4v8.2L13,18,8.167,12.532,0,13.671Z" transform="translate(377 777)" fill="#eceff5"/><path d="M4,3.167,18,0V10l-5,3.167-4.833-4L0,10Z" transform="translate(377 777)" fill="#fff"/><path d="M-.211,18.893,16,12l.246,14.107-2.084,4.646L0,31Z" transform="matrix(1, 0.017, -0.017, 1, 400.376, 734.864)" fill="#eceff5"/><path d="M9.75,12H16l-3.75,7H0Z" transform="translate(400 735)" fill="#fff"/><g transform="translate(447 690)"><path d="M97,0,63.923,4.5,24.316,0,8.523,12,0,22l18.55,8.5,12.283-5,29.079,5,23.488-5,6.467-12.126Z" transform="translate(-1 12)" fill="#fff"/><path d="M81.149.607l-28.1,3.945L26.17,1.9l-11.1,2.655L-2.651-1.333V12.391l17.083,2.276L21.846,11l14.917.632,2.334.759L49.759,11l28.991,1.391s-1.4-1.778,0-4.724A43.992,43.992,0,0,0,81.149.607Z" transform="translate(1.651 35.333)" fill="#eceff5"/></g></g></svg>
  <div class="content" style="margin-top:5px">
    啊哦，已经到底啦～
  </div>
</h2>

<h2 class="ui icon header infinite-scroll-error">
  <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="200" height="200" viewBox="0 0 480 480"><defs><linearGradient id="a" x1="0.5" y1="1" x2="0.564" gradientUnits="objectBoundingBox"><stop offset="0" stop-color="#e0e5ef" stop-opacity="0"/><stop offset="1" stop-color="#e0e5ef"/></linearGradient><linearGradient id="b" x1="0.5" x2="0.5" y2="1" gradientUnits="objectBoundingBox"><stop offset="0" stop-color="#d5d5d5"/><stop offset="1" stop-color="#6b6b6b" stop-opacity="0.059"/></linearGradient><linearGradient id="c" x1="0.222" y1="1.105" x2="0.681" y2="0.152" gradientUnits="objectBoundingBox"><stop offset="0" stop-color="#fff" stop-opacity="0"/><stop offset="1" stop-color="#909aa9"/></linearGradient><linearGradient id="d" x1="-0.392" y1="1.144" x2="0.636" y2="0.061" xlink:href="#c"/><linearGradient id="e" x1="0.027" y1="1.117" x2="0.736" y2="0.141" xlink:href="#c"/></defs><g transform="translate(-135 -375)"><ellipse cx="184" cy="184" rx="184" ry="184" transform="translate(191 431)" fill="#f3f3fa"/><path d="M112,259.243V96h64V259.243a187.037,187.037,0,0,1-64,0ZM0,192.931V0H88V253.371A184.268,184.268,0,0,1,0,192.931ZM208,24h96V169.434a184.369,184.369,0,0,1-96,81.193Z" transform="translate(230 536.999)" fill="url(#a)"/><g transform="translate(267.046 592.758) rotate(-25)"><rect width="156" height="200" rx="8" transform="translate(24 0)" fill="#78818e"/><path d="M8,0H144a8,8,0,0,1,8,8V192a8,8,0,0,1-8,8H8a8,8,0,0,1-8-8V8A8,8,0,0,1,8,0Z" transform="translate(24 0)" fill="#a1a7af"/><rect width="136" height="184" rx="4" transform="translate(32 8)" fill="#dae8e6"/><path d="M36,0H164a4.065,4.065,0,0,1,4,4.127c-7,174.567-15.744,174.717-15.744,174.717s-42.41.678-80.745-3.834A527.118,527.118,0,0,1-1.085,160.8S16,150.623,24,132.053s8-49.52,8-49.52V4.127A4.065,4.065,0,0,1,36,0Z" transform="translate(0 8)" fill="url(#b)"/><path d="M36,0H164a4,4,0,0,1,4,4c-7,169.209-11,171-11,171s-47.75-1.25-85-7A628,628,0,0,1,0,152a47.176,47.176,0,0,0,24-24c8-18,8-48,8-48V4A4,4,0,0,1,36,0Z" transform="translate(0 8)" fill="#fff"/><rect width="40" height="40" rx="2" transform="translate(48 40)" fill="#ebedf5"/><rect width="48" height="16" rx="2" transform="translate(104 40)" fill="#ebedf5"/><rect width="48" height="16" rx="2" transform="translate(104 64)" fill="#ebedf5"/><path d="M1,0S27,2,53,2s52-2,52-2l-1,12s-21.25,2-47,2S0,12,0,12Z" transform="translate(47 96)" fill="#ebedf5"/><path d="M2.5,0s14,2.438,40,2.75,63-1.5,63-1.5l-2,14S68,17.5,42.5,17.5,0,13.25,0,13.25Z" transform="translate(45.5 114.75)" fill="#ebedf5"/><path d="M4.5,0A254.823,254.823,0,0,0,40,3.333C60,3.833,108,2,108,2l-3,17s-38.417,2.75-65,2S0,16,0,16Z" transform="translate(40 136)" fill="#ebedf5"/></g><g transform="matrix(0.966, 0.259, -0.259, 0.966, 397.282, 500.051)"><rect width="6" height="32" rx="2" transform="translate(1)" fill="#b5b9be"/><rect width="6" height="32" rx="2" fill="#dddfe6"/></g><circle cx="1.5" cy="1.5" r="1.5" transform="translate(397 513.452)" fill="#909aa9"/><path d="M-3331,1132c188.947,26.75,289.45-16,289.45-16" transform="translate(3555.8 -620.625)" fill="none" stroke="#909aa9" stroke-linecap="round" stroke-width="2"/><g transform="translate(389 497.405)"><rect width="8" height="40" rx="2" transform="translate(1)" fill="#b5b9be"/><rect width="8" height="40" rx="2" fill="#cdd3df"/></g><g transform="matrix(0.839, 0.545, -0.545, 0.839, 437.927, -8.055)"><path d="M1585.106,53.028a7,7,0,0,1-6.618-4.723l-5.209-15.128a7,7,0,1,1,13.237-4.558l5.209,15.128a7,7,0,0,1-6.619,9.281ZM1580,28.462a2.5,2.5,0,1,0,2.5,2.5A2.5,2.5,0,0,0,1580,28.462Z" transform="translate(-1421.502 512.538)" fill="#909aa9"/><g transform="translate(145.469 536.589)"><path d="M21.951,107.445C7.073,105.525.152,97.989,0,87.2S3.6,54.89,6.22,41.423c1.093-6.458,1.453-6.148,0-6.02S0,31.09,1.866,26.884C2.356,23.48,5.5,23,7.535,23.056a4.1,4.1,0,0,1,.717-1.737s5.013-5.761,10.315-8.273a16.5,16.5,0,0,1,8.1-1.366,10.154,10.154,0,0,0,4.121-.409c2.8-1.181,2.558-2.36,4.769-2.8s10.6.936,11.317,10.872c.7,9.679-4.572,14.545-3.687,19.125.421,2.181.861,3.139,2.5,7.188A36.867,36.867,0,0,1,52.564,56.34c3.049,7.235,5.116,12.177,7.875,13.625s6.04,14.584-6.882,12.558l-.065-.011c5.463-1.532,1.439-.386,4.2,0,8.188.64,8.587,17.883,1,18.952-5.937,2.063-14.9,0-14.9,0v-1c-.04,1.317.078,1.422,0,2.1-.371,3.243-4.3,5.521-12.878,5.521A70.728,70.728,0,0,1,21.951,107.445ZM29.876,5.84A2.986,2.986,0,0,1,33.5,2.9S33.189-.785,36.876.153c4.25.875,2.25,8.625,2.25,8.625s-1.483.875-1.567.875C36.683,9.653,29.814,10.278,29.876,5.84Z" transform="translate(0 0)" fill="#909aa9" stroke="rgba(0,0,0,0)" stroke-width="1"/><g transform="translate(2.001 2.09)"><g transform="translate(40.489 44.55)"><path d="M.779,0A31.23,31.23,0,0,1,7.865,10.425c2.772,6.6,5.877,13.459,8.386,14.78S19.945,35.237,8.2,33.389.779,0,.779,0Z" fill="#fff"/><path d="M.293,0A32.341,32.341,0,0,1,7.246,16.851c.847,8.628,2.933,13.332,5.151,13.016a12.659,12.659,0,0,1-5.991-.025C2.891,29.071-1.127.113.293,0Z" transform="translate(1.438 2.659)" fill="url(#c)"/></g><path d="M40.077,87.626a34.415,34.415,0,0,0,14.137,1.09c6.9-.975,8.727-13.747-.647-15.059C46.3,72.636,47.541,61.489,46.2,51.224S39.641,32.376,38.837,28.2s4.251-9.233,3.614-18.062C41.8,1.07,36.15-.344,34.143.061s-3.609,2.392-6.154,3.47S21.7,2.858,16.878,5.149,7.5,12.7,7.5,12.7c-2.009,2.561.4,10.648-.938,14.691S-.132,66.612,0,76.45,6.429,93.165,19.954,94.917s19.419-.606,19.856-4.448c.279-2.443,1.905-11.053-7.8-12.535-4.83-.74-7.363-1.347-7.363-1.347" transform="translate(0 8.494)" fill="#fff"/><path d="M0,1.594S.961.016,1.726,0c1.313-.026,2.7,1.631,2.7,1.631S.043,3.365,0,1.594Z" transform="translate(32.843 8.554)" fill="#757f95"/><path d="M4.9.072C2.845-.464,2.622,2.158,2.622,2.158S-.268,1.844.02,3.9C.377,6.466,5.851,6.344,5.851,6.344S7.4.728,4.9.072Z" transform="translate(29.714 0)" fill="#757f95"/><path d="M6.817.178S.728-1.16.062,3.5,4.243,11,7.718,4.1" transform="translate(1.634 22.772)" fill="#fff"/><path d="M.411,0s-1.45,17.9,1.1,22.385c2.3,4.044,10.662,5.138,16.755,4.63a25.038,25.038,0,0,0,6.013-1.246c6.068-2.157,2.831-6.2,0-8.893S20.54,6.531,15.686,2.375" transform="translate(8.172 57.25)" fill="url(#d)"/><path d="M4.7,0A.6.6,0,0,0,4.18.31v0L4.17.322A4.814,4.814,0,0,1,.943,2.645l-.019,0,0,0a.6.6,0,0,0-.509.5l-.011,0L0,4.226s.341-.014.842-.088L.9,3.831l.11-.584v.865c.188-.031.389-.073.6-.121V3.243l.064.454.037.268A5.609,5.609,0,0,0,4.1,2.828,4.083,4.083,0,0,0,5.251.851C5.291.7,5.305.6,5.305.6A.6.6,0,0,0,4.7,0Z" transform="translate(17.708 16.722)" fill="#757f95"/><path d="M15.643,1.542c-3.6-3.507-6.766.555-6.766.555s-6.2-4.888-8.5.26c-2.873,6.422,11.8,16.794,11.8,16.794S19.326,5.132,15.643,1.542Z" transform="translate(27.658 57.366)" fill="url(#e)"/><path d="M0,0S5.02,15.274,7.571,19.76c3.236,5.688,9.468,8.51,15.533,6.355s2.831-5.527,0-8.223S19.03,6.1,14.175,1.947" transform="translate(8.621 56.615)" fill="#fff"/></g></g></g><g transform="translate(239.735 501.489)"><g transform="matrix(0.755, -0.656, 0.656, 0.755, 6.82, 4.592)"><rect width="6" height="32" rx="2" transform="translate(1)" fill="#b5b9be"/><rect width="6" height="32" rx="2" fill="#dddfe6"/></g><circle cx="1.5" cy="1.5" r="1.5" transform="translate(17.738 12.298) rotate(-56)" fill="#909aa9"/><g transform="translate(0 9.983) rotate(-56)"><rect width="8" height="40" rx="2" transform="translate(1)" fill="#b5b9be"/><rect width="8" height="40" rx="2" fill="#cdd3df"/></g></g><g transform="translate(359.323 650.849) rotate(-47)"><rect width="68.62" height="15.248" transform="translate(4.222 26.682)" fill="#ffcc43"/><rect width="68.616" height="15.248" transform="translate(45.744) rotate(90)" fill="#ffcc43"/></g><path d="M134.011,161.88l-6.667,23.833,8.833,8.667,25.5-5.833,28.738-30.229L164.264,131.88Z" transform="translate(300.156 434.287)" fill="#78818e"/><path d="M135.344,155.3l-6.5,23.845,4.286,4.143,24.214-5.488,25.333-25.583L160.511,129.88Z" transform="translate(302.156 442.287)" fill="#e5e2e2"/><path d="M182.7,150.552l4.6-4.6a6.537,6.537,0,0,0,0-9.192l-13.148-13.148a6.537,6.537,0,0,0-9.192,0l-4.6,4.6Zm-18.983-14.068,10.671,10.671,5.835,5.835-22.74,22.74c-5.4,1.159-6.554-1.479-5.835-5.835-5.475-.759-9.552-3.2-10.511-9.432L156.487,145.6l-1.4-1.4-15.746,15.266c-3.956.32-4.8-2.238-4.2-6.075l22.74-22.74Z" transform="translate(302.156 444.132)" fill="#909aa9"/><path d="M182.7,150.552l4.6-4.6a6.537,6.537,0,0,0,0-9.192l-13.148-13.148a6.537,6.537,0,0,0-9.192,0l-4.6,4.6Z" transform="translate(302.156 444.067)" fill="#78818e"/><path d="M131.844,167.63l-3.332,11.577,4.476,4.476,12.356-2.8Z" transform="translate(302.156 442.287)" fill="#78818e"/><path d="M186.977,155.3l5.475-5.353a7.493,7.493,0,0,0,0-10.706l-15.663-15.314a7.914,7.914,0,0,0-10.95,0l-5.475,5.353Z" transform="translate(299.156 441.701)" fill="#78818e"/><path d="M182.7,150.552l4.6-4.6a6.537,6.537,0,0,0,0-9.192l-13.148-13.148a6.537,6.537,0,0,0-9.192,0l-4.6,4.6Z" transform="translate(301.156 444.995)" fill="#a1a7af"/></g></svg>
  <div class="content" style="margin-top:5px">
    啊哦，加载错误啦～
  </div>
</h2>

</div>

<?php if(categorynum(categoryid($this->getArchiveSlug())) > Bsoptions('infinite_pageSize') && $this->is('archive')): ?>
<center><button class="ui right labeled icon button" id="bsnext" style="margin-top:20px;">
  <i class="right arrow icon"></i>
  加载更多
</button></center>
<?php elseif($this->is('search')): ?>
<center><button class="ui right labeled icon button" id="bsnext" style="margin-top:20px;">
  <i class="right arrow icon"></i>
  加载更多
</button></center>
<?php else:?><center><br>
<h2 class="ui icon header">
 <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="200" height="200" viewBox="0 0 480 480"><defs><linearGradient id="a" x1="1.128" y1="0.988" x2="0.364" y2="1" gradientUnits="objectBoundingBox"><stop offset="0" stop-color="#e0e5ef" stop-opacity="0"/><stop offset="1" stop-color="#e0e5ef"/></linearGradient><linearGradient id="c" x1="1" y1="0.5" x2="0.112" y2="1.125" gradientUnits="objectBoundingBox"><stop offset="0" stop-color="#fff" stop-opacity="0"/><stop offset="1" stop-color="#747f95"/></linearGradient><linearGradient id="d" x1="-0.392" y1="1.114" x2="0.5" y2="0.396" gradientUnits="objectBoundingBox"><stop offset="0" stop-color="#fff" stop-opacity="0"/><stop offset="1" stop-color="#ebedf5"/></linearGradient><linearGradient id="e" x1="-0.906" y1="1.646" x2="0.636" y2="0.061" xlink:href="#d"/><linearGradient id="f" x1="-0.109" y1="1.931" x2="0.736" y2="0.141" xlink:href="#d"/></defs><g transform="translate(-135 -375)"><circle cx="184" cy="184" r="184" transform="translate(191 443)" fill="#f3f3fa"/><path d="M2925,350h0c-8.837,0-16-32.235-16-72s7.163-72,16-72c.038,0,11.813.471,18.75-7.529s9-14.486,9-24.469c0-34.257,14.681-58.6,28.25-63.313,3.909-.688,10,.818,16-4.354s8-9.372,8-16.333c0-37.555,12.536-68,28-68s28,30.445,28,68c0,6.961-.667,10.328,5.333,15.5s14.76,4.5,18.667,5.187c13.569,4.714,24,33.055,24,67.312a101.212,101.212,0,0,0,2.333,20s4.485,11.842,11,5.5,9.13-14.885,10.25-22.871C3135.767,157.923,3142.61,142,3149,142c6.519,0,12.127,16.566,14.645,40.566.741,7.066,2.2,11.743,6.521,17.6A14.3,14.3,0,0,0,3180.92,206H3181c6.488,0,12.073,16.409,14.617,40.308.5,4.725.982,7.6,5.3,11.527S3212.884,262,3212.884,262l.116,0c2.16,0,4.255,1.8,6.228,5.344a58.6,58.6,0,0,1,5.086,14.573C3227.336,294.758,3229,311.835,3229,330c0,6.817-.237,13.546-.7,20H2925Zm303.3,0h0Z" transform="translate(-2718 397)" fill="url(#a)"/><path d="M117,208H.7c-.466-6.453-.7-13.181-.7-20,0-18.163,1.664-35.24,4.686-48.083a58.6,58.6,0,0,1,5.086-14.573C11.745,121.8,13.84,120,16,120l.116,0s7.651-.242,11.967-4.166,4.8-6.8,5.3-11.527C35.927,80.408,41.513,64,48,64a16.6,16.6,0,0,0,3.3-1.014A6.153,6.153,0,0,0,53.365,61.5c6.515-6.342,9.13-14.884,10.25-22.871C66.8,15.924,73.642,0,80.032,0,86.55,0,92.158,16.566,94.676,40.567c.742,7.065,2.2,11.742,6.521,17.6A14.3,14.3,0,0,0,111.951,64h.081c6.487,0,12.073,16.409,14.617,40.307.5,4.725.983,7.6,5.3,11.527S143.915,120,143.915,120l.116,0c2.16,0,4.255,1.8,6.228,5.344a58.6,58.6,0,0,1,5.086,14.573c3.022,12.844,4.686,29.921,4.686,48.083,0,6.818-.237,13.546-.7,20H117Zm42.328,0h0ZM.7,208h0Z" transform="translate(350.969 539)" fill="url(#a)"/><path d="M2989,62c-10.838-4.087-16.3,0-32,0-26.51,0-48-8.954-48-20s21.49-20,48-20h256a16,16,0,1,1,0,32s-15.5,0-27.5,3S3165,68.714,3165,68.714,3127.392,110,3081,110c-38.041,0-70.176-13.246-80.647-31.653C2998.219,74.6,2999.838,66.087,2989,62Z" transform="translate(-2702 701)" fill="#d1d6e2"/><path d="M-2493,98s-56.355,45.651-64,16,74.25-17.75-16,72" transform="translate(3044 409)" fill="none" stroke="#909aa9" stroke-linecap="round" stroke-width="2" stroke-dasharray="10"/><path d="M4,2.2C7.15-.75,16,0,16,0s-1.5,4-2.6,8-.232,5.942-1.8,8C7.6,21.25,0,21,0,21s.75-3.4,2-8S.85,5.15,4,2.2Z" transform="translate(447 603.085)" fill="#909aa9"/><ellipse cx="10" cy="4" rx="10" ry="4" transform="translate(294 787)" fill="url(#c)"/><path d="M8.44,24s8.115-6,6.94-10S11.51,9.625,9.775,6.125A11.222,11.222,0,0,1,8.44,0S1.767,2.625,1.5,9.375C1.38,12.419,4.436,14.344,6.171,18A32.451,32.451,0,0,1,8.44,24Z" transform="translate(287 794.497) rotate(-90)" fill="#909aa9"/><path d="M0,0,57,4.5,136,0l31.5,12,17,10-37,8.5-24.5-5-58,5L4,23Z" transform="translate(191 699)" fill="#fff"/><path d="M-1.4,1.2,60,9l58.75-5.25L143,9l36-9V24.5L144.4,29l-16.2-7.25L95.6,23l-5.1,1.5L67.2,21.75,5,23.25S2.8,16.713,1.2,11.2-1.4,1.2-1.4,1.2Z" transform="translate(196 720)" fill="#eceff5"/><ellipse cx="43" cy="9.5" rx="43" ry="9.5" transform="translate(253 701)" fill="#ebedf5"/><g transform="translate(63 354)"><g transform="translate(258.49 305.55)"><path d="M525.021,66.584a31.23,31.23,0,0,1,7.085,10.425c2.772,6.6,5.877,13.459,8.386,14.78s3.695,10.033-8.053,8.185S525.021,66.584,525.021,66.584Z" transform="translate(-524.241 -66.584)" fill="#fff"/><path d="M525.494,68.3a32.341,32.341,0,0,1,6.953,16.851c.847,8.628,2.933,13.332,5.151,13.016a12.659,12.659,0,0,1-5.991-.025C528.092,97.37,524.074,68.412,525.494,68.3Z" transform="translate(-523.763 -65.64)" fill="url(#d)"/></g><path d="M537.949,131.675a34.415,34.415,0,0,0,14.137,1.09c6.9-.975,8.727-13.747-.647-15.059-7.267-1.02-6.026-12.167-7.366-22.433s-6.56-18.848-7.364-23.026,4.251-9.233,3.614-18.062c-.652-9.065-6.3-10.479-8.307-10.074s-3.609,2.392-6.154,3.47-6.292-.673-11.112,1.619-9.377,7.547-9.377,7.547c-2.009,2.561.4,10.648-.938,14.691s-6.694,39.223-6.56,49.062,6.426,16.715,19.952,18.467,19.419-.606,19.856-4.448c.279-2.443,1.905-11.053-7.8-12.535-4.83-.74-7.363-1.347-7.363-1.347" transform="translate(-279.872 225.445)" fill="#fff"/><path d="M519.206,44.961s.961-1.578,1.726-1.594c1.313-.026,2.7,1.631,2.7,1.631S519.249,46.731,519.206,44.961Z" transform="translate(-268.363 226.187)" fill="#757f95"/><path d="M522.077,37.922c-2.054-.536-2.278,2.085-2.278,2.085s-2.89-.313-2.6,1.743c.357,2.566,5.831,2.443,5.831,2.443S524.583,38.578,522.077,37.922Z" transform="translate(-269.464 223.151)" fill="#757f95"/><path d="M505.743,52.715s-6.088-1.338-6.755,3.318,4.181,7.509,7.656.6" transform="translate(-279.292 231.235)" fill="#fff"/><path d="M503.084,74.624s-1.45,17.9,1.1,22.385c2.3,4.044,10.662,5.138,16.755,4.63a25.038,25.038,0,0,0,6.013-1.246c6.068-2.157,2.831-6.2,0-8.893s-3.738-10.346-8.593-14.5" transform="translate(-276.501 243.626)" fill="url(#e)"/><path d="M514.078,48.635a.6.6,0,0,0-.522.31v0l-.009.014a4.814,4.814,0,0,1-3.228,2.322l-.019,0,0,0a.6.6,0,0,0-.509.5l-.011,0-.406,1.078s.341-.014.842-.088l.057-.307.11-.584v.865c.188-.031.389-.073.6-.121v-.747l.064.454.037.268a5.609,5.609,0,0,0,2.386-1.138,4.083,4.083,0,0,0,1.152-1.977c.04-.155.054-.248.054-.248A.6.6,0,0,0,514.078,48.635Z" transform="translate(-273.668 229.087)" fill="#757f95"/><path d="M531.516,76.393c-3.6-3.507-6.766.555-6.766.555s-6.2-4.888-8.5.26C513.373,83.63,528.051,94,528.051,94S535.2,79.982,531.516,76.393Z" transform="translate(-270.216 243.516)" fill="url(#f)"/><path d="M504.118,75.051s5.02,15.274,7.571,19.76c3.236,5.688,9.468,8.51,15.533,6.355s2.831-5.527,0-8.223S523.148,81.155,518.293,77" transform="translate(-277.496 242.564)" fill="#fff"/></g><path d="M0,9.833l18-9.5,2.667,4v8.2L13,18,8.167,12.532,0,13.671Z" transform="translate(377 777)" fill="#eceff5"/><path d="M4,3.167,18,0V10l-5,3.167-4.833-4L0,10Z" transform="translate(377 777)" fill="#fff"/><path d="M-.211,18.893,16,12l.246,14.107-2.084,4.646L0,31Z" transform="matrix(1, 0.017, -0.017, 1, 400.376, 734.864)" fill="#eceff5"/><path d="M9.75,12H16l-3.75,7H0Z" transform="translate(400 735)" fill="#fff"/><g transform="translate(447 690)"><path d="M97,0,63.923,4.5,24.316,0,8.523,12,0,22l18.55,8.5,12.283-5,29.079,5,23.488-5,6.467-12.126Z" transform="translate(-1 12)" fill="#fff"/><path d="M81.149.607l-28.1,3.945L26.17,1.9l-11.1,2.655L-2.651-1.333V12.391l17.083,2.276L21.846,11l14.917.632,2.334.759L49.759,11l28.991,1.391s-1.4-1.778,0-4.724A43.992,43.992,0,0,0,81.149.607Z" transform="translate(1.651 35.333)" fill="#eceff5"/></g></g></svg>

  <div class="content" style="margin-top:5px">
    啊哦，已经到底啦～
  </div>
</h2></center>
  <?php endif; ?>

  <?php endif; ?>

  <?php endif; ?></div>