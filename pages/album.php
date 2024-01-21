<?php if(Bsoptions('AdControl') == true) :?>
<?php if(Bsoptions('AdControl4') == true && !empty(Bsoptions('AdControl4Src'))) :?>
<?php billboard(Bsoptions('AdControl4Src'),'other'); ?>
  <?php endif; ?><?php endif; ?>
<div class="pure-g" id="layout">
            <div class="pure-u-1 pure-u-md-<?php if(Bsoptions('site_style') == '1' || Bsoptions('site_style') == ''):?>3<?php endif;?><?php if(Bsoptions('site_style') == '2'):?>4<?php endif;?>-4">
                <div class="content_container">
                    <center>
                    <h3 class="ui header">
  <i class="images outline icon"></i>
  <div class="content">
    <?php $this->archiveTitle(array(
            'category'  =>  _t('%s'),
            'search'    =>  _t('包含关键字「%s」的相册'),
            'tag'       =>  _t('标签「%s」下的相册'),
            'author'    =>  _t('「%s」发布的相册')
        ), '', ''); ?>
       <?php if($this->is('category')): ?>
       
<div class="sub header"><?php echo $this->getDescription();?></div><?php endif; ?>
  </div>
</h2></center><br>

  
<?php if(Bsoptions('Slidersss') == true && Bsoptions('SliderOthers') == true) :?>
 <div id="bearslider">
	    <?php foreach (Bsoptions('slider__content') as $sliderpic) { ?>
		<a href="<?php echo $sliderpic['slider__url'];?>"><img src="<?php echo $sliderpic['slider__pic'];?>"  title="<?php echo $sliderpic['slider__title'];?>" alt="<?php echo $sliderpic['slider__desc'];?>"></a>
		 <?php } ?>
	
	</div>

<?php endif; ?>


           <?php if ($this->have()): ?>
               <section class="bs-photo-stack-section">

<ul class="bs-photo-stack-grid">
   <?php while($this->next()): ?>

  <li>
    <a href="<?php $this->permalink() ?>">
      <figure class="bs-photo-stack">
        <img <?php echo lazyload('auto',thumb2($this)); ?>src="<?php echo thumb2($this,'album'); ?>" alt="相册" />
      </figure>
      <span class="bs-photo-stack-span"><?php echo $this->title ?></span>
    </a>
  </li>



   	<?php endwhile; ?>
   	</ul>
</section>

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
      $content = preg_replace("/<ol class=\"(.*?)\">/sm", '<div class="ui labels" style="margin-top:30px"><div style="text-align:center">', $content);
      $content = preg_replace("/<li><span>(.*?)<\/span><\/li>/sm", '<a class="ui large label">...</a>', $content);
      $content = preg_replace("/<li class=\"current\"><a href=\"(.*?)\">(.*?)<\/a><\/li>/sm", '<a class="ui black large label" href="$1">$2</a>', $content);
      $content = preg_replace("/<li><a href=\"(.*?)\">(.*?)<\/a><\/li>/sm", '<a class="ui large label" href="$1">$2</a>', $content);
       $content = preg_replace("/<li [class=\"prev\"]+><a href=\"(.*?)\">(.*?)<\/a><\/li>/sm", '<a class="ui large label" href="$1">上一页</a>', $content);
      $content = preg_replace("/<li [class=\"next\"]+><a href=\"(.*?)\">(.*?)<\/a><\/li>/sm", '<a class="ui large label" style="margin-top:5px" href="$1">下一页</a>', $content);
      $content = preg_replace("/<\/ol>/sm", '</div></div>', $content);
      }
      echo $content;
     ?>
     
   <?php else :?>
<article class="post">
        <center><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="200" height="200" viewBox="0 0 480 480"><defs><linearGradient id="a" x1="1.128" y1="0.988" x2="0.364" y2="1" gradientUnits="objectBoundingBox"><stop offset="0" stop-color="#e0e5ef" stop-opacity="0"/><stop offset="1" stop-color="#e0e5ef"/></linearGradient><linearGradient id="c" x1="1" y1="0.5" x2="0.112" y2="1.125" gradientUnits="objectBoundingBox"><stop offset="0" stop-color="#fff" stop-opacity="0"/><stop offset="1" stop-color="#747f95"/></linearGradient></defs><g transform="translate(-135 -375)"><circle cx="184" cy="184" r="184" transform="translate(191 443)" fill="#f3f3fa"/><path d="M2925,350h0c-8.837,0-16-32.235-16-72s7.163-72,16-72c.038,0,11.813.471,18.75-7.529s9-14.486,9-24.469c0-34.257,14.681-58.6,28.25-63.313,3.909-.688,10,.818,16-4.354s8-9.372,8-16.333c0-37.555,12.536-68,28-68s28,30.445,28,68c0,6.961-.667,10.328,5.333,15.5s14.76,4.5,18.667,5.187c13.569,4.714,24,33.055,24,67.312a101.212,101.212,0,0,0,2.333,20s4.485,11.842,11,5.5,9.13-14.885,10.25-22.871C3135.767,157.923,3142.61,142,3149,142c6.519,0,12.127,16.566,14.645,40.566.741,7.066,2.2,11.743,6.521,17.6A14.3,14.3,0,0,0,3180.92,206H3181c6.488,0,12.073,16.409,14.617,40.308.5,4.725.982,7.6,5.3,11.527S3212.884,262,3212.884,262l.116,0c2.16,0,4.255,1.8,6.228,5.344a58.6,58.6,0,0,1,5.086,14.573C3227.336,294.758,3229,311.835,3229,330c0,6.817-.237,13.546-.7,20H2925Zm303.3,0h0Z" transform="translate(-2718 397)" fill="url(#a)"/><path d="M117,208H.7c-.466-6.453-.7-13.181-.7-20,0-18.163,1.664-35.24,4.686-48.083a58.6,58.6,0,0,1,5.086-14.573C11.745,121.8,13.84,120,16,120l.116,0s7.651-.242,11.967-4.166,4.8-6.8,5.3-11.527C35.927,80.408,41.513,64,48,64a16.6,16.6,0,0,0,3.3-1.014A6.153,6.153,0,0,0,53.365,61.5c6.515-6.342,9.13-14.884,10.25-22.871C66.8,15.924,73.642,0,80.032,0,86.55,0,92.158,16.566,94.676,40.567c.742,7.065,2.2,11.742,6.521,17.6A14.3,14.3,0,0,0,111.951,64h.081c6.487,0,12.073,16.409,14.617,40.307.5,4.725.983,7.6,5.3,11.527S143.915,120,143.915,120l.116,0c2.16,0,4.255,1.8,6.228,5.344a58.6,58.6,0,0,1,5.086,14.573c3.022,12.844,4.686,29.921,4.686,48.083,0,6.818-.237,13.546-.7,20H117Zm42.328,0h0ZM.7,208h0Z" transform="translate(350.969 539)" fill="url(#a)"/><path d="M2989,62c-10.838-4.087-16.3,0-32,0-26.51,0-48-8.954-48-20s21.49-20,48-20h256a16,16,0,1,1,0,32s-15.5,0-27.5,3S3165,68.714,3165,68.714,3127.392,110,3081,110c-38.041,0-70.176-13.246-80.647-31.653C2998.219,74.6,2999.838,66.087,2989,62Z" transform="translate(-2702 701)" fill="#d1d6e2"/><path d="M-2493,98s-56.355,45.651-64,16,74.25-17.75-16,72" transform="translate(3044 409)" fill="none" stroke="#909aa9" stroke-linecap="round" stroke-width="2" stroke-dasharray="10"/><path d="M4,2.2C7.15-.75,16,0,16,0s-1.5,4-2.6,8-.232,5.942-1.8,8C7.6,21.25,0,21,0,21s.75-3.4,2-8S.85,5.15,4,2.2Z" transform="translate(447 603.085)" fill="#909aa9"/><ellipse cx="10" cy="4" rx="10" ry="4" transform="translate(294 787)" fill="url(#c)"/><path d="M8.44,24s8.115-6,6.94-10S11.51,9.625,9.775,6.125A11.222,11.222,0,0,1,8.44,0S1.767,2.625,1.5,9.375C1.38,12.419,4.436,14.344,6.171,18A32.451,32.451,0,0,1,8.44,24Z" transform="translate(287 794.497) rotate(-90)" fill="#909aa9"/><path d="M0,0,57,4.5,136,0l31.5,12,17,10-37,8.5-24.5-5-58,5L4,23Z" transform="translate(191 699)" fill="#fff"/><path d="M-1.4,1.2,60,9l58.75-5.25L143,9l36-9V24.5L144.4,29l-16.2-7.25L95.6,23l-5.1,1.5L67.2,21.75,5,23.25S2.8,16.713,1.2,11.2-1.4,1.2-1.4,1.2Z" transform="translate(196 720)" fill="#eceff5"/><path d="M0,9.833l18-9.5,2.667,4v8.2L13,18,8.167,12.532,0,13.671Z" transform="translate(377 777)" fill="#eceff5"/><path d="M4,3.167,18,0V10l-5,3.167-4.833-4L0,10Z" transform="translate(377 777)" fill="#fff"/><path d="M-.211,18.893,16,12l.246,14.107-2.084,4.646L0,31Z" transform="matrix(1, 0.017, -0.017, 1, 400.376, 734.864)" fill="#eceff5"/><path d="M9.75,12H16l-3.75,7H0Z" transform="translate(400 735)" fill="#fff"/><g transform="translate(447 690)"><path d="M97,0,63.923,4.5,24.316,0,8.523,12,0,22l18.55,8.5,12.283-5,29.079,5,23.488-5,6.467-12.126Z" transform="translate(-1 12)" fill="#fff"/><path d="M81.149.607l-28.1,3.945L26.17,1.9l-11.1,2.655L-2.651-1.333V12.391l17.083,2.276L21.846,11l14.917.632,2.334.759L49.759,11l28.991,1.391s-1.4-1.778,0-4.724A43.992,43.992,0,0,0,81.149.607Z" transform="translate(1.651 35.333)" fill="#eceff5"/></g></g></svg></center>
                <center><h2>这里暂时没有相册～</h2></center>
            </article>
            
<?php endif; ?>


    
     

  </div>
     </div>
