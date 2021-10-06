 <bearsimple  id="bearsimple-images"></bearsimple>
 <?php if($this->options->Animate == "close" || $this->options->Animate == null): ?>  
<div class="pure-g" id="layout">
    <?php else: ?>
    <div class="pure-g animate__animated animate__<?php $this->options->Animate() ?>" id="layout">
        <?php endif; ?>
            <div class="pure-u-1 pure-u-md-3-4">
                <div class="content_container">
                    <?php if($this->options->AdControl == '1') :?>
<?php if($this->options->AdControl3 == '1') :?>
<?php billboard($this->options->AdControl3Src,'other'); ?>
  <?php endif; ?><?php endif; ?>
 
<?php if($this->options->Slidersss == '1' && $this->options->SliderIndexs == '1') :?>
<div class="wrappers">
		  <div class="cols">
					<div class="col">
						<div class="container">
  <div class="swiper-container" id="swiper">
    <div class="swiper-wrapper">
        <?php foreach (sliderget() as $sliderpic) { ?>
        <div class="swiper-slide"><img class="swiper-slide" src="<?php $this->options->themeUrl() ?>/modules/BearThumb/BearThumb.php?src=<?php echo $sliderpic;?>&h=230&w=547"></div>
        <?php } ?>
    </div>
    <div class="swiper-pagination"></div>
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
</div></div></div></div></div>
<?php endif; ?>

           <?php if ($this->have()): ?>
<?php if($this->options->Article_forma == "4"): ?>		
   <?php while($this->next()): ?>

<div class="ui vertical segment">

    
 <h2 class="post-title"><?php $this->sticky() ?><a href="<?php $this->permalink() ?>" class="header" style="margin-top:5px"><?php $this->title(articletitlenum(), '...') ?></a> 	<?php if($this->options->Article_time3 == "1"): ?><div class="ui gray horizontal label"><?php $this->date(); ?></div><?php endif; ?></h2>
  <p>
<?php if($this->fields->excerpt == null): ?>
		<!--给文章加上内页链接 -->
				    <?php if($this->options->ALABEL == '1'): ?>
			<a href="<?php $this->permalink() ?>"><?php $this->excerpt(articledecnum(), '...'); ?></a>
			<?php else : ?>
			<?php $this->excerpt(articledecnum(), '...'); ?>
			<?php endif; ?>
		<?php endif; ?>
			<?php if($this->fields->excerpt !== null): ?>
			<?php if($this->options->ALABEL == '1'): ?>
			<a href="<?php $this->permalink() ?>">
			<?php $this->fields->excerpt(); ?></a>
			<?php else : ?>
			<?php $this->fields->excerpt(); ?>
			<?php endif; ?>
			<?php endif; ?>
      
      
  </p>
</div>

 	<?php endwhile; ?>
 	<?php endif; ?>
<?php if($this->options->Article_forma == "1"): ?>		
   <?php while($this->next()): ?>
<div class="ui divided items segment" style="border-radius:10px;">
  <div class="item">

<?php if(thumb($this) !== "null"): ?>
  <div class="image" style="margin-top:auto;margin-bottom:auto;">
      <!--给文章加上内页链接 -->
				    <?php if($this->options->ALABEL == '1'): ?>
			<a href="<?php $this->permalink() ?>">
      <img style="width:180px;height:100px;border-radius:10px" src="<?php $this->options->themeUrl() ?>/modules/BearThumb/BearThumb.php?src=<?php echo thumb($this); ?>&h=230&w=547" alt="<?php $this->title() ?>">
      </a>
      <?php else : ?>
       <img style="width:180px;height:100px;border-radius:10px" src="<?php $this->options->themeUrl() ?>/modules/BearThumb/BearThumb.php?src=<?php echo thumb($this); ?>&h=230&w=547" alt="<?php $this->title() ?>">
      <?php endif; ?>
    </div>
    <?php endif; ?>
    <div class="content" style="margin-left:20px">
      <h2 class="post-title"><?php $this->sticky(); ?><a href="<?php $this->permalink() ?>" class="header" style="margin-top:5px"><?php $this->title(articletitlenum(), '...') ?></a></h2>
      <?php if($this->excerpt||$this->fields->excerpt) : ?>
      <div class="meta">
        <span class="cinema" style="word-wrap:break-word;line-height:1.5em"><?php if($this->fields->excerpt == null): ?>
		<!--给文章加上内页链接 -->
				    <?php if($this->options->ALABEL == '1'): ?>
				    
			<a href="<?php $this->permalink() ?>">
			<?php $this->excerpt(articledecnum(), '...'); ?>
			</a>
			<?php else :?>
			<?php $this->excerpt(articledecnum(), '...'); ?>
			<?php endif; ?>
		<?php endif; ?>
			<?php if($this->fields->excerpt !== null): ?>
			 <?php if($this->options->ALABEL == '1'): ?>
			<a href="<?php $this->permalink() ?>">
			<?php $this->fields->excerpt(); ?>
			</a>
			<?php else :?>
			<?php $this->fields->excerpt(); ?>
			<?php endif; ?>
			<?php endif; ?></span>
      </div>
      <?php endif; ?>
      <div class="description">
        <p></p>
      </div>
      <div class="extra">
        		<?php if($this->options->Article_time == "1"): ?><div class="ui label"><i class="time icon"></i> <?php $this->date(); ?></div><?php endif; ?>

   
        <p class="readmore"><a style="margin-top:<?php if(!empty($this->excerpt)||!empty($this->fields->excerpt)) : ?>-17<?php endif; ?><?php if(thumb($this) !== "null"): ?>9<?php endif; ?>px;" href="<?php $this->permalink() ?>">阅读全文</a></p>
      </div>
    </div>
  </div></div>
 	<?php endwhile; ?>
 	<?php endif; ?>
<?php if($this->options->Article_forma == "2" || $this->options->Article_forma == null): ?>
	<?php while($this->next()): ?>



<div class="ui segment" style="border-radius:10px">
        

        <div class="post">
			<h1 class="post-title"><?php $this->sticky() ?><a itemprop="url" href="<?php $this->permalink() ?>"><?php $this->title(articletitlenum(), '...') ?></a></h1>
	
			<div class="post-meta">
			<time datetime="<?php $this->date('c'); ?>" itemprop="datePublished"><?php $this->date(); ?></time>
			</div>
			<div class="post-content">
				    <?php if($this->fields->excerpt == null): ?>
			<!--给文章简介加上内页链接 -->
				    <?php if($this->options->ALABEL == '1'): ?>
			<a href="<?php $this->permalink() ?>"><?php $this->excerpt(articledecnum(), '...'); ?></a>
			<?php else: ?>
			<?php $this->excerpt(articledecnum(), '...'); ?>
				<?php endif; ?>
		<?php endif; ?>
			<?php if($this->fields->excerpt !== null): ?>
		<!--给文章简介加上内页链接 -->
				    <?php if($this->options->ALABEL == '1'): ?>
			<a href="<?php $this->permalink() ?>"><?php $this->fields->excerpt(); ?></a>
			<?php else: ?>
			<?php $this->fields->excerpt(); ?>
			<?php endif; ?>
			<?php endif; ?>
			</div><br><p class="readmore" style="float:right;"><a href="<?php $this->permalink() ?>">阅读全文</a></p></div></div>

			
	<?php endwhile; ?>
<?php endif; ?>
<?php if($this->options->Article_forma == "3"): ?>

  <?php while($this->next()): ?>
                    <div class="wrappers">
		  <div class="cols">
		
					<div class="col">
					
						<div class="container">
				
						    <?php if(thumb2($this) !== "null"): ?>
							<div class="front" style="background-image: url(<?php echo thumb2($this); ?>)">
							    <?php else: ?>
							    <div class="front" style="background-image: url(<?php AssetsDir();?>assets/images/2.png)">
							        <?php endif; ?>
							
								<div class="inner">
									<p><?php $this->sticky() ?><a href="<?php $this->permalink() ?>" style="color:white"><?php $this->title(articletitlenum(), '...') ?></a></p>
	
		              <span><?php if($this->fields->excerpt == null): ?>
			<?php $this->excerpt(articledecnum(), '...'); ?>
		<?php endif; ?>
			<?php if($this->fields->excerpt !== null): ?>
			<?php $this->fields->excerpt(); ?>
			<?php endif; ?> </span>		
			<?php if($this->options->Article_time == "3"): ?><div class="post-meta" style="padding-top:30px">
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
        <center><svg t="1617683554811" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="2629" width="200" height="200"><path d="M817.152 346.112c0-12.8-10.752-23.552-23.552-23.552h-28.672v281.6l-181.76 182.272H361.472v15.36c0 12.8 10.752 23.552 23.552 23.552l254.976-2.56 180.224-184.32-3.072-292.352z" fill="#E3EAED" p-id="2630"></path><path d="M332.8 705.536H258.56c-18.432 0-32.768-14.336-32.768-32.768V223.232c0-18.432 14.336-32.768 32.768-32.768H604.16c4.608 0 9.216 4.096 9.216 9.216 0 4.608-4.096 9.216-9.216 9.216H258.56c-7.68 0-14.336 6.656-14.336 14.336v449.024c0 7.68 6.656 14.336 14.336 14.336H332.8M686.08 299.52v-51.2c0-4.608 4.096-9.216 9.216-9.216 4.608 0 9.216 4.096 9.216 9.216v51.2" fill="#D3DBDE" p-id="2631"></path><path d="M608.768 797.184H350.208c-18.432 0-32.768-14.336-32.768-32.768V315.392c0-18.432 14.336-32.768 32.768-32.768h413.184c18.432 0 32.768 14.336 32.768 32.768v294.912l-187.392 186.88z m-258.56-496.64c-7.68 0-14.336 6.656-14.336 14.336v449.024c0 7.68 6.656 14.336 14.336 14.336h251.392l176.128-176.128v-286.72c0-7.68-6.656-14.336-14.336-14.336H350.208z" fill="#D3DBDE" p-id="2632"></path><path d="M601.088 778.752l177.152-176.128V322.56H394.752c-12.8 0-23.552 11.264-23.552 24.576v431.616h229.888z" fill="#F2F5F7" p-id="2633"></path><path d="M613.888 788.992h-18.432v-110.08c0-44.032 36.352-80.384 80.384-80.384h103.936v17.92H675.84c-34.304 0-62.464 27.648-62.464 62.464l0.512 110.08z m45.056-350.72H453.12c-6.656 0-12.288-5.632-12.288-12.288 0-6.656 5.632-12.288 12.288-12.288h205.824c6.656 0 12.288 5.632 12.288 12.288 0 7.168-5.632 12.288-12.288 12.288z m0-11.776v6.144-6.144z m1.536 71.168H453.12c-6.656 0-12.288-5.632-12.288-11.776 0-6.656 5.632-11.776 12.288-11.776H660.48c6.656 0 12.288 5.632 12.288 11.776-0.512 6.656-5.632 11.776-12.288 11.776z m0-11.776v6.144-6.144z m0 71.68H453.12c-6.656 0-12.288-5.632-12.288-11.776 0-6.656 5.632-11.776 12.288-11.776H660.48c6.656 0 12.288 5.632 12.288 11.776-0.512 6.656-5.632 11.776-12.288 11.776z m0-11.776v6.144-6.144z m-10.752-451.072c-5.12 0-9.216 4.096-9.216 9.216v61.44c0 5.12 4.096 9.216 9.216 9.216 4.608 0 9.216-4.096 9.216-9.216v-61.44c0-4.608-4.096-9.216-9.216-9.216z m114.688 17.408c-4.096-3.072-9.728-2.048-12.8 2.048l-35.84 49.664c-3.072 4.096-2.048 9.728 2.048 12.8 2.048 1.024 3.584 2.048 5.632 2.048 3.072 0 5.632-1.024 7.168-3.584l35.84-49.664c2.56-4.608 2.048-10.24-2.048-13.312z m58.88 71.168c-2.048-5.12-7.168-6.656-12.288-4.096l-55.296 25.6c-5.12 2.048-6.656 7.168-4.096 12.288 2.048 3.584 5.12 5.632 8.704 5.632 1.024 0 2.56 0 3.584-0.512l55.296-25.6c4.096-3.584 6.144-8.704 4.096-13.312z" fill="#D3DBDE" p-id="2634"></path></svg></center>
                <center><h2>暂无文章</h2></center>
            </article>
<?php endif; ?>
    <?php
      ob_start(); 
      $this->pageNav('&laquo;','&raquo;', 1, '');
      $content = ob_get_contents();
      ob_end_clean();
      if($this->options->pagination_style == '2'){
      $content = preg_replace("/<ol class=\"(.*?)\">/sm", '<nav class="page-navigator">', $content);
      $content = preg_replace("/<li><span>(.*?)<\/span><\/li>/sm", '<span class="page-number">...</span>', $content);
      $content = preg_replace("/<li class=\"current\"><a href=\"(.*?)\">(.*?)<\/a><\/li>/sm", '<a class="page-number current" href="$1">$2</a>', $content);
      $content = preg_replace("/<li><a href=\"(.*?)\">(.*?)<\/a><\/li>/sm", '<a class="page-number" href="$1">$2</a>', $content);
       $content = preg_replace("/<li [class=\"prev\"]+><a href=\"(.*?)\">(.*?)<\/a><\/li>/sm", '<a class="extend prev" href="$1">上一页</a>', $content);
      $content = preg_replace("/<li [class=\"next\"]+><a href=\"(.*?)\">(.*?)<\/a><\/li>/sm", '<a class="extend next" href="$1">下一页</a>', $content);
      $content = preg_replace("/<\/ol>/sm", '</nav>', $content);
      }
      if(empty($this->options->pagination_style) || $this->options->pagination_style == '1'){
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
  
  
</div></div>